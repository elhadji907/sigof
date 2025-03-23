@extends('layout.user-layout')
@section('title', 'Importer courriers arrivés')
@section('space-work')
    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @if ($message = Session::get('status'))
                    <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show"
                        role="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-12 pt-0">
                                <span class="d-flex mt-2 align-items-baseline"><a href="{{ route('arrives.index') }}"
                                        class="btn btn-success btn-sm" title="retour"><i
                                            class="bi bi-arrow-counterclockwise"></i></a>&nbsp;
                                    <p> | Liste des courriers arrivés</p>
                                </span>
                            </div>
                        </div>
                        <h5 class="card-title">
                            Importation des courriers arrivés
                        </h5>
                        {{-- <form action="{{ route('import.arrives') }}" method="POST" enctype="multipart/form-data"
                            class="row g-3">
                            @csrf
                            <div class="row">
                                <label for="file" class="form-label"><b>Fichier (.XLSX, .CSV, .XLS)<span
                                            class="text-danger mx-1">*</span></b></label>
                                <input type="file" name="file" value="{{ old('file') }}"
                                    class="form-control form-control-sm @error('file') is-invalid @enderror" id="file"
                                    placeholder="Fichier" autofocus>
                                @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <div>{{ $message }}</div>
                                    </span>
                                @enderror
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-sm">Importer</button>
                            </div>
                        </form> --}}

                        <form method="post" action="{{ route('import.arrives') }}" enctype="multipart/form-data"
                            class="row g-3">
                            @csrf
                            <table class="table table-bordered" id="dynamicAddRemove">
                                <tr>
                                    <th>
                                        Fichier (.XLSX, .CSV, .XLS)<span class="text-danger mx-1">*</span>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="file" name="file" value="{{ old('file') }}"
                                            class="form-control form-control-sm @error('file') is-invalid @enderror"
                                            id="file" placeholder="Fichier" autofocus>
                                        @error('file')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </td>
                                </tr>
                            </table>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-left mt-2">
                                <button type="submit" class="btn btn-primary btn-sm text-white">Importer</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
