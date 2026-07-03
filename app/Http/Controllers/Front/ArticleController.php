<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Article\Article;
use App\Models\Article\ArticleCategory;

class ArticleController extends Controller
{
    
    /**
     * 显示博客文章列表
     *
     * @param Request $request
     * @param int|null $page
     * @return \Illuminate\View\View
     */
    public function index_page(Request $request, $page = null)
    {
        return $this->index($request, null, $page);
    }

    /**
     * 显示分类下的文章列表
     * 
     * @param Request $request
     * @param string|null $category_name
     * @param int|null $page
     * @return \Illuminate\View\View
     */
    public function index_category_page(Request $request, $category_name = null, $page = null)
    {
        return $this->index($request, $category_name, $page);
    }

    /**
     * 显示博客文章列表主逻辑
     * 
     * @param Request $request
     * @param string|null $category_name
     * @param int|null $page
     * @return \Illuminate\View\View
     */
    public function index(Request $request, $category_name = null, $page = null)
    {
        $search = $request->input('search');
        $locale = app()->getLocale();

        if ($page) {
            $request->merge(['page' => $page]);
        }

        $currentPage = $request->get('page', 1);

        // 分类用于侧边栏；即使为空，也允许总文章页渲染空状态
        $categories = ArticleCategory::withCount('articles')->get();

        // 基础查询
        $query = Article::with(['category', 'user'])
            ->forFrontendLocale($locale);

        // 分类筛选
        if(!$category_name || 'all' == $category_name)
        {
            $currentCategory = new ArticleCategory([
                'id' => 0,
                'name' => $locale === 'zh' ? '全部文章' : ($locale === 'nl' ? 'Alle artikelen' : 'All Articles'),
                'seo_description' => $locale === 'zh'
                    ? '浏览荷兰净计量、太阳能回馈电价和家庭能源账单相关的全部文章。'
                    : ($locale === 'nl'
                        ? 'Bekijk alle artikelen over de Nederlandse salderingsregeling, terugleververgoedingen en energierekeningen voor huishoudens.'
                        : 'Browse all articles about Dutch net metering, solar feed-in tariffs, and residential energy bills.'),
            ]);
        }
        else
        {
            $currentCategory = $categories->firstWhere('name', $category_name);
            if($currentCategory) {
                $query->where('category_id', $currentCategory->id);
            } else {
                abort(404);
            }
        }

        // 搜索处理
        if($search) {
            $query->searchFrontend($search, $locale);
        }

        $articles = $query->orderBy('id', 'desc')->paginate(9)->appends([
            'search' => $search
        ]);

        $articles->setPath($this->getPaginationPath($category_name));

        $topArticle = null;
        if(!$search && $currentPage == 1) {
            $topArticleQuery = Article::with(['category', 'user'])
                ->forFrontendLocale($locale);

            if ($currentCategory->id) {
                $topArticleQuery->where('category_id', $currentCategory->id);
            }

            $topArticle = $topArticleQuery
                ->orderByDesc('view_count')
                ->orderByDesc('id')
                ->first();
        }

        $popularArticles = Article::with(['category', 'user'])
            ->forFrontendLocale($locale)
            ->orderByDesc('view_count')
            ->orderByDesc('id')
            ->take(5)
            ->get();

        return view('front.article.index', compact(
            'articles',
            'categories',
            'currentCategory',
            'topArticle',
            'search',
            'currentPage',
            'popularArticles'
        ));
    }

    /**
     * 获取分页路径
     * 
     * @param string|null $category_name
     * @return string
     */
    private function getPaginationPath($category_name = null)
    {
        if ($category_name && 'all' != $category_name) {
            return route('article.category2', ['category_name' => $category_name]);
        }

        return route('articles');
    }

    /**
     * 显示文章详细页面
     * 
     * @param Request $request
     * @param string $category_name
     * @param string $link
     */
    public function detail(Request $request, $category_name, $link)
    {
        $article = Article::with(['category', 'user', 'tags'])->where('link', $link)->first();

        if (!$article) {
            abort(404);
        }

        $sidebarArticles = $article->category->articles()->with(['category', 'user'])->where('id', '!=', $article->id)->take(5)->get();
        $plainText = strip_tags($article->content);

        if (mb_strlen($plainText) <= 100) {
            $abstract = $plainText;
        } else {
            $substr = mb_substr($plainText, 0, 100);
            if (preg_match('/^(.+?\b)[^\pL]*$/u', $substr, $matches)) {
                $abstract = $matches[1];
            } else {
                $abstract = $substr;
            }
        }

        $navbar = 'blog';

        // 目录生成
        preg_match_all('/<h2[^>]*>(.*?)<\/h2>/', $article->content, $h2Matches);
        $headings = [];
        $counter = 0;

        $contentWithAnchors = preg_replace_callback(
            '/<h2[^>]*>(.*?)<\/h2>/',
            function ($match) use (&$counter, &$headings) {
                $id = 'heading-' . (++$counter);
                $title = trim(strip_tags($match[1]));
                $headings[] = [
                    'id' => $id,
                    'title' => $title,
                ];
                return '<h2 class="h5" id="' . $id . '">' . $match[1] . '</h2>';
            },
            $article->content
        );

        $contentWithAnchors = preg_replace(
            '/<h3[^>]*>(.*?)<\/h3>/',
            '<h3 class="h6">$1</h3>',
            $contentWithAnchors
        );

        return view('front.article.detail', compact(
            'category_name',
            'article',
            'sidebarArticles',
            'abstract',
            'navbar',
            'headings',
            'contentWithAnchors'
        ));
    }

    /**
     * 记录一次浏览
     * @param Request $request
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(Request $request, Article $article)
    {
        $article->recordViewByIp($request->ip());
        return response()->json(['ok' => true]);
    }

    /**
     * 记录一次有效阅读
     * @param Request $request
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function read(Request $request, Article $article)
    {
        $article->recordReadByIp($request->ip());
        return response()->json(['ok' => true]);
    }

}
