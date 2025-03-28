@extends('layout.user-layout')
@section('title', 'Modification module ' . $module->name)
@section('space-work')
    <section class="section">
        <div class="container-fluid"> <!-- Utilisation de container-fluid pour occuper toute la largeur -->
            <div class="pagetitle">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Accueil</a></li>
                        <li class="breadcrumb-item">Tables</li>
                        <li class="breadcrumb-item active">Données</li>
                    </ol>
                </nav>
            </div>

            @if ($message = Session::get('status'))
                <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
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

            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 pt-2">
                            <span class="d-flex mt-2 align-items-baseline">
                                <a href="{{ route('modules.index') }}" class="btn btn-success btn-sm" title="retour">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </a>&nbsp;
                                <p> | Liste des modules</p>
                            </span>
                        </div>
                    </div>
                    <form method="post" action="{{ route('modules.update', $module?->id) }}" enctype="multipart/form-data"
                        class="row g-3">
                        @csrf
                        @method('PUT')
                        <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                            <label for="name" class="form-label">Module<span class="text-danger mx-1">*</span></label>
                            <div class="input-group has-validation">
                                <input type="text" name="name" value="{{ $module->name ?? old('name') }}"
                                    class="form-control form-control-sm @error('name') is-invalid @enderror" id="name"
                                    placeholder="Module">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <div>{{ $message }}</div>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                            <label for="domaine" class="form-label">Domaine<span class="text-danger mx-1">*</span></label>
                            <select name="domaine" class="form-select  @error('domaine') is-invalid @enderror"
                                aria-label="Select" id="select-field-domaine-module" data-placeholder="Choisir domaine">
                                <option value="{{ $module?->domaine?->id }}">
                                    {{ $module?->domaine?->name ?? old('domaine') }}
                                </option>
                                @foreach ($domaines as $domaine)
                                    <option value="{{ $domaine?->id }}">
                                        {{ $domaine?->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                            <label for="niveau_qualification" class="form-label">Niveau de qualification<span
                                    class="text-danger mx-1">*</span></label>
                            <div class="input-group has-validation">
                                <input type="text" name="niveau_qualification"
                                    value="{{ old('niveau_qualification', $module->niveau_qualification ?? '') }}"
                                    class="form-control form-control-sm @error('niveau_qualification') is-invalid @enderror"
                                    placeholder="Exemple : Ouvrier, Technicien, Agent, Etc." autocomplete="off">
                                @error('niveau_qualification')
                                    <span class="invalid-feedback" role="alert">
                                        <div>{{ $message }}</div>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-sm">Enregistrer les modifications</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
