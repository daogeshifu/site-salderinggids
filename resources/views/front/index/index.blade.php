@extends('layouts.stitch.master')

@php
    $locale = app()->getLocale();
    $isZh = $locale === 'zh';
    $isNl = $locale === 'nl';
    $pageTitle = $isZh
        ? 'SalderingGids 荷兰净计量专题页 | 规则、政府链接与计算器'
        : ($isNl
            ? 'SalderingGids | Salderingsregeling 2027, thuisbatterij en calculator'
            : 'SalderingGids | Dutch Net Metering, 2027, Home Battery, and Calculator');
    $pageDescription = $isZh
        ? '围绕荷兰净计量 salderingsregeling 的专题首页，包含 2027 政策变化说明、家用电池决策、官方政府链接、回馈补偿信息、收益计算器与相关文章入口。'
        : ($isNl
            ? 'Een gerichte homepage over de Nederlandse salderingsregeling met uitleg over 2027, thuisbatterij, terugleververgoeding, officiële overheidslinks en een calculator.'
            : 'A focused homepage about the Dutch salderingsregeling with the 2027 transition, home battery choices, official government links, feed-in compensation guidance, and a calculator.');
    $pageKeywords = $isZh
        ? 'salderingsregeling, 荷兰净计量, 2027, thuisbatterij, zonnepanelen, terugleververgoeding, 荷兰能源合同'
        : ($isNl
            ? 'salderingsregeling, 2027, thuisbatterij, zonnepanelen, terugleververgoeding, energiecontract, Nederlandse zonne-energie'
            : 'salderingsregeling, 2027, home battery, zonnepanelen, terugleververgoeding, solar Netherlands, Dutch energy contract');
    $homeText = $isZh ? [
        'hero_summary_title' => '荷兰净计量首页解释模块',
        'core_points_title' => '你需要先理解的 4 个核心点',
        'core_points_intro' => '专题首页既要讲清规则，也要让用户直接进入政策变化、合同比较和收益计算。',
        'calculator_heading' => '比较当前规则与 2027 年后的年度价值',
        'production_label' => '年发电量 (kWh)',
        'usage_label' => '家庭年用电量 (kWh)',
        'self_consumption_label' => '即时自用比例 (%)',
        'buy_rate_label' => '购电价 (EUR/kWh)',
        'feed_in_rate_label' => '2027 后回馈补偿价 (EUR/kWh)',
        'logic_label' => '计算逻辑：',
        'logic_text' => '当前规则下，假设回馈电量可在年度内与剩余用电量优先抵扣；2027 年后，自发自用仍按购电价节省，外送电量按输入的回馈补偿价计算。该工具用于首页专题估算，不替代具体能源合同条款。',
        'result_label' => '结果预览',
        'result_heading' => '两种规则下的年度价值',
        'current_regime_label' => '当前规则（到 2026-12-31）',
        'future_regime_label' => '2027 之后',
        'difference_label' => '年度差额',
        'difference_hint' => '如果 2027 后的年度价值更低，通常说明提高自发自用比例和比较能源合同会更重要。',
        'resources_heading' => '首页直接挂上权威来源',
        'articles_heading' => '底部放相关文章入口',
        'more_label' => '更多',
        'empty_section' => '当前分类暂时还没有文章。',
    ] : ($isNl ? [
        'hero_summary_title' => 'Uitlegblok voor de homepage over salderen',
        'core_points_title' => 'De 4 punten die iedere Nederlandse zonnepaneelbezitter eerst moet begrijpen',
        'core_points_intro' => 'Een thematische homepage moet de regels helder uitleggen en bezoekers direct naar beleidswijzigingen, contractvergelijking en rendementschatting leiden.',
        'calculator_heading' => 'Vergelijk je jaarlijkse waarde voor en na de wijziging in 2027',
        'production_label' => 'Jaarlijkse zonneproductie (kWh)',
        'usage_label' => 'Jaarlijks huishoudelijk verbruik (kWh)',
        'self_consumption_label' => 'Direct eigen verbruik (%)',
        'buy_rate_label' => 'Afnameprijs stroom (EUR/kWh)',
        'feed_in_rate_label' => 'Terugleververgoeding na 2027 (EUR/kWh)',
        'logic_label' => 'Rekenlogica:',
        'logic_text' => 'Onder de huidige regels wordt aangenomen dat teruglevering eerst het resterende jaarverbruik compenseert. Na 2027 bespaart direct eigen verbruik nog steeds de afnameprijs, terwijl teruglevering wordt gewaardeerd tegen de ingevoerde vergoeding. Dit is een schatting voor de homepage en vervangt geen contractvoorwaarden van leveranciers.',
        'result_label' => 'Resultaat',
        'result_heading' => 'Je jaarlijkse waarde onder beide regelsets',
        'current_regime_label' => 'Huidige regeling (tot 2026-12-31)',
        'future_regime_label' => 'Na 2027',
        'difference_label' => 'Verschil per jaar',
        'difference_hint' => 'Als de jaarlijkse waarde na 2027 lager uitvalt, worden direct eigen verbruik en contractvergelijking nog belangrijker.',
        'resources_heading' => 'Zet de gezaghebbende bronnen direct op de homepage',
        'articles_heading' => 'Sluit de homepage af met ingangen naar verdiepende artikelen',
        'more_label' => 'Meer',
        'empty_section' => 'In deze sectie zijn nog geen artikelen gepubliceerd.',
    ] : [
        'hero_summary_title' => 'Homepage rule summary for the Dutch market',
        'core_points_title' => 'The 4 points every Dutch solar owner should understand first',
        'core_points_intro' => 'A topic homepage should explain the rules clearly and move readers straight into policy changes, contract comparison, and payback estimation.',
        'calculator_heading' => 'Compare annual value before and after the 2027 transition',
        'production_label' => 'Annual solar production (kWh)',
        'usage_label' => 'Annual household usage (kWh)',
        'self_consumption_label' => 'Self-consumption share (%)',
        'buy_rate_label' => 'Import electricity price (EUR/kWh)',
        'feed_in_rate_label' => 'Post-2027 feed-in compensation (EUR/kWh)',
        'logic_label' => 'Calculation logic:',
        'logic_text' => 'Under the current regime, exported electricity is assumed to offset remaining annual usage first. After 2027, self-consumed solar still saves the import rate, while exported electricity is valued at the feed-in compensation you enter. This is a homepage estimator, not a substitute for specific supplier contract terms.',
        'result_label' => 'Result preview',
        'result_heading' => 'Your yearly value under both rule sets',
        'current_regime_label' => 'Current regime (until 2026-12-31)',
        'future_regime_label' => 'After 2027',
        'difference_label' => 'Difference per year',
        'difference_hint' => 'If the post-2027 value is lower, raising self-consumption and comparing supplier contracts will matter more.',
        'resources_heading' => 'Put the authoritative sources directly on the homepage',
        'articles_heading' => 'Finish the homepage with article entry points',
        'more_label' => 'More',
        'empty_section' => 'This section does not have published articles yet.',
    ]);
