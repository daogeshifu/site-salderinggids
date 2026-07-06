@extends('layouts.stitch.master')

@php
    $locale = app()->getLocale();
    $isZh = $locale === 'zh';
    $isNl = $locale === 'nl';

    $pageTitle = $isZh
        ? '荷兰净计量 2027 政策事实页 | 1 月 1 日起停止、补偿规则与官方来源'
        : ($isNl
            ? 'Salderingsregeling 2027: wat verandert echt? | Stop op 1 januari 2027'
            : 'Dutch net metering in 2027: what actually changes? | Ends on January 1, 2027');
    $pageDescription = $isZh
        ? '直接回答荷兰 salderingsregeling 在 2027 年到底怎么变：何时停止、什么还保留、最低回馈补偿到什么时候有效，以及用户现在该做什么。'
        : ($isNl
            ? 'Een feitenpagina die direct uitlegt wat er in 2027 aan de salderingsregeling verandert: wanneer salderen stopt, wat blijft bestaan, hoe de minimale terugleververgoeding werkt en wat huishoudens nu kunnen doen.'
            : 'A facts page explaining what changes in Dutch net metering in 2027: when salderen ends, what remains, how minimum feed-in compensation works, and what households should do now.');
    $pageKeywords = $isZh
        ? 'salderingsregeling 2027, 荷兰净计量, terugleververgoeding, zonnepanelen 2027, 荷兰太阳能政策'
        : ($isNl
            ? 'salderingsregeling 2027, stopt in 2027, terugleververgoeding, zonnepanelen, energiecontract'
            : 'Dutch net metering 2027, salderingsregeling ends, feed-in compensation, solar Netherlands, energy contract');

    $hero = $isZh ? [
        'eyebrow' => '政策事实页',
        'title' => '荷兰净计量不是分阶段拖到 2031，而是自 2027 年 1 月 1 日起停止',
        'description' => '如果你只想先抓住一个最重要的事实：荷兰家庭太阳能用户可以继续净计量到 2026 年 12 月 31 日。自 2027 年 1 月 1 日起，不再按购电价 1:1 年度抵扣，改为保留自发自用节省，并对回馈电量支付补偿。',
        'primary' => '打开收益计算器',
        'secondary' => '查看全部文章',
        'direct_label' => '一句话结论',
        'direct_answer' => 'salderingsregeling 在荷兰会在 2027 年 1 月 1 日停止，不是渐进式 afbouw 到 2031。',
    ] : ($isNl ? [
        'eyebrow' => 'Feitenpagina',
        'title' => 'De salderingsregeling wordt niet geleidelijk afgebouwd tot 2031, maar stopt op 1 januari 2027',
        'description' => 'Als u maar een feit wilt onthouden: huishoudens met zonnepanelen kunnen nog salderen tot en met 31 december 2026. Vanaf 1 januari 2027 vervalt de jaarlijkse 1-op-1-verrekening tegen het leveringstarief. Direct eigen verbruik blijft waardevol en teruglevering wordt vergoed.',
        'primary' => 'Open de calculator',
        'secondary' => 'Bekijk alle artikelen',
        'direct_label' => 'Kort antwoord',
        'direct_answer' => 'De Nederlandse salderingsregeling stopt op 1 januari 2027 en wordt dus niet in stappen afgebouwd tot 2031.',
    ] : [
        'eyebrow' => 'Fact anchor',
        'title' => 'Dutch net metering is not phased out through 2031. It ends on January 1, 2027',
        'description' => 'If you remember only one fact, make it this one: Dutch households with solar panels can still net out annual exports against annual usage through December 31, 2026. From January 1, 2027, full annual netting ends. Self-consumption still saves money and exported electricity is compensated instead.',
        'primary' => 'Open the calculator',
        'secondary' => 'Browse all articles',
        'direct_label' => 'Direct answer',
        'direct_answer' => 'The Dutch salderingsregeling ends on January 1, 2027 rather than being gradually reduced through 2031.',
    ]);

    $facts = $isZh ? [
        ['label' => '可继续净计量到', 'value' => '2026-12-31', 'text' => '在这之前，住宅用户仍可按年度将回馈电量与用电量抵扣。'],
        ['label' => '制度停止日', 'value' => '2027-01-01', 'text' => '从这一天起，不再进行按购电价 1:1 的年度净计量。'],
        ['label' => '最低补偿保护到', 'value' => '2030-01-01', 'text' => '在此之前，能源供应商对超额回馈至少支付裸电价 50% 的补偿。'],
    ] : ($isNl ? [
        ['label' => 'Nog salderen tot en met', 'value' => '2026-12-31', 'text' => 'Tot die datum mogen huishoudens teruglevering nog jaarlijks wegstrepen tegen verbruik.'],
        ['label' => 'Stopdatum regeling', 'value' => '2027-01-01', 'text' => 'Vanaf die dag vervalt de jaarlijkse 1-op-1-verrekening tegen het leveringstarief.'],
        ['label' => 'Minimale bescherming tot', 'value' => '2030-01-01', 'text' => 'Tot die datum moet overtollige teruglevering minimaal voor 50% van het kale leveringstarief worden vergoed.'],
    ] : [
        ['label' => 'Netting still applies until', 'value' => '2026-12-31', 'text' => 'Until then, households can still offset annual exports against annual usage.'],
        ['label' => 'Scheme end date', 'value' => '2027-01-01', 'text' => 'From that date, annual one-to-one netting at the retail supply rate ends.'],
        ['label' => 'Minimum protection until', 'value' => '2030-01-01', 'text' => 'Until then, excess exports must be compensated at no less than 50% of the bare supply tariff.'],
    ]);

    $sections = $isZh ? [
        [
            'title' => '2027 年到底变了什么',
            'items' => [
                '停止的是“年度 1:1 抵扣”，不是太阳能发电本身，也不是自发自用带来的节省。',
                '你仍然可以把电回馈到电网，但价值不再等于购电价，而是按合同里的 terugleververgoeding 计算。',
                '这意味着自发自用比例、能源合同条款和 terugleverkosten 会比过去更重要。',
            ],
        ],
        [
            'title' => '什么没有变',
            'items' => [
                '你家太阳能板继续发电，自发自用的电仍然直接替代购电。',
                '你依然可以比较不同供应商的回馈补偿和固定费用。',
                '如果系统本身运行良好，太阳能在 2027 年后通常仍有回报，只是回本逻辑更依赖用电曲线。',
            ],
        ],
        [
            'title' => '用户现在该做什么',
            'items' => [
                '先测算你当前的自发自用比例，而不是只看总发电量。',
                '开始记录合同中的回馈电价、固定费用和 eventuele terugleverkosten。',
                '优先评估哪些负载可以搬到白天，比如 EV 充电、热泵热水、洗烘设备等。',
            ],
        ],
    ] : ($isNl ? [
        [
            'title' => 'Wat verandert er precies in 2027',
            'items' => [
                'Wat stopt, is de jaarlijkse 1-op-1-verrekening van teruglevering tegen afname, niet de zonne-opwek zelf en ook niet de waarde van direct eigen verbruik.',
                'U kunt stroom nog steeds terugleveren aan het net, maar die kWh krijgt niet meer automatisch dezelfde waarde als afname tegen het leveringstarief.',
                'Daardoor wegen eigen verbruik, contractvoorwaarden en eventuele terugleverkosten zwaarder dan onder de oude regeling.',
            ],
        ],
        [
            'title' => 'Wat niet verandert',
            'items' => [
                'Uw zonnepanelen blijven stroom opwekken en direct eigen verbruik blijft direct waardevol doordat u minder hoeft af te nemen.',
                'U kunt leveranciers nog steeds vergelijken op terugleververgoeding, vaste kosten en contractstructuur.',
                'Zonnepanelen kunnen zich ook na 2027 nog terugverdienen, maar het profiel van verbruik en teruglevering wordt belangrijker.',
            ],
        ],
        [
            'title' => 'Wat huishoudens nu moeten doen',
            'items' => [
                'Meet eerst uw aandeel direct eigen verbruik in plaats van alleen naar totale opwek te kijken.',
                'Vergelijk nu al contractvoorwaarden: terugleververgoeding, vaste kosten en mogelijke terugleverkosten.',
                'Onderzoek welke verbruikers u naar de daguren kunt verschuiven, zoals EV-laden, warm water of was- en droogmomenten.',
            ],
        ],
    ] : [
        [
            'title' => 'What actually changes in 2027',
            'items' => [
                'What ends is annual one-to-one netting of exports against imports, not solar generation itself and not the savings from self-consumed solar.',
                'Households can still export electricity to the grid, but exported kWh are no longer automatically worth the same as imported retail electricity.',
                'That makes self-consumption, contract terms, and any export-related charges more important than under the old scheme.',
            ],
        ],
        [
            'title' => 'What does not change',
            'items' => [
                'Solar panels still generate electricity, and self-consumed electricity still offsets imported power directly.',
                'Households can still compare suppliers on export compensation, fixed fees, and contract design.',
                'Solar can still pay back after 2027, but the economics depend more on usage timing and export exposure.',
            ],
        ],
        [
            'title' => 'What households should do now',
            'items' => [
                'Measure your self-consumption share rather than looking only at annual generation totals.',
                'Track supplier terms now: feed-in compensation, fixed fees, and any export-related charges.',
                'Assess which loads can be shifted into daylight hours, such as EV charging, hot water, or laundry.',
            ],
        ],
    ]);

    $faqItems = $isZh ? [
        ['q' => '荷兰净计量是逐步 afbouw 到 2031 吗？', 'a' => '不是。当前官方口径是 salderingsregeling 自 2027 年 1 月 1 日起停止。2030 相关的是最低回馈补偿保护期限，不是净计量还可以持续到 2030 或 2031。'],
        ['q' => '2027 年后太阳能是否就不划算了？', 'a' => '不一定。2027 年后回报更多取决于自发自用比例、合同补偿价和是否有额外 terugleverkosten。对高白天用电家庭，回报依然可能健康。'],
        ['q' => '2027 年后我还能把电卖回电网吗？', 'a' => '可以。变化在于不再 1:1 抵扣，而是由能源供应商按回馈补偿机制支付。'],
        ['q' => '为什么 2030 这个日期也常被提到？', 'a' => '因为到 2030 年 1 月 1 日前，供应商对超额回馈电量仍需至少支付裸电价 50% 的补偿。这个日期不是 salderen 的结束日期。'],
    ] : ($isNl ? [
        ['q' => 'Wordt de salderingsregeling geleidelijk afgebouwd tot 2031?', 'a' => 'Nee. De huidige officiele lijn is dat de salderingsregeling stopt op 1 januari 2027. De datum 2030 hoort bij de minimale terugleververgoeding en is dus niet de datum waarop salderen nog zou doorlopen.'],
        ['q' => 'Zijn zonnepanelen na 2027 dan niet meer rendabel?', 'a' => 'Niet per definitie. Na 2027 hangen rendement en terugverdientijd sterker af van direct eigen verbruik, de terugleververgoeding in uw contract en eventuele terugleverkosten.'],
        ['q' => 'Mag ik na 2027 nog stroom terugleveren aan het net?', 'a' => 'Ja. Wat verandert, is de manier waarop die stroom financieel wordt gewaardeerd. U krijgt dan een vergoeding in plaats van volledige jaarlijkse verrekening.'],
        ['q' => 'Waarom wordt 2030 dan zo vaak genoemd?', 'a' => 'Omdat leveranciers tot 1 januari 2030 voor overtollige teruglevering minimaal 50% van het kale leveringstarief moeten betalen. Dat is iets anders dan de stopdatum van salderen zelf.'],
    ] : [
        ['q' => 'Is Dutch net metering phased out gradually through 2031?', 'a' => 'No. The current official position is that the Dutch salderingsregeling ends on January 1, 2027. The 2030 date relates to minimum export compensation, not continued full netting.'],
        ['q' => 'Does solar stop being worth it after 2027?', 'a' => 'Not necessarily. After 2027, payback depends more on self-consumption, supplier compensation rates, and any export-related charges.'],
        ['q' => 'Can households still export electricity after 2027?', 'a' => 'Yes. The change is that exported electricity is compensated instead of being fully netted out annually at the retail supply rate.'],
        ['q' => 'Why is 2030 often mentioned in the same discussion?', 'a' => 'Because until January 1, 2030, suppliers must compensate excess exports at a minimum of 50% of the bare supply tariff. That is separate from the 2027 end date for netting itself.'],
    ]);

    $officialLinks = collect(config('site.official_links', []))->map(function ($link) use ($locale) {
        return [
            'title' => $link['title'][$locale] ?? $link['title']['en'],
            'description' => $link['description'][$locale] ?? $link['description']['en'],
            'source' => $link['source'] ?? null,
            'updated_at' => $link['updated_at'] ?? null,
            'url' => $link['url'],
        ];
    });
