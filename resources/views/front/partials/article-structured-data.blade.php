@php
    $locale     = app()->getLocale();
    $isZh       = $locale === 'zh';
    $currentUrl = request()->url();

    $sectionMap = [
        'news'   => ['en' => 'News',   'zh' => '新闻', 'route' => 'news'],
        'guides' => ['en' => 'Guides', 'zh' => '指南', 'route' => 'guides'],
        'cases'  => ['en' => 'Cases',  'zh' => '案例', 'route' => 'cases'],
    ];
    $section         = $sectionMap[$sectionKey] ?? $sectionMap['news'];
    $categoryName    = $isZh ? $section['zh'] : $section['en'];
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
    $inLanguage   = $isZh ? 'zh-CN' : 'en';
    $homeName     = $isZh ? '首页' : 'Home';
    $logoUrl      = asset('logo.png');

    $orgDescription = $isZh
        ? 'SalderingGids 是一个围绕荷兰净计量、太阳能回馈电价和家庭能源合同变化的专题资源站，提供规则说明、政府来源与实用计算工具。'
        : 'SalderingGids is a focused resource about Dutch net metering, solar feed-in compensation, and household energy contract changes, with explainers, government sources, and practical calculators.';
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
      "@type": "BlogPosting",
      "@id": "{{ $currentUrl }}#article",
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ $currentUrl }}"
      },
      "headline": "{{ $headline }}",
      "description": "{{ $description }}",
      @if($coverAbsUrl)
      "image": {
        "@type": "ImageObject",
        "url": "{{ $coverAbsUrl }}"
      },
      @endif
      "datePublished": "{{ $publishedAt }}",
      "dateModified": "{{ $modifiedAt }}",
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
