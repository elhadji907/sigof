@extends('layout.user-layout')
@section('title', 'ENREGISTREMENT OPERATEUR')
@section('space-work')
    @can('operateur-update')
        <section class="section min-vh-0 d-flex flex-column align-items-center justify-content-center py-0">
            <div class="container">
                <div class="row justify-content-center">
                    @if ($message = Session::get('status'))
                        <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show"
                            role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show"
                                role="alert"><strong>{{ $error }}</strong></div>
                        @endforeach
                    @endif
                    <div
                        class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12 d-flex flex-column align-items-center justify-content-center">
                        <div class="card mb-3">

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 pt-2">
                                        <span class="d-flex mt-2 align-items-baseline"><a href="{{ route('operateurs.index') }}"
                                                class="btn btn-success btn-sm" title="retour"><i
                                                    class="bi bi-arrow-counterclockwise"></i></a>&nbsp;
                                            <p> | Dossier personnel</p>
                                        </span>
                                    </div>
                                </div>

                                <form method="post" action="{{ route('addOperateur') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-12 col-md-12 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="numero_dossier" class="form-label">Numéro dossier<span
                                                    class="text-danger mx-1">*</span></label>
                                            <div class="input-group has-validation">
                                                <input type="number" min="0" name="numero_dossier"
                                                    value="{{ old('numero_dossier') }}"
                                                    class="form-control form-control-sm @error('numero_dossier') is-invalid @enderror"
                                                    id="numero_dossier" placeholder="Numéro dossier">
                                                @error('numero_dossier')
                                                    <span class="invalid-feedback" role="alert">
                                                        <div>{{ $message }}</div>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-12 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="numero_arrive" class="form-label">Numéro courrier<span
                                                    class="text-danger mx-1">*</span></label>
                                            <div class="input-group has-validation">
                                                {{-- <input type="number" min="0" name="numero_arrive"
                                                value="{{ old('numero_arrive') }}"
                                                class="form-control form-control-sm @error('numero_arrive') is-invalid @enderror"
                                                id="numero_arrive" placeholder="Numéro de correspondance"> --}}
                                                <input type="text" placeholder="Rechercher numéro courrier..."
                                                    class="form-control form-control-sm @error('product') is-invalid @enderror"
                                                    name="numero_arrive" id="numero" required>
                                                <div id="productList"></div>
                                                @error('numero_arrive')
                                                    <span class="invalid-feedback" role="alert">
                                                        <div>{{ $message }}</div>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="numero_agrement" class="form-label">Numéro agrément<span
                                                    class="text-danger mx-1">*</span></label>
                                            <input type="text" name="numero_agrement" value="{{ old('numero_agrement') }}"
                                                class="form-control form-control-sm @error('numero_agrement') is-invalid @enderror"
                                                id="numero_agrement" placeholder="Numéro agrément">
                                            @error('numero_agrement')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                            <label for="operateur" class="form-label">Raison sociale opérateur<span
                                                    class="text-danger mx-1">*</span></label>
                                            {{-- <textarea name="operateur" id="operateur" rows="1"
                                            class="form-control form-control-sm @error('operateur') is-invalid @enderror"
                                            placeholder="La raison sociale de l'opérateur">{{ old('operateur') }}</textarea> --}}
                                            <input type="text" placeholder="La raison sociale de l'opérateur"
                                                class="form-control form-control-sm @error('objet') is-invalid @enderror"
                                                name="operateur" id="objet" value="" required>
                                            @error('operateur')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="username" class="form-label">Sigle<span
                                                    class="text-danger mx-1">*</span></label>
                                            <input type="text" name="username" value="{{ old('username') }}"
                                                class="form-control form-control-sm @error('username') is-invalid @enderror"
                                                id="username" placeholder="username">
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="email" class="form-label">Email<span
                                                    class="text-danger mx-1">*</span></label>
                                            <input type="email" name="email" value="{{ old('email') }}"
                                                class="form-control form-control-sm @error('email') is-invalid @enderror"
                                                id="email" placeholder="Adresse email">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="fixe" class="form-label">Téléphone fixe<span
                                                    class="text-danger mx-1">*</span></label>
                                            <input name="fixe" type="text" maxlength="12"
                                                class="form-control form-control-sm @error('fixe') is-invalid @enderror"
                                                id="fixe" value="{{ old('fixe') }}" autocomplete="tel"
                                                placeholder="XX:XXX:XX:XX">
                                            @error('fixe')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="telephone" class="form-label">Téléphone<span
                                                    class="text-danger mx-1">*</span></label>
                                            <input name="telephone" type="text" maxlength="12"
                                                class="form-control form-control-sm @error('telephone') is-invalid @enderror"
                                                id="telephone" value="{{ old('telephone') }}" autocomplete="tel"
                                                placeholder="XX:XXX:XX:XX">
                                            @error('telephone')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="bp" class="form-label">Boite postal</label>
                                            <input type="text" name="bp" value="{{ old('bp') }}"
                                                class="form-control form-control-sm @error('bp') is-invalid @enderror"
                                                id="bp" placeholder="Boite postal">
                                            @error('bp')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>
                                        {{-- Type de structure --}}
                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="categorie" class="form-label">Catégorie<span
                                                    class="text-danger mx-1">*</span></label>
                                            <select name="categorie"
                                                class="form-select  @error('categorie') is-invalid @enderror"
                                                aria-label="Select" id="categorie"
                                                data-placeholder="Choisir">
                                                <option value="{{ old('categorie') }}">
                                                    {{ old('categorie') }}
                                                </option>
                                                <option value="Publique">
                                                    Publique
                                                </option>
                                                <option value="Privé">
                                                    Privé
                                                </option>
                                                <option value="Autre">
                                                    Autre
                                                </option>
                                            </select>
                                            @error('categorie')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="statut" class="form-label">Statut juridique<span
                                                    class="text-danger mx-1">*</span></label>
                                            <select name="statut" class="form-select  @error('statut') is-invalid @enderror"
                                                aria-label="Select" id="statut_juridique"
                                                data-placeholder="Choisir statut">
                                                <option value="{{ old('statut') }}">
                                                    {{ old('statut') }}
                                                </option>
                                                <option value="GIE">
                                                    GIE
                                                </option>
                                                <option value="Association">
                                                    Association
                                                </option>
                                                <option value="Entreprise individuelle">
                                                    Entreprise individuelle
                                                </option>
                                                <option value="SA">
                                                    SA
                                                </option>
                                                <option value="SAS">
                                                    SAS
                                                </option>
                                                <option value="SUARL">
                                                    SUARL
                                                </option>
                                                <option value="SARL">
                                                    SARL
                                                </option>
                                                <option value="SNC">
                                                    SNC
                                                </option>
                                                <option value="SCS">
                                                    SCS
                                                </option>
                                                <option value="Etablissement public">
                                                    Etablissement public
                                                </option>
                                                <option value="Autre">
                                                    Autre
                                                </option>
                                            </select>
                                            @error('statut')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="autre_statut" class="form-label">Si autre ?
                                                précisez</label>
                                            <input type="text" name="autre_statut" value="{{ old('autre_statut') }}"
                                                class="form-control form-control-sm @error('autre_statut') is-invalid @enderror"
                                                id="autre_statut" placeholder="autre statut juridique">
                                            @error('autre_statut')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="demande_signe" class="form-label">Demande signée</label>
                                            <select name="demande_signe"
                                                class="form-select  @error('demande_signe') is-invalid @enderror"
                                                aria-label="Select" id="demande_signe"
                                                data-placeholder="Choisir">
                                                <option value="{{ old('demande_signe') }}">
                                                    {{ old('demande_signe') }}
                                                </option>
                                                <option value="Oui">
                                                    Oui
                                                </option>
                                                <option value="Non">
                                                    Non
                                                </option>
                                            </select>
                                            @error('demande_signe')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="departement" class="form-label">Siège social<span
                                                    class="text-danger mx-1">*</span></label>
                                            <select name="departement"
                                                class="form-select form-select-sm @error('departement') is-invalid @enderror"
                                                aria-label="Select" id="departement"
                                                data-placeholder="Choisir">
                                                <option value="{{ old('departement') }}">{{ old('departement') }}
                                                </option>
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

                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="type_demande" class="form-label">Type demande<span
                                                    class="text-danger mx-1">*</span></label>
                                            <select name="type_demande"
                                                class="form-select form-select-sm @error('type_demande') is-invalid @enderror"
                                                aria-label="Select" id="type_demande"
                                                data-placeholder="Choisir type de demande">
                                                <option value="{{ old('type_demande') }}">
                                                    {{ old('type_demande') }}
                                                </option>
                                                <option value="Nouvelle">
                                                    Nouvelle
                                                </option>
                                                <option value="Renouvellement">
                                                    Renouvellement
                                                </option>
                                            </select>
                                            @error('type_demande')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="web" class="form-label">Site web</label>
                                            <input type="text" name="web" value="{{ old('web') }}"
                                                class="form-control form-control-sm @error('web') is-invalid @enderror"
                                                id="web" placeholder="www.">
                                            @error('web')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                            <label for="adresse" class="form-label">Adresse<span
                                                    class="text-danger mx-1">*</span></label>
                                            <textarea name="adresse" id="adresse" rows="1"
                                                class="form-control form-control-sm @error('adresse') is-invalid @enderror"
                                                placeholder="Adresse exacte de l'opérateur">{{ old('adresse') }}</textarea>
                                            @error('adresse')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="rccm" class="form-label">RCCM / Ninea</label>
                                            <select name="rccm"
                                                class="form-select form-select-sm @error('rccm') is-invalid @enderror"
                                                aria-label="Select" id="rccm" data-placeholder="Choisir">
                                                <option value="{{ old('rccm') }}">
                                                    {{ old('rccm') }}
                                                </option>
                                                <option value="Registre de commerce">
                                                    Registre de commerce
                                                </option>
                                                <option value="Ninea">
                                                    Ninea
                                                </option>
                                                <option value="Aucun">
                                                    Aucun
                                                </option>
                                                <option value="Autre">
                                                    Autre
                                                </option>
                                            </select>
                                            @error('rccm')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="ninea" class="form-label">Numéro RCCM / Ninea</label>
                                            <input type="text" name="ninea" value="{{ old('ninea') }}"
                                                class="form-control form-control-sm @error('ninea') is-invalid @enderror"
                                                id="ninea" placeholder="Votre ninéa / Numéro RCCM">
                                            @error('ninea')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="quitusfiscal" class="form-label">Quitus fiscal<span
                                                    class="text-danger mx-1">*</span></label>
                                            <select name="quitusfiscal"
                                                class="form-select  @error('quitusfiscal') is-invalid @enderror"
                                                aria-label="Select" id="quitus"
                                                data-placeholder="Choisir">
                                                <option value="{{ old('quitusfiscal') }}">
                                                    {{ old('quitusfiscal') }}
                                                </option>
                                                <option value="Oui">
                                                    Oui
                                                </option>
                                                <option value="Non">
                                                    Non
                                                </option>
                                            </select>
                                            @error('quitusfiscal')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="quitus" class="form-label">Scan quitus fiscal</label>
                                            <input type="file" name="quitus" id="quitus" value="{{ old('quitus') }}"
                                                class="form-control @error('quitus') is-invalid @enderror btn btn-outline-success btn-sm">
                                            @error('quitus')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="date_quitus" class="form-label">Date délivrance</label>
                                            <input type="text" name="date_quitus" value="{{ old('date_quitus') }}"
                                                class="form-control form-control-sm @error('date_quitus') is-invalid @enderror"
                                                id="datepicker" placeholder="JJ/MM/AAAA" autocomplete="bday">
                                            @error('date_quitus')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="arrete_creation" class="form-label">Arrêté création</label>
                                            <select name="arrete_creation"
                                                class="form-select  @error('arrete_creation') is-invalid @enderror"
                                                aria-label="Select" id="arrete_creation"
                                                data-placeholder="Choisir">
                                                <option value="{{ old('arrete_creation') }}">
                                                    {{ old('arrete_creation') }}
                                                </option>
                                                <option value="MFP">
                                                    MFP
                                                </option>
                                                <option value="MESRI">
                                                    MESRI
                                                </option>
                                                <option value="MEN">
                                                    MEN
                                                </option>
                                                <option value="Aucun">
                                                    Aucun
                                                </option>
                                                <option value="Autre">
                                                    Autre
                                                </option>
                                            </select>
                                            @error('arrete_creation')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="file_arrete_creation" class="form-label">Scan</label>
                                            <input type="file" name="file_arrete_creation" id="file_arrete_creation"
                                                value="{{ old('file_arrete_creation') }}"
                                                class="form-control @error('file_arrete_creation') is-invalid @enderror btn btn-outline-primary btn-sm">
                                            @error('file_arrete_creation')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="formulaire_signe" class="form-label">Formulaire signée</label>
                                            <select name="formulaire_signe"
                                                class="form-select  @error('formulaire_signe') is-invalid @enderror"
                                                aria-label="Select" id="formulaire_signe"
                                                data-placeholder="Choisir">
                                                <option value="{{ old('formulaire_signe') }}">
                                                    {{ old('formulaire_signe') }}
                                                </option>
                                                <option value="Oui">
                                                    Oui
                                                </option>
                                                <option value="Non">
                                                    Non
                                                </option>
                                            </select>
                                            @error('formulaire_signe')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="cvsigne" class="form-label">CV signés</label>
                                            <select name="cvsigne"
                                                class="form-select  @error('cvsigne') is-invalid @enderror"
                                                aria-label="Select" id="cv_signe" data-placeholder="Choisir">
                                                <option value="{{ old('cvsigne') }}">
                                                    {{ old('cvsigne') }}
                                                </option>
                                                <option value="Oui">
                                                    Oui
                                                </option>
                                                <option value="Non">
                                                    Non
                                                </option>
                                            </select>
                                            @error('cvsigne')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <hr class="dropdown-divider mt-5">

                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="civilite" class="form-label">Civilité<span
                                                    class="text-danger mx-1">*</span></label>
                                            <select name="civilite"
                                                class="form-select form-select-sm @error('civilite') is-invalid @enderror"
                                                aria-label="Select" id="civilite"
                                                data-placeholder="Choisir civilité">
                                                <option value="{{ old('civilite') }}">
                                                    {{ old('civilite') }}
                                                </option>
                                                <option value="M.">
                                                    M.
                                                </option>
                                                <option value="Mme">
                                                    Mme
                                                </option>
                                            </select>
                                            @error('civilite')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="prenom" class="form-label">Prénom responsable<span
                                                    class="text-danger mx-1">*</span></label>
                                            <input type="text" name="prenom" value="{{ old('prenom') }}"
                                                class="form-control form-control-sm @error('prenom') is-invalid @enderror"
                                                id="prenom" placeholder="Prénom responsable">
                                            @error('prenom')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="nom" class="form-label">Nom responsable<span
                                                    class="text-danger mx-1">*</span></label>
                                            <input type="text" name="nom" value="{{ old('nom') }}"
                                                class="form-control form-control-sm @error('nom') is-invalid @enderror"
                                                id="nom" placeholder="Nom responsable">
                                            @error('nom')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="fonction_responsable" class="form-label">Fonction responsable<span
                                                    class="text-danger mx-1">*</span></label>
                                            <input type="text" name="fonction_responsable"
                                                value="{{ old('fonction_responsable') }}"
                                                class="form-control form-control-sm @error('fonction_responsable') is-invalid @enderror"
                                                id="fonction_responsable" placeholder="Fonction responsable">
                                            @error('fonction_responsable')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="email_responsable" class="form-label">Adresse e-mail</label>
                                            <input type="email" name="email_responsable"
                                                value="{{ old('email_responsable') }}"
                                                class="form-control form-control-sm @error('email_responsable') is-invalid @enderror"
                                                id="email_responsable" placeholder="Adresse email responsable">
                                            @error('email_responsable')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="telephone_parent" class="form-label">Téléphone responsable</label>
                                            <input name="telephone_parent" type="text" maxlength="12"
                                                class="form-control form-control-sm @error('telephone_parent') is-invalid @enderror"
                                                id="telephone_secondaire" value="{{ old('telephone_parent') }}"
                                                autocomplete="tel" placeholder="XX:XXX:XX:XX">
                                            @error('telephone_parent')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="modal-footer mt-5">
                                        <button type="button" class="btn btn-secondary btn-sm"
                                            data-bs-dismiss="modal">Fermer</button>
                                        <button type="submit" class="btn btn-primary btn-sm">Ajouter</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endcan
