@extends('layout.user-layout')
@section('title', 'ONFP | UTILISATEURS EN LIGNE')
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
        <div class="row">
            <div class="col-lg-12">
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
                            <div class="col-sm-12 pt-1">
                                <span class="d-flex mt-2 align-items-baseline"><a href="{{ route('users.actifs') }}"
                                        class="btn btn-success btn-sm" title="retour"><i
                                            class="bi bi-arrow-counterclockwise"></i></a>&nbsp;
                                    <p> | Liste des utilisateurs</p>
                                </span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            @can('user-create')
                                <h5 class="card-title">UTILISATEURS EN LIGNE</h5>
                            @endcan
                        </div>
                        @if ($users->isNotEmpty())
                            <table class="table datatables align-middle" id="table-users">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Username</th>
                                        <th>E-mail</th>
                                        <th>Téléphone</th>
                                        <th>Roles</th>
                                        <th class="text-center">En ligne</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($users as $user)
                                        <tr>
                                            <th scope="row">
                                                <a href="{{ route('users.show', $user->id) }}">
                                                    <img class="rounded-circle w-20" alt="Profil"
                                                        src="{{ asset($user->getImage()) }}" width="40" height="auto">
                                                </a>
                                            </th>
                                            <td>{{ $user->username }}</td>
                                            <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                                            <td><a href="tel:+221{{ $user->telephone }}">{{ $user->telephone }}</a></td>
                                            <td>
                                                @if (!empty($user->getRoleNames()))
                                                    @foreach ($user->getRoleNames() as $roleName)
                                                        <label for="label"
                                                            class="badge bg-primary mx-1">{{ $roleName }}</label>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td style="text-align: center;">
                                                @if ($user?->email_verified_at)
                                                    <i class="bi bi-check-circle text-success" title="compte vérifié"></i>
                                                @endif
                                                {{ \Carbon\Carbon::parse($user->last_activity)->diffForHumans() }}
                                            </td>
                                            <td>
                                                <span class="d-flex mt-2 align-items-baseline"><a
                                                        href="{{ route('users.show', $user->id) }}"
                                                        class="btn btn-info btn-sm mx-1" title="voir détails"><i
                                                            class="bi bi-eye"></i></a>
                                                    <div class="filter">
                                                        <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                                                class="bi bi-three-dots"></i></a>
                                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                            {{-- @can('user-update') --}}
                                                            <li><a class="dropdown-item btn btn-sm mx-1"
                                                                    href="{{ route('users.edit', $user->id) }}"><i
                                                                        class="bi bi-pencil"></i> Modifier</a>
                                                            </li>
                                                            {{-- @endcan --}}
                                                            @can('user-delete')
                                                                <li>
                                                                    <form action="{{ route('users.destroy', $user->id) }}"
                                                                        method="post">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="dropdown-item show_confirm"><i
                                                                                class="bi bi-trash"></i>Supprimer</button>
                                                                    </form>
                                                                </li>
                                                            @endcan
                                                            <li>
                                                                <a class="dropdown-item btn btn-sm mx-1" href="#"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#forgotModal{{ $user->id }}">
                                                                    <i class="bi bi-key"></i>Réinitialiser MP</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-warning">
                                Aucun utilisateur connecté pour l'instant !
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        new DataTable('#table-users', {

            "order": [
                [5, 'asc']
            ],

            "lengthMenu": [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, "Tout"]
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
