<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php
    $siteName = config('site.name', config('app.name', 'SalderingGids'));
    $siteDomain = config('site.domain', parse_url(config('app.url'), PHP_URL_HOST));
    $siteUrl = rtrim(config('app.url', 'https://salderinggids.nl'), '/');
    $locale = app()->getLocale();
    $metaTitle = trim($__env->yieldContent('title')) ?: ($locale === 'zh' ? 'SalderingGids 荷兰净计量专题' : ($locale === 'nl' ? 'SalderingGids Nederlandse salderingsgids' : 'SalderingGids Dutch net metering guide'));
    $metaDescription = trim($__env->yieldContent('description')) ?: ($locale === 'zh'
        ? '荷兰净计量、回馈补偿、太阳能合同和 2027 政策变化的专题内容站。'
        : ($locale === 'nl'
            ? 'Een themasite over de Nederlandse salderingsregeling, terugleververgoeding, zonne-energiecontracten en de wijziging vanaf 2027.'
            : 'A focused site about Dutch net metering, feed-in compensation, solar contracts, and the 2027 policy transition.'));
    $metaKeywords = trim($__env->yieldContent('keywords')) ?: 'salderingsregeling, zonnepanelen, terugleververgoeding, energiecontract, net metering';
    $metaImage = trim($__env->yieldContent('image')) ?: asset('og/salderinggids-share.svg');
    $ogLocale = $locale === 'zh' ? 'zh_CN' : ($locale === 'nl' ? 'nl_NL' : 'en_GB');
    $orgDescription = $locale === 'zh'
        ? 'SalderingGids 是聚焦荷兰净计量、太阳能回馈补偿和家庭能源合同变化的专题内容站。'
        : ($locale === 'nl'
            ? 'SalderingGids is een gespecialiseerde themasite over de Nederlandse salderingsregeling, terugleververgoedingen en energiecontracten voor huishoudens.'
            : 'SalderingGids is a focused content site about Dutch net metering, solar feed-in compensation, and household energy contracts.');
    $searchTarget = route('articles') . '?search={search_term_string}';
@endphp
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO meta tags -->
    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="keywords" content="{{ $metaKeywords }}">
    <meta name="author" content="{{ $siteDomain }}">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="{{ request()->url() }}" />

    <!-- Hreflang alternate links -->
    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    <link rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}" />
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ LaravelLocalization::getLocalizedURL(config('laravellocalization.defaultLocale', 'en')) }}" />

    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:locale" content="{{ $ogLocale }}">
    <meta property="og:image" content="{{ $metaImage }}">
    <meta property="og:image:alt" content="{{ $metaTitle }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $metaImage }}">

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "Organization",
          "@id": "{{ $siteUrl }}/#organization",
          "name": "{{ $siteName }}",
          "url": "{{ $siteUrl }}/",
          "description": "{{ $orgDescription }}"
        },
        {
          "@type": "WebSite",
          "@id": "{{ $siteUrl }}/#website",
          "url": "{{ $siteUrl }}/",
          "name": "{{ $siteName }}",
          "inLanguage": "{{ $ogLocale }}",
          "potentialAction": {
            "@type": "SearchAction",
            "target": "{{ $searchTarget }}",
            "query-input": "required name=search_term_string"
          },
          "publisher": {
            "@id": "{{ $siteUrl }}/#organization"
          }
        },
        {
          "@type": "WebPage",
          "@id": "{{ request()->url() }}#webpage",
          "url": "{{ request()->url() }}",
          "name": "{{ $metaTitle }}",
          "description": "{{ $metaDescription }}",
          "isPartOf": {
            "@id": "{{ $siteUrl }}/#website"
          },
          "inLanguage": "{{ $ogLocale }}"
        }
      ]
    }
    </script>
    @stack('schema')

    <!-- Favicon (SVG) -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg fill='%23135bec' viewBox='0 0 48 48' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath clip-rule='evenodd' d='M24 18.4228L42 11.475V34.3663C42 34.7796 41.7457 35.1504 41.3601 35.2992L24 42V18.4228Z' fill-rule='evenodd'/%3E%3Cpath clip-rule='evenodd' d='M24 8.18819L33.4123 11.574L24 15.2071L14.5877 11.574L24 8.18819ZM9 15.8487L21 20.4805V37.6263L9 32.9945V15.8487ZM27 37.6263V20.4805L39 15.8487V32.9945L27 37.6263ZM25.354 2.29885C24.4788 1.98402 23.5212 1.98402 22.646 2.29885L4.98454 8.65208C3.7939 9.08038 3 10.2097 3 11.475V34.3663C3 36.0196 4.01719 37.5026 5.55962 38.098L22.9197 44.7987C23.6149 45.0671 24.3851 45.0671 25.0803 44.7987L42.4404 38.098C43.9828 37.5026 45 36.0196 45 34.3663V11.475C45 10.2097 44.2061 9.08038 43.0155 8.65208L25.354 2.29885Z' fill-rule='evenodd'/%3E%3C/svg%3E">
    <link rel="apple-touch-icon" href="data:image/svg+xml,%3Csvg fill='%23135bec' viewBox='0 0 48 48' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath clip-rule='evenodd' d='M24 18.4228L42 11.475V34.3663C42 34.7796 41.7457 35.1504 41.3601 35.2992L24 42V18.4228Z' fill-rule='evenodd'/%3E%3Cpath clip-rule='evenodd' d='M24 8.18819L33.4123 11.574L24 15.2071L14.5877 11.574L24 8.18819ZM9 15.8487L21 20.4805V37.6263L9 32.9945V15.8487ZM27 37.6263V20.4805L39 15.8487V32.9945L27 37.6263ZM25.354 2.29885C24.4788 1.98402 23.5212 1.98402 22.646 2.29885L4.98454 8.65208C3.7939 9.08038 3 10.2097 3 11.475V34.3663C3 36.0196 4.01719 37.5026 5.55962 38.098L22.9197 44.7987C23.6149 45.0671 24.3851 45.0671 25.0803 44.7987L42.4404 38.098C43.9828 37.5026 45 36.0196 45 34.3663V11.475C45 10.2097 44.2061 9.08038 43.0155 8.65208L25.354 2.29885Z' fill-rule='evenodd'/%3E%3C/svg%3E">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!-- Preconnect to Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Google Material Icons (async) -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" media="print" onload="this.media='all'"/>

    <!-- Space Grotesk Font (async) -->
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet" media="print" onload="this.media='all'"/>

    <!-- Tailwind Config -->
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#135bec",
                        "background-light": "#f6f6f8",
                        "background-dark": "#101622",
                    },
                    fontFamily: {
                        "display": ["Space Grotesk", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>

    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        body {
            font-family: 'Space Grotesk', sans-serif;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-background-light dark:bg-background-dark text-[#111318] dark:text-white transition-colors duration-200">
    <div class="layout-container flex h-full grow flex-col">

        <!-- Header -->
        @include('layouts.stitch.header')

        <!-- Main Content -->
        <main class="flex-1">
            @yield('content')
        </main>

        <!-- Footer -->
        @include('layouts.stitch.footer')

    </div>

    @include('layouts.stitch.script')

    @stack('scripts')
</body>
</html>
