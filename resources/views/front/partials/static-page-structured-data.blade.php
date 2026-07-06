@php
    $siteUrl = rtrim(config('app.url', 'https://salderinggids.nl'), '/');
    $schemaPageType = $schemaPageType ?? 'WebPage';
    $schemaPageTitle = $schemaPageTitle ?? trim($__env->yieldContent('title'));
    $schemaPageDescription = $schemaPageDescription ?? trim($__env->yieldContent('description'));
    $schemaPageUrl = $schemaPageUrl ?? request()->url();
    $schemaLanguage = $schemaLanguage ?? (app()->getLocale() === 'zh' ? 'zh-CN' : (app()->getLocale() === 'nl' ? 'nl-NL' : 'en'));
    $schemaBreadcrumbs = $schemaBreadcrumbs ?? [];
    $schemaFaqItems = $schemaFaqItems ?? [];
    $schemaItemList = $schemaItemList ?? [];
@endphp

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "{{ $schemaPageType }}",
  "@id": "{{ $schemaPageUrl }}#page",
  "url": "{{ $schemaPageUrl }}",
  "name": "{{ $schemaPageTitle }}",
  "description": "{{ $schemaPageDescription }}",
  "inLanguage": "{{ $schemaLanguage }}",
  "isPartOf": {
    "@id": "{{ $siteUrl }}/#website"
  }
}
</script>

@if(!empty($schemaBreadcrumbs))
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "@id": "{{ $schemaPageUrl }}#breadcrumb",
  "itemListElement": [
    @foreach($schemaBreadcrumbs as $breadcrumb)
    {
      "@type": "ListItem",
      "position": {{ $loop->iteration }},
      "name": @json($breadcrumb['name'])@if(!empty($breadcrumb['item'])),
      "item": @json($breadcrumb['item'])@endif
    }@if(!$loop->last),@endif
    @endforeach
  ]
}
</script>
@endif

@if(!empty($schemaFaqItems))
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "@id": "{{ $schemaPageUrl }}#faq",
  "mainEntity": [
    @foreach($schemaFaqItems as $faq)
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

@if(!empty($schemaItemList))
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ItemList",
  "@id": "{{ $schemaPageUrl }}#itemlist",
  "itemListElement": [
    @foreach($schemaItemList as $item)
    {
      "@type": "ListItem",
      "position": {{ $loop->iteration }},
      "name": @json($item['name'])@if(!empty($item['url'])),
      "url": @json($item['url'])@endif
    }@if(!$loop->last),@endif
    @endforeach
  ]
}
</script>
@endif
