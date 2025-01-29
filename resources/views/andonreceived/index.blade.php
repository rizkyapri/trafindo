@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between">
            <h3 style="font-size: 32px; font-weight: bold; color: black">
                <i class="fa-solid fa-land-mine-on" style="margin-right: 10px;"></i>Andon Received
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

        <div class="row">
            <div class="col-md-6" style="margin-top: 38px;">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title"><strong>Delays</strong></h5>
                        <button id="refreshbutton" type="button" class="btn btn-sm btn-primary">
                            <i class="fas fa-rotate-right"></i>
                        </button>

                    </div>
                    <div class="card-body">
                        <!-- Set max height and enable overflow-y -->
                        <div style="min-height: 378px; max-height: 378px; overflow-y: auto;" class="table-responsive">
                            <table class="table table-hover" id="myTable">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Serie</th>
                                        <th>WC</th>
                                        <th>Action</th>
                                        {{-- <th>Times</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($andonData as $data)
                                        <tr>
                                            @if ($data->AndonDateClosed === null)
                                                <td>
                                                    @if ($data->Andon_Color == 'YELLOW')
                                                        <span class="badge bg-warning me-1"> YELLOW</span>
                                                    @elseif ($data->Andon_Color == 'RED')
                                                        <span class="badge bg-danger me-1"> RED</span>
                                                    @else
                                                        <span class="badge bg-secondary me-1"> NO DATA</span>
                                                    @endif
                                                </td>
                                                <td>{{ strtoupper($data->Andon_Serie) }}</td>
                                                <td>{{ $data->Workcenter }}</td>
                                                {{-- <td>tes</td> --}}
                                                <td>
                                                    @if ($data->AndonDateSolving === null)
                                                        <form
                                                            action="{{ route('save.to.session', ['andonSerie' => $data->Andon_Serie]) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-primary">Receive
                                                            </button>
                                                        </form>
                                                    @elseif ($data->AndonDateAccepted != null)
                                                        <form
                                                            action="{{ route('save.to.session', ['andonSerie' => $data->Andon_Serie]) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-primary">Accepted
                                                            </button>
                                                        </form>
                                                    @else
                                                    @endif

                                                </td>
                                            @else
                                                <td>No Data</td>
                                                <td>No Data</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            @if (session('Andon_Serie') && session('AndonDateSolving') === null)
                <div class="col-md-6" style="margin-top: 37px;">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('update.andon.received', ['andonSerie' => session('Andon_Serie')]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row g-4">
                                    <div class="col mb-0">
                                        <label for="NoAndon" class="form-label" style="font-weight: bold;">No.
                                            Andon</label>
                                        <input type="text" id="NoAndon" class="form-control"
                                            value="{{ strtoupper(session('Andon_Serie')) }}" readonly>
                                    </div>
                                    <div class="col mb-0">
                                        <label for="WorkCenter" class="form-label" style="font-weight: bold;">Work
                                            Center</label>
                                        <input type="text" id="WorkCenter" class="form-control"
                                            value="{{ strtoupper(session('Workcenter')) }}" readonly>
                                    </div>
                                </div>
                                <div class="row g-4 mt-3">
                                    <div class="col mb-0">
                                        <label for="OpBy" class="form-label" style="font-weight: bold;">Open
                                            By:</label>
                                        <input type="text" id="OpBy" class="form-control"
                                            value="{{ session('RiseUp_EmployeeName') }}" readonly>
                                    </div>
                                    <div class="col mb-0">
                                        <label for="WO" class="form-label" style="font-weight: bold;">Work
                                            Order</label>
                                        <input type="text" id="WO" class="form-control"
                                            value="{{ strtoupper(session('RiseUp_OprNo')) }}" readonly>
                                    </div>
                                </div>
                                <div class="row g-4 mt-3">
                                    <div class="col mb-0">
                                        <label for="DescriptionProblem" class="form-label"
                                            style="font-weight: bold;">Problem
                                            Description:</label>
                                        <textarea type="text" id="DescriptionProblem" class="form-control" name="DescriptionProblem"
                                            placeholder="Enter Problem Description" rows="4" readonly>{{ session('DescriptionProblem') }}</textarea>
                                        @error('DescriptionProblem')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col mb-0">
                                        <label for="DescriptionSolving" class="form-label"
                                            style="font-weight: bold;">Solving
                                            Action:</label>
                                        <textarea type="text" id="DescriptionSolving" class="form-control" name="DescriptionSolving"
                                            placeholder="Enter Solving Action" rows="4">{{ old('DescriptionSolving') }}</textarea>
                                        @error('DescriptionSolving')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="card-footer d-flex justify-content-center align-items-center">
                                    <button type="submit" class="btn btn-primary">Solving Andon</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            @elseif (session('Andon_Serie') && session('AndonDateSolving') !== null)
                <div class="col-md-6" style="margin-top: 37px;">
                    <div class="card">
                        <div class="card-body">
                            <form
                                action="{{ route('update.andon.received.solved', ['andonSerie' => session('Andon_Serie')]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="col mb-0">
                                    <label for="AndonRemark" class="form-label" style="font-weight: bold;">Remark :
                                    </label>
                                    <textarea type="text" id="AndonRemark" class="form-control" name="AndonRemark" placeholder="Enter Remark"
                                        value="{{ old('AndonRemark') }}" rows="4"></textarea>
                                </div>
                                <div class="card-footer d-flex justify-content-center align-items-center">
                                    <button type="submit" class="btn btn-primary">Close Andon</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @else
            @endif

            {{-- END FORM --}}

            {{-- STEPPER --}}
            @if (session('Andon_Serie') && session('AndonDateSolving') === null)
                <div style="margin-top: 32px;">
                    <div class="card">
                        <div class="card-header">
                            <section class="stepper"
                                style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                <ul>
                                    <li class="stepper1 {{ session('AndonDateOpen') ? 'checked' : '' }}">
                                        <i class="icon uil uil-folder-open color-1"></i>
                                        <div class="progress one">
                                            <p class="pt-1">1</p>
                                            <i class="uil uil-check"></i>
                                        </div>
                                        <p class="text">Open</p>
                                        <div class="shadow-sm p-3 mb-10 bg-white rounded"
                                            style="border: 1px solid #fa994b;">
                                            {{ session('AndonDateOpen') }}
                                        </div>
                                    </li>
                                    <li class="stepper2 {{ session('AndonDateReceived') ? 'checked' : '' }}">
                                        <i class="icon uil uil-envelope-download color-2"></i>
                                        <div class="progress two">
                                            <p class="pt-1">2</p>
                                            <i class="uil uil-check"></i>
                                        </div>
                                        <p class="text">Received</p>
                                        <div class="shadow-sm p-3 mb-10 bg-white rounded"
                                            style="border: 1px solid #8699a8;">
                                            {{ session('AndonDateReceived') }}
                                        </div>
                                    </li>
                                    <li class="stepper3 {{ session('AndonDateSolving') ? 'checked' : '' }}">
                                        <i class="icon uil uil-wrench color-3"></i>
                                        <div class="progress three">
                                            <p class="pt-1">3</p>
                                            <i class="uil uil-check"></i>
                                        </div>
                                        <p class="text">Solving</p>
                                        <div class="shadow-sm p-3 mb-10 bg-white rounded"
                                            style="border: 1px solid #f5c861;">
                                            {{ session('AndonDateSolving') }}
                                        </div>
                                    </li>
                                    <li class="stepper4 {{ session('AndonDateAccepted') ? 'checked' : '' }}">
                                        <i class="icon uil uil-check-circle color-4"></i>
                                        <div class="progress four">
                                            <p class="pt-1">4</p>
                                            <i class="uil uil-check"></i>
                                        </div>
                                        <p class="text">Accepted</p>
                                        <div class="shadow-sm p-3 mb-10 bg-white rounded"
                                            style="border: 1px solid #2496d2;">
                                            {{ session('AndonDateAccepted') }}
                                        </div>
                                    </li>
                                    <li class="stepper5 {{ session('AndonDateClosed') ? 'checked' : '' }}">
                                        <i class="icon uil uil-minus-square-full color-5"></i>
                                        <div class="progress five">
                                            <p class="pt-1">5</p>
                                            <i class="uil uil-check"></i>
                                        </div>
                                        <p class="text">Closed</p>
                                        <div class="shadow-sm p-3 mb-10 bg-white rounded"
                                            style="border: 1px solid #3c9c30;">
                                            {{ session('AndonDateClosed') }}
                                        </div>
                                    </li>
                                </ul>
                            </section>
                        </div>
                        <div class="box-container">
                            <div class="box one"> <span
                                    class="center-text">{{ floor(session('AndonOpenReceived') / 60) . ' H ' . session('AndonOpenReceived') % 60 . ' M' }}</span>
                            </div>
                            <i class="fa-sharp fa-solid fa-circle-plus" style="font-size: 30px; margin-top: 15px;"></i>

                            <div class="box two"> <span
                                    class="center-text">{{ floor(session('AndonReceivedSolving') / 60) . ' H ' . session('AndonReceivedSolving') % 60 . ' M' }}</span>
                            </div>
                            <i class="fa-sharp fa-solid fa-circle-plus" style="font-size: 30px; margin-top: 15px;"></i>

                            <div class="box three"><span
                                    class="center-text">{{ floor(session('AndonSolvingAccepted') / 60) . ' H ' . session('AndonSolvingAccepted') % 60 . ' M' }}</span>
                            </div>
                            <i class="fa-sharp fa-solid fa-circle-plus" style="font-size: 30px; margin-top: 15px;"></i>

                            <div class="box four"> <span
                                    class="center-text">{{ floor(session('AndonAcceptedClosed') / 60) . ' H ' . session('AndonAcceptedClosed') % 60 . ' M' }}</span>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div style="display: flex; justify-content:center; align-items: center; margin-top: 45px;">
                                <h1 style="font-size: 20px; margin-top: 3px;">Accumulated Delays :</h1>
                                <div class="horizontal-boxes">
                                    <div class="box-delays box 1"><span
                                            class="center-text">{{ floor(session('andonAccumulatedTime') / 60) . ' Hours ' . session('andonAccumulatedTime') % 60 . ' Minutes' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif (session('AndonDateSolving') !== null)
            @else
            @endif
            {{-- END STEPPER --}}

        </div>
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

    <script>
        ;

        function autoRefresh() {
            location.reload();
        }
        setInterval(autoRefresh, 15000);
    </script>
    @if ($playAudio)
        <script>
            var audio = new Audio("{{ asset('audio/Sirine.mp3') }}");
            audio.play();
        </script>
    @endif

    {{-- @if ($showModal)
    <script>
        $(document).ready(function() {
            $("#notificationModal").modal("show");
        });
    </script>
@endif --}}

    <script>
        function stopAudio() {
            // Hentikan audio di sini
            var audio = new Audio("{{ asset('audio/Sirine.mp3') }}");
            audio.pause();
            audio.currentTime = 0;
        }
    </script>
@endsection

@push('andon-stepper')
    <link rel="stylesheet" href="{{ asset('css/andon.css') }}" />
@endpush
