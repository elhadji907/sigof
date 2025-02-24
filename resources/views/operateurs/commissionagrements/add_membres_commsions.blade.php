@extends('layout.user-layout')
@section('title', 'ajouter dans la formation')
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
                                        href="{{ route('commissionagrements.index') }}"
                                        class="btn btn-success btn-sm" title="retour"><i
                                            class="bi bi-arrow-counterclockwise"></i></a>&nbsp;
                                    <p> | {{ $commissionagrement?->commission }}</p>
                                </span>
                            </div>
                        </div>
                        @isset($commissionagrement->operateurs)
                            <h5 class="pt-2"><u><b>Membres du jury</b> :</u>
                                <span class="badge bg-secondary"> {{ count($commissionagrement?->commissionmembres) }}
                                </span>
                            </h5>
                        @endisset
                        <form method="post" action="{{ route('addMembreJury', $commissionagrement->id) }}"
                            enctype="multipart/form-data" class="row g-3">
                            @csrf
                            @method('patch')
                            <div class="row mb-0">
                                {{-- <div class="form-check col-md-2 pt-3">
                                    <label for="#">Choisir tout</label>
                                    <input type="checkbox" class="form-check-input" id="checkAll">
                                </div> --}}
                                <div class="form-check col-md-12 pt-3">
                                    <table class="table datatables align-middle" id="table-operateurs">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="form-check-input" id="checkAll"></th>
                                                <th width='8%'>Civilité</th>
                                                <th>Prénom</th>
                                                <th>Nom</th>
                                                <th>Fonction</th>
                                                <th>structure</th>
                                                <th>Email</th>
                                                <th class="text-center">Téléphone</th>
                                                <th class="text-center" width='8%'>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($membres as $membre)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="membres[]" value="{{ $membre?->id }}"
                                                            {{ in_array($membre?->id, $membreJury) ? 'checked' : '' }}
                                                            class="form-check-input @error('membres') is-invalid @enderror">
                                                        {{ $membre?->civilite }}
                                                        @error('membres')
                                                            <span class="invalid-feedback" role="alert">
                                                                <div>{{ $message }}</div>
                                                            </span>
                                                        @enderror
                                                    </td>
                                                    <td>{{ $membre->civilite }}</td>
                                                    <td>{{ $membre->prenom }}</td>
                                                    <td>{{ $membre->nom }}</td>
                                                    <td>{{ $membre->fonction }}</td>
                                                    <td>{{ $membre->structure }}</td>
                                                    <td><a href="mailto:{{ $membre->email }}">{{ $membre->email }}</a>
                                                    </td>
                                                    <td class="text-center"><a
                                                            href="tel:+221{{ $membre->telephone }}">{{ $membre->telephone }}</a>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <span class="d-flex mt-2 align-items-baseline"><a
                                                                href="{{ route('commissionmembres.show', $membre->id) }}"
                                                                class="btn btn-warning btn-sm mx-1" title="Voir détails">
                                                                <i class="bi bi-eye"></i></a>
                                                            {{-- <div class="filter">
                                                                <a class="icon" href="#"
                                                                    data-bs-toggle="dropdown"><i
                                                                        class="bi bi-three-dots"></i></a>
                                                                <ul
                                                                    class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                                    <li>
                                                                        <button type="button"
                                                                            class="dropdown-item btn btn-sm mx-1"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#EditmembreModal{{ $membre->id }}">
                                                                            <i class="bi bi-pencil" title="Modifier"></i>
                                                                            Modifier
                                                                        </button>
                                                                    </li>
                                                                    <li>
                                                                        <form
                                                                            action="{{ route('commissionmembres.destroy', $membre->id) }}"
                                                                            method="post">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="dropdown-item show_confirm"><i
                                                                                    class="bi bi-trash"></i>Supprimer</button>
                                                                        </form>
                                                                    </li>
                                                                </ul>
                                                            </div> --}}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-outline-primary btn-sm"><i
                                            class="bi bi-check2-circle"></i>&nbsp;Sélectionner</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        new DataTable('#table-operateurs', {
            /* layout: {
                topStart: {
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                }
            }, */
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "Tout"]
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
