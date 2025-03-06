@extends('layout.user-layout')
@section('title', 'Liste de mes formations')
@section('space-work')
    @can('dg')
        <section class="section faq">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mt-0">
                            <span class="d-flex align-items-baseline"><a href="{{ url('/profil') }}"
                                    class="btn btn-success btn-sm" title="retour"><i
                                        class="bi bi-arrow-counterclockwise"></i></a>&nbsp;
                                <p> | retour</p>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="d-flex align-items-baseline">
                                <h5 class="card-title">Liste des formations</h5>
                            </span>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                            @if (!empty(Auth::user()->ingenieur))
                                @foreach (Auth::user()->ingenieur->formations as $formation)
                                @endforeach
                                @if (!empty($formation))
                                    <table class="table datatables" id="table-formations">
                                        <thead>
                                            <tr>
                                                <th width='5%' class="text-center">Code</th>
                                                <th width='15%'>Type formation</th>
                                                {{-- <th>Bénéficiaires</th> --}}
                                                <th width='15%'>Localité</th>
                                                <th width='5%'>Modules</th>
                                                <th width='15%'>Niveau qualification</th>
                                                <th width='5%' class="text-center">Statut</th>
                                                <th width='3%'><i class="bi bi-gear"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach (Auth::user()->ingenieur->formations as $formation)
                                                <tr>
                                                    <td style="text-align: center">{{ $formation?->code }}</td>
                                                    <td>{{ $formation->types_formation?->name }}</td>
                                                    {{-- <td>{{ $formation?->name }}</td> --}}
                                                    <td>{{ $formation->departement?->region?->nom }}</td>
                                                    <td>
                                                        @isset($formation?->module?->name)
                                                            {{ $formation?->module?->name }}
                                                        @endisset
                                                        @isset($formation?->collectivemodule?->module)
                                                            {{ $formation?->collectivemodule?->module }}
                                                        @endisset
                                                    </td>
                                                    <td>{{ $formation->type_certification }}</td>
                                                    <td class="text-center"><a><span
                                                                class="{{ $formation?->statut }}">{{ $formation?->statut }}</span></a>
                                                    </td>
                                                    <td>
                                                        @can('formation-show')
                                                            <span class="d-flex align-items-baseline"><a
                                                                    href="{{ route('formations.show', $formation->id) }}"
                                                                    class="btn btn-primary btn-sm" title="voir détails"><i
                                                                        class="bi bi-eye"></i></a>
                                                                <div class="filter">
                                                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                                                            class="bi bi-three-dots"></i></a>
                                                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                                        @can('formation-update')
                                                                            <li>
                                                                                <a class="dropdown-item btn btn-sm"
                                                                                    href="{{ route('formations.edit', $formation->id) }}"
                                                                                    class="mx-1" title="Modifier"><i
                                                                                        class="bi bi-pencil"></i>Modifier</a>
                                                                            </li>
                                                                        @endcan
                                                                        @can('formation-delete')
                                                                            <li>
                                                                                <form
                                                                                    action="{{ route('formations.destroy', $formation->id) }}"
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
                                @else
                                    <div class="alert alert-secondary">
                                        {{ __('Aucune formation ne vous a été attribuée pour le moment.') }} </div>
                                @endif
                            @else
                                <div class="alert alert-secondary"> {{ __("Vous n'êtes pas un ingénieur.") }} </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endcan
@endsection
@push('scripts')
    <script>
        new DataTable('#table-formations', {
            /* layout: {
                topStart: {
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                }
            }, */
            /* "order": [
                [0, 'desc']
            ], */

            "lengthMenu": [
                [1, 5, 10, 25, 50, 100, -1],
                [1, 5, 10, 25, 50, 100, "Tout"]
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
