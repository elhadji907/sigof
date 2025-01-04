@extends('layout.user-layout')
@section('title', 'SIGOF - SÉLECTIONNER STRUCTURE')
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
                                    <p> | Liste des demandes collectives</p>
                                </span>
                            </div>
                        </div>
                        @isset($formation?->collectivemodule?->collective?->name)
                            <h5><b><u>BENEFICIAIRES</u></b> : {{ $formation?->collectivemodule?->collective?->name }}
                                @isset($formation?->collectivemodule?->collective?->name)
                                    {{ '(' . $formation?->collectivemodule?->collective?->sigle . ')' }}
                                @endisset
                            </h5>
                            <h5><b><u>MODULE</u></b> :{{ $formation?->collectivemodule?->module }}</h5>
                        @endisset
                        {{-- <h5 class="pt-2">Liste des demandes collectives</h5> --}}
                        <form method="post" action="{{ route('formationcollectives', $formation->id) }}"
                            enctype="multipart/form-data" class="row g-3">
                            @csrf
                            @method('PUT')
                            {{--  <input type="hidden" value="{{ $formation?->collectivemodule?->id }}"
                                name="collectivemoduleformation"> --}}
                            <div class="row mb-3">
                                <div class="form-check col-md-12 pt-5">
                                    <table class="table datatables align-middle" id="table-modules">
                                        <thead>
                                            <tr>
                                                <th>N°</th>
                                                <th>Structure</th>
                                                {{-- <th>Sigle</th> --}}
                                                <th>Téléphone</th>
                                                {{-- <th>E-mail</th> --}}
                                                <th>Département</th>
                                                <th>Modules</th>
                                                <th style="text-align: center;">Effectif</th>
                                                <th>Statut</th>
                                                <th class="text-center">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($collectivemodules as $collectivemodule)
                                                <tr>
                                                    <td>
                                                        <input type="radio" name="collectivemodule"
                                                            value="{{ $collectivemodule?->id }}"
                                                            {{ in_array($collectivemodule->formations_id, $collectiveModule) ? 'checked' : '' }}
                                                            {{ in_array($collectivemodule->formations_id, $collectiveModuleCheck) ? 'disable' : '' }}
                                                            class="form-check-input @error('collective') is-invalid @enderror">
                                                        @error('collectivemodule')
                                                            <span class="invalid-feedback" role="alert">
                                                                <div>{{ $message }}</div>
                                                            </span>
                                                        @enderror
                                                        {{ $collectivemodule?->collective->numero }}
                                                    </td>

                                                    <td>{{ $collectivemodule?->collective?->name }}
                                                        @isset($collectivemodule->collective?->sigle)
                                                            {{ '(' . $collectivemodule->collective?->sigle . ')' }}
                                                        @endisset
                                                    </td>
                                                    {{-- <td>{{ $collectivemodule->collective?->sigle }}</td> --}}
                                                    <td>{{ $collectivemodule->collective?->user?->telephone }}</td>
                                                    {{-- <td><a
                                                            href="mailto:{{ $collectivemodule->collective?->user?->email }}">{{ $collectivemodule->collective?->user?->email }}</a>
                                                    </td> --}}
                                                    <td>{{ $collectivemodule->collective->departement?->region?->nom }}
                                                    </td>
                                                    <td>{{ $collectivemodule?->module }}</td>
                                                    <td style="text-align: center;">
                                                        @foreach ($collectivemodule->listecollectives as $listecollective)
                                                            @if ($loop->last)
                                                                <span class="badge bg-info">{{ $loop->count }}</span>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="{{ $collectivemodule?->statut }}">{{ $collectivemodule?->statut }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="d-flex align-items-baseline"><a
                                                                href="{{ route('collectives.show', $collectivemodule->collective->id) }}"
                                                                class="btn btn-primary btn-sm" title="voir détails"><i
                                                                    class="bi bi-eye"></i></a>
                                                            <div class="filter">
                                                                <a class="icon" href="#"
                                                                    data-bs-toggle="dropdown"><i
                                                                        class="bi bi-three-dots"></i></a>
                                                                <ul
                                                                    class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                                    {{-- <li><a class="dropdown-item btn btn-sm"
                                                                            href="{{ route('collectives.edit', $collectivemodule->collective->id) }}"
                                                                            class="mx-1" title="Modifier">Modifier</a>
                                                                    </li> --}}
                                                                    <li>
                                                                        <a class="btn" data-bs-toggle="modal"
                                                                            data-bs-target="#indiponibleModal{{ $collectivemodule->id }}"
                                                                            title="retirer">Retirer
                                                                        </a>
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
                                <div class="text-center">
                                    <button type="submit" class="btn btn-outline-primary"><i
                                            class="bi bi-check2-circle"></i>&nbsp;Sélectionner</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($collectivemodules as $collectivemodule)
            <div class="modal fade" id="indiponibleModal{{ $collectivemodule->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="{{ route('retirermoduleformation', $collectivemodule->id) }}"
                            enctype="multipart/form-data" class="row">
                            @csrf
                            @method('PUT')
                            <div class="card-header bg-gradient-default">
                                <h1 class="h4 text-black mb-0">{{ $collectivemodule?->module }}
                                </h1>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="collectivemoduleid" value="{{ $collectivemodule->id }}">
                                <label for="motif" class="form-label">Justification du retrait</label>
                                <textarea name="motif" id="motif" rows="5"
                                    class="form-control form-control-sm @error('motif') is-invalid @enderror"
                                    placeholder="Expliquer les raisons du retrait de ce bénéficiaire">{{ old('motif') }}</textarea>
                                @error('motif')
                                    <span class="invalid-feedback" role="alert">
                                        <div>{{ $message }}</div>
                                    </span>
                                @enderror
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

    </section>
@endsection
@push('scripts')
    <script>
        new DataTable('#table-modules', {
            layout: {
                topStart: {
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                }
            },
            lengthMenu: [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, "Tout"]
            ],
            "order": [
                [2, 'desc']
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
