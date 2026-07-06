@php
    $currentLocale = \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale();
    $isZh = in_array($currentLocale, ['zh', 'cn'], true);
    $isNl = $currentLocale === 'nl';
    $siteName = config('site.name', 'SalderingGids');
    $hubLabel = $isZh ? '荷兰净计量专题' : ($isNl ? 'Nederlandse salderingshub' : 'Dutch net metering hub');
    $factsLabel = $isZh ? '政策事实' : ($isNl ? '2027 feiten' : '2027 facts');
    $newsLabel = $isZh ? '更新' : ($isNl ? 'Updates' : 'Updates');
    $guidesLabel = $isZh ? '指南' : ($isNl ? 'Gidsen' : 'Guides');
    $analysisLabel = $isZh ? '观察' : ($isNl ? 'Analyse' : 'Analysis');
    $calculatorLabel = $isZh ? '计算器' : ($isNl ? 'Calculator' : 'Calculator');
    $searchPlaceholder = $isZh ? '搜索净计量、回馈电价、能源合同…' : ($isNl ? 'Zoek op salderen, terugleververgoeding, contracten...' : 'Search salderen, feed-in tariffs, contracts...');
    $articleSearchPlaceholder = $isZh ? '搜索净计量文章…' : ($isNl ? 'Zoek netmeteringsartikelen...' : 'Search net metering articles...');
    $estimateLabel = $isZh ? '开始测算' : ($isNl ? 'Bereken voordeel' : 'Estimate savings');
@endphp

