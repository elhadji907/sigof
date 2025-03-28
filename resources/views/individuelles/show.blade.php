@extends('layout.user-layout')
@section('title', 'DETAILS DEMANDE DE ' . $individuelle->user->firstname . ' ' . $individuelle->user->name)
@section('space-work')
    <section class="section min-vh-0 d-flex flex-column align-items-center justify-content-center py-0 section profile">
        <div class="container-fluid">
            <div class="row justify-content-center">
                @if ($message = Session::get('status'))
                    <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show"
                        role="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                        <strong>{{ $error }}</strong>
                    </div>
                @endforeach

                <div class="col-12 d-flex flex-column align-items-center justify-content-center">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                @php
                                    $isAdmin = auth()
                                        ->user()
                                        ->hasRole(['super-admin', 'admin', 'DIOF', 'DEC']);
                                    $route = $isAdmin ? route('individuelles.index') : route('demandesIndividuelle');
                                    $btnClass = $isAdmin ? 'btn-secondary' : 'btn-info';
                                @endphp

                                <span class="d-flex mt-2 align-items-baseline">
                                    <a href="{{ $route }}" class="btn {{ $btnClass }} btn-sm" title="Retour">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </a>&nbsp;
                                    <p> | Retour</p>
                                </span>

                                @if ($individuelle?->validationindividuelles->isNotEmpty())
                                    <span class="d-flex mt-2 align-items-baseline">
                                        <nav class="header-nav ms-auto">
                                            <ul class="d-flex align-items-center">
                                                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                                                    <i class="bi bi-chat-left-text m-1"></i>
                                                    <span class="badge bg-success badge-number"
                                                        title="{{ $individuelle?->statut }}">
                                                        {{ $individuelle?->validationindividuelles->count() }}
                                                    </span>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                                                    <li class="dropdown-header">
                                                        Vous avez {{ $individuelle?->validationindividuelles->count() }}
                                                        validation(s)
                                                        <a
                                                            href="{{ url('validationsRejetMessage/' . $individuelle?->id) }}">
                                                            <span class="badge rounded-pill bg-primary p-2 ms-2">Voir
                                                                toutes</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    @foreach ($individuelle?->validationindividuelles->take(2) as $validationindividuelle)
                                                        <li class="message-item">
                                                            <a
                                                                href="{{ url('validationsRejetMessage/' . $individuelle?->id) }}">
                                                                <img src="{{ asset($validationindividuelle->user->getImage()) }}"
                                                                    alt="" class="rounded-circle">
                                                                <div>
                                                                    <h4>{{ $validationindividuelle->user->firstname }}
                                                                        {{ $validationindividuelle->user->name }}</h4>
                                                                    <p><span
                                                                            class="{{ $validationindividuelle->action }}">{{ $validationindividuelle->action }}</span>
                                                                    </p>
                                                                    <p>{!! $validationindividuelle->created_at->diffForHumans() !!}</p>
                                                                </div>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                    @endforeach
                                                    <li class="dropdown-footer">
                                                        <form action="{{ route('validationmessage') }}" method="post"
                                                            target="_blank">
                                                            @csrf
                                                            {{-- @method('PUT') --}}
                                                            <input type="hidden" name="id"
                                                                value="{{ $individuelle?->id }}">
                                                            <button class="btn btn-sm mx-1">Voir
                                                                toutes les validations</button>
                                                        </form>
                                                        {{-- <a
                                                            href="{{ route('validationmessage/' . $individuelle?->id) }}">Voir
                                                            toutes les validations</a> --}}
                                                    </li>
                                                </ul>
                                            </ul>
                                        </nav>
                                    </span>
                                @endif

                                @can('user-view')
                                    <span class="d-flex align-items-baseline">
                                        <span class="{{ $individuelle?->statut }}">{{ $individuelle?->statut }}</span>
                                        <div class="filter">
                                            <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                                    class="bi bi-three-dots"></i></a>
                                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                <form
                                                    action="{{ route('validation-individuelles.update', $individuelle?->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="show_confirm_valider btn btn-sm mx-1">Accepter</button>
                                                </form>
                                                <button class="btn btn-sm mx-1" data-bs-toggle="modal"
                                                    data-bs-target="#RejetDemandeModal">Rejeter</button>
                                            </ul>
                                        </div>
                                    </span>
                                @endcan
                            </div>

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <form method="post" action="{{ url('individuelles/' . $individuelle?->id) }}"
                                    enctype="multipart/form-data" class="row g-3">
                                    @csrf
                                    @method('PUT')
                                    @foreach ([
            'Formation sollicitée' => $individuelle?->module?->name,
            'Numéro' => $individuelle?->numero,
            'Civilité' => $individuelle?->user?->civilite,
            'N° CIN' => $individuelle?->user?->cin,
            'Prénom' => $individuelle?->user?->firstname,
            'Nom' => $individuelle?->user?->name,
            'Date naissance' => $individuelle?->user?->date_naissance?->format('d/m/Y'),
            'Lieu naissance' => $individuelle?->user?->lieu_naissance,
            'Adresse' => $individuelle?->user?->adresse,
            'Email' => '<a href="mailto:' . $individuelle?->user?->email . '">' . $individuelle?->user?->email . '</a>',
            'Téléphone personnel' => '<a href="tel:+' . $individuelle?->user?->telephone . '">' . $individuelle?->user?->telephone . '</a>',
            'Téléphone secondaire' => '<a href="tel:+' . $individuelle?->telephone . '">' . $individuelle?->telephone . '</a>',
            'Lieu de formation' => $individuelle?->departement?->nom,
        ] as $label => $value)
                                        <div class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <div class="label">{{ $label }}</div>
                                            <div>{!! $value !!}</div>
                                        </div>
                                    @endforeach

                                    @if (!empty($individuelle?->diplome_academique))
                                        <div class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <div class="label">Diplôme académique</div>
                                            <div>{{ $individuelle?->diplome_academique }}</div>
                                        </div>
                                    @endif

                                    @if (!empty($individuelle?->autre_diplome_academique))
                                        <div class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <div class="label">Autre diplôme académique</div>
                                            <div>{{ $individuelle?->autre_diplome_academique }}</div>
                                        </div>
                                    @endif

                                    @if (!empty($individuelle?->option_diplome_academique))
                                        <div class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <div class="label">Option diplôme académique</div>
                                            <div>{{ $individuelle?->option_diplome_academique }}</div>
                                        </div>
                                    @endif

                                    @if (!empty($individuelle?->etablissement_academique))
                                        <div class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <div class="label">Etablissement d'obtention</div>
                                            <div>{{ $individuelle?->etablissement_academique }}</div>
                                        </div>
                                    @endif

                                    @if (!empty($individuelle?->diplome_professionnel))
                                        <div class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <div class="label">Diplôme professionnel</div>
                                            <div>{{ $individuelle?->diplome_professionnel }}</div>
                                        </div>
                                    @endif

                                    @if (!empty($individuelle?->autre_diplome_professionnel))
                                        <div class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <div class="label">Autre diplôme professionnel</div>
                                            <div>{{ $individuelle?->autre_diplome_professionnel }}</div>
                                        </div>
                                    @endif

                                    @if (!empty($individuelle?->specialite_diplome_professionnel))
                                        <div class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <div class="label">Spécialité</div>
                                            <div>{{ $individuelle?->specialite_diplome_professionnel }}</div>
                                        </div>
                                    @endif

                                    @if (!empty($individuelle?->etablissement_professionnel))
                                        <div class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <div class="label">Etablissement</div>
                                            <div>{{ $individuelle?->etablissement_professionnel }}</div>
                                        </div>
                                    @endif

                                    @if (!empty($individuelle?->projet_poste_formation))
                                        <div class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <div class="label">Projet poste formation</div>
                                            <div>{{ $individuelle?->projet_poste_formation }}</div>
                                        </div>
                                    @endif

                                    @if (!empty($individuelle?->qualification))
                                        <div class="col-12 col-md-4 col-lg-4 col-sm-12 col-xs-12 col-xxl-4">
                                            <div class="label">Qualification</div>
                                            <div>{{ $individuelle?->qualification }}</div>
                                        </div>
                                    @endif

                                    @if (!empty($individuelle?->experience))
                                        <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                            <div class="label">Expérience</div>
                                            <div>
                                                {!! '- ' .
                                                    implode('- ', array_map(fn($line) => nl2br(e($line)), explode("\n", ucfirst($individuelle?->experience)))) !!}
                                            </div>
                                        </div>
                                    @endif

                                    @if (!empty($individuelle?->projetprofessionnel))
                                        <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                            <div class="label">Projet professionnel</div>
                                            <div>
                                                {!! '- ' .
                                                    implode('- ', array_map(fn($line) => nl2br(e($line)), explode("\n", ucfirst($individuelle?->projetprofessionnel)))) !!}
                                            </div>
                                        </div>
                                    @endif

                                    <div class="text-center">
                                        <a href="{{ route('individuelles.edit', $individuelle?->id) }}"
                                            class="btn btn-primary btn-sm text-white" title="Modifier">Modifier</a>
                                    </div>
                                </form>
                                <div>
                                    <div class="col-md-4">
                                        <div class="label">FICHIERS JOINTS</div>
                                        {{-- @foreach (Auth::user()->files->whereNotNull('file') as $file) --}}
                                        @foreach ($files as $file)
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <!-- Affichage de la légende -->
                                                <p class="mb-0 me-3">{{ $file->legende }}</p>

                                                <!-- Bouton de téléchargement -->
                                                <a href="{{ asset($file->getFichier()) }}"
                                                    class="btn btn-sm btn-secondary" target="_blank">
                                                    Télécharger
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="RejetDemandeModal" tabindex="-1" aria-labelledby="RejetDemandeLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('validation-individuelles.destroy', $individuelle?->id) }}"
                            enctype="multipart/form-data" class="row">
                            @csrf
                            @method('DELETE')

                            <div class="card-header text-center bg-gradient-default">
                                <h1 class="h4 text-black mb-0">REJET</h1>
                            </div>

                            <div class="modal-body">
                                <label for="motif" class="form-label">Motifs du rejet</label>
                                <textarea name="motif" id="motif" rows="5"
                                    class="form-control form-control-sm @error('motif') is-invalid @enderror"
                                    placeholder="Enumérez les motifs du rejet" aria-describedby="motifHelp">{{ old('motif', $individuelle?->motif_retrait) }}</textarea>

                                @error('motif')
                                    <span class="invalid-feedback" role="alert">
                                        <div>{{ $message }}</div>
                                    </span>
                                @enderror
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm"
                                    data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-danger btn-sm">Rejeter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
@endsection
