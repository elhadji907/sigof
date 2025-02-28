@include('header-accueil')

<body class="service-details-page">

    @include('header')

    <main class="main">

        <!-- Page Title -->
        <div class="page-title light-background">
            <div class="container">
                <h1>Guide utilisation</h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="{{ url('/') }}">Accueil</a></li>
                        <li class="current">Guide utilisation</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <!-- Service Details Section -->
        <section id="service-details" class="service-details section">
            <div class="container">
                <div class="row gy-5">
                    <!-- Bloc des ressources -->
                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-box">
                            <h4><i class="bi bi-link-45deg text-2xl mr-2"></i> Ressources Utiles</h4>
                            <div class="services-list">
                                <a href="#" class="video-link active"
                                    data-video="https://www.youtube.com/embed/SJjW_yaZBP4"
                                    data-title="Création d’un compte personnel"
                                    data-description="Cette vidéo vous explique comment créer un compte pour soumettre une demande de formation, qu'elle soit individuelle ou collective, auprès de l'ONFP.">
                                    <i class="bi bi-arrow-right-circle"></i><span>Créer un compte personnel</span>
                                </a>

                                <a href="#" class="video-link"
                                    data-video="https://www.youtube.com/embed/ANOTHER_VIDEO_ID"
                                    data-title="Création d’un compte opérateur"
                                    data-description="Cette vidéo vous guide dans la création d'un compte afin de déposer une demande d'agrément en tant qu'opérateur de formation potentiel auprès de l'ONFP.">
                                    <i class="bi bi-arrow-right-circle"></i><span>Créer un compte opérateur</span>
                                </a>

                                <a href="#" class="video-link"
                                    data-video="https://www.youtube.com/embed/ANOTHER_VIDEO_ID"
                                    data-title="Processus de soummission de demande individuelle"
                                    data-description="Cette vidéo vous guide dans la soumission d'une demande de formation individuelle au sein de l'ONFP">
                                    <i class="bi bi-arrow-right-circle"></i><span>Soumettre demande individuelle</span>
                                </a>

                                <a href="#" class="video-link"
                                    data-video="https://www.youtube.com/embed/ANOTHER_VIDEO_ID"
                                    data-title="Processus de soummission de demande collective"
                                    data-description="Cette vidéo vous guide dans la soumission d'une demande de formation collective au sein de l'ONFP">
                                    <i class="bi bi-arrow-right-circle"></i><span>Soumettre demande collective</span>
                                </a>

                                <a href="#" class="video-link"
                                    data-video="https://www.youtube.com/embed/ANOTHER_VIDEO_ID"
                                    data-title="Processus de soummission de demande agrément opérateur"
                                    data-description="Cette vidéo vous guide dans la soumission d'une demande d'agrément opérateur au sein de l'ONFP">
                                    <i class="bi bi-arrow-right-circle"></i><span>Soumettre demande agrément
                                        opérateur</span>
                                </a>
                                <a href="{{ route('nos-modules') }}" target="_blank"><i class="bi bi-filetype-pdf"></i><span>Nos modules
                                        (PDF)</span></a>
                            </div>
                        </div>

                        <!-- Bloc Téléchargements -->
                        <div class="service-box">
                            <h4>Téléchargements</h4>
                            <div class="download-catalog">
                                <a href="#"><i class="bi bi-filetype-pdf"></i><span>Guide utilisateur
                                        (PDF)</span></a>
                            </div>
                        </div>

                        <!-- Bloc Assistance -->
                        <div class="help-box d-flex flex-column justify-content-center align-items-center">
                            <i class="bi bi-headset help-icon"></i>
                            <h4>Besoin d’aide ?</h4>
                            <p class="d-flex align-items-center mt-2 mb-0"><i class="bi bi-telephone me-2"></i>
                                <span>+221 77 291 33 97</span>
                            </p>
                            <p class="d-flex align-items-center mt-1 mb-0"><i class="bi bi-envelope me-2"></i>
                                <a href="mailto:onfp@onfp.sn">onfp@onfp.sn</a>
                            </p>
                        </div>
                    </div>

                    <!-- Bloc de la vidéo et du contenu dynamique -->
                    <div class="col-lg-8 ps-lg-5" data-aos="fade-up" data-aos-delay="200">
                        <div class="video-container">
                            <iframe id="video-frame" width="100%" height="500"
                                src="https://www.youtube.com/embed/SJjW_yaZBP4" frameborder="0"
                                allowfullscreen></iframe>
                        </div>

                        <!-- Ajout d’une marge entre la vidéo et le contenu -->
                        <div class="video-content mt-4">
                            <h3 id="video-title" class="fw-bold">Création d’un compte personnel</h3>
                            <div id="video-description">
                                Cette vidéo vous explique comment créer un compte pour soumettre une demande de
                                formation, qu'elle soit individuelle ou collective, auprès de l'ONFP.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- /Service Details Section -->

    </main>

    @include('footer-accueil')

</body>

</html>
