@extends('layout.user-layout')
@section('title', 'Ajouter dans la formation')
@section('space-work')
    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-12">
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
                            role="alert">
                            <strong>{{ $error }}</strong>
                        </div>
                    @endforeach
                @endif
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 pt-0">
                                <span class="d-flex mt-0 align-items-baseline">
                                    <a href="{{ route('formations.show', $formation->id) }}" class="btn btn-success btn-sm"
                                        title="Retour">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </a>&nbsp;
                                    <p> | Liste des bénéficiaires</p>
                                </span>
                            </div>
                        </div>
                        <h5><u><b>Région</b></u> : {{ $region->nom }}</h5>
                        <h5><u><b>Module</b></u> : {{ $module->name }}</h5>
                        <h5><u><b>Sélectionnés</b></u> : {{ $candidatsretenus?->count() ?? '' }}</h5>
                        <form method="post"
                            action="{{ url('formationdemandeurs', ['idformation' => $formation->id, 'idmodule' => $formation->module->id, 'idlocalite' => $formation->departement->id]) }}"
                            enctype="multipart/form-data" class="row g-3 mt-2">
                            @csrf
                            @method('PUT')

                            @foreach ($individuelles as $nonvide)
                            @endforeach
                            @if (!empty($nonvide))
                                <div class="form-check col-md-12">
                                    <table class="table datatables align-middle" id="table-individuelles">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="form-check-input" id="checkAll"> Civilité
                                                </th>
                                                <th>Prénom</th>
                                                <th>NOM</th>
                                                <th>Date naissance</th>
                                                <th>Lieu naissance</th>
                                                <th>Département</th>
                                                <th>Module</th>
                                                <th>Statut</th>
                                                @if (!empty($formation->projets_id))
                                                    <th>Projet</th>
                                                @endif
                                                <th width='5%'><i class="bi bi-gear"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($individuelles as $individuelle)
                                                @if (!empty($individuelle?->numero))
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="individuelles[]"
                                                                value="{{ $individuelle->id }}"
                                                                {{ in_array($individuelle->formations_id, $individuelleFormation) ? 'checked' : '' }}
                                                                {{ in_array($individuelle->formations_id, $individuelleFormationCheck) ? 'disabled' : '' }}
                                                                class="form-check-input @error('individuelles') is-invalid @enderror">
                                                            {{ $individuelle?->user?->civilite }}
                                                            @error('individuelles')
                                                                <span class="invalid-feedback"
                                                                    role="alert">{{ $message }}</span>
                                                            @enderror
                                                        </td>
                                                        <td>{{ $individuelle?->user?->firstname }}</td>
                                                        <td>{{ $individuelle?->user?->name }}</td>
                                                        <td>{{ $individuelle?->user->date_naissance?->format('d/m/Y') }}
                                                        </td>
                                                        <td>{{ $individuelle?->user->lieu_naissance }}</td>
                                                        <td>{{ $individuelle?->departement->nom }}</td>
                                                        <td>{{ $individuelle?->module->name }}</td>
                                                        <td><span
                                                                class="{{ $individuelle?->statut }}">{{ $individuelle?->statut }}</span>
                                                        </td>
                                                        @if (!empty($formation->projets_id))
                                                            <td>{{ $individuelle?->projet?->sigle }}</td>
                                                        @endif
                                                        <td>
                                                            <span class="d-flex align-items-baseline">
                                                                <a href="{{ route('individuelles.show', $individuelle->id) }}"
                                                                    class="btn btn-primary btn-sm" title="Voir détails"
                                                                    target="_blank">
                                                                    <i class="bi bi-eye"></i>
                                                                </a>
                                                                <div class="filter">
                                                                    <a class="icon" href="#"
                                                                        data-bs-toggle="dropdown"><i
                                                                            class="bi bi-three-dots"></i></a>
                                                                    <ul
                                                                        class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                                        <li>
                                                                            <a class="dropdown-item btn btn-sm"
                                                                                href="{{ route('individuelles.edit', $individuelle->id) }}"
                                                                                title="Modifier">
                                                                                <i class="bi bi-pencil"></i> Modifier
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <form
                                                                                action="{{ route('individuelles.destroy', $individuelle->id) }}"
                                                                                method="post">
                                                                                @csrf
                                                                                <button type="submit"
                                                                                    class="dropdown-item show_confirm"
                                                                                    title="Supprimer">
                                                                                    <i class="bi bi-trash"></i> Supprimer
                                                                                </button>
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
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-outline-primary btn-sm"><i
                                                class="bi bi-check2-circle"></i> Sélectionner</button>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning mt-5">Aucun demandeur disponible pour le moment !!!</div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- autre --}}
        <div class="row justify-content-center">
            <div class="col-lg-12">
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
                            role="alert">
                            <strong>{{ $error }}</strong>
                        </div>
                    @endforeach
                @endif
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 pt-0">
                                <span class="d-flex mt-0 align-items-baseline">
                                    <a href="{{ route('formations.show', $formation->id) }}" class="btn btn-success btn-sm"
                                        title="Retour">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </a>&nbsp;
                                    <p> | Liste des candidats éligibles mais retirés</p>
                                </span>
                            </div>
                        </div>

                        @foreach ($retirer_individuelles as $indiv)
                        @endforeach
                        @if (!empty($indiv))
                            <div class="form-check col-md-12">
                                <table class="table datatables align-middle" id="table-individuelles">
                                    <thead>
                                        <tr>
                                            <th> Civilité</th>
                                            <th>Prénom</th>
                                            <th>NOM</th>
                                            <th>Date naissance</th>
                                            <th>Lieu naissance</th>
                                            <th>Département</th>
                                            <th>Module</th>
                                            <th>Statut</th>
                                            @if (!empty($formation->projets_id))
                                                <th>Projet</th>
                                            @endif
                                            <th><i class="bi bi-gear"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($retirer_individuelles as $individuelle)
                                            @if (!empty($individuelle?->numero))
                                                <tr>
                                                    <td>{{ $individuelle?->user?->civilite }}</td>
                                                    <td>{{ $individuelle?->user?->firstname }}</td>
                                                    <td>{{ $individuelle?->user?->name }}</td>
                                                    <td>{{ $individuelle?->user->date_naissance?->format('d/m/Y') }}</td>
                                                    <td>{{ $individuelle?->user->lieu_naissance }}</td>
                                                    <td>{{ $individuelle?->departement->nom }}</td>
                                                    <td>{{ $individuelle?->module->name }}</td>
                                                    <td><span
                                                            class="{{ $individuelle?->statut }}">{{ $individuelle?->statut }}</span>
                                                    </td>
                                                    @if (!empty($formation->projets_id))
                                                        <td>{{ $individuelle?->projet?->sigle }}</td>
                                                    @endif
                                                    <td>
                                                        <span class="d-flex align-items-baseline">
                                                            <a href="{{ route('individuelles.show', $individuelle->id) }}"
                                                                class="btn btn-primary btn-sm" title="Voir détails"
                                                                target="_blank">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                            <div class="filter">
                                                                <a class="icon" href="#"
                                                                    data-bs-toggle="dropdown"><i
                                                                        class="bi bi-three-dots"></i></a>
                                                                <ul
                                                                    class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                                    @can('retirer-demandeur-formation')
                                                                        <button class="btn btn-sm mx-1" data-bs-toggle="modal"
                                                                            data-bs-target="#diponibleModal{{ $individuelle->id }}">
                                                                            <i class="bi bi-arrow-return-right"></i> Remettre
                                                                        </button>
                                                                    @endcan
                                                                </ul>
                                                            </div>
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info mt-5">Aucun pour le moment !!!</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @foreach ($retirer_individuelles as $individuelle)
            <div class="modal fade" id="diponibleModal{{ $individuelle->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="{{ route('givedisponibles', $individuelle->id) }}"
                            enctype="multipart/form-data" class="row">
                            @csrf
                            @method('PUT')
                            <div class="card-header bg-gradient-default">
                                <h1 class="h4 text-black mb-0">Remettre
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
                                    <div class="col-12">
                                        <input type="hidden" name="individuelleid" value="{{ $individuelle->id }}">
                                        <label for="motif" class="form-label">Justification<span
                                                class="text-danger mx-1">*</span></label>
                                        <textarea name="motif" id="motif" rows="5"
                                            class="form-control form-control-sm @error('motif') is-invalid @enderror" placeholder="Expliquer les raisons">{{ old('motif') }}</textarea>
                                        @error('motif')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm"
                                    data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-primary btn-sm"><i
                                        class="bi bi-arrow-right-circle"></i> Remettre</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </section>
@endsection
