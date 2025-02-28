<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>{{ $title }}</title>

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon-onfp.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <style>
        /* @page {
            margin: 0cm 0cm;
        } */

        @page {
            size: 21cm 29.7cm;
            margin-top: 1cm;
            margin-bottom: 0cm;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding-top: 0px;
            padding-bottom: 25px;
            padding-left: 25px;
            padding-right: 25px;
            border: 0px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 13px;
            line-height: 22px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            /* color: #555; */
        }

        /** RTL **/
        .rtl {
            imputation: rtl;
        }

        .invoice-box table tr.heading td {
            background: rgb(255, 255, 255);
            border: 0px solid #000000;
            border-collapse: collapse;
            font-weight: bold;
        }


        .invoice-box table tr.total td {
            /* border-top: 2px solid #eee;
            border-bottom: 1px solid #eee;
            border-left: 1px solid #eee;
            border-right: 1px solid #eee; */
            /* background: #eee;
            font-weight: normal; */
        }

        /* .invoice-box table tr.item td {
            border: 1px solid #000000;
        } */

        table {
            /* border-left: 0px solid rgb(0, 0, 0);
            border-right: 0;
            border-top: 0px solid rgb(0, 0, 0);
            border-bottom: 0; */
            width: 100%;
            /* border-spacing: 0px; */
            border-collapse: collapse;
        }

        table td,
        table th {
            border-left: 1px solid rgb(0, 0, 0);
            border-right: 1px solid rgb(0, 0, 0);
            border-top: 1px solid rgb(0, 0, 0);
            border-bottom: 1px solid rgb(0, 0, 0);
            border: 1px solid;
        }

        .Oui {
            color: #198754;
            text-align: center;
        }

        .Non {
            color: #DC3545;
            padding: 4px 8px;
            text-align: center;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;

            /** Extra personal styles **/
            background-color: #ffffff;
            color: rgb(0, 0, 0);
            text-align: center;
            line-height: 1.5cm;
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//db.onlinewebfonts.com/c/dd79278a2e4c4a2090b763931f2ada53?family=ArialW02-Regular" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
@foreach ($operateurs as $operateur)

    <body>
        <div style="text-align: center;">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/entete.png'))) }}"
                style="width: 100%; max-width: 370px" />
        </div>
        {{-- <div class="invoice-box">
            <table>
                <thead>
                    <tr class="heading">
                        <td colspan="3" style="text-align: center;">
                            <small>
                                <b>REPUBLIQUE DU SENEGAL</b><br>
                                <small><em>Un Peuple - Un But - Une Foi</em></small><br>
                                ********<br>
                                <b>MINISTERE DE LA FORMATION PROFESSIONNELLE ET TECHNIQUE</b><br>
                                ********</small><br>
                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/logo-onfp.jpg'))) }}"
                                style="width: 100%; max-width: 370px" />
                        </td>
                        <td colspan="3"></td>
                        <td colspan="3" style="text-align: right;"></td>
                    </tr>
                </thead>
            </table>
        </div> --}}
        <h4 style="text-align: center;">AGREMENT OPERATEUR</h4>
        <div class="invoice-box">
            <b>Opérateur</b> :
            {{ $operateur?->user?->operateur . ' (' . $operateur?->user?->username . ')' }}
            <br>
            <b>Responsable</b> :
            {{ $operateur?->user?->firstname . ' ' . $operateur?->user?->name }}
            <br>
            <b>Adresse</b> :
            {{ $operateur?->user?->adresse }}
            <br>
            <b>Téléphone</b> :
            <a style="text-decoration:none" href="tel:+{{ $operateur?->user?->telephone }}">
                {{ substr($operateur?->user?->fixe, 0, 2) .
                    ' ' .
                    substr($operateur?->user?->fixe, 2, 3) .
                    ' ' .
                    substr($operateur?->user?->fixe, 5, 2) .
                    ' ' .
                    substr($operateur?->user?->fixe, 7, 2) }}

                {{ ' / ' .
                    substr($operateur?->user?->telephone, 0, 2) .
                    ' ' .
                    substr($operateur?->user?->telephone, 2, 3) .
                    ' ' .
                    substr($operateur?->user?->telephone, 5, 2) .
                    ' ' .
                    substr($operateur?->user?->telephone, 7, 2) }}
            </a>
            <br>
            <b>Email</b> :
            <a style="text-decoration:none"
                href="mailto:{{ $operateur?->user?->email }}">{{ $operateur?->user?->email }}</a>
            <br>
            Est agréé par l'ONFP sous le N°: <span
                style="color: #DC3545; font-weight: bold">{{ $operateur?->numero_agrement }}</span> <br><br>
            <table class="table table-responsive">
                <tbody>
                    <tr class="item" style="text-align: center;">
                        <td colspan="9"><b>{{ __('FORMATIONS AGRÉÉES') }}</b></td>
                    </tr>
                    <tr class="item" style="text-align: center;">
                        <td colspan="2" style="width:5cm"><b>{{ __('DOMAINES') }}</b></td>
                        <td colspan="2" style="width:8cm"><b>{{ __('MODULES / SPECIALITE') }}</b></td>
                        <td colspan="5" style="width:8cm">
                            <b>{{ __('TITRE OU NIVEAU DE QUALIFICATION CORRESPONDANT ') }}</b>
                        </td>
                    </tr>
                    {{-- @foreach ($operateur?->operateurmodules?->where('statut', 'agréer') as $operateurmodule)
                        <tr class="item" style="text-align: center;">
                            <td colspan="2">{{ $operateurmodule?->domaine }}</td>
                            <td colspan="2">{{ $operateurmodule?->module }}</td>
                            <td colspan="5">{{ $operateurmodule?->categorie }}</td>
                        </tr>
                    @endforeach --}}
                    <?php
                    $operateurmodules = $operateur?->operateurmodules?->where('statut', 'agréer') ?? collect();
                    ?>

                    @foreach ($operateurmodules as $operateurmodule)
                        <tr class="item" style="text-align: center;">
                            <td colspan="2">{{ $operateurmodule->domaine ?? 'Domaine non défini' }}</td>
                            <td colspan="2">{{ $operateurmodule->module ?? 'Module non défini' }}</td>
                            <td colspan="5">{{ $operateurmodule->categorie ?? 'Catégorie non définie' }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            Le présent agrément est valable deux (2) ans renouvelables une fois. Durant cette période, l'opérateur
            dispose de la faculté de renoncer à son agrément, en le notifiant par écrit à l'ONFP, au moins un
            (1) mois à l'avance. L'ONFP se réserve le droit de suspendre ou de résilier, à tout moment, le présent
            agrément, par notification écrite à l'opérateur.
            <ul>
                L'Opérateur agréé :
                <li>déclare avoir pris connaissance des procédures de l'ONFP notamment celles relatives à l'opérateur de
                    formation,</li>
                <li>s'engage à exécuter comme assistant les formations qui lui sont confiées dans le respect des normes
                    du
                    métier et participe à la demande de l'ONFP à toute activité en lien avec cet agrément,</li>
                <li>certifie que l'agrément dont il bénéficie ne peut donner lieu à aucune responsabilité ou obligation
                    de
                    l'ONFP vis-à-vis d'un tiers ou de l'administration,</li>
                <li>reconnait que toute production faite dans le cadre des actions de formation qui lui sont confiées,
                    est
                    la propriété de l'Office.</li>

            </ul>
            <h3 style="text-align: right;">
                {{ 'Fait à ' . $operateur?->commissionagrement?->description . ', le ' . $operateur?->commissionagrement?->date?->format('d/m/Y') }}
                <br>
                <div class="page-number" id="footer">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/signature_op_dg.png'))) }}"
                        style="display: block; width: 100%;" />
                </div>
            </h3>
            {{-- <table>
                <h3 style="text-align: right;">{{ $operateur?->commissionagrement?->description }}</h3>
                <h3>L'Opérateur
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Le Directeur Général
                    <br><small class="small fst-italic">(Lu et
                        approuvé - Signature)</small>
                </h3>
            </table> --}}
        </div>
        {{-- <div class="invoice-box" style="margin-top: 0cm;">
        <table>
            <thead>
                <tr class="heading">
                    <td colspan="3">
                        <h3>L'Opérateur <br><small class="small fst-italic">(Lu et
                                approuvé - Signature)</small></h3>
                    </td>
                    <td colspan="3"></td>
                    <td colspan="3" style="text-align: right;">
                        <h3>{{ $operateur?->commissionagrement?->description }} <br>
                            <span style="padding-right: 40px">Le Directeur Général</span>
                        </h3>
                    </td>
                </tr>
            </thead>
        </table>
    </div> --}}

        <footer>
            <div class="page-number" id="footer">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/pied.png'))) }}"
                    style="display: block; width: 100%;" />
            </div>
        </footer>
    </body>

    {{-- <div style="page-break-after: always;"></div> --}}
@endforeach

</html>
