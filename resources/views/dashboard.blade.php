@extends('layouts.main')

@section('content')
    {{-- @dd($statusData) --}}
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('images/icons/unicons/wo.png') }}" alt="card-checklist" class="rounded" />
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                    <a href="{{ route('workorder.index') }}" class="dropdown-item"
                                        href="javascript:void(0);">View More</a>
                                </div>
                            </div>
                        </div>
                        <span class="d-block mb-1 text-dark">Work Order</span>
                        <h3 class="card-title text-nowrap mb-2 text-dark">{{ $totalWO }}</h3>
                    </div>
                </div>
            </div>
            {{-- Employees --}}
            <div class="col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('images/icons/unicons/employees.png') }}" alt="Employee"
                                    class="rounded" />
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                    <a href="{{ route('employee.index') }}" class="dropdown-item"
                                        href="javascript:void(0);">View More</a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1 text-dark">Employees</span>
                        <h3 class="card-title mb-2 text-dark">{{ $totalEmployees }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Work Order Opr -->
            <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
                <div class="card">
                    <div class="row row-bordered g-0">
                        <div class="col-11">
                            <h5 class="card-header m-0 me-2 pb-3 text-dark">Status Work Order Operations</h5>
                            <div class="col-4">
                                <form method="GET" class="d-flex justify-content-end align-items-center p-2">
                                    {{-- <label for="year" class="me-2">Pilih Tahun:</label> --}}
                                    <select name="year" id="year" class="form-control form-control-md mx-3"
                                        onchange="this.form.submit()">
                                        @foreach ($yearsFromColumns as $availableYear)
                                            <option value="{{ $availableYear }}"
                                                {{ $year == $availableYear ? 'selected' : '' }}>
                                                {{ $availableYear }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                            <div id="statusWoChart" class="py-3"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Total Work Order -->
            <!-- Employees Statistics -->
            <div class="col-md-6 col-lg-4 order-2 mb-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between pb-0">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2 mb-3 text-dark">Employees Statistics</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center mb-3">
                            <div id="employeesStatisticsChart"></div>
                        </div>
                        <div class="card-body" style="max-height: 218px; overflow-y: auto;">
                            <!-- Set max height and enable overflow-y -->
                            <table class="table table-sm table-hover">
                                <thead>
                                    <th>Employees Name</th>
                                    <th>Status</th>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($employees as $user)
                                        <tr>
                                            <td>{{ $user->Name }}</td>
                                            <td>
                                                @if ($user->InProgress == 0)
                                                    <span class="badge bg-success me-1">Finish</span>
                                                @elseif ($user->InProgress == 1)
                                                    <span class="badge bg-primary me-1">Active</span>
                                                @else
                                                    <span class="badge bg-danger me-1">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!--/ Employees Statistics -->

        </div>
        <!-- Man Hours wo -->
        {{-- <div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
            <div class="card">
                <div class="row row-bordered g-0">
                    <div class="col-11">
                        <h5 class="card-header m-0 me-2 pb-3">Man Hours Per Work Order</h5>
                        <div id="manhoursWoChart" class="px-2"></div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!--/ Man Hours wo-->
    </div>
    <script>
        var notStartedData = @json($statusData['Not Started']);
        var inProgressData = @json($statusData['In Progress']);
        var finishData = @json($statusData['Finish']);
        const totalFinishEmployees = {{ $totalFinishEmployees }};
        const totalRunEmployees = {{ $totalRunEmployees }};
        const totalStopEmployees = {{ $totalStopEmployees }};
    </script>
    <script>
        $(document).ready(function() {
            $('#employeeTable').DataTable({
                // Define sorting options for specific columns
                columnDefs: [{
                        targets: [0, 1],
                        orderable: true
                    }, // Enable sorting for column 0 and 1
                ],
            });
        });
    </script>
@endsection
