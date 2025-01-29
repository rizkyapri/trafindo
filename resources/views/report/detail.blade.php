@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between">
            <div>
                <h1>
                    <i class="fa-solid fa-book" style="margin-right: 10px;"></i>Report 303
                </h1>
            </div>
            <div>
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false"><i class="fas fa-print"></i>
                    Export Report
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li>
                        @if (isset($WOnborig) && isset($date) && isset($workcenter))
                            <a class="dropdown-item"
                                href="{{ route('report.export', ['WOnborig' => $WOnborig, 'date' => $date, 'workcenter' => $workcenter]) }}"
                                style="cursor: pointer;">Export to Excel</a>
                            <a class="dropdown-item"
                                href="{{ route('report.exportcsv', ['WOnborig' => $WOnborig, 'date' => $date, 'workcenter' => $workcenter]) }}"
                                style="cursor: pointer;">Export to Smartsoft</a>
                        @endif

                    </li>
                    <li>
                        {{-- <a class="dropdown-item" href="{{ route('report.export') }}" style="cursor: pointer;">Export to
                            CSV</a> --}}
                    </li>

                </ul>
            </div>

        </div>

        <hr style="color: black;" class="my-3" />


        <h4>
            @if (!empty($department) && !is_null($department))
                PPIC Produksi {{ $department }}
            @else
                PPIC Produksi
            @endif
        </h4>

        <div class="card" style="margin-bottom: 30px;">
            <!-- Employee Table -->
            <div class="card">
                <div class="table-responsive text-nowrap container mt-4">
                    <span class="badge bg-label-primary mb-2" style="font-size: 23px;">Total ManHours:
                        {{ $overallTotalDurationInHours + intdiv($overallTotalDurationInMinutes, 60) }} H
                        {{ $overallTotalDurationInMinutes % 60 }} M</span>
                    <table class="report-data table table-hover" id="report">
                        <thead>
                            <tr>
                                <th>No</th>
                                {{-- <th>NIK</th>
                                <th>Name</th> --}}
                                <th>WO</th>
                                <th>SIE</th>
                                <th>DATE</th>
                                <th>ManHours</th>
                                <th>Detail</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($report as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    {{-- <td>{{ $item->EmployeeNumber }}</td>
                                    <td>{{ $item->Name }}</td> --}}
                                    <td>
                                        {{ $item->WOnborig }}
                                    </td>
                                    <td>
                                        {{ $item->OprName }}
                                    </td>
                                    <td>{{ $item->TaskDateStart }}</td>

                                    <td>{{ $item->totalDurationInHours }} H {{ $item->totalDurationInMinutes }} M </td>

                                    <td>
                                        <button type="button"
                                            class="btn btn-sm btn-primary text-center justify-content-center"
                                            data-bs-toggle="modal" data-bs-target="#detailReportModal{{ $item->OprID }}">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>

                                        <!-- Detail report modal -->
                                        <div class="modal fade" id="detailReportModal{{ $item->OprID }}" tabindex="-1"
                                            aria-labelledby="detailReportModalLabel{{ $item->OprID }}" aria-hidden="true">
                                            <div class="modal-dialog modal-xl" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="detailReportModalLabel">
                                                            {{ $item->OprName }}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="report-data table table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>NIK</th>
                                                                    <th>Name</th>
                                                                    <th>Task Start</th>
                                                                    <th>Task End</th>
                                                                    <th>ManHours</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($item->tasks as $task)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>{{ $task->employees->EmployeeNumber }}</td>
                                                                        <td>{{ $task->employees->Name }}</td>
                                                                        <td>{{ $task->TaskDateStart }}</td>
                                                                        <td>{{ $task->TaskDateEnd }}</td>
                                                                        <td>{{ floor($task->duration / 60) }} H
                                                                            {{ $task->duration % 60 }} M</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

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
        $(document).ready(function() {
            $("#report").DataTable({
                columnDefs: [{
                    target: -1,
                    className: "dt-head-center",
                }],
            });
        });
        // dom: 'Bfrtip',
        // buttons: [{
        //     extend: 'excelHtml5',
        //     title: 'Report 303', // Set your custom Excel title
        //     exportOptions: {
        //         columns: [0, 1, 2, 3, 4] // Specify which columns to export
        //     },
        //     customize: function(xlsx) {
        //         var sheet = xlsx.xl.worksheets['sheet1.xml'];
        //         $('row c[r^="A"]', sheet).attr('s',
        //         '25'); // Set the cell style for column A
        //     }
        // }]
    </script>

    <script>
        var flatpickrRange = document.querySelector("#daterange");

        flatpickrRange.flatpickr({
            mode: "range",
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
@endpush
