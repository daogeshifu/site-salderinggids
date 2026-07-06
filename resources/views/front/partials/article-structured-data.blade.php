@php
    $locale     = app()->getLocale();
    $isZh       = $locale === 'zh';
    $isNl       = $locale === 'nl';
    $currentUrl = request()->url();

    $sectionMap = [
        'article' => ['en' => 'Articles', 'nl' => 'Artikelen', 'zh' => '文章', 'route' => 'articles'],
        'news'   => ['en' => 'News',   'nl' => 'Updates', 'zh' => '新闻', 'route' => 'news'],
        'guides' => ['en' => 'Guides', 'nl' => 'Gidsen', 'zh' => '指南', 'route' => 'guides'],
        'cases'  => ['en' => 'Cases',  'nl' => 'Analyse', 'zh' => '案例', 'route' => 'cases'],
    ];
    $section         = $sectionMap[$sectionKey ?? 'article'] ?? $sectionMap['article'];
    $categoryName    = $isZh ? $section['zh'] : ($isNl ? $section['nl'] : $section['en']);
    $categoryUrl     = route($section['route']);
    $siteName        = config('site.name', 'SalderingGids');
    $siteUrl         = rtrim(config('app.url', 'https://salderinggids.nl'), '/');

    $authorName   = $article->author ?? ($isZh ? '管理员' : 'Admin');
    $authorBio    = $article->author_bio ?? '';
    $headline     = $article->seo_title ?? $article->title;
    $description  = $article->seo_description ?? $article->summary ?? $article->title;
    $coverAbsUrl  = $article->cover ? url(\Illuminate\Support\Facades\Storage::url($article->cover)) : '';
    $publishedAt  = optional($article->created_at)->toAtomString();
    $modifiedAt   = optional($article->updated_at)->toAtomString();
    $inLanguage   = $isZh ? 'zh-CN' : ($isNl ? 'nl-NL' : 'en');
    $homeName     = $isZh ? '首页' : 'Home';
    $logoUrl      = asset('og/salderinggids-share.svg');
    $wordCount    = str_word_count(strip_tags($article->content ?? ''));
    $articleSection = $article->category->name ?? $categoryName;

    $orgDescription = $isZh
        ? 'SalderingGids 是一个围绕荷兰净计量、太阳能回馈电价和家庭能源合同变化的专题资源站，提供规则说明、政府来源与实用计算工具。'
        : ($isNl
            ? 'SalderingGids is een thematische bron over de Nederlandse salderingsregeling, terugleververgoeding en contractverandering voor huishoudens, met uitleg, overheidsbronnen en praktische rekentools.'
            : 'SalderingGids is a focused resource about Dutch net metering, solar feed-in compensation, and household energy contract changes, with explainers, government sources, and practical calculators.');

    $faqItems = [];
    if (!empty($article->content)) {
        $previousUseErrors = libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $html = '<?xml encoding="utf-8" ?><div>' . $article->content . '</div>';

        if ($dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD)) {
            $xpath = new DOMXPath($dom);
            foreach ($xpath->query('//h2|//h3') as $headingNode) {
                $question = trim(preg_replace('/\s+/u', ' ', $headingNode->textContent ?? ''));

                if ($question === '' || !str_ends_with($question, '?')) {
                    continue;
                }

                $answerParts = [];
                for ($node = $headingNode->nextSibling; $node; $node = $node->nextSibling) {
                    if ($node->nodeType === XML_ELEMENT_NODE && in_array(strtolower($node->nodeName), ['h2', 'h3'], true)) {
                        break;
                    }

                    $text = trim(preg_replace('/\s+/u', ' ', strip_tags($dom->saveHTML($node))));
                    if ($text !== '') {
                        $answerParts[] = $text;
                    }

                    if (mb_strlen(implode(' ', $answerParts)) > 360) {
                        break;
                    }
                }

                if (!empty($answerParts)) {
                    $faqItems[] = [
                        'question' => $question,
                        'answer' => trim(implode(' ', $answerParts)),
                    ];
                }

                if (count($faqItems) >= 8) {
                    break;
                }
            }
        }

        libxml_clear_errors();
        libxml_use_internal_errors($previousUseErrors);
    }
@endphp

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Organization",
      "@id": "{{ $siteUrl }}/#organization",
      "name": "{{ $siteName }}",
      "url": "{{ $siteUrl }}/",
      "logo": {
        "@type": "ImageObject",
        "url": "{{ $logoUrl }}"
      },
      "description": "{{ $orgDescription }}"
    },
    {
      "@type": "Person",
      "@id": "{{ $currentUrl }}#author",
      "name": "{{ $authorName }}",
      "description": "{{ $authorBio }}"
    },
    {
      "@type": "Article",
      "@id": "{{ $currentUrl }}#article",
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ $currentUrl }}"
      },
      "headline": "{{ $headline }}",
      "description": "{{ $description }}",
      "articleSection": "{{ $articleSection }}",
      @if($coverAbsUrl)
      "image": {
        "@type": "ImageObject",
        "url": "{{ $coverAbsUrl }}"
      },
      @endif
      "datePublished": "{{ $publishedAt }}",
      "dateModified": "{{ $modifiedAt }}",
      "wordCount": "{{ $wordCount }}",
      "author": {
        "@id": "{{ $currentUrl }}#author"
      },
      "publisher": {
        "@id": "{{ $siteUrl }}/#organization"
      },
      "inLanguage": "{{ $inLanguage }}"
    }
  ]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "BreadcrumbList",
      "@id": "{{ $currentUrl }}#breadcrumb",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "{{ $homeName }}",
          "item": "{{ $siteUrl }}/"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "{{ $categoryName }}",
          "item": "{{ $categoryUrl }}"
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": "{{ $headline }}"
        }
      ]
    }
  ]
}
</script>

@if(!empty($faqItems))
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "@id": "{{ $currentUrl }}#faq",
  "mainEntity": [
    @foreach($faqItems as $faq)
    {
      "@type": "Question",
      "name": @json($faq['question']),
      "acceptedAnswer": {
        "@type": "Answer",
        "text": @json($faq['answer'])
      }
    }@if(!$loop->last),@endif
    @endforeach
  ]
}
</script>
@endif
