<nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">
        @php
            $user = auth()->user();
            $unreadNotifications = $user->unReadNotifications;
            $notificationCount = $unreadNotifications->count();
        @endphp

        @if ($notificationCount > 0)
            @can('courrier-notification-show')
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number">{{ $notificationCount }}</span>
                    </a><!-- End Notification Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            {{ $notificationCount }} nouvelles notifications
                            <a href="{{ url('notifications') }}">
                                <span class="badge rounded-pill bg-primary p-2 ms-2">Voir toutes</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        @foreach ($unreadNotifications as $notification)
                            <a class="dropdown-item d-flex align-items-center"
                                href="{{ route('courriers.showFromNotification', ['courrier' => $notification->data['courrierId'], 'notification' => $notification->id]) }}">
                                <li class="notification-item">
                                    <i class="bi bi-check-circle text-success"></i>
                                    <div>
                                        <h4>{{ $notification->data['firstname'] }} {{ $notification->data['name'] }}</h4>
                                        <p>{{ $notification->data['courrierTitle'] }}</p>
                                        <p>{{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                </li>
                            </a>
                        @endforeach

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="dropdown-footer">
                            <a href="{{ url('notifications') }}">Voir toutes les notifications</a>
                        </li>
                    </ul><!-- End Notification Dropdown Items -->
                </li>
            @endcan
        @endif


        <li class="nav-item dropdown pe-3">

            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                {{-- <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle"> --}}
                <img class="rounded-circle" alt="Profil" src="{{ asset(Auth::user()->getImage()) }}">
                <span class="d-none d-md-block dropdown-toggle ps-2">
                    @if (Auth::user()->operateur)
                        {{ Auth::user()->username }}
                    @elseif (Auth::user()->name)
                        {{ Auth::user()->civilite . ' ' . Auth::user()->name }}
                    @else
                        {{ Auth::user()->username }}
                    @endif
                </span>
            </a><!-- End Profile Iamge Icon -->

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                <li class="dropdown-header">
                    <h6>
                        @if (Auth::user()->operateur)
                            {{ Auth::user()->username }}
                        @elseif (Auth::user()->name)
                            {{ Auth::user()->civilite . ' ' . Auth::user()->firstname . ' ' . Auth::user()->name }}
                        @else
                            {{ Auth::user()->username }}
                        @endif
                    </h6>
                    <span><a href="mailto:{{ Auth::user()->email }}">{{ Auth::user()->email }}</a></span>
                    {{-- @foreach (Auth::user()->roles as $role)
                        <span>{{ $role->name }}</span>
                    @endforeach --}}
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>
                    <a class="dropdown-item d-flex align-items-center" href="{{ url('/profil') }}">
                        <i class="bi bi-person"></i>
                        <span>Mon Profil</span>
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>

                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="dropdown-item show_confirm_disconnect"><i
                                class="bi bi-box-arrow-in-left"></i>Se
                            déconnecter</button>
                    </form>
                </li>

            </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

    </ul>
</nav>
