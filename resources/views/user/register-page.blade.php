<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript">
        function callbackThen(response) {
            // read Promise object
            response.json().then(function(data) {
                console.log(data);
                if (data.success && data.score > 0.5) {
                    console.log('valid recpatcha');
                } else {
                    document.getElementById('registerForm').addEventListener('submit', function(event) {
                        event.preventDefault();
                        alert('recpatcha error');
                    });
                }
            });
        }

        function callbackCatch(error) {
            console.error('Error:', error)
        }
    </script>

    {!! htmlScriptTagJsApi([
        'callback_then' => 'callbackThen',
        'callback_catch' => 'callbackCatch',
    ]) !!}
    <title>Inscription</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon-onfp.png') }}" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Jan 29 2024 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
    {{-- @include('navbar') --}}
    <main>
        <div class="container">
            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div
                            class="col-12 col-md-6 col-lg-6 col-sm-12 col-xs-12 col-xxl-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="{{ route('accueil') }}" class="logo d-flex align-items-center w-auto"
                                    target="_blank">
                                    {{-- <img src="{{ asset('assets/img/logo_sigle.png') }}" alt=""> --}}
                                    <span class="d-none d-lg-block">ONFP</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">
                                    {{-- <div class="d-flex justify-content-center py-0">
                                        <a href="{{ url('/register-page') }}"
                                            class="logo d-flex align-items-center w-auto">
                                            <h5 class="card-title">Création de compte personnel</h5>
                                            <p class="text-center small">Entrez vos informations pour créer un compte</p>
                                        </a>
                                    </div> --}}

                                    <div class="pt-0 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Création compte personnel</h5>
                                        <p class="text-center small">Entrez vos informations pour créer un compte</p>
                                    </div>

                                    <div class="tab-content">
                                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                            <form class="row g-3 needs-validation" novalidate method="POST"
                                                action="{{ route('register') }}">
                                                @csrf

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
                                                    <label for="email" class="form-label">E-mail<span
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
                                                            value="{{ old('password') }}"
                                                            autocomplete="new-password">
                                                        <div class="invalid-feedback">
                                                            @error('password')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Mot de passe de confirmation -->
                                                <div class="col-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-xxl-12">
                                                    <label for="password_confirmation" class="form-label">Confirmez
                                                        mot de
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
                                                        <input
                                                            class="form-check-input @error('termes') is-invalid @enderror"
                                                            name="termes" type="checkbox" value="1"
                                                            id="acceptTerms" required>
                                                        <label class="form-check-label" for="acceptTerms">J'accepte
                                                            les
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
                                                    <button class="btn btn-primary w-100" type="submit">Créer un
                                                        compte personnel ou collectif</button>
                                                </div>
                                                <div
                                                    class="col-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-xxl-12 justify-content-center">
                                                    <p class="small">Vous avez déjà un compte ? <a
                                                            href="{{ url('/login-page') }}">Se connecter</a></p>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            @include('user.termes')
                            <div class="credits">
                                &copy; Copyright <strong><span><a href="https://www.onfp.sn/"
                                            target="_blank">ONFP</a></span></strong>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->


    {{-- @include('layout.footer') --}}

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>
