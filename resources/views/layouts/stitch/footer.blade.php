@php
    $locale = app()->getLocale();
    $isZh = $locale === 'zh';
    $isNl = $locale === 'nl';
    $siteName = config('site.name', 'SalderingGids');
    $officialLinks = collect(config('site.official_links', []))->take(3)->map(function ($link) use ($locale) {
        return [
            'title' => $link['title'][$locale] ?? $link['title']['en'],
            'url' => $link['url'],
        ];
    });
@endphp

<footer class="border-t border-[#d6dde8] bg-[#0f1d34] px-6 py-14 text-white">
    <div class="mx-auto grid max-w-[1280px] gap-12 md:grid-cols-12">
        <div class="md:col-span-4">
            <h2 class="text-2xl font-black tracking-tight">{{ $siteName }}</h2>
            <p class="mt-4 max-w-md text-sm leading-7 text-blue-100/80">
                {{ $isZh
                    ? '围绕荷兰净计量、太阳能回馈电价和家庭能源账单变化建立的专题内容站。首页聚合规则说明、官方来源、计算器和相关文章入口。'
                    : ($isNl
                        ? 'Een gespecialiseerde themasite over de Nederlandse salderingsregeling, terugleververgoedingen en veranderingen in energiecontracten voor huishoudens, met uitleg, officiële bronnen, een calculator en praktische artikelen.'
                        : 'A focused content hub for Dutch net metering, solar feed-in compensation, and household energy contract changes, with explainers, official sources, a calculator, and practical articles.') }}
            </p>
            <div class="mt-6 flex flex-wrap gap-3 text-xs text-blue-100/70">
                <span class="rounded-full border border-white/10 px-3 py-1.5">salderinggids.nl</span>
                <span class="rounded-full border border-white/10 px-3 py-1.5">{{ $isZh ? '荷兰住宅用户' : ($isNl ? 'Voor huishoudens in NL' : 'For NL homeowners') }}</span>
                <span class="rounded-full border border-white/10 px-3 py-1.5">{{ $isZh ? '2027 政策变化' : ($isNl ? 'Wijziging in 2027' : '2027 transition') }}</span>
            </div>
        </div>

        <div class="md:col-span-3">
            <h3 class="text-sm font-bold uppercase tracking-[0.2em] text-blue-100/60">{{ $isZh ? '内容导航' : ($isNl ? 'Navigatie' : 'Navigation') }}</h3>
            <ul class="mt-4 space-y-3 text-sm text-blue-100/85">
                <li><a class="transition-colors hover:text-white" href="{{ route('index') }}">{{ __('menu.home') }}</a></li>
                <li><a class="transition-colors hover:text-white" href="{{ route('news') }}">News</a></li>
                <li><a class="transition-colors hover:text-white" href="{{ route('guides') }}">Guides</a></li>
                <li><a class="transition-colors hover:text-white" href="{{ route('cases') }}">{{ $isZh ? '观察' : ($isNl ? 'Analyse' : 'Analysis') }}</a></li>
                <li><a class="transition-colors hover:text-white" href="{{ route('index') }}#calculator">{{ $isZh ? '净计量计算器' : ($isNl ? 'Salderingscalculator' : 'Net metering calculator') }}</a></li>
            </ul>
        </div>

        <div class="md:col-span-3">
            <h3 class="text-sm font-bold uppercase tracking-[0.2em] text-blue-100/60">{{ $isZh ? '官方链接' : ($isNl ? 'Officiële links' : 'Official links') }}</h3>
            <ul class="mt-4 space-y-3 text-sm text-blue-100/85">
                @foreach($officialLinks as $link)
                    <li>
                        <a class="transition-colors hover:text-white" href="{{ $link['url'] }}" rel="noopener noreferrer" target="_blank">
                            {{ $link['title'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="md:col-span-2">
            <h3 class="text-sm font-bold uppercase tracking-[0.2em] text-blue-100/60">{{ $isZh ? '重要时间点' : ($isNl ? 'Belangrijke datums' : 'Key dates') }}</h3>
            <ul class="mt-4 space-y-3 text-sm text-blue-100/85">
                <li>2026-12-31: {{ $isZh ? '当前净计量结束前的最后完整年度' : ($isNl ? 'Laatste volledige jaar onder de huidige salderingsregels' : 'Last full year under current salderen rules') }}</li>
                <li>2027-01-01: {{ $isZh ? '净计量结束' : ($isNl ? 'Einde salderen' : 'Salderen ends') }}</li>
                <li>2030-01-01: {{ $isZh ? '最低 50% 回馈补偿保障截止' : ($isNl ? 'Uiterste datum voor minimale terugleverbescherming van 50%' : 'Minimum 50% feed-in protection deadline') }}</li>
            </ul>
        </div>
    </div>

    <div class="mx-auto mt-12 flex max-w-[1280px] flex-col gap-4 border-t border-white/10 pt-8 text-xs text-blue-100/60 md:flex-row md:items-center md:justify-between">
        <p>&copy; {{ date('Y') }} {{ $siteName }}. {{ $isZh ? '专题内容持续更新。' : ($isNl ? 'De themapagina wordt doorlopend bijgewerkt.' : 'Topic coverage updated continuously.') }}</p>
        <div class="flex gap-5">
            <a class="transition-colors hover:text-white" href="{{ route('policy') }}">{{ __('privacy-policy.privacy_policy_title') }}</a>
            <a class="transition-colors hover:text-white" href="{{ route('terms') }}">{{ __('terms-of-service.terms_title') }}</a>
        </div>
    </div>
</footer>
