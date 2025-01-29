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
    </style>
</head>

<body>
    <table width="100%">
        <tr>
            @foreach ($dataemployee as $employee)
                <td class="text-center" style="border: 1px solid #333;">
                    <p>{{ $employee->Name }}</p>
                    <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($employee->EmployeeNumber, 'QRCODE') }}"
                        alt="{{ $employee->EmployeeNumber }}" width="180" height="180" >
                    <!-- Menggunakan width dan height yang sama -->
                    <br>
                    {{ $employee->EmployeeNumber }}
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
