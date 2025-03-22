@extends('layout.user-layout')
@section('title', 'Demande individuelle de ' . Auth::user()->civilite . ' ' . Auth::user()->firstname . ' ' .
    Auth::user()->name)
@section('space-work')
    <section class="section profile">
        <div class="row justify-content-center">
            <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                @if ($message = Session::get('status'))
                    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" region="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($message = Session::get('success'))
                    <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show"
                        region="alert">
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
                    <div class="card-header text-center bg-gradient-default">
                        <h1 class="h4 text-black mb-0">Formation programmée</h1>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="d-flex align-items-baseline"><a href="{{ route('profil') }}"
                                    class="btn btn-success btn-sm" title="retour"><i
                                        class="bi bi-arrow-counterclockwise"></i></a>&nbsp;
                                <p> | retour</p>
                            </span>
                        </div>

                        <h5 class="card-title"><strong><em>! <u>IMPORTANT</u></strong></em></h5>
                        <p class="fst-italic">Cher(e)
                            <strong><em>{{ Auth::user()->firstname . ' ' . Auth::user()->name }}</em></strong>, <br>
                            veuillez lire attentivement les informations relatives à la formation. Afin de garantir
                            votre place, il est essentiel de <span
                                class="bg bg-success text-white"><em>confirmer</em></span>
                            votre présence. <br>
                            Si vous ne souhaitez pas y participer,
                            n’oubliez pas de <span class="bg bg-danger text-white"><em>décliner</em></span> votre
                            invitation.
                        </p>

                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">

                                {{-- <h5 class="card-title">Informations</h5> --}}

                                <?php $i = 1; ?>
                                @foreach ($nouvelle_formations as $individuelle)
                                    <div class="d-flex align-items-baseline mb-2">
                                        <h5 class="card-title">Formation {{ $i++ }} :
                                            @if (!empty($individuelle?->formation?->module?->name))
                                                {{ $individuelle?->formation?->module?->name }}
                                            @elseif(!empty($individuelle?->formation->collectivemodule->module))
                                                {{ $individuelle?->formation->collectivemodule->module }}
                                            @else
                                                Aucun
                                            @endif
                                        </h5>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Statut</div>
                                        <div class="col-lg-9 col-md-8">
                                            @if (!empty($individuelle?->confirmation))
                                                <span
                                                    class="{{ $individuelle?->confirmation }}">{{ $individuelle?->confirmation }}
                                                </span>
                                            @else
                                                <div class="col-lg-9 col-md-8 alert alert-warning">Aucune confirmation !
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    @if (!empty($individuelle?->motif_declinaison))
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label ">Motif</div>
                                            <div class="col-lg-9 col-md-8">
                                                <span class="badge border-danger border-1 text-danger">{{ $individuelle?->motif_declinaison }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Bénéficiaires</div>
                                        <div class="col-lg-9 col-md-8">{{ $individuelle?->formation?->name }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Opérateur</div>
                                        @if (!empty($individuelle?->formation?->operateur?->user?->operateur))
                                            <div class="col-lg-9 col-md-8">
                                                {{ $individuelle?->formation?->operateur?->user?->operateur }}
                                                @if (!empty($individuelle?->formation?->operateur?->user?->username))
                                                    <strong><em>{{ '(' . $individuelle?->formation?->operateur?->user?->username . ')' }}</em></strong>
                                                @endif
                                            </div>
                                        @else
                                            <div class="col-lg-9 col-md-8">Aucun</div>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Date début</div>
                                        @if (!empty($individuelle?->formation?->date_debut))
                                            <div class="col-lg-9 col-md-8">
                                                {{ $individuelle?->formation?->date_debut->format('d/m/Y') }}
                                            </div>
                                        @else
                                            <div class="col-lg-9 col-md-8">Non définie</div>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Date fin</div>
                                        @if (!empty($individuelle?->formation?->date_fin))
                                            <div class="col-lg-9 col-md-8">
                                                {{ $individuelle?->formation?->date_fin->format('d/m/Y') }}
                                            </div>
                                        @else
                                            <div class="col-lg-9 col-md-8">Non définie</div>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Durée</div>
                                        @if (!empty($individuelle?->formation?->duree_formation))
                                            <div class="col-lg-9 col-md-8">
                                                {{ $individuelle?->formation?->duree_formation . ' jours' }}
                                            </div>
                                        @else
                                            <div class="col-lg-9 col-md-8">Non définie</div>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Lieu formation</div>
                                        @if (!empty($individuelle?->formation?->lieu))
                                            <div class="col-lg-9 col-md-8">
                                                {{ $individuelle?->formation?->lieu . ', ' . $individuelle?->formation?->departement?->nom }}
                                            </div>
                                        @else
                                            <div class="col-lg-9 col-md-8">Aucun</div>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Type de diplôme</div>
                                        @if (!empty($individuelle?->formation?->referentiel?->titre))
                                            <div class="col-lg-9 col-md-8">
                                                @if ($individuelle?->formation?->referentiel?->titre == 'Attestation')
                                                    {{ $individuelle?->formation?->referentiel?->titre }}
                                                @else
                                                    {{ $individuelle?->formation?->referentiel?->titre }}
                                                    @if (!empty($individuelle?->formation?->referentiel?->categorie))
                                                        {{ ', ' . $individuelle?->formation?->referentiel?->categorie }}
                                                    @endif
                                                    @if (!empty($individuelle?->formation?->referentiel?->convention?->name))
                                                        {{ ', de la ' . $individuelle?->formation?->referentiel?->convention?->name }}
                                                    @endif
                                                @endif
                                            </div>
                                        @else
                                            <div class="col-lg-9 col-md-8">Aucun</div>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-baseline mb-2">
                                        @switch($individuelle?->confirmation)
                                            @case('décliner')
                                                <form action="{{ route('confirmer', $individuelle?->id) }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <button
                                                        class="show_confirm_valider btn btn-success btn-sm mx-1">Confirmer</button>
                                                </form>
                                            @break

                                            @case('confirmer')
                                                <button class="btn btn-danger btn-sm mx-1" data-bs-toggle="modal"
                                                    data-bs-target="#declinerFormation{{ $individuelle?->id }}">
                                                    Décliner
                                                </button>
                                            @break

                                            @default
                                                <button class="btn btn-danger btn-sm mx-1" data-bs-toggle="modal"
                                                    data-bs-target="#declinerFormation{{ $individuelle?->id }}">
                                                    Décliner
                                                </button>
                                                <form action="{{ route('confirmer', $individuelle?->id) }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <button
                                                        class="show_confirm_valider btn btn-success btn-sm mx-1">Confirmer</button>
                                                </form>
                                        @endswitch
                                    </div>

                                    <div class="modal fade" id="declinerFormation{{ $individuelle?->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <form method="post" action="{{ route('decliner', $individuelle?->id) }}"
                                                    enctype="multipart/form-data" class="row">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="card-header text-center bg-gradient-default">
                                                        <h1 class="h4 text-black mb-0">Indisponibilité</h1>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label for="motif" class="form-label">Décliner formation<span
                                                                class="text-danger mx-1">*</span></label>
                                                        <textarea name="motif" id="motif" rows="3"
                                                            class="form-control form-control-sm @error('motif') is-invalid @enderror"
                                                            placeholder="Expliquer pourquoi vous ne souhaitez pas y participer">{{ $individuelle?->motif_declinaison ?? old('motif') }}</textarea>
                                                        @error('motif')
                                                            <span class="invalid-feedback" role="alert">
                                                                <div>{{ $message }}</div>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            data-bs-dismiss="modal">Fermer</button>
                                                        <button type="submit"
                                                            class="btn btn-danger btn-sm">Décliner</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div><!-- End Bordered Tabs -->

                    </div>

                </div>
            </div>
        </div>
        {{-- @foreach ($nouvelle_formations as $individuelle)
            <div class="modal fade" id="declinerFormation{{$individuelle?->id}}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form method="post" action="{{ route('decliner', $individuelle?->id) }}"
                            enctype="multipart/form-data" class="row">
                            @csrf
                            @method('PUT')
                            <div class="card-header text-center bg-gradient-default">
                                <h1 class="h4 text-black mb-0">Indisponibilité</h1>
                            </div>
                            <div class="modal-body">
                                <label for="motif" class="form-label">Décliner formation<span
                                        class="text-danger mx-1">*</span></label>
                                <textarea name="motif" id="motif" rows="3"
                                    class="form-control form-control-sm @error('motif') is-invalid @enderror"
                                    placeholder="Expliquer pourquoi vous ne souhaitez pas y participer">{{ $individuelle?->motif_declinaison ?? old('motif') }}</textarea>
                                @error('motif')
                                    <span class="invalid-feedback" role="alert">
                                        <div>{{ $message }}</div>
                                    </span>
                                @enderror
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm"
                                    data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-danger btn-sm">Décliner</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach --}}
    </section>
@endsection
