<nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">

        {{-- <li class="nav-item d-block d-lg-none">
            <a class="nav-link nav-icon search-bar-toggle " href="#">
                <i class="bi bi-search"></i>
            </a>
        </li> --}}
        <!-- End Search Icon-->

        @unless (auth()->user()->unReadNotifications->isEmpty())
            @can('courrier-notification-show')
                <li class="nav-item dropdown">

                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number">{!! auth()->user()->unReadNotifications->count() !!}</span>
                    </a><!-- End Notification Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            {!! auth()->user()->unReadNotifications->count() !!} nouvelles notifications
                            <a href="{{ url('notifications') }}"><span class="badge rounded-pill bg-primary p-2 ms-2">Voir
                                    toutes</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        @foreach (auth()->user()->unReadNotifications as $notification)
                            <a class="dropdown-item d-flex align-items-centers"
                                href="{{ route('courriers.showFromNotification', ['courrier' => $notification->data['courrierId'], 'notification' => $notification->id]) }}">
                                <li class="notification-item">
                                    <i class="bi bi-check-circle text-success"></i>
                                    <div>
                                        <h4>{!! $notification->data['firstname'] !!}&nbsp;{!! $notification->data['name'] !!}</h4>
                                        <p>{!! $notification->data['courrierTitle'] !!}</p>
                                        <p>{!! $notification->created_at->diffForHumans() !!}</p>
                                    </div>
                                </li>
                            </a>
                        @endforeach

                        <hr class="dropdown-divider">
                        <li class="dropdown-footer">
                            <a href="{{ url('notifications') }}">Voir toutes les notifications</a>
                        </li>

                    </ul><!-- End Notification Dropdown Items -->

                </li>
            @endcan
        @endunless
        <!-- End Notification Nav -->

        {{-- <li class="nav-item dropdown">

            <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                <i class="bi bi-chat-left-text"></i>
                <span class="badge bg-success badge-number">3</span>
            </a> --}}
        <!-- End Messages Icon -->

        {{--  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                <li class="dropdown-header">
                    You have 3 new messages
                    <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>

                <li class="message-item">
                    <a href="#">
                        <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
                        <div>
                            <h4>Maria Hudson</h4>
                            <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                            <p>4 hrs. ago</p>
                        </div>
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>

                <li class="message-item">
                    <a href="#">
                        <img src="assets/img/messages-2.jpg" alt="" class="rounded-circle">
                        <div>
                            <h4>Anna Nelson</h4>
                            <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                            <p>6 hrs. ago</p>
                        </div>
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>

                <li class="message-item">
                    <a href="#">
                        <img src="assets/img/messages-3.jpg" alt="" class="rounded-circle">
                        <div>
                            <h4>David Muldon</h4>
                            <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                            <p>8 hrs. ago</p>
                        </div>
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>

                <li class="dropdown-footer">
                    <a href="#">Show all messages</a>
                </li>

            </ul> --}}
        <!-- End Messages Dropdown Items -->

        {{--  </li> --}}
        <!-- End Messages Nav -->

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

                {{-- <li>
                    <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                        <i class="bi bi-gear"></i>
                        <span>Account Settings</span>
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>
                    <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                        <i class="bi bi-question-circle"></i>
                        <span>Need Help?</span>
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li> --}}

                <li>
                    {{--   <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="dropdown-item d-flex align-items-center" href="route('logout')"
                            onclick="event.preventDefault();
      this.closest('form').submit();">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Se déconnecter</span>
                        </a>
                    </form> --}}
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
