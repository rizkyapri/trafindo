@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between">
            <div>
                <h1 style="color: black">
                    <i class="fa-solid fa-book" style="margin-right: 10px; color: black"></i>Report 303
                </h1>
            </div>
            <div>
                @if (isset($dateRange) && isset($department))
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-print"></i>
                        Export Report
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li>
                            <a class="dropdown-item"
                                href="{{ route('report.exportwo', ['daterange' => $dateRange, 'department' => $department]) }}"
                                style="cursor: pointer;" data-toggle="modal" data-target="#importdata">Export to Excel</a>
                        </li>
                        <li>
                            <a class="dropdown-item"
                                href="{{ route('report.exportwocsv', ['daterange' => $dateRange, 'department' => $department]) }}"
                                style="cursor: pointer;" data-toggle="modal" data-target="#importdata">Export to
                                Smartsoft</a>

                        </li>
                    </ul>
                @endif
            </div>

        </div>


        <hr style="color: black;" class="my-3" />

        <h4>

            @if (!empty($department) && !is_null($department))
                PPIC Produksi {{ $department }} | {{ $dateRange }}
            @else
                PPIC Produksi
            @endif
        </h4>


        <div class="card" style="margin-bottom: 30px;">
            <div class="card-body">

                <form action="{{ route('report.report') }}" method="POST">
                    @csrf
                    <div class="row">

                        {{-- Pilihan Jam --}}
                        {{-- <div class="col-md-3 mb-3">
                            <div class="btn-group">
                                <div class="input-group input-group-merge">
                                    <select class="selectpicker" data-style="btn-primary" data-live-search="true"
                                        aria-label="hours" id="hours" name="hours">
                                        <option selected disabled>- Choose Hours -</option>
                                        <option value="7" selected>7 Hours</option>
                                        <option value="8">8 Hours</option>
                                    </select>
                                </div>
                            </div>
                        </div> --}}

                        {{-- Choose Department --}}
                        <div class="col-md-3 mb-1">
                            <div class="btn-group">
                                <div class="input-group input-group-merge">
                                    <select class="selectpicker" data-style="btn-secondary" data-live-search="true"
                                        aria-label="department" id="department" name="department"
                                        onchange="toggleWorkCenterDropdown()">
                                        <option selected disabled>- Choose Department -</option>
                                        <option value="PL 1">PL 1</option>
                                        <option value="PL 2">PL 2</option>
                                        <option value="PL 3">PL 3</option>
                                        <option value="REPAIR">REPAIR</option>
                                        <option value="DRY TYPE">DRY TYPE</option>
                                        <option value="CTVT">CTVT</option>
                                    </select>

                                </div>
                            </div>
                            @if (session('error'))
                                <span class="text-danger">Invalid Department</span>
                            @endif
                        </div>

                        {{-- Date Range --}}
                        <div class="col-2 col-md-3 mb-1">
                            <div class="mb-1">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="YYYY-MM-DD to YYYY-MM-DD"
                                        id="daterange" name="daterange" value="{{ $dateRange ?? '' }}" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar fs-4"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @if (session('error'))
                                <span class="text-danger">Invalid Date</span>
                            @endif
                        </div>

                        {{-- Apply Button --}}
                        <div class="col-2 col-md-3 mb-1">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary" id="applyButton">Apply</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>



            <!-- Employee Table -->
            <div class="card">
                <div class="table-responsive text-nowrap container mt-4">
                    <table class="report-data table table-hover" id="report">
                        <thead>
                            <tr>
                                <th>No</th>
                                {{-- <th>NIK</th>
                                <th>Name</th> --}}
                                <th>WO</th>
                                <th>Divisi</th>
                                <th>WC</th>
                                <th>Qty</th>
                                {{-- <th>Hours</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($woopr as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    {{-- <td>{{ $item->EmployeeNumber }}</td>
                                    <td>{{ $item->Name }}</td> --}}
                                    <td>
                                        <a
                                            href="{{ route('report.details', ['WOnborig' => $item->WOnborig, 'date' => $dateRange, 'department' => $item->department]) }}">
                                            {{ $item->WOnborig }}
                                        </a>
                                    </td>
                                    <td>
                                        @if (in_array($item->Workcenter, ['TP01', 'TP02', 'TP03', 'TP04', 'TP05', 'TP06', 'TP07']))
                                            PL 1
                                        @elseif (in_array($item->Workcenter, ['TP41', 'TP42', 'TP43', 'TP44', 'TP45', 'TP46', 'TP47']))
                                            PL 2
                                        @elseif (in_array($item->Workcenter, ['TP51', 'TP52', 'TP53', 'TP54', 'TP55', 'TP56', 'TP57', 'TP58']))
                                            PL 3
                                        @elseif (in_array($item->Workcenter, ['SP11', 'SP12', 'SP13']))
                                            REPAIR
                                        @elseif (in_array($item->Workcenter, ['DP41', 'DP42', 'DP43', 'DP44', 'DP45']))
                                            DRY TYPE
                                        @elseif (in_array($item->Workcenter, ['CP13', 'CP17', 'CP17', 'CP18']))
                                            CTVT
                                        @endif
                                    </td>
                                    <td>{{ $item->Workcenter }}</td>
                                    <td>{{ $item->WOqty }}</td>

                                    {{-- <td></td> --}}

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var flatpickrRange = document.querySelector("#daterange");

        flatpickrRange.flatpickr({
            mode: "range",
        });

        $("#report").DataTable({
            columnDefs: [{
                target: -1,
                className: "dt-head-center",
            }, ],
        });
    </script>
    <script>
        function toggleWorkCenterDropdown() {
            var departmentDropdown = document.getElementById("department");
            var workCenterDropdown = document.getElementById("workCenterDropdown");

            if (departmentDropdown.value !== "") {
                workCenterDropdown.style.display = "block";
            } else {
                workCenterDropdown.style.display = "none";
            }
        }
    </script>

    <script>
        function toggleOperationNameDropdown() {
            var workCenterDropdown = document.getElementById("wc");
            var operationDropdown = document.getElementById("operationDropdown");

            if (workCenterDropdown.value !== "") {
                operationDropdown.style.display = "block";
            } else {
                operationDropdown.style.display = "none";
            }
        }
    </script>
    {{-- <script>
        $(function() {

            $('input[name="daterange"]').daterangepicker({
                startDate: moment().subtract(1, 'M'),
                endDate: moment()
            });

            var table = $('.report-data').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('report.report') }}",
                    data: function(d) {
                        d.from_date = $('input[name="daterange"]').data('daterangepicker').startDate
                            .format('YYYY-MM-DD');
                        d.to_date = $('input[name="daterange"]').data('daterangepicker').endDate.format(
                            'YYYY-MM-DD');
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $(".filter").click(function() {
                table.draw();
            });

        });
    </script>
    <script>
        jQuery.noConflict();
        jQuery(document).ready(function($) {
            // DatePicker
            var startDate, endDate, selectedHours,
                selectedDepartment; // Variabel untuk menyimpan nilai startDate dan endDate

            // Mendengarkan perubahan pada elemen dengan id 'hours'
            $('#hours').change(function() {
                // Mendapatkan nilai yang dipilih
                var selectedHours = $(this).val();

                // Menampilkan nilai yang dipilih di console
                console.log('Selected Hours:', selectedHours);
            });

            // Mendengarkan perubahan pada elemen dengan id 'department'
            $('#department').change(function() {
                // Mendapatkan nilai yang dipilih
                var selectedDepartment = $(this).val();

                // Menampilkan nilai yang dipilih di console
                console.log('Selected Department:', selectedDepartment);
            });

            var flatpickrRange = document.querySelector("#daterange");

            flatpickrRange.flatpickr({
                mode: "range",
                onChange: function(selectedDates, dateStr, instance) {
                    var dateRangeString = dateStr;

                    // Pecah rentang tanggal menjadi dua tanggal
                    var dateArray = dateRangeString.split(" to ");
                    var startDate = dateArray[0]; // "2023-11-01"
                    var endDate = dateArray[1]; // "2023-11-23"

                    console.log("Start Date:", startDate);
                    console.log("End Date:", endDate);

                    // dateStr adalah rentang tanggal dalam format teks
                    // console.log(dateStr);
                }
            });


            // $('#applyButton').on('click', function() {

            //     // Kirim data ke controller atau lakukan operasi lain sesuai kebutuhan
            //     $.ajax({
            //         type: 'GET',
            //         url: "{{ route('report.report') }}", // Ganti dengan URL yang sesuai
            //         data: {
            //             start_date: startDate,
            //             end_date: endDate,
            //             hours: selectedHours,
            //             department: selectedDepartment
            //         },
            //         success: function(data) {
            //             // Tambahkan logika atau tindakan lain setelah sukses
            //             console.log('Data sent successfully:', data);
            //             $('.report-data').DataTable().ajax.reload();
            //         },
            //         error: function(error) {
            //             // Tambahkan logika atau tindakan lain jika ada kesalahan
            //             console.error('Error sending data:', error);
            //         }
            //     });
            // });

            // Gunakan $ di sini untuk menghindari konflik dengan variabel lain
            var table = $('.report-data').DataTable({
                processing: true,
                serverSide: true,
                // ajax: "{{ route('report.report') }}",
                ajax: {
                    url: "{{ route('report.report') }}",
                    // data: function(data) {
                    //     // _token:{{ csrf_token() }}
                    //     // Gunakan nilai startDate dan endDate yang telah disimpan sebelumnya
                    //     data.from_date = startDate,
                    //         data.to_date = endDate
                    // }
                },
                columns: [{
                        data: 'DT_RowIndex', // Gunakan 'DT_RowIndex' untuk menampilkan indeks
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'NIK',
                        name: 'NIK',
                    },
                    {
                        data: 'EmployeeName',
                        name: 'EmployeeName'
                    },
                    {
                        data: 'WONumber',
                        name: 'WONumber'
                    },
                    {
                        data: 'Divisi',
                        name: 'Divisi'
                    },
                    {
                        data: 'Workcenter',
                        name: 'Workcenter'
                    },
                    {
                        data: 'QTY',
                        name: 'QTY'
                    },
                    {
                        data: 'Manhours',
                        name: 'Manhours'
                    },

                ],
                searching: true, // Enable searching
            });
        });
    </script> --}}
@endpush
