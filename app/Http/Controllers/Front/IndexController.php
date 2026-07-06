<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article\Article;
use App\Models\Article\ArticleCategory;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * 首页
     */
    public function index(Request $request)
    {
        $locale = app()->getLocale();
        $isZh = $locale === 'zh';
        $isNl = $locale === 'nl';

        $baseQuery = Article::with(['category', 'user'])
            ->forFrontendLocale($locale);

        $newsCategory = ArticleCategory::where('name', 'news')->first();
        $guidesCategory = ArticleCategory::where('name', 'guides')->first();
        $casesCategory = ArticleCategory::where('name', 'cases')->first();

        $newsArticles = $newsCategory
            ? (clone $baseQuery)->where('category_id', $newsCategory->id)->orderByDesc('id')->take(3)->get()
            : collect();
        $guidesArticles = $guidesCategory
            ? (clone $baseQuery)->where('category_id', $guidesCategory->id)->orderByDesc('id')->take(3)->get()
            : collect();
        $casesArticles = $casesCategory
            ? (clone $baseQuery)->where('category_id', $casesCategory->id)->orderByDesc('id')->take(3)->get()
            : collect();

        $officialLinks = collect(config('site.official_links', []))->map(function ($link) use ($locale) {
            return [
                'title' => $link['title'][$locale] ?? $link['title']['en'],
                'description' => $link['description'][$locale] ?? $link['description']['en'],
                'source' => $link['source'] ?? null,
                'updated_at' => $link['updated_at'] ?? null,
                'url' => $link['url'],
            ];
        });

        $pageCopy = $isZh ? [
            'eyebrow' => '荷兰净计量专题',
            'hero_title' => 'SalderingGids：帮你看懂荷兰净计量、2027 变化与回本逻辑',
            'hero_description' => '面向荷兰住宅用户的一站式净计量专题页，整合净计量规则、政府来源、回馈电价变化和一个可直接使用的收益计算器。',
            'hero_primary' => '立即计算',
            'hero_secondary' => '先看 2027 政策事实',
            'highlights' => [
                '截至 2026 年 12 月 31 日，家庭太阳能用户仍可按年度进行净计量。',
                '从 2027 年 1 月 1 日起，净计量停止，超额回馈改为补偿机制。',
                '到 2030 年 1 月 1 日前，能源公司需至少支付裸电价 50% 的回馈补偿。',
            ],
            'facts_title' => '当前规则速览',
            'facts_description' => '以下信息基于荷兰政府与 ACM 消费者官方页面整理，适合作为首页专题的核心解释模块。',
            'calculator_title' => '净计量收益计算器',
            'calculator_description' => '输入你的年发电量、家庭年用电量、购电价和回馈补偿价，快速对比 2026 年前后两种规则下的年度收益。',
            'resources_title' => '官方与监管链接',
            'resources_description' => '首页保留权威出处，既利于 SEO，也能增强用户信任。',
            'articles_title' => '相关文章入口',
            'articles_description' => '把指南、新闻和案例都放到首页底部，用户可以从政策理解直接进入深度文章。',
            'section_news' => '最新新闻',
            'section_guides' => '实用指南',
            'section_cases' => '市场观察',
            'browse_all' => '浏览全部文章',
        ] : ($isNl ? [
            'eyebrow' => 'Nederlandse salderingshub',
            'hero_title' => 'SalderingGids helpt je de Nederlandse salderingsregeling, de wijziging in 2027 en je terugverdientijd te begrijpen',
            'hero_description' => 'Een gerichte landingspagina voor huishoudens in Nederland met duidelijke uitleg van de regels, officiële bronnen, praktische artikelen en een calculator voor het huidige en het post-2027 scenario.',
            'hero_primary' => 'Open de calculator',
            'hero_secondary' => 'Lees wat er echt verandert',
            'highlights' => [
                'Huishoudens met zonnepanelen kunnen hun jaarlijkse teruglevering nog verrekenen tot en met 31 december 2026.',
                'Vanaf 1 januari 2027 stopt de Nederlandse salderingsregeling en wordt teruglevering vergoed in plaats van volledig verrekend.',
                'Tot 1 januari 2030 moeten leveranciers voor extra teruglevering minimaal 50% van het kale leveringstarief betalen.',
            ],
            'facts_title' => 'De regels in het kort',
            'facts_description' => 'Deze samenvatting is gebaseerd op officiële informatie van de Rijksoverheid en ACM ConsuWijzer en past als kernuitleg op de homepage.',
            'calculator_title' => 'Salderingscalculator',
            'calculator_description' => 'Vul je jaarlijkse productie, verbruik, stroomprijs en terugleververgoeding in om je jaarlijkse waarde voor en na de wijziging in 2027 te vergelijken.',
            'resources_title' => 'Officiële en toezichthoudende links',
            'resources_description' => 'Officiële bronnen op de homepage versterken vertrouwen, duidelijkheid en topical authority.',
            'articles_title' => 'Gerelateerde artikelen',
            'articles_description' => 'Toon gidsen, nieuws en marktanalyses onderaan de homepage zodat bezoekers vanuit de uitleg direct kunnen door naar verdieping.',
            'section_news' => 'Laatste nieuws',
            'section_guides' => 'Praktische gidsen',
            'section_cases' => 'Marktanalyse',
            'browse_all' => 'Bekijk alle artikelen',
        ] : [
            'eyebrow' => 'Dutch net metering hub',
            'hero_title' => 'SalderingGids explains Dutch net metering, the 2027 change, and what it means for your solar payback',
            'hero_description' => 'A focused landing page for homeowners in the Netherlands with clear rule summaries, official sources, practical articles, and a calculator for today\'s and post-2027 scenarios.',
            'hero_primary' => 'Open the calculator',
            'hero_secondary' => 'Read the 2027 facts first',
            'highlights' => [
                'Residential solar owners can still offset annual feed-in against consumption until December 31, 2026.',
                'From January 1, 2027, the Dutch salderingsregeling ends and exported electricity is compensated instead of fully netted out.',
                'Until January 1, 2030, suppliers must pay at least 50% of the bare supply tariff for excess feed-in.',
            ],
            'facts_title' => 'The rules at a glance',
            'facts_description' => 'These summary blocks are based on official Dutch government and ACM consumer guidance and are designed for a clean homepage explainer.',
            'calculator_title' => 'Net metering calculator',
            'calculator_description' => 'Enter annual production, household usage, import price, and feed-in compensation to compare your yearly value before and after the 2027 rule change.',
            'resources_title' => 'Official and regulatory links',
            'resources_description' => 'Keeping government sources on the homepage improves trust, clarity, and topic authority.',
            'articles_title' => 'Related articles',
            'articles_description' => 'Surface guides, news, and market analysis at the bottom of the homepage so readers can move from explanation to depth.',
            'section_news' => 'Latest news',
            'section_guides' => 'Practical guides',
            'section_cases' => 'Market analysis',
            'browse_all' => 'Browse all articles',
        ]);

        $factCards = $isZh ? [
            [
                'title' => '净计量结束日期',
                'value' => '2027-01-01',
                'description' => '荷兰政府已确认净计量制度将在 2027 年 1 月 1 日终止。',
            ],
            [
                'title' => '最低回馈补偿',
                'value' => '裸电价的 50%',
                'description' => '到 2030 年 1 月 1 日前，超额回馈电量至少按裸电价 50% 获得补偿。',
            ],
            [
                'title' => '智能电表要求',
                'value' => '2026 起更关键',
                'description' => '从 2026 年开始，能源公司在结算回馈电量时会更依赖智能电表与分时读数。',
            ],
        ] : ($isNl ? [
            [
                'title' => 'Einddatum salderen',
                'value' => '2027-01-01',
                'description' => 'De Nederlandse overheid heeft bevestigd dat de salderingsregeling eindigt op 1 januari 2027.',
            ],
            [
                'title' => 'Minimale terugleververgoeding',
                'value' => '50% van het kale tarief',
                'description' => 'Tot 1 januari 2030 moet overtollige teruglevering minimaal tegen 50% van het kale leveringstarief worden vergoed.',
            ],
            [
                'title' => 'Slimme meter',
                'value' => 'Belangrijker vanaf 2026',
                'description' => 'Vanaf 2026 worden registratie, contractvergelijking en afrekening nog sterker afhankelijk van de slimme meter en tijdsregistratie.',
            ],
        ] : [
            [
                'title' => 'End date for salderen',
                'value' => '2027-01-01',
                'description' => 'The Dutch government has confirmed that the salderingsregeling ends on January 1, 2027.',
            ],
            [
                'title' => 'Minimum feed-in compensation',
                'value' => '50% of the bare tariff',
                'description' => 'Until January 1, 2030, excess exported electricity must be compensated at no less than 50% of the bare supply tariff.',
            ],
            [
                'title' => 'Smart meter relevance',
                'value' => 'Higher from 2026',
                'description' => 'From 2026 onward, supplier settlement and contract comparison increasingly depend on smart meter registration and time-based readings.',
            ],
        ]);

        $calculatorDefaults = [
            'annual_production' => 4200,
            'annual_usage' => 3500,
            'self_consumption' => 30,
            'buy_rate' => 0.28,
            'feed_in_rate' => 0.11,
        ];

        return view('front.index.index', [
            'navbar' => 'index',
            'newsArticles' => $newsArticles,
            'guidesArticles' => $guidesArticles,
            'casesArticles' => $casesArticles,
            'officialLinks' => $officialLinks,
            'pageCopy' => $pageCopy,
            'factCards' => $factCards,
            'calculatorDefaults' => $calculatorDefaults,
        ]);
    }
}
