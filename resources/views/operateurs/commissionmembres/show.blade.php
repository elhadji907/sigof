@extends('layout.user-layout')
@section('title', 'ONFP | Liste des Membres du jury')
@section('space-work')
    @can('ingenieur-view')
        <section class="section register">
            <div class="row justify-content-center">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="pagetitle">
                        {{-- <h1>Data Tables</h1> --}}
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Accueil</a></li>
                                <li class="breadcrumb-item">Tables</li>
                                <li class="breadcrumb-item active">Données</li>
                            </ol>
                        </nav>
                    </div><!-- End Page Title -->
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
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 pt-0">
                                    <span class="d-flex mt-0 align-items-baseline"><a
                                            href="{{ route('commissionmembres.index') }}"
                                            class="btn btn-success btn-sm" title="retour"><i
                                                class="bi bi-arrow-counterclockwise"></i></a>&nbsp;
                                        <p> | retour</p>
                                    </span>
                                </div>
                            </div>
                            <h5 class="card-title">{{ $membre?->civilite . ' ' . $membre?->prenom . ' ' . $membre?->nom }}</h5>
                            <table class="table datatables align-middle justify-content-center" id="table-membre">
                                <thead>
                                    <tr>
                                        <th>Commission agrément</th>
                                        <th class="text-center">Session</th>
                                        <th width="5%" class="text-center">Date</th>
                                        <th>Lieu</th>
                                        <th>Fin agrément</th>
                                        <th width="5%" class="text-center">Operateurs</th>
                                        <th width="5%" class="text-center">Statut</th>
                                        <th width="5%" class="text-center" scope="col"><i class="bi bi-gear"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($membre?->commissionagrements as $commission)
                                        <tr>
                                            <td>{{ $commission?->commission }}</td>
                                            <td style="text-align: center;">{{ $commission?->session }}</td>
                                            <td style="text-align: center;">{{ $commission?->date?->format('d/m/Y') }}</td>
                                            <td>{{ $commission?->lieu }}</td>
                                            <td>{{ $commission?->date?->translatedFormat('l d F Y') }}</td>
                                            <td style="text-align: center;">
                                                @foreach ($commission?->operateurs as $operateur)
                                                    @if ($loop?->last)
                                                        <span class="badge bg-info">{{ $loop?->count }}</span>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td></td>
                                            <td style="text-align: center;">
                                                @can('commission-show')
                                                    <span class="d-flex mt-2 align-items-baseline"><a
                                                            href="{{ route('commissionagrements.show', $commission?->id) }}"
                                                            class="btn btn-warning btn-sm mx-1" title="Voir détails">
                                                            <i class="bi bi-eye"></i></a>
                                                        @if (auth()?->user()?->hasRole('super-admin|admin'))
                                                            <div class="filter">
                                                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                                                        class="bi bi-three-dots"></i></a>
                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                                    @can('commission-update')
                                                                        <li>
                                                                            <button type="button" class="dropdown-item btn btn-sm mx-1"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#EditagrementModal{{ $commission?->id }}">
                                                                                <i class="bi bi-pencil" title="Modifier"></i> Modifier
                                                                            </button>
                                                                        </li>
                                                                    @endcan
                                                                    @can('commission-delete')
                                                                        <li>
                                                                            <form
                                                                                action="{{ url('commissionagrements', $commission?->id) }}"
                                                                                method="post">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit"
                                                                                    class="dropdown-item show_confirm"><i
                                                                                        class="bi bi-trash"></i>Supprimer</button>
                                                                            </form>
                                                                        </li>
                                                                        <hr>
                                                                        <li>
                                                                            <a class="dropdown-item btn btn-sm"
                                                                                href="{{ route('jurycommissionagrements.jury', $commission?->id) }}"
                                                                                class="mx-1" title="Modifier"><i
                                                                                    class="bi bi-people"></i>Membres du jury</a>
                                                                        </li>
                                                                    @endcan
                                                                </ul>
                                                            </div>
                                                        @endif
                                                    </span>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->
                        </div>
                    </div>

                </div>
            </div>
        </section>
    @endcan
@endsection

@push('scripts')
    <script>
        new DataTable('#table-membre', {
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
