@extends('layout.user-layout')
@section('title', 'Feuille de présence formation en ' . $formation?->name . ': ' . $emargement?->jour)
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
                            role="alert"><strong>{{ $error }}</strong></div>
                    @endforeach
                @endif
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 pt-0">
                                <span class="d-flex mt-0 align-items-baseline"><a
                                        href="{{ route('formations.show', $formation->id) }}" class="btn btn-success btn-sm"
                                        title="retour"><i class="bi bi-arrow-counterclockwise"></i></a>&nbsp;
                                    <p> | Feuille de présence</p>
                                </span>
                            </div>
                        </div>
                        <br>
                        <div class="d-flex justify-content-between align-items-center">
                            <h5><u><b>{{ $emargement?->jour }}</b></u></h5>
                            <span class="d-flex align-items-baseline">
                                <form action="{{ route('feuillePresenceJour') }}" method="post" target="_blank">
                                    @csrf
                                    <input type="hidden" name="idformation" value="{{ $formation->id }}">
                                    <input type="hidden" name="idmodule" value="{{ $formation?->module?->id }}">
                                    <input type="hidden" name="idlocalite"
                                        value="{{ $formation?->departement?->region?->id }}">
                                    <input type="hidden" name="idemargement" value="{{ $emargement?->id }}">
                                    <button class="btn btn-secondary btn-sm mx-1">Feuille présence</button>
                                </form>
                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                            class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li>
                                            <form action="{{ route('feuillePresenceTous') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="idformation" value="{{ $formation->id }}">
                                                <input type="hidden" name="idmodule" value="{{ $formation?->module?->id }}">
                                                <input type="hidden" name="idlocalite"
                                                    value="{{ $formation?->departement?->region?->id }}">
                                                <input type="hidden" name="idemargement" value="{{ $emargement?->id }}">
                                                <button class="show_confirm_valider btn btn-sm mx-1">Pointer tous</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </span>
                        </div>
                        <br>
                        <form method="post"
                            action="{{ url('formationemargement', [
                                'idformation' => $formation?->id,
                                'idmodule' => $formation?->module?->id,
                                'idlocalite' => $formation?->departement?->region?->id,
                                'idemargement' => $emargement?->id,
                            ]) }}"
                            enctype="multipart/form-data" class="row g-3 mt-2">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <div class="form-check col-md-12">
                                    <table class="table datatables align-middle" id="table-individuelles">
                                        <thead>
                                            <tr>
                                                <th width="3%">N°</th>
                                                {{-- <th>CIN</th> --}}
                                                {{--  <th width="3%"> --}}
                                                {{-- <input type="checkbox" class="form-check-input" id="checkAll"> --}}
                                                {{--      Civilité
                                                </th> --}}
                                                <th>Prénom</th>
                                                <th>NOM</th>
                                                <th>Date naissance</th>
                                                <th>Lieu naissance</th>
                                                <th>Département</th>
                                                {{-- <th>Adresse</th> --}}
                                                {{-- <th>Module</th> --}}
                                                <th style="text-align: center">Présence</th>
                                                @if (!empty($formation->projets_id))
                                                    <th>Projet</th>
                                                @endif
                                                <th width="3%"><i class="bi bi-gear"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($formation?->individuelles as $individuelle)
                                                @if (!empty($individuelle?->numero))
                                                    <tr>
                                                        <td>{{ $i++ }}</td>
                                                        {{-- <td>{{ $individuelle?->user?->cin }}</td> --}}
                                                        {{--  <td> --}}
                                                        {{-- <input type="checkbox" name="individuelles[]"
                                                                value="{{ $individuelle->id }}"
                                                                {{ in_array($individuelle->formations_id, $individuelleFormation) ? 'checked' : '' }}
                                                                {{ in_array($individuelle->formations_id, $individuelleFormationCheck) ? 'disabled' : '' }}
                                                                class="form-check-input @error('individuelles') is-invalid @enderror"> --}}
                                                        {{-- {{ $individuelle?->user?->civilite }}
                                                            @error('individuelles')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <div>{{ $message }}</div>
                                                                </span>
                                                            @enderror
                                                        </td> --}}
                                                        <td>{{ $individuelle?->user?->firstname }}</td>
                                                        <td>{{ $individuelle?->user?->name }}</td>
                                                        <td>{{ $individuelle?->user?->date_naissance?->format('d/m/Y') }}
                                                        </td>
                                                        <td>{{ $individuelle?->user?->lieu_naissance }}</td>
                                                        <td>{{ $individuelle?->departement?->nom }}</td>
                                                        {{-- <td>{{ $individuelle?->user?->adresse }}</td> --}}
                                                        {{-- <td>{{ $individuelle?->module?->name }}</td> --}}
                                                        {{-- <td><span class="{{ $individuelle?->statut }}">{{ $individuelle?->statut }}</span>
                                                        </td> --}}
                                                        <td style="text-align: center">
                                                            @foreach ($individuelle?->feuillepresences as $feuillepresence)
                                                                {{ in_array($feuillepresence?->emargements_id, $feuillepresenceIndividuelle) ? $feuillepresence?->presence : '' }}
                                                            @endforeach
                                                        </td>
                                                        @if (!empty($formation->projets_id))
                                                            <td>{{ $individuelle?->projet?->sigle }}</td>
                                                        @endif
                                                        <td>
                                                            <span class="d-flex align-items-baseline"><a
                                                                    href="{{ route('individuelles.show', $individuelle->id) }}"
                                                                    class="btn btn-primary btn-sm" title="voir détails"
                                                                    target="_blanck"><i class="bi bi-eye"></i></a>
                                                                <div class="filter">
                                                                    <a class="icon" href="#"
                                                                        data-bs-toggle="dropdown"><i
                                                                            class="bi bi-three-dots"></i></a>
                                                                    <ul
                                                                        class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                                        <li>
                                                                            {{-- <a class="dropdown-item btn btn-sm"
                                                                                href="{{ route('individuelleEmargement', ['idindividuelle' => $individuelle?->id, 'idemargement' => $emargement?->id]) }}"
                                                                                class="mx-1" title="Modifier"><i
                                                                                    class="bi bi-pencil"></i>Modifier</a> --}}
                                                                            <button type="button" class="dropdown-item"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#PresenceModal{{ $individuelle->id }}">Présence
                                                                            </button>
                                                                            {{-- <button type="button" class="dropdown-item btn btn-sm"
                                                                            data-bs-toggle="modal" data-bs-target="#generate_rapport"></i>Rechercher
                                                                            plus</button> --}}
                                                                        </li>
                                                                        <li>
                                                                            <form
                                                                                action="{{ route('feuillepresences.destroy', $individuelle->id) }}"
                                                                                method="post">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit"
                                                                                    class="dropdown-item show_confirm"
                                                                                    title="Supprimer">Supprimer</button>
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
                                    {{--  <div class="text-center">
                                        <button type="submit" class="btn btn-outline-primary btn-sm"><i
                                                class="bi bi-check2-circle"></i>&nbsp;Sélectionner</button>
                                    </div> --}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($formation?->individuelles as $individuelle)
            <div class="modal fade" id="PresenceModal{{ $individuelle->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="{{ route('feuillepresences.update', $individuelle->id) }}"
                            enctype="multipart/form-data" class="row">
                            @csrf
                            @method('patch')
                            <div class="card-header text-center bg-gradient-default">
                                <h3 class="h4 text-black mb-0">
                                    {{ $individuelle?->user?->civilite . ' ' . $individuelle?->user?->firstname . ' ' . $individuelle?->user?->name }}
                                </h3>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="idemargement" value="{{ $emargement->id }}">
                                <input type="hidden" name="pointeur" value="0">
                                <label for="motif" class="form-label">Présence<span
                                        class="text-danger mx-1">*</span></label>
                                <select name="presence" class="form-select  @error('presence') is-invalid @enderror"
                                    aria-label="Select" id="select-field-feuille_presence" data-placeholder="Choisir">
                                    @foreach ($individuelle?->feuillepresences->unique('presence') as $feuillepresence)
                                        <option value="{{ $feuillepresence?->presence ?? old('presence') }}">
                                            {{ in_array($feuillepresence?->emargements_id, $feuillepresenceIndividuelle) ? $feuillepresence?->presence : '' }}
                                        </option>
                                    @endforeach
                                    <option value="Oui">Oui</option>
                                    <option value="Non">Non</option>
                                </select>
                                @error('motif')
                                    <span class="invalid-feedback" role="alert">
                                        <div>{{ $message }}</div>
                                    </span>
                                @enderror
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm"
                                    data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-success btn-sm">Valider</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </section>
@endsection
