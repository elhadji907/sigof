@include('header-accueil')

<body class="index-page">

    @include('header')

    <main class="main">
        <!-- Hero Section -->
        <section id="accueil" class="hero section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row align-items-center">

                    @if ($message = Session::get('status'))
                        <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show"
                            role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Fermer"></button>
                        </div>
                    @endif
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show"
                                role="alert"><strong>{{ $error }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Fermer"></button>
                            </div>
                        @endforeach
                    @endif
                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                        <div class="hero-content" data-aos="fade-up" data-aos-delay="200">

                            @if (!empty($une?->titre1))
                                <div class="company-badge mb-4">
                                    <i class="bi bi-gear-fill me-2"></i>
                                    ONFP - La référence de la formation professionnelle
                                </div>
                                <h1 class="mb-4">
                                    @if (!empty($une?->titre1))
                                        {{ $une?->titre1 }} <br>
                                    @else
                                        M. Mouhamadou Lamine Bara LO <br>
                                    @endif

                                    @if (!empty($une?->titre2))
                                        <span class="accent-text">{{ $une?->titre2 }}</span>
                                    @else
                                        <span class="accent-text">Directeur Général</span>
                                    @endif
                                </h1>
                            @else
                                <h2 class="mb-4">
                                    ONFP<br>
                                    LA REFERENCE<br>
                                    <span class="accent-text">DE LA FORMATION</span><br>
                                    <span class="accent-text">PROFESSIONNELLE AU SENEGAL</span>
                                </h2>
                            @endif

                            <p class="mb-4 mb-md-5">
                                @if (!empty($une?->message))
                                    {{ substr($une?->message, 0, 350) }}...
                                @else
                                @endif
                            </p>
                            <div class="hero-buttons">
                                @if (!empty($une?->message))
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#enSavoirPlusModal"
                                        class="btn btn-primary btn-sm me-0 me-sm-2 mx-1">En savoir plus</a>
                                @else
                                    <a href="#apropos" class="btn btn-primary btn-sm me-0 me-sm-2 mx-1">En savoir
                                        plus</a>
                                @endif
                                @if (!empty($une?->video))
                                    <a href="{{ $une?->video }}" class="btn btn-sm btn-link mt-2 mt-sm-0 glightbox">
                                        <i class="bi bi-play-circle me-1"></i>Lire la vidéo</a>
                                @else
                                    <a href="https://www.youtube.com/watch?v=UVn3WAv8XbM&t=49s"
                                        class="btn btn-sm btn-link mt-2 mt-sm-0 glightbox">
                                        <i class="bi bi-play-circle me-1"></i>Vidéo présentation</a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                        {{-- <div class="hero-image" data-aos="zoom-out" data-aos-delay="300">

                            @if (!empty($une?->image))
                                <img class="img-fluid main-image rounded-4" alt="Image"
                                    src="{{ asset($une?->getUne()) }}">
                            @else
                                <img src="{{ asset('asset/img/dg.png') }}" alt="Hero Image"
                                    class="img-fluid main-image rounded-4">
                            @endif

                            <div class="customers-badge">
                                <div class="customer-avatars">
                                    <span class="avatar more">{{ $count_today }}</span>
                                </div>
                                <p class="mb-0 mt-2">
                                    {{ $title }}
                                </p>
                            </div>
                        </div> --}}
                        <section class="service-details py-6">
                            <div class="container mx-auto px-4">
                                <div class="p-6 rounded-lg">
                                    <h4 class="text-xl font-bold text-blue-600 mb-4 flex items-center">
                                        <i class="bi bi-link-45deg text-2xl mr-2"></i> Ressources utiles
                                    </h4>
                                    <div class="services-list space-y-3">
                                        <a href="{{ route('services.details') }}"
                                            class="flex items-center text-gray-700 hover:text-blue-500 transition duration-300">
                                            <i class="bi bi-arrow-right-circle mr-2 text-blue-500"></i>
                                            <span>Comment s'inscrire ?</span>
                                        </a>
                                        <a href="{{ route('services.details') }}"
                                            class="flex items-center text-gray-700 hover:text-blue-500 transition duration-300">
                                            <i class="bi bi-arrow-right-circle mr-2 text-blue-500"></i>
                                            <span>Comment déposer une demande de formation individuelle ?</span>
                                        </a>
                                        <a href="{{ route('services.details') }}"
                                            class="flex items-center text-gray-700 hover:text-blue-500 transition duration-300">
                                            <i class="bi bi-arrow-right-circle mr-2 text-blue-500"></i>
                                            <span>Comment déposer une demande de formation collective ?</span>
                                        </a>
                                        {{-- <a href="{{ route('services.details') }}"
                                            class="flex items-center text-gray-700 hover:text-blue-500 transition duration-300">
                                            <i class="bi bi-arrow-right-circle mr-2 text-blue-500"></i>
                                            <span>Comment devenir opérateur ?</span>
                                        </a> --}}
                                        <a href="{{ route('nos-modules') }}"
                                            class="flex items-center text-gray-700 hover:text-blue-500 transition duration-300"
                                            target="_blank">
                                            <i class="bi bi-filetype-pdf"></i>
                                            <span>Quels sont nos modules de formation ?</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    @if (!empty($postNotEmpty))
                        <div class="row stats-row gy-4 mt-5" data-aos="fade-up" data-aos-delay="500">
                            @foreach ($posts as $post)
                                @if (!empty($post->image))
                                    <div class="col-12 col-md-12 col-lg-3 col-sm-12 col-xs-12 col-xxl-3">
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#ShowPostModal{{ $post->id }}">
                                            <div class="stat-item">
                                                <img class="rounded-circle" alt="{{ $post->titre }}"
                                                    src="{{ asset($post->getPoste()) }}" width="50" height="auto">
                                                <div class="stat-content">
                                                    <p>{{ $post?->titre }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                </div>

        </section>

        <!-- About Section -->
        <section id="apropos" class="about section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4 align-items-center justify-content-between">

                    <div class="col-xl-5" data-aos="fade-up" data-aos-delay="200">
                        <span class="about-meta">À PROPOS DE L'ONFP</span>
                        {{-- <h2 class="about-title">La référence de la formation professionnelle</h2> --}}
                        <p class="about-description">L'Office National de Formation Professionnelle <b>(ONFP)</b> est
                            un
                            établissement public à caractère industriel et commercial (EPIC) créé par la Loi <b>n°86-44
                                du
                                11 Août 1986.</b> Ainsi, l'ONFP a pour mission de :</p>

                        <div class="row feature-list-wrapper">
                            <div class="col-md-12">
                                <ul class="feature-list">
                                    <li><i class="bi bi-check-circle-fill"></i> Aider à mettre en œuvre les objectifs
                                        sectoriels du gouvernement et d'assister les organismes publics et privés dans
                                        la réalisation de leur action ;</li>
                                    <li><i class="bi bi-check-circle-fill"></i> Réaliser des études sur l'emploi, la
                                        qualification professionnelle, les moyens quantitatifs et qualitatifs de la
                                        formation professionnelle initiale et continue ;</li>
                                    <li><i class="bi bi-check-circle-fill"></i> Coordonner les interventions par
                                        branche professionnelle par action prioritaire en s'appuyant sur des structures
                                        existantes ou à créer ;</li>
                                    <li><i class="bi bi-check-circle-fill"></i> Coordonner l'action de formation
                                        professionnelle des organismes d'aides bilatérales ou multilatérales.</li>

                                </ul>
                            </div>
                        </div>

                        <div class="info-wrapper">
                            <div class="row gy-4">
                                <div class="col-lg-6">
                                    <div class="profile d-flex align-items-center gap-3">
                                        <img src="{{ asset('asset/img/dg.png') }}" alt="DG ONFP"
                                            class="profile-image">
                                        <div>
                                            <h4 class="profile-name"><b>M. Lamine Bara LO</b></h4>
                                            <p class="profile-position">Directeur Général</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="contact-info d-flex align-items-center gap-2">
                                        <i class="bi bi-telephone-fill"></i>
                                        <div>
                                            <p class="contact-label">Appelez-nous au</p>
                                            <p class="contact-number">+221 33 827 92 51</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="image-wrapper">
                            <div class="images position-relative" data-aos="zoom-out" data-aos-delay="400">
                                <img src="{{ asset('asset/img/about5.jpg') }}" alt="Image 5"
                                    class="img-fluid main-image rounded-4">
                                <img src="{{ asset('asset/img/about2.jpg') }}" alt="Image 2"
                                    class="img-fluid small-image rounded-4">
                            </div>
                            <div class="experience-badge floating">
                                <h3>{{ $anciennete }}+ <span>ans</span></h3>
                                <p>{{ __("d'expérience dans la formation professionnelle") }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </section>
        <!-- /About Section -->

        <section class="testimonials section light-background">
        </section>


        <!-- Features Section -->
        <section id="features" class="features section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>À PROPOS DU SIGOF</h2>
                <p>Le Système Intégré de Gestion des Opérations de Formation de l’ONFP</p>
            </div><!-- End Section Title -->

            <div class="container">

                {{-- <div class="d-flex justify-content-center">
  
            <ul class="nav nav-tabs" data-aos="fade-up" data-aos-delay="100">
  
              <li class="nav-item">
                <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#features-tab-1">
                  <h4>Modisit</h4>
                </a>
              </li><!-- End tab nav item -->
  
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-2">
                  <h4>Praesenti</h4>
                </a><!-- End tab nav item -->
  
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-3">
                  <h4>Explica</h4>
                </a>
              </li><!-- End tab nav item -->
  
            </ul>
  
          </div> --}}

                <div class="tab-content" data-aos="fade-up" data-aos-delay="200">

                    <div class="tab-pane fade active show" id="features-tab-1">
                        <div class="row">
                            <div
                                class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12 order-2 order-lg-1 mt-3 mt-lg-0 d-flex flex-column justify-content-center">
                                {{-- <h3>SIGOF</h3> --}}
                                <p class="fst-italic">
                                    Le Système Intégré de Gestion des Opérations de Formation (SIGOF) de l’ONFP (Office
                                    National de Formation Professionnelle) est une plateforme numérique conçue pour
                                    centraliser et automatiser la gestion des activités liées à la formation
                                    professionnelle.
                                </p>
                                <ul>
                                    <h5>Objectifs principaux :</h5>
                                    <li><i class="bi bi-check"></i> <span><b>Optimisation des processus</b> :
                                            Simplifier la gestion des inscriptions et la coordination des parties
                                            prenantes.</span></li>
                                    <li><i class="bi bi-check"></i> <span><b>Gestion des demandeurs</b> :
                                            Enregistrement et traitement des demandes individuelles ou
                                            collectives.</span></li>
                                    <li><i class="bi bi-check"></i> <span><b>Gestion des opérateurs</b> :
                                            Enregistrement et traitement
                                            des prestataires de formation.</span></li>
                                    <li><i class="bi bi-check"></i> <span><b>Gestion des partenaires</b> :
                                            Coordination et suivi des collaborations institutionnelles.</span></li>
                                    <li><i class="bi bi-check"></i> <span><b>Portail interactif</b> : Interface
                                            utilisateur pour les demandeurs de formations et les opérateurs, accessible
                                            en ligne.</span></li>
                                </ul>
                                {{-- <ul>
                                    <h5>Fonctionnalités clés :</h5>
                                    <li><i class="bi bi-check"></i> <span><b>Gestion des formations</b> :
                                            Planification, organisation et suivi des programmes.</span></li>
                                    <li><i class="bi bi-check"></i> <span><b>Base de données des bénéficiaires</b>
                                            : Enregistrement et suivi des apprenants et des formateurs.</span></li>
                                    <li><i class="bi bi-check"></i> <span><b>Rapports et statistiques</b> :
                                            Génération automatique de bilans et d’indicateurs pour mesurer les
                                            performances.</span></li>
                                    <li><i class="bi bi-check"></i> <span><b>Portail interactif</b> : Interface
                                            utilisateur pour les apprenants, formateurs et administrateurs, accessible
                                            en ligne.</span></li>
                                </ul> --}}
                                <p>
                                    En résumé, le SIGOF est un outil stratégique qui modernise et professionnalise la
                                    gestion des activités de formation de l'ONFP, améliorant ainsi l'efficacité et la
                                    qualité des services offerts.
                                </p>
                            </div>
                            <div class="col-lg-6 order-1 order-lg-2 text-center">
                                <img src="assets/img/features-illustration-1.webp" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div><!-- End tab content item -->
                    {{-- 
            <div class="tab-pane fade" id="features-tab-2">
                <div class="row">
                  <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0 d-flex flex-column justify-content-center">
                    <h3>Neque exercitationem debitis</h3>
                    <p class="fst-italic">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
                      magna aliqua.
                    </p>
                    <ul>
                      <li><i class="bi bi-check2-all"></i> <span>Ullamco laboris nisi ut aliquip ex ea commodo consequat.</span></li>
                      <li><i class="bi bi-check2-all"></i> <span>Duis aute irure dolor in reprehenderit in voluptate velit.</span></li>
                      <li><i class="bi bi-check2-all"></i> <span>Provident mollitia neque rerum asperiores dolores quos qui a. Ipsum neque dolor voluptate nisi sed.</span></li>
                      <li><i class="bi bi-check2-all"></i> <span>Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate trideta storacalaperda mastiro dolore eu fugiat nulla pariatur.</span></li>
                    </ul>
                  </div>
                  <div class="col-lg-6 order-1 order-lg-2 text-center">
                    <img src="assets/img/features-illustration-2.webp" alt="" class="img-fluid">
                  </div>
                </div>
              </div><!-- End tab content item -->
    
              <div class="tab-pane fade" id="features-tab-3">
                <div class="row">
                  <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0 d-flex flex-column justify-content-center">
                    <h3>Voluptatibus commodi accusamu</h3>
                    <ul>
                      <li><i class="bi bi-check2-all"></i> <span>Ullamco laboris nisi ut aliquip ex ea commodo consequat.</span></li>
                      <li><i class="bi bi-check2-all"></i> <span>Duis aute irure dolor in reprehenderit in voluptate velit.</span></li>
                      <li><i class="bi bi-check2-all"></i> <span>Provident mollitia neque rerum asperiores dolores quos qui a. Ipsum neque dolor voluptate nisi sed.</span></li>
                    </ul>
                    <p class="fst-italic">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
                      magna aliqua.
                    </p>
                  </div>
                  <div class="col-lg-6 order-1 order-lg-2 text-center">
                    <img src="assets/img/features-illustration-3.webp" alt="" class="img-fluid">
                  </div>
                </div>
              </div><!-- End tab content item -->
               --}}
                </div>

            </div>

        </section><!-- /Features Section -->

        <section class="testimonials section light-background">
        </section>
        <!-- /Stats Section -->

        <!-- Services Section -->
        <section id="services" class="services section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Services</h2>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row g-4">
                    @foreach ($services as $service)
                        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                            <div class="service-card d-flex">
                                <div class="icon flex-shrink-0">
                                    <i class="bi bi-easel"></i>
                                </div>
                                <div>
                                    <h3>{{ $service?->titre }}</h3>
                                    <p>{{ $service?->name }}</p>
                                    <a href="{{ $service?->lien }}" class="read-more" target="_blank">En savoir plus
                                        <i class="bi bi-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!-- End Service Card -->

                </div>

            </div>

        </section><!-- /Services Section -->

        <!-- Stats Section -->
        <section id="stats" class="stats section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="{{ $count_demandeurs }}"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>Demandes</p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="{{ $referentiels }}"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>Référentiels</p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="{{ $count_projets }}"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>Partenaires</p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="{{ $count_operateurs }}"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>Opérateurs</p>
                        </div>
                    </div><!-- End Stats Item -->

                </div>

            </div>

        </section>
        <!-- Faq Section -->
        <section class="faq-9 faq section light-background" id="faq">

            <div class="container">
                <div class="row">

                    <div class="col-lg-5" data-aos="fade-up">
                        <h2 class="faq-title">Réponses aux questions</h2>
                        <p class="faq-description">Vous avez une question ? Consultez les questions fréquemment posées
                        </p>
                        <div class="faq-arrow d-none d-lg-block" data-aos="fade-up" data-aos-delay="200">
                            <svg class="faq-arrow" width="200" height="211" viewBox="0 0 200 211"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M198.804 194.488C189.279 189.596 179.529 185.52 169.407 182.07L169.384 182.049C169.227 181.994 169.07 181.939 168.912 181.884C166.669 181.139 165.906 184.546 167.669 185.615C174.053 189.473 182.761 191.837 189.146 195.695C156.603 195.912 119.781 196.591 91.266 179.049C62.5221 161.368 48.1094 130.695 56.934 98.891C84.5539 98.7247 112.556 84.0176 129.508 62.667C136.396 53.9724 146.193 35.1448 129.773 30.2717C114.292 25.6624 93.7109 41.8875 83.1971 51.3147C70.1109 63.039 59.63 78.433 54.2039 95.0087C52.1221 94.9842 50.0776 94.8683 48.0703 94.6608C30.1803 92.8027 11.2197 83.6338 5.44902 65.1074C-1.88449 41.5699 14.4994 19.0183 27.9202 1.56641C28.6411 0.625793 27.2862 -0.561638 26.5419 0.358501C13.4588 16.4098 -0.221091 34.5242 0.896608 56.5659C1.8218 74.6941 14.221 87.9401 30.4121 94.2058C37.7076 97.0203 45.3454 98.5003 53.0334 98.8449C47.8679 117.532 49.2961 137.487 60.7729 155.283C87.7615 197.081 139.616 201.147 184.786 201.155L174.332 206.827C172.119 208.033 174.345 211.287 176.537 210.105C182.06 207.125 187.582 204.122 193.084 201.144C193.346 201.147 195.161 199.887 195.423 199.868C197.08 198.548 193.084 201.144 195.528 199.81C196.688 199.192 197.846 198.552 199.006 197.935C200.397 197.167 200.007 195.087 198.804 194.488ZM60.8213 88.0427C67.6894 72.648 78.8538 59.1566 92.1207 49.0388C98.8475 43.9065 106.334 39.2953 114.188 36.1439C117.295 34.8947 120.798 33.6609 124.168 33.635C134.365 33.5511 136.354 42.9911 132.638 51.031C120.47 77.4222 86.8639 93.9837 58.0983 94.9666C58.8971 92.6666 59.783 90.3603 60.8213 88.0427Z"
                                    fill="currentColor"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="col-lg-7" data-aos="fade-up" data-aos-delay="300">
                        <div class="faq-container">
                            <?php $i = 1; ?>
                            @foreach ($contacts as $contact)
                                @if (!empty($contact?->reponse))
                                    <div class="faq-item">
                                        <h3>{{ $contact?->message }}</h3>
                                        <div class="faq-content">
                                            <p>{{ $contact?->reponse }}</p>
                                        </div>
                                        <i class="faq-toggle bi bi-chevron-right"></i>
                                    </div>
                                    <!-- End Faq item-->
                                    <?php $i++; ?>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /Faq Section -->

        <section class="stats section">
        </section>

        <!-- Contact Section -->
        <section id="contact" class="contact section light-background">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Contact</h2>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row g-4 g-lg-5">
                    <div class="col-lg-5">
                        <div class="info-box" data-aos="fade-up" data-aos-delay="200">
                            <h3 class="text-center">Pour nous joindre</h3>
                            <p class="text-center">Vous pouvez nous contacter via le formulaire de contact, par email
                                direct ou par
                                téléphone.</p>

                            <div class="info-item" data-aos="fade-up" data-aos-delay="300">
                                <div class="icon-box">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div class="content">
                                    <h4>Notre localisation</h4>
                                    <p>Spres 1, lot 2 - 2 voies liberté 6, extension VDN. </p>
                                </div>
                            </div>

                            <div class="info-item" data-aos="fade-up" data-aos-delay="400">
                                <div class="icon-box">
                                    <a href="tel:+221338279251"><i class="bi bi-telephone"></i></a>
                                </div>
                                <div class="content">
                                    <h4>Téléphone</h4>
                                    <p>+221 33 827 92 51</p>
                                </div>
                            </div>

                            <div class="info-item" data-aos="fade-up" data-aos-delay="500">
                                <div class="icon-box">
                                    <a href="mailto:onfp@onfp.sn"><i class="bi bi-envelope"></i></a>
                                </div>
                                <div class="content">
                                    <h4>Addresse e-mail</h4>
                                    <p>onfp@onfp.sn</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="contact-form" data-aos="fade-up" data-aos-delay="300">
                            <h3>Connectez-nous ! Posez vos questions !</h3>
                            <p>
                                Bonjour et bienvenue sur notre application !

                                Nous sommes ravis de vous compter parmi nos utilisateurs. Si vous avez des questions,
                                des suggestions ou des remarques, n'hésitez pas à nous contacter. Notre équipe est là
                                pour vous assister et s'assurer que vous avez la meilleure expérience possible.
                            </p>
                            <p>
                                Cordialement,
                                L'équipe digitale
                            </p>

                            <form class="row g-3 needs-validation" novalidate method="POST"
                                action="{{ route('contacts.store') }}">
                                @csrf
                                <div class="col-12 col-md-6 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                                    <label for="emailadresse" class="form-label">Email<span
                                            class="text-danger mx-1">*</span></label>
                                    <div class="input-group has-validation">
                                        <input type="emailadresse" name="emailadresse"
                                            class="form-control form-control-sm @error('emailadresse') is-invalid @enderror"
                                            id="emailadresse" required placeholder="Votre adresse e-mail"
                                            value="{{ old('emailadresse') }}">
                                        <div class="invalid-feedback">
                                            @error('emailadresse')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                                    <label for="telephone" class="form-label">Téléphone<span
                                            class="text-danger mx-1">*</span></label>
                                    <div class="input-group has-validation">
                                        <input type="telephone" name="telephone"
                                            class="form-control form-control-sm @error('telephone') is-invalid @enderror"
                                            id="telephone" required placeholder="Votre téléphone"
                                            value="{{ old('telephone') }}">
                                        <div class="invalid-feedback">
                                            @error('telephone')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                    <label for="objet" class="form-label">Objet<span
                                            class="text-danger mx-1">*</span></label>
                                    <div class="input-group has-validation">
                                        <input type="name" name="objet"
                                            class="form-control form-control-sm @error('objet') is-invalid @enderror"
                                            id="objet" required placeholder="Objet" value="{{ old('objet') }}">
                                        <div class="invalid-feedback">
                                            @error('objet')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                    <label for="message" class="form-label">Message<span
                                            class="text-danger mx-1">*</span></label>
                                    <div class="input-group has-validation">
                                        <textarea class="form-control" name="message" rows="4"
                                            placeholder="Ecrire votre message ici, Poser votre question, ..." required></textarea>
                                    </div>
                                </div>

                                <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12 text-center">
                                    <button class="btn btn-sm" type="submit">Envoyer</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </div>

        </section>
        <!-- /Contact Section -->
        <!-- Clients Section -->
        <section id="partenaires" class="clients section">

            <div class="container section-title" data-aos="fade-up">
                <h2>Partenaires</h2>
            </div>
            <!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="swiper init-swiper">
                    <script type="application/json" class="swiper-config">
                        {
                        "loop": true,
                        "speed": 600,
                        "autoplay": {
                            "delay": 5000
                        },
                        "slidesPerView": "auto",
                        "pagination": {
                            "el": ".swiper-pagination",
                            "type": "bullets",
                            "clickable": true
                        },
                        "breakpoints": {
                            "320": {
                            "slidesPerView": 2,
                            "spaceBetween": 40
                            },
                            "480": {
                            "slidesPerView": 3,
                            "spaceBetween": 60
                            },
                            "640": {
                            "slidesPerView": 4,
                            "spaceBetween": 80
                            },
                            "992": {
                            "slidesPerView": 6,
                            "spaceBetween": 120
                            }
                        }
                        }
                    </script>
                    <div class="swiper-wrapper align-items-center">
                        @foreach ($projets as $projet)
                            <div class="swiper-slide"><img src="{{ asset($projet?->getProjetImage()) }}"
                                    class="img-fluid" alt="">
                            </div>
                        @endforeach
                        <div class="swiper-slide"><img src="" class="img-fluid" alt=""></div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>

            </div>

        </section>

        <section class="testimonials section light-background">
        </section>

        {{-- Connexion --}}
        <div
            class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12 d-flex flex-column align-items-center justify-content-center">
            <div class="modal fade" id="loginModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="row g-3 needs-validation" novalidate method="POST"
                            action="{{ route('login') }}">
                            @csrf
                            <div class="modal-header">
                                <h5 class="w-100 text-center">CONNEXION</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="email" class="form-label">Email<span
                                                class="text-danger mx-1">*</span></label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                                            <input type="email" name="email"
                                                class="form-control form-control-sm @error('email') is-invalid @enderror"
                                                id="email" required placeholder="Votre adresse e-mail"
                                                value="{{ old('email') }}" autofocus>
                                            <div class="invalid-feedback">
                                                @error('email')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="password" class="form-label">Mot de passe<span
                                                class="text-danger mx-1">*</span></label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend"><i
                                                    class="bi bi-key"></i></span>
                                            <input type="password" name="password"
                                                class="form-control form-control-sm  @error('password') is-invalid @enderror"
                                                id="password" required placeholder="Votre mot de passe">
                                            <div class="invalid-feedback">
                                                @error('password')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember"
                                                value="true" id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">Souviens-toi de
                                                moi</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <button class="btn btn-sm w-100" type="submit"
                                            style="background-color: #F28500; color: #FFFFFF">Se
                                            connecter</button>
                                    </div>

                                    <div class="col-12">
                                        @if (Route::has('password.request'))
                                            <p class="small mb-0">Mot de passe oublié !
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#forgotModal"> Réinitialiser</a>
                                            </p>
                                        @endif
                                    </div>

                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Inscription Demandeur --}}
        <div
            class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12 d-flex flex-column align-items-center justify-content-center">
            <div class="modal fade" id="registerDemandeurModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="row g-3 needs-validation contact-form" novalidate method="POST"
                            action="{{ route('register') }}">
                            @csrf
                            <div class="modal-header">
                                <h5 class="w-100 text-center">Création compte personnel</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Fermer"></button>
                            </div>

                            <div class="modal-body">
                                <div class="row g-3">
                                    <!-- Username -->
                                    <input type="hidden" name="role" value="Demandeur">
                                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <label for="username" class="form-label">Username<span
                                                class="text-danger mx-1">*</span></label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend"><i
                                                    class="bi bi-person"></i></span>
                                            <input type="text" name="username"
                                                class="form-control form-control-sm @error('username') is-invalid @enderror"
                                                id="username" required placeholder="ex : jean221"
                                                value="{{ old('username') }}" autocomplete="username">
                                            <div class="invalid-feedback">
                                                @error('username')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Addresse E-mail -->
                                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <label for="email" class="form-label">Email<span
                                                class="text-danger mx-1">*</span></label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                                            <input type="email" name="email"
                                                class="form-control form-control-sm @error('email') is-invalid @enderror"
                                                id="email" required placeholder="Votre e-mail"
                                                value="{{ old('email') }}" autocomplete="email">
                                            <div class="invalid-feedback">
                                                @error('email')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Mot de passe -->
                                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <label for="password" class="form-label">Mot de passe<span
                                                class="text-danger mx-1">*</span></label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend"><i
                                                    class="bi bi-key"></i></span>
                                            <input type="password" name="password"
                                                class="form-control form-control-sm @error('password') is-invalid @enderror"
                                                id="password" required placeholder="Votre mot de passe"
                                                value="{{ old('password') }}" autocomplete="new-password">
                                            <div class="invalid-feedback">
                                                @error('password')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Mot de passe de confirmation -->
                                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <label for="password_confirmation" class="form-label">Confirmez mot de
                                            passe<span class="text-danger mx-1">*</span></label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend"><i
                                                    class="bi bi-key"></i></span>
                                            <input type="password" name="password_confirmation"
                                                class="form-control form-control-sm @error('password_confirmation') is-invalid @enderror"
                                                id="password_confirmation" required
                                                placeholder="Confimez votre mot de passe"
                                                value="{{ old('password_confirmation') }}"
                                                autocomplete="new-password_confirmation">
                                            <div class="invalid-feedback">
                                                @error('password_confirmation')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <div class="form-check">
                                            <input class="form-check-input @error('termes') is-invalid @enderror"
                                                name="termes" type="checkbox" value="1" id="acceptTerms"
                                                required>
                                            <label class="form-check-label" for="acceptTerms">J'accepte les
                                                <button style="color: blue" type="button"
                                                    class="btn btn-default btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#largeModal">
                                                    termes et conditions
                                                </button>
                                                <span class="text-danger mx-1">*</span></label>
                                            <div class="invalid-feedback">
                                                @error('termes')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <button type="submit" class="btn btn-sm w-100"
                                            style="background-color: #F28500; color: #FFFFFF">Créer un compte
                                            personnel</button>
                                    </div>

                                    <div
                                        class="col-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-xxl-12 justify-content-center">
                                        <p class="small">Vous avez déjà un compte ? <a href="#"
                                                data-bs-toggle="modal" data-bs-target="#loginModal">Se connecter</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Inscription opérateur --}}
        <div
            class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12 d-flex flex-column align-items-center justify-content-center">
            <div class="modal fade" id="registerOperateurModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="row g-3 needs-validation contact-form" novalidate method="POST"
                            action="{{ route('register') }}">
                            @csrf
                            <div class="modal-header">
                                <h5 class="w-100  text-center">Création compte opérateur</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3">
                                    <input type="hidden" name="role" value="Operateur">
                                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <label for="username" class="form-label">Sigle<span
                                                class="text-danger mx-1">*</span></label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend"><i
                                                    class="bi bi-person"></i></span>
                                            <input type="text" name="username"
                                                class="form-control form-control-sm @error('username') is-invalid @enderror"
                                                id="username" required placeholder="ex : CFP/MBACKE"
                                                value="{{ old('username') }}" autocomplete="username">
                                            <div class="invalid-feedback">
                                                @error('username')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <label for="email" class="form-label">Email<span
                                                class="text-danger mx-1">*</span></label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                                            <input type="email" name="email"
                                                class="form-control form-control-sm @error('email') is-invalid @enderror"
                                                id="email" required placeholder="E-mail structure"
                                                value="{{ old('email') }}" autocomplete="email">
                                            <div class="invalid-feedback">
                                                @error('email')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <label for="password" class="form-label">Mot de passe<span
                                                class="text-danger mx-1">*</span></label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend"><i
                                                    class="bi bi-key"></i></span>
                                            <input type="password" name="password"
                                                class="form-control form-control-sm @error('password') is-invalid @enderror"
                                                id="password" required placeholder="Votre mot de passe"
                                                value="{{ old('password') }}" autocomplete="new-password">
                                            <div class="invalid-feedback">
                                                @error('password')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <label for="password_confirmation" class="form-label">Confirmez mot de
                                            passe<span class="text-danger mx-1">*</span></label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend"><i
                                                    class="bi bi-key"></i></span>
                                            <input type="password" name="password_confirmation"
                                                class="form-control form-control-sm @error('password_confirmation') is-invalid @enderror"
                                                id="password_confirmation" required
                                                placeholder="Confimez votre mot de passe"
                                                value="{{ old('password_confirmation') }}"
                                                autocomplete="new-password_confirmation">
                                            <div class="invalid-feedback">
                                                @error('password_confirmation')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <div class="form-check">
                                            <input class="form-check-input @error('termes') is-invalid @enderror"
                                                name="termes" type="checkbox" value="1" id="acceptTerms"
                                                required>
                                            <label class="form-check-label" for="acceptTerms">J'accepte les
                                                <button style="color: blue" type="button"
                                                    class="btn btn-default btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#largeModal">
                                                    termes et conditions
                                                </button>
                                                <span class="text-danger mx-1">*</span></label>
                                            <div class="invalid-feedback">
                                                @error('termes')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <button type="submit" class="btn btn-sm w-100"
                                            style="background-color: #F28500; color: #FFFFFF">Créer un compte
                                            opérateur</button>
                                    </div>

                                    <div
                                        class="col-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-xxl-12 justify-content-center">
                                        <p class="small">Vous avez déjà un compte ? <a href="#"
                                                data-bs-toggle="modal" data-bs-target="#loginModal">Se connecter</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mot de passe oublié --}}
        <div
            class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12 d-flex flex-column align-items-center justify-content-center">
            <div class="modal fade" id="forgotModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="row g-3 needs-validation contact-form" novalidate method="POST"
                            action="{{ route('password.email') }}">
                            @csrf
                            <div class="modal-header">
                                <h5 class="w-100  text-center">Réinitialisation du mot de passe
                                    par e-mail</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <label for="email" class="form-label">Email<span
                                                class="text-danger mx-1">*</span></label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                                            <input type="email" name="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                id="email" required placeholder="Votre adresse e-mail"
                                                value="{{ old('email') }}" autofocus>
                                            <div class="invalid-feedback">
                                                @error('email')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <button class="btn btn-sm w-100" type="submit"
                                            style="background-color: #F28500; color: #FFFFFF">Lien de
                                            réinitialisation du mot de passe par e-mail</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- En savoir plus --}}
        <div
            class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12 d-flex flex-column align-items-center justify-content-center">
            <div class="modal fade" id="enSavoirPlusModal" tabindex="-1">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="w-100  text-center">{{ $une?->titre1 }}</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">

                                <h4>{{ $une?->titre2 }}</h4>
                                <p>{{ $une?->message }}</p>

                            </div>
                        </div>
                        <div class="modal-footer mt-5">
                            <button type="button" class="btn btn-secondary btn-sm"
                                data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Antennes modal --}}
        @foreach ($antennes as $antenne)
            <div
                class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12 d-flex flex-column align-items-center justify-content-center">
                <div class="modal fade" id="antenneModal{{ $antenne?->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <section id="pricing" class="pricing section light-background">
                                <!-- Section Title -->
                                <div class="container section-title" data-aos="fade-up">
                                    <h2>{{ $antenne?->name }}</h2>
                                    {{-- <p>{{ $antenne?->adresse }}</p> --}}
                                </div>
                                <!-- End Section Title -->
                                <div class="container" data-aos="fade-up" data-aos-delay="100">
                                    <div class="row justify-content-center">
                                        <!-- Standard Plan -->
                                        <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12"
                                            data-aos="fade-up" data-aos-delay="200">
                                            <div class="pricing-card popular">

                                                @if (!empty($antenne?->date_ouverture))
                                                    <div class="popular-badge">
                                                        {{ 'SINCE ' . mb_strtoupper($antenne?->date_ouverture?->translatedFormat('Y'), 'UTF-8') }}
                                                    </div>
                                                @else
                                                    <div class="popular-badge">{{ $antenne?->code }}</div>
                                                @endif
                                                {{-- <h3>Chef : <span
                                                        class="currency">{{ $antenne?->chef?->user?->firstname . ' ' . $antenne?->chef?->user?->name }}</span>
                                                </h3> --}}
                                                <h4>ZONE DE COUVERTURE</h4>
                                                <ul class="features-list">
                                                    @foreach ($antenne?->regions as $region)
                                                        @if (!empty($region))
                                                            <li>
                                                                <i class="bi bi-check-circle-fill"></i>
                                                                {{ 'REGION DE ' . $region?->nom }}
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                                <h4>CONTACT</h4>
                                                <p><i class="bi bi-telephone"></i>
                                                    {{ $antenne?->contact . ' / ' . $antenne?->chef?->user?->telephone }}
                                                </p>
                                                <p><i class="bi bi-envelope"></i>
                                                    {{ $antenne?->chef?->user?->email }}
                                                </p>
                                                <h4>ADRESSE</h4>
                                                <div class="icon-box">
                                                    <p><i class="bi bi-geo-alt"></i> {{ $antenne?->adresse }}</p>
                                                </div>
                                                {{-- <a href="#" class="btn btn-light">
                                                    En savoir plus
                                                    <i class="bi bi-arrow-right"></i>
                                                </a> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @foreach ($posts as $post)
            <div class="modal fade" id="ShowPostModal{{ $post->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $post->titre }}</h5>
                            {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                        </div>
                        <div class="modal-body">
                            <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                <img src="{{ asset($post->getPoste()) }}" class="d-block w-100 main-image rounded-4"
                                    alt="{{ $post->legende }}">
                            </div>
                            <p class="small fst-italic pt-1">{{ $post->name }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm"
                                data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        @include('sweetalert::alert')
    </main>

    @include('footer-accueil')

</body>

</html>
