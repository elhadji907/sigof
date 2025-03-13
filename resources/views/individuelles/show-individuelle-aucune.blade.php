@extends('layout.user-layout')
@section('title', 'Demande individuelle de ' . Auth::user()->civilite . ' ' . Auth::user()->firstname . ' ' .
    Auth::user()->name)
@section('space-work')
    <section class="section">
        <div class="row justify-content-center">
            <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                @if ($message = Session::get('status'))
                    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" region="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($message = Session::get('success'))
                    <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show"
                        region="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show"
                            role="alert">
                            <strong>{{ $error }}</strong>
                        </div>
                    @endforeach
                @endif
                <div class="card">
                    <div class="card-header text-center bg-gradient-default">
                        <h1 class="h4 text-black mb-0">DEMANDE INDIVIDUELLE</h1>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mt-0">
                            <span class="d-flex align-items-baseline"><a href="{{ url('/profil') }}"
                                    class="btn btn-success btn-sm" title="retour"><i
                                        class="bi bi-arrow-counterclockwise"></i></a>&nbsp;
                                <p> | retour</p>
                            </span>
                            @if (!empty(Auth::user()->cin))
                                <button type="button" class="btn btn-primary btn-sm float-end btn-rounded"
                                    data-bs-toggle="modal" data-bs-target="#AddIndividuelleModal">                                    
                                    {{-- <i class="bi bi-plus" title="Ajouter"></i> --}} Ajouter
                                </button>
                            @endif
                        </div>
                        @if (!empty(Auth::user()->civilite))
                            <h5 class="card-title">
                                Bonjour
                                {{ Auth::user()->civilite . ' ' . Auth::user()->firstname . ' ' . Auth::user()->name }}
                            </h5>
                        @endif
                        @if (isset(Auth::user()->cin))
                            <div class="alert alert-info">Vous n'avez aucune demande individuelle pour le moment !!
                            </div>
                        @else
                            {{-- <h5 class="card-title">Informations personnelles : <a href="{{ route('profil') }}"><span
                                        class="badge bg-warning text-white">Incomplètes</span></a>, cliquez <a
                                    href="{{ route('profil') }}">ici</a> pour modifier votre profil</h5> --}}
                            <div class="text-center">
                                <h5 class="card-title pb-0 fs-4">Complétez d'abord votre profil</h5>
                                <p class="small">Vous devez compléter votre profil avant de pouvoir soumettre une demande
                                    de formation.</p>
                            </div>

                            <form method="post" action="{{ route('profile.update', Auth::user()->id) }}"
                                enctype="multipart/form-data" class="row g-3">
                                @csrf
                                @method('patch')
                                <div class="col-12 col-md-6 col-lg-4 mb-0">
                                    <label for="civilite" class="form-label">Civilité<span
                                            class="text-danger mx-1">*</span></label>
                                    <select name="civilite" class="form-select  @error('civilite') is-invalid @enderror"
                                        aria-label="Select" id="select-field-civilite" data-placeholder="Choisir civilité">
                                        <option value="{{ Auth::user()?->civilite ?? old('civilite') }}">
                                            {{ Auth::user()?->civilite ?? old('civilite') }}
                                        </option>
                                        <option value="M.">
                                            Monsieur
                                        </option>
                                        <option value="Mme">
                                            Madame
                                        </option>
                                    </select>
                                    @error('civilite')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6 col-lg-4 mb-0">
                                    <label for="cin" class="form-label">CIN</label>
                                    <input name="cin" type="text"
                                        class="form-control form-control-sm @error('cin') is-invalid @enderror"
                                        id="cin" value="{{ $user->cin ?? old('cin') }}" autocomplete="off"
                                        placeholder="Ex: 1 099 2005 00012" minlength="16" maxlength="17" required>
                                    @error('cin')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6 col-lg-4 mb-0">
                                    <label for="username" class="form-label">Username<span
                                            class="text-danger mx-1">*</span></label>
                                    <input type="text" name="username"
                                        value="{{ Auth::user()?->username ?? old('username') }}"
                                        class="form-control form-control-sm @error('username') is-invalid @enderror"
                                        id="username" placeholder="username">
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6 col-lg-4 mb-0">
                                    <label for="firstname" class="form-label">Prénom<span
                                            class="text-danger mx-1">*</span></label>
                                    <input type="text" name="firstname"
                                        value="{{ Auth::user()?->firstname ?? old('firstname') }}"
                                        class="form-control form-control-sm @error('firstname') is-invalid @enderror"
                                        id="firstname" placeholder="prénom">
                                    @error('firstname')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6 col-lg-4 mb-0">
                                    <label for="name" class="form-label">Nom<span
                                            class="text-danger mx-1">*</span></label>
                                    <input type="text" name="name" value="{{ Auth::user()?->name ?? old('name') }}"
                                        class="form-control form-control-sm @error('name') is-invalid @enderror"
                                        id="name" placeholder="nom">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6 col-lg-4 mb-0">
                                    <label for="date naissance" class="form-label">Date naissance</label>
                                    <input type="text" name="date_naissance"
                                        value="{{ old('date_naissance', optional(Auth::user()?->date_naissance)->format('d/m/Y')) }}"
                                        class="form-control form-control-sm @error('date_naissance') is-invalid @enderror"
                                        id="datepicker" placeholder="JJ/MM/AAAA" autocomplete="bday">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6 col-lg-4 mb-0">
                                    <label for="lieu_naissance" class="form-label">Lieu naissance</label>
                                    <input type="text" name="lieu_naissance"
                                        value="{{ Auth::user()?->lieu_naissance ?? old('lieu_naissance') }}"
                                        class="form-control form-control-sm @error('lieu_naissance') is-invalid @enderror"
                                        id="lieu_naissance" placeholder="Lieu de naissance">
                                    @error('lieu_naissance')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6 col-lg-4 mb-0">
                                    <label for="email" class="form-label">email<span
                                            class="text-danger mx-1">*</span></label>
                                    <div class="input-group has-validation">
                                        {{-- <span class="input-group-text" id="email">@</span> --}}
                                        <input type="email" name="email"
                                            value="{{ old('email', Auth::user()?->email ?? '') }}" readonly
                                            class="form-control form-control-sm @error('email') is-invalid @enderror"
                                            id="email" placeholder="email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-4 mb-0">
                                    <label for="telephone" class="form-label">Téléphone<span
                                            class="text-danger mx-1">*</span></label>
                                    <input name="telephone" type="text" maxlength="12"
                                        class="form-control form-control-sm @error('telephone') is-invalid @enderror"
                                        id="telephone" value="{{ old('telephone', Auth::user()?->telephone ?? '') }}"
                                        autocomplete="tel" placeholder="XX:XXX:XX:XX">
                                    @error('telephone')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6 col-lg-4 mb-0">
                                    <label for="adresse" class="form-label">Adresse<span
                                            class="text-danger mx-1">*</span></label>
                                    <input type="text" name="adresse"
                                        value="{{ Auth::user()?->adresse ?? old('adresse') }}"
                                        class="form-control form-control-sm @error('adresse') is-invalid @enderror"
                                        id="adresse" placeholder="adresse">
                                    @error('adresse')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6 col-lg-4 mb-0">
                                    <label for="situation_familiale" class="form-label">Situation familiale<span
                                            class="text-danger mx-1">*</span></label>
                                    <select name="situation_familiale"
                                        class="form-select  @error('situation_familiale') is-invalid @enderror"
                                        aria-label="Select" id="select-field-familiale"
                                        data-placeholder="Choisir situation familiale">
                                        <option
                                            value="{{ Auth::user()?->situation_familiale ?? old('situation_familiale') }}">
                                            {{ Auth::user()?->situation_familiale ?? old('situation_familiale') }}
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

                                <div class="col-12 col-md-6 col-lg-4 mb-0">
                                    <label for="situation_profesionnelle" class="form-label">Situation
                                        profesionnelle<span class="text-danger mx-1">*</span></label>
                                    <select name="situation_professionnelle"
                                        class="form-select  @error('situation_professionnelle') is-invalid @enderror"
                                        aria-label="Select" id="select-field-professionnelle"
                                        data-placeholder="Choisir situation professionnelle">
                                        <option
                                            value="{{ Auth::user()?->situation_professionnelle ?? old('situation_professionnelle') }}">
                                            {{ Auth::user()?->situation_professionnelle ?? old('situation_professionnelle') }}
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

                                <div class="col-12 col-md-6 col-lg-4 mb-0">
                                    <label for="adresse" class="form-label">Facebook</label>
                                    <input name="facebook" type="facebook"
                                        class="form-control form-control-sm @error('facebook') is-invalid @enderror"
                                        id="facebook" value="{!! $user->facebook ?? old('facebook') !!}" autocomplete="facebook"
                                        placeholder="Entrez l'URL de votre compte facebook">
                                    @error('facebook')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6 col-lg-4 mb-0">
                                    <label for="adresse" class="form-label">X (ex twitter)</label>
                                    <input name="twitter" type="twitter"
                                        class="form-control form-control-sm @error('twitter') is-invalid @enderror"
                                        id="twitter" value="{!! $user->twitter ?? old('twitter') !!}" autocomplete="twitter"
                                        placeholder="Entrez l'URL de votre compte X">
                                    @error('twitter')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6 col-lg-4 mb-0">
                                    <label for="adresse" class="form-label">Instagram</label>
                                    <input name="instagram" type="instagram"
                                        class="form-control form-control-sm @error('instagram') is-invalid @enderror"
                                        id="instagram" value="{!! $user->instagram ?? old('instagram') !!}" autocomplete="instagram"
                                        placeholder="Entrez l'URL de votre compte instagram">
                                    @error('instagram')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6 col-lg-4 mb-0">
                                    <label for="adresse" class="form-label">Linkedin</label>
                                    <input name="linkedin" type="linkedin"
                                        class="form-control form-control-sm @error('linkedin') is-invalid @enderror"
                                        id="linkedin" value="{!! $user->linkedin ?? old('linkedin') !!}" autocomplete="linkedin"
                                        placeholder="Entrez l'URL de votre compte linkedin">
                                    @error('linkedin')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                </div>

                                <input type="hidden" name="newPassword" value="{{ Auth::user()?->password }}">

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-sm">Sauvegarder les
                                        modifications</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div
            class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12 d-flex flex-column align-items-center justify-content-center">
            <div class="modal fade" id="AddIndividuelleModal" tabindex="-1">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <form method="post" action="{{ route('individuelles.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header text-center bg-gradient-default">
                                <h1 class="h4 text-black mb-0">ajouter une nouvelle demande individuelle</h1>
                            </div>
                            {{-- <div class="modal-header">
                                <h5 class="modal-title"><i class="bi bi-plus" title="Ajouter"></i> Ajouter une nouvelle
                                    demande
                                    individuelle</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div> --}}
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-12 col-md-12 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                        <label for="module" class="form-label">Formation sollicitée<span
                                                class="text-danger mx-1">*</span></label>

                                        <input type="text" name="module" value="{{ old('module_name') }}"
                                            class="form-control form-control-sm @error('module_name') is-invalid @enderror"
                                            id="module_name" placeholder="Nom du module" autofocus>
                                        <div id="countryList"></div>
                                        {{ csrf_field() }}
                                        @error('module')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                        <label for="departement" class="form-label">Département<span
                                                class="text-danger mx-1">*</span></label>
                                        <select name="departement"
                                            class="form-select  @error('departement') is-invalid @enderror"
                                            aria-label="Select" id="select-field-departement-ind"
                                            data-placeholder="Choisir la localité">
                                            <option value="{{ old('departement') }}">
                                                {{ old('departement') }}</option>
                                            @foreach ($departements as $departement)
                                                <option value="{{ $departement->nom }}">
                                                    {{ $departement->nom }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('departement')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                        <label for="adresse" class="form-label">Adresse<span
                                                class="text-danger mx-1">*</span></label>
                                        <input type="text" name="adresse"
                                            value="{{ Auth::user()?->adresse ?? old('adresse') }}"
                                            class="form-control form-control-sm @error('adresse') is-invalid @enderror"
                                            id="adresse" placeholder="adresse">
                                        @error('adresse')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                        <label for="telephone_secondaire" class="form-label">Téléphone secondaire<span
                                                class="text-danger mx-1">*</span></label>
                                        <input name="telephone_secondaire" type="text" maxlength="12"
                                            class="form-control form-control-sm @error('telephone_secondaire') is-invalid @enderror"
                                            id="telephone_secondaire"
                                            value="{{ old('telephone_secondaire', $individuelle->telephone ?? '') }}"
                                            autocomplete="tel" placeholder="XX:XXX:XX:XX">
                                        @error('telephone_secondaire')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                        <label for="Niveau étude" class="form-label">Niveau étude<span
                                                class="text-danger mx-1">*</span></label>
                                        <select name="niveau_etude"
                                            class="form-select  @error('niveau_etude') is-invalid @enderror"
                                            aria-label="Select" id="select-field-niveau_etude-ind"
                                            data-placeholder="Choisir niveau étude">
                                            <option value="{{ old('niveau_etude') }}">
                                                {{ old('niveau_etude') }}
                                            </option>
                                            <option value="Aucun">
                                                Aucun
                                            </option>
                                            <option value="Arabe">
                                                Arabe
                                            </option>
                                            <option value="Elementaire">
                                                Elementaire
                                            </option>
                                            <option value="Secondaire">
                                                Secondaire
                                            </option>
                                            <option value="Moyen">
                                                Moyen
                                            </option>
                                            <option value="Supérieur">
                                                Supérieur
                                            </option>
                                        </select>
                                        @error('niveau_etude')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                        <label for="diplome_academique" class="form-label">Diplôme académique<span
                                                class="text-danger mx-1">*</span></label>
                                        <select name="diplome_academique"
                                            class="form-select  @error('diplome_academique') is-invalid @enderror"
                                            aria-label="Select" id="select-field-diplome_academique-ind"
                                            data-placeholder="Choisir diplôme académique">
                                            <option value="{{ old('diplome_academique') }}">
                                                {{ old('diplome_academique') }}
                                            </option>
                                            <option value="Aucun">
                                                Aucun
                                            </option>
                                            <option value="Arabe">
                                                Arabe
                                            </option>
                                            <option value="CFEE">
                                                CFEE
                                            </option>
                                            <option value="BFEM">
                                                BFEM
                                            </option>
                                            <option value="BAC">
                                                BAC
                                            </option>
                                            <option value="Licence">
                                                Licence
                                            </option>
                                            <option value="Master 2">
                                                Master 2
                                            </option>
                                            <option value="Doctorat">
                                                Doctorat
                                            </option>
                                            <option value="Autre">
                                                Autre
                                            </option>
                                        </select>
                                        @error('diplome_academique')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                        <label for="autre_diplome_academique" class="form-label">Si autre ?
                                            précisez</label>
                                        <input type="text" name="autre_diplome_academique"
                                            value="{{ old('autre_diplome_academique') }}"
                                            class="form-control form-control-sm @error('autre_diplome_academique') is-invalid @enderror"
                                            id="autre_diplome_academique" placeholder="autre diplôme académique">
                                        @error('autre_diplome_academique')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                        <label for="option_diplome_academique" class="form-label">Option du
                                            diplôme</label>
                                        <input type="text" name="option_diplome_academique"
                                            value="{{ old('option_diplome_academique') }}"
                                            class="form-control form-control-sm @error('option_diplome_academique') is-invalid @enderror"
                                            id="option_diplome_academique" placeholder="Ex: Mathématiques">
                                        @error('option_diplome_academique')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                        <label for="etablissement_academique" class="form-label">Etablissement
                                            académique</label>
                                        <input type="text" name="etablissement_academique"
                                            value="{{ old('etablissement_academique') }}"
                                            class="form-control form-control-sm @error('etablissement_academique') is-invalid @enderror"
                                            id="etablissement_academique" placeholder="Etablissement obtention">
                                        @error('etablissement_academique')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                        <label for="diplome_pro" class="form-label">Diplôme professionnel<span
                                                class="text-danger mx-1">*</span></label>
                                        <select name="diplome_professionnel"
                                            class="form-select  @error('diplome_professionnel') is-invalid @enderror"
                                            aria-label="Select" id="select-field-diplome_professionnel-ind"
                                            data-placeholder="Choisir diplôme professionnel">
                                            <option value="{{ old('diplome_professionnel') }}">
                                                {{ old('diplome_professionnel') }}
                                            </option>
                                            <option value="Aucun">
                                                Aucun
                                            </option>
                                            <option value="CAP">
                                                CAP
                                            </option>
                                            <option value="BEP">
                                                BEP
                                            </option>
                                            <option value="BT">
                                                BT
                                            </option>
                                            <option value="BTS">
                                                BTS
                                            </option>
                                            <option value="CPS">
                                                CPS
                                            </option>
                                            <option value="L3 Pro">
                                                L3 Pro
                                            </option>
                                            <option value="DTS">
                                                DTS
                                            </option>
                                            <option value="Autre">
                                                Autre
                                            </option>
                                        </select>
                                        @error('diplome_professionnel')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                        <label for="autre_diplome_professionnel" class="form-label">Si autre ?
                                            précisez</label>
                                        <input type="text" name="autre_diplome_professionnel"
                                            value="{{ old('autre_diplome_professionnel') }}"
                                            class="form-control form-control-sm @error('autre_diplome_professionnel') is-invalid @enderror"
                                            id="autre_diplome_professionnel"
                                            placeholder="autre diplôme professionnel ou attestations">
                                        @error('autre_diplome_professionnel')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                        <label for="etablissement_professionnel" class="form-label">Etablissement
                                            professionnel</label>
                                        <input type="text" name="etablissement_professionnel"
                                            value="{{ old('etablissement_professionnel') }}"
                                            class="form-control form-control-sm @error('etablissement_professionnel') is-invalid @enderror"
                                            id="etablissement_professionnel" placeholder="Etablissement obtention">
                                        @error('etablissement_professionnel')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                        <label for="specialite_diplome_professionnel"
                                            class="form-label">Spécialité</label>
                                        <input type="text" name="specialite_diplome_professionnel"
                                            value="{{ old('specialite_diplome_professionnel') }}"
                                            class="form-control form-control-sm @error('specialite_diplome_professionnel') is-invalid @enderror"
                                            id="specialite_diplome_professionnel" placeholder="Ex: électricité">
                                        @error('specialite_diplome_professionnel')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                        <label for="projet_poste_formation" class="form-label">Votre projet après la
                                            formation<span class="text-danger mx-1">*</span></label>
                                        <select name="projet_poste_formation"
                                            class="form-select  @error('projet_poste_formation') is-invalid @enderror"
                                            aria-label="Select" id="select-field-projet_poste_formation-ind"
                                            data-placeholder="Choisir projet">
                                            <option value="{{ old('projet_poste_formation') }}">
                                                {{ old('projet_poste_formation') }}
                                            </option>
                                            <option value="Poursuivre mes études">
                                                Poursuivre mes études
                                            </option>
                                            <option value="Chercher un emploi">
                                                Chercher un emploi
                                            </option>
                                            <option value="Lancer mon entreprise">
                                                Lancer mon entreprise
                                            </option>
                                            <option value="Retourner dans mon entreprise">
                                                Retourner dans mon entreprise
                                            </option>
                                            <option value="Aucun de ces projets">
                                                Aucun de ces projets
                                            </option>
                                        </select>
                                        @error('projet_poste_formation')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <label for="qualification" class="form-label">Qualification et autres
                                            diplômes</label>
                                        <textarea name="qualification" id="qualification" rows="1"
                                            class="form-control form-control-sm @error('qualification') is-invalid @enderror"
                                            placeholder="Qualification et autres diplômes">{{ old('qualification') }}</textarea>
                                        @error('qualification')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <label for="experience" class="form-label">Expériences et stages</label>
                                        <textarea name="experience" id="experience" rows="1"
                                            class="form-control form-control-sm @error('experience') is-invalid @enderror"
                                            placeholder="Expériences ou stages">{{ old('experience') }}</textarea>
                                        @error('experience')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <label for="projetprofessionnel" class="form-label">Informations complémentaires
                                            sur
                                            le projet
                                            professionnel</label>
                                        <textarea name="projetprofessionnel" id="projetprofessionnel" rows="2"
                                            class="form-control form-control-sm @error('projetprofessionnel') is-invalid @enderror"
                                            placeholder="Si vous disposez déjà d'un projet professionnel, merci d'écrire son résumé en quelques lignes">{{ old('projetprofessionnel') }}</textarea>
                                        @error('projetprofessionnel')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm"
                                        data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
