<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>{{ $title }}</title>

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon-onfp.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <style>
        @page {
            /* margin: 0cm 0cm; */
            margin-top: 0.5cm;
            margin-bottom: 0cm;
        }

        .invoice-box {
            max-width: 1000px;
            margin-bottom: 50px;
            /* Laisse de l'espace pour le footer */
            margin-left: 50px;
            /* Laisse de l'espace pour le footer */
            margin-right: 50px;
            /* Laisse de l'espace pour le footer */
            /* padding: 30px; */
            font-size: 12px;
            line-height: 18px;
            color: color: rgb(0, 0, 0);
            ;
        }

        /** RTL **/
        .rtl {
            imputation: rtl;
        }

        .invoice-box table tr.heading td {
            background: rgb(255, 255, 255);
            border: 1px solid #000000;
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
            /* border-left: 0;
            border-right: 0px solid rgb(0, 0, 0);
            border-top: 0;
            border-bottom: 0px solid rgb(0, 0, 0); */
            border: 1px solid;
        }

        /* footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;

            background-color: #ffffff;
            color: rgb(0, 0, 0);
            text-align: center;
            line-height: 1.5cm;
        } */

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #ffffff;
            color: black;
            text-align: center;
            padding: 10px 0;
            font-size: 12px;
            border-top: none;
        }

        .footer-separator {
            width: 90%;
            margin: 0 auto 0px;
            border: 0;
            border-top: 2px solid #000000;
            opacity: 0.7;
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

<body>
    <div style="text-align: center;">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/entete.png'))) }}"
            style="width: 100%; max-width: 370px" />
    </div>
    <h4 style="text-align: center;">NOS MODULES DE FORMATION</h4>
    <div class="invoice-box">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover ms-autor" style="text-align: left;">
                <thead class="thead-dark">
                    <tr>
                        <th style="text-align: center;"><b>N°</b></th>
                        <th style="text-align: left;"><b>MODULES / SPÉCIALITE</b></th>
                        <th style="text-align: left;"><b>NIVEAU QUALIFICATION</b></th>
                        {{-- <th><b>DOMAINES</b></th>
                    <th><b>SECTEURS</b></th>
                    <th><b>NIVEAU ENTRE</b></th>
                    <th><b>TITRE / ATTESTATION</b></th> --}}
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    ?>
                    @foreach ($modules as $module)
                        <tr class="item">
                            <td style="text-align: center;">{{ $i++ }}</td>
                            <td>{{ remove_accents_uppercase($module?->name) }}</td>
                            <td>{{ $module?->niveau_qualification }}</td>
                            {{-- <td>{{ remove_accents_uppercase($module?->domaine?->name) }}</td>
                        <td>{{ remove_accents_uppercase($module?->domaine?->secteur?->name) }}</td>
                        <td></td>
                        <td></td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <footer class="footer">
        <hr class="footer-separator">
        <div class="container text-center">
            <p>
                Sipres 1, lot 2, 2 voies Liberté 6 extension VDN |
                Tél : (+221) 33 827 92 51 | Fax : 33 827 92 55 |
                BP: 21013 Dakar-Ponty | Site web: <a href="https://onfp.sn">onfp.sn</a> |
                Email: <a href="mailto:onfp@onfp.sn">onfp@onfp.sn</a>
            </p>
        </div>
    </footer>
</body>

</html>
