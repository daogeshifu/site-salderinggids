@php
    $locale = app()->getLocale();
    $widgetTitle = $widgetTitle ?? ($locale === 'zh' ? '官方链接' : ($locale === 'nl' ? 'Officiële links' : 'Official links'));
    $widgetDescription = $widgetDescription ?? ($locale === 'zh'
        ? '保留监管与政府来源，帮助用户快速核验规则。'
        : ($locale === 'nl'
            ? 'Houd de bronnen van overheid en toezichthouder dichtbij zodat lezers de regels snel kunnen controleren.'
            : 'Keep the government and regulator sources close so readers can verify the rules quickly.'));
    $widgetLinks = collect(config('site.official_links', []))->take($limit ?? 4)->map(function ($link) use ($locale) {
        return [
            'title' => $link['title'][$locale] ?? $link['title']['en'],
            'description' => $link['description'][$locale] ?? $link['description']['en'],
            'url' => $link['url'],
        ];
    });
@endphp

<div class="rounded-xl border border-[#dbe4f0] bg-white p-6 shadow-sm">
    <div class="flex items-start gap-3">
        <div class="mt-1 flex size-10 items-center justify-center rounded-2xl bg-[#edf4ff] text-[#2f73ff]">
            <span class="material-symbols-outlined text-[20px]">policy</span>
        </div>
        <div>
            <h4 class="text-lg font-bold text-[#12315f]">{{ $widgetTitle }}</h4>
            <p class="mt-1 text-sm leading-6 text-[#5f7698]">{{ $widgetDescription }}</p>
        </div>
    </div>

    <div class="mt-5 space-y-4">
        @foreach($widgetLinks as $link)
            <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer" class="block rounded-2xl border border-[#e8eef6] px-4 py-4 transition-all hover:border-[#c7dafd] hover:bg-[#f8fbff]">
                <p class="text-sm font-semibold text-[#12315f]">{{ $link['title'] }}</p>
                <p class="mt-1 text-xs leading-5 text-[#5f7698]">{{ $link['description'] }}</p>
            </a>
        @endforeach
    </div>
</div>
