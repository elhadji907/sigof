@extends('layout.user-layout')
@section('title', 'Mon dossier de demandes agréments')
@section('space-work')
    <section class="section">
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
                        <h1 class="h4 text-black mb-0">NOUVELLE DEMANDE AGREMENT</h1>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mt-0">
                            <span class="d-flex mt-2 align-items-baseline"><a href="{{ url('/profil') }}"
                                    class="btn btn-success btn-sm" title="retour"><i
                                        class="bi bi-arrow-counterclockwise"></i></a>&nbsp;
                                <p> | Profil</p>
                            </span>
                            @if (
                                !empty(Auth::user()?->operateur) &&
                                    !empty(Auth::user()?->username) &&
                                    !empty(Auth::user()?->ninea) &&
                                    !empty(Auth::user()?->rccm) &&
                                    !empty(Auth::user()?->fonction_responsable) &&
                                    !empty(Auth::user()?->email))
                                <button type="button" class="btn btn-info btn-sm">
                                    <span class="badge bg-white text-info">{{ $operateur_total }}</span>
                                </button>
                                @can('agrement-ouvert')
                                    <button type="button" class="btn btn-primary btn-sm float-end btn-rounded"
                                        data-bs-toggle="modal" data-bs-target="#AddoperateurModal">Ajouter
                                    </button>
                                @elsecan('agrement-fermer')
                                    <span class="text-danger small fw-bold">Les agréments sont actuellement
                                        <span class="text-uppercase">fermés</span></span>
                                @endcan
                            @endif
                        </div>

                        @if (
                            !empty(Auth::user()?->operateur) &&
                                !empty(Auth::user()?->username) &&
                                !empty(Auth::user()?->ninea) &&
                                !empty(Auth::user()?->rccm) &&
                                !empty(Auth::user()?->fonction_responsable) &&
                                !empty(Auth::user()?->email))
                            <div class="alert alert-info">Vous n'avez aucune demande agrément pour le moment !!
                            </div>
                        @else
                            <h5 class="card-title">Informations personnelles : <a href="{{ route('profil') }}"><span
                                        class="badge bg-warning text-white">Incomplètes</span></a>, cliquez <a
                                    href="{{ route('profil') }}">ici</a> pour modifier votre profil</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @can('agrement-ouvert')
            <div
                class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12 d-flex flex-column align-items-center justify-content-center">
                <div class="modal fade" id="AddoperateurModal" tabindex="-1">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="card-header text-center bg-gradient-default">
                                <h1 class="h4 text-black mb-0">AJOUTER AGREMENT</h1>
                            </div>
                            <form method="post" action="{{ route('operateurs.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                                            <label for="type_demande" class="form-label">Type demande<span
                                                    class="text-danger mx-1">*</span></label>
                                            <select name="type_demande"
                                                class="form-select form-select-sm @error('type_demande') is-invalid @enderror"
                                                aria-label="Select" id="select-field_type_demande"
                                                data-placeholder="Choisir type de demande">
                                                <option value="{{ old('type_demande') }}">
                                                    {{ old('type_demande') }}
                                                </option>
                                                <option value="Nouvelle">
                                                    Nouvelle
                                                </option>
                                                <option value="Renouvellement">
                                                    Renouvellement
                                                </option>
                                            </select>
                                            @error('type_demande')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                                            <label for="departement" class="form-label">Département<span
                                                    class="text-danger mx-1">*</span></label>
                                            <select name="departement"
                                                class="form-select form-select-sm @error('departement') is-invalid @enderror"
                                                aria-label="Select" id="select-field-departement_op" data-placeholder="Choisir">
                                                <option value="{{ old('departement') }}">{{ old('departement') }}</option>
                                                @foreach ($departements as $departement)
                                                    <option value="{{ $departement->nom }}">
                                                        {{ $departement->nom }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('departement')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                                            <label for="quitus" class="form-label">Quitus fiscal<span
                                                    class="text-danger mx-1">*</span></label>
                                            <input type="file" name="quitus" id="quitus"
                                                accept=".jpg, .jpeg, .png, .svg, .gif"
                                                class="form-control @error('quitus') is-invalid @enderror btn btn-outline-primary btn-sm">
                                            @error('quitus')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                                            <label for="date_quitus" class="form-label">Date visa quitus<span
                                                    class="text-danger mx-1">*</span></label>
                                            <input type="date" name="date_quitus" value="{{ old('date_quitus') }}"
                                                class="form-control form-control-sm @error('date_quitus') is-invalid @enderror"
                                                id="date_quitus" placeholder="Date quitus">
                                            @error('date_quitus')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="modal-footer mt-5">
                                        <button type="button" class="btn btn-secondary btn-sm"
                                            data-bs-dismiss="modal">Fermer</button>
                                        <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </section>
@endsection
