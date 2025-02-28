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
    <h4 style="text-align: center;">MODULES</h4>
    <div class="invoice-box">
        <table class="table table-responsive">
            <tbody>
                <tr class="item">
                    <td style="text-align: center;">N°</td>
                    <td>MODULES / SPECIALITE</td>
                    <td>DOMAINES</td>
                    <td>SECTEURS</td>
                </tr>

                <?php
                $i = 1;
                $previousDomaine = null;
                $previousSecteur = null;
                ?>

                @foreach ($modules as $module)
                    <tr class="item">
                        <td style="text-align: center;">{{ $i++ }}</td>
                        <td>{{ remove_accents_uppercase($module?->name) }}</td>

                        {{-- Vérifier si le domaine est identique au précédent --}}
                        @if ($module?->domaine?->name == $previousDomaine)
                            <td></td> {{-- Laisser la cellule vide pour éviter la répétition --}}
                        @else
                            <td>{{ remove_accents_uppercase($module?->domaine?->name) }}</td>
                        @endif

                        {{-- Vérifier si le secteur est identique au précédent --}}
                        @if ($module?->domaine?->secteur?->name == $previousSecteur)
                            <td></td> {{-- Laisser la cellule vide pour éviter la répétition --}}
                        @else
                            <td>{{ remove_accents_uppercase($module?->domaine?->secteur?->name) }}</td>
                        @endif
                    </tr>

                    {{-- Mettre à jour les variables pour la prochaine itération --}}
                    <?php
                    $previousDomaine = $module?->domaine?->name;
                    $previousSecteur = $module?->domaine?->secteur?->name;
                    ?>
                @endforeach
            </tbody>
        </table>
    </div>
    <footer>
        <div class="page-number" id="footer">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/pied.png'))) }}"
                style="display: block; width: 100%;" />
        </div>
    </footer>
</body>

</html>