@endphp

@section('title', $pageTitle)
@section('description', $pageDescription)
@section('keywords', $pageKeywords)
@section('image', asset('og/salderinggids-share.svg'))

@push('styles')
<style>
    .policy-hero {
        background:
            radial-gradient(circle at top left, rgba(104, 175, 255, 0.24), transparent 32%),
            radial-gradient(circle at right 22%, rgba(47, 115, 255, 0.26), transparent 28%),
            linear-gradient(135deg, #eef5ff 0%, #ffffff 46%, #f4f8fc 100%);
    }
</style>
@endpush

@section('content')
<main class="pb-20">
    <section class="policy-hero border-b border-[#dce5f1]">
        <div class="mx-auto grid max-w-[1280px] gap-10 px-6 py-12 lg:grid-cols-[minmax(0,1.25fr)_360px] lg:px-10 lg:py-20">
            <div>
                <span class="inline-flex rounded-full border border-[#cfe0fb] bg-white px-4 py-1.5 text-xs font-bold uppercase tracking-[0.24em] text-[#2f73ff]">
                    {{ $hero['eyebrow'] }}
                </span>
                <h1 class="mt-6 max-w-4xl text-4xl font-black leading-[1.05] tracking-tight text-[#12315f]">
                    {{ $hero['title'] }}
                </h1>
                <p class="mt-6 max-w-3xl text-lg leading-8 text-[#506987]">
                    {{ $hero['description'] }}
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('index') }}#calculator" class="inline-flex h-12 items-center justify-center rounded-2xl bg-[#12315f] px-5 text-sm font-semibold text-white transition-colors hover:bg-[#0e294f]">
                        {{ $hero['primary'] }}
                    </a>
                    <a href="{{ route('articles') }}" class="inline-flex h-12 items-center justify-center rounded-2xl border border-[#c7dafd] bg-white px-5 text-sm font-semibold text-[#12315f] transition-colors hover:bg-[#f7fbff]">
                        {{ $hero['secondary'] }}
                    </a>
                </div>
            </div>

            <aside class="rounded-[2rem] border border-[#dce5f1] bg-white p-6 shadow-xl shadow-blue-100/40">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#2f73ff]">{{ $hero['direct_label'] }}</p>
                <h2 class="mt-3 text-2xl font-black tracking-tight text-[#12315f]">{{ $hero['direct_answer'] }}</h2>
                <div class="mt-6 space-y-4">
                    @foreach($facts as $fact)
                        <div class="rounded-3xl border border-[#e7eef7] bg-[#fbfdff] p-4">
                            <div class="flex items-center justify-between gap-3">
                                <p class="text-sm font-bold text-[#12315f]">{{ $fact['label'] }}</p>
                                <span class="rounded-full bg-[#12315f] px-3 py-1 text-xs font-semibold text-white">{{ $fact['value'] }}</span>
                            </div>
                            <p class="mt-2 text-sm leading-6 text-[#5f7698]">{{ $fact['text'] }}</p>
                        </div>
                    @endforeach
                </div>
            </aside>
        </div>
    </section>

    <section class="mx-auto max-w-[1280px] px-6 py-16 lg:px-10">
        <div class="grid gap-6 lg:grid-cols-3">
            @foreach($sections as $section)
                <article class="rounded-[2rem] border border-[#dbe4f0] bg-white p-6 shadow-sm">
                    <h2 class="text-2xl font-black tracking-tight text-[#12315f]">{{ $section['title'] }}</h2>
                    <ul class="mt-5 space-y-3 text-sm leading-7 text-[#5f7698]">
                        @foreach($section['items'] as $item)
                            <li class="flex gap-3">
                                <span class="mt-1 text-[#2f73ff]">•</span>
                                <span>{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>
                </article>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-[1280px] px-6 py-4 lg:px-10">
        <div class="rounded-[2rem] border border-[#dbe4f0] bg-[#f8fbff] p-6 md:p-8">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#2f73ff]">{{ $isZh ? '下一步' : ($isNl ? 'Volgende stap' : 'Next step') }}</p>
                    <h2 class="mt-2 text-3xl font-black tracking-tight text-[#12315f]">
                        {{ $isZh ? '先确认事实，再进入测算、合同与解决方案' : ($isNl ? 'Bevestig eerst de feiten en ga dan pas naar rekentools, contracten en oplossingen' : 'Confirm the facts first, then move into calculators, contract comparison, and solutions') }}
                    </h2>
                </div>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-3">
                <a href="{{ route('index') }}#calculator" class="rounded-3xl border border-[#dbe4f0] bg-white p-5 transition-all hover:-translate-y-0.5 hover:border-[#c6d8fb]">
                    <p class="text-sm font-bold text-[#12315f]">{{ $isZh ? '收益计算器' : ($isNl ? 'Salderingscalculator' : 'Net metering calculator') }}</p>
                    <p class="mt-2 text-sm leading-6 text-[#5f7698]">{{ $isZh ? '估算当前规则与 2027 年后的年度价值差异。' : ($isNl ? 'Schat het verschil in jaarwaarde tussen de huidige regels en het regime na 2027.' : 'Estimate the annual value difference between the current rules and the post-2027 regime.') }}</p>
                </a>
                <a href="{{ route('guides') }}" class="rounded-3xl border border-[#dbe4f0] bg-white p-5 transition-all hover:-translate-y-0.5 hover:border-[#c6d8fb]">
                    <p class="text-sm font-bold text-[#12315f]">{{ $isZh ? '实用指南' : ($isNl ? 'Praktische gidsen' : 'Practical guides') }}</p>
                    <p class="mt-2 text-sm leading-6 text-[#5f7698]">{{ $isZh ? '继续看合同、白天用电、热水和 EV 充电等具体策略。' : ($isNl ? 'Lees verder over contracten, dagverbruik, warm water en EV-laden als concrete vervolgstappen.' : 'Move into concrete strategies around contracts, daytime usage, hot water, and EV charging.') }}</p>
                </a>
                <a href="{{ route('news') }}" class="rounded-3xl border border-[#dbe4f0] bg-white p-5 transition-all hover:-translate-y-0.5 hover:border-[#c6d8fb]">
                    <p class="text-sm font-bold text-[#12315f]">{{ $isZh ? '政策与市场更新' : ($isNl ? 'Beleids- en marktupdates' : 'Policy and market updates') }}</p>
                    <p class="mt-2 text-sm leading-6 text-[#5f7698]">{{ $isZh ? '持续跟踪官方表述、监管变化和供应商回馈政策。' : ($isNl ? 'Volg doorlopend wijzigingen in officiele communicatie, toezicht en leveranciersvoorwaarden.' : 'Track ongoing changes in official communication, regulation, and supplier policy.') }}</p>
                </a>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-[1280px] px-6 py-16 lg:px-10">
        <div class="mb-8 flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#2f73ff]">{{ $isZh ? '权威来源' : ($isNl ? 'Bronnen' : 'Sources') }}</p>
                <h2 class="mt-2 text-3xl font-black tracking-tight text-[#12315f]">
                    {{ $isZh ? '把政策出处放在结论旁边' : ($isNl ? 'Zet de bron direct naast de conclusie' : 'Keep the source next to the conclusion') }}
                </h2>
            </div>
        </div>
        <div class="grid gap-5 lg:grid-cols-2">
            @foreach($officialLinks as $link)
                <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer" class="rounded-[2rem] border border-[#dbe4f0] bg-white p-6 shadow-sm transition-all hover:-translate-y-1 hover:border-[#c6d8fb] hover:bg-[#fbfdff]">
                    <div class="flex flex-wrap items-center gap-2">
                        @if($link['source'])
                            <span class="rounded-full bg-[#edf4ff] px-2.5 py-1 text-[11px] font-semibold text-[#2f73ff]">{{ $link['source'] }}</span>
                        @endif
                        @if($link['updated_at'])
                            <span class="text-[11px] text-[#7a8faa]">{{ $isZh ? '更新于' : ($isNl ? 'Bijgewerkt' : 'Updated') }} {{ $link['updated_at'] }}</span>
                        @endif
                    </div>
                    <h3 class="mt-4 text-lg font-black text-[#12315f]">{{ $link['title'] }}</h3>
                    <p class="mt-3 text-sm leading-7 text-[#5f7698]">{{ $link['description'] }}</p>
                </a>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-[980px] px-6 py-4 lg:px-10">
        <div class="rounded-[2rem] border border-[#dbe4f0] bg-white p-6 md:p-8">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#2f73ff]">{{ $isZh ? 'FAQ' : 'FAQ' }}</p>
            <h2 class="mt-2 text-3xl font-black tracking-tight text-[#12315f]">
                {{ $isZh ? '关于 2027 停止净计量，最常见的 4 个问题' : ($isNl ? 'De 4 meest gestelde vragen over het einde van salderen in 2027' : 'The 4 most common questions about the 2027 end of Dutch net metering') }}
            </h2>

            <div class="mt-8 space-y-4">
                @foreach($faqItems as $faq)
                    <article class="rounded-3xl border border-[#e7eef7] bg-[#fbfdff] p-5">
                        <h3 class="text-lg font-bold text-[#12315f]">{{ $faq['q'] }}</h3>
                        <p class="mt-3 text-sm leading-7 text-[#5f7698]">{{ $faq['a'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
</main>
@endsection

@push('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "AboutPage",
      "@id": "{{ request()->url() }}#aboutpage",
      "url": "{{ request()->url() }}",
      "name": "{{ $pageTitle }}",
      "description": "{{ $pageDescription }}",
      "inLanguage": "{{ $isZh ? 'zh-CN' : ($isNl ? 'nl-NL' : 'en') }}",
      "isPartOf": {
        "@id": "{{ rtrim(config('app.url', 'https://salderinggids.nl'), '/') }}/#website"
      }
    },
    {
      "@type": "BreadcrumbList",
      "@id": "{{ request()->url() }}#breadcrumb",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "{{ $isZh ? '首页' : ($isNl ? 'Home' : 'Home') }}",
          "item": "{{ route('index') }}"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "{{ $isZh ? '2027 政策事实页' : ($isNl ? 'Feitenpagina 2027' : '2027 fact page') }}"
        }
      ]
    },
    {
      "@type": "FAQPage",
      "@id": "{{ request()->url() }}#faq",
      "mainEntity": [
        @foreach($faqItems as $faq)
        {
          "@type": "Question",
          "name": @json($faq['q']),
          "acceptedAnswer": {
            "@type": "Answer",
            "text": @json($faq['a'])
          }
        }@if(!$loop->last),@endif
        @endforeach
      ]
    }
  ]
}
</script>
@endpush
