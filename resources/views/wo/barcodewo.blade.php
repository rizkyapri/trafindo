<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Barcode</title>

    <style>
        .text-center {
            text-align: center;
        }
        .bordered {
        border: 2px solid #333;
        padding: 5px; /* Sesuaikan padding sesuai kebutuhan */
        display: inline-block;
        }
    </style>
</head>

<body>
    <table width="100%">
        <tr>
            @foreach ($dataworkorder as $workorder)
                <td width="100%" class="text-center" style="border: 1px solid #333;">
                    <p>{{ substr($workorder->WONumber, -3) }}</p>
                    <p>{{ $workorder->OprName }}</p>
                    <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($workorder->WONumber . $workorder->OprNumber, 'QRCODE') }}"
                        alt="{{ $workorder->WONumber . $workorder->OprNumber }}" width="200" height="200" >
                    <!-- Menggunakan width dan height yang sama -->
                    <br>
                    {{ $workorder->WONumber . $workorder->OprNumber }}
                    <br>
                    <p class="bordered">{{$dataworkorder[0]->Workcenter}}</p>
                </td>
                @if ($no++ % 3 == 0)
        </tr>
        <tr>
            @endif
            @endforeach
        </tr>
    </table>
</body>

</html>