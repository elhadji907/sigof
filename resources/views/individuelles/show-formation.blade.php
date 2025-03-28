@extends('layout.user-layout')
@section('title', 'Formation de ' . Auth::user()->civilite . ' ' . Auth::user()->firstname . ' ' . Auth::user()->name)
@section('space-work')
    <section class="section">
        <div class="row justify-content-center">
            <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                <div class="card">
                    <div class="card-header text-center bg-gradient-default">
                        <h1 class="h4 text-black mb-0">FORMATIONS</h1>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mt-0">
                            <span class="d-flex align-items-baseline"><a href="{{ url('/profil') }}"
                                    class="btn btn-success btn-sm" title="retour"><i
                                        class="bi bi-arrow-counterclockwise"></i></a>&nbsp;
                                <p> | retour</p>
                            </span>
                        </div>
                        <h5 class="card-title">
                            Bonjour {{ Auth::user()->civilite . ' ' . Auth::user()->firstname . ' ' . Auth::user()->name }}
                        </h5>
                        @if (!empty($formation_count))
                            <table class="table table-bordered table-hover table-borderless">
                                <thead>
                                    <tr>
                                        <th width='6%' class="text-center">Code</th>
                                        <th>Bénéficiaires</th>
                                        <th width='15%'>Localité</th>
                                        <th width='20%'>Modules</th>
                                        <th width='10%'>Type certification</th>
                                        <th width='5%' class="text-center">Statut</th>
                                        <th width='5%' class="text-center">Diplômes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($individuelles as $individuelle)
                                        <tr>
                                            <td style="text-align: center">{{ $individuelle?->formation?->code }}</td>
                                            <td>{{ $individuelle?->formation?->name }}</td>
                                            <td>{{ $individuelle?->formation->departement?->region?->nom }}</td>
                                            <td>{{ $individuelle?->formation?->module?->name }}</td>
                                            <td>{{ $individuelle?->formation->type_certification }}</td>
                                            <td class="text-center"><a><span
                                                        class="{{ $individuelle?->formation?->statut }}">{{ $individuelle?->formation?->statut }}</span></a>
                                            </td>
                                            {{-- <td class="text-center"><span
                                                class="{{ $individuelle->formation?->attestation }}">{{ $individuelle?->formation?->attestation }}</span></td> --}}
                                            <td style="text-align: center; vertical-align: middle;">
                                                @if (!empty($individuelle?->formation?->attestation))
                                                    @if (!empty($individuelle?->retrait_diplome))
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#EditShowModal{{ $individuelle?->id }}">
                                                            <i class="bi bi-check-circle text-success"
                                                                title="diplôme retiré"></i>
                                                        </a>
                                                    @else
                                                        <i class="bi bi-x text-danger" title="diplôme non retiré"></i>
                                                    @endif
                                                @else
                                                    <i class="bi bi-x text-danger" title="non disponible"></i>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-info">Vous n'avez bénéficié d'aucune formation pour le moment !!
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @foreach ($individuelles as $individuelle)
            <div class="modal fade" id="EditShowModal{{ $individuelle->id }}" tabindex="-1" role="dialog"
                aria-labelledby="EditShowModalLabel{{ $individuelle->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="card-header text-center bg-gradient-default">
                            <h4 class="h4 text-black mb-0">
                                {{ strtoupper($individuelle?->formation?->type_certification) }}
                            </h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" value="{{ $individuelle->id }}">
                            <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                <div class="row g-3">
                                    <label for="retrait" class="form-label">Informations !<span
                                            class="text-danger mx-1">*</span></label>
                                    <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                        <label class="form-check-label" for="moi">
                                            {{ 'Retrait effectué par ' . $individuelle?->retrait_diplome }}
                                        </label>

                                    </div>

                                </div>
                            </div>
                        </div>
                        {{-- <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-primary">
                                    Valider</button>
                            </div>
                        </form> --}}
                    </div>
                </div>
            </div>
        @endforeach
    </section>
@endsection
