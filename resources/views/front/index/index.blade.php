@extends('layouts.stitch.master')

@php
    $locale = app()->getLocale();
    $isZh = $locale === 'zh';
    $isNl = $locale === 'nl';
    $siteName = config('site.name', 'SalderingGids');
@endphp

@section('title', $isZh ? 'SalderingGids 荷兰净计量专题页 | 规则、政府链接与计算器' : ($isNl ? 'SalderingGids | Nederlandse salderingsregeling, officiële links en calculator' : 'SalderingGids | Dutch Net Metering Guide, Official Links, and Calculator'))
@section('description', $isZh ? '围绕荷兰净计量 salderingsregeling 的专题首页，包含 2027 政策变化说明、官方政府链接、回馈补偿信息、收益计算器与相关文章入口。' : ($isNl ? 'Een gerichte homepage over de Nederlandse salderingsregeling met uitleg over de wijziging in 2027, officiële overheidslinks, informatie over terugleververgoeding en een calculator.' : 'A focused homepage about the Dutch salderingsregeling with the 2027 transition, official government links, feed-in compensation guidance, a calculator, and related articles.'))
@section('keywords', $isZh ? 'salderingsregeling, 荷兰净计量, zonnepanelen, terugleververgoeding, 荷兰太阳能, 荷兰能源合同' : ($isNl ? 'salderingsregeling, zonnepanelen, terugleververgoeding, energiecontract, Nederlandse zonne-energie' : 'salderingsregeling, Dutch net metering, zonnepanelen, terugleververgoeding, solar Netherlands, Dutch energy contract'))

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
                    <a href="#official-links" class="inline-flex h-12 items-center justify-center rounded-2xl border border-[#c7dafd] bg-white px-5 text-sm font-semibold text-[#12315f] transition-colors hover:bg-[#f7fbff]">
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
                            {{ $isZh ? '荷兰净计量首页解释模块' : ($isNl ? 'Uitlegblok voor de homepage over salderen' : 'Homepage rule summary for the Dutch market') }}
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
                <h2 class="mt-2 text-3xl font-black tracking-tight text-[#12315f]">{{ $isZh ? '你需要先理解的 4 个核心点' : ($isNl ? 'De 4 punten die iedere Nederlandse zonnepaneelbezitter eerst moet begrijpen' : 'The 4 points every Dutch solar owner should understand first') }}</h2>
            </div>
            <p class="max-w-xl text-sm leading-6 text-[#5f7698]">
                {{ $isZh ? '专题首页既要讲清规则，也要让用户直接进入政策变化、合同比较和收益计算。' : ($isNl ? 'Een thematische homepage moet de regels helder uitleggen en bezoekers direct naar beleidswijzigingen, contractvergelijking en rendementschatting leiden.' : 'A topic homepage should explain the rules clearly and move readers straight into policy changes, contract comparison, and payback estimation.') }}
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

    <section id="calculator" class="mx-auto max-w-[1280px] px-6 py-4 lg:px-10">
        <div class="calculator-card-shadow overflow-hidden rounded-[2rem] border border-[#dbe4f0] bg-white">
            <div class="grid gap-0 lg:grid-cols-[minmax(0,1fr)_420px]">
                <div class="p-6 md:p-8">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#2f73ff]">{{ $pageCopy['calculator_title'] }}</p>
                    <h2 class="mt-2 text-3xl font-black tracking-tight text-[#12315f]">{{ $isZh ? '比较当前规则与 2027 年后的年度价值' : ($isNl ? 'Vergelijk je jaarlijkse waarde voor en na de wijziging in 2027' : 'Compare annual value before and after the 2027 transition') }}</h2>
                    <p class="mt-4 max-w-2xl text-sm leading-7 text-[#5f7698]">{{ $pageCopy['calculator_description'] }}</p>

                    <div class="mt-8 grid gap-5 md:grid-cols-2">
                        <label class="block">
                            <span class="mb-2 block text-sm font-semibold text-[#12315f]">{{ $isZh ? '年发电量 (kWh)' : ($isNl ? 'Jaarlijkse zonneproductie (kWh)' : 'Annual solar production (kWh)') }}</span>
                            <input id="annual-production" type="number" min="0" step="50" value="{{ $calculatorDefaults['annual_production'] }}" class="h-12 w-full rounded-2xl border border-[#dbe4f0] bg-[#fbfdff] px-4 text-[#12315f] focus:border-[#2f73ff] focus:ring-[#2f73ff]" />
                        </label>
                        <label class="block">
                            <span class="mb-2 block text-sm font-semibold text-[#12315f]">{{ $isZh ? '家庭年用电量 (kWh)' : ($isNl ? 'Jaarlijks huishoudelijk verbruik (kWh)' : 'Annual household usage (kWh)') }}</span>
                            <input id="annual-usage" type="number" min="0" step="50" value="{{ $calculatorDefaults['annual_usage'] }}" class="h-12 w-full rounded-2xl border border-[#dbe4f0] bg-[#fbfdff] px-4 text-[#12315f] focus:border-[#2f73ff] focus:ring-[#2f73ff]" />
                        </label>
                        <label class="block">
                            <span class="mb-2 block text-sm font-semibold text-[#12315f]">{{ $isZh ? '即时自用比例 (%)' : ($isNl ? 'Direct eigen verbruik (%)' : 'Self-consumption share (%)') }}</span>
                            <input id="self-consumption" type="number" min="0" max="100" step="1" value="{{ $calculatorDefaults['self_consumption'] }}" class="h-12 w-full rounded-2xl border border-[#dbe4f0] bg-[#fbfdff] px-4 text-[#12315f] focus:border-[#2f73ff] focus:ring-[#2f73ff]" />
                        </label>
                        <label class="block">
                            <span class="mb-2 block text-sm font-semibold text-[#12315f]">{{ $isZh ? '购电价 (EUR/kWh)' : ($isNl ? 'Afnameprijs stroom (EUR/kWh)' : 'Import electricity price (EUR/kWh)') }}</span>
                            <input id="buy-rate" type="number" min="0" step="0.01" value="{{ $calculatorDefaults['buy_rate'] }}" class="h-12 w-full rounded-2xl border border-[#dbe4f0] bg-[#fbfdff] px-4 text-[#12315f] focus:border-[#2f73ff] focus:ring-[#2f73ff]" />
                        </label>
                        <label class="block md:col-span-2">
                            <span class="mb-2 block text-sm font-semibold text-[#12315f]">{{ $isZh ? '2027 后回馈补偿价 (EUR/kWh)' : ($isNl ? 'Terugleververgoeding na 2027 (EUR/kWh)' : 'Post-2027 feed-in compensation (EUR/kWh)') }}</span>
                            <input id="feed-in-rate" type="number" min="0" step="0.01" value="{{ $calculatorDefaults['feed_in_rate'] }}" class="h-12 w-full rounded-2xl border border-[#dbe4f0] bg-[#fbfdff] px-4 text-[#12315f] focus:border-[#2f73ff] focus:ring-[#2f73ff]" />
                        </label>
                    </div>

                    <div class="mt-6 rounded-[1.5rem] border border-[#e6eef8] bg-[#f8fbff] p-5 text-sm leading-7 text-[#48617f]">
                        <strong class="text-[#12315f]">{{ $isZh ? '计算逻辑：' : ($isNl ? 'Rekenlogica:' : 'Calculation logic:') }}</strong>
                        {{ $isZh
                            ? '当前规则下，假设回馈电量可在年度内与剩余用电量优先抵扣；2027 年后，自发自用仍按购电价节省，外送电量按输入的回馈补偿价计算。该工具用于首页专题估算，不替代具体能源合同条款。'
                            : ($isNl
                                ? 'Onder de huidige regels wordt aangenomen dat teruglevering eerst het resterende jaarverbruik compenseert. Na 2027 bespaart direct eigen verbruik nog steeds de afnameprijs, terwijl teruglevering wordt gewaardeerd tegen de ingevoerde vergoeding. Dit is een schatting voor de homepage en vervangt geen contractvoorwaarden van leveranciers.'
                                : 'Under the current regime, exported electricity is assumed to offset remaining annual usage first. After 2027, self-consumed solar still saves the import rate, while exported electricity is valued at the feed-in compensation you enter. This is a homepage estimator, not a substitute for specific supplier contract terms.')) }}
                    </div>
                </div>

                <aside class="result-panel p-6 text-white md:p-8">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-blue-100/75">{{ $isZh ? '结果预览' : ($isNl ? 'Resultaat' : 'Result preview') }}</p>
                    <h3 class="mt-2 text-2xl font-black tracking-tight">{{ $isZh ? '两种规则下的年度价值' : ($isNl ? 'Je jaarlijkse waarde onder beide regelsets' : 'Your yearly value under both rule sets') }}</h3>

                    <div class="mt-8 space-y-4">
                        <div class="rounded-[1.5rem] border border-white/10 bg-white/5 p-5">
                            <p class="text-xs uppercase tracking-[0.18em] text-blue-100/70">{{ $isZh ? '当前规则（到 2026-12-31）' : ($isNl ? 'Huidige regeling (tot 2026-12-31)' : 'Current regime (until 2026-12-31)') }}</p>
                            <p id="current-value" class="mt-3 text-4xl font-black">EUR 0</p>
                            <p id="current-detail" class="mt-3 text-sm leading-6 text-blue-100/80"></p>
                        </div>
                        <div class="rounded-[1.5rem] border border-white/10 bg-white/5 p-5">
                            <p class="text-xs uppercase tracking-[0.18em] text-blue-100/70">{{ $isZh ? '2027 之后' : ($isNl ? 'Na 2027' : 'After 2027') }}</p>
                            <p id="future-value" class="mt-3 text-4xl font-black">EUR 0</p>
                            <p id="future-detail" class="mt-3 text-sm leading-6 text-blue-100/80"></p>
                        </div>
                        <div class="rounded-[1.5rem] border border-[#6aa7ff]/30 bg-[#6aa7ff]/10 p-5">
                            <p class="text-xs uppercase tracking-[0.18em] text-blue-100/70">{{ $isZh ? '年度差额' : ($isNl ? 'Verschil per jaar' : 'Difference per year') }}</p>
                            <p id="difference-value" class="mt-3 text-3xl font-black">EUR 0</p>
                            <p class="mt-2 text-sm leading-6 text-blue-100/80">
                                {{ $isZh ? '如果 2027 后的年度价值更低，通常说明提高自发自用比例和比较能源合同会更重要。' : ($isNl ? 'Als de jaarlijkse waarde na 2027 lager uitvalt, worden direct eigen verbruik en contractvergelijking nog belangrijker.' : 'If the post-2027 value is lower, raising self-consumption and comparing supplier contracts will matter more.') }}
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
                <h2 class="mt-2 text-3xl font-black tracking-tight text-[#12315f]">{{ $isZh ? '首页直接挂上权威来源' : ($isNl ? 'Zet de gezaghebbende bronnen direct op de homepage' : 'Put the authoritative sources directly on the homepage') }}</h2>
            </div>
            <p class="max-w-xl text-sm leading-6 text-[#5f7698]">{{ $pageCopy['resources_description'] }}</p>
        </div>

        <div class="grid gap-5 lg:grid-cols-2">
            @foreach($officialLinks as $link)
                <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer" class="rounded-[2rem] border border-[#dbe4f0] bg-white p-6 shadow-sm transition-all hover:-translate-y-1 hover:border-[#c6d8fb] hover:bg-[#fbfdff]">
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
                <h2 class="mt-2 text-3xl font-black tracking-tight text-[#12315f]">{{ $isZh ? '底部放相关文章入口' : ($isNl ? 'Sluit de homepage af met ingangen naar verdiepende artikelen' : 'Finish the homepage with article entry points') }}</h2>
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
                        <a href="{{ $section['route'] }}" class="text-sm font-semibold text-[#2f73ff]">{{ $isZh ? '更多' : ($isNl ? 'Meer' : 'More') }}</a>
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
                                {{ $isZh ? '当前分类暂时还没有文章。' : ($isNl ? 'In deze sectie zijn nog geen artikelen gepubliceerd.' : 'This section does not have published articles yet.') }}
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
