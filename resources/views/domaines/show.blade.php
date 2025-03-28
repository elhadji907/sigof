@extends('layout.user-layout')
@section('title', 'ONFP | DOMAINES')
@section('space-work')

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
    <section class="section">
        <div class="row justify-content-center">
            <div class="col-12 col-md-12 col-lg-12">
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
                <div class="card">
                    <div class="card-body">
                        {{-- @can('role-create') --}}
                        <div class="pt-1">
                            <a href="{{ route('domaines.create') }}" class="btn btn-primary float-end btn-rounded"><i
                                    class="fas fa-plus"></i>
                                <i class="bi bi-person-plus" title="Ajouter"></i> </a>
                        </div>
                        {{-- @endcan --}}
                        <h5 class="card-title">Domaine : {{ $domaine?->name }}</h5>
                        <!-- Table with stripped rows -->
                        <table class="table datatables align-middle justify-content-center" id="table-domaines">
                            <thead>
                                <tr>
                                    <th>Modules</th>
                                    <th>Niveau qualification</th>
                                    <th class="text-center" scope="col">Formations</th>
                                    <th class="text-center" scope="col">Demandes</th>
                                    <th class="text-center" scope="col">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($domaine?->modules as $module)
                                    <tr>
                                        <td>{{ $module->name }}</td>
                                        <td>{{ $module?->niveau_qualification }}</td>
                                        <td style="text-align: center;">
                                            @foreach ($module->formations as $formation)
                                                @if ($loop->last)
                                                    <a href="{{ url('formations/' . $formation->id) }}"><span
                                                            class="badge bg-info">{{ $loop->count }}</span></a>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td style="text-align: center;">
                                            @foreach ($module->individuelles as $individuelle)
                                                @if ($loop->last)
                                                    <a href="{{ url('modules/' . $module->id) }}"><span
                                                            class="badge bg-info">{{ $loop->count }}</span></a>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td style="text-align: center;">
                                            @can('module-show')
                                                <span class="d-flex mt-2 align-items-baseline"><a
                                                        href="{{ url('modules/' . $module->id) }}"
                                                        class="btn btn-success btn-sm mx-1" title="Voir détails">
                                                        <i class="bi bi-eye"></i></a>
                                                    <div class="filter">
                                                        <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                                                class="bi bi-three-dots"></i></a>
                                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                            @can('module-update')
                                                                <li><a class="dropdown-item btn btn-sm"
                                                                        href="{{ route('modules.edit', $module?->id) }}"
                                                                        class="mx-1"><i class="bi bi-pencil"></i>
                                                                        Modifier</a>
                                                                </li>
                                                            @endcan
                                                            @can('module-delete')
                                                                <li>
                                                                    <form action="{{ url('modules', $module->id) }}"
                                                                        method="post">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="dropdown-item show_confirm"><i
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
                        <!-- End Table with stripped rows -->
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
@push('scripts')
    <script>
        new DataTable('#table-domaines', {
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