<header class="sticky top-0 z-50 border-b border-[#d6dde8] bg-white/90 px-6 py-4 backdrop-blur lg:px-10">
    <div class="mx-auto flex max-w-[1280px] items-center justify-between gap-6">
        <div class="flex items-center gap-10">
            <a href="{{ route('index') }}" class="flex items-center gap-3 text-[#12315f]">
                <div class="flex size-10 items-center justify-center rounded-2xl bg-gradient-to-br from-[#12315f] via-[#2f73ff] to-[#9ad4ff] text-white shadow-lg shadow-blue-100">
                    <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" class="size-6">
                        <path d="M8 28.5 22.5 21v17L8 32.8v-4.3Z" fill="currentColor"/>
                        <path d="M25.5 38V21L40 15.4v16.8L25.5 38Z" fill="currentColor" opacity=".75"/>
                        <path d="M24 7 38.8 12.4 24 18 9.2 12.4 24 7Z" fill="currentColor"/>
                    </svg>
                </div>
                <div>
                    <p class="text-base font-black tracking-tight">{{ $siteName }}</p>
                    <p class="hidden text-[11px] uppercase tracking-[0.24em] text-[#6680a8] sm:block">
                        {{ $hubLabel }}
                    </p>
                </div>
            </a>

            <nav class="hidden items-center gap-7 md:flex">
                <a class="text-sm font-medium transition-colors hover:text-[#2f73ff] {{ request()->routeIs('index') ? 'text-[#2f73ff]' : 'text-[#12315f]' }}" href="{{ route('index') }}">
                    {{ __('menu.home') }}
                </a>
                <a class="text-sm font-medium transition-colors hover:text-[#2f73ff] {{ request()->routeIs('saldering.policy') ? 'text-[#2f73ff]' : 'text-[#12315f]' }}" href="{{ route('saldering.policy') }}">
                    {{ $factsLabel }}
                </a>
                <a class="text-sm font-medium transition-colors hover:text-[#2f73ff] {{ request()->routeIs('news*') ? 'text-[#2f73ff]' : 'text-[#12315f]' }}" href="{{ route('news') }}">
                    {{ $newsLabel }}
                </a>
                <a class="text-sm font-medium transition-colors hover:text-[#2f73ff] {{ request()->routeIs('guides*') ? 'text-[#2f73ff]' : 'text-[#12315f]' }}" href="{{ route('guides') }}">
                    {{ $guidesLabel }}
                </a>
                <a class="text-sm font-medium transition-colors hover:text-[#2f73ff] {{ request()->routeIs('cases*') ? 'text-[#2f73ff]' : 'text-[#12315f]' }}" href="{{ route('cases') }}">
                    {{ $analysisLabel }}
                </a>
                <a class="text-sm font-medium transition-colors hover:text-[#2f73ff] text-[#12315f]" href="{{ route('index') }}#calculator">
                    {{ $calculatorLabel }}
                </a>
            </nav>
        </div>

        <div class="flex items-center gap-3">
            <div class="hidden lg:flex items-stretch rounded-xl border border-[#d6dde8] bg-[#f5f8fc] px-3">
                <span class="material-symbols-outlined self-center text-[20px] text-[#6680a8]">search</span>
                <form action="{{ route('articles') }}" method="GET" class="flex-1">
                    <input
                        class="h-11 w-64 border-none bg-transparent text-sm text-[#12315f] placeholder:text-[#6680a8] focus:ring-0"
                        name="search"
                        placeholder="{{ $searchPlaceholder }}"
                    />
                </form>
            </div>

            <div class="relative group">
                <button class="flex h-11 items-center justify-center rounded-xl border border-[#d6dde8] bg-white px-3 text-sm font-medium text-[#12315f]">
                    <span class="material-symbols-outlined mr-1 text-[18px]">language</span>
                    {{ $isNl ? 'NL' : ($currentLocale === 'en' ? 'EN' : '中') }}
                </button>
                <div class="invisible absolute right-0 mt-2 w-32 rounded-xl border border-[#d6dde8] bg-white opacity-0 shadow-xl transition-all group-hover:visible group-hover:opacity-100">
                    <a href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL('nl', null, [], true) }}" class="block px-4 py-2 text-sm hover:bg-[#f5f8fc] {{ $isNl ? 'text-[#2f73ff]' : 'text-[#12315f]' }}">Nederlands</a>
                    <a href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL('en', null, [], true) }}" class="block px-4 py-2 text-sm hover:bg-[#f5f8fc] {{ $currentLocale === 'en' ? 'text-[#2f73ff]' : 'text-[#12315f]' }}">English</a>
                    <a href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL('zh', null, [], true) }}" class="block px-4 py-2 text-sm hover:bg-[#f5f8fc] {{ $isZh ? 'text-[#2f73ff]' : 'text-[#12315f]' }}">中文</a>
                </div>
            </div>

            <a href="{{ route('index') }}#calculator" class="hidden h-11 items-center justify-center rounded-xl bg-[#12315f] px-4 text-sm font-semibold text-white transition-colors hover:bg-[#0f294f] sm:flex">
                {{ $estimateLabel }}
            </a>

            <button class="flex h-11 w-11 items-center justify-center rounded-xl border border-[#d6dde8] bg-white text-[#12315f] md:hidden" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </div>
</header>

<div id="mobile-menu" class="hidden border-b border-[#d6dde8] bg-white px-6 py-4 md:hidden">
    <nav class="mx-auto flex max-w-[1280px] flex-col gap-3">
        <a class="text-sm font-medium text-[#12315f]" href="{{ route('index') }}">{{ __('menu.home') }}</a>
        <a class="text-sm font-medium text-[#12315f]" href="{{ route('saldering.policy') }}">{{ $factsLabel }}</a>
        <a class="text-sm font-medium text-[#12315f]" href="{{ route('news') }}">{{ $newsLabel }}</a>
        <a class="text-sm font-medium text-[#12315f]" href="{{ route('guides') }}">{{ $guidesLabel }}</a>
        <a class="text-sm font-medium text-[#12315f]" href="{{ route('cases') }}">{{ $analysisLabel }}</a>
        <a class="text-sm font-medium text-[#12315f]" href="{{ route('index') }}#calculator">{{ $calculatorLabel }}</a>
        <form action="{{ route('articles') }}" method="GET" class="mt-2 flex items-stretch rounded-xl border border-[#d6dde8] bg-[#f5f8fc] px-3">
            <span class="material-symbols-outlined self-center text-[20px] text-[#6680a8]">search</span>
            <input
                class="h-11 w-full border-none bg-transparent text-sm text-[#12315f] placeholder:text-[#6680a8] focus:ring-0"
                name="search"
                placeholder="{{ $articleSearchPlaceholder }}"
            />
        </form>
    </nav>
</div>
