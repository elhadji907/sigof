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
                        <h1 class="h4 text-black mb-0">DEMANDES INDIVIDUELLES</h1>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mt-0">
                            <span class="d-flex align-items-baseline"><a href="{{ url('/profil') }}"
                                    class="btn btn-success btn-sm" title="retour"><i
                                        class="bi bi-arrow-counterclockwise"></i></a>&nbsp;
                                <p> | retour</p>
                            </span>
                            <button type="button" class="btn btn-info btn-sm">
                                <span class="badge bg-white text-info">{{ $individuelle_total }}/3</span>
                            </button>
                            @if(!empty(Auth::user()->cin))
                                <button type="button" class="btn btn-outline-primary btn-sm float-end btn-rounded"
                                    data-bs-toggle="modal" data-bs-target="#AddIndividuelleModal">
                                    <i class="bi bi-plus" title="Ajouter"></i>
                                </button>
                            @endif
                        </div>
                        <h5 class="card-title">
                            Bonjour {{ Auth::user()->civilite . ' ' . Auth::user()->firstname. ' ' . Auth::user()->name }}</h5>
                        <table class="table table-bordered table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th width="2%" class="text-center">N°</th>
                                    <th width="8%" class="text-center">Numéro</th>
                                    <th>Module</th>
                                    <th width="12%" class="text-center">Département</th>
                                    <th width="15%" class="text-center">Niveau étude</th>
                                    <th width="15%" class="text-center">Diplome académique</th>
                                    <th width="15%" class="text-center">Diplome professionnel</th>
                                    <th width="5%" class="text-center">Statut</th>
                                    <th style="width:5%;"><i class="bi bi-gear"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($individuelles as $individuelle)
                                    @if(!empty($individuelle->numero))
                                        <tr>
                                            <td class="text-center">{{ $i++ }}</td>
                                            <td class="text-center">{{ $individuelle?->numero }}</td>
                                            <td>{{ $individuelle?->module?->name }}</td>
                                            <td class="text-center">{{ $individuelle?->departement?->nom }}</td>
                                            <td class="text-center">{{ $individuelle?->niveau_etude }}</td>
                                            <td class="text-center">{{ $individuelle?->diplome_academique }}</td>
                                            <td class="text-center">{{ $individuelle?->diplome_professionnel }}</td>
                                            <td class="text-center">
                                                <span class="{{ $individuelle?->statut }}">{{ $individuelle?->statut }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="d-flex align-items-baseline">
                                                    <a href="{{ route('individuelles.show', $individuelle->id) }}"
                                                        class="btn btn-success btn-sm" title="voir détails"><i
                                                            class="bi bi-eye"></i></a>
                                                    <div class="filter">
                                                        <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                                                class="bi bi-three-dots"></i></a>
                                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                            <li><a class="dropdown-item btn btn-sm"
                                                                    href="{{ route('individuelles.edit', $individuelle->id) }}"
                                                                    class="mx-1" title="Modifier"><i
                                                                        class="bi bi-pencil"></i>Modifier</a>
                                                            </li>
                                                            <li>
                                                                <form
                                                                    action="{{ route('individuelles.destroy', $individuelle->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item show_confirm"
                                                                        title="Supprimer"><i
                                                                            class="bi bi-trash"></i>Supprimer</button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </span>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Ajouter un autre choix --}}

        @foreach (Auth::user()?->individuelles as $individuelle)
            <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12 d-flex flex-column align-items-center justify-content-center">
                <div class="modal fade" id="AddIndividuelleModal" tabindex="-1">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <form method="post" action="{{ route('individuelles.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-header text-center bg-gradient-default">
                                    <h1 class="h4 text-black mb-0">Ajouter une nouvelle demande individuelle</h1>
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

                                            {{-- <select name="module" class="form-select  @error('module') is-invalid @enderror"
                                            aria-label="Select" id="select-field-module-ind"
                                            data-placeholder="Choisir formation">
                                            <option value="">
                                                {{ old('module') }}
                                            </option>
                                            @foreach ($modules as $module)
                                                <option value="{{ $module->id }}">
                                                    {{ $module->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('module')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror --}}
                                        </div>

                                        {{-- <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                        <label for="autre_module" class="form-label">Si autre formation ? précisez</label>
                                        <input type="text" name="autre_module" value="{{ old('autre_module') }}"
                                            class="form-control form-control-sm @error('autre_module') is-invalid @enderror"
                                            id="autre_module" placeholder="autre diplôme académique">
                                        @error('autre_module')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div> --}}

                                        <div class="col-12 col-md-12 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <label for="departement" class="form-label">Lieu de formation<span
                                                    class="text-danger mx-1">*</span></label>
                                            <select name="departement"
                                                class="form-select  @error('departement') is-invalid @enderror"
                                                aria-label="Select" id="select-field-departement-ind"
                                                data-placeholder="Choisir la localité">
                                                <option value="{{ $individuelle?->departement?->nom }}">
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

                                        <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
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
                                            <input type="number" name="telephone_secondaire" min="0"
                                                value="{{ $individuelle?->telephone ?? old('telephone_secondaire') }}"
                                                class="form-control form-control-sm @error('telephone_secondaire') is-invalid @enderror"
                                                id="telephone_secondaire" placeholder="7x xxx xx xx">
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
                                                <option value="{{ $individuelle->niveau_etude ?? old('niveau_etude') }}">
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
                                                aria-label="Select" id="select-field-diplome_academique-ind"
                                                data-placeholder="Choisir diplôme académique">
                                                <option
                                                    value="{{ $individuelle->diplome_academique ?? old('diplome_academique') }}">
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
                                            <label for="autre_diplome_academique" class="form-label">Si autre ?
                                                précisez</label>
                                            <input type="text" name="autre_diplome_academique"
                                                value="{{ $individuelle?->autre_diplome_academique ?? old('autre_diplome_academique') }}"
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
                                                value="{{ $individuelle?->option_diplome_academique ?? old('option_diplome_academique') }}"
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
                                                value="{{ $individuelle?->etablissement_academique ?? old('etablissement_academique') }}"
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
                                                <option
                                                    value="{{ $individuelle?->diplome_professionnel ?? old('diplome_professionnel') }}">
                                                    {{ $individuelle?->diplome_professionnel ?? old('diplome_professionnel') }}
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
                                                value="{{ $individuelle?->autre_diplome_professionnel ?? old('autre_diplome_professionnel') }}"
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
                                                value="{{ $individuelle?->etablissement_professionnel ?? old('etablissement_professionnel') }}"
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
                                                value="{{ $individuelle?->specialite_diplome_professionnel ?? old('specialite_diplome_professionnel') }}"
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
                                                <option
                                                    value="{{ $individuelle?->projet_poste_formation ?? old('projet_poste_formation') }}">
                                                    {{ $individuelle?->projet_poste_formation ?? old('projet_poste_formation') }}
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

                                        <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12 mb-0">
                                            <label for="qualification" class="form-label">Qualification et autres
                                                diplômes</label>
                                            <textarea name="qualification" id="qualification" rows="1"
                                                class="form-control form-control-sm @error('qualification') is-invalid @enderror"
                                                placeholder="Qualification et autres diplômes">{{ $individuelle?->qualification ?? old('qualification') }}</textarea>
                                            @error('qualification')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12 mb-0">
                                            <label for="experience" class="form-label">Expériences et stages</label>
                                            <textarea name="experience" id="experience" rows="1"
                                                class="form-control form-control-sm @error('experience') is-invalid @enderror"
                                                placeholder="Expériences ou stages">{{ $individuelle?->experience ?? old('experience') }}</textarea>
                                            @error('experience')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12 mb-0">
                                            <label for="projetprofessionnel" class="form-label">Informations
                                                complémentaires
                                                sur
                                                le projet
                                                professionnel</label>
                                            <textarea name="projetprofessionnel" id="projetprofessionnel" rows="2"
                                                class="form-control form-control-sm @error('projetprofessionnel') is-invalid @enderror"
                                                placeholder="Si vous disposez déjà d'un projet professionnel, merci d'écrire son résumé en quelques lignes">{{ $individuelle?->projetprofessionnel ?? old('projetprofessionnel') }}</textarea>
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
                                        <button type="submit" class="btn btn-primary btn-sm"><i
                                                class="bi bi-printer"></i>
                                            Ajouter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </section>
@endsection
