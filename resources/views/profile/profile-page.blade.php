@extends('layout.user-layout')
@section('title', 'ONFP | Mon profil')
@section('space-work')
    <div class="pagetitle">
        <h1>Profil</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                <li class="breadcrumb-item">Utilisateurs</li>
                <li class="breadcrumb-item active">Profil</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row justify-content-center">
            {{-- Début Photo de profil --}}
            <div class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            {{-- <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle"> --}}
                            <img class="rounded-circle w-25" alt="Profil" src="{{ asset(Auth::user()?->getImage()) }}"
                                width="50" height="auto">

                            <h2>
                                @if (!empty(Auth::user()?->name))
                                    {{ Auth::user()?->civilite . ' ' . Auth::user()?->firstname . ' ' . Auth::user()?->name }}
                                @else
                                    {{ Auth::user()?->username }}
                                @endif
                            </h2>
                            @if (!empty(Auth::user()?->situation_professionnelle))
                                <span><a href="">{{ Auth::user()?->situation_professionnelle }}</a></span>
                            @endif
                            {{-- <h3>
                            @foreach (Auth::user()->roles as $role)
                                <span>{{ $role->name }} |</span>
                            @endforeach
                        </h3> --}}
                            <div class="social-links mt-2">
                                @if (!empty(Auth::user()?->twitter))
                                    <a href="{{ Auth::user()?->twitter }}" class="twitter" target="_blank"><i
                                            class="bi bi-twitter"></i></a>
                                @endif
                                @if (!empty(Auth::user()?->facebook))
                                    <a href="{{ Auth::user()?->facebook }}" class="facebook" target="_blank"><i
                                            class="bi bi-facebook"></i></a>
                                @endif
                                @if (!empty(Auth::user()?->instagram))
                                    <a href="{{ Auth::user()?->instagram }}" class="instagram" target="_blank"><i
                                            class="bi bi-instagram"></i></a>
                                @endif
                                @if (!empty(Auth::user()?->linkedin))
                                    <a href="{{ Auth::user()?->linkedin }}" class="linkedin" target="_blank"><i
                                            class="bi bi-linkedin"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @role('Employe')
                    <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                        <div class="card">
                            <div class="card-body pb-0">
                                <h5 class="card-title">Demandes <span>| Personnelles</span></h5>

                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th scope="col">Demande</th>
                                            <th scope="col" class="text-center">Nombre</th>
                                            <th scope="col" class="text-center">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-primary">Individuelle</td>
                                            <td class="text-center">
                                                {{ count($individuelles) }}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('demandesIndividuelle') }}" title="voir"><i
                                                        class="bi bi-eye"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-primary">Collective</td>
                                            <td class="text-center">
                                                {{ count($collectives) }}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('demandesCollective') }}" title="voir"><i
                                                        class="bi bi-eye"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                @endrole

                @if (!empty($nouvelle_formation_count))
                    <div class="col-12">
                        <a href="{{ route('nouvellesformations') }}">
                            <div class="card shadow-lg border-0 rounded-lg">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h5 class="card-title text-info d-flex align-items-center">
                                            <i class="bi bi-graduation-cap me-0"></i> Nouvelle <span class="fw-bold">&nbsp;|
                                                Formation</span>
                                        </h5>
                                        <p class="text-muted">Nouvelles formations disponibles.</p>
                                    </div>
                                    <div class="card-icon bg-info text-white rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 30px; height: 30px; font-size: 1.2rem;">
                                        {{ $nouvelle_formation_count }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @else
                    <div class="alert alert-info">Aucune notification vous concernant pour l'instant !</div>
                @endif
            </div>
            {{-- Fin Photo de profil --}}

            {{-- Début aperçu --}}
            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                <div class="flex items-center gap-4">
                    <div class="card">
                        @if ($message = Session::get('status'))
                            <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show"
                                role="alert">
                                <strong>{{ $message }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if ($message = Session::get('message'))
                            <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show"
                                role="alert">
                                <strong>{{ $message }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if ($errors->updatePassword->get('current_password'))
                            <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show"
                                role="alert">
                                <strong><x-input-error :messages="$errors->updatePassword->get('current_password')" /></strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show"
                                    role="alert"><strong>{{ $error }}</strong></div>
                            @endforeach
                        @endif
                        <div class="card-body pt-3">
                            <ul class="nav nav-tabs nav-tabs-bordered">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                        data-bs-target="#profile-overview">Aperçu</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Modifier
                                        profil
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#profile-change-password">Changer le mot de passe</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#files">Fichiers</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link">
                                        <a style="text-decoration: none; color: black"
                                            href="{{ route('mesformations') }}" title="voir">Formations</a>
                                    </button>
                                </li>

                            </ul>
                            <div class="tab-content pt-2">
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <h5 class="card-title">À propos</h5>
                                    <p class="small fst-italic">
                                        créé, {{ Auth::user()->created_at->diffForHumans() }}
                                    </p>

                                    <div class="row">
                                        <div class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 label">
                                            Informations personnelles
                                        </div>
                                        <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                            @if (!empty(Auth::user()->cin))
                                                <span class="badge bg-success text-white">Complètes</span>
                                            @else
                                                <span class="badge bg-warning text-white">Incomplètes</span>, cliquez sur
                                                l'onglet modifier profil pour complèter
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 label">
                                            Fichiers joints
                                        </div>
                                        <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                            @if (!empty($user_cin))
                                                <span class="badge bg-primary text-white">Valide</span>
                                            @else
                                                <span class="badge bg-warning text-white">Incomplètes</span>, cliquez sur
                                                l'onglet fichier pour télécharger
                                            @endif
                                        </div>
                                    </div>

                                    @if (Auth::user()?->cin)
                                        <div class="row">
                                            <div class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 label">CIN
                                            </div>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                {{ Auth::user()->cin }}</div>
                                        </div>
                                    @endif

                                    @if (Auth::user()?->username)
                                        <div class="row">
                                            <div class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 label">
                                                Username
                                            </div>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                {{ Auth::user()->username }}</div>
                                        </div>
                                    @endif

                                    @if (Auth::user()?->firstname)
                                        <div class="row">
                                            <div class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 label">
                                                Prénom
                                            </div>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                {{ format_proper_name(Auth::user()->firstname) }}</div>
                                        </div>
                                    @endif

                                    @if (Auth::user()?->name)
                                        <div class="row">
                                            <div class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 label">Nom
                                            </div>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                {{ Auth::user()->name }}</div>
                                        </div>
                                    @endif

                                    @if (Auth::user()?->date_naissance)
                                        <div class="row">
                                            <div class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 label">Date
                                                naissance
                                            </div>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                {{ Auth::user()->date_naissance->translatedFormat('l jS F Y') }}</div>
                                        </div>
                                    @endif

                                    @if (Auth::user()?->lieu_naissance)
                                        <div class="row">
                                            <div class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 label">Lieu
                                                naissance
                                            </div>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                {{ Auth::user()->lieu_naissance }}</div>
                                        </div>
                                    @endif

                                    @if (Auth::user()?->email)
                                        <div class="row">
                                            <div class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 label">Email
                                            </div>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8"><a
                                                    href="mailto:{{ Auth::user()->email }}">{{ Auth::user()->email }}</a>
                                            </div>
                                        </div>
                                    @endif

                                    @if (Auth::user()?->telephone)
                                        <div class="row">
                                            <div class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 label">
                                                Téléphone
                                            </div>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8"><a
                                                    href="tel:+221{{ Auth::user()->telephone }}">{{ Auth::user()->telephone }}</a>
                                            </div>
                                        </div>
                                    @endif

                                    @if (Auth::user()?->adresse)
                                        <div class="row">
                                            <div class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 label">
                                                Adresse
                                            </div>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                {{ remove_accents_uppercase(Auth::user()->adresse) }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            {{-- Fin aperçu --}}
                            <div class="tab-content pt-2">
                                {{-- Début Edition --}}
                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                    <form method="post" action="{{ route('profile.update', Auth::user()->id) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('patch')
                                        <h5 class="card-title">Modification du profil</h5>
                                        <!-- Profile Edit Form -->

                                        <div class="row mb-3">
                                            <label for="profileImage"
                                                class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 col-form-label">
                                                Image de profil
                                            </label>
                                            {{-- <div class="col-md-8 col-lg-9"> --}}
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                <img class="rounded-circle w-25" alt="Profil"
                                                    src="{{ asset(Auth::user()->getImage()) }}" width="50"
                                                    height="auto">

                                                <div class="pt-2 d-flex align-items-center gap-2">
                                                    <div class="form-group mb-0">
                                                        <label for="image" class="btn btn-primary btn-sm text-white"
                                                            title="Image de profil">
                                                            <i class="bi bi-upload"></i>
                                                            <input type="file" name="image" id="image"
                                                                accept=".jpg, .jpeg, .png, .svg, .gif"
                                                                class="form-control d-none @error('image') is-invalid @enderror">
                                                        </label>
                                                        @error('image')
                                                            <span class="text-danger d-block">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    @auth
                                                        @if (optional(Auth::user())?->image)
                                                            <div class="d-inline">
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm show_confirmDeleteImage"
                                                                    data-url="{{ route('profile.image.destroy') }}"
                                                                    title="Supprimer l'image de profil">
                                                                    <span class="badge border-danger border-1 text-danger">
                                                                        <i class="bi bi-trash"></i>
                                                                    </span>
                                                                </button>
                                                            </div>
                                                        @endif
                                                    @endauth
                                                </div>
                                            </div>
                                        </div>

                                        {{-- CIN --}}
                                        <div class="row mb-3">
                                            <label for="cin"
                                                class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 col-form-label">N°
                                                CIN (NIN)<span class="text-danger mx-1">*</span>
                                            </label>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                <div class="pt-2">
                                                    <input name="cin" type="text"
                                                        class="form-control form-control-sm @error('cin') is-invalid @enderror"
                                                        id="cin" value="{{ $user?->cin ?? old('cin') }}"
                                                        autocomplete="off" placeholder="Ex: 1 099 2005 00012"
                                                        minlength="16" maxlength="17" required>
                                                </div>
                                                @error('cin')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Username --}}
                                        <div class="row mb-3">
                                            <label for="username"
                                                class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 col-form-label">Username<span
                                                    class="text-danger mx-1">*</span>
                                            </label>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                <div class="pt-2">
                                                    <input name="username" type="text"
                                                        class="form-control form-control-sm @error('username') is-invalid @enderror"
                                                        id="username" value="{{ $user->username ?? old('username') }}"
                                                        autocomplete="username" placeholder="Votre username">
                                                </div>
                                                @error('username')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Civilité --}}
                                        <div class="row mb-3">
                                            <label for="Civilité"
                                                class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 col-form-label">Civilité<span
                                                    class="text-danger mx-1">*</span>
                                            </label>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                <div class="pt-2">
                                                    <select name="civilite"
                                                        class="form-select form-select-sm @error('civilite') is-invalid @enderror"
                                                        aria-label="Select" id="select-field-civilite"
                                                        data-placeholder="Choisir civilité">
                                                        <option value="{{ $user->civilite ?? old('civilite') }}">
                                                            {{ $user->civilite ?? old('civilite') }}
                                                        </option>
                                                        <option value="M.">
                                                            Monsieur
                                                        </option>
                                                        <option value="Mme">
                                                            Madame
                                                        </option>
                                                    </select>
                                                    @error('civilite')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Prénom --}}
                                        <div class="row mb-3">
                                            <label for="firstname"
                                                class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 col-form-label">Prénom<span
                                                    class="text-danger mx-1">*</span>
                                            </label>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                <div class="pt-2">
                                                    <input name="firstname" type="text"
                                                        class="form-control form-control-sm @error('firstname') is-invalid @enderror"
                                                        id="firstname" value="{{ $user->firstname ?? old('firstname') }}"
                                                        autocomplete="firstname" placeholder="Votre prénom">
                                                </div>
                                                @error('firstname')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- Nom --}}
                                        <div class="row mb-3">
                                            <label for="name"
                                                class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 col-form-label">Nom<span
                                                    class="text-danger mx-1">*</span></label>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                <input name="name" type="text"
                                                    class="form-control form-control-sm @error('name') is-invalid @enderror"
                                                    id="name" value="{{ $user->name ?? old('name') }}"
                                                    autocomplete="name" placeholder="Votre Nom">
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <div>{{ $message }}</div>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- Date de naissance --}}
                                        <div class="row mb-3">
                                            <label for="date_naissance"
                                                class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 col-form-label">Date
                                                naissance<span class="text-danger mx-1">*</span></label>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                <input type="text" name="date_naissance"
                                                    value="{{ old('date_naissance', optional($user->date_naissance)->format('d/m/Y')) }}"
                                                    class="form-control form-control-sm @error('date_naissance') is-invalid @enderror"
                                                    id="datepicker" placeholder="JJ/MM/AAAA" autocomplete="bday">
                                                @error('date_naissance')
                                                    <span class="invalid-feedback" role="alert">
                                                        <div>{{ $message }}</div>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- Lieu naissance --}}
                                        <div class="row mb-3">
                                            <label for="lieu naissance"
                                                class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 col-form-label">Lieu
                                                naissance<span class="text-danger mx-1">*</span></label>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                <input name="lieu_naissance" type="text"
                                                    class="form-control form-control-sm @error('lieu_naissance') is-invalid @enderror"
                                                    id="lieu_naissance"
                                                    value="{{ $user->lieu_naissance ?? old('lieu_naissance') }}"
                                                    autocomplete="lieu_naissance" placeholder="Votre Lieu naissance">
                                                @error('lieu_naissance')
                                                    <span class="invalid-feedback" role="alert">
                                                        <div>{{ $message }}</div>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- Email --}}
                                        <div class="row mb-3">
                                            <label for="Email"
                                                class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 col-form-label">Email<span
                                                    class="text-danger mx-1">*</span></label>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                <input name="email" type="email" readonly
                                                    class="form-control form-control-sm @error('email') is-invalid @enderror"
                                                    id="Email" value="{{ $user->email ?? old('email') }}"
                                                    autocomplete="email" placeholder="Votre adresse e-mail">
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <div>{{ $message }}</div>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Telephone --}}
                                        <div class="row mb-3">
                                            <label for="telephone"
                                                class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 col-form-label">Téléphone<span
                                                    class="text-danger mx-1">*</span></label>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                <input name="telephone" type="text" maxlength="12"
                                                    class="form-control form-control-sm @error('telephone') is-invalid @enderror"
                                                    id="telephone" value="{{ old('telephone', $user->telephone ?? '') }}"
                                                    autocomplete="tel" placeholder="XX:XXX:XX:XX">
                                                @error('telephone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <div>{{ $message }}</div>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Adresse --}}
                                        <div class="row mb-3">
                                            <label for="adresse"
                                                class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 col-form-label">Adresse<span
                                                    class="text-danger mx-1">*</span></label>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                <input name="adresse" type="adresse"
                                                    class="form-control form-control-sm @error('adresse') is-invalid @enderror"
                                                    id="adresse" value="{{ $user->adresse ?? old('adresse') }}"
                                                    autocomplete="adresse" placeholder="Votre adresse de résidence">
                                                @error('adresse')
                                                    <span class="invalid-feedback" role="alert">
                                                        <div>{{ $message }}</div>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Situation familiale --}}
                                        <div class="row mb-3">
                                            <label for="adresse"
                                                class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 col-form-label">Situation
                                                familiale<span class="text-danger mx-1">*</span></label>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                <select name="situation_familiale"
                                                    class="form-select form-select-sm @error('situation_familiale') is-invalid @enderror"
                                                    aria-label="Select" id="select-field-familiale"
                                                    data-placeholder="Choisir situation familiale">
                                                    <option
                                                        value="{{ $user->situation_familiale ?? old('situation_familiale') }}">
                                                        {{ $user->situation_familiale ?? old('situation_familiale') }}
                                                    </option>
                                                    <option value="Marié(e)">
                                                        Marié(e)
                                                    </option>
                                                    <option value="Célibataire">
                                                        Célibataire
                                                    </option>
                                                    <option value="Veuf(ve)">
                                                        Veuf(ve)
                                                    </option>
                                                    <option value="Divorsé(e)">
                                                        Divorsé(e)
                                                    </option>
                                                </select>
                                                @error('situation_familiale')
                                                    <span class="invalid-feedback" role="alert">
                                                        <div>{{ $message }}</div>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Situation professionnelle --}}
                                        <div class="row mb-3">
                                            <label for="adresse"
                                                class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 col-form-label">Situation
                                                professionnelle<span class="text-danger mx-1">*</span></label>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                <select name="situation_professionnelle"
                                                    class="form-select  @error('situation_professionnelle') is-invalid @enderror"
                                                    aria-label="Select" id="select-field-professionnelle"
                                                    data-placeholder="Choisir situation professionnelle">
                                                    <option
                                                        value="{{ $user->situation_professionnelle ?? old('situation_professionnelle') }}">
                                                        {{ $user->situation_professionnelle ?? old('situation_professionnelle') }}
                                                    </option>
                                                    <option value="Employé(e)">
                                                        Employé(e)
                                                    </option>
                                                    <option value="Informel">
                                                        Informel
                                                    </option>
                                                    <option value="Elève ou étudiant">
                                                        Elève ou étudiant
                                                    </option>
                                                    <option value="chercheur emploi">
                                                        chercheur emploi
                                                    </option>
                                                    <option value="Stage ou période essai">
                                                        Stage ou période essai
                                                    </option>
                                                    <option value="Entrepreneur ou freelance">
                                                        Entrepreneur ou freelance
                                                    </option>
                                                </select>
                                                @error('situation_professionnelle')
                                                    <span class="invalid-feedback" role="alert">
                                                        <div>{{ $message }}</div>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- facebook --}}
                                        <div class="row mb-3">
                                            <label for="facebook"
                                                class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 col-form-label">Facebook
                                                profil</label>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                <input name="facebook" type="facebook"
                                                    class="form-control form-control-sm @error('facebook') is-invalid @enderror"
                                                    id="facebook" value="{!! $user->facebook ?? old('facebook') !!}"
                                                    autocomplete="facebook"
                                                    placeholder="Entrez l'URL de votre compte facebook">
                                                @error('facebook')
                                                    <span class="invalid-feedback" role="alert">
                                                        <div>{{ $message }}</div>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- twitter --}}
                                        <div class="row mb-3">
                                            <label for="twitter"
                                                class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 col-form-label">X
                                                profil (ex
                                                twitter)</label>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                <input name="twitter" type="twitter"
                                                    class="form-control form-control-sm @error('twitter') is-invalid @enderror"
                                                    id="twitter" value="{{ $user->twitter ?? old('twitter') }}"
                                                    autocomplete="twitter"
                                                    placeholder="Entrez l'URL de votre compte x (ex twitter)">
                                                @error('twitter')
                                                    <span class="invalid-feedback" role="alert">
                                                        <div>{{ $message }}</div>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- instagram --}}
                                        <div class="row mb-3">
                                            <label for="instagram"
                                                class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 col-form-label">Instagram
                                                profil</label>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                <input name="instagram" type="instagram"
                                                    class="form-control form-control-sm @error('instagram') is-invalid @enderror"
                                                    id="instagram" value="{{ $user->instagram ?? old('instagram') }}"
                                                    autocomplete="instagram"
                                                    placeholder="Entrez l'URL de votre compte instagram">
                                                @error('instagram')
                                                    <span class="invalid-feedback" role="alert">
                                                        <div>{{ $message }}</div>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- linkedin --}}
                                        <div class="row mb-3">
                                            <label for="linkedin"
                                                class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 col-form-label">Linkedin
                                                profil</label>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                <input name="linkedin" type="linkedin"
                                                    class="form-control form-control-sm @error('linkedin') is-invalid @enderror"
                                                    id="linkedin" value="{{ $user->linkedin ?? old('linkedin') }}"
                                                    autocomplete="linkedin"
                                                    placeholder="Entrez l'URL de votre ompte linkedin">
                                                @error('linkedin')
                                                    <span class="invalid-feedback" role="alert">
                                                        <div>{{ $message }}</div>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- Scan CIN --}}
                                        {{-- <div class="row mb-3">
                                            <label for="scan_cin"
                                                class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 col-form-label">SCAN
                                                CIN Recto/Verso
                                                profil<span class="text-danger mx-1">*</span></label>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                <input type="file" name="scan_cin" id="scan_cin"
                                                    class="form-control @error('scan_cin') is-invalid @enderror btn btn-primary btn-sm">
                                                @error('scan_cin')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                                @error('scan_cin')
                                                    <span class="invalid-feedback" role="alert">
                                                        <div>{{ $message }}</div>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> --}}
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-info btn-sm">Sauvegarder les
                                                modifications</button>
                                        </div>
                                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                            <div>
                                                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                                    {{ __('Votre adresse e-mail n\'est pas vérifiée.') }}

                                                    {{--  <button form="send-verification"
                                                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                                        {{ __('Cliquez ici pour renvoyer l\'e-mail de vérification.') }}
                                                    </button> --}}
                                                <form method="POST" action="{{ route('verification.send') }}">
                                                    @csrf

                                                    <div>
                                                        <button type="submit"
                                                            class="btn btn-outline-primary">{{ __('Cliquez ici pour renvoyer l\'e-mail de vérification.') }}</button>
                                                        {{--  <x-primary-button>
                                                                        {{ __('Renvoyer l\'e-mail de vérification') }}
                                                                    </x-primary-button> --}}
                                                    </div>
                                                </form>
                                                </p>

                                                @if (session('status') === 'verification-link-sent')
                                                    <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                                        {{ __('Un nouveau lien de vérification a été envoyé à votre adresse e-mail.') }}
                                                    </p>
                                                @endif
                                            </div>
                                        @endif
                                        <!-- End Profile Edit Form -->
                                    </form>
                                </div>
                            </div>
                            <div class="tab-content pt-2">
                                {{-- Fin Edition --}}
                                <div class="tab-pane fade pt-3" id="profile-change-password">
                                    <!-- Change Password Form -->
                                    <form method="post" action="{{ route('password.update') }}">
                                        {{-- Début Modification mot de passe --}}
                                        <div class="flex items-center gap-4">
                                            <!-- Bordered Tabs -->
                                            <div class="tab-pane fade show profile-overview" id="profile-overview">
                                                <h5 class="card-title">Modification du mot de passe</h5>
                                                <!-- Change Password Form -->
                                                @csrf
                                                @method('put')
                                                <div class="row mb-3">
                                                    <label for="update_password_current_password"
                                                        class="col-md-4 col-lg-3 col-form-label label">Mot de
                                                        passe actuel<span class="text-danger mx-1">*</span></label>
                                                    <div class="col-md-6 col-lg-6">
                                                        <input name="current_password" type="password"
                                                            class="form-control @error('current_password') is-invalid @enderror"
                                                            id="update_password_current_password"
                                                            placeholder="Votre mot de passe actuel"
                                                            autocomplete="current-password">
                                                        {{-- <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" /> --}}
                                                    </div>
                                                </div>
                                                <!-- Mot de passe -->
                                                <div class="row mb-3">
                                                    <label for="password"
                                                        class="col-md-4 col-lg-3 col-form-label label">Mot
                                                        de
                                                        passe<span class="text-danger mx-1">*</span></label>
                                                    <div class="col-md-6 col-lg-6">
                                                        <input type="password" name="password"
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            id="password" placeholder="Votre mot de passe"
                                                            value="{{ old('password') }}" autocomplete="new-password">
                                                        <div class="invalid-feedback">
                                                            @error('password')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Mot de passe de confirmation -->
                                                <div class="row mb-3">
                                                    <label for="password_confirmation"
                                                        class="col-md-4 col-lg-3 col-form-label label">Confirmez<span
                                                            class="text-danger mx-1">*</span></label>
                                                    <div class="col-md-6 col-lg-6">
                                                        <input type="password" name="password_confirmation"
                                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                                            id="password_confirmation"
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
                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-primary">Changer
                                                        le mot de
                                                        passe</button>
                                                </div>
                                                <!-- End Change Password Form -->
                                            </div>
                                        </div>
                                        {{-- Fin Modification mot de passe --}}
                                    </form><!-- End Change Password Form -->
                                </div>
                            </div><!-- End Bordered Tabs -->


                            <div class="tab-content pt-2">
                                {{-- Début Edition --}}
                                <div class="tab-pane fade files" id="files">
                                    <div class="row mb-3">
                                        <h5 class="card-title col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            FICHIERS JOINTS</h5>
                                        <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                            <table class="table table-bordered table-hover datatables" id="table-iles">
                                                <thead>
                                                    <tr>
                                                        <th width="5%" class="text-center">N°</th>
                                                        <th>Légende</th>
                                                        <th width="10%" class="text-center">File</th>
                                                        <th width="5%" class="text-center"><i class="bi bi-gear"></i>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1; ?>
                                                    @foreach ($files as $file)
                                                        <tr>
                                                            <td class="text-center">{{ $i++ }}</td>
                                                            <td>{{ $file?->legende }}</td>
                                                            <td class="text-center">
                                                                <a class="btn btn-default btn-sm"
                                                                    title="télécharger le fichier joint" target="_blank"
                                                                    href="{{ asset($file->getFichier()) }}">
                                                                    <i class="bi bi-download"></i>
                                                                </a>
                                                            </td>
                                                            <td class="text-center">
                                                                <form action="{{ route('fileDestroy') }}" method="post">
                                                                    @csrf
                                                                    @method('put')
                                                                    <input type="hidden" name="idFile"
                                                                        value="{{ $file->id }}">
                                                                    <button type="submit"
                                                                        style="background:none;border:0px;"
                                                                        class="show_confirm" title="retirer">
                                                                        <span
                                                                            class="badge border-danger border-1 text-danger">
                                                                            <i class="bi bi-trash"></i>
                                                                        </span>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <form method="post" action="{{ route('files.update', $user?->id) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('patch')
                                        <h5 class="card-title">{{ __("Ajouter d'autres fichiers") }}</h5>
                                        <span style="color:red;">NB:</span>
                                        <span>Seule la Carte Nationale d'Identité (recto/verso) </span><span
                                            style="color:red;"> est requise</span>.
                                        <!-- Profile Edit Form -->
                                        <div class="row mb-3 mt-3">
                                            <label for="legende"
                                                class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 col-form-label">Légende<span
                                                    class="text-danger mx-1">*</span></label>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                {{-- <input name="legende" type="text"
                                                    class="form-control form-control-sm @error('legende') is-invalid @enderror"
                                                    id="legende" value="{{ old('legende') }}" autocomplete="legende"
                                                    placeholder="Légende"> --}}
                                                <select name="legende"
                                                    class="form-select  @error('legende') is-invalid @enderror"
                                                    aria-label="Select" id="select-field-file"
                                                    data-placeholder="Choisir">
                                                    <option value="{{ old('legende') }}">

                                                    </option>
                                                    @foreach ($user_files as $file)
                                                        <option value="{{ $file?->id }}">
                                                            {{ $file?->legende }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('legende')
                                                    <span class="invalid-feedback" role="alert">
                                                        <div>{{ $message }}</div>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="file"
                                                class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 col-form-label">Fichier<span
                                                    class="text-danger mx-1">*</span></label>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                <div class="pt-2">
                                                    <input type="file" name="file" id="file"
                                                        class="form-control @error('file') is-invalid @enderror btn btn-primary btn-sm">
                                                    @error('file')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="file"
                                                class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 col-form-label"><span
                                                    class="text-danger mx-1"></span></label>
                                            <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                <div class="pt-2">
                                                    <button type="submit" class="btn btn-info btn-sm">Ajouter</button>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @role('Demandeur')
        <section class="section dashboard">
            <div class="row">
                <!-- Left side columns -->
                <div class="col-lg-12">
                    <div class="row">
                        <!-- Sales Card -->
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="card info-card sales-card">
                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                            class="bi bi-three-dots"></i></a>
                                </div>
                                <a href="{{ route('demandesIndividuelle') }}">
                                    <div class="card-body">
                                        <h5 class="card-title">Demandes <span>| Individuelles</span></h5>
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-person-plus-fill"></i>
                                                {{ count($individuelles) }}
                                            </div>
                                            <div class="ps-3">
                                                <h6>
                                                    {{-- @foreach (Auth::user()->individuelles as $individuelle)
                                                @if (isset($individuelle->numero) && isset($individuelle->modules_id))
                                                    @if ($loop->last)
                                                        {!! $loop->count ?? '0' !!}
                                                    @endif
                                                @else
                                                    <span class="text-primary">0</span>
                                                @endif
                                            @endforeach --}}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="card info-card sales-card">
                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                            class="bi bi-three-dots"></i></a>
                                </div>
                                <a href="{{ route('demandesCollective') }}">
                                    <div class="card-body">
                                        <h5 class="card-title">Demandes <span>| collectives</span></h5>
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-person-plus-fill"></i>
                                                {{ count($collectives) }}
                                            </div>
                                            <div class="ps-3">
                                                <h6>
                                                    {{-- @foreach (Auth::user()->collectives as $collective)
                                                @if (isset($collective->numero))
                                                    @if ($loop->last)
                                                        {!! $loop->count ?? '0' !!}
                                                    @endif
                                                @else
                                                    <span class="text-primary">0</span>
                                                @endif
                                            @endforeach --}}
                                                </h6>
                                                {{-- <span class="text-success small pt-1 fw-bold">12%</span> <span
                                            class="text-muted small pt-2 ps-1">increase</span> --}}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        @foreach ($projets as $projet)
                            <?php
                            $projet_count = $projet?->individuelles?->where('projets_id', $projet?->id)?->where('users_id', $user?->id)?->count() ?? 0;
                            ?>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="card info-card sales-card">
                                    <div class="filter">
                                        <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                                class="bi bi-three-dots"></i></a>
                                    </div>
                                    <a href="{{ route('projetsIndividuelle', ['id' => $projet?->id]) }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $projet?->type_projet }} <span>|
                                                    {{ $projet?->sigle }}</span></h5>
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-person-plus-fill"></i>
                                                    <span>{{ $projet_count }}</span>
                                                </div>
                                                <div class="ps-3">
                                                    <span>
                                                        <span
                                                            class="btn btn-sm {{ $projet?->statut }}">{{ $projet?->statut }}</span><br>
                                                        <span
                                                            class="text-muted small pt-2 ps-1">{{ 'Clôture, le ' . date_format(date_create($projet?->date_fermeture), 'd/m/Y') }}</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endrole

    <div class="row">
        {{-- DIOF --}}
        @role('DIOF')
            @if (!empty($nouvelle_formation_count))
                <div class="col-12 col-md-4 col-lg-3 col-sm-12 col-xs-12 col-xxl-3">
                    <a href="#">
                        <div class="card shadow-lg border-0 rounded-lg">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <h5 class="card-title text-warning d-flex align-items-center">
                                        <i class="bi bi-graduation-cap me-0"></i> Demandes <span class="fw-bold">&nbsp;|
                                            Collectives</span>
                                    </h5>
                                    <p class="text-muted">Nouvelles demandes collectives</p>
                                </div>
                                <div class="card-icon bg-warning text-white rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 30px; height: 30px; font-size: 1.2rem;">
                                    {{ $nouvelle_formation_count }}
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
        @endrole

        {{-- DIOF --}}
        @role('DIOF')
            @if (!empty($nouvelle_formation_count))
                <div class="col-12 col-md-4 col-lg-3 col-sm-12 col-xs-12 col-xxl-3">
                    <a href="#">
                        <div class="card shadow-lg border-0 rounded-lg">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <h5 class="card-title text-secondary d-flex align-items-center">
                                        <i class="bi bi-graduation-cap me-0"></i> Formations <span class="fw-bold">&nbsp;|
                                            DIOF</span>
                                    </h5>
                                    <p class="text-muted">Nouvelles formations</p>
                                </div>
                                <div class="card-icon bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 30px; height: 30px; font-size: 1.2rem;">
                                    {{ $nouvelle_formation_count }}
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
        @endrole

        {{-- Ingénieurs --}}
        @role('Ingenieur')
            @if (!empty($count_ingenieur_formations))
                <div class="col-12 col-md-4 col-lg-3 col-sm-12 col-xs-12 col-xxl-3">
                    <a href="{{ route('ingenieurformations') }}">
                        <div class="card shadow-lg border-0 rounded-lg">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <h5 class="card-title text-primary d-flex align-items-center">
                                        <i class="bi bi-graduation-cap me-0"></i> Formations <span class="fw-bold">&nbsp;|
                                            Ingénieurs</span>
                                    </h5>
                                    <p class="text-muted">Mes formations</p>
                                </div>
                                <div class="card-icon bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 30px; height: 30px; font-size: 1.2rem;">
                                    {{ $count_ingenieur_formations }}
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
        @endrole

        {{-- Courriers --}}
        @hasrole('Employe|super-admin')
            @if (!empty($count_courriers))
                <div class="col-12 col-md-4 col-lg-3 col-sm-12 col-xs-12 col-xxl-3">
                    <a href="{{ route('mescourriers') }}">
                        <div class="card shadow-lg border-0 rounded-lg">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <h5 class="card-title text-success d-flex align-items-center">
                                        <i class="bi bi-graduation-cap me-0"></i> Courriers <span class="fw-bold">&nbsp;|
                                            Personnels</span>
                                    </h5>
                                    <p class="text-muted">Mes courriers</p>
                                </div>
                                <div class="card-icon bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 30px; height: 30px; font-size: 1.2rem;">
                                    {{ $count_courriers }}
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
        @endhasrole
    </div>
@endsection
