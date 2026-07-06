@php
    $locale = app()->getLocale();
    $isZh = $locale === 'zh';
    $isNl = $locale === 'nl';
    $sectionKey = $sectionKey ?? 'article';
    $siteUrl = rtrim(config('app.url', 'https://salderinggids.nl'), '/');
    $collectionTitle = $collectionTitle ?? trim($__env->yieldContent('title'));
    $collectionDescription = $collectionDescription ?? trim($__env->yieldContent('description'));
    $collectionUrl = $collectionUrl ?? request()->url();

    $buildUrl = function ($item) use ($sectionKey) {
        return match ($sectionKey) {
            'news' => route('news.detail.show', $item->link),
            'guides' => route('guides.detail.show', $item->link),
            'cases' => route('cases.detail.show', $item->link),
            default => route('article.detail.show', [$item->category->name ?? 'article', $item->link]),
        };
    };

    $schemaItems = collect($items ?? [])->filter(function ($item) {
        return !empty($item->title) && !empty($item->link);
    })->take(12)->values();

    $itemType = $isZh ? '集合页' : ($isNl ? 'Collectiepagina' : 'Collection page');
@endphp

@if($schemaItems->isNotEmpty())
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "CollectionPage",
      "@id": "{{ $collectionUrl }}#collection",
      "url": "{{ $collectionUrl }}",
      "name": "{{ $collectionTitle }}",
      "description": "{{ $collectionDescription }}",
      "inLanguage": "{{ $isZh ? 'zh-CN' : ($isNl ? 'nl-NL' : 'en') }}",
      "isPartOf": {
        "@id": "{{ $siteUrl }}/#website"
      },
      "about": "{{ $itemType }}"
    },
    {
      "@type": "ItemList",
      "@id": "{{ $collectionUrl }}#itemlist",
      "itemListOrder": "https://schema.org/ItemListOrderDescending",
      "numberOfItems": "{{ $schemaItems->count() }}",
      "itemListElement": [
        @foreach($schemaItems as $item)
        {
          "@type": "ListItem",
          "position": {{ $loop->iteration }},
          "url": "{{ $buildUrl($item) }}",
          "name": @json($item->seo_title ?? $item->title)
        }@if(!$loop->last),@endif
        @endforeach
      ]
    }
  ]
}
</script>
@endif
