@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between">
            <h3 style="font-size: 32px; font-weight: bold; color: black">
                <i class="fa-solid fa-clock-rotate-left" style="color: #000000;"></i>
                Andon History
            </h3>
        </div>

        <hr class="my-1" />


        <div class="card">
            <div class="card-header">
                <div class="row g-2">
                    <div class="col mb-0">
                        <h2><strong>Hello, {{ $andonCategory->ContactPerson }}</strong></h2>
                    </div>
                    <div class="col-auto ml-auto">
                        <span class="badge bg-label-primary"
                            style="font-size: 28px; font-weight: bold;">{{ $andonCategory->CategoryProblem }}</span>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row g-4">
                    <div class="col mb-0">
                        <label for="NOEMPLOYEE" class="form-label" style="font-weight: bold;">Employee Number: </label>
                        <input type="text" id="NOEMPLOYEE" value="{{ $employee->EmployeeNumber }}" class="form-control"
                            readonly>
                    </div>
                    <div class="col mb-0">
                        <label for="NOWA" class="form-label" style="font-weight: bold;">WhatsApp: </label>
                        <input type="text" id="NOWA" value="{{ $andonCategory->HP_WA }}" class="form-control"
                            readonly>
                    </div>
                </div>
            </div>
        </div>


        <div style="margin-top: 38px;">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title"><strong>History</strong></h5>
                    <button id="refreshbutton" type="button" class="btn btn-sm btn-primary">
                        <i class="fas fa-rotate-right"></i>
                    </button>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('andon.export') }}" method="get">
                        <div class="row">
                            <div class="col-md-3 mb-4">
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
                
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Export to Excel</button>
                            </div>
                        </div>
                    </form>
                
                    <!-- Set max height and enable overflow-y -->
                    <div class="table-responsive">
                        <table class="table table-hover" id="myTable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Status</th>
                                    <th>Andon Serie</th>
                                    <th>WC</th>
                                    <th>Progress</th>
                                    <th>Details</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($andonData as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($data->Andon_Color == 'YELLOW')
                                                <span class="badge bg-warning me-1">YELLOW</span>
                                            @elseif ($data->Andon_Color == 'RED')
                                                <span class="badge bg-danger me-1">RED</span>
                                            @else
                                                <span class="badge bg-secondary me-1">NO DATA</span>
                                            @endif
                                        </td>
                                        <td>{{ strtoupper($data->Andon_Serie) }}</td>
                                        <td>{{ $data->Workcenter }}</td>
                                        <td>
                                            @if ($data->AndonDateClosed != null)
                                                <span class="badge bg-success me-1">Finish</span>
                                            @else
                                                <span class="badge bg-primary me-1">In Progress</span>
                                            @endif
                                        </td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#basicModal{{ $data->id }}">
                                                View Details
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="basicModal{{ $data->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="exampleModalLabel1{{ $data->id }}">
                                                                <span class="badge bg-primary"
                                                                    style="font-size: 20px; font-weight: bold;">{{ strtoupper($data->Andon_Serie) }}</span>
                                                            </h5>

                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row g-4">
                                                                <div class="col mb-0">
                                                                    <label for="OpBy" class="form-label"
                                                                        style="font-weight: bold;">Open
                                                                        By</label>
                                                                    <input type="text" id="OpBy"
                                                                        class="form-control"
                                                                        value="{{ $data->Guard_Name }}" disabled>
                                                                </div>
                                                                <div class="col mb-0">
                                                                    <label for="Workcenter" class="form-label"
                                                                        style="font-weight: bold;">Work
                                                                        Center</label>
                                                                    <input type="text" id="Workcenter"
                                                                        class="form-control"
                                                                        value="{{ strtoupper($data->Workcenter) }}"
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                            <div class="row g-4 mt-3">
                                                                <div class="col mb-0">
                                                                    <label for="RiseUp_EmployeeName" class="form-label"
                                                                        style="font-weight: bold;">Rise Up Employee
                                                                        Name</label>
                                                                    <input type="text" id="RiseUp_EmployeeName"
                                                                        class="form-control"
                                                                        value="{{ $data->RiseUp_EmployeeName }}" disabled>
                                                                </div>
                                                                <div class="col mb-0">
                                                                    <label for="WO" class="form-label"
                                                                        style="font-weight: bold;">Work
                                                                        Order</label>
                                                                    <input type="text" id="WO"
                                                                        class="form-control"
                                                                        value="{{ $data->RiseUp_OprNo }}" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="row g-4 mt-3">
                                                                <div class="col mb-0">
                                                                    <label for="DescriptionProblem" class="form-label"
                                                                        style="font-weight: bold;">Problem
                                                                        Description:</label>
                                                                    <textarea type="text" id="DescriptionProblem" class="form-control" name="DescriptionProblem" rows="4"
                                                                        disabled>{{ $data->DescriptionProblem }}</textarea>
                                                                </div>
                                                                <div class="col mb-0">
                                                                    <label for="AndonRemark" class="form-label"
                                                                        style="font-weight: bold;">Remark:</label>
                                                                    <textarea type="text" id="AndonRemark" class="form-control" name="AndonRemark" rows="4" disabled>{{ $data->AndonRemark }}</textarea>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <form
                                                action="{{ route('save.to.history', ['andonSerie' => $data->Andon_Serie]) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary">Check</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        {{-- END FORM --}}

        {{-- STEPPER --}}
        @if (session('HistoryAndon_Serie'))
            <div style="margin-top: 32px;">
                <div class="card">
                    <div class="card-header">
                        <section class="stepper"
                            style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                            <ul>
                                <li class="stepper1 {{ session('HistoryAndonDateOpen') ? 'checked' : '' }}">
                                    <i class="icon uil uil-folder-open color-1"></i>
                                    <div class="progress one">
                                        <p class="pt-1">1</p>
                                        <i class="uil uil-check"></i>
                                    </div>
                                    <p class="text">Open</p>
                                    <div class="shadow-sm p-3 mb-10 bg-white rounded" style="border: 1px solid #fa994b;">
                                        {{ session('HistoryAndonDateOpen') }}
                                    </div>
                                </li>
                                <li class="stepper2 {{ session('HistoryAndonDateReceived') ? 'checked' : '' }}">
                                    <i class="icon uil uil-envelope-download color-2"></i>
                                    <div class="progress two">
                                        <p class="pt-1">2</p>
                                        <i class="uil uil-check"></i>
                                    </div>
                                    <p class="text">Received</p>
                                    <div class="shadow-sm p-3 mb-10 bg-white rounded" style="border: 1px solid #8699a8;">
                                        {{ session('HistoryAndonDateReceived') }}
                                    </div>
                                </li>
                                <li class="stepper3 {{ session('HistoryAndonDateSolving') ? 'checked' : '' }}">
                                    <i class="icon uil uil-wrench color-3"></i>
                                    <div class="progress three">
                                        <p class="pt-1">3</p>
                                        <i class="uil uil-check"></i>
                                    </div>
                                    <p class="text">Solving</p>
                                    <div class="shadow-sm p-3 mb-10 bg-white rounded" style="border: 1px solid #f5c861;">
                                        {{ session('HistoryAndonDateSolving') }}
                                    </div>
                                </li>
                                <li class="stepper4 {{ session('HistoryAndonDateAccepted') ? 'checked' : '' }}">
                                    <i class="icon uil uil-check-circle color-4"></i>
                                    <div class="progress four">
                                        <p class="pt-1">4</p>
                                        <i class="uil uil-check"></i>
                                    </div>
                                    <p class="text">Accepted</p>
                                    <div class="shadow-sm p-3 mb-10 bg-white rounded" style="border: 1px solid #2496d2;">
                                        {{ session('HistoryAndonDateAccepted') }}
                                    </div>
                                </li>
                                <li class="stepper5 {{ session('HistoryAndonDateClosed') ? 'checked' : '' }}">
                                    <i class="icon uil uil-minus-square-full color-5"></i>
                                    <div class="progress five">
                                        <p class="pt-1">5</p>
                                        <i class="uil uil-check"></i>
                                    </div>
                                    <p class="text">Closed</p>
                                    <div class="shadow-sm p-3 mb-10 bg-white rounded" style="border: 1px solid #3c9c30;">
                                        {{ session('HistoryAndonDateClosed') }}
                                    </div>
                                </li>
                            </ul>
                        </section>
                    </div>
                    <div class="box-container">
                        <div class="box one"> <span
                                class="center-text">{{ floor(session('HistoryAndonOpenReceived') / 60) . ' H ' . session('HistoryAndonOpenReceived') % 60 . ' M' }}</span>
                        </div>
                        <i class="fa-sharp fa-solid fa-circle-plus" style="font-size: 30px; margin-top: 15px;"></i>

                        <div class="box two"> <span
                                class="center-text">{{ floor(session('HistoryAndonReceivedSolving') / 60) . ' H ' . session('HistoryAndonReceivedSolving') % 60 . ' M' }}</span>
                        </div>
                        <i class="fa-sharp fa-solid fa-circle-plus" style="font-size: 30px; margin-top: 15px;"></i>

                        <div class="box three"><span
                                class="center-text">{{ floor(session('HistoryAndonSolvingAccepted') / 60) . ' H ' . session('HistoryAndonSolvingAccepted') % 60 . ' M' }}</span>
                        </div>
                        <i class="fa-sharp fa-solid fa-circle-plus" style="font-size: 30px; margin-top: 15px;"></i>

                        <div class="box four"> <span
                                class="center-text">{{ floor(session('HistoryAndonAcceptedClosed') / 60) . ' H ' . session('HistoryAndonAcceptedClosed') % 60 . ' M' }}</span>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div style="display: flex; justify-content:center; align-items: center; margin-top: 45px;">
                            <h1 style="font-size: 20px; margin-top: 3px;">Accumulated Delays :</h1>
                            <div class="horizontal-boxes">
                                <div class="box-delays box 1"><span
                                        class="center-text">{{ floor(session('HistoryandonAccumulatedTime') / 60) . ' Hours ' . session('HistoryandonAccumulatedTime') % 60 . ' Minutes' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif (session('HistoryAndonDateSolving') != null)
        @else
        @endif
        {{-- END STEPPER --}}

    </div>


    <script src="{{ asset('js/config.js') }}"></script>

    {{-- <script async defer src="https://buttons.github.io/buttons.js"></script> --}}

    <script>
        $('.timepicker').timepicker({
            showInputs: false,
            showMeridian: false
        });

        $('.timepicker').timepicker();
    </script>

    {{-- Refresh button --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const refreshButton = document.getElementById("refreshbutton");
            if (refreshButton) {
                refreshButton.addEventListener("click", function() {
                    location.reload(); // Reload the page
                });
            }
        });
    </script>
@endsection

@push('andon-stepper')
    <link rel="stylesheet" href="{{ asset('css/andon.css') }}" />
@endpush
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var flatpickrRange = flatpickr("#daterange", {
                mode: "range",
            });

            $('#daterange').on('apply.daterangepicker', function(ev, picker) {
                // Update the flatpickr range when the date range is applied
                $('#daterange').val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format(
                    'YYYY-MM-DD'));
            });

            $('#daterange').on('cancel.daterangepicker', function() {
                // Clear the flatpickr range when the date range is cleared
                $('#daterange').val('');
            });
        });
    </script>
@endpush
