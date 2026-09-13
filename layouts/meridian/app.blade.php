<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />

    <title>@yield('title') - {{ config('app.name') }}</title>
    <script>
        // Check for saved user preference, if any, on initial load
        (function() {
            if (localStorage.getItem('theme') === 'dark' || ((!localStorage.getItem('theme') || localStorage.getItem(
                    'theme') === 'system') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.setAttribute('data-bs-theme', "dark")
            }
        })();
    </script>

    {{-- Start of required lines block. DON'T REMOVE THESE LINES! They're required or might break things --}}
    <meta name="base-url" content="{!! url('') !!}">
    <meta name="api-key" content="{!! Auth::check() ? Auth::user()->api_key : '' !!}">
    <meta name="csrf-token" content="{!! csrf_token() !!}">
    {{-- End the required lines block --}}

    <link rel="shortcut icon" type="image/png" href="{{ public_asset('/assets/img/favicon.png') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cookieconsent/3.1.1/cookieconsent.min.css"
        integrity="sha512-LQ97camar/lOliT/MqjcQs5kWgy6Qz/cCRzzRzUCfv0fotsCTC9ZHXaPQmJV8Xu/PVALfJZ7BDezl5lW3/qBxg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css" />
    <link href="{{ public_asset('/assets/vendor/tomselect/tom-select.bootstrap5.css') }}" rel="stylesheet">

    {{-- Start of the required files in the head block --}}
    @yield('css')
    @yield('scripts_head')
    {{-- End of the required stuff in the head block --}}

    {{-- The whole skin is driven by these few variables. Swap them for the VA's own
         colours and the entire site follows - nav, buttons, badges, tables, charts. --}}
    <style>
        :root {
            --va-navy: #0b1f3a;
            --va-navy-deep: #071429;
            --va-accent: #f0a500;
            --va-accent-dark: #c98700;
            --va-ink: #16202e;
            --bs-primary: #0b1f3a;
            --bs-primary-rgb: 11, 31, 58;
            --bs-body-font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        [data-bs-theme=light] {
            --bs-primary: #0b1f3a;
            --bs-body-bg: #f5f7fa;
        }

        [data-bs-theme=dark] {
            --va-navy: #0e2f52;
            --bs-primary: #12365f;
        }

        body {
            font-family: var(--bs-body-font-family);
        }

        h1, h2, h3, .va-display {
            font-family: 'Barlow Condensed', 'Inter', sans-serif;
            letter-spacing: .02em;
            text-transform: uppercase;
            font-weight: 700;
        }

        .bg-primary {
            background-color: var(--va-navy) !important;
        }

        .btn-primary {
            background-color: var(--va-navy) !important;
            border-color: var(--va-navy) !important;
        }

        .btn-primary:hover {
            background-color: var(--va-navy-deep) !important;
            border-color: var(--va-navy-deep) !important;
        }

        .btn-accent {
            background-color: var(--va-accent);
            border-color: var(--va-accent);
            color: var(--va-navy-deep);
            font-weight: 600;
        }

        .btn-accent:hover {
            background-color: var(--va-accent-dark);
            border-color: var(--va-accent-dark);
            color: #fff;
        }

        .navbar .nav-link:hover {
            color: var(--va-accent) !important;
        }

        .va-wordmark {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 700;
            font-size: 1.45rem;
            letter-spacing: .12em;
            color: #fff;
            text-transform: uppercase;
            line-height: 1;
        }

        .va-wordmark span {
            color: var(--va-accent);
        }

        .va-callsign {
            font-size: .62rem;
            letter-spacing: .28em;
            color: rgba(255, 255, 255, .65);
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            text-transform: uppercase;
        }

        /* Hero ------------------------------------------------------------ */
        .va-hero {
            background:
                linear-gradient(115deg, rgba(7, 20, 41, .94) 0%, rgba(11, 31, 58, .86) 45%, rgba(11, 31, 58, .55) 100%),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='1600' height='600'%3E%3Cdefs%3E%3ClinearGradient id='s' x1='0' y1='0' x2='1' y2='1'%3E%3Cstop offset='0' stop-color='%231b4c86'/%3E%3Cstop offset='1' stop-color='%23071429'/%3E%3C/linearGradient%3E%3C/defs%3E%3Crect width='1600' height='600' fill='url(%23s)'/%3E%3Cg fill='none' stroke='%23ffffff' stroke-opacity='.10'%3E%3Cpath d='M0 470 C 320 330 640 520 960 360 S 1440 180 1600 240'/%3E%3Cpath d='M0 520 C 360 420 700 560 1040 420 S 1460 260 1600 310'/%3E%3C/g%3E%3C/svg%3E");
            background-size: cover;
            background-position: center;
            color: #fff;
            padding: 4.5rem 0 3rem;
            margin-top: -1.5rem;
        }

        .va-hero h1 {
            font-size: clamp(2.2rem, 5vw, 3.6rem);
            margin-bottom: .75rem;
        }

        .va-hero .lead {
            max-width: 44rem;
            color: rgba(255, 255, 255, .8);
        }

        .va-rule {
            width: 64px;
            height: 4px;
            background: var(--va-accent);
            margin-bottom: 1.25rem;
        }

        /* KPI strip -------------------------------------------------------- */
        .va-kpis {
            margin-top: 2.5rem;
        }

        .va-kpi {
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: .5rem;
            padding: 1rem 1.1rem;
            height: 100%;
        }

        .va-kpi .val {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 2.1rem;
            font-weight: 700;
            line-height: 1;
            color: var(--va-accent);
        }

        .va-kpi .lbl {
            font-size: .72rem;
            letter-spacing: .16em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .7);
            margin-top: .35rem;
        }

        /* Section headers -------------------------------------------------- */
        .va-section-title {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin: 2.5rem 0 1rem;
        }

        .va-section-title h2 {
            margin: 0;
            font-size: 1.5rem;
        }

        .va-section-title .line {
            flex: 1;
            height: 1px;
            background: rgba(0, 0, 0, .12);
        }

        [data-bs-theme=dark] .va-section-title .line {
            background: rgba(255, 255, 255, .15);
        }

        /* Pilot cards ------------------------------------------------------ */
        .va-pilot {
            border: 1px solid rgba(0, 0, 0, .08);
            border-radius: .5rem;
            background: var(--bs-body-bg);
            overflow: hidden;
            height: 100%;
            transition: transform .15s ease, box-shadow .15s ease;
        }

        .va-pilot:hover {
            transform: translateY(-2px);
            box-shadow: 0 .5rem 1.25rem rgba(11, 31, 58, .14);
        }

        .va-pilot .head {
            background: var(--va-navy);
            color: #fff;
            padding: .9rem 1rem;
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .va-pilot .head img {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: 2px solid var(--va-accent);
        }

        .va-pilot .head .nm {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.15rem;
            font-weight: 600;
            text-transform: uppercase;
            line-height: 1.1;
        }

        .va-pilot .head .sub {
            font-size: .7rem;
            letter-spacing: .14em;
            color: rgba(255, 255, 255, .6);
            text-transform: uppercase;
        }

        .va-pilot .body {
            padding: .85rem 1rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .va-pilot .body .base {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--va-navy);
            line-height: 1;
        }

        [data-bs-theme=dark] .va-pilot .body .base {
            color: #9fc4f0;
        }

        .va-pilot .body .base small {
            display: block;
            font-family: 'Inter', sans-serif;
            font-size: .65rem;
            letter-spacing: .16em;
            font-weight: 500;
            color: var(--bs-secondary-color);
            text-transform: uppercase;
        }

        .va-badge-accent {
            background: var(--va-accent);
            color: var(--va-navy-deep);
            font-weight: 600;
            letter-spacing: .06em;
        }

        footer.va-footer {
            background: var(--va-navy-deep);
            color: rgba(255, 255, 255, .65);
            border-top: 3px solid var(--va-accent);
        }

        footer.va-footer a {
            color: #fff;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <div class="wrapper d-flex flex-column min-vh-100">
        @include('nav')
        @yield('hero')
        <div class="body container flex-grow-1 pt-4">
            {{-- These should go where you want your content to show up --}}
            @include('flash.message')
            @yield('content')
            {{-- End the above block --}}

        </div>
        <footer class="va-footer py-4 mt-4">
            <div class="container d-flex flex-wrap justify-content-between align-items-center">
                <div class="col-md-6 d-flex align-items-center">
                    <span class="mb-2 mb-md-0">&copy; {{ date('Y') }} {{ config('app.name') }} &mdash; a virtual
                        airline. Not affiliated with any real-world operator.</span>
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-md-end">
                    <span class="mb-2 mb-md-0 text-md-end">Powered by <a href="https://www.phpvms.net"
                            target="_blank">phpVMS</a></span>
                </div>
            </div>
        </footer>
    </div>

    {{-- External Redirects Modal --}}
    @include('external_redirect_modal')

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.1/dist/js/tom-select.complete.min.js"></script>

    <script>
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
    </script>

    {{-- Start of the required tags block. Don't remove these or things will break!! --}}
    <script src="{{ public_mix('/assets/global/js/vendor.js') }}"></script>
    <script src="{{ public_mix('/assets/frontend/js/vendor.js') }}"></script>
    <script src="{{ public_mix('/assets/frontend/js/app.js') }}"></script>
    @yield('scripts')

    {{-- This is the color theme switcher --}}
    @include('scripts.bs_theme')

    <script>
        window.addEventListener("load", function() {
            window.cookieconsent.initialise({
                palette: {
                    popup: {
                        background: "#071429",
                        text: "#dfe6ef"
                    },
                    button: {
                        "background": "#f0a500",
                        "text": "#071429"
                    }
                },
                position: "bottom",
            })
        });
    </script>
    {{-- End the required tags block --}}

    @php
        $gtag = setting('general.google_analytics_id');
    @endphp
    @if ($gtag)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gtag }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', '{{ $gtag }}');
        </script>
    @endif

</body>

</html>
