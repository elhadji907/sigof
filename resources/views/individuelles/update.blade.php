@extends('layout.user-layout')
@section('title', 'ONFP | MODIFICATION DEMANDE EN ' . strtoupper($individuelle?->module?->name))
@section('space-work')
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
                                    @if (auth()->user()->hasRole('Demandeur'))
                                        <span class="d-flex mt-2 align-items-baseline"><a
                                                href="{{ route('demandesIndividuelle') }}" class="btn btn-success btn-sm"
                                                title="retour"><i class="bi bi-arrow-counterclockwise"></i></a>&nbsp;
                                            <p> | Dossier personnel</p>
                                        </span>
                                    @endif
                                    @if (auth()->user()->hasRole('super-admin|admin'))
                                        <span class="d-flex mt-2 align-items-baseline"><a
                                                href="{{ route('individuelles.show', $individuelle?->id) }}"
                                                class="btn btn-success btn-sm" title="retour"><i
                                                    class="bi bi-arrow-counterclockwise"></i></a>&nbsp;
                                            <p> | retour</p>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <form method="post" action="{{ route('individuelles.update', $individuelle->id) }}"
                                enctype="multipart/form-data" class="row g-3">
                                @csrf
                                @method('PUT')
                                <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                    <label for="module" class="form-label">Formation sollicitée (module)<span
                                            class="text-danger mx-1">*</span></label>
                                    <input type="text" name="module"
                                        value="{{ $individuelle?->module?->name ?? old('module_name') }}"
                                        class="form-control form-control-sm @error('module_name') is-invalid @enderror"
                                        id="module_name" placeholder="Formation choisie" autofocus>
                                    <div id="countryList"></div>
                                    {{ csrf_field() }}
                                    @error('module')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                                    <label for="departement" class="form-label">Département<span
                                            class="text-danger mx-1">*</span></label>
                                    <select name="departement"
                                        class="form-select  @error('departement') is-invalid @enderror" aria-label="Select"
                                        id="select-field-departement" data-placeholder="Choisir">
                                        <option value="{{ $individuelle?->departement?->nom ?? old('departement') }}">
                                            {{ $individuelle?->departement?->nom ?? old('departement') }}</option>
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

                                <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                                    <label for="adresse" class="form-label">Adresse<span
                                            class="text-danger mx-1">*</span></label>
                                    <input type="text" name="adresse"
                                        value="{{ $individuelle?->adresse ?? old('adresse') }}"
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
                                        value="{{ old('telephone_secondaire', $individuelle?->telephone ?? '') }}"
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
                                        class="form-select  @error('niveau_etude') is-invalid @enderror" aria-label="Select"
                                        id="select-field-niveau_etude" data-placeholder="Choisir niveau étude">
                                        <option value="{{ $individuelle->niveau_etude }}">
                                            {{ $individuelle->niveau_etude ?? old('niveau_etude') }}
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
                                        aria-label="Select" id="select-field-diplome_academique"
                                        data-placeholder="Choisir diplôme académique">
                                        <option value="{{ $individuelle->diplome_academique }}">
                                            {{ $individuelle->diplome_academique ?? old('diplome_academique') }}
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
                                    <label for="autre_diplome_academique" class="form-label">Si autre ? précisez</label>
                                    <input type="text" name="autre_diplome_academique"
                                        value="{{ $individuelle->autre_diplome_academique ?? old('autre_diplome_academique') }}"
                                        class="form-control form-control-sm @error('autre_diplome_academique') is-invalid @enderror"
                                        id="autre_diplome_academique" placeholder="autre diplôme académique">
                                    @error('autre_diplome_academique')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                    <label for="option_diplome_academique" class="form-label">Option du diplôme</label>
                                    <input type="text" name="option_diplome_academique"
                                        value="{{ $individuelle->option_diplome_academique ?? old('option_diplome_academique') }}"
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
                                        value="{{ $individuelle->etablissement_academique ?? old('etablissement_academique') }}"
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
                                        aria-label="Select" id="select-field-diplome_professionnel"
                                        data-placeholder="Choisir diplôme professionnel">
                                        <option value="{{ $individuelle->diplome_professionnel }}">
                                            {{ $individuelle->diplome_professionnel ?? old('diplome_professionnel') }}
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
                                        value="{{ $individuelle->autre_diplome_professionnel ?? old('autre_diplome_professionnel') }}"
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
                                        value="{{ $individuelle->etablissement_professionnel ?? old('etablissement_professionnel') }}"
                                        class="form-control form-control-sm @error('etablissement_professionnel') is-invalid @enderror"
                                        id="etablissement_professionnel" placeholder="Etablissement obtention">
                                    @error('etablissement_professionnel')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                    <label for="specialite_diplome_professionnel" class="form-label">Spécialité</label>
                                    <input type="text" name="specialite_diplome_professionnel"
                                        value="{{ $individuelle->specialite_diplome_professionnel ?? old('specialite_diplome_professionnel') }}"
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
                                        aria-label="Select" id="select-field-projet_poste_formation"
                                        data-placeholder="Choisir projet poste formation">
                                        <option value="{{ $individuelle->projet_poste_formation }}">
                                            {{ $individuelle->projet_poste_formation ?? old('projet_poste_formation') }}
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

                                @if (auth()->user()->hasRole('super-admin|admin'))
                                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                        <label for="date_depot" class="form-label">Date dépot<span
                                                class="text-danger mx-1">*</span></label>
                                        <input type="text" name="date_depot"
                                            value="{{ old('date_depot', optional($individuelle->date_depot)->format('d/m/Y')) }}"
                                            class="form-control form-control-sm @error('date_depot') is-invalid @enderror"
                                            id="datepicker" placeholder="JJ/MM/AAAA" autocomplete="bday">
                                        @error('date_depot')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                @else
                                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                        <label for="date_depot" class="form-label">Date dépot<span
                                                class="text-danger mx-1">*</span></label>
                                        <input type="text" name="date_depot"
                                            value="{{ old('date_depot', optional($individuelle->date_depot)->format('d/m/Y')) }}"
                                            readonly
                                            class="form-control form-control-sm @error('date_depot') is-invalid @enderror"
                                            id="datepickers" placeholder="JJ/MM/AAAA" autocomplete="bday">
                                        @error('date_depot')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                @endif

                                @can('projet-view')
                                    <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <label for="projet" class="form-label">Partenaire</label>
                                        <select name="projet" class="form-select  @error('projet') is-invalid @enderror"
                                            aria-label="Select" id="select-field-projet" data-placeholder="Choisir">
                                            <option>
                                                {{ $individuelle?->projet?->sigle ?? old('projet') }}
                                            </option>
                                            <option value="null">
                                                Aucun
                                            </option>
                                            @foreach ($projets as $projet)
                                                <option value="{{ $projet?->sigle }}">
                                                    {{ $projet?->name . ' (' . $projet?->sigle . ')' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('projet')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                @endcan

                                <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                    <label for="qualification" class="form-label">Qualification et autres diplômes</label>
                                    <textarea name="qualification" id="qualification" rows="2"
                                        class="form-control form-control-sm @error('qualification') is-invalid @enderror"
                                        placeholder="Qualification et autres diplômes">{{ $individuelle->qualification ?? old('qualification') }}</textarea>
                                    @error('qualification')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                    <label for="experience" class="form-label">Expériences et stages</label>
                                    <textarea name="experience" id="experience" rows="2"
                                        class="form-control form-control-sm @error('experience') is-invalid @enderror"
                                        placeholder="Expériences ou stages">{{ $individuelle->experience ?? old('experience') }}</textarea>
                                    @error('experience')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                    <label for="projetprofessionnel" class="form-label">Informations complémentaires sur
                                        le projet
                                        professionnel<span class="text-danger mx-1">*</span></label>
                                    <textarea name="projetprofessionnel" id="projetprofessionnel" rows="5"
                                        class="form-control form-control-sm @error('projetprofessionnel') is-invalid @enderror"
                                        placeholder="Si vous disposez déjà d'un projet professionnel, merci d'écrire son résumé en quelques lignes">{{ $individuelle->projetprofessionnel ?? old('projetprofessionnel') }}</textarea>
                                    @error('projetprofessionnel')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-sm">Enregister
                                        modifications</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
