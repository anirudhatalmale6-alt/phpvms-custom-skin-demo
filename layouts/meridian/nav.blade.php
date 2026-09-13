<nav class="navbar navbar-expand-lg bg-primary py-3" data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
            <i class="bi bi-airplane-fill" style="color: var(--va-accent); font-size: 1.35rem; transform: rotate(45deg);"></i>
            <span>
                <span class="va-wordmark d-block">Meridian<span>Virtual</span></span>
                <span class="va-callsign">MRD &middot; Virtual Airline</span>
            </span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                @if (Auth::check())
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link d-flex gap-1" href="{{ route('frontend.dashboard.index') }}">
                            <i class="bi bi-speedometer2"></i>
                            @lang('common.dashboard')
                        </a>
                    </li>
                @endif

                <li class="nav-item d-flex align-items-center">
                    <a class="nav-link d-flex gap-1" href="{{ route('frontend.livemap.index') }}">
                        <i class="bi bi-globe"></i>
                        @lang('common.livemap')
                    </a>
                </li>

                <li class="nav-item d-flex align-items-center">
                    <a class="nav-link d-flex gap-1" href="{{ route('frontend.pilots.index') }}">
                        <i class="bi bi-people"></i>
                        {{ trans_choice('common.pilot', 2) }}
                    </a>
                </li>

                {{-- Show the module links that don't require being logged in --}}
                @foreach ($moduleSvc->getFrontendLinks($logged_in = false) as &$link)
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link d-flex gap-1" href="{{ url($link['url']) }}">
                            <i class="{{ $link['icon'] }}"></i>
                            {{ $link['title'] }}
                        </a>
                    </li>
                @endforeach

                @foreach ($page_links as $page)
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link d-flex gap-1" href="{{ $page->url }}"
                            target="{{ $page->new_window ? '_blank' : '_self' }}">
                            <i class="{{ $page['icon'] }}"></i>
                            {{ $page['name'] }}
                        </a>
                    </li>
                @endforeach

                @if (!Auth::check())
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link d-flex gap-1" href="{{ url('/login') }}">
                            <i class="bi bi-box-arrow-in-right"></i>
                            @lang('common.login')
                        </a>
                    </li>
                    <li class="nav-item d-flex align-items-center ms-lg-2">
                        <a class="btn btn-accent btn-sm px-3 d-flex gap-1 align-items-center"
                            href="{{ url('/register') }}">
                            <i class="bi bi-person-vcard"></i>
                            @lang('common.register')
                        </a>
                    </li>
                @else
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link d-flex gap-1" href="{{ route('frontend.flights.index') }}">
                            <i class="bi bi-airplane"></i>
                            {{ trans_choice('common.flight', 2) }}
                        </a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link d-flex gap-1" href="{{ route('frontend.downloads.index') }}">
                            <i class="bi bi-download"></i>
                            {{ trans_choice('common.download', 2) }}
                        </a>
                    </li>

                    {{-- Show the module links for being logged in --}}
                    @foreach ($moduleSvc->getFrontendLinks($logged_in = true) as &$link)
                        <li class="nav-item d-flex align-items-center">
                            <a class="nav-link d-flex gap-1" href="{{ url($link['url']) }}">
                                <i class="{{ $link['icon'] }}"></i>
                                {{ $link['title'] }}
                            </a>
                        </li>
                    @endforeach

                    <li class="nav-item dropdown ms-lg-2">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                            id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" data-boundary="viewport"
                            aria-haspopup="true" aria-expanded="false">
                            @if (Auth::user()->avatar == null)
                                <img src="{{ Auth::user()->gravatar(38) }}"
                                    style="height: 38px; width: 38px; border-radius: 50%; border: 2px solid var(--va-accent);">
                            @else
                                <img src="{{ Auth::user()->avatar->url }}"
                                    style="height: 38px; width: 38px; border-radius: 50%; border: 2px solid var(--va-accent);">
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('frontend.profile.index') }}">
                                <i class="bi bi-person"></i>&nbsp;&nbsp;@lang('common.profile')
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('frontend.pireps.index') }}">
                                <i class="bi bi-journal-check"></i>&nbsp;&nbsp;{{ trans_choice('common.pirep', 2) }}
                            </a>
                            <a class="dropdown-item" href="{{ route('frontend.flights.bids') }}">
                                <i class="bi bi-bookmark-check"></i>&nbsp;&nbsp;{{ trans_choice('flights.mybid', 2) }}
                            </a>
                            <div class="dropdown-divider"></div>
                            @can('access_admin')
                                <a class="dropdown-item" href="{{ url('/admin') }}">
                                    <i class="bi bi-gear"></i>&nbsp;&nbsp;@lang('common.administration')
                                </a>
                                <div class="dropdown-divider"></div>
                            @endcan
                            <a class="dropdown-item" href="{{ url('/logout') }}">
                                <i class="bi bi-box-arrow-right"></i>&nbsp;&nbsp;@lang('common.logout')
                            </a>
                        </div>
                    </li>
                @endif

                <li class="nav-item dropdown my-0 my-md-auto ms-lg-2">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                        <span class="fi fi-{{ $languages[$locale]['flag-icon'] }}"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        @foreach ($languages as $lang => $language)
                            @if ($lang != $locale)
                                <a class="dropdown-item" href="{{ route('frontend.lang.switch', $lang) }}">
                                    <span
                                        class="fi fi-{{ $language['flag-icon'] }}"></span>&nbsp;&nbsp;{{ $language['display'] }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </li>
                <li class="nav-item dropdown my-0 my-md-auto">
                    <button class="btn btn-link nav-link py-2 px-0 px-lg-2 dropdown-toggle d-flex align-items-center"
                        id="bd-theme" type="button" aria-expanded="true" data-bs-toggle="dropdown"
                        data-bs-display="static" aria-label="Toggle theme (light)">
                        <i class="bi-sun-fill" id="theme-icon-active"></i>
                        <span class="d-lg-none ms-2" id="bd-theme-text">@lang('common.toggleColors')</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="bd-theme-text"
                        data-bs-popper="static">
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center active"
                                data-bs-theme-value="light" aria-pressed="true">
                                <i class="bi-sun-fill"></i>
                                &nbsp;@lang('common.light')
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center"
                                data-bs-theme-value="dark" aria-pressed="false">
                                <i class="bi-moon-stars-fill"></i>
                                &nbsp;@lang('common.dark')
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center"
                                data-bs-theme-value="system" aria-pressed="false">
                                <i class="bi-circle-half"></i>
                                &nbsp;@lang('common.auto')
                            </button>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
