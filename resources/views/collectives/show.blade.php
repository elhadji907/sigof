@extends('layout.user-layout')
@section('title', 'ONFP | DETAILS DEMANDE COLLECTIVE')
@section('space-work')

    <section
        class="section profile min-vh-0 d-flex flex-column align-items-center justify-content-center py-0 section profile">
        <div class="container-fluid">
            <div class="pagetitle">
                {{-- <h1>Data Tables</h1> --}}
                <nav>
                    <ol class="breadcrumb">
                        @can('user-view')
                            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Accueil</a></li>
                        @endcan
                        <li class="breadcrumb-item">Tables</li>
                        <li class="breadcrumb-item active">Collectives</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->
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
                                @hasrole('super-admin|admin|DIOF|Ingenieur|DG')
                                    @can('collective-view')
                                        <li class="nav-item">
                                            <span class="nav-link"><a href="{{ route('collectives.index') }}"
                                                    class="btn btn-secondary btn-sm" title="retour"><i
                                                        class="bi bi-arrow-counterclockwise"></i></a>
                                            </span>
                                        </li>
                                    @endcan
                                @endcan
                                @role('Demandeur')
                                    @can('demandeur-view')
                                        <li class="nav-item">
                                            <span class="nav-link"><a href="{{ route('demandesCollective') }}"
                                                    class="btn btn-info btn-sm" title="retour"><i
                                                        class="bi bi-arrow-counterclockwise"></i></a>
                                            </span>
                                        </li>
                                    @endcan
                                    @endif
                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-overview">Info
                                            demande</button>
                                    </li>

                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab"
                                            data-bs-target="#responsable-overview">Responsable</button>
                                    </li>

                                    <li class="nav-item">
                                        <button class="nav-link active" data-bs-toggle="tab"
                                            data-bs-target="#membres-overview">Membres
                                        </button>
                                    </li>

                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#modules-overview">Modules
                                        </button>
                                    </li>


                                    @php
                                        // Filtrer uniquement les fichiers qui ont une valeur non vide
                                        $validFiles = $collective?->user?->files->filter(
                                            fn($file) => !empty($file?->file),
                                        );
                                    @endphp

                                    @can('user-delete')
                                        <li class="nav-item">
                                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#files">Fichiers</button>
                                        </li>
                                    @endcan

                                    @can('user-view')
                                        <li class="nav-item">
                                            <button class="nav-link" data-bs-toggle="tab"
                                                data-bs-target="#foration-overview">Formations</button>
                                        </li>
                                    @endcan

                                    {{--  <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#autres-demandes-overview">Demandes totales
                                        <span class="badge bg-success badge-number">{{ $collectives->count() }}</span>
                                    </button>
                                </li> --}}

                                </ul>
                                <div class="d-flex justify-content-between align-items-center">
                                </div>
                                {{-- Détail opérateur --}}
                                <div class="tab-content pt-0">
                                    <div class="tab-pane fade profile-overview pt-3" id="profile-overview">
                                        <form method="post" action="#" enctype="multipart/form-data" class="row g-3">
                                            @csrf
                                            @method('PUT')
                                            <h5 class="card-title">Détails: <span
                                                    class="{{ $collective?->statut_demande }} text-white">
                                                    {{ $collective?->statut_demande }}</span></h5>
                                            <div class="col-12 col-md-9 col-lg-9 mb-0">
                                                <div class="label">Nom structure</div>
                                                <div>{{ $collective?->name }}</div>
                                            </div>
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Sigle</div>
                                                <div>{{ $collective?->sigle }}</div>
                                            </div>
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Numéro dossier</div>
                                                <div>{{ $collective?->numero }}</div>
                                            </div>
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Statut juridique</div>
                                                <div>{{ $collective?->statut_juridique }}</div>
                                            </div>
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Région</div>
                                                <div>{{ $collective?->departement->region->nom }}</div>
                                            </div>
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Département</div>
                                                <div>{{ $collective->departement->nom }}
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Adresse exacte</div>
                                                <div>{{ $collective?->adresse }}
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Téléphone</div>
                                                <div><a
                                                        href="tel:+221{{ $collective?->telephone }}">{{ $collective?->telephone }}</a>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Fixe</div>
                                                <div><a href="tel:+221{{ $collective?->fixe }}">{{ $collective?->fixe }}</a>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Email</div>
                                                <div><a href="mailto:{{ $collective?->email }}">{{ $collective?->email }}</a>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-12 mb-0">
                                                <div class="label">Projet professionnel</div>
                                                <div>
                                                    {!! '- ' .
                                                        implode('- ', array_map(fn($line) => nl2br(e($line)), explode("\n", ucfirst($collective?->projetprofessionnel)))) !!}
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                                {{-- Détail responsable --}}
                                <div class="tab-content pt-2">
                                    <div class="tab-pane fade profile-overview pt-3" id="responsable-overview">
                                        <form method="post" action="#" enctype="multipart/form-data" class="row g-3">
                                            @csrf
                                            @method('PUT')
                                            <h5 class="card-title">Responsable</h5>
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Civilité</div>
                                                <div>{{ $collective?->civilite_responsable }}</div>
                                            </div>
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Prénom</div>
                                                <div>{{ $collective->prenom_responsable }}</div>
                                            </div>
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Nom</div>
                                                <div>{{ $collective->nom_responsable }}</div>
                                            </div>
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Email</div>
                                                <div><a
                                                        href="mailto:{{ $collective->email_responsable }}">{{ $collective->email_responsable }}</a>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Téléphone</div>
                                                <div><a
                                                        href="tel:+221{{ $collective->telephone_responsable }}">{{ $collective->telephone_responsable }}</a>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-3 col-lg-3 mb-0">
                                                <div class="label">Fonction responsable</div>
                                                <div>{{ $collective->fonction_responsable }}</div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="tab-content pt-0">
                                    <div class="tab-pane fade show active profile-overview" id="membres-overview">
                                        <div class="col-12 col-md-12 col-lg-12 mb-0">
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <span class="card-title d-flex align-items-baseline">N° :&nbsp;
                                                    <span class="badge bg-info text-white">
                                                        {{ $collective?->numero }}</span>
                                                </span>
                                                <span class="card-title d-flex align-items-baseline">Statut :&nbsp;
                                                    <span class="{{ $collective?->statut_demande }} text-white">
                                                        {{ $collective?->statut_demande }}</span>
                                                    @can('user-view')
                                                        <div class="filter">
                                                            <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                                                    class="bi bi-three-dots"></i></a>
                                                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                                <form
                                                                    action="{{ route('validation-collectives.update', $collective?->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <button
                                                                        class="show_confirm_valider btn btn-sm mx-1">Accepter</button>
                                                                </form>
                                                                <button class="btn btn-sm mx-1" data-bs-toggle="modal"
                                                                    data-bs-target="#RejetDemandeModal">Rejeter
                                                                </button>
                                                            </ul>
                                                        </div>
                                                    @endcan
                                                </span>

                                                @can('diof')
                                                    @if ($ingenieur)
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h5 class="card-title">
                                                                {{ $ingenieur->name }}
                                                                @can('ingenieur-check')
                                                                    <a class="btn btn-info btn-sm" title="Voir ingénieur"
                                                                        href="{{ route('ingenieurs.show', $collective->id) }}">
                                                                        <i class="bi bi-eye"></i>
                                                                    </a>&nbsp;
                                                                    <a href="{{ route('addcollectiveingenieurs', $collective->id) }}"
                                                                        class="btn btn-primary float-end btn-sm">Changer ingénieur</a>
                                                                @endcan
                                                            </h5>
                                                        </div>
                                                    @else
                                                        <div class="pb-2">
                                                            <a href="{{ route('addcollectiveingenieurs', $collective->id) }}"
                                                                class="btn btn-primary float-end btn-sm">Imputer ingénieur</a>
                                                        </div>
                                                    @endif
                                                @endcan
                                            </div>

                                            {{-- @can('demandeur') --}}
                                            <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                                <div class="card">
                                                    <div class="card-body pb-0">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h5 class="card-title">Modules de formations</h5>
                                                            <button type="button"
                                                                class="btn btn-success btn-sm float-end btn-rounded"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#AddcollectiveModuleModal">Ajouter
                                                                formation</button>
                                                        </div>
                                                        <h5 class="card-title">Modules <span>| Formation</span></h5>
                                                        @if ($collective?->collectivemodules->isNotEmpty())
                                                            <table class="table table-borderless">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">Formation</th>
                                                                        <th scope="col" class="text-center">Effectifs</th>
                                                                        <th scope="col" class="text-center">Statut</th>
                                                                        <th scope="col" class="float-end">Membres
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($collective?->collectivemodules as $module_collective)
                                                                        <tr>
                                                                            <td class="text-primary">
                                                                                {{ $module_collective->module }}</td>
                                                                            <td class="text-center">
                                                                                <span>
                                                                                    {{ is_countable($module_collective->listecollectives) && count($module_collective->listecollectives) > 0 ? count($module_collective->listecollectives) : '' }}
                                                                                </span>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <span
                                                                                    class="{{ $module_collective?->statut }}">{{ $module_collective?->statut }}</span>
                                                                            </td>
                                                                            <td class="float-end">
                                                                                <span class="d-flex align-items-baseline"><a
                                                                                        href="{{ route('collectivemodules.show', $module_collective->id) }}"
                                                                                        class="btn btn-info btn-sm text-white"
                                                                                        title="voir détails">ajouter</a>
                                                                                    <div class="filter">
                                                                                        <a class="icon" href="#"
                                                                                            data-bs-toggle="dropdown"><i
                                                                                                class="bi bi-three-dots"></i></a>
                                                                                        <ul
                                                                                            class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                                                            @can('validate-module-collective')
                                                                                                <form
                                                                                                    action="{{ route('validerModuleCollective') }}"
                                                                                                    method="post">
                                                                                                    @csrf
                                                                                                    @method('PUT')
                                                                                                    <input type="hidden"
                                                                                                        name="id"
                                                                                                        value="{{ $module_collective->id }}">
                                                                                                    <button
                                                                                                        class="show_confirm_valider btn btn-sm mx-1">Accepter</button>
                                                                                                </form>
                                                                                                <button class="btn btn-sm mx-1"
                                                                                                    data-bs-toggle="modal"
                                                                                                    data-bs-target="#RejetModuleDemandeModal{{ $module_collective->id }}">Rejeter
                                                                                                </button>
                                                                                                <br>
                                                                                            @endcan
                                                                                            <button class="btn btn-sm mx-1"
                                                                                                data-bs-toggle="modal"
                                                                                                data-bs-target="#EditRegionModal{{ $module_collective->id }}">Modifier
                                                                                            </button>
                                                                                            <form
                                                                                                action="{{ route('collectivemodules.destroy', $module_collective->id) }}"
                                                                                                method="post">
                                                                                                @csrf
                                                                                                @method('DELETE')
                                                                                                <button type="submit"
                                                                                                    class="dropdown-item show_confirm"
                                                                                                    title="Supprimer">Supprimer</button>
                                                                                            </form>
                                                                                        </ul>
                                                                                    </div>
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        @else
                                                            <div class="alert alert-warning">Aucune formation pour le momement
                                                                !
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- @endcan --}}

                                            <div class="card">
                                                <div class="card-body pb-0">
                                                    <h5 class="card-title">Liste des membres</h5>
                                                    @if ($listecollective)
                                                        <div class="row g-3">
                                                            <table
                                                                class="table datatables align-middle justify-content-center table-borderless"
                                                                id="table-collectiveMembres">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col" width="12%"class="text-center">
                                                                            CIN</th>
                                                                        <th scope="col">Civilité</th>
                                                                        <th scope="col" width="15%">Prénom & NOM</th>
                                                                        {{-- <th scope="col">Nom</th> --}}
                                                                        <th scope="col" width="10%">Date naissance</th>
                                                                        <th scope="col" width="10%">Lieu naissance</th>
                                                                        <th scope="col" width="10%">Niveau étude</th>
                                                                        <th scope="col">Module</th>
                                                                        <th scope="col">Statut</th>
                                                                        <th class="col"><i class="bi bi-gear"></i></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $i = 1; ?>
                                                                    @foreach ($collective->listecollectives as $listecollective)
                                                                        <tr>
                                                                            <td>{{ $listecollective?->cin }}</td>
                                                                            <td>{{ $listecollective?->civilite }}</td>
                                                                            <td>{{ $listecollective?->prenom . ' ' . $listecollective?->nom }}
                                                                            </td>
                                                                            {{-- <td>{{ $listecollective?->nom }}</td> --}}
                                                                            <td>{{ $listecollective?->date_naissance->format('d/m/Y') }}
                                                                            </td>
                                                                            <td>{{ $listecollective?->lieu_naissance }}</td>
                                                                            <td>{{ $listecollective?->niveau_etude }}</td>
                                                                            <td>{{ $listecollective?->collectivemodule?->module }}
                                                                            </td>
                                                                            <td>
                                                                                <span
                                                                                    class="{{ $listecollective?->statut }}">{{ $listecollective?->statut }}</span>
                                                                            </td>
                                                                            <td>
                                                                                <span class="d-flex align-items-baseline">
                                                                                    <a href="{{ route('listecollectives.show', $listecollective?->id) }}"
                                                                                        class="btn btn-primary btn-sm"
                                                                                        title="voir détails"
                                                                                        target="_blank"><i
                                                                                            class="bi bi-eye"></i></a>
                                                                                    <div class="filter">
                                                                                        <a class="icon" href="#"
                                                                                            data-bs-toggle="dropdown"><i
                                                                                                class="bi bi-three-dots"></i></a>
                                                                                        <ul
                                                                                            class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                                                            <li><a class="dropdown-item btn btn-sm"
                                                                                                    href="{{ route('listecollectives.edit', $listecollective->id) }}"
                                                                                                    class="mx-1"
                                                                                                    title="Modifier"><i
                                                                                                        class="bi bi-pencil"></i>Modifier</a>
                                                                                            </li>
                                                                                            <form
                                                                                                action="{{ route('listecollectives.destroy', $listecollective->id) }}"
                                                                                                method="post">
                                                                                                @csrf
                                                                                                @method('DELETE')
                                                                                                <button type="submit"
                                                                                                    class="dropdown-item show_confirm"
                                                                                                    title="Supprimer"><i
                                                                                                        class="bi bi-trash"></i>Supprimer</button>
                                                                                            </form>
                                                                                        </ul>
                                                                                    </div>
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @else
                                                        <div class="alert alert-info">Aucun membre pour l'instant !
                                                        </div>
                                                    @endif
                                                    {{-- </form> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Détail modules --}}
                                <div class="tab-content">
                                    <div class="tab-pane fade modules-overview pt-1" id="modules-overview">
                                        <h5 class="card-title">Liste des modules</h5>
                                        @if (!empty($listemodulescollective))
                                            <table class="table datatables" id="table-modules">
                                                <thead>
                                                    <tr>
                                                        <th>N°</th>
                                                        <th>Module</th>
                                                        <th>Demandeurs</th>
                                                        <th>Statut</th>
                                                        <th class="float-end"><i class="bi bi-gear"></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1; ?>
                                                    @foreach ($collective?->collectivemodules as $collectivemodule)
                                                        <tr>
                                                            <td>{{ $i++ }}</td>
                                                            <td>{{ $collectivemodule?->module }}</td>
                                                            <td>
                                                                {{-- @foreach ($collectivemodule->listecollectives as $listecollective)
                                                                @if ($loop->last)
                                                                    <a href="#"><span
                                                                            class="badge bg-info">{{ $loop->count }}</span></a>
                                                                @endif
                                                            @endforeach --}}
                                                                <span
                                                                    class="badge bg-info">{{ count($collectivemodule->listecollectives) }}</span>
                                                            </td>
                                                            <td>
                                                                <span class="{{ $collectivemodule?->statut }}">
                                                                    {{ $collectivemodule?->statut }}
                                                                </span>
                                                            </td>
                                                            <td>

                                                                <span class="d-flex align-items-baseline float-end"><a
                                                                        href="{{ route('collectivemodules.show', $collectivemodule->id) }}"
                                                                        class="btn btn-primary btn-sm" title="voir détails"><i
                                                                            class="bi bi-eye"></i></a>
                                                                    <div class="filter">
                                                                        <a class="icon" href="#"
                                                                            data-bs-toggle="dropdown"><i
                                                                                class="bi bi-three-dots"></i></a>
                                                                        <ul
                                                                            class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                                            @can('validate-module-collective')
                                                                                <form
                                                                                    action="{{ route('validerModuleCollective') }}"
                                                                                    method="post">
                                                                                    @csrf
                                                                                    @method('PUT')
                                                                                    <input type="hidden" name="id"
                                                                                        value="{{ $collectivemodule->id }}">
                                                                                    <button
                                                                                        class="show_confirm_valider btn btn-sm mx-1">Accepter</button>
                                                                                </form>
                                                                                <button class="btn btn-sm mx-1"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#RejetModuleDemandeModal{{ $collectivemodule->id }}">Rejeter
                                                                                </button>
                                                                                <br>
                                                                            @endcan
                                                                            <button class="btn btn-sm mx-1"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#EditRegionModal{{ $collectivemodule->id }}">Modifier
                                                                            </button>
                                                                            <form
                                                                                action="{{ route('collectivemodules.destroy', $collectivemodule->id) }}"
                                                                                method="post">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit"
                                                                                    class="dropdown-item show_confirm"
                                                                                    title="Supprimer">Supprimer</button>
                                                                            </form>
                                                                        </ul>
                                                                    </div>
                                                                </span>
                                                                {{-- <span class="d-flex align-items-baseline float-end"><a
                                                                    href="{{ route('collectivemodules.show', $collectivemodule->id) }}"
                                                                    class="btn btn-primary btn-sm" title="voir détails"><i
                                                                        class="bi bi-eye"></i></a>
                                                                <div class="filter">
                                                                    <a class="icon" href="#"
                                                                        data-bs-toggle="dropdown"><i
                                                                            class="bi bi-three-dots"></i></a>
                                                                    <ul
                                                                        class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                                        <button type="button"
                                                                            class="dropdown-item btn btn-sm mx-1"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#EditRegionModal{{ $collectivemodule->id }}">
                                                                            <i class="bi bi-pencil" title="Modifier"></i>
                                                                            Modifier
                                                                        </button>
                                                                        <li>
                                                                            <form
                                                                                action="{{ route('collectivemodules.destroy', $collectivemodule->id) }}"
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
                                                            </span> --}}
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        @else
                                            <div class="alert alert-info">Aucun module pour l'instat
                                            </div>
                                        @endif

                                        <!-- End Table with stripped rows -->
                                    </div>
                                </div>

                                <div class="tab-content pt-2">
                                    <div class="tab-pane fade files" id="files">
                                        <div class="row mb-3">
                                            <h5 class="card-title col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                                FICHIERS JOINTS</h5>
                                            @if ($validFiles->isNotEmpty())
                                                <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-8">
                                                    <table class="table table-bordered table-hover datatables"
                                                        id="table-iles">
                                                        <thead>
                                                            <tr>
                                                                <th width="5%" class="text-center">N°</th>
                                                                <th>Légende</th>
                                                                <th width="10%" class="text-center">File</th>
                                                                @can('user-show-file')
                                                                    <th width="5%" class="text-center"><i
                                                                            class="bi bi-gear"></i></th>
                                                                @endcan
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php $i = 1; @endphp
                                                            @foreach ($validFiles as $file)
                                                                <tr>
                                                                    <td class="text-center">{{ $i++ }}</td>
                                                                    <td>{{ $file->legende }}</td>
                                                                    <td class="text-center">
                                                                        <a class="btn btn-default btn-sm"
                                                                            title="Télécharger le fichier joint"
                                                                            target="_blank"
                                                                            href="{{ asset($file->getFichier()) }}">
                                                                            <i class="bi bi-download"></i>
                                                                        </a>
                                                                    </td>
                                                                    @can('user-show-file')
                                                                        <td class="text-center">
                                                                            <form action="{{ route('fileDestroy') }}"
                                                                                method="post">
                                                                                @csrf
                                                                                @method('put')
                                                                                <input type="hidden" name="idFile"
                                                                                    value="{{ $file->id }}">
                                                                                <button type="submit"
                                                                                    style="background:none;border:0px;"
                                                                                    class="show_confirm text-danger"
                                                                                    title="Retirer">
                                                                                    <i class="bi bi-trash"></i>
                                                                                </button>
                                                                            </form>
                                                                        </td>
                                                                    @endcan
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <div class="alert alert-info">
                                                    <p class="text-muted">Aucun fichier joint.</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Détail Formations --}}
                                <div class="tab-content">
                                    <div class="tab-pane fade profile-overview pt-1" id="foration-overview">
                                        <h5 class="card-title">Formations </h5>
                                        @if ($collective)
                                            <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                                <table class="table table-bordered table-hover datatables" id="table-iles">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%" class="text-center">N°</th>
                                                            <th width="15%" class="text-center">Date dépôt</th>
                                                            <th>Modules</th>
                                                            <th width="10%" class="text-center">Statut</th>
                                                            @can('user-show')
                                                                <th width="5%" class="text-center"><i class="bi bi-gear"></i>
                                                                </th>
                                                            @endcan
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $i = 1; @endphp
                                                        @foreach ($collective->collectivemodules as $collectivemodule)
                                                            <tr>
                                                                <td class="text-center">{{ $i++ }}</td>
                                                                <td class="text-center">
                                                                    {{ $collective->date_depot ? \Carbon\Carbon::parse($collective->date_depot)->diffForHumans() : 'Aucun' }}
                                                                </td>
                                                                <td>{{ $collectivemodule->module }}</td>
                                                                <td class="text-center">
                                                                    <span class="{{ $collectivemodule?->statut }}">
                                                                        {{ $collectivemodule?->statut }}
                                                                    </span>
                                                                </td>
                                                                @can('user-show')
                                                                    <td class="text-center">
                                                                        <a href="{{ route('collectivemodules.show', $collectivemodule?->id) }}"
                                                                            class="btn btn-primary btn-sm" target="_blank"
                                                                            title="voir détails"><i class="bi bi-eye"></i></a>
                                                                    </td>
                                                                @endcan
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="alert alert-info">
                                                <p class="text-muted">Aucune formation pour l'instant !</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                {{-- Détail Formations --}}
                                {{-- <div class="tab-content">
                                <div class="tab-pane fade profile-overview pt-1" id="autres-demandes-overview">

                                    <h5 class="card-title">Mes demandes collectives</h5>
                                    <table class="table datatables align-middle" id="table-collectives">
                                        <thead>
                                            <tr>
                                                <th>N° DEM.</th>
                                                <th>Structure</th>
                                                <th>Sigle</th>
                                                <th>Téléphone</th>
                                                <th>E-mail</th>
                                                <th>Localité</th>
                                                <th>Statut</th>
                                                <th class="text-center">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($collectives as $collective)
                                                @isset($collective?->numero)
                                                    <tr>
                                                        <td>{{ $collective?->numero }}
                                                        </td>
                                                        <td>{{ $collective?->name }}</td>
                                                        <td>{{ $collective?->sigle }}</td>
                                                        <td>{{ $collective?->user?->telephone }}</td>
                                                        <td><a
                                                                href="mailto:{{ $collective?->user?->email }}">{{ $collective?->user?->email }}</a>
                                                        </td>
                                                        <td>{{ $collective->departement?->region?->nom }}</td>
                                                        <td>
                                                            <span
                                                                class="{{ $collective?->statut_demande }}">{{ $collective?->statut_demande }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="d-flex align-items-baseline"><a
                                                                    href="{{ route('collectives.show', $collective->id) }}"
                                                                    class="btn btn-primary btn-sm" title="voir détails"><i
                                                                        class="bi bi-eye"></i></a>
                                                                <div class="filter">
                                                                    <a class="icon" href="#"
                                                                        data-bs-toggle="dropdown"><i
                                                                            class="bi bi-three-dots"></i></a>
                                                                    <ul
                                                                        class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                                        <li><a class="dropdown-item btn btn-sm"
                                                                                href="{{ route('collectives.edit', $collective->id) }}"
                                                                                class="mx-1" title="Modifier"><i
                                                                                    class="bi bi-pencil"></i>Modifier</a>
                                                                        </li>
                                                                        <li>
                                                                            <form
                                                                                action="{{ route('collectives.destroy', $collective->id) }}"
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
                                                @endisset
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!-- End Table with stripped rows -->
                                </div>
                            </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            {{-- Ajouter module collective --}}
            <div class="modal fade" id="AddcollectiveModuleModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form method="post" action="{{ route('collectivemodules.store') }}" enctype="multipart/form-data"
                            class="row g-3">
                            @csrf
                            {{-- <div class="modal-header">
                            <h5 class="modal-title"><i class="bi bi-plus" title="Ajouter"></i> Ajouter un nouveau module
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div> --}}

                            <div class="card-header text-center bg-gradient-default">
                                <h1 class="h4 text-black mb-0">Ajouter un nouveau module</h1>
                            </div>
                            <div class="modal-body">
                                <div class="form-floating mb-3">
                                    <input type="hidden" name="collectiveid" value="{{ $collective->id }}">
                                    <input type="text" name="module_name" value="{{ old('module_name') }}"
                                        class="form-control form-control-sm @error('module_name') is-invalid @enderror"
                                        id="module_name" placeholder="Formation sollicitée" autofocus>
                                    <div id="countryList"></div>
                                    {{ csrf_field() }}
                                    @error('module_name')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                    <label for="floatingInput">Module</label>
                                </div>
                            </div>
                            <input type="hidden" name="collective" value="{{ $collective->id }}">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm"
                                    data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Add member --}}
            <div class="col-lg-12 col-md-12 d-flex flex-column align-items-center justify-content-center">
                <div class="modal fade" id="AddIndividuelleModal" tabindex="-1">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <form method="post" action="{{ route('listecollectives.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                {{-- <div class="modal-header">
                                <h5 class="modal-title"><i class="bi bi-plus" title="Ajouter"></i> Ajouter un membre</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div> --}}

                                <div class="card-header text-center bg-gradient-default">
                                    <h1 class="h4 text-black mb-0">Ajouter un membre</h1>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <input type="hidden" name="collective" value="{{ $collective->id }}">
                                        <div class="col-12 col-md-4 col-lg-4 mb-0">
                                            <label for="cin" class="form-label">CIN<span
                                                    class="text-danger mx-1">*</span></label>
                                            <input type="text" name="cin" value="{{ old('cin') }}"
                                                class="form-control form-control-sm @error('cin') is-invalid @enderror"
                                                id="cin" placeholder="CIN">
                                            @error('cin')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-4 col-lg-4 mb-0">
                                            <label for="civilite" class="form-label">Civilité<span
                                                    class="text-danger mx-1">*</span></label>
                                            <select name="civilite"
                                                class="form-select form-select-sm @error('civilite') is-invalid @enderror"
                                                aria-label="Select" id="select-field-civilite"
                                                data-placeholder="Choisir civilité">
                                                <option value="{{ old('civilite') }}">
                                                    {{ old('civilite') }}
                                                </option>
                                                <option value="Monsieur">
                                                    Monsieur
                                                </option>
                                                <option value="Madame">
                                                    Madame
                                                </option>
                                            </select>
                                            @error('civilite')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-md-4 col-lg-4 mb-0">
                                            <label for="firstname" class="form-label">Prénom<span
                                                    class="text-danger mx-1">*</span></label>
                                            <input type="text" name="firstname" value="{{ old('firstname') }}"
                                                class="form-control form-control-sm @error('firstname') is-invalid @enderror"
                                                id="firstname" placeholder="prénom">
                                            @error('firstname')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-4 col-lg-4 mb-0">
                                            <label for="name" class="form-label">Nom<span
                                                    class="text-danger mx-1">*</span></label>
                                            <input type="text" name="name" value="{{ old('name') }}"
                                                class="form-control form-control-sm @error('name') is-invalid @enderror"
                                                id="name" placeholder="nom">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-4 col-lg-4 mb-0">
                                            <label for="date_naissance" class="form-label">Date naissance<span
                                                    class="text-danger mx-1">*</span></label>
                                            <input type="date" name="date_naissance" value="{{ old('date_naissance') }}"
                                                class="form-control form-control-sm @error('date_naissance') is-invalid @enderror"
                                                id="datepicker date_naissance" placeholder="jj/mm-aaaa">
                                            @error('date_naissance')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-4 col-lg-4 mb-0">
                                            <label for="name" class="form-label">Lieu naissance<span
                                                    class="text-danger mx-1">*</span></label>
                                            <input name="lieu_naissance" type="text"
                                                class="form-control form-control-sm @error('lieu_naissance') is-invalid @enderror"
                                                id="lieu_naissance" value="{{ old('lieu_naissance') }}"
                                                autocomplete="lieu_naissance" placeholder="Lieu naissance">
                                            @error('lieu_naissance')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-4 col-lg-4 mb-0">
                                            <label for="module" class="form-label">Formation sollicitée<span
                                                    class="text-danger mx-1">*</span></label>
                                            <select name="module" class="form-select  @error('module') is-invalid @enderror"
                                                aria-label="Select" id="select-field-module-ind"
                                                data-placeholder="Choisir formation">
                                                <option value="{{ old('module') }}">
                                                    {{ old('module') }}
                                                </option>
                                                @foreach ($collectivemodules as $module)
                                                    <option value="{{ $module->id }}">
                                                        {{ $module->module }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('module')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-4 col-lg-4 mb-0">
                                            <label for="telephone" class="form-label">Téléphone</label>
                                            <input type="number" min="0" name="telephone"
                                                value="{{ old('telephone') }}"
                                                class="form-control form-control-sm @error('telephone') is-invalid @enderror"
                                                id="telephone" placeholder="7xxxxxxxx">
                                            @error('telephone')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-4 col-lg-4 mb-0">
                                            <label for="Niveau étude" class="form-label">Niveau étude</label>
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

                                        <div class="col-12 col-md-12 col-lg-12 mb-0">
                                            <label for="experience" class="form-label">Expériences</label>
                                            <textarea name="experience" id="experience" rows="1"
                                                class="form-control form-control-sm @error('experience') is-invalid @enderror"
                                                placeholder="Expériences ou stages">{{ old('experience') }}</textarea>
                                            @error('experience')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-12 col-lg-12 mb-0">
                                            <label for="autre_experience" class="form-label">Autres expériences</label>
                                            <textarea name="autre_experience" id="autre_experience" rows="1"
                                                class="form-control form-control-sm @error('autre_experience') is-invalid @enderror"
                                                placeholder="Autres expériences">{{ old('autre_experience') }}</textarea>
                                            @error('autre_experience')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-12 col-lg-12 mb-0">
                                            <label for="details" class="form-label">Commentaires</label>
                                            <textarea name="details" id="details" rows="1"
                                                class="form-control form-control-sm @error('details') is-invalid @enderror" placeholder="Autres expériences">{{ old('details') }}</textarea>
                                            @error('details')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
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

            @foreach ($collectivemodules as $collectivemodule)
                <div class="modal fade" id="EditRegionModal{{ $collectivemodule->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="EditRegionModalLabel{{ $collectivemodule->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            {{-- <form method="POST" action="{{ route('updateRegion') }}">
                            @csrf --}}
                            <form method="post" action="{{ route('collectivemodules.update', $collectivemodule->id) }}"
                                enctype="multipart/form-data" class="row g-3">
                                @csrf
                                @method('patch')
                                {{-- <div class="modal-header" id="EditRegionModalLabel{{ $collectivemodule->id }}">
                                <h5 class="modal-title"><i class="bi bi-pencil" title="Ajouter"></i> Modifier module</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div> --}}

                                <div class="card-header text-center bg-gradient-default">
                                    <h1 class="h4 text-black mb-0">Modifier module</h1>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id" value="{{ $collectivemodule->id }}">
                                    <input type="hidden" name="collective" value="{{ $collective->id }}">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="module_name"
                                            value="{{ $collectivemodule->module ?? old('module_name') }}"
                                            class="form-control form-control-sm @error('module_name') is-invalid @enderror"
                                            id="module_name" placeholder="Module" autofocus>
                                        @error('module_name')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                        <label for="floatingInput">Module</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm"
                                        data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Modifier</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="modal fade" id="RejetDemandeModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form method="post" action="{{ route('validation-collectives.destroy', $collective?->id) }}"
                            enctype="multipart/form-data" class="row">
                            @csrf
                            @method('DELETE')
                            {{-- <div class="modal-header">
                            <h5 class="modal-title"><i class="bi bi-plus" title="Ajouter"></i> Rejet demande</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div> --}}
                            <div class="card-header text-center bg-gradient-default">
                                <h1 class="h4 text-black mb-0">Rejeter demande</h1>
                            </div>
                            <div class="modal-body">
                                <label for="motif" class="form-label">Motifs du rejet</label>
                                <textarea name="motif" id="motif" rows="5"
                                    class="form-control form-control-sm @error('motif') is-invalid @enderror"
                                    placeholder="Enumérer les motifs du rejet">{{ old('motif') }}</textarea>
                                @error('motif')
                                    <span class="invalid-feedback" role="alert">
                                        <div>{{ $message }}</div>
                                    </span>
                                @enderror
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-printer"></i>
                                    Rejeter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @foreach ($collectivemodules as $collectivemodule)
                <div class="modal fade" id="RejetModuleDemandeModal{{ $collectivemodule->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" action="{{ route('rejeterModuleCollective') }}"
                                enctype="multipart/form-data" class="row">
                                @csrf
                                @method('PUT')
                                {{-- <div class="modal-header">
                                <h5 class="modal-title"><i class="bi bi-plus" title="Ajouter"></i> Rejet module</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div> --}}
                                <div class="card-header text-center bg-gradient-default">
                                    <h1 class="h4 text-black mb-0">Rejeter module</h1>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id" value="{{ $collectivemodule->id }}">
                                    <label for="motif" class="form-label">Motifs du rejet</label>
                                    <textarea name="motif" id="motif" rows="5"
                                        class="form-control form-control-sm @error('motif') is-invalid @enderror"
                                        placeholder="Enumérer les motifs du rejet">{{ old('motif') }}</textarea>
                                    @error('motif')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-printer"></i>
                                        Rejeter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </section>
    @endsection

    @push('scripts')
        <script>
            new DataTable('#table-collectiveMembres', {
                layout: {
                    topStart: {
                        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
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
    @endpush