@endsection


@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#numero').keyup(function() {
                var query = $(this).val().trim();
                if (query !== '') {
                    $.ajax({
                        url: "{{ route('collectives.fetch') }}", // Changez cette URL si nécessaire
                        method: "POST",
                        data: {
                            query: query,
                            _token: "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.html) {
                                $('#productList').fadeIn().html(response.html);
                            } else {
                                $('#productList').fadeOut();
                            }
                        }
                    });
                } else {
                    $('#productList').fadeOut();
                }
            });

            $(document).on('click', 'li', function() {
                var selectedNumero = $(this).text();
                var selectedId = $(this).data("id");

                $('#numero').val(selectedNumero); // Remplir le champ numéro
                $('#id').val(selectedId);

                // Appeler l'API pour récupérer l'objet associé au numéro sélectionné
                $.ajax({
                    url: "{{ route('getObjetByNumero') }}", // Définir une route pour récupérer l'objet
                    method: "GET",
                    data: {
                        numero: selectedNumero
                    },
                    success: function(response) {
                        $('#objet').val(response
                            .objet); // Remplir automatiquement le champ 'objet'
                        $('#date_depot').val(response
                            .date_depot); // Remplir automatiquement le champ 'objet'
                    },
                    error: function() {
                        alert('Erreur lors de la récupération de l\'objet.');
                    }
                });

                $('#productList').fadeOut();
            });
        });
    </script>
@endpush
