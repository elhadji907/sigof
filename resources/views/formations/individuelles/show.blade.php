@extends('layout.user-layout')
@section('title', 'ONFP - ' . $formation->name)
@section('space-work')

    <section
        class="section profile min-vh-0 d-flex flex-column align-items-center justify-content-center py-0 section profile">
        <div class="container-fluid">
            <div class="pagetitle">
                {{-- <h1>Data Tables</h1> --}}
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Accueil</a></li>
                        <li class="breadcrumb-item">Tables</li>
                        <li class="breadcrumb-item active">Formations {{ $type_formation }}</li>
                    </ol>
                </nav>
            </div>
            <!-- End Title -->
            <div class="row justify-content-center">
                @if ($message = Session::get('status'))
                    <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show"
                        role="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($message = Session::get('danger'))
                    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show"
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
                <div class="flex items-center gap-4">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-tabs-bordered">

                                <li class="nav-item">
                                    <span class="nav-link"><a href="{{ route('formations.index', $formation->id) }}"
                                            class="btn btn-secondary btn-sm" title="retour"><i
                                                class="bi bi-arrow-counterclockwise"></i></a>
                                    </span>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-overview">Détails
                                        formation</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#responsable-overview">Opérateur</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                        data-bs-target="#beneficiaires-overview">Bénéficiaires
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#module-overview">Module
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#ingenieur-overview">Ingénieur
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#emargement-overview">Émargement
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#evaluation-overview">Évaluation
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#retrait-attestation-overview">Attestations
                                    </button>
                                </li>

                            </ul>
                            <div class="tab-content pt-0">
                                <div class="tab-pane fade profile-overview pt-3" id="profile-overview">
                                    <form method="post" action="#" enctype="multipart/form-data" class="row g-3">
                                        @csrf
                                        @method('PUT')
                                        <span class="card-title">Détails formation : <span
                                                class="{{ $formation?->statut }} text-white">
                                                {{ $formation?->statut }}</span>
                                        </span>
                                        <div class="col-12 col-md-12 col-lg-12 mb-0">
                                            <div class="label">Intitulé formation</div>
                                            <div>{{ $formation?->name }}</div>
                                        </div>
                                        <div class="col-12 col-md-3 col-lg-3 mb-0">
                                            <div class="label">Code</div>
                                            <div>{{ $formation?->code }}</div>
                                        </div>
                                        @isset($formation?->module?->name)
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Module</div>
                                                <div>{{ $formation?->module?->name }}</div>
                                            </div>
                                        @endisset
                                        <div class="col-12 col-md-3 col-lg-3 mb-0">
                                            <div class="label">Région</div>
                                            <div>{{ $formation?->departement->region->nom }}</div>
                                        </div>
                                        <div class="col-12 col-md-3 col-lg-3 mb-0">
                                            <div class="label">Département</div>
                                            <div>{{ $formation->departement->nom }}
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3 col-lg-3 mb-0">
                                            <div class="label">Adresse exacte</div>
                                            <div>{{ $formation?->lieu }}
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3 col-lg-3 mb-0">
                                            <div class="label">Type formation</div>
                                            <div>{{ $formation?->types_formation?->name }}</div>
                                        </div>
                                        <div class="col-12 col-md-3 col-lg-3 mb-0">
                                            <div class="label">Statut juridique</div>
                                            <div>{{ $formation?->statut }}</div>
                                        </div>
                                        <div class="col-12 col-md-3 col-lg-3 mb-0">
                                            <div class="label">Niveau qualification</div>
                                            <div>{{ $formation->niveau_qualification }}</div>
                                        </div>
                                        @isset($formation?->date_debut)
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Date début</div>
                                                <div>{{ $formation?->date_debut->format('d/m/Y') }}</div>
                                            </div>
                                        @endisset
                                        @isset($formation?->date_fin)
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Date fin</div>
                                                <div>{{ $formation?->date_fin->format('d/m/Y') }}</div>
                                            </div>
                                        @endisset
                                        @isset($formation?->effectif_prevu)
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Effectif prévu</div>
                                                <div>{{ $formation?->effectif_prevu }}</div>
                                            </div>
                                        @endisset
                                        @isset($formation?->prevue_h)
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Prévu homme</div>
                                                <div>{{ $formation?->prevue_h }}</div>
                                            </div>
                                        @endisset
                                        @isset($formation?->prevue_f)
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Prévu femmes</div>
                                                <div>{{ $formation?->prevue_f }}</div>
                                            </div>
                                        @endisset
                                        @isset($formation?->frais_operateurs)
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Frais opérateur</div>
                                                <div>{{ number_format($formation?->frais_operateurs, 2, ',', ' ') }}</div>
                                            </div>
                                        @endisset
                                        @isset($formation?->frais_add)
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Frais additionels</div>
                                                <div>{{ number_format($formation?->frais_add, 2, ',', ' ') }}</div>
                                            </div>
                                        @endisset
                                        @isset($formation?->autes_frais)
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Autres frais</div>
                                                <div>{{ number_format($formation?->autes_frais, 2, ',', ' ') }}</div>
                                            </div>
                                        @endisset
                                        @isset($formation?->projets_id)
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Projet</div>
                                                <div>{{ $formation?->projet?->name }}</div>
                                            </div>
                                        @endisset
                                        @isset($formation?->programmes_id)
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Programme</div>
                                                <div>{{ $formation?->programme?->name }}</div>
                                            </div>
                                        @endisset
                                        @isset($formation?->choixoperateur?->description)
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Choix opérateur</div>
                                                <div>{{ $formation?->choixoperateur?->description }}</div>
                                            </div>
                                        @endisset
                                        @if (!empty($formation?->attestation))
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Titres - Attestations</div>
                                                <div>{{ $formation?->attestation }}</div>
                                            </div>
                                        @endif
                                        <div class="col-12 col-md-12 col-lg-12 mb-0 text-center pt-5">
                                            <a class="btn btn-outline-primary btn-sm"
                                                href="{{ route('formations.edit', $formation->id) }}" class="mx-1"
                                                title="Modifier">Modifier cette formation</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            {{-- Détail --}}
                            <div class="tab-content">
                                <div class="tab-pane fade profile-overview" id="responsable-overview">
                                    @if (!empty($operateur))
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="card-title">
                                                {{ $formation?->operateur?->user?->operateur . '(' . $formation?->operateur?->user?->username . ')' }}
                                                @can('operateur-check')
                                                    <a class="btn btn-info btn-sm" title=""
                                                        href="{{ route('operateurs.show', $formation?->operateur?->id) }}"><i
                                                            class="bi bi-eye"></i></a>&nbsp;
                                                    <a href="{{ url('formationoperateurs', ['$idformation' => $formation->id, '$idmodule' => $formation->module->id, '$idlocalite' => $formation->departement->region->id]) }}"
                                                        class="btn btn-primary float-end btn-sm">
                                                        <i class="bi bi-pencil" title="Changer opérateur"></i> </a>
                                                @endcan
                                            </h5>
                                        </div>
                                    @elseif(!empty($module))
                                        <div class="pt-2">
                                            @can('operateur-check')
                                                <a href="{{ url('formationoperateurs', ['$idformation' => $formation?->id, '$idmodule' => $formation?->module?->id, '$idlocalite' => $formation?->departement?->region?->id]) }}"
                                                    class="btn btn-primary float-end btn-sm">
                                                    <i class="bi bi-person-plus-fill" title="Ajouter opérateur"></i> </a>
                                            @endcan
                                        </div>
                                    @else
                                    @endif
                                    <div class="col-12 col-md-12 col-lg-12 mb-0">
                                        @if (!empty($operateur))
                                            <h1 class="card-title">
                                                Liste des formations
                                            </h1>
                                            <div class="row g-3">
                                                <table class="table table-bordered table-hover datatables"
                                                    id="table-formations">
                                                    <thead>
                                                        <tr>
                                                            <th>Code</th>
                                                            <th>Type</th>
                                                            <th>Intitulé formation</th>
                                                            <th>Localité</th>
                                                            {{-- <th>Modules</th> --}}
                                                            {{-- <th>Niveau qualification</th> --}}
                                                            <th>Effectif</th>
                                                            <th>Statut</th>
                                                            <th class="text-center">#</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($operateur?->formations as $operateurformation)
                                                            <tr valign="middle">
                                                                <td>{{ $operateurformation?->code }}</td>
                                                                <td><a
                                                                        href="#">{{ $operateurformation->types_formation?->name }}</a>
                                                                </td>
                                                                <td>{{ $operateurformation?->name }}</td>
                                                                <td>{{ $operateurformation->departement?->region?->nom }}
                                                                </td>
                                                                {{-- <td>{{ $operateurformation->module?->name }}</td> --}}
                                                                {{-- <td>{{ $operateurformation->niveau_qualification }}</td> --}}
                                                                <td class="text-center">
                                                                    @foreach ($operateurformation->individuelles as $individuelle)
                                                                        @if ($loop->last)
                                                                            <a class="text-primary fw-bold"
                                                                                href="{{ route('formations.show', $operateurformation->id) }}">{!! $loop->count ?? '0' !!}</a>
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                                <td><a href="#"><span
                                                                            class="{{ $operateurformation?->statut }}">{{ $operateurformation?->statut }}</span></a>
                                                                </td>
                                                                <td>
                                                                    @can('formation-show')
                                                                        <span class="d-flex align-items-baseline"><a
                                                                                href="{{ route('formations.show', $operateurformation->id) }}"
                                                                                class="btn btn-primary btn-sm"
                                                                                title="voir détails"><i
                                                                                    class="bi bi-eye"></i></a>
                                                                            <div class="filter">
                                                                                <a class="icon" href="#"
                                                                                    data-bs-toggle="dropdown"><i
                                                                                        class="bi bi-three-dots"></i></a>
                                                                                <ul
                                                                                    class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                                                    @can('formation-update')
                                                                                        <li><a class="dropdown-item btn btn-sm"
                                                                                                href="{{ route('formations.edit', $operateurformation->id) }}"
                                                                                                class="mx-1" title="Modifier"><i
                                                                                                    class="bi bi-pencil"></i>Modifier</a>
                                                                                        </li>
                                                                                    @endcan

                                                                                    @can('formation-delete')
                                                                                        <li>
                                                                                            <form
                                                                                                action="{{ route('formations.destroy', $operateurformation->id) }}"
                                                                                                method="post">
                                                                                                @csrf
                                                                                                @method('DELETE')
                                                                                                <button type="submit"
                                                                                                    class="dropdown-item show_confirm"
                                                                                                    title="Supprimer"><i
                                                                                                        class="bi bi-trash"></i>Supprimer</button>
                                                                                            </form>
                                                                                        </li>
                                                                                    @endcan
                                                                                </ul>
                                                                            </div>
                                                                        </span>
                                                                    @endcan
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="alert alert-info mt-5">Aucun opérateur pour le moment !!!</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="tab-content pt-0">
                                <div class="tab-pane fade show active profile-overview" id="beneficiaires-overview">
                                    @if (!empty($module))
                                        <div class="col-12 col-md-12 col-lg-12 mb-0">
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <span class="card-title d-flex align-items-baseline">Code formation :&nbsp;
                                                    <span class="badge bg-info text-white">
                                                        {{ $formation?->code }}</span>
                                                </span>
                                                @can('formation-show')
                                                    <span class="card-title d-flex align-items-baseline">Statut formation
                                                        :&nbsp;
                                                        <span class="{{ $formation?->statut }} text-white">
                                                            {{ $formation?->statut }}</span>
                                                        <div class="filter">
                                                            <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                                                    class="bi bi-three-dots"></i></a>
                                                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                                @can('demarrer-formation')
                                                                    <form
                                                                        action="{{ route('validation-formations.update', $formation?->id) }}"
                                                                        method="post">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <button
                                                                            class="show_confirm_valider btn btn-sm mx-1">Démarrer</button>
                                                                    </form>
                                                                @endcan
                                                                @can('terminer-formation')
                                                                    <form action="{{ route('formationTerminer') }}"
                                                                        method="post">
                                                                        @csrf
                                                                        <input type="hidden" name="id"
                                                                            value="{{ $formation->id }}">
                                                                        <button
                                                                            class="show_confirm_valider btn btn-sm mx-1">Terminer</button>
                                                                    </form>
                                                                @endcan

                                                                @can('annuler-formation')
                                                                    <button class="btn btn-sm mx-1" data-bs-toggle="modal"
                                                                        data-bs-target="#RejetDemandeModal">Annuler
                                                                    </button>
                                                                @endcan
                                                                <hr>
                                                                <form action="{{ route('feuillePresence') }}" method="post"
                                                                    target="_blank">
                                                                    @csrf
                                                                    {{-- @method('PUT') --}}
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $formation->id }}">
                                                                    <button class="btn btn-sm mx-1">Feuille présence</button>
                                                                </form>
                                                                <form action="{{ route('ficheSuivi') }}" method="post"
                                                                    target="_blank">
                                                                    @csrf
                                                                    {{-- @method('PUT') --}}
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $formation->id }}">
                                                                    <button class="btn btn-sm mx-1">Fiche de suivi</button>
                                                                </form>
                                                                @can('pv-formation')
                                                                    <form action="{{ route('pvVierge') }}" method="post"
                                                                        target="_blank">
                                                                        @csrf
                                                                        {{-- @method('PUT') --}}
                                                                        <input type="hidden" name="id"
                                                                            value="{{ $formation->id }}">
                                                                        <button class="btn btn-sm mx-1">PV vierge</button>
                                                                    </form>
                                                                    <form action="{{ route('pvEvaluation') }}" method="post"
                                                                        target="_blank">
                                                                        @csrf
                                                                        {{-- @method('PUT') --}}
                                                                        <input type="hidden" name="id"
                                                                            value="{{ $formation->id }}">
                                                                        <button class="btn btn-sm mx-1">PV finale</button>
                                                                    </form>
                                                                @endcan
                                                                @can('lettre-formation')
                                                                    <hr>
                                                                    <form action="{{ route('lettreEvaluation') }}" method="post"
                                                                        target="_blank">
                                                                        @csrf
                                                                        {{-- @method('PUT') --}}
                                                                        <input type="hidden" name="id"
                                                                            value="{{ $formation->id }}">
                                                                        <button class="btn btn-sm mx-1">Lettre mission</button>
                                                                    </form>
                                                                @endcan
                                                                @can('lettre-formation')
                                                                    <form action="{{ route('abeEvaluation') }}" method="post"
                                                                        target="_blank">
                                                                        @csrf
                                                                        {{-- @method('PUT') --}}
                                                                        <input type="hidden" name="id"
                                                                            value="{{ $formation->id }}">
                                                                        <button class="btn btn-sm mx-1">A B E</button>
                                                                    </form>
                                                                @endcan
                                                                @can('email-formation')
                                                                    <hr>
                                                                    <form action="{{ route('sendFormationEmail') }}"
                                                                        method="post">
                                                                        @csrf
                                                                        <input type="hidden" name="id"
                                                                            value="{{ $formation->id }}">
                                                                        <button
                                                                            class="show_confirm_valider btn btn-sm mx-1">Démarrage
                                                                            (e-mail)</button>
                                                                    </form>
                                                                    {{-- <form action="{{ route('send-training-start-email', ['trainingId' => $formation->id]) }}" method="POST">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-primary">Informer les demandeurs du démarrage de la formation</button>
                                                                    </form> --}}

                                                                    <form action="{{ route('sendWelcomeEmail') }}"
                                                                        method="post">
                                                                        @csrf
                                                                        {{-- @method('PUT') --}}
                                                                        <input type="hidden" name="id"
                                                                            value="{{ $formation->id }}">
                                                                        <button
                                                                            class="show_confirm_valider btn btn-sm mx-1">Résultats
                                                                            (e-mail)</button>
                                                                    </form>

                                                                    <hr>

                                                                    <button class="btn btn-sm mx-1" data-bs-toggle="modal"
                                                                        data-bs-target="#sendFormationSMS">Démarrage
                                                                        (SMS)
                                                                    </button>
                                                                    <br>
                                                                    <button class="btn btn-sm mx-1" data-bs-toggle="modal"
                                                                        data-bs-target="#sendWelcomeSMS">Résultats
                                                                        (SMS)
                                                                    </button>
                                                                @endcan

                                                                <hr>

                                                                <form action="{{ route('suivreTous', $formation?->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <button class="show_confirm_suivi btn btn-sm mx-1">Suivre
                                                                        tous</button>
                                                                </form>
                                                            </ul>
                                                        </div>
                                                    </span>
                                                @endcan
                                                <div class="float-end">
                                                    <a href="{{ url('formationdemandeurs', ['$idformation' => $formation->id, '$idmodule' => $formation?->module?->id, '$idlocalite' => $formation->departement->region->id]) }}"
                                                        class="btn btn-outline-primary btn-rounded btn-sm">
                                                        <i class="bi bi-plus" title="Ajouter demandeur"></i> </a>
                                                </div>
                                            </div>
                                            <div class="row g-3 pt-3">
                                                <table
                                                    class="table table-bordered table-hover datatables align-middle justify-content-center table-borderless"
                                                    id="table-operateurModules">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">N°</th>
                                                            <th class="text-center">CIN</th>
                                                            <th>Prénom</th>
                                                            <th>NOM</th>
                                                            <th class="text-center">Date naissance</th>
                                                            <th class="text-center">Lieu de naissance</th>
                                                            <th class="text-center">Telephone</th>
                                                            {{-- Condition pour afficher la note ou la confirmation --}}
                                                            @if ($formation->statut === 'Terminée')
                                                                <th class="text-center">Note</th>
                                                            @else
                                                                <th class="text-center">Confirmation</th>
                                                            @endif
                                                            {{-- Masquer le suivi si la formation n'est pas encore Terminée --}}
                                                            @if ($formation->statut === 'Terminée')
                                                                @can('rapport-suivi-formes-view')
                                                                    <th width='3%' class="text-center">Suivi</th>
                                                                @endcan
                                                            @endif
                                                            <th width='2%' class="text-center"><i
                                                                    class="bi bi-gear"></i>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($formation->individuelles as $individuelle)
                                                            <tr valign="middle">
                                                                <td class="text-center">{{ $i++ }}</td>
                                                                <td style="text-align: center;">
                                                                    {{ $individuelle?->user?->cin }}</td>
                                                                <td>{{ $individuelle?->user?->firstname }}</td>
                                                                <td>{{ $individuelle?->user?->name }}</td>
                                                                <td style="text-align: center;">
                                                                    {{ $individuelle?->user?->date_naissance?->format('d/m/Y') }}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ $individuelle?->user?->lieu_naissance }}
                                                                </td>
                                                                <td style="text-align: center;">
                                                                    {{ $individuelle?->user?->telephone }}
                                                                </td>
                                                                {{-- Condition pour afficher la note ou la confirmation --}}
                                                                @if ($formation->statut === 'Terminée')
                                                                    <td class="text-center">
                                                                        {{ $individuelle?->note_obtenue ?? ' ' }}</td>
                                                                @else
                                                                    <td class="text-center">
                                                                        <span
                                                                            class="{{ $individuelle?->confirmation }}">{{ $individuelle?->confirmation ?? ' ' }}</span>
                                                                        @if (!empty($individuelle?->motif_declinaison))
                                                                            <!-- Bouton qui ouvre le modal -->
                                                                            <button class="btn btn-sm mx-1"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#declinaisonModal{{ $individuelle->id }}">
                                                                                <i class="bi bi-plus"></i> Voir
                                                                            </button>
                                                                        @endif
                                                                    </td>
                                                                @endif
                                                                {{-- Masquer le suivi si la formation n'est pas encore Terminée --}}
                                                                @if ($formation->statut === 'Terminée')
                                                                    @can('rapport-suivi-formes-view')
                                                                        <td style="text-align: center;">
                                                                            @if (empty($individuelle?->suivi))
                                                                                <form
                                                                                    action="{{ route('SuivreFormes', $individuelle?->id) }}"
                                                                                    method="post">
                                                                                    @csrf
                                                                                    @method('PUT')
                                                                                    <button
                                                                                        class="show_confirm_suivi btn btn-dark rounded-pill btn-sm float-center">
                                                                                        Suivre
                                                                                    </button>
                                                                                </form>
                                                                            @else
                                                                                <button type="button"
                                                                                    class="btn btn-success rounded-pill btn-sm float-center">
                                                                                    {{ $individuelle?->suivi }}
                                                                                </button>
                                                                            @endif
                                                                        </td>
                                                                    @endcan
                                                                @endif

                                                                <td>
                                                                    <span class="d-flex align-items-baseline">
                                                                        <a href="{{ route('individuelles.show', $individuelle?->id) }}"
                                                                            class="btn btn-primary btn-sm"
                                                                            title="voir détails"><i
                                                                                class="bi bi-eye"></i></a>
                                                                        <div class="filter">
                                                                            <a class="icon" href="#"
                                                                                data-bs-toggle="dropdown"><i
                                                                                    class="bi bi-three-dots"></i></a>
                                                                            <ul
                                                                                class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                                                @can('retirer-demandeur-formation')
                                                                                    <button class="btn btn-sm mx-1"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#indiponibleModal{{ $individuelle->id }}">Retirer
                                                                                    </button>
                                                                                @endcan
                                                                                @if (!empty($individuelle?->suivi) && $formation->statut !== 'Attente')
                                                                                    <form
                                                                                        action="{{ route('nepasSuivre', $individuelle?->id) }}"
                                                                                        method="post">
                                                                                        @csrf
                                                                                        @method('PUT')
                                                                                        <button
                                                                                            class="show_confirm_suivi btn btn-sm mx-1">Ne
                                                                                            plus suivre</button>
                                                                                    </form>
                                                                                @endif
                                                                            </ul>
                                                                        </div>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @else
                                        <div class="alert alert-info mt-3">Aucun bénéficiaire pour le moment !!!</div>
                                    @endif
                                </div>
                            </div>
                            {{-- Détail Modules --}}
                            <div class="tab-content pt-2">
                                <div class="tab-pane fade module-overview pt-3" id="module-overview">
                                    @if (!empty($module))
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="card-title">
                                                {{ $module?->name }}
                                                @can('module-check')
                                                    <a class="btn btn-info btn-sm" title=""
                                                        href="{{ route('modules.show', $module?->id) }}"><i
                                                            class="bi bi-eye"></i></a>&nbsp;
                                                    <a href="{{ url('formationmodules', ['$idformation' => $formation->id, '$idlocalite' => $formation->departement->region->id]) }}"
                                                        class="btn btn-primary float-end btn-sm">
                                                        <i class="bi bi-pencil" title="Changer module"></i></a>
                                                @endcan
                                            </h5>
                                        </div>
                                    @else
                                        <div>
                                            @can('module-check')
                                                <a href="{{ url('moduleformations', ['$idformation' => $formation->id, '$idlocalite' => $formation->departement->region->id]) }}"
                                                    class="btn btn-primary float-end btn-sm">
                                                    <i class="bi bi-plus" title="Ajouter module"></i> </a>
                                            @endcan
                                        </div>
                                        <div class="alert alert-info mt-5">Aucun module pour le moment !!!</div>
                                    @endif
                                    {{-- <div class="col-12 col-md-12 col-lg-12 mb-0">
                                        @isset($operateur)
                                            <h1 class="card-title">
                                                @if (isset($module))
                                                    Liste des formations en {{ $module?->name }}
                                                @endif
                                            </h1>
                                            <div class="row g-3">
                                                <table class="table table-bordered table-hover datatables"
                                                    id="table-formations">
                                                    <thead>
                                                        <tr>
                                                            <th>Code</th>
                                                            <th>Type</th>
                                                            <th>Intitulé formation</th>
                                                            <th>Localité</th>
                                                            <th>Effectif</th>
                                                            <th>Statut</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($module?->formations as $formation)
                                                            <tr>
                                                                <td>{{ $formation?->code }}</td>
                                                                <td><a
                                                                        href="#">{{ $formation->types_formation?->name }}</a>
                                                                </td>
                                                                <td>{{ $formation?->name }}</td>
                                                                <td>{{ $formation->departement?->region?->nom }}</td>
                                                                <td class="text-center">
                                                                    @foreach ($formation->individuelles as $individuelle)
                                                                        @if ($loop->last)
                                                                            <a class="text-primary fw-bold"
                                                                                href="{{ route('formations.show', $formation->id) }}">{!! $loop->count ?? '0' !!}</a>
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                                <td><a href="#"><span
                                                                            class="{{ $formation?->statut }}">{{ $formation?->statut }}</span></a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                </table>
                                            </div>
                                        @endisset
                                    </div> --}}

                                </div>
                            </div>
                            {{-- Détail ingenieur --}}
                            <div class="tab-content">
                                <div class="tab-pane fade ingenieur-overview" id="ingenieur-overview">
                                    @if (!empty($ingenieur))
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="card-title">
                                                {{ $ingenieur?->name }}
                                                @can('ingenieur-check')
                                                    <a class="btn btn-info btn-sm" title=""
                                                        href="{{ route('ingenieurs.show', $ingenieur?->id) }}"><i
                                                            class="bi bi-eye"></i></a>&nbsp;
                                                    <a href="{{ url('formationingenieurs', ['$idformation' => $formation->id]) }}"
                                                        class="btn btn-primary float-end btn-sm">
                                                        <i class="bi bi-pencil" title="Changer ingenieur"></i> </a>
                                                @endcan
                                            </h5>
                                            <h5 class="card-title">
                                                Agent de suivi
                                                @can('ingenieur-check')
                                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#EditAgentSuiviModal{{ $formation->id }}">
                                                        <i class="bi bi-plus" title="Ajouter un agent de suivi"></i>
                                                    </button>
                                                @endcan
                                            </h5>
                                        </div>
                                    @else
                                        <div class="pb-2">
                                            <a href="{{ url('formationingenieurs', ['$idformation' => $formation->id]) }}"
                                                class="btn btn-primary float-end btn-sm">
                                                <i class="bi bi-plus" title="Ajouter ingenieur"></i> </a>
                                        </div>
                                        <div class="alert alert-info mt-5">Aucun ingénieur pour le moment !!!</div>
                                    @endif
                                    <div class="col-12 col-md-12 col-lg-12 mb-0">
                                        @if (!empty($ingenieur))
                                            <h1 class="card-title">
                                                Liste des formations
                                                @if (!empty($ingenieur))
                                                    de {{ $ingenieur?->name }}
                                                @endif
                                            </h1>
                                            <div class="row g-3">
                                                <table class="table table-bordered table-hover datatables"
                                                    id="table-formations">
                                                    <thead>
                                                        <tr>
                                                            <th>Code</th>
                                                            <th>Type</th>
                                                            <th>Intitulé formation</th>
                                                            <th>Localité</th>
                                                            {{-- <th>Modules</th> --}}
                                                            {{-- <th>Niveau qualification</th> --}}
                                                            <th>Effectif</th>
                                                            <th>Statut</th>
                                                            <th class="text-center"><i class="bi bi-gear"></i></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($ingenieur?->formations as $ingenieurformation)
                                                            <tr valign="middle">
                                                                <td>{{ $ingenieurformation?->code }}</td>
                                                                <td><a
                                                                        href="#">{{ $ingenieurformation->types_formation?->name }}</a>
                                                                </td>
                                                                <td>{{ $ingenieurformation?->name }}</td>
                                                                <td>{{ $ingenieurformation->departement?->region?->nom }}
                                                                </td>
                                                                {{-- <td>{{ $ingenieurformation->module?->name }}</td> --}}
                                                                {{-- <td>{{ $ingenieurformation->niveau_qualification }}</td> --}}
                                                                <td class="text-center">
                                                                    @foreach ($ingenieurformation->individuelles as $individuelle)
                                                                        @if ($loop->last)
                                                                            <a class="text-primary fw-bold"
                                                                                href="{{ route('formations.show', $ingenieurformation->id) }}">{!! $loop->count ?? '0' !!}</a>
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                                <td><a href="#"><span
                                                                            class="{{ $ingenieurformation?->statut }}">{{ $ingenieurformation?->statut }}</span></a>
                                                                </td>
                                                                <td>
                                                                    <span class="d-flex align-items-baseline"><a
                                                                            href="{{ route('formations.show', $ingenieurformation->id) }}"
                                                                            class="btn btn-primary btn-sm"
                                                                            title="voir détails"><i
                                                                                class="bi bi-eye"></i></a>
                                                                        <div class="filter">
                                                                            <a class="icon" href="#"
                                                                                data-bs-toggle="dropdown"><i
                                                                                    class="bi bi-three-dots"></i></a>
                                                                            <ul
                                                                                class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                                                <li><a class="dropdown-item btn btn-sm"
                                                                                        href="{{ route('formations.edit', $ingenieurformation->id) }}"
                                                                                        class="mx-1" title="Modifier"><i
                                                                                            class="bi bi-pencil"></i>Modifier</a>
                                                                                </li>
                                                                                <li>
                                                                                    <form
                                                                                        action="{{ route('formations.destroy', $ingenieurformation->id) }}"
                                                                                        method="post">
                                                                                        @csrf
                                                                                        @method('DELETE')
                                                                                        <button type="submit"
                                                                                            class="dropdown-item show_confirm"
                                                                                            title="Supprimer"><i
                                                                                                class="bi bi-trash"></i>Supprimer</button>
                                                                                    </form>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </div>
                            {{-- Evaluation --}}
                            <div class="tab-content pt-2">
                                <div class="tab-pane fade module-overview" id="evaluation-overview">
                                    @if (!empty($module))
                                        <div class="col-12 col-md-12 col-lg-12 mb-0">
                                            <form method="post"
                                                action="{{ url('notedemandeurs', ['$idformation' => $formation->id]) }}"
                                                enctype="multipart/form-data" class="row g-3">
                                                @csrf
                                                @method('PUT')
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h1 class="card-title"> Liste des bénéficiaires :
                                                        {{ $count_demandes }}</h1>
                                                    <h5 class="card-title">
                                                        @can('jury-formation')
                                                            Membres du jury
                                                            <button type="button" class="btn btn-outline-primary btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#EditMembresJuryModal{{ $formation->id }}">
                                                                <i class="bi bi-plus" title="Ajouter les membres du jury"></i>
                                                            </button>
                                                        @endcan
                                                    </h5>
                                                </div>
                                                <div class="row g-3">
                                                    <table class="table table-bordered table-hover datatables"
                                                        id="table-evaluation">
                                                        <thead>
                                                            <tr>
                                                                <th>N°</th>
                                                                {{-- <th>Numéro</th> --}}
                                                                <th>Civilité</th>
                                                                <th>CIN</th>
                                                                <th>Prénom</th>
                                                                <th>NOM</th>
                                                                <th>Date naissance</th>
                                                                <th>Lieu de naissance</th>
                                                                <th class="text-center">Note<span
                                                                        class="text-danger mx-1">*</span></th>
                                                                <th class="text-center">Observations</th>
                                                                {{-- <th class="col"><i class="bi bi-gear"></i></th> --}}
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 1; ?>
                                                            @foreach ($formation->individuelles as $individuelle)
                                                                <tr valign="middle">
                                                                    <td>{{ $i++ }}</td>
                                                                    {{-- <td>{{ $individuelle?->numero }}</td> --}}
                                                                    <td>{{ $individuelle?->user?->civilite }}</td>
                                                                    <td>{{ $individuelle?->user?->cin }}</td>
                                                                    <td>{{ $individuelle?->user?->firstname }}</td>
                                                                    <td>{{ $individuelle?->user?->name }}</td>
                                                                    <td>{{ $individuelle?->user->date_naissance?->format('d/m/Y') }}
                                                                    </td>
                                                                    <td>{{ $individuelle?->user->lieu_naissance }}</td>
                                                                    <td class="text-center"><input type="number"
                                                                            value="{{ $individuelle?->note_obtenue }}"
                                                                            name="notes[]" placeholder="note"
                                                                            step="0.01" min="0" max="20">
                                                                        <input type="hidden" name="individuelles[]"
                                                                            value="{{ $individuelle?->id }}">
                                                                    </td>
                                                                    <td
                                                                        style="text-align: center; vertical-align: middle;">
                                                                        @can('evaluer-formation')
                                                                            <button type="button"
                                                                                class="btn btn-outline-primary btn-sm"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#EditDemandeurModal{{ $individuelle->id }}">
                                                                                <i class="bi bi-plus"
                                                                                    title="Observations"></i>
                                                                            </button>
                                                                        @endcan
                                                                    </td>
                                                                    {{-- <td>
                                                                    <span class="d-flex align-items-baseline"><a
                                                                            href="{{ route('individuelles.show', $individuelle->id) }}"
                                                                            class="btn btn-primary btn-sm"
                                                                            title="voir détails"><i class="bi bi-eye"></i></a>
                                                                        <div class="filter">
                                                                            <a class="icon" href="#"
                                                                                data-bs-toggle="dropdown"><i
                                                                                    class="bi bi-three-dots"></i></a>
                                                                            <ul
                                                                                class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                                                <li>
                                                                                    <a class="btn btn-danger btn-sm"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#indiponibleModal{{ $individuelle->id }}"
                                                                                        title="retirer">Retirer de cette
                                                                                        formation
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </span>
                                                                </td> --}}
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    </table>
                                                </div>
                                                @can('evaluation-formation')
                                                    <div class="text-center">
                                                        <button type="submit" class="btn btn-outline-primary btn-sm"><i
                                                                class="bi bi-check2-circle"></i>&nbsp;Save</button>
                                                    </div>
                                                @endcan
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            {{-- Emargement --}}
                            <div class="tab-content pt-2">
                                <div class="tab-pane fade module-overview" id="emargement-overview">
                                    <div class="col-12 col-md-12 col-lg-12 mb-0">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h1 class="card-title">Feuilles de présence</h1>
                                            <span class="d-flex align-items-baseline">
                                                <button type="button" class="btn btn-outline-primary btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#ajouterJours{{ $formation->id }}">ajouter
                                                </button>
                                                <div class="filter">
                                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                                            class="bi bi-three-dots"></i></a>
                                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                        <li>
                                                            <form action="{{ route('feuillePresenceFinale') }}"
                                                                method="post" target="_blank">
                                                                @csrf
                                                                <input type="hidden" name="idformation"
                                                                    value="{{ $formation->id }}">
                                                                <input type="hidden" name="idmodule"
                                                                    value="{{ $formation?->module?->id }}">
                                                                <input type="hidden" name="idlocalite"
                                                                    value="{{ $formation?->departement?->region?->id }}">
                                                                <button class="btn btn-sm mx-1">Feuille présence</button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('etatTransport') }}" method="post"
                                                                target="_blank">
                                                                @csrf
                                                                <input type="hidden" name="idformation"
                                                                    value="{{ $formation->id }}">
                                                                <input type="hidden" name="idmodule"
                                                                    value="{{ $formation?->module?->id }}">
                                                                <input type="hidden" name="idlocalite"
                                                                    value="{{ $formation?->departement?->region?->id }}">
                                                                <button class="btn btn-sm mx-1">Etat transport</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </span>
                                        </div>
                                        <div class="row g-3">
                                            <table class="table table-bordered table-hover datatables"
                                                id="table-evaluation">
                                                <thead>
                                                    <tr>
                                                        <th width="5%" class="text-center">N°</th>
                                                        <th width="10%" class="text-center">Jours</th>
                                                        <th width="10%" class="text-center">Date</th>
                                                        <th width="10%" class="text-center">Effectif</th>
                                                        <th width="10%" class="text-center">SCAN</th>
                                                        <th>Observations</th>
                                                        <th width="5%" class="text-center"><i class="bi bi-gear"></i>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1; ?>
                                                    @foreach ($emargements as $emargement)
                                                        <tr valign="middle">
                                                            <td class="text-center">{{ $i++ }}</td>
                                                            <td class="text-center">{{ $emargement?->jour }}</td>
                                                            <td class="text-center">
                                                                {{ $emargement?->date?->format('d/m/Y') }}</td>
                                                            <td class="text-center">
                                                                {{ count($emargement?->formation?->individuelles) }}</td>
                                                            <td class="text-center">
                                                                @if (!empty($emargement?->file))
                                                                    <div>
                                                                        <a class="btn btn-outline-secondary btn-sm"
                                                                            title="Feuille émargement" target="_blank"
                                                                            href="{{ asset($emargement->getFileEmargement()) }}">
                                                                            <i class="bi bi-file-earmark-pdf"></i>
                                                                        </a>
                                                                    </div>
                                                                @else
                                                                    <div class="badge bg-warning">Aucun</div>
                                                                @endif
                                                            </td>
                                                            <td>{{ $emargement?->observations }}</td>
                                                            <td class="text-center">
                                                                <span class="d-flex mt-2 align-items-baseline">
                                                                    <form
                                                                        action="{{ route('formationemargement', [
                                                                            '$idformation' => $formation->id,
                                                                            '$idmodule' => $formation->module->id,
                                                                            '$idlocalite' => $formation->departement->id,
                                                                        ]) }}"
                                                                        method="get">
                                                                        @csrf
                                                                        <input type="hidden" name="idformation"
                                                                            value="{{ $formation?->id }}">
                                                                        <input type="hidden" name="idmodule"
                                                                            value="{{ $formation?->module?->id }}">
                                                                        <input type="hidden" name="idlocalite"
                                                                            value="{{ $formation?->departement?->region?->id }}">
                                                                        <input type="hidden" name="idemargement"
                                                                            value="{{ $emargement?->id }}">
                                                                        <button type="submit"
                                                                            class="btn btn-outline-primary btn-rounded btn-sm"><i
                                                                                class="bi bi-eye"
                                                                                title="Ajouter bénéficiaires"></i></button>
                                                                    </form>
                                                                    <div class="filter">
                                                                        <a class="icon" href="#"
                                                                            data-bs-toggle="dropdown"><i
                                                                                class="bi bi-three-dots"></i></a>
                                                                        <ul
                                                                            class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                                            <li>
                                                                                <button type="button"
                                                                                    class="dropdown-item btn btn-sm mx-1"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#EditEmargementModal{{ $emargement->id }}">
                                                                                    <i class="bi bi-pencil"
                                                                                        title="Modifier"></i> Modifier
                                                                                </button>
                                                                            </li>
                                                                            <li>
                                                                                <form
                                                                                    action="{{ url('emargements', $emargement->id) }}"
                                                                                    method="post">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit"
                                                                                        class="dropdown-item show_confirm"><i
                                                                                            class="bi bi-trash"></i>Supprimer</button>
                                                                                </form>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </span>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Retrait attestation --}}
                            <div class="tab-content pt-2">
                                <div class="tab-pane fade attestation-overview pt-1" id="retrait-attestation-overview">
                                    @if (!empty($module))
                                        <div class="col-12 col-md-12 col-lg-12 mb-0">
                                            {{-- <form method="post"
                                                action="{{ url('notedemandeurs', ['$idformation' => $formation->id]) }}"
                                                enctype="multipart/form-data" class="row g-3">
                                                @csrf
                                                @method('PUT') --}}
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h1 class="card-title">Retrait des attestations</h1>
                                                <h5 class="card-title">
                                                    @can('attestation-formation')
                                                        Informer
                                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#EditRemiseAttestationsModal{{ $formation->id }}">
                                                            <i class="bi bi-plus" title="Ajouter les membres du jury"></i>
                                                        </button>
                                                    @endcan
                                                </h5>
                                            </div>
                                            <div class="row g-3">
                                                <table class="table table-bordered table-hover datatables"
                                                    id="table-evaluation">
                                                    <thead>
                                                        <tr>
                                                            <th>N°</th>
                                                            {{-- <th>Numéro</th> --}}
                                                            <th>Civilité</th>
                                                            <th>CIN</th>
                                                            <th>Prénom</th>
                                                            <th>NOM</th>
                                                            <th>Date naissance</th>
                                                            <th>Lieu de naissance</th>
                                                            <th class="text-center">Note<span
                                                                    class="text-danger mx-1">*</span></th>
                                                            <th class="text-center">Diplôme</th>
                                                            <th class="text-center"><i class="bi bi-gear"></i></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($formation->individuelles as $individuelle)
                                                            <tr valign="middle">
                                                                <td>{{ $i++ }}</td>
                                                                {{-- <td>{{ $individuelle?->numero }}</td> --}}
                                                                <td>{{ $individuelle?->user?->civilite }}</td>
                                                                <td>{{ $individuelle?->user?->cin }}</td>
                                                                <td>{{ $individuelle?->user?->firstname }}</td>
                                                                <td>{{ $individuelle?->user?->name }}</td>
                                                                <td>{{ $individuelle?->user?->date_naissance?->format('d/m/Y') }}
                                                                </td>
                                                                <td>{{ $individuelle?->user?->lieu_naissance }}</td>
                                                                <td style="text-align: center">
                                                                    {{-- <input type="number"
                                                                            value="{{ $individuelle?->note_obtenue }}"
                                                                            name="notes[]" placeholder="note" step="0.01"
                                                                            min="0" max="20">
                                                                        <input type="hidden" name="individuelles[]"
                                                                            value="{{ $individuelle?->id }}"> --}}
                                                                    <span>{{ $individuelle?->note_obtenue }}</span>
                                                                </td>
                                                                <td style="text-align: center; vertical-align: middle;">
                                                                    @if (!empty($individuelle?->retrait_diplome))

                                                                        <a href="#" data-bs-toggle="modal"
                                                                            data-bs-target="#EditShowModal{{ $individuelle?->id }}"><i
                                                                                class="bi bi-check-circle text-success"
                                                                                title="diplome retiré"></i></a>
                                                                    @else
                                                                        <i class="bi bi-x text-danger"
                                                                            title="diplome non retiré"></i>
                                                                    @endif
                                                                </td>
                                                                <td style="text-align: center; vertical-align: middle;">
                                                                    @can('attestation-formation')
                                                                        <button type="button"
                                                                            class="btn btn-outline-primary btn-sm"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#EditAttestationsModal{{ $individuelle->id }}">
                                                                            <i class="bi bi-plus" title="Attestation"></i>
                                                                        </button>
                                                                    @endcan
                                                                </td>
                                                                {{-- <td>
                                                                    <span class="d-flex align-items-baseline"><a
                                                                            href="{{ route('individuelles.show', $individuelle->id) }}"
                                                                            class="btn btn-primary btn-sm"
                                                                            title="voir détails"><i class="bi bi-eye"></i></a>
                                                                        <div class="filter">
                                                                            <a class="icon" href="#"
                                                                                data-bs-toggle="dropdown"><i
                                                                                    class="bi bi-three-dots"></i></a>
                                                                            <ul
                                                                                class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                                                <li>
                                                                                    <a class="btn btn-danger btn-sm"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#indiponibleModal{{ $individuelle->id }}"
                                                                                        title="retirer">Retirer de cette
                                                                                        formation
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </span>
                                                                </td> --}}
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                </table>
                                            </div>
                                            {{-- <div class="text-center">
                                                    <button type="submit" class="btn btn-outline-primary"><i
                                                            class="bi bi-check2-circle"></i>&nbsp;Save</button>
                                                </div>
                                            </form> --}}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Edit Operateur-->
        @foreach ($formation->individuelles as $individuelle)
            <div class="modal fade" id="indiponibleModal{{ $individuelle->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="{{ route('giveindisponibles', $formation->id) }}"
                            enctype="multipart/form-data" class="row">
                            @csrf
                            @method('PUT')
                            <div class="card-header bg-gradient-default">
                                <h1 class="h4 text-black mb-0">Retirer
                                    {{ $individuelle?->user?->civilite . ' ' . $individuelle?->user?->firstname . ' ' . $individuelle?->user?->name }}
                                </h1>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3">
                                    @if (!empty($individuelle?->motif_rejet))
                                        <div class="col-12">
                                            <span class="form-label">Motif: </span>
                                            <p class="small fst-italic" style="white-space: pre-line;">
                                                {{ str_replace(';', ";\n", $individuelle?->motif_rejet) }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                                <div class="row g-3">
                                    <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <input type="hidden" name="individuelleid" value="{{ $individuelle->id }}">
                                        <label for="motif" class="form-label">Justification du retrait<span
                                                class="text-danger mx-1">*</span></label>
                                        <textarea name="motif" id="motif" rows="5"
                                            class="form-control form-control-sm @error('motif') is-invalid @enderror"
                                            placeholder="Expliquer les raisons du retrait de ce bénéficiaire">{{ old('motif') }}</textarea>
                                        @error('motif')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm"
                                    data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-danger btn-sm"><i
                                        class="bi bi-arrow-right-circle"></i>
                                    Retirer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
        <!-- Remise attestation-->
        <div class="modal fade" id="EditRemiseAttestationsModal{{ $formation->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" action="{{ url('remiseAttestations', ['$idformation' => $formation->id]) }}"
                        enctype="multipart/form-data" class="row">
                        @csrf
                        @method('PUT')
                        {{-- <div class="modal-header">
                            <h5 class="modal-title"><i class="bi bi-plus" title="Ajouter"></i> Situation des attestations
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div> --}}

                        <div class="card-header text-center bg-gradient-default">
                            <h1 class="h4 text-black mb-0">SATATUT ATTESTATIONS</h1>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="formationid" value="{{ $formation->id }}">
                            <label for="region" class="form-label">Statut attestations<span
                                    class="text-danger mx-1">*</span></label>
                            <select name="statut"
                                class="form-select form-select-sm @error('statut') is-invalid @enderror"
                                aria-label="Select" id="select-field-statut-attestations"
                                data-placeholder="Choisir statut attestations">
                                <option value="{{ $formation?->attestation ?? old('statut') }}">
                                    {{ $formation?->attestation ?? old('statut') }}
                                </option>
                                <option value="En cours">
                                    En cours
                                </option>
                                <option value="disponible">
                                    disponible
                                </option>
                                <option value="retiré">
                                    retiré
                                </option>
                            </select>
                            @error('statut')
                                <span class="invalid-feedback" role="alert">
                                    <div>{{ $message }}</div>
                                </span>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm"
                                data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary btn-sm"><i
                                    class="bi bi-arrow-right-circle"></i>
                                Valider</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="RejetDemandeModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" action="{{ route('validation-formations.destroy', $formation->id) }}"
                        enctype="multipart/form-data" class="row">
                        @csrf
                        @method('DELETE')
                        <div class="card-header text-center bg-gradient-default">
                            <h1 class="h4 text-black mb-0">ANNULER DEMANDE</h1>
                        </div>
                        <div class="modal-body">
                            <label for="motif" class="form-label">Motifs<span
                                    class="text-danger mx-1">*</span></label>
                            <textarea name="motif" id="motif" rows="5"
                                class="form-control form-control-sm @error('motif') is-invalid @enderror" placeholder="Motifs de l'annulation">{{ old('motif') }}</textarea>
                            @error('motif')
                                <span class="invalid-feedback" role="alert">
                                    <div>{{ $message }}</div>
                                </span>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm"
                                data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-danger btn-sm">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="sendFormationSMS" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('sendFormationSMS') }}" method="post">
                        @csrf
                        <div class="card-header text-center bg-gradient-info">
                            <h1 class="h4 text-black mb-0">ENVOYER SMS DEMARRAGE</h1>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" value="{{ $formation->id }}">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                    <div class="mb-3">
                                        <label for="titre" class="form-label">Titre<span
                                                class="text-danger mx-1">*</span></label>
                                        <textarea name="titre" id="titre" rows="1"
                                            class="form-control form-control-sm @error('titre') is-invalid @enderror" placeholder="Bonjour, Bonsoir">{{ 'Bonjour' ?? old('titre') }}</textarea>
                                        @error('titre')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                    <label for="sms" class="form-label">SMS<span
                                            class="text-danger mx-1">*</span></label>
                                    <textarea name="sms" id="sms" rows="3"
                                        class="form-control form-control-sm @error('sms') is-invalid @enderror" placeholder="Ecrire votre SMS ici">{{ 'vous êtes convoqué(e)s pour une formation en ' .
                                            $formation?->module?->name .
                                            ' le ' .
                                            $formation?->date_debut?->format('d/m/Y') .
                                            ' à partir de 08 h ' .
                                            ' à ' .
                                            $formation?->lieu ??
                                            old('sms') }}
                                    </textarea>
                                    @error('sms')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm"
                                data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-success btn-sm">Envoyer SMS</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="sendWelcomeSMS" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('sendWelcomeSMS') }}" method="post">
                        @csrf
                        <div class="card-header text-center bg-gradient-info">
                            <h1 class="h4 text-black mb-0">ENVOYER SMS FIN</h1>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" value="{{ $formation->id }}">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                    <div class="mb-3">
                                        <label for="titre" class="form-label">Titre<span
                                                class="text-danger mx-1">*</span></label>
                                        <textarea name="titre" id="titre" rows="1"
                                            class="form-control form-control-sm @error('titre') is-invalid @enderror" placeholder="Bonjour, Bonsoir">{{ 'Bonjour' ?? old('titre') }}</textarea>
                                        @error('titre')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                    <label for="sms" class="form-label">SMS<span
                                            class="text-danger mx-1">*</span></label>
                                    <textarea name="sms" id="sms" rows="3"
                                        class="form-control form-control-sm @error('sms') is-invalid @enderror" placeholder="Ecrire votre SMS ici">{{ 'votre formation en ' .
                                            $formation?->module?->name .
                                            ' est désormais terminée. Vous avez obtenu une note de ' ??
                                            old('sms') }}
                                    </textarea>
                                    @error('sms')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm"
                                data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-success btn-sm">Envoyer SMS</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Observations --}}
        @foreach ($formation->individuelles as $individuelle)
            <div class="modal fade" id="EditDemandeurModal{{ $individuelle->id }}" tabindex="-1" role="dialog"
                aria-labelledby="EditDemandeurModalLabel{{ $individuelle->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="{{ route('individuelles.updateObservations') }}"
                            enctype="multipart/form-data" class="row g-3">
                            @csrf
                            @method('patch')
                            <div class="card-header text-center bg-gradient-default">
                                <h1 class="h4 text-black mb-0">Ajouter un commentaire ou observation</h1>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" value="{{ $individuelle->id }}">
                                <label for="floatingInput" class="mb-3">Observation<span
                                        class="text-danger mx-1">*</span></label>
                                <textarea name="observations" id="observations" cols="30" rows="5"
                                    class="form-control form-control-sm @error('observations') is-invalid @enderror" placeholder="Observations"
                                    autofocus>{{ $individuelle->observations ?? old('observations') }}</textarea>
                                @error('observations')
                                    <span class="invalid-feedback" role="alert">
                                        <div>{{ $message }}</div>
                                    </span>
                                @enderror
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm"
                                    data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    Valider</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
        {{-- Attestations --}}
        @foreach ($formation->individuelles as $individuelle)
            <div class="modal fade" id="EditAttestationsModal{{ $individuelle->id }}" tabindex="-1" role="dialog"
                aria-labelledby="EditAttestationsModalLabel{{ $individuelle->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="{{ route('individuelles.updateAttestations') }}"
                            enctype="multipart/form-data" class="row g-3">
                            @csrf
                            @method('patch')
                            {{-- <div class="modal-header" id="EditAttestationsModalLabel{{ $individuelle->id }}">
                            <h5 class="modal-title">Retrait {{ $individuelle?->formation?->type_certification }} de
                                {{ $individuelle?->user?->civilite . ' ' . $individuelle?->user?->firstname . ' ' . $individuelle?->user?->name }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div> --}}

                            <div class="card-header text-center bg-gradient-default">
                                <h4 class="h4 text-black mb-0">
                                    {{ 'RETRAIT ' . strtoupper($individuelle?->formation?->type_certification) }}</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3">
                                    <input type="hidden" name="id" value="{{ $individuelle->id }}">
                                    <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <div class="row g-3">
                                            <div>
                                                {{ 'Bénéficiaire : ' . $individuelle?->user?->civilite . ' ' . $individuelle?->user?->firstname . ' ' . $individuelle?->user?->name }}
                                            </div>
                                            <hr>
                                            <label for="retrait" class="form-label">
                                                Qui va retirer le diplôme ?<span class="text-danger mx-1">*</span>
                                            </label>
                                            <div class="d-flex gap-3">
                                                <div class="form-check">
                                                    <input type="radio" id="moi" name="personne" value="moi"
                                                        class="form-check-input @error('personne') is-invalid @enderror">
                                                    <label class="form-check-label" for="moi">Le propriétaire</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" id="autre" name="personne" value="autre"
                                                        class="form-check-input @error('personne') is-invalid @enderror">
                                                    <label class="form-check-label" for="autre">Une autre
                                                        personne</label>
                                                </div>
                                            </div>
                                            @error('personne')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12 pt-3">
                                        <label for="date_retrait" class="form-label">Date retrait<span
                                                class="text-danger mx-1">*</span></label>
                                        <input type="date" name="date_retrait"
                                            value="{{ date('Y-m-d') ?? old('date_retrait') }}"
                                            class="datepicker form-control form-control-sm @error('date_retrait') is-invalid @enderror"
                                            id="date_retrait" placeholder="jj/mm/aaaa">
                                        @error('date_retrait')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                    <br>
                                    <label for="form-label">Si autre personne</label>
                                    <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <label for="cin" class="form-label">N° CIN</label>
                                        <input minlength="13" maxlength="14" type="text" name="cin"
                                            value="{{ old('cin') }}"
                                            class="form-control form-control-sm @error('cin') is-invalid @enderror"
                                            placeholder="Numéro carte d'identité nationale">
                                        @error('cin')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" name="name" value="{{ old('name') }}"
                                            class="form-control form-control-sm @error('name') is-invalid @enderror"
                                            placeholder="Prénom et NOM">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <label for="commentaires" class="form-label">Commentaires</label>
                                        <input type="text" maxlength="150" name="commentaires"
                                            value="{{ old('commentaires') }}"
                                            class="form-control form-control-sm @error('commentaires') is-invalid @enderror"
                                            placeholder="Un petit commentaire...">
                                        @error('commentaires')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm"
                                        data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Valider</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
        {{-- Attestations retrait --}}
        @foreach ($formation->individuelles as $individuelle)
            <div class="modal fade" id="EditShowModal{{ $individuelle->id }}" tabindex="-1" role="dialog"
                aria-labelledby="EditShowModalLabel{{ $individuelle->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        {{-- <form method="post" action="{{ route('individuelles.updateAttestations') }}"
                            enctype="multipart/form-data" class="row g-3">
                            @csrf
                            @method('patch') --}}
                        {{-- <div class="modal-header" id="EditShowModalLabel{{ $individuelle->id }}">
                        <h5 class="modal-title">Attestation de
                            {{ $individuelle?->user?->civilite . ' ' . $individuelle?->user?->firstname . ' ' . $individuelle?->user?->name }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div> --}}

                        <div class="card-header text-center bg-gradient-default">
                            <h4 class="h4 text-black mb-0">
                                {{ strtoupper($individuelle?->formation?->type_certification) . ' de ' . $individuelle?->user?->civilite . ' ' . $individuelle?->user?->firstname . ' ' . $individuelle?->user?->name }}
                            </h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" value="{{ $individuelle->id }}">
                            <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                <div class="row g-3">
                                    <label for="retrait" class="form-label">Informations !<span
                                            class="text-danger mx-1">*</span></label>
                                    <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <label class="form-check-label" for="moi">
                                            {{ 'Retrait effectué par ' . $individuelle?->retrait_diplome }}
                                        </label>

                                    </div>

                                </div>
                            </div>
                        </div>
                        {{-- <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-primary">
                                    Valider</button>
                            </div>
                        </form> --}}
                    </div>
                </div>
            </div>
        @endforeach
        {{-- Agent de suivi --}}
        <div class="modal fade" id="EditAgentSuiviModal{{ $formation->id }}" tabindex="-1" role="dialog"
            aria-labelledby="EditAgentSuiviModalLabel{{ $formation->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" action="{{ route('formations.updateAgentSuivi') }}"
                        enctype="multipart/form-data" class="row g-3">
                        @csrf
                        @method('patch')
                        <div class="card-header text-center bg-gradient-default">
                            <h1 class="h4 text-black mb-0">Ajouter un agent de suivi</h1>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" value="{{ $formation->id }}">
                            <div class="form-floating mb-3">
                                <input type="text" name="suivi_dossier"
                                    value="{{ $formation?->suivi_dossier ?? old('suivi_dossier') }}"
                                    class="form-control form-control-sm @error('suivi_dossier') is-invalid @enderror"
                                    id="suivi_dossier" placeholder="Nom de l'agent de suivi" autofocus>
                                @error('suivi_dossier')
                                    <span class="invalid-feedback" role="alert">
                                        <div>{{ $message }}</div>
                                    </span>
                                @enderror
                                <label for="floatingInput">Agent suivi</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="date" name="date_suivi"
                                    value="{{ $formation?->date_suivi?->format('Y-m-d') ?? old('date_suivi') }}"
                                    class="datepicker form-control form-control-sm @error('date_suivi') is-invalid @enderror"
                                    id="date_suivi" placeholder="jj/mm/aaaa">
                                @error('date_suivi')
                                    <span class="invalid-feedback" role="alert">
                                        <div>{{ $message }}</div>
                                    </span>
                                @enderror
                                <label for="floatingInput">Date suivi</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm"
                                data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary btn-sm">Valider</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Membres du jury --}}
        <div class="modal fade" id="EditMembresJuryModal{{ $formation->id }}" tabindex="-1" role="dialog"
            aria-labelledby="EditMembresJuryModalLabel{{ $formation->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" action="{{ route('formations.updateMembresJury') }}"
                        enctype="multipart/form-data" class="row g-3">
                        @csrf
                        @method('patch')
                        {{-- <div class="modal-header" id="EditMembresJuryModalLabel{{ $formation->id }}">
                            <h5 class="modal-title text-center">Evaluation formation <br>
                                {{ $formation?->module?->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div> --}}

                        <div class="card-header text-center bg-gradient-default">
                            <h1 class="h4 text-black mb-0">Evaluation</h1>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" value="{{ $formation->id }}">

                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                                    <div class="mb-3">
                                        <label>N° convention<span class="text-danger mx-1">*</span></label>
                                        <input type="text" name="numero_convention"
                                            value="{{ $formation?->numero_convention ?? old('numero_convention') }}"
                                            class="form-control form-control-sm @error('numero_convention') is-invalid @enderror"
                                            id="numero_convention" placeholder="n° convention">
                                        @error('numero_convention')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                                    <div class="mb-3">
                                        <label>Date convention<span class="text-danger mx-1">*</span></label>
                                        <input type="date" name="date_convention"
                                            value="{{ $formation?->date_convention?->format('Y-m-d') ?? old('date_convention') }}"
                                            class="datepicker form-control form-control-sm @error('date_convention') is-invalid @enderror"
                                            id="date_convention" placeholder="jj/mm/aaaa">
                                        @error('date_convention')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                                    <div class="mb-3">
                                        <label>Date évaluation<span class="text-danger mx-1">*</span></label>
                                        <input type="date" name="date_pv"
                                            value="{{ $formation?->date_pv?->format('Y-m-d') ?? old('date_pv') }}"
                                            class="datepicker form-control form-control-sm @error('date_pv') is-invalid @enderror"
                                            id="date_pv" placeholder="jj/mm/aaaa">
                                        @error('date_pv')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                                    <div class="mb-3">
                                        <label>Montant indemnité de membre <span class="text-danger mx-1">*</span></label>
                                        <input type="number" name="frais_evaluateur" min="0" step="0.001"
                                            value="{{ $formation?->frais_evaluateur ?? old('frais_evaluateur') }}"
                                            class="form-control form-control-sm @error('frais_evaluateur') is-invalid @enderror"
                                            id="frais_evaluateur" placeholder="Montant indemnité de membre ">
                                        @error('frais_evaluateur')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                                    <div class="mb-3">
                                        <label for="evaluateur" class="form-label">Evaluateur<span
                                                class="text-danger mx-1">*</span></label>
                                        <select name="evaluateur"
                                            class="form-select @error('evaluateur') is-invalid @enderror"
                                            aria-label="Select" id="select-field"
                                            data-placeholder="Choisir evaluateur">
                                            <option value="{{ $formation?->evaluateur?->id }}">
                                                @if (!empty($formation?->evaluateur?->name))
                                                    {{ $formation?->evaluateur?->name . ', ' . $formation?->evaluateur?->fonction }}
                                                @endif
                                            </option>
                                            @foreach ($evaluateurs as $evaluateur)
                                                <option value="{{ $evaluateur->id }}">
                                                    {{ $evaluateur?->name . ', ' . $evaluateur?->fonction ?? old('evaluateur') }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('evaluateur')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- <div class="row">
                                <div class="col-12 col-md-9 col-lg-9 mb-3">
                                    <label>Evaluateur ONFP<span class="text-danger mx-1">*</span></label>
                                    <input type="text" name="nom_evaluateur_onfp"
                                        value="{{ $formation?->evaluateur_onfp ?? old('nom_evaluateur_onfp') }}"
                                        class="form-control form-control-sm @error('nom_evaluateur_onfp') is-invalid @enderror"
                                        id="nom_evaluateur_onfp" placeholder="Nom évaluateur onfp">
                                    @error('nom_evaluateur_onfp')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-3 col-lg-3 mb-3">
                                    <label>Initiale<span class="text-danger mx-1">*</span></label>
                                    <input type="text" name="initiale_evaluateur_onfp"
                                        value="{{ $formation?->initiale_evaluateur_onfp ?? old('initiale_evaluateur_onfp') }}"
                                        class="form-control form-control-sm @error('initiale_evaluateur_onfp') is-invalid @enderror"
                                        id="initiale_evaluateur_onfp" placeholder="Initiale évaluateur onfp">
                                    @error('initiale_evaluateur_onfp')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                </div>
                            </div> --}}


                                <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                                    <div class="mb-3">
                                        <label for="evaluateur" class="form-label">Evaluateur ONFP</label>
                                        <select name="onfpevaluateur"
                                            class="form-select @error('onfpevaluateur') is-invalid @enderror"
                                            aria-label="Select" id="select-field-onfp" data-placeholder="Choisir">
                                            <option value="{{ $formation->onfpevaluateur?->id }}">
                                                @if (!empty($formation?->onfpevaluateur?->name))
                                                    {{ $formation?->onfpevaluateur?->name . ', ' . $formation?->onfpevaluateur?->fonction }}
                                                @endif
                                            </option>
                                            <option value="Aucun">Aucun</option>
                                            @foreach ($onfpevaluateurs as $onfpevaluateur)
                                                <option value="{{ $onfpevaluateur->id }}">
                                                    {{ $onfpevaluateur?->name . ', ' . $onfpevaluateur?->fonction ?? old('onfpevaluateur') }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('onfpevaluateur')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                                    <div class="mb-3">
                                        <label>Titre (convention)<span class="text-danger mx-1">*</span></label>
                                        {{-- <input type="text" name="type_certificat" min="0" step="0.001"
                                    value="{{ $formation?->type_certificat ?? old('type_certificat') }}"
                                    class="form-control form-control-sm @error('type_certificat') is-invalid @enderror"
                                    id="type_certificat" placeholder="Attestation ou Titre "> --}}

                                        <select name="titre"
                                            class="form-select  @error('titre') is-invalid @enderror"
                                            aria-label="Select" id="select-field-titre"
                                            data-placeholder="Choisir titre">
                                            <option>
                                                {{ $formation?->titre ?? ($formation?->referentiel?->titre ?? old('titre')) }}
                                            </option>
                                            <option value="null">
                                                Aucun
                                            </option>
                                            @foreach ($referentiels as $referentiel)
                                                <option value="{{ $referentiel?->titre }}">
                                                    {{ $referentiel?->titre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('titre')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                                    <div class="mb-3">
                                        <label>Type certification<span class="text-danger mx-1">*</span></label>
                                        <select name="type_certification"
                                            class="form-select  @error('type_certification') is-invalid @enderror"
                                            aria-label="Select" id="select-field-type_certification_update"
                                            data-placeholder="Choisir type certification">
                                            <option value="{{ $formation?->type_certification }}">
                                                {{ $formation?->type_certification ?? old('type_certification') }}
                                            </option>
                                            <option value="{{ old('c') }}">
                                                {{ old('type_certification') }}
                                            </option>
                                            <option value="Titre">
                                                Titre
                                            </option>
                                            <option value="Attestation">
                                                Attestation
                                            </option>
                                        </select>
                                        @error('type_certification')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="mb-3">

                                <label for="membres_jury">Autre membres du jury</label>

                                <textarea name="membres_jury" id="membres_jury" cols="30" rows="3"
                                    class="form-control form-control-sm @error('membres_jury') is-invalid @enderror"
                                    placeholder="Membre 1; Membre 2; Membre 3 " autofocus>{{ $formation->membres_jury ?? old('membres_jury') }}</textarea>

                                {{-- <input type="text" name="membres_jury"
                                    value="{{ $formation?->membres_jury ?? old('membres_jury') }}"
                                    class="form-control form-control-sm @error('membres_jury') is-invalid @enderror"
                                    id="membres_jury" placeholder="Ajouter membres du jury" autofocus> --}}
                                @error('membres_jury')
                                    <span class="invalid-feedback" role="alert">
                                        <div>{{ $message }}</div>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">

                                <label for="recommandations">Recommandations</label>

                                <textarea name="recommandations" id="recommandations" cols="30" rows="3s"
                                    class="form-control form-control-sm @error('recommandations') is-invalid @enderror"
                                    placeholder="Recommandations" autofocus>{{ $formation?->recommandations ?? old('recommandations') }}</textarea>
                                @error('recommandations')
                                    <span class="invalid-feedback" role="alert">
                                        <div>{{ $message }}</div>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm"
                                data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary btn-sm">
                                Valider</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Jours formation --}}
        <div class="modal fade" id="ajouterJours{{ $formation->id }}" tabindex="-1" role="dialog"
            aria-labelledby="ajouterJoursLabel{{ $formation->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" action="{{ route('formations.ajouterJours') }}"
                        enctype="multipart/form-data" class="row g-3">
                        @csrf
                        @method('patch')
                        <div class="card-header text-center bg-gradient-default">
                            <h1 class="h4 text-black mb-0">AJOUTER JOUR</h1>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="idformation" value="{{ $formation->id }}">
                            <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                <div class="mb-3">
                                    <label>Nombre de jours<span class="text-danger mx-1">*</span></label>
                                    <input type="number" min="1" max="1" name="jour"
                                        value="{{ '1' ?? old('jour') }}"
                                        class="form-control form-control-sm @error('jour') is-invalid @enderror"
                                        id="jour" placeholder="Nombre de jour">
                                    @error('jour')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                                <div class="mb-3">
                                    <label>Date<span class="text-danger mx-1">*</span></label>
                                    <input type="date" name="date" value="{{ old('date') }}"
                                        class="datepicker form-control form-control-sm @error('date') is-invalid @enderror"
                                        id="date" placeholder="jj/mm/aaaa">
                                    @error('date')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                </div>
                            </div> --}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm"
                                data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary btn-sm">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @foreach ($emargements as $emargement)
            <div class="modal fade" id="EditEmargementModal{{ $emargement->id }}" tabindex="-1" role="dialog"
                aria-labelledby="EditEmargementModalLabel{{ $emargement->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        {{-- <form method="POST" action="{{ route('updateRegion') }}">
                    @csrf --}}
                        <form method="post" action="{{ route('emargements.update', $emargement->id) }}"
                            enctype="multipart/form-data" class="row g-3">
                            @csrf
                            @method('patch')
                            <div class="card-header text-center bg-gradient-default">
                                <h1 class="h4 text-black mb-0">Modification {{ $emargement?->jour }}</h1>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="idformation" value="{{ $formation->id }}">
                                <div class="row">
                                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                                        <div class="mb-3">
                                            <label>Jour<span class="text-danger mx-1">*</span></label>
                                            <input type="text" name="jour"
                                                value="{{ $emargement?->jour ?? old('jour') }}"
                                                class="form-control form-control-sm @error('jour') is-invalid @enderror"
                                                id="jour" placeholder="Nombre de jour">
                                            @error('jour')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                                        <div class="mb-3">
                                            <label>Date<span class="text-danger mx-1">*</span></label>
                                            <input type="date" name="date"
                                                value="{{ $emargement?->date?->format('Y-m-d') ?? old('date') }}"
                                                class="datepicker form-control form-control-sm @error('date') is-invalid @enderror"
                                                id="date" placeholder="jj/mm/aaaa">
                                            @error('date')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <div class="mb-3">
                                            <label for="feuille" class="form-label">Joindre scan feuille de prsénce
                                                {{ $emargement?->jour }}</label>
                                            <input type="file" name="feuille" id="feuille"
                                                class="form-control @error('feuille') is-invalid @enderror btn btn-outline-secondary btn-sm">
                                            @error('feuille')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <div class="mb-3">
                                            <label>Observations</label>
                                            <textarea name="observations" id="observations" cols="30" rows="3s"
                                                class="form-control form-control-sm @error('observations') is-invalid @enderror" placeholder="observations"
                                                autofocus>{{ $emargement?->observations ?? old('observations') }}</textarea>
                                            @error('observations')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm"
                                    data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    Modifier</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Modal -->
        @foreach ($formation->individuelles as $individuelle)
            <div class="modal fade" id="declinaisonModal{{ $individuelle->id }}" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Détails</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Affichage du motif de rejet avec retour à la ligne -->
                            <p style="white-space: pre-line;">
                                {{ str_replace(';', ";\n", $individuelle?->motif_declinaison) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </section>
@endsection
{{-- @push('scripts')
    <script>
        new DataTable('#table-operateurModules', {
            layout: {
                topStart: {
                    buttons: ['excel', 'pdf', 'print'],
                }
            },
            "order": [
                [0, 'asc']
            ],
            language: {
                "sProcessing": "Traitement en cours...",
                "sSearch": "Rechercher&nbsp;:",
                "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
                "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
                "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                "sInfoPostFix": "",
                "sLoadingRecords": "Chargement en cours...",
                "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
                "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
                "oPaginate": {
                    "sFirst": "Premier",
                    "sPrevious": "Pr&eacute;c&eacute;dent",
                    "sNext": "Suivant",
                    "sLast": "Dernier"
                },
                "oAria": {
                    "sSortAscending": ": activer pour trier la colonne par ordre croissant",
                    "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                },
                "select": {
                    "rows": {
                        _: "%d lignes sÃ©lÃ©ctionnÃ©es",
                        0: "Aucune ligne sÃ©lÃ©ctionnÃ©e",
                        1: "1 ligne sÃ©lÃ©ctionnÃ©e"
                    }
                }
            }
        });
    </script>
@endpush --}}
