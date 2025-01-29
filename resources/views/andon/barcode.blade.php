<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Cetak Barcode</title>

    <style>
        .text-center {
            text-align: center;
        }
        .barcode-container {
            border: 1px solid #333;
            padding: 2px;
            margin-bottom: 0px;
        }
        .barcode-container img {
            width: 119px;
            height: 119px;
            margin-top: 0px;
        }
        .barcode-container p {
            margin: 0;
        }
        .work-center {
            text-align: center;
            font-size: 24px;
            margin-top: 0px;
        }
        .page-break-before {
            page-break-before: always;
        }
    </style>
</head>

<body>
<h1 class="work-center" style="text-align: center; margin-top: -25px;">WORK CENTER <br>TP{{ $dataandon[0]->Workcenter }}</h1>
    <table style="margin-top: -5px;" width="100%">
        <tr>
            <td width="100%">
                @php
                    $yellowBarcodes = array_filter($dataandon->toArray(), function($andonno) {
                        return $andonno['Andon_Color'] === 'YELLOW';
                    });
                @endphp
                @foreach ($yellowBarcodes as $andonno)
                    <div class="barcode-container text-center">
                        <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($andonno['Andon_No'], 'QRCODE') }}"
                            alt="{{ $andonno['Andon_No'] }}">
                            <p>
                            {{ $andonno['Andon_No'] }}
                            </p>
                            <p style="background-color: yellow;">
                            @if($andonno['CodeAndon'] === 'A')
                                MATERIAL
                            @elseif($andonno['CodeAndon'] === 'B')
                                DRAWING
                            @elseif($andonno['CodeAndon'] === 'C')
                                MACHINE
                            @elseif($andonno['CodeAndon'] === 'D')
                                MAN (Labor)
                            @elseif($andonno['CodeAndon'] === 'E')
                                SAFETY (K3)
                            @elseif($andonno['CodeAndon'] === 'F')
                                QUALITY
                            @else
                                ACCEPTED
                            @endif
                        </p>
                    </div>
                @endforeach
            </td>
            <td width="100%">
                @php
                    $redBarcodes = array_filter($dataandon->toArray(), function($andonno) {
                        return $andonno['Andon_Color'] === 'RED';
                    });
                @endphp
                @foreach ($redBarcodes as $andonno)
                    <div class="barcode-container text-center" >
                        <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($andonno['Andon_No'], 'QRCODE') }}"
                            alt="{{ $andonno['Andon_No'] }}">
                        <p>
                            {{ $andonno['Andon_No'] }}
                        </p>
                        <p style="background-color: red;">
                            @if($andonno['CodeAndon'] === 'A')
                                MATERIAL
                            @elseif($andonno['CodeAndon'] === 'B')
                                DRAWING
                            @elseif($andonno['CodeAndon'] === 'C')
                                MACHINE
                            @elseif($andonno['CodeAndon'] === 'D')
                                MAN (Labor)
                            @elseif($andonno['CodeAndon'] === 'E')
                                SAFETY (K3)
                            @elseif($andonno['CodeAndon'] === 'F')
                                QUALITY
                            @else
                                ACCEPTED
                            @endif
                        </p>
                    </div>
                @endforeach
            </td>
        </tr>
        <tr>
            <td width="100%">
                @php
                    $greenBarcodes = array_filter($dataandon->toArray(), function($andonno) {
                        return empty($andonno['Workcenter']);
                    });
                @endphp
                @foreach ($greenBarcodes as $andonno)
                    <div class="barcode-container text-center" >
                        <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($andonno['Andon_No'], 'QRCODE') }}"
                            alt="{{ $andonno['Andon_No'] }}">
                        <p>
                            {{ $andonno['Andon_No'] }}
                        </p>
                        <p style="background-color: green;">
                            @if($andonno['CodeAndon'] === 'A')
                                MATERIAL
                            @elseif($andonno['CodeAndon'] === 'B')
                                DRAWING
                            @elseif($andonno['CodeAndon'] === 'C')
                                MACHINE
                            @elseif($andonno['CodeAndon'] === 'D')
                                MAN (Labor)
                            @elseif($andonno['CodeAndon'] === 'E')
                                SAFETY (K3)
                            @elseif($andonno['CodeAndon'] === 'F')
                                QUALITY
                            @else
                                ACCEPTED
                            @endif
                        </p>
                    </div>
                @endforeach
            </td>
        </tr>
    </table>
</body>
</html>