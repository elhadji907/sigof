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
                            <div class="pt-1">
                                <button type="button" class="btn btn-primary btn-sm float-end btn-rounded"
                                    data-bs-toggle="modal" data-bs-target="#AddmembresjuryModal">Ajouter
                                </button>
                            </div>
                            <h5 class="card-title">Membres du jury</h5>
                            <table class="table datatables align-middle justify-content-center" id="table-jury">
                                <thead>
                                    <tr>
                                        <th width='8%'>Civilité</th>
                                        <th>Prénom</th>
                                        <th>Nom</th>
                                        <th>Fonction</th>
                                        <th>structure</th>
                                        <th>Email</th>
                                        <th class="text-center">Téléphone</th>
                                        <th class="text-center">Jury</th>
                                        <th class="text-center" width='8%'>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($membres as $membre)
                                        <tr>
                                            <td>{{ $membre->civilite }}</td>
                                            <td>{{ $membre->prenom }}</td>
                                            <td>{{ $membre->nom }}</td>
                                            <td>{{ $membre->fonction }}</td>
                                            <td>{{ $membre->structure }}</td>
                                            <td><a href="mailto:{{ $membre->email }}">{{ $membre->email }}</a></td>
                                            <td class="text-center"><a
                                                    href="tel:+221{{ $membre->telephone }}">{{ $membre->telephone }}</a></td>
                                            <td class="text-center"><span
                                                    class="text-primary fw-bold">{{ count($membre?->commissionagrements) }}</span>
                                            </td>
                                            <td style="text-align: center;">
                                                <span class="d-flex mt-2 align-items-baseline"><a
                                                        href="{{ route('commissionmembres.show', $membre->id) }}"
                                                        class="btn btn-warning btn-sm mx-1" title="Voir détails">
                                                        <i class="bi bi-eye"></i></a>
                                                    <div class="filter">
                                                        <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                                                class="bi bi-three-dots"></i></a>
                                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                            <li>
                                                                <button type="button" class="dropdown-item btn btn-sm mx-1"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#EditmembreModal{{ $membre->id }}">
                                                                    <i class="bi bi-pencil" title="Modifier"></i> Modifier
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <form
                                                                    action="{{ route('commissionmembres.destroy', $membre->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item show_confirm"><i
                                                                            class="bi bi-trash"></i>Supprimer</button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </span>
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

            <!-- Add membre -->
            <div class="modal fade" id="AddmembresjuryModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="{{ route('commissionmembres.store') }}" enctype="multipart/form-data"
                            class="row g-3">
                            @csrf
                            <div class="card-header text-center bg-gradient-default">
                                <h1 class="h4 text-black mb-0">Ajouter membre</h1>
                            </div>
                            <div class="modal-body">
                                <div class="form-floating mb-3">
                                    <input type="text" name="civilite" value="{{ old('civilite') }}"
                                        class="form-control form-control-sm @error('civilite') is-invalid @enderror"
                                        id="civilite" placeholder="M. ou Mme" autofocus>
                                    @error('civilite')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                    <label for="floatingInput">Civilité<span class="text-danger mx-1">*</span></label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="prenom" value="{{ old('prenom') }}"
                                        class="form-control form-control-sm @error('prenom') is-invalid @enderror"
                                        id="prenom" placeholder="prenom">
                                    @error('prenom')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                    <label for="floatingInput">Prénom<span class="text-danger mx-1">*</span></label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="nom" value="{{ old('nom') }}"
                                        class="form-control form-control-sm @error('nom') is-invalid @enderror" id="nom"
                                        placeholder="nom">
                                    @error('nom')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                    <label for="floatingInput">Nom<span class="text-danger mx-1">*</span></label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="fonction" value="{{ old('fonction') }}"
                                        class="form-control form-control-sm @error('fonction') is-invalid @enderror"
                                        id="fonction" placeholder="fonction">
                                    @error('fonction')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                    <label for="floatingInput">Fonction<span class="text-danger mx-1">*</span></label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="structure" value="{{ old('structure') }}"
                                        class="form-control form-control-sm @error('structure') is-invalid @enderror"
                                        id="structure" placeholder="structure">
                                    @error('structure')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                    <label for="floatingInput">Structure<span class="text-danger mx-1">*</span></label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control form-control-sm @error('email') is-invalid @enderror"
                                        id="email" placeholder="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                    <label for="floatingInput">Email<span class="text-danger mx-1">*</span></label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="number" name="telephone" min="0" value="{{ old('telephone') }}"
                                        class="form-control form-control-sm @error('telephone') is-invalid @enderror"
                                        id="telephone" placeholder="7xxxxxxxx">
                                    @error('telephone')
                                        <span class="invalid-feedback" role="alert">
                                            <div>{{ $message }}</div>
                                        </span>
                                    @enderror
                                    <label for="floatingInput">Téléphone<span class="text-danger mx-1">*</span></label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm"
                                    data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Add membre-->

            <!-- Edit membre -->
            @foreach ($membres as $membre)
                <div class="modal fade" id="EditmembreModal{{ $membre->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="EditmembreModalLabel{{ $membre->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" action="{{ route('commissionmembres.update', $membre->id) }}"
                                enctype="multipart/form-data" class="row g-3">
                                @csrf
                                @method('patch')
                                <div class="card-header text-center bg-gradient-default">
                                    <h1 class="h4 text-black mb-0">Modifier membre</h1>
                                </div>
                                <input type="hidden" name="id" value="{{ $membre->id }}">
                                <div class="modal-body">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="civilite"
                                            value="{{ $membre->civilite ?? old('civilite') }}"
                                            class="form-control form-control-sm @error('civilite') is-invalid @enderror"
                                            id="civilite" placeholder="M. ou Mme" autofocus>
                                        @error('civilite')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                        <label for="floatingInput">Civilité<span class="text-danger mx-1">*</span></label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" name="prenom" value="{{ $membre->prenom ?? old('prenom') }}"
                                            class="form-control form-control-sm @error('prenom') is-invalid @enderror"
                                            id="prenom" placeholder="prenom">
                                        @error('prenom')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                        <label for="floatingInput">Prénom<span class="text-danger mx-1">*</span></label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" name="nom" value="{{ $membre->nom ?? old('nom') }}"
                                            class="form-control form-control-sm @error('nom') is-invalid @enderror"
                                            id="nom" placeholder="nom">
                                        @error('nom')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                        <label for="floatingInput">Nom<span class="text-danger mx-1">*</span></label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" name="fonction"
                                            value="{{ $membre->fonction ?? old('fonction') }}"
                                            class="form-control form-control-sm @error('fonction') is-invalid @enderror"
                                            id="fonction" placeholder="fonction">
                                        @error('fonction')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                        <label for="floatingInput">Fonction<span class="text-danger mx-1">*</span></label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" name="structure"
                                            value="{{ $membre->structure ?? old('structure') }}"
                                            class="form-control form-control-sm @error('structure') is-invalid @enderror"
                                            id="structure" placeholder="structure">
                                        @error('structure')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                        <label for="floatingInput">Structure<span class="text-danger mx-1">*</span></label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="email" name="email" value="{{ $membre->email ?? old('email') }}"
                                            class="form-control form-control-sm @error('email') is-invalid @enderror"
                                            id="email" placeholder="email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                        <label for="floatingInput">Email<span class="text-danger mx-1">*</span></label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="number" name="telephone" min="0"
                                            value="{{ $membre->telephone ?? old('telephone') }}"
                                            class="form-control form-control-sm @error('telephone') is-invalid @enderror"
                                            id="telephone" placeholder="7xxxxxxxx">
                                        @error('telephone')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                        <label for="floatingInput">Téléphone<span class="text-danger mx-1">*</span></label>
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
            <!-- End Edit membre-->
        </section>
    @endcan
@endsection

@push('scripts')
    <script>
        new DataTable('#table-jury', {
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
