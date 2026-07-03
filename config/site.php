<?php

return [
    'name' => env('APP_NAME', 'SalderingGids'),
    'domain' => env('SITE_DOMAIN', 'salderinggids.nl'),
    'official_links' => [
        [
            'title' => [
                'en' => 'Rijksoverheid: Salderingsregeling stops in 2027',
                'zh' => '荷兰政府：净计量将于 2027 年结束',
            ],
            'description' => [
                'en' => 'Official government overview of the Dutch net metering scheme, including the end date and the 2027 transition.',
                'zh' => '荷兰政府关于净计量制度的官方说明，包含结束时间和 2027 年后的变化。',
            ],
            'url' => 'https://www.rijksoverheid.nl/themas/klimaat-milieu-en-natuur/energie-thuis/salderingsregeling',
        ],
        [
            'title' => [
                'en' => 'ACM ConsuWijzer: Salderen and feed-in compensation',
                'zh' => 'ACM 消费者指南：净计量与回馈电价',
            ],
            'description' => [
                'en' => 'Consumer guidance on annual settlement, excess feed-in, and the minimum compensation rules after 2027.',
                'zh' => '消费者视角的年度结算、超额回馈与 2027 年后最低补偿规则说明。',
            ],
            'url' => 'https://consument.acm.nl/elektriciteit-en-gas/duurzame-energie/wat-is-salderen',
        ],
        [
            'title' => [
                'en' => 'ACM ConsuWijzer: Feed-in, contract terms and smart meter rules',
                'zh' => 'ACM 消费者指南：回馈电力、合同条款与智能电表',
            ],
            'description' => [
                'en' => 'Explains how to register feed-in, compare contracts, and prepare for smart meter requirements from 2026.',
                'zh' => '介绍如何申报回馈电力、比较合同，并了解 2026 年起的智能电表要求。',
            ],
            'url' => 'https://consument.acm.nl/elektriciteit-en-gas/duurzame-energie/teruglevering-van-elektriciteit',
        ],
        [
            'title' => [
                'en' => 'Rijksoverheid: Financing, 0% VAT and solar support',
                'zh' => '荷兰政府：太阳能融资、0% 增值税与支持政策',
            ],
            'description' => [
                'en' => 'Government page about solar financing options, 0% VAT on qualifying residential installations, and related support.',
                'zh' => '荷兰政府关于太阳能融资、住宅光伏 0% 增值税和相关支持政策的页面。',
            ],
            'url' => 'https://www.rijksoverheid.nl/vraag-en-antwoord/energie-thuis/krijg-ik-subsidie-voor-zonnepanelen',
        ],
    ],
    'fallback_tags' => [
        'salderingsregeling',
        'zonnepanelen',
        'terugleververgoeding',
        'energiecontract',
        'slimme-meter',
    ],
];
