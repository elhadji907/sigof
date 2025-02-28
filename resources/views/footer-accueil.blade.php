<footer id="footer" class="footer">

    <div class="container footer-top">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6 footer-about">
                <a href="{{ url('/') }}" class="logo d-flex align-items-center">
                    <span class="sitename">SIGOF</span>
                </a>
                <div class="footer-contact pt-0">
                    <p>Direction générale (Dakar & Thiès)</p>
                    <p>Sipres 1, lot 2</p>
                    <p>2 voies liberté 6, extension VDN</p>
                    <p class="mt-3"><strong>Téléphone:</strong> <span><a href="tel:+2211338279251">+221 33 827
                                92 51</a></span></p>
                    <p><strong>Email:</strong> <span><a href="mailto:onfp@onfp.sn">onfp@onfp.sn</a></span></p>
                </div>
                <div class="social-links d-flex mt-4">
                    <a href="https://x.com/ONFP_Officiel/" target="_blank"><i class="bi bi-twitter-x"></i></a>
                    <a href="https://www.facebook.com/profile.php?id=61566912421177" target="_blank"><i
                            class="bi bi-facebook"></i></a>
                    <a href="https://www.instagram.com/onfp.sn/" target="_blank"><i class="bi bi-instagram"></i></a>
                    <a href="https://www.linkedin.com/company/104719756/admin/page-posts/published/" target="_blank"><i
                            class="bi bi-linkedin"></i></a>
                    <a href="https://www.youtube.com/@onfp9383/featured" target="_blank"><i
                            class="bi bi-youtube"></i></a>
                    <a href="https://wa.me/221772911838" target="_blank"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Réseaux sociaux</h4>
                <ul>
                    <li><a href="#accueil">Accueil</a></li>
                    <li><a href="#apropos">A propos</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#partenaires">Partenaires</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>

            {{-- <div class="col-lg-2 col-md-3 footer-links">
                <h4>Nos services</h4>
                <ul>
                    <li><a href="#">Web Design</a></li>
                    <li><a href="#">Web Development</a></li>
                    <li><a href="#">Product Management</a></li>
                    <li><a href="#">Marketing</a></li>
                    <li><a href="#">Graphic Design</a></li>
                </ul>
            </div> --}}

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Nos antennes</h4>
                <ul>
                    @foreach ($antennes as $antenne)
                        <li><a href="#" data-bs-toggle="modal"
                                data-bs-target="#antenneModal{{ $antenne?->id }}">{{ $antenne?->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="contact-form col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 footer-links">
                <h4>Connexion</h4>
                <ul>
                    {{-- <li><a data-bs-toggle="modal" data-bs-target="#loginModal">Se connecter</a></li>
                    <li><a data-bs-toggle="modal" data-bs-target="#registerDemandeurModal">Créer un compte
                            personnel</a></li>
                    <li><a data-bs-toggle="modal" data-bs-target="#registerOperateurModal">Créer un compte
                            opérateur</a></li> --}}

                    <div class="modal-content">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                        {{-- <label for="email" class="form-label">Email<span
                                                class="text-danger mx-1">*</span></label> --}}
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                                            <input type="email" name="email"
                                                class="form-control @error('email') is-invalid @enderror" id="email"
                                                required placeholder="Votre adresse e-mail" value="{{ old('email') }}">
                                            <div class="invalid-feedback">
                                                @error('email')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                        {{-- <label for="password" class="form-label">Mot de passe<span
                                                class="text-danger mx-1">*</span></label> --}}
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend"><i
                                                    class="bi bi-key"></i></span>
                                            <input type="password" name="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="password" required placeholder="Votre mot de passe">
                                            <div class="invalid-feedback">
                                                @error('password')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
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

                                    <div
                                        class="col-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-xxl-12 justify-content-center">
                                        @if (Route::has('password.request'))
                                            <p class="small mb-0">Mot de passe oublié !
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#forgotModal">
                                                    Réinitialiser</a>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                        </form>
                </ul>

                {{-- <div class="footer-links">
                    <h4>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="submit" class="dropdown-item show_confirm_disconnect">Se
                                déconnecter</button>
                        </form>
                    </h4>
                </div> --}}

            </div>
        </div>
    </div>

    @include('user.termes')

    <div class="container copyright text-center mt-4">
        <p>© <span>Copyright</span> <strong class="px-1 sitename">SIGOF</strong> <span></span></p>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you've purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
            Conçu par <a href="https://www.onfp.sn/" target="_blank">ONFP</a>, MAI 2024
        </div>
    </div>

</footer>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="{{ asset('asset/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('asset/vendor/php-email-form/validate.js') }}"></script>
<script src="{{ asset('asset/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('asset/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('asset/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('asset/vendor/purecounter/purecounter_vanilla.js') }}"></script>

<!-- Main JS File -->
<script src="{{ asset('asset/js/main.js') }}"></script>

<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
    crossorigin="anonymous"></script>

<script>
    setTimeout(function() {
        $('.alert-success').remove();
    }, 120000);
</script>

<script>
    setTimeout(function() {
        $('.alert-danger').remove();
    }, 120000);
</script>

<script>
    function myFunction() {
        var element = document.body;
        element.dataset.bsTheme =
            element.dataset.bsTheme == "light" ? "dark" : "light";
    }

    function stepFunction(event) {
        debugger;
        var element = document.getElementsByClassName(("html")[0].innerHTML);
        for (var i = 0; i < element.length; i++) {
            if (element[i] !== event.target.ariaControls) {
                element[i].classList.remove("show");
            }
        }
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const videoLinks = document.querySelectorAll(".video-link");
        const videoFrame = document.getElementById("video-frame");
        const videoTitle = document.getElementById("video-title");
        const videoDescription = document.getElementById("video-description");

        videoLinks.forEach(link => {
            link.addEventListener("click", function(event) {
                event.preventDefault(); // Évite le rechargement de la page

                // Retirer la classe active des autres liens et l'ajouter au lien sélectionné
                videoLinks.forEach(l => l.classList.remove("active"));
                this.classList.add("active");

                // Mettre à jour la vidéo
                const videoURL = this.getAttribute("data-video");
                if (videoURL) {
                    videoFrame.src = videoURL;
                }

                // Mise à jour du titre
                videoTitle.textContent = this.getAttribute("data-title") ||
                    "Vidéo non disponible";

                // Mise à jour de la description avec du HTML
                const descriptionHTML = this.getAttribute("data-description") ||
                    "<ul><li>Aucune description disponible.</li></ul>";
                videoDescription.innerHTML = descriptionHTML;
            });
        });
    });
</script>

