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
                                        <th width='15%'>Type formation</th>
                                        <th>Bénéficiaires</th>
                                        <th width='15%'>Localité</th>
                                        <th width='5%'>Modules</th>
                                        <th width='17%'>Type certification</th>
                                        <th width='5%' class="text-center">Statut</th>
                                        <th width='8%' class="text-center">Diplômes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($individuelles as $individuelle)
                                        <tr>
                                            <td style="text-align: center">{{ $individuelle?->formation?->code }}</td>
                                            <td>{{ $individuelle->formation->types_formation?->name }}</td>
                                            <td>{{ $individuelle->formation?->name }}</td>
                                            <td>{{ $individuelle->formation->departement?->region?->nom }}</td>
                                            <td>{{ $individuelle->formation?->module?->name }}</td>
                                            <td>{{ $individuelle->formation->type_certification }}</td>
                                            <td class="text-center"><a><span
                                                        class="{{ $individuelle->formation?->statut }}">{{ $individuelle->formation?->statut }}</span></a>
                                            </td>
                                            <td class="text-center"><span
                                                class="{{ $individuelle->formation?->attestation }}">{{ $individuelle?->formation?->attestation }}</span></td>
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
    </section>
@endsection
