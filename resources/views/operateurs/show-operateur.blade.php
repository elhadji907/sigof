@extends('layout.user-layout')
@section('title', remove_accents_uppercase('DOSSIER | AGREMENT'))
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
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mt-0">
                            <span class="d-flex mt-0 align-items-baseline"><a href="{{ url('/profil') }}"
                                    class="btn btn-success btn-sm" title="retour"><i
                                        class="bi bi-arrow-counterclockwise"></i></a>&nbsp;
                                <p> | Profil</p>
                            </span>
                            <button class="btn btn-info btn-sm">
                                <span class="badge bg-white text-info">{{ $operateurA->count() }}</span>
                            </button>
                            @can('devenir-operateur-agrement-ouvert')
                                @can('devenir-operateur-agrement-create')
                                    @can('agrement-ouvert')
                                        <button type="button" class="btn btn-warning btn-sm float-end btn-rounded"
                                            data-bs-toggle="modal" data-bs-target="#AddoperateurModal">
                                            renouveler agrément
                                        </button>
                                    @elsecan('agrement-fermer')
                                        <span class="text-danger small fw-bold">Les agréments sont actuellement
                                            <span class="text-uppercase">fermés</span></span>
                                    @endcan
                                @endcan
                            @endcan
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered table-hover table-borderless">
                                <thead>
                                    <tr>
                                        <th class="text-center">Année</th>
                                        <th class="text-center">Module</th>
                                        <th class="text-center">Référence</th>
                                        <th class="text-center">Equi. & Infras.</th>
                                        <th class="text-center">Formateurs</th>
                                        <th class="text-center">Type demande</th>
                                        <th class="text-center">Etat</th>
                                        <th class="text-center">Statut</th>
                                        <th class="text-center">Quitus</th>
                                        <th class="text-center"><i class="bi bi-gear"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($operateurA as $operateur)
                                        <tr>
                                            <td style="text-align: center;">{{ $operateur?->annee_agrement?->format('Y') }}
                                            </td>
                                            <td style="text-align: center;">
                                                <span class="badge bg-info">
                                                    {{ count($operateur->operateurmodules) }}
                                                </span>
                                                @can('devenir-operateur-agrement-ouvert')
                                                    @can('agrement-ouvert')
                                                        <a href="{{ route('operateurs.show', $operateur->id) }}" target="_blank">
                                                            <i class="bi bi-plus" title="Voir"></i> </a>
                                                    @endcan
                                                @endcan
                                            </td>
                                            <td style="text-align: center;">
                                                <span class="badge bg-info">
                                                    {{ count($operateur->operateureferences) }}
                                                </span>

                                                @can('devenir-operateur-agrement-ouvert')
                                                    @can('agrement-ouvert')
                                                        <a href="{{ route('showReference', ['id' => $operateur->id]) }}"
                                                            target="_blank">
                                                            <i class="bi bi-plus" title="Ajouter, Modifier, Supprimer"></i> </a>
                                                    @endcan
                                                @endcan
                                            </td>
                                            <td style="text-align: center;">
                                                <span class="badge bg-info">
                                                    {{ count($operateur->operateurequipements) }}
                                                </span>

                                                @can('devenir-operateur-agrement-ouvert')
                                                    @can('agrement-ouvert')
                                                        <a href="{{ route('showEquipement', ['id' => $operateur->id]) }}"
                                                            target="_blank">
                                                            <i class="bi bi-plus" title="Ajouter, Modifier, Supprimer"></i> </a>
                                                    @endcan
                                                @endcan
                                            </td>
                                            <td style="text-align: center;">
                                                <span class="badge bg-info">
                                                    {{ count($operateur->operateurformateurs) }}
                                                </span>
                                                @can('devenir-operateur-agrement-ouvert')
                                                    @can('agrement-ouvert')
                                                        <a href="{{ route('showFormateur', ['id' => $operateur->id]) }}"
                                                            target="_blank">
                                                            <i class="bi bi-plus" title="Ajouter, Modifier, Supprimer"></i> </a>
                                                    @endcan
                                                @endcan
                                            </td>
                                            <td style="text-align: center;"><span
                                                    class="{{ $operateur?->type_demande }}">{{ $operateur?->type_demande }}</span>
                                            </td>
                                            <td style="text-align: center;">
                                                <span class="{{ $statut_demande }} mb-2">
                                                    {{ $statut_demande }}
                                                </span>
                                            </td>
                                            <td style="text-align: center;">
                                                <span class="{{ $operateur?->statut_agrement }} mb-2">
                                                    {{ $operateur?->statut_agrement }}
                                                </span>
                                            </td>
                                            <td style="text-align: center;">
                                                <a class="btn btn-outline-secondary btn-sm" title="télécharger le quitus"
                                                    target="_blank" href="{{ asset($operateur?->getQuitus()) }}">
                                                    <i class="bi bi-file-image"></i>
                                                </a>
                                            </td>
                                            <td style="text-align: center;">
                                                @can('devenir-operateur-agrement-show')
                                                    @can('view', $operateur)
                                                        <span class="d-flex align-items-baseline"><a
                                                                href="{{ route('operateurs.show', $operateur->id) }}"
                                                                class="btn btn-success btn-sm" target="_blank"
                                                                title="voir détails"><i class="bi bi-eye"></i></a>
                                                            @can('agrement-ouvert')
                                                                <div class="filter">
                                                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                                                            class="bi bi-three-dots"></i></a>
                                                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                                        @can('devenir-operateur-agrement-update')
                                                                            @can('update', $operateur)
                                                                                <li>
                                                                                    <button type="button" class="dropdown-item btn btn-sm mx-1"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#EditOperateurModal{{ $operateur->id }}">
                                                                                        <i class="bi bi-pencil" title="Modifier"></i>
                                                                                        Modifier
                                                                                    </button>
                                                                                </li>
                                                                            @endcan
                                                                        @endcan
                                                                        @can('devenir-operateur-agrement-delete')
                                                                            @can('delete', $operateur)
                                                                                <li>
                                                                                    <form
                                                                                        action="{{ route('operateurs.destroy', $operateur->id) }}"
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
                                                                        @endcan
                                                                    </ul>
                                                                </div>
                                                            @endcan
                                                        </span>
                                                    @endcan
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        @can('upload-file-view')
                            <hr>
                            <div class="row pt-5">
                                <h5 class="card-title col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                    FICHIERS JOINTS</h5>
                                <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-6">
                                    <table class="table table-bordered table-hover datatables" id="table-iles">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">N°</th>
                                                <th>LENGENDE</th>
                                                <th width="10%" class="text-center">FILE</th>
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
                                                        <a class="btn btn-default btn-sm" title="télécharger le fichier joint"
                                                            target="_blank" href="{{ asset($file->getFichier()) }}">
                                                            <i class="bi bi-download"></i>
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <form action="{{ route('fileDestroy') }}" method="post">
                                                            @csrf
                                                            @method('put')
                                                            <input type="hidden" name="idFile"
                                                                value="{{ $file->id }}">
                                                            <button type="submit" style="background:none;border:0px;"
                                                                class="show_confirm" title="retirer">
                                                                <span class="badge border-danger border-1 text-danger">
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
                            <form method="post" action="{{ route('files.update', $operateur?->user?->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <h5 class="card-title">JOINDRE VOS SCANS DE DOSSIERS</h5>
                                <span style="color:red;">NB:</span>
                                <span>Seuls l'acte ou l'arrêté
                                    de création, ainsi que le NINEA ou le registre de commerce,</span> <span
                                    style="color:red;"> sont exigés</span>.
                                <!-- Profile Edit Form -->
                                <div class="row mb-3 mt-3">
                                    <label for="legende"
                                        class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 col-form-label">LEGENDE<span
                                            class="text-danger mx-1">*</span></label>
                                    <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-6">
                                        <select name="legende" class="form-select  @error('legende') is-invalid @enderror"
                                            aria-label="Select" id="select-field-file" data-placeholder="Choisir">
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
                                        class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4 col-form-label">FICHIER<span
                                            class="text-danger mx-1">*</span></label>
                                    <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-6">
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
                                    <div class="col-12 col-md-8 col-lg-8 col-sm-12 col-xs-12 col-xxl-6">
                                        <div class="pt-2">
                                            <button type="submit" class="btn btn-info btn-sm text-white">ENREGISTRER</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endcan
                        @foreach ($operateurs as $operateur)
                            <div class="col-lg-12 col-md-12 d-flex flex-column align-items-center justify-content-center">
                                <div class="modal fade" id="validationViewModal{{ $operateur?->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="col-12 col-md-12 col-lg-12">
                                                <table
                                                    class="table table-bordered table-hover table-borderless table-stripped">
                                                    <tr>
                                                        <td>Modules</td>
                                                        <td style="text-align: center;"><span
                                                                class="{{ $module_count }}">{{ count($operateur->operateurmodules) }}</span>
                                                        </td>
                                                        <td style="text-align: center;"><a
                                                                href="{{ route('operateurs.show', $operateur->id) }}"
                                                                class="btn btn-outline-primary btn-rounded btn-sm"
                                                                target="_blank">
                                                                <i class="bi bi-plus"
                                                                    title="Ajouter, Modifier, Supprimer"></i> </a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Références professionnelles</td>
                                                        <td style="text-align: center;"><span
                                                                class="{{ $reference_count }}">{{ count($operateur->operateureferences) }}</span>
                                                        </td>
                                                        <td style="text-align: center;"><a
                                                                href="{{ route('showReference', ['id' => $operateur->id]) }}"
                                                                class="btn btn-outline-primary btn-rounded btn-sm"
                                                                target="_blank">
                                                                <i class="bi bi-plus"
                                                                    title="Ajouter, Modifier, Supprimer"></i> </a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Infrastructures et Equipements</td>
                                                        <td style="text-align: center;"><span
                                                                class="{{ $equipement_count }}">{{ count($operateur->operateurequipements) }}</span>
                                                        </td>
                                                        <td style="text-align: center;"><a
                                                                href="{{ route('showEquipement', ['id' => $operateur->id]) }}"
                                                                class="btn btn-outline-primary btn-rounded btn-sm"
                                                                target="_blank">
                                                                <i class="bi bi-plus"
                                                                    title="Ajouter, Modifier, Supprimer"></i> </a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Formateurs</td>
                                                        <td style="text-align: center;"><span
                                                                class="{{ $formateur_count }}">{{ count($operateur->operateurformateurs) }}</span>
                                                        </td>
                                                        <td style="text-align: center;"><a
                                                                href="{{ route('showFormateur', ['id' => $operateur->id]) }}"
                                                                class="btn btn-outline-primary btn-rounded btn-sm"
                                                                target="_blank">
                                                                <i class="bi bi-plus"
                                                                    title="Ajouter, Modifier, Supprimer"></i> </a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Localités</td>
                                                        <td style="text-align: center;"><span
                                                                class="{{ $localite_count }}">{{ count($operateur->operateurlocalites) }}</span>
                                                        </td>
                                                        <td style="text-align: center;"><a
                                                                href="{{ route('showLocalite', ['id' => $operateur->id]) }}"
                                                                class="btn btn-outline-primary btn-rounded btn-sm"
                                                                target="_blank">
                                                                <i class="bi bi-plus"
                                                                    title="Ajouter, Modifier, Supprimer"></i> </a></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 d-flex flex-column align-items-center justify-content-center">
            <div class="modal fade" id="AddoperateurModal" tabindex="-1">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <form method="post" action="{{ route('renewOperateur') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header text-center bg-gradient-default">
                                <h1 class="h4 text-black mb-0">RENOUVELLEMENT AGREMENT OPERATEUR</h1>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                                        <label for="quitus" class="form-label">Quitus fiscal<span
                                                class="text-danger mx-1">*</span></label>
                                        <input type="file" name="quitus" id="quitus"
                                            accept=".jpg, .jpeg, .png, .svg, .gif"
                                            class="form-control @error('quitus') is-invalid @enderror btn btn-outline-primary btn-sm">
                                        @error('quitus')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                                        <label for="date_quitus" class="form-label">Date visa quitus<span
                                                class="text-danger mx-1">*</span></label>
                                        <input type="text" name="date_quitus" value="{{ old('date_quitus') }}"
                                            class="form-control form-control-sm @error('date_quitus') is-invalid @enderror"
                                            id="datepicker" placeholder="JJ/MM/AAAA" autocomplete="bday">
                                        @error('date_quitus')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer mt-5">
                                    <button type="button" class="btn btn-secondary btn-sm"
                                        data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Renouveler agrément</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($operateurs as $operateur)
            <div class="modal fade" id="EditOperateurModal{{ $operateur->id }}" tabindex="-1" role="dialog"
                aria-labelledby="EditOperateurModalLabel{{ $operateur->id }}" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <form method="post" action="{{ route('operateurs.updated', $operateur->id) }}"
                            enctype="multipart/form-data" class="row g-3">
                            @csrf
                            @method('patch')
                            <div class="card-header text-center bg-gradient-default">
                                <h1 class="h4 text-black mb-0">MODIFICATION OPERATEUR</h1>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" value="{{ $operateur->id }}">
                                <div class="row g-3">
                                    {{-- <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <label for="operateur" class="form-label">Raison sociale opérateur<span
                                                class="text-danger mx-1">*</span></label>
                                        <textarea name="operateur" id="operateur" rows="1"
                                            class="form-control form-control-sm @error('operateur') is-invalid @enderror"
                                            placeholder="La raison sociale de l'opérateur">{{ $operateur?->user?->operateur ?? old('operateur') }}</textarea>
                                        @error('operateur')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                        <label for="username" class="form-label">Sigle<span
                                                class="text-danger mx-1">*</span></label>
                                        <input type="text" name="username"
                                            value="{{ $operateur?->user?->username ?? old('username') }}"
                                            class="form-control form-control-sm @error('username') is-invalid @enderror"
                                            id="username" placeholder="username">
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div> --}}

                                    {{-- <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                        <label for="email" class="form-label">Email<span
                                                class="text-danger mx-1">*</span></label>
                                        <input type="text" name="email"
                                            value="{{ $operateur->user->email ?? old('email') }}"
                                            class="form-control form-control-sm @error('email') is-invalid @enderror"
                                            id="email" placeholder="Adresse email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                        <label for="fixe" class="form-label">Téléphone fixe<span
                                                class="text-danger mx-1">*</span></label>
                                        <input type="number" min="0" name="fixe"
                                            value="{{ $operateur->user->fixe ?? old('fixe') }}"
                                            class="form-control form-control-sm @error('fixe') is-invalid @enderror"
                                            id="fixe" placeholder="3xxxxxxxx">
                                        @error('fixe')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                        <label for="telephone" class="form-label">Téléphone<span
                                                class="text-danger mx-1">*</span></label>
                                        <input type="number" min="0" name="telephone"
                                            value="{{ $operateur->user->telephone ?? old('telephone') }}"
                                            class="form-control form-control-sm @error('telephone') is-invalid @enderror"
                                            id="telephone" placeholder="7xxxxxxxx">
                                        @error('telephone')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div> --}}

                                    {{--  <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                        <label for="bp" class="form-label">Boite postal</label>
                                        <input type="text" name="bp"
                                            value="{{ $operateur?->user?->bp ?? old('bp') }}"
                                            class="form-control form-control-sm @error('bp') is-invalid @enderror"
                                            id="bp" placeholder="Boite postal">
                                        @error('bp')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div> --}}

                                    {{-- <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                        <label for="categorie" class="form-label">Catégorie<span
                                                class="text-danger mx-1">*</span></label>
                                        <select name="categorie"
                                            class="form-select form-select-sm @error('categorie') is-invalid @enderror"
                                            aria-label="Select" id="select-field-categorie_op"
                                            data-placeholder="Choisir">
                                            <option value="{{ $operateur?->user?->categorie ?? old('categorie') }}">
                                                {{ $operateur?->user?->categorie ?? old('categorie') }}
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
                                    </div> --}}

                                    {{-- <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                        <label for="statut" class="form-label">Statut juridique<span
                                                class="text-danger mx-1">*</span></label>
                                        <select name="statut"
                                            class="form-select form-select-sm @error('statut') is-invalid @enderror"
                                            aria-label="Select" id="select-field-juridique" data-placeholder="Choisir">
                                            <option value="{{ $operateur?->statut ?? old('statut') }}">
                                                {{ $operateur?->statut ?? old('statut') }}
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
                                    </div> --}}

                                    {{--    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                        <label for="autre_statut" class="form-label">Si autre ?
                                            précisez</label>
                                        <input type="text" name="autre_statut"
                                            value="{{ $operateur?->autre_statut ?? old('autre_statut') }}"
                                            class="form-control form-control-sm @error('autre_statut') is-invalid @enderror"
                                            id="autre_statut" placeholder="autre statut juridique">
                                        @error('autre_statut')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div> --}}

                                    {{-- <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                        <label for="adresse" class="form-label">Adresse<span
                                                class="text-danger mx-1">*</span></label>
                                        <textarea name="adresse" id="adresse" rows="1"
                                            class="form-control form-control-sm @error('adresse') is-invalid @enderror"
                                            placeholder="Adresse exacte opérateur">{{ $operateur?->user?->adresse ?? old('adresse') }}</textarea>
                                        @error('adresse')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div> --}}
                                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                                        <label for="type_demande" class="form-label">Type demande<span
                                                class="text-danger mx-1">*</span></label>
                                        <select name="type_demande"
                                            class="form-select form-select-sm @error('type_demande') is-invalid @enderror"
                                            aria-label="Select" id="select-field-registre" data-placeholder="Choisir">
                                            <option value="{{ $operateur?->type_demande ?? old('type_demande') }}">
                                                {{ $operateur?->type_demande ?? old('type_demande') }}
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

                                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                                        <label for="departement" class="form-label">Département<span
                                                class="text-danger mx-1">*</span></label>
                                        <select name="departement"
                                            class="form-select form-select-sm @error('departement') is-invalid @enderror"
                                            aria-label="Select" id="select-field-departement-update"
                                            data-placeholder="Choisir">
                                            <option value="{{ $operateur->departement?->nom ?? old('departement') }}">
                                                {{ $operateur->departement?->nom ?? old('departement') }}
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

                                    {{-- <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                        <label for="registre_commerce" class="form-label">RCCM / Ninéa<span
                                                class="text-danger mx-1">*</span></label>
                                        <select name="registre_commerce"
                                            class="form-select form-select-sm @error('registre_commerce') is-invalid @enderror"
                                            aria-label="Select" id="select-field-registre-update"
                                            data-placeholder="Choisir">
                                            <option value="{{ $operateur?->user?->rccm ?? old('registre_commerce') }}">
                                                {{ $operateur->user->rccm ?? old('registre_commerce') }}
                                            </option>
                                            <option value="Registre de commerce">
                                                Registre de commerce
                                            </option>
                                            <option value="Ninea">
                                                Ninea
                                            </option>
                                        </select>
                                        @error('registre_commerce')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4">
                                        <label for="ninea" class="form-label">Numéro RCCM / Ninéa<span
                                                class="text-danger mx-1">*</span></label>
                                        <input type="text" name="ninea"
                                            value="{{ $operateur?->user?->ninea ?? old('ninea') }}"
                                            class="form-control form-control-sm @error('ninea') is-invalid @enderror"
                                            id="ninea" placeholder="Votre ninéa / Numéro RCCM">
                                        @error('ninea')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div> --}}

                                    <div class="col-12 col-md-12 col-lg-3 col-sm-12 col-xs-12 col-xxl-5">
                                        <label for="quitus" class="form-label">Quitus fiscal<span
                                                class="text-danger mx-1">*</span></label>

                                        <input type="file" name="quitus" id="quitus"
                                            accept=".jpg, .jpeg, .png, .svg, .gif"
                                            class="form-control @error('quitus') is-invalid @enderror btn btn-outline-primary btn-sm">
                                        @error('quitus')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-1 col-sm-12 col-xs-12 col-xxl-1">
                                        <label for="quitus" class="form-label">Fichier</label>
                                        <div>
                                            <a class="btn btn-outline-secondary btn-sm" title="télécharger le quitus"
                                                target="_blank" href="{{ asset($operateur?->getQuitus()) }}">
                                                <i class="bi bi-file-image"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                                        <label for="date_quitus" class="form-label">Date visa quitus<span
                                                class="text-danger mx-1">*</span></label>
                                        <input type="date" name="date_quitus"
                                            value="{{ $operateur?->debut_quitus?->format('Y-m-d') ?? old('date_quitus') }}"
                                            class="datepicker form-control form-control-sm @error('date_quitus') is-invalid @enderror"
                                            id="date_quitus" placeholder="jj/mm/aaaa">
                                        @error('date_quitus')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer mt-3">
                                    <button type="button" class="btn btn-secondary btn-sm"
                                        data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Enregistrer
                                        modifications</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </section>
@endsection
