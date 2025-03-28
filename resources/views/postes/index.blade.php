@extends('layout.user-layout')

@section('space-work')
    <div class="container">
        <div class="justify-content-center">
            <section class="section dashboard">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show"
                            role="alert"><strong>{{ $error }}</strong></div>
                    @endforeach
                @endif
                <div class="row">
                    <!-- Left side columns -->
                    <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                        <div class="card">
                            <div class="card-body pb-0">
                                @if (auth()->user()->hasRole('super-admin|admin|COM'))
                                    <div class="pt-1">
                                        <button type="button" class="btn btn-primary btn-sm float-end btn-rounded"
                                            data-bs-toggle="modal" data-bs-target="#AddPosteModal">Ajouter</button>
                                    </div>
                                @endif
                                <h5 class="card-title">Posts <span>| les plus récents</span></h5>
                                <div class="news mb-5">
                                    @foreach ($postes as $poste)
                                        <div class="post-item clearfix">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <img src="{{ asset($poste->getPoste()) }}" class="w-20"
                                                        alt="{{ $poste->legende }}" data-bs-toggle="modal"
                                                        data-bs-target="#ShowPostModal{{ $poste->id }}">
                                                    <h4><a href="#">{{ $poste->titre }}</a></h4>
                                                    <p>{{ substr($poste->name, 0, 250) }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <span class="d-flex mt-2 align-items-baseline">
                                                        <button type="button" class="dropdown-item btn btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#EditPostModal{{ $poste->id }}">
                                                            <i class="bi bi-pencil" title="Modifier"></i>
                                                        </button>

                                                        <form action="{{ route('postes.destroy', $poste->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="dropdown-item show_confirm btn btn-sm"
                                                                title="Supprimer"><span style="color: red"><i
                                                                        class="bi bi-trash"></i>
                                                                </span></button>
                                                        </form>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div
                class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12 d-flex flex-column align-items-center justify-content-center">
                <div class="modal fade" id="AddPosteModal" tabindex="-1">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <form method="post" action="{{ route('postes.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-header text-center bg-gradient-default">
                                    <h1 class="h4 text-black mb-0">CRÉER UN POST</h1>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <input type="hidden" name="users_id" value="{{ Auth::user()->id }}">
                                        
                                        <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                            <label for="titre" class="form-label">Titre<span
                                                class="text-danger mx-1">*</span></label>
                                            <textarea name="titre" id="titre" rows="1"
                                                class="form-control form-control-sm @error('titre') is-invalid @enderror" placeholder="Titre">{{ old('titre') }}</textarea>
                                            @error('titre')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                            <label for="name" class="form-label">Post<span
                                                    class="text-danger mx-1">*</span></label>
                                            <textarea name="name" id="name" rows="3"
                                                class="form-control form-control-sm @error('name') is-invalid @enderror" placeholder="Ecrire votre poste ici">{{ old('name') }}</textarea>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                                            <label for="legende" class="form-label">Légende</label>
                                            <textarea name="legende" id="legende" rows="1"
                                                class="form-control form-control-sm @error('legende') is-invalid @enderror" placeholder="Légende">{{ old('legende') }}</textarea>
                                            @error('legende')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                                            <label for="image" class="form-label">Image<span
                                                    class="text-danger mx-1">*</span></label>
                                            <input type="file" name="image" value="{{ old('image') }}" accept=".jpg, .jpeg, .png, .svg, .gif"
                                                class="form-control form-control-sm @error('image') is-invalid @enderror"
                                                id="image" placeholder="Image">
                                            @error('image')
                                                <span class="invalid-feedback" role="alert">
                                                    <div>{{ $message }}</div>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="modal-footer mt-5">
                                        <button type="button" class="btn btn-secondary btn-sm"
                                            data-bs-dismiss="modal">Fermer</button>
                                        <button type="submit" class="btn btn-primary btn-sm">POSTER</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @foreach ($postes as $poste)
                <div
                    class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12 d-flex flex-column align-items-center justify-content-center">
                    <div class="modal fade" id="ShowPostModal{{ $poste->id }}" tabindex="-1">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <form method="post" action="#" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-header text-center bg-gradient-default">
                                        <h1 class="h4 text-black mb-0">{{ $poste->legende }}</h1>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-3">

                                            <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                                <img src="{{ asset($poste->getPoste()) }}" class="d-block w-100"
                                                    alt="{{ $poste->legende }}">
                                            </div>
                                            <p>{{ $poste->name }}
                                            </p>

                                        </div>
                                        <div class="modal-footer mt-5">
                                            <button type="button" class="btn btn-secondary btn-sm"
                                                data-bs-dismiss="modal">Fermer</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @foreach ($postes as $poste)
                <div
                    class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12 d-flex flex-column align-items-center justify-content-center">
                    <div class="modal fade" id="EditPostModal{{ $poste->id }}" tabindex="-1">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <form method="post" action="{{ route('postes.update', $poste->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-header text-center bg-gradient-default">
                                        <h1 class="h4 text-black mb-0">MODIFICATION POST</h1>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-3">


                                            <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                                <label for="titre" class="form-label">Titre<span
                                                    class="text-danger mx-1">*</span><span
                                                        class="text-danger mx-1">*</span></label>
                                                <textarea name="titre" id="titre" rows="1"
                                                    class="form-control form-control-sm @error('titre') is-invalid @enderror" placeholder="Titre">{{ $poste?->titre ?? old('titre') }}</textarea>
                                                @error('titre')
                                                    <span class="invalid-feedback" role="alert">
                                                        <div>{{ $message }}</div>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                                <label for="name" class="form-label">Poste<span
                                                        class="text-danger mx-1">*</span></label>
                                                <textarea name="name" id="name" rows="3"
                                                    class="form-control form-control-sm @error('name') is-invalid @enderror" placeholder="Ecrire votre poste ici">{{ $poste->name ?? old('name') }}</textarea>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <div>{{ $message }}</div>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-6">
                                                <label for="legende" class="form-label">Légende</label>
                                                <textarea name="legende" id="legende" rows="1"
                                                    class="form-control form-control-sm @error('legende') is-invalid @enderror" placeholder="Légende">{{ $poste->legende ?? old('legende') }}</textarea>
                                                @error('legende')
                                                    <span class="invalid-feedback" role="alert">
                                                        <div>{{ $message }}</div>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-12 col-md-12 col-lg-5 col-sm-12 col-xs-12 col-xxl-5">
                                                <label for="image" class="form-label">Image<span
                                                        class="text-danger mx-1">*</span></label>
                                                <input type="file" name="image" value="{{ old('image') }}" accept=".jpg, .jpeg, .png, .svg, .gif"
                                                    class="form-control form-control-sm @error('image') is-invalid @enderror"
                                                    id="image" placeholder="Image">
                                                @error('image')
                                                    <span class="invalid-feedback" role="alert">
                                                        <div>{{ $message }}</div>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-12 col-md-12 col-lg-1 col-sm-12 col-xs-12 col-xxl-1">
                                                <br>
                                                @if (!empty($poste->image))
                                                    <div>
                                                        <img class="w-50" alt="Profil"
                                                            src="{{ asset($poste->getPoste()) }}" width="50"
                                                            height="auto">
                                                    </div>
                                                @else
                                                    <div class="badge bg-warning">Aucun</div>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="modal-footer mt-5">
                                            <button type="button" class="btn btn-secondary btn-sm"
                                                data-bs-dismiss="modal">Fermer</button>
                                            <button type="submit" class="btn btn-primary btn-sm">POSTER</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