@endphp

@section('title', $pageTitle)
@section('description', $pageDescription)
@section('keywords', $pageKeywords)

@push('styles')
<style>
    .hero-grid {
        background:
            radial-gradient(circle at top left, rgba(104, 175, 255, 0.22), transparent 32%),
            radial-gradient(circle at right 20%, rgba(47, 115, 255, 0.24), transparent 28%),
            linear-gradient(135deg, #f3f8ff 0%, #ffffff 45%, #eef4fb 100%);
    }
    .calculator-card-shadow {
        box-shadow: 0 30px 80px -50px rgba(18, 49, 95, 0.45);
    }
    .result-panel {
        background: linear-gradient(180deg, rgba(18, 49, 95, 0.98) 0%, rgba(24, 67, 130, 0.98) 100%);
    }
    .article-card:hover img {
        transform: scale(1.04);
    }
</style>
@endpush

@section('content')
<main class="pb-20">
    <section class="hero-grid border-b border-[#dce5f1]">
        <div class="mx-auto grid max-w-[1280px] gap-10 px-6 py-12 lg:grid-cols-[minmax(0,1.2fr)_440px] lg:px-10 lg:py-20">
            <div>
                <span class="inline-flex rounded-full border border-[#cfe0fb] bg-white px-4 py-1.5 text-xs font-bold uppercase tracking-[0.24em] text-[#2f73ff]">
                    {{ $pageCopy['eyebrow'] }}
                </span>

                <h1 class="mt-6 max-w-4xl text-4xl font-black leading-[1.05] tracking-tight text-[#12315f]">
                    {{ $pageCopy['hero_title'] }}
                </h1>

                <p class="mt-6 max-w-2xl text-lg leading-8 text-[#506987]">
                    {{ $pageCopy['hero_description'] }}
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="#calculator" class="inline-flex h-12 items-center justify-center rounded-2xl bg-[#12315f] px-5 text-sm font-semibold text-white transition-colors hover:bg-[#0e294f]">
                        {{ $pageCopy['hero_primary'] }}
                    </a>
                    <a href="{{ route('saldering.policy') }}" class="inline-flex h-12 items-center justify-center rounded-2xl border border-[#c7dafd] bg-white px-5 text-sm font-semibold text-[#12315f] transition-colors hover:bg-[#f7fbff]">
                        {{ $pageCopy['hero_secondary'] }}
                    </a>
                </div>

                <div class="mt-10 grid gap-4 md:grid-cols-3">
                    @foreach($pageCopy['highlights'] as $highlight)
                        <div class="rounded-3xl border border-[#dce5f1] bg-white/85 p-5 shadow-sm">
                            <span class="material-symbols-outlined text-[20px] text-[#2f73ff]">check_circle</span>
                            <p class="mt-3 text-sm leading-6 text-[#24486f]">{{ $highlight }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="self-start rounded-[2rem] border border-[#dce5f1] bg-white p-6 shadow-xl shadow-blue-100/50">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#2f73ff]">{{ $pageCopy['facts_title'] }}</p>
                        <h2 class="mt-2 text-2xl font-black tracking-tight text-[#12315f]">
                            {{ $homeText['hero_summary_title'] }}
                        </h2>
                    </div>
                    <span class="flex size-12 items-center justify-center rounded-2xl bg-[#edf4ff] text-[#2f73ff]">
                        <span class="material-symbols-outlined">bolt</span>
                    </span>
                </div>

                <p class="mt-4 text-sm leading-6 text-[#5f7698]">
                    {{ $pageCopy['facts_description'] }}
                </p>

                <div class="mt-6 space-y-4">
                    @foreach($factCards as $card)
                        <div class="rounded-3xl border border-[#e7eef7] bg-[#fbfdff] p-5">
                            <div class="flex items-center justify-between gap-4">
                                <h3 class="text-sm font-bold text-[#12315f]">{{ $card['title'] }}</h3>
                                <span class="rounded-full bg-[#12315f] px-3 py-1 text-xs font-semibold text-white">{{ $card['value'] }}</span>
                            </div>
                            <p class="mt-3 text-sm leading-6 text-[#5f7698]">{{ $card['description'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-[1280px] px-6 py-16 lg:px-10">
        <div class="mb-8 flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#2f73ff]">{{ $pageCopy['facts_title'] }}</p>
                <h2 class="mt-2 text-3xl font-black tracking-tight text-[#12315f]">{{ $homeText['core_points_title'] }}</h2>
            </div>
            <p class="max-w-xl text-sm leading-6 text-[#5f7698]">
                {{ $homeText['core_points_intro'] }}
            </p>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
            @php
                $points = $isZh ? [
                    ['title' => '1. 年度净计量', 'text' => '在 2026 年底之前，家庭用户仍可将全年回馈电量与全年用电量进行年度抵扣。'],
                    ['title' => '2. 2027 起不再全额抵扣', 'text' => '从 2027 年 1 月 1 日开始，超额回馈不再按购电价 1:1 抵扣，而是转为补偿。'],
                    ['title' => '3. 回馈补偿不等于购电价', 'text' => '2027 年后的补偿通常低于购电价，因此自发自用比例会变得更重要。'],
                    ['title' => '4. 合同比较更重要', 'text' => '能源供应商的回馈电价、固定费用与 terugleverkosten 会明显影响实际回报。'],
                ] : ($isNl ? [
                    ['title' => '1. Jaarlijkse verrekening blijft voorlopig', 'text' => 'Tot eind 2026 kunnen huishoudens hun jaarlijkse teruglevering nog wegstrepen tegen hun jaarlijkse verbruik.'],
                    ['title' => '2. Volledige saldering stopt in 2027', 'text' => 'Vanaf 1 januari 2027 wordt overtollige teruglevering niet langer één op één verrekend met het leveringstarief.'],
                    ['title' => '3. Terugleverwaarde is lager dan afnamewaarde', 'text' => 'Na 2027 is de vergoeding meestal lager dan je afnameprijs, waardoor direct eigen verbruik belangrijker wordt.'],
                    ['title' => '4. Contractvergelijking telt zwaarder', 'text' => 'Terugleververgoedingen, vaste kosten en eventuele terugleverkosten hebben straks meer invloed op je werkelijke opbrengst.'],
                ] : [
                    ['title' => '1. Annual netting still applies', 'text' => 'Until the end of 2026, households can still offset annual exported electricity against annual consumption.'],
                    ['title' => '2. Full netting ends in 2027', 'text' => 'From January 1, 2027, excess export is no longer settled one-for-one at the retail import rate.'],
                    ['title' => '3. Feed-in value is lower than import value', 'text' => 'After 2027, compensation is usually lower than your buying price, so self-consumption matters more.'],
                    ['title' => '4. Contract comparison matters more', 'text' => 'Supplier feed-in tariffs, fixed fees, and any terugleverkosten can materially change your real return.'],
                ]);
            @endphp

            @foreach($points as $point)
                <article class="rounded-[2rem] border border-[#dbe4f0] bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-black text-[#12315f]">{{ $point['title'] }}</h3>
                    <p class="mt-3 text-sm leading-7 text-[#5f7698]">{{ $point['text'] }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-[1280px] px-6 py-4 lg:px-10">
        @php
            $topicSection = $isZh ? [
                'eyebrow' => '整站规划',
                'title' => '把流量先导向 4 个核心主题入口',
                'description' => '首页不只负责解释规则，也要把用户分流到政策锚点、测算、解决方案和持续更新四个路径。',
                'cards' => [
                    ['title' => '2027 政策事实页', 'description' => '先确认 saldering 到底何时停止，避免把 2030 或 2031 误当成结束日期。', 'url' => route('saldering.policy')],
                    ['title' => '收益计算器', 'description' => '比较 2026 规则与 2027 之后的年度价值差异。', 'url' => route('index') . '#calculator'],
                    ['title' => '实用指南', 'description' => '继续看合同、白天用电、热水和 EV 充电等具体动作。', 'url' => route('guides')],
                    ['title' => '政策与市场更新', 'description' => '持续跟踪监管表述、供应商补偿和市场变化。', 'url' => route('news')],
                ],
            ] : ($isNl ? [
                'eyebrow' => 'Sitestructuur',
                'title' => 'Leid bezoekers eerst naar 4 kerningangen',
                'description' => 'De homepage moet niet alleen uitleg geven, maar bezoekers ook verdelen over feiten, rekentools, oplossingen en updates.',
                'cards' => [
                    ['title' => 'Feitenpagina 2027', 'description' => 'Bevestig eerst wanneer salderen echt stopt, zodat 2030 of 2031 niet verkeerd wordt gelezen als einddatum.', 'url' => route('saldering.policy')],
                    ['title' => 'Salderingscalculator', 'description' => 'Vergelijk de jaarwaarde onder de huidige regels en het regime na 2027.', 'url' => route('index') . '#calculator'],
                    ['title' => 'Praktische gidsen', 'description' => 'Ga verder met contracten, dagverbruik, warm water en EV-laden als concrete vervolgstappen.', 'url' => route('guides')],
                    ['title' => 'Beleids- en marktupdates', 'description' => 'Volg wijzigingen in toezicht, leveranciersvoorwaarden en terugleververgoeding.', 'url' => route('news')],
                ],
            ] : [
                'eyebrow' => 'Site plan',
                'title' => 'Guide visitors through 4 core entry points',
                'description' => 'The homepage should do more than explain the rules. It should route readers into facts, calculators, solutions, and ongoing updates.',
                'cards' => [
                    ['title' => '2027 fact page', 'description' => 'Confirm when Dutch net metering actually ends so 2030 or 2031 are not confused with the stop date.', 'url' => route('saldering.policy')],
                    ['title' => 'Net metering calculator', 'description' => 'Compare yearly value under the current rules and the post-2027 regime.', 'url' => route('index') . '#calculator'],
                    ['title' => 'Practical guides', 'description' => 'Move into contracts, daytime usage, hot water, and EV charging as next steps.', 'url' => route('guides')],
                    ['title' => 'Policy and market updates', 'description' => 'Track regulatory wording, supplier terms, and feed-in compensation changes.', 'url' => route('news')],
                ],
            ]);
        @endphp

        <div class="mb-8 flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#2f73ff]">{{ $topicSection['eyebrow'] }}</p>
                <h2 class="mt-2 text-3xl font-black tracking-tight text-[#12315f]">{{ $topicSection['title'] }}</h2>
            </div>
            <p class="max-w-xl text-sm leading-6 text-[#5f7698]">{{ $topicSection['description'] }}</p>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
            @foreach($topicSection['cards'] as $card)
                <a href="{{ $card['url'] }}" class="rounded-[2rem] border border-[#dbe4f0] bg-white p-6 shadow-sm transition-all hover:-translate-y-1 hover:border-[#c6d8fb] hover:bg-[#fbfdff]">
                    <span class="flex size-11 items-center justify-center rounded-2xl bg-[#edf4ff] text-[#2f73ff]">
                        <span class="material-symbols-outlined text-[22px]">north_east</span>
                    </span>
                    <h3 class="mt-5 text-lg font-black leading-7 text-[#12315f]">{{ $card['title'] }}</h3>
                    <p class="mt-3 text-sm leading-6 text-[#5f7698]">{{ $card['description'] }}</p>
                </a>
            @endforeach
        </div>
    </section>

    <section id="calculator" class="mx-auto max-w-[1280px] px-6 py-4 lg:px-10">
        <div class="calculator-card-shadow overflow-hidden rounded-[2rem] border border-[#dbe4f0] bg-white">
            <div class="grid gap-0 lg:grid-cols-[minmax(0,1fr)_420px]">
                <div class="p-6 md:p-8">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#2f73ff]">{{ $pageCopy['calculator_title'] }}</p>
                    <h2 class="mt-2 text-3xl font-black tracking-tight text-[#12315f]">{{ $homeText['calculator_heading'] }}</h2>
                    <p class="mt-4 max-w-2xl text-sm leading-7 text-[#5f7698]">{{ $pageCopy['calculator_description'] }}</p>

                    <div class="mt-8 grid gap-5 md:grid-cols-2">
                        <label class="block">
                            <span class="mb-2 block text-sm font-semibold text-[#12315f]">{{ $homeText['production_label'] }}</span>
                            <input id="annual-production" type="number" min="0" step="50" value="{{ $calculatorDefaults['annual_production'] }}" class="h-12 w-full rounded-2xl border border-[#dbe4f0] bg-[#fbfdff] px-4 text-[#12315f] focus:border-[#2f73ff] focus:ring-[#2f73ff]" />
                        </label>
                        <label class="block">
                            <span class="mb-2 block text-sm font-semibold text-[#12315f]">{{ $homeText['usage_label'] }}</span>
                            <input id="annual-usage" type="number" min="0" step="50" value="{{ $calculatorDefaults['annual_usage'] }}" class="h-12 w-full rounded-2xl border border-[#dbe4f0] bg-[#fbfdff] px-4 text-[#12315f] focus:border-[#2f73ff] focus:ring-[#2f73ff]" />
                        </label>
                        <label class="block">
                            <span class="mb-2 block text-sm font-semibold text-[#12315f]">{{ $homeText['self_consumption_label'] }}</span>
                            <input id="self-consumption" type="number" min="0" max="100" step="1" value="{{ $calculatorDefaults['self_consumption'] }}" class="h-12 w-full rounded-2xl border border-[#dbe4f0] bg-[#fbfdff] px-4 text-[#12315f] focus:border-[#2f73ff] focus:ring-[#2f73ff]" />
                        </label>
                        <label class="block">
                            <span class="mb-2 block text-sm font-semibold text-[#12315f]">{{ $homeText['buy_rate_label'] }}</span>
                            <input id="buy-rate" type="number" min="0" step="0.01" value="{{ $calculatorDefaults['buy_rate'] }}" class="h-12 w-full rounded-2xl border border-[#dbe4f0] bg-[#fbfdff] px-4 text-[#12315f] focus:border-[#2f73ff] focus:ring-[#2f73ff]" />
                        </label>
                        <label class="block md:col-span-2">
                            <span class="mb-2 block text-sm font-semibold text-[#12315f]">{{ $homeText['feed_in_rate_label'] }}</span>
                            <input id="feed-in-rate" type="number" min="0" step="0.01" value="{{ $calculatorDefaults['feed_in_rate'] }}" class="h-12 w-full rounded-2xl border border-[#dbe4f0] bg-[#fbfdff] px-4 text-[#12315f] focus:border-[#2f73ff] focus:ring-[#2f73ff]" />
                        </label>
                    </div>

                    <div class="mt-6 rounded-[1.5rem] border border-[#e6eef8] bg-[#f8fbff] p-5 text-sm leading-7 text-[#48617f]">
                        <strong class="text-[#12315f]">{{ $homeText['logic_label'] }}</strong>
                        {{ $homeText['logic_text'] }}
                    </div>
                </div>

                <aside class="result-panel p-6 text-white md:p-8">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-blue-100/75">{{ $homeText['result_label'] }}</p>
                    <h3 class="mt-2 text-2xl font-black tracking-tight">{{ $homeText['result_heading'] }}</h3>

                    <div class="mt-8 space-y-4">
                        <div class="rounded-[1.5rem] border border-white/10 bg-white/5 p-5">
                            <p class="text-xs uppercase tracking-[0.18em] text-blue-100/70">{{ $homeText['current_regime_label'] }}</p>
                            <p id="current-value" class="mt-3 text-4xl font-black">EUR 0</p>
                            <p id="current-detail" class="mt-3 text-sm leading-6 text-blue-100/80"></p>
                        </div>
                        <div class="rounded-[1.5rem] border border-white/10 bg-white/5 p-5">
                            <p class="text-xs uppercase tracking-[0.18em] text-blue-100/70">{{ $homeText['future_regime_label'] }}</p>
                            <p id="future-value" class="mt-3 text-4xl font-black">EUR 0</p>
                            <p id="future-detail" class="mt-3 text-sm leading-6 text-blue-100/80"></p>
                        </div>
                        <div class="rounded-[1.5rem] border border-[#6aa7ff]/30 bg-[#6aa7ff]/10 p-5">
                            <p class="text-xs uppercase tracking-[0.18em] text-blue-100/70">{{ $homeText['difference_label'] }}</p>
                            <p id="difference-value" class="mt-3 text-3xl font-black">EUR 0</p>
                            <p class="mt-2 text-sm leading-6 text-blue-100/80">
                                {{ $homeText['difference_hint'] }}
                            </p>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <section id="official-links" class="mx-auto max-w-[1280px] px-6 py-16 lg:px-10">
        <div class="mb-8 flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#2f73ff]">{{ $pageCopy['resources_title'] }}</p>
                <h2 class="mt-2 text-3xl font-black tracking-tight text-[#12315f]">{{ $homeText['resources_heading'] }}</h2>
            </div>
            <p class="max-w-xl text-sm leading-6 text-[#5f7698]">{{ $pageCopy['resources_description'] }}</p>
        </div>

        <div class="grid gap-5 lg:grid-cols-2">
            @foreach($officialLinks as $link)
                <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer" class="rounded-[2rem] border border-[#dbe4f0] bg-white p-6 shadow-sm transition-all hover:-translate-y-1 hover:border-[#c6d8fb] hover:bg-[#fbfdff]">
                    <div class="flex flex-wrap items-center gap-2">
                        @if(!empty($link['source']))
                            <span class="rounded-full bg-[#edf4ff] px-2.5 py-1 text-[11px] font-semibold text-[#2f73ff]">{{ $link['source'] }}</span>
                        @endif
                        @if(!empty($link['updated_at']))
                            <span class="text-[11px] text-[#7a8faa]">{{ $isZh ? '更新于' : ($isNl ? 'Bijgewerkt' : 'Updated') }} {{ $link['updated_at'] }}</span>
                        @endif
                    </div>
                    <div class="flex items-start gap-4">
                        <span class="mt-1 flex size-11 items-center justify-center rounded-2xl bg-[#edf4ff] text-[#2f73ff]">
                            <span class="material-symbols-outlined text-[22px]">open_in_new</span>
                        </span>
                        <div>
                            <h3 class="text-lg font-black text-[#12315f]">{{ $link['title'] }}</h3>
                            <p class="mt-3 text-sm leading-7 text-[#5f7698]">{{ $link['description'] }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-[1280px] px-6 py-4 lg:px-10">
        <div class="mb-8 flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#2f73ff]">{{ $pageCopy['articles_title'] }}</p>
                <h2 class="mt-2 text-3xl font-black tracking-tight text-[#12315f]">{{ $homeText['articles_heading'] }}</h2>
            </div>
            <a href="{{ route('articles') }}" class="text-sm font-semibold text-[#2f73ff] transition-colors hover:text-[#12315f]">{{ $pageCopy['browse_all'] }}</a>
        </div>
        <p class="mb-8 max-w-3xl text-sm leading-6 text-[#5f7698]">{{ $pageCopy['articles_description'] }}</p>

        <div class="grid gap-10 xl:grid-cols-3">
            @php
                $sections = [
                    ['title' => $pageCopy['section_guides'], 'route' => route('guides'), 'items' => $guidesArticles],
                    ['title' => $pageCopy['section_news'], 'route' => route('news'), 'items' => $newsArticles],
                    ['title' => $pageCopy['section_cases'], 'route' => route('cases'), 'items' => $casesArticles],
                ];
            @endphp

            @foreach($sections as $section)
                <div>
                    <div class="mb-5 flex items-center justify-between">
                        <h3 class="text-xl font-black text-[#12315f]">{{ $section['title'] }}</h3>
                        <a href="{{ $section['route'] }}" class="text-sm font-semibold text-[#2f73ff]">{{ $homeText['more_label'] }}</a>
                    </div>

                    <div class="space-y-4">
                        @forelse($section['items'] as $article)
                            <article class="article-card rounded-[1.75rem] border border-[#dbe4f0] bg-white p-4 shadow-sm">
                                <a href="{{ route('article.detail.show', [$article->category->name ?? 'blog', $article->link]) }}" class="block overflow-hidden rounded-2xl">
                                    <img src="{{ $article->cover ? Storage::url($article->cover) : '/around/image/blog-homepage.jpg' }}" alt="{{ $article->title }}" class="h-48 w-full object-cover transition-transform duration-300" loading="lazy">
                                </a>
                                <div class="pt-4">
                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#2f73ff]">{{ $article->created_at->format('Y-m-d') }}</p>
                                    <h4 class="mt-2 text-lg font-black leading-7 text-[#12315f]">
                                        <a href="{{ route('article.detail.show', [$article->category->name ?? 'blog', $article->link]) }}">{{ $article->title }}</a>
                                    </h4>
                                    <p class="mt-2 text-sm leading-6 text-[#5f7698]">{{ Str::limit($article->summary ?? strip_tags($article->content), 110) }}</p>
                                </div>
                            </article>
                        @empty
                            <div class="rounded-[1.75rem] border border-dashed border-[#dbe4f0] bg-[#fbfdff] p-6 text-sm leading-6 text-[#5f7698]">
                                {{ $homeText['empty_section'] }}
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputs = {
            production: document.getElementById('annual-production'),
            usage: document.getElementById('annual-usage'),
            selfConsumption: document.getElementById('self-consumption'),
            buyRate: document.getElementById('buy-rate'),
            feedInRate: document.getElementById('feed-in-rate')
        };

        const outputs = {
            currentValue: document.getElementById('current-value'),
            currentDetail: document.getElementById('current-detail'),
            futureValue: document.getElementById('future-value'),
            futureDetail: document.getElementById('future-detail'),
            differenceValue: document.getElementById('difference-value')
        };

        const locale = @json($locale);
        const isZh = locale === 'zh';
        const isNl = locale === 'nl';
        const numberLocale = isZh ? 'zh-CN' : (isNl ? 'nl-NL' : 'en-NL');
        const money = new Intl.NumberFormat(numberLocale, {
            style: 'currency',
            currency: 'EUR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        });

        const number = new Intl.NumberFormat(numberLocale, {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        });

        function calculate() {
            const production = Math.max(Number(inputs.production.value) || 0, 0);
            const usage = Math.max(Number(inputs.usage.value) || 0, 0);
            const selfConsumptionShare = Math.min(Math.max(Number(inputs.selfConsumption.value) || 0, 0), 100) / 100;
            const buyRate = Math.max(Number(inputs.buyRate.value) || 0, 0);
            const feedInRate = Math.max(Number(inputs.feedInRate.value) || 0, 0);

            const selfConsumed = production * selfConsumptionShare;
            const exported = Math.max(production - selfConsumed, 0);
            const remainingUsage = Math.max(usage - selfConsumed, 0);

            const nettedExport = Math.min(exported, remainingUsage);
            const excessExport = Math.max(exported - nettedExport, 0);

            const currentValue = (selfConsumed * buyRate) + (nettedExport * buyRate) + (excessExport * feedInRate);
            const futureValue = (selfConsumed * buyRate) + (exported * feedInRate);
            const difference = currentValue - futureValue;

            outputs.currentValue.textContent = money.format(currentValue);
            outputs.futureValue.textContent = money.format(futureValue);
            outputs.differenceValue.textContent = money.format(difference);

            outputs.currentDetail.textContent = isZh
                ? `自发自用 ${number.format(selfConsumed)} kWh，年度净计量 ${number.format(nettedExport)} kWh，超额回馈 ${number.format(excessExport)} kWh。`
                : (isNl
                    ? `${number.format(selfConsumed)} kWh direct gebruikt, ${number.format(nettedExport)} kWh jaarlijks verrekend en ${number.format(excessExport)} kWh als extra teruglevering vergoed.`
                    : `${number.format(selfConsumed)} kWh self-consumed, ${number.format(nettedExport)} kWh netted annually, and ${number.format(excessExport)} kWh paid as excess export.`);

            outputs.futureDetail.textContent = isZh
                ? `自发自用部分按购电价节省，${number.format(exported)} kWh 外送电量按回馈补偿价计算。`
                : (isNl
                    ? `Direct eigen verbruik bespaart de afnameprijs, terwijl ${number.format(exported)} kWh teruglevering wordt gewaardeerd tegen de ingevoerde vergoeding.`
                    : `Self-consumed solar saves the import rate, while ${number.format(exported)} kWh of export is valued at the feed-in compensation rate.`);
        }

        Object.values(inputs).forEach(function (input) {
            input.addEventListener('input', calculate);
        });

        calculate();
    });
</script>
@endpush

@push('schema')
@php
    $homeFaqItems = $isZh ? [
        ['question' => '荷兰净计量会在 2027 年逐步取消到 2031 吗？', 'answer' => '不会。当前官方口径是 salderingsregeling 自 2027 年 1 月 1 日起停止。2030 相关的是最低回馈补偿保护期限。'],
        ['question' => '2027 年后家用电池会更重要吗？', 'answer' => '通常会。因为 2027 年后回馈电量的价值低于购电价，自发自用比例越高，家用电池和负载转移的意义越大。'],
        ['question' => '2027 年后我还可以把电卖回电网吗？', 'answer' => '可以。变化在于不再按年度 1:1 抵扣，而是由供应商支付回馈补偿。'],
    ] : ($isNl ? [
        ['question' => 'Wordt de salderingsregeling afgebouwd tot 2031?', 'answer' => 'Nee. De huidige officiele lijn is dat de salderingsregeling stopt op 1 januari 2027. De datum 2030 hoort bij de minimale terugleververgoeding.'],
        ['question' => 'Wordt een thuisbatterij belangrijker na 2027?', 'answer' => 'Vaak wel. Omdat teruglevering na 2027 meestal minder waard is dan directe besparing op afname, wordt extra eigen verbruik via een thuisbatterij aantrekkelijker voor sommige huishoudens.'],
        ['question' => 'Kun je na 2027 nog stroom terugleveren aan het net?', 'answer' => 'Ja. Wat verandert, is dat teruglevering niet meer volledig wordt gesaldeerd maar wordt vergoed volgens de contractvoorwaarden van de leverancier.'],
    ] : [
        ['question' => 'Is Dutch net metering phased out through 2031?', 'answer' => 'No. The current official position is that the salderingsregeling ends on January 1, 2027, while 2030 relates to minimum export compensation.'],
        ['question' => 'Does a home battery matter more after 2027?', 'answer' => 'Often yes. When export compensation is lower than the retail import rate, higher self-consumption through a home battery can become more valuable for some households.'],
        ['question' => 'Can households still export electricity after 2027?', 'answer' => 'Yes. The change is that exported electricity is compensated instead of being fully netted out annually.'],
    ]);
    $homeItemList = collect($officialLinks)->take(4)->map(function ($link) {
        return ['name' => $link['title'], 'url' => $link['url']];
    })->all();
    $homeBreadcrumbs = [
        ['name' => $isZh ? '首页' : 'Home', 'item' => route('index')],
    ];
@endphp
@include('front.partials.static-page-structured-data', [
    'schemaPageType' => 'WebPage',
    'schemaPageTitle' => $pageTitle,
    'schemaPageDescription' => $pageDescription,
    'schemaPageUrl' => request()->url(),
    'schemaLanguage' => $isZh ? 'zh-CN' : ($isNl ? 'nl-NL' : 'en'),
    'schemaBreadcrumbs' => $homeBreadcrumbs,
    'schemaFaqItems' => $homeFaqItems,
    'schemaItemList' => $homeItemList,
])
@endpush
