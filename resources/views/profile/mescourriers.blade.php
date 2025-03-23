@extends('layout.user-layout')
@section('title', 'MES COURRIERS')
@section('space-work')
    @can('dg')
        <section class="section faq">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mt-0">
                            <span class="d-flex align-items-baseline"><a href="{{ url('/profil') }}" class="btn btn-success btn-sm"
                                    title="retour"><i class="bi bi-arrow-counterclockwise"></i></a>&nbsp;
                                <p> | retour</p>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="d-flex align-items-baseline">
                                <h5 class="card-title">Mes courriers</h5>
                            </span>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                            @php
                                $user = Auth::user();
                                $employee = $user?->employee;
                            @endphp
                            @if ($user?->employee)
                                @if ($employee?->arrives?->isNotEmpty())
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="table-courriers-emp">
                                            <thead class="table-default">
                                                <tr>
                                                    <th style="width:40%;">Imputations</th>
                                                    <th style="width:15%;" class="text-center">Instructions DG</th>
                                                    {{-- <th style="width:10%;">Suivi dossier</th> --}}
                                                    <th class="text-center">
                                                        @unless (auth()->user()->unReadNotifications->isEmpty())
                                                            <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                                                                <i class="bi bi-bell"></i>
                                                                <span
                                                                    class="badge bg-primary badge-number">{!! auth()->user()->unReadNotifications->count() !!}</span>
                                                            </a><!-- End Notification Icon -->
                                                            <ul
                                                                class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                                                                <li class="dropdown-header">
                                                                    {!! auth()->user()->unReadNotifications->count() !!} nouveaux commentaires non lus
                                                                    <a href="{{ url('notifications') }}" target="_blank"><span
                                                                            class="badge rounded-pill bg-primary p-2 ms-2">Voir
                                                                            tous</span></a>
                                                                </li>
                                                            </ul>
                                                        @endunless
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach (Auth::user()->employee?->arrives as $arrive)
                                                    <?php
                                                    $i = 1;
                                                    $x = 0;
                                                    $y = 0;
                                                    $z = 0;
                                                    $xy = 0;
                                                    $xz = 0;
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            {{-- @if (isset($arrive?->courrier) && $arrive?->courrier?->type == 'arrive') --}}
                                                            <p><b>N° courrier</b> : {{ $arrive?->numero_arrive }}</p>
                                                            <p><b>Objet</b> : <a
                                                                    href="{!! route('arrives.show', $arrive?->id) !!}">{!! $arrive?->courrier?->objet ?? '' !!}</a>
                                                            </p>
                                                            <p><b>Expéditeur</b> : {{ $arrive?->courrier?->expediteur }}</p>
                                                            @if (isset($arrive->courrier->file))
                                                                <label for="reference" class="form-label">Scan courrier :
                                                                </label>
                                                                <a class="btn btn-outline-secondary btn-sm"
                                                                    title="télécharger le fichier joint" target="_blank"
                                                                    href="{{ asset($arrive->courrier->getFile()) }}">
                                                                    <i class="bi bi-download"></i>
                                                                </a>
                                                            @endif
                                                            {{-- @endif --}}
                                                            <p>{!! $arrive?->courrier?->message !!}</p>
                                                            {{-- <p><strong>Type de courrier : </strong> {!! $arrive?->courrier?->type ?? '' !!}</p> --}}
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                {{-- format('d/m/Y à H:i:s') --}}
                                                                <small><b>Date imputation</b> :
                                                                    {{-- {!! Carbon\Carbon::parse($arrive?->courrier?->date_imp)?->translatedFormat('l jS F Y') !!} --}}
                                                                    {!! ($arrive?->courrier?->date_imp)?->diffForHumans(null, false) !!}
                                                                </small>
                                                                <span
                                                                    class="badge badge-info">{!! $arrive?->courrier?->user?->firstname !!}&nbsp;{!! $arrive?->courrier?->user?->name !!}</span>
                                                            </div>
                                                        </td>
                                                        <td class="vertical-align-middle text-center">
                                                            <p>{!! remove_accents_uppercase($arrive?->courrier->description) ?? '' !!}</p>
                                                        </td>
                                                        {{-- <td>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        @foreach ($arrive?->employees->unique('id') as $employee)
                                                            {{ $employee->user->firstname . ' ' . $employee->user->name }}<br>
                                                        @endforeach
                                                    </div>
                                                </td> --}}
                                                        <td>
                                                            <h5 class="card-title">Commentaires
                                                                ({{ count($arrive->courrier->comments) }})
                                                            </h5>
                                                            @forelse ($arrive->courrier->comments as $comment)
                                                                <div class="accordion accordion-flush"
                                                                    id="accordionFlushExample">
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header"
                                                                            id="flush-heading{{ $x++ }}">
                                                                            <button class="accordion-button collapsed"
                                                                                type="button" data-bs-toggle="collapse"
                                                                                data-bs-target="#flush-collapse{{ $z++ }}"
                                                                                aria-expanded="false"
                                                                                aria-controls="flush-collapse{{ $xy++ }}">
                                                                                Commentaire # {{ $i++ }}
                                                                            </button>
                                                                        </h2>
                                                                        <div id="flush-collapse{{ $xz++ }}"
                                                                            class="accordion-collapse collapse"
                                                                            aria-labelledby="flush-heading{{ $y++ }}"
                                                                            data-bs-parent="#accordionFlushExample">
                                                                            <div class="accordion-body">
                                                                                <span>{!! $comment?->user?->firstname . ' ' . $comment?->user?->name !!}</span>
                                                                                <div class="activity">
                                                                                    <div
                                                                                        class="activity-item d-flex col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                                                                        <div
                                                                                            class="activite-label col-2 col-md-2 col-lg-2 col-sm-2 col-xs-2 col-xxl-2">
                                                                                            {!! Carbon\Carbon::parse($comment?->created_at)?->diffForHumans() !!}
                                                                                        </div>
                                                                                        &nbsp;
                                                                                        <i
                                                                                            class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                                                                        &nbsp;
                                                                                        <div
                                                                                            class="activity-content col-10 col-md-10 col-lg-10 col-sm-10 col-xs-10 col-xxl-10">
                                                                                            {!! $comment->content !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                                $a = 1;
                                                                                $b = '1a';
                                                                                $c = '1a';
                                                                                $d = '1a';
                                                                                $e = '1a';
                                                                                $f = '1a';
                                                                                ?>
                                                                                <h5 class="card-title">Réponses au
                                                                                    commentaire #
                                                                                    {{ $i - 1 }}</h5>
                                                                                <div class="activity">
                                                                                    @forelse ($comment->comments as $replayComment)
                                                                                        <div
                                                                                            class="row col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                                                                                            <label for=""
                                                                                                class="col-1 col-md-1 col-lg-1 col-sm-1 col-xs-1 col-xxl-1"></label>
                                                                                            <div
                                                                                                class="col-11 col-md-11 col-lg-11 col-sm-11 col-xs-11 col-xxl-11">

                                                                                                <h2 class="accordion-header"
                                                                                                    id="flush-heading{{ $b++ }}">
                                                                                                    <button
                                                                                                        class="accordion-button collapsed"
                                                                                                        type="button"
                                                                                                        data-bs-toggle="collapse"
                                                                                                        data-bs-target="#flush-collapse{{ $d++ }}"
                                                                                                        aria-expanded="false"
                                                                                                        aria-controls="flush-collapse{{ $e++ }}">
                                                                                                        Réponse #
                                                                                                        {{ $a++ }}
                                                                                                    </button>
                                                                                                </h2>
                                                                                                {{-- <h5 class="card-title">
                                                                                                Réponse
                                                                                                {!! $replayComment?->user?->firstname . ' ' . $replayComment?->user?->name !!}<span></span>
                                                                                            </h5> --}}

                                                                                                <div id="flush-collapse{{ $f++ }}"
                                                                                                    class="accordion-collapse collapse"
                                                                                                    aria-labelledby="flush-heading{{ $c++ }}"
                                                                                                    data-bs-parent="#accordionFlushExample">
                                                                                                    <div class="accordion-body">
                                                                                                        <span>{!! $comment?->user?->firstname . ' ' . $comment?->user?->name !!}</span>
                                                                                                        <div
                                                                                                            class="activity-item d-flex">
                                                                                                            <div
                                                                                                                class="activite-label col-3 col-md-3 col-lg-3 col-sm-3 col-xs-3 col-xxl-3">
                                                                                                                {{-- <span class="fw-bold text-dark"></span> --}}
                                                                                                                {!! Carbon\Carbon::parse($replayComment?->created_at)?->diffForHumans() !!}
                                                                                                            </div>
                                                                                                            &nbsp;
                                                                                                            <i
                                                                                                                class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                                                                                                            &nbsp;
                                                                                                            <div
                                                                                                                class="activity-content col-8 col-md-8 col-lg-8 col-sm-8 col-xs-8 col-xxl-8">
                                                                                                                {!! $replayComment?->content !!}
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @empty
                                                                                        <div class="alert alert-info">
                                                                                            Aucune
                                                                                            réponse à ce commentaire</div>
                                                                                    @endforelse
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @empty

                                                                <div class="alert alert-info">Aucun commentaire pour ce
                                                                    courrier
                                                                </div>
                                                            @endforelse

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-info"> {{ __("Vous n'avez pas de courrier à votre nom") }}
                                    </div>
                                @endif
                            @else
                                <div class="alert alert-info"> {{ __("Vous n'êtes pas encore employé(e)") }} </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endcan
    </div>
@endsection

@push('scripts')
    <script>
        new DataTable('#table-courriers-emp', {
            /* layout: {
                topStart: {
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                }
            }, */
            "order": [
                [0, 'desc']
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
