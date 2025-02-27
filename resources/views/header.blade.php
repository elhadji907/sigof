<header id="header" class="header d-flex align-items-center fixed-top">
    <div
        class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

        <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto me-xl-0">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <!-- <img src="{{ asset('asset/img/logo.png') }}" alt=""> -->
            {{-- <img src="{{ asset('assets/img/logo_sigle.png') }}" alt=""> --}}
            <h1 class="sitename"><b>SIGOF</b></h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ url('/') }}" class="active">Accueil</a></li>
                <li><a href="#apropos">À propos</a></li>
                <li><a href="#partenaires">Partenaires</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#contact">Contact</a></li>

                <li class="dropdown"><a><span>S'inscrire</span> <i
                            class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li> <a href="#" data-bs-toggle="modal"
                                data-bs-target="#registerDemandeurModal">Compte personnel</a>
                        </li>
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#registerOperateurModal">Compte
                                opérateur</a>
                        </li>
                    </ul>
                </li>

            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <a class="btn-getstarted" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Se
            connecter</a>

    </div>
</header>