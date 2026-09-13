@extends('app')
@section('title', __('home.welcome.title'))

@php
    use App\Models\Aircraft;
    use App\Models\Airport;
    use App\Models\Enums\PirepState;
    use App\Models\Enums\UserState;
    use App\Models\Flight;
    use App\Models\Pirep;
    use App\Models\User;

    $filedStates = [PirepState::DRAFT, PirepState::IN_PROGRESS, PirepState::CANCELLED, PirepState::REJECTED, PirepState::DELETED];

    $stat_pilots = User::where('state', '!=', UserState::DELETED)->count();
    $stat_routes = Flight::where('active', true)->count();
    $stat_fleet = Aircraft::count();
    $stat_bases = Airport::where('hub', true)->count();
    $stat_minutes = (int) Pirep::whereNotIn('state', $filedStates)->sum('flight_time');
    $stat_flights = Pirep::whereNotIn('state', $filedStates)->count();

    $latest = Pirep::with(['airline', 'aircraft', 'user', 'dpt_airport', 'arr_airport'])
        ->whereNotIn('state', $filedStates)
        ->orderBy('submitted_at', 'desc')
        ->take(6)
        ->get();

    $fmt_time = function ($minutes) {
        $minutes = (int) $minutes;

        return intdiv($minutes, 60).'h '.str_pad($minutes % 60, 2, '0', STR_PAD_LEFT).'m';
    };
@endphp

@section('hero')
    <section class="va-hero">
        <div class="container">
            <div class="va-rule"></div>
            <h1>Fly the line.<br>Keep the logbook.</h1>
            <p class="lead mb-4">
                Meridian Virtual is a flight simulation community flying scheduled routes across a live network.
                Bid on a flight, fly it in your sim, and your ACARS client files the report automatically &mdash;
                hours, landing rate, fuel burn and route, straight into your pilot record.
            </p>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ url('/register') }}" class="btn btn-accent px-4 py-2">
                    <i class="bi bi-person-vcard me-1"></i> Join the roster
                </a>
                <a href="{{ route('frontend.livemap.index') }}" class="btn btn-outline-light px-4 py-2">
                    <i class="bi bi-globe me-1"></i> Who's airborne now
                </a>
            </div>

            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-3 va-kpis">
                <div class="col">
                    <div class="va-kpi">
                        <div class="val">{{ number_format($stat_pilots) }}</div>
                        <div class="lbl">{{ trans_choice('common.pilot', 2) }}</div>
                    </div>
                </div>
                <div class="col">
                    <div class="va-kpi">
                        <div class="val">{{ number_format($stat_flights) }}</div>
                        <div class="lbl">Flights filed</div>
                    </div>
                </div>
                <div class="col">
                    <div class="va-kpi">
                        <div class="val">{{ number_format(intdiv($stat_minutes, 60)) }}</div>
                        <div class="lbl">Hours flown</div>
                    </div>
                </div>
                <div class="col">
                    <div class="va-kpi">
                        <div class="val">{{ number_format($stat_routes) }}</div>
                        <div class="lbl">Scheduled routes</div>
                    </div>
                </div>
                <div class="col">
                    <div class="va-kpi">
                        <div class="val">{{ number_format($stat_fleet) }}</div>
                        <div class="lbl">Aircraft in fleet</div>
                    </div>
                </div>
                <div class="col">
                    <div class="va-kpi">
                        <div class="val">{{ number_format($stat_bases) }}</div>
                        <div class="lbl">Hubs</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <div class="va-section-title">
        <h2>Latest flight reports</h2>
        <div class="line"></div>
        <a href="{{ route('frontend.livemap.index') }}" class="text-decoration-none small">Live map <i
                class="bi bi-arrow-right"></i></a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr class="text-uppercase" style="font-size: .72rem; letter-spacing: .12em;">
                        <th scope="col">Flight</th>
                        <th scope="col">Route</th>
                        <th scope="col">{{ trans_choice('common.pilot', 1) }}</th>
                        <th scope="col">Equipment</th>
                        <th scope="col" class="text-end">Block time</th>
                        <th scope="col" class="text-end d-none d-md-table-cell">Filed</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latest as $p)
                        <tr>
                            <td>
                                <span class="badge va-badge-accent">{{ $p->ident }}</span>
                            </td>
                            <td>
                                <a class="text-decoration-none fw-semibold"
                                    href="{{ route('frontend.airports.show', [$p->dpt_airport_id]) }}">{{ $p->dpt_airport_id }}</a>
                                <i class="bi bi-arrow-right mx-1 text-body-secondary" style="font-size: .8rem;"></i>
                                <a class="text-decoration-none fw-semibold"
                                    href="{{ route('frontend.airports.show', [$p->arr_airport_id]) }}">{{ $p->arr_airport_id }}</a>
                            </td>
                            <td>{{ optional($p->user)->name_private }}</td>
                            <td class="text-body-secondary">{{ optional($p->aircraft)->ident }}</td>
                            <td class="text-end font-monospace">{{ $fmt_time($p->flight_time) }}</td>
                            <td class="text-end text-body-secondary d-none d-md-table-cell">
                                {{ $p->submitted_at ? $p->submitted_at->diffForHumans() : '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-body-secondary py-4">
                                No flight reports have been filed yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="va-section-title">
        <h2>@lang('common.newestpilots')</h2>
        <div class="line"></div>
        <a href="{{ route('frontend.pilots.index') }}" class="text-decoration-none small">Full roster <i
                class="bi bi-arrow-right"></i></a>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
        @foreach ($users as $user)
            <div class="col">
                <div class="va-pilot">
                    <a href="{{ route('frontend.profile.show', [$user->id]) }}" class="text-decoration-none">
                        <div class="head">
                            @if ($user->avatar == null)
                                <img src="{{ $user->gravatar(88) }}" alt="">
                            @else
                                <img src="{{ $user->avatar->url }}" alt="">
                            @endif
                            <span>
                                <span class="nm d-block">{{ $user->name_private }}</span>
                                <span class="sub">{{ optional($user->rank)->name ?? 'New hire' }}</span>
                            </span>
                        </div>
                    </a>
                    <div class="body">
                        <div class="base">
                            {{ filled($user->home_airport) ? $user->home_airport->icao : '—' }}
                            <small>Home base</small>
                        </div>
                        <a href="{{ route('frontend.profile.show', [$user->id]) }}"
                            class="btn btn-sm btn-outline-secondary">@lang('common.profile')</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
