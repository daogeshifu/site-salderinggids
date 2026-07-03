@php
    $locale = app()->getLocale();
    $title = $title ?? ($locale === 'zh' ? '测一下你的净计量收益' : ($locale === 'nl' ? 'Bereken je waarde onder de salderingsregeling' : 'Estimate your net metering value'));
    $description = $description ?? ($locale === 'zh'
        ? '用首页计算器快速比较当前规则与 2027 年后的年度收益差异。'
        : ($locale === 'nl'
            ? 'Gebruik de calculator op de homepage om je jaarlijkse waarde onder de huidige regels en na de wijziging in 2027 te vergelijken.'
            : 'Use the homepage calculator to compare annual value under today\'s rules and after the 2027 transition.'));
    $buttonLabel = $buttonLabel ?? ($locale === 'zh' ? '打开计算器' : ($locale === 'nl' ? 'Open calculator' : 'Open calculator'));
@endphp

<div class="overflow-hidden rounded-xl bg-gradient-to-br from-[#12315f] via-[#224f94] to-[#2f73ff] p-6 text-white shadow-lg shadow-blue-100">
    <div class="relative z-10">
        <span class="material-symbols-outlined text-[30px]">calculate</span>
        <h4 class="mt-3 text-lg font-bold">{{ $title }}</h4>
        <p class="mt-2 text-sm leading-6 text-blue-50/85">{{ $description }}</p>
        <a href="{{ route('index') }}#calculator" class="mt-5 inline-flex h-11 items-center justify-center rounded-xl bg-white px-4 text-sm font-semibold text-[#12315f] transition-colors hover:bg-blue-50">
            {{ $buttonLabel }}
        </a>
    </div>
</div>
