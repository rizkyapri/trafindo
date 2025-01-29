<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Operator Trafindo</title>

    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/trafindo.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/operator.css') }}" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="{{ asset('vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Include Toastify CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
        integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <!-- Page CDN CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Helpers -->
    <script src="{{ asset('vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('js/config.js') }}"></script>
    <style>
        /* Custom styles for star rating */
        .rating {
            display: inline-block;
            font-size: 24px;
        }

        .rating .fa-star {
            color: goldenrod;
            cursor: pointer;
        }

        .rating .fa-star:hover,
        .rating .fa-star.active {
            color: gold;
        }
    </style>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu sidebar -->

            @include('includes.sidebarOperator')
            <!-- / Menu sidebar -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    {{-- navbar --}}
                    @include('includes.navbar')
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="d-flex justify-content-between align-items-center">

                             <h3 class="card-header text-uppercase text-dark">

                                <i class="fa-regular fa-hourglass-half"
                                    style="margin-right: 10px; color:
                                    black"></i>Real-Time
                                Status
                                Employee
                            </h3>
                            <div>

                                <!-- Andon rise up -->

                                @if (session('andonRiseUpWO') && session('andonRiseUpEmployeeNumber'))

                                    <div class="modal fade" data-bs-backdrop="static" id="largeModal" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="detailModalLabel"><strong>Andon Rise
                                                            Up</strong></h5>
                                                    <h5 style="margin-left: 40%" class="modal-title">Status:
                                                        @if (session('Andon_Color') == 'YELLOW')
                                                            <span class="badge bg-warning me-1"> YELLOW</span>
                                                        @elseif (session('Andon_Color') == 'RED')
                                                            <span class="badge bg-danger me-1"> RED</span>
                                                        @else
                                                            <span class="badge bg-secondary me-1"> NO DATA</span>
                                                        @endif
                                                    </h5>

                                                    <form action="{{ route('operator.close') }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                        </button>
                                                    </form>
                                                </div>
                                                <hr>
                                                <div class="modal-body">
                                                    <form action="{{ route('operator.store.andon') }}" method="POST">
                                                        @csrf
                                                        <div style="justify-content: center; text-align:center; font-size:25px;"
                                                            class="mb-3">
                                                            <span class="badge bg-primary me-1">
                                                                {{ session('andon_no') }}
                                                            </span>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 mb-0">
                                                                <label for="Workcenter" class="form-label">Work
                                                                    Center</label>
                                                                <input type="text" id="Workcenter"
                                                                    class="form-control" name="Workcenter" readonly
                                                                    placeholder="Enter Work Center"
                                                                    value="{{ old('Workcenter') ? old('Workcenter') : session('Workcenter') }}">
                                                            </div>
                                                            <div class="col-md-6 mb-0">
                                                                <label class="form-label"
                                                                    for="CategoryProblem">Problem
                                                                    Category</label>
                                                                <div class="col">
                                                                    <div class="input-group input-group-merge">
                                                                        <input type="text" id="CategoryProblem"
                                                                            class="form-control"
                                                                            name="CategoryProblem" readonly
                                                                            placeholder="Enter Work Center"
                                                                            value="{{ old('CategoryProblem') ? old('CategoryProblem') : session('CategoryProblem') }}">
                                                                    </div>
                                                                    @error('CategoryProblem')
                                                                        <span
                                                                            class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-md-6 mb-0">
                                                                <label for="AssignTo" class="form-label">Assign
                                                                    To</label>
                                                                <input type="text" id="AssignTo"
                                                                    class="form-control" name="AssignTo" readonly
                                                                    placeholder="Enter Work Center"
                                                                    value="{{ old('AssignTo') ? old('AssignTo') : session('AssignTo') }}">
                                                            </div>
                                                            <div class="col mb-0">
                                                                <label for="andonRiseUpEmployeeName"
                                                                    class="form-label">Employee Name</label>
                                                                <input type="text" id="andonRiseUpEmployeeName"
                                                                    class="form-control"
                                                                    name="andonRiseUpEmployeeName" readonly
                                                                    value="{{ old('andonRiseUpEmployeeName') ? old('andonRiseUpEmployeeName') : session('andonRiseUpEmployeeName') }}">
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-md-6 mb-0">
                                                                <label for="andonRiseUpEmployeeNumber"
                                                                    class="form-label">Employee Number</label>
                                                                <input type="text" id="andonRiseUpEmployeeNumber"
                                                                    class="form-control"
                                                                    name="andonRiseUpEmployeeNumber" readonly
                                                                    value="{{ old('andonRiseUpEmployeeNumber') ? old('andonRiseUpEmployeeNumber') : session('andonRiseUpEmployeeNumber') }}">

                                                            </div>
                                                            <div class="col-md-6 mb-0">
                                                                <label for="NOWO" class="form-label">No. Work
                                                                    Order</label>
                                                                <input type="text" id="andonRiseUpWO"
                                                                    class="form-control" name="andonRiseUpWO" readonly
                                                                    value="{{ old('andonRiseUpWO') ? old('andonRiseUpWO') : session('andonRiseUpWO') }}">
                                                            </div>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <label for="DescriptionProblem">Message</label>
                                                            <textarea id="DescriptionProblem" name="DescriptionProblem" placeholder="Enter Your Message" rows="4"
                                                                cols="50"></textarea>

                                                        </div>
                                                        <div style="text-align: end;" class="mt-4">
                                                            <button type="submit"
                                                                class="btn btn-primary">Send</button>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{-- TEST ANDON ACCEPTED --}}
                                @if (session('AndonEmpSession'))
                                    <div class="modal fade" id="andonAccepted" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLabel1">
                                                        <strong>Accepted Andon</strong>
                                                    </h3>
                                                    <h5 style="padding-left: 49%" class="modal-title mx-2">
                                                        Employee
                                                        ID:
                                                    </h5>
                                                    <div class="col mb-0 mx-4">
                                                        <input type="text" id="EmployeeID" class="form-control"
                                                            placeholder="Enter Employee ID"
                                                            value="{{ $AndonEmpSession->RiseUp_EmployeeNo }}"
                                                            readonly>
                                                    </div>
                                                    <form action="{{ route('operator.close') }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </form>
                                                </div>
                                                <hr>
                                                <div class="modal-body">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <!-- Left Grid -->
                                                                <div class="row g-3">
                                                                    <div class="col mb-0">
                                                                        <label for="NoAndon" class="form-label">No.
                                                                            Andon</label>
                                                                        <input type="text" id="NoAndon"
                                                                            class="form-control"
                                                                            value="{{ substr($AndonEmpSession->Andon_Serie, 6) }}"
                                                                            placeholder="Enter No. Andon" readonly>
                                                                    </div>
                                                                    <div class="col mb-0">
                                                                        <label for="WorkCenter"
                                                                            class="form-label">Work
                                                                            Center</label>
                                                                        <input type="text" id="WorkCenter"
                                                                            class="form-control"
                                                                            value="{{ $AndonEmpSession->Workcenter }}"
                                                                            placeholder="Enter Work Order" readonly>
                                                                    </div>
                                                                    <div class="col mb-0">
                                                                        <label for="OpBy" class="form-label">Open
                                                                            By:</label>
                                                                        <input type="email" id="OpBy"
                                                                            value="{{ $AndonEmpSession->RiseUp_EmployeeName }}"
                                                                            class="form-control"
                                                                            placeholder="Open By:" readonly>
                                                                    </div>
                                                                    <div class="col mb-0">
                                                                        <label for="WO" class="form-label">Work
                                                                            Order</label>
                                                                        <input type="text" id="WO"
                                                                            class="form-control"
                                                                            value="{{ $AndonEmpSession->RiseUp_OprNo }}"
                                                                            placeholder="Enter Work Order" readonly>
                                                                    </div>

                                                                    <section class="step-wizard">
                                                                        <ul class="step-wizard-list">
                                                                            <li class="step-wizard-item"
                                                                                data-step="1">
                                                                                <span class="progress-count">1</span>
                                                                                <span
                                                                                    class="progress-label">Open</span>
                                                                                <div
                                                                                    class="shadow-sm p-3 mb-5 bg-body rounded">
                                                                                    {{ $AndonEmpSession->AndonDateOpen }}
                                                                                </div>

                                                                            </li>
                                                                            <li class="step-wizard-item"
                                                                                data-step="2">
                                                                                <span class="progress-count">2</span>
                                                                                <span
                                                                                    class="progress-label">Received</span>
                                                                                <div
                                                                                    class="shadow-sm p-3 mb-5 bg-body rounded">
                                                                                    {{ $AndonEmpSession->AndonDateReceived }}
                                                                                </div>
                                                                            </li>
                                                                            <li class="step-wizard-item"
                                                                                data-step="3">
                                                                                <span class="progress-count">3</span>
                                                                                <span
                                                                                    class="progress-label">Solving</span>
                                                                                <div
                                                                                    class="shadow-sm p-3 mb-5 bg-body rounded">
                                                                                    {{ $AndonEmpSession->AndonDateSolving }}
                                                                                </div>
                                                                            </li>
                                                                            <li class="step-wizard-item"
                                                                                data-step="4">
                                                                                <span class="progress-count">4</span>
                                                                                <span
                                                                                    class="progress-label">Accepted</span>
                                                                                <div
                                                                                    class="shadow-sm p-3 mb-5 bg-body rounded">
                                                                                    {{ $AndonEmpSession->AndonDateAccepted }}
                                                                                </div>
                                                                            </li>
                                                                            <li class="step-wizard-item"
                                                                                data-step="5">
                                                                                <span class="progress-count">5</span>
                                                                                <span
                                                                                    class="progress-label">Closed</span>
                                                                                <div
                                                                                    class="shadow-sm p-3 mb-5 bg-body rounded">
                                                                                    {{ $AndonEmpSession->AndonDateClosed }}
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </section>


                                                                </div>
                                                                <div class="row g-3 mt-3">
                                                                    <div class="col mb-0">
                                                                        <label for="OpBy"
                                                                            class="form-label">Problem
                                                                            Description:</label>
                                                                        <textarea type="text" id="WO" class="form-control" placeholder="Enter Work Order" rows="4"
                                                                            readonly>{{ $AndonEmpSession->DescriptionProblem }}</textarea>
                                                                    </div>
                                                                    <div class="col mb-0">
                                                                        <label for="WO"
                                                                            class="form-label">Solving
                                                                            Action:</label>
                                                                        <textarea type="text" id="ProblemCategory" name="ProblemCategory" class="form-control"
                                                                            placeholder="Enter Work Order" rows="4" readonly>{{ $AndonEmpSession->DescriptionSolving }}</textarea>
                                                                        {{-- <textarea id="Message" name="Message" rows="4" cols="50"></textarea> --}}
                                                                    </div>
                                                                </div>
                                                                <form method="POST"
                                                                    action="{{ route('operator.storeAndonAcc') }}">
                                                                    @csrf

                                                                    @if (!empty($AndonEmpSession->AndonDateSolving))
                                                                        <div class="row g-3">
                                                                            <div class="col md-4">
                                                                                <div class="card mt-4"
                                                                                    style="justify-content:center; text-align:center; ">
                                                                                    <div class="card-body">
                                                                                        <h5
                                                                                            class="card-title text-center">
                                                                                            Score Andon
                                                                                        </h5>
                                                                                        <div
                                                                                            class="rating d-flex justify-content-center align-items-center">
                                                                                            <i class="fas fa-star"
                                                                                                style="padding-right: 5px;"></i>
                                                                                            <i class="fas fa-star"
                                                                                                style="padding-right: 5px;"></i>
                                                                                            <i class="fas fa-star"
                                                                                                style="padding-right: 5px;"></i>
                                                                                            <i class="fas fa-star"
                                                                                                style="padding-right: 5px;"></i>
                                                                                            <i class="fas fa-star"
                                                                                                style="padding-right: 5px;"></i>
                                                                                        </div>
                                                                                        <!-- Input tersembunyi untuk menyimpan rating -->
                                                                                        <input type="hidden"
                                                                                            name="rating"
                                                                                            id="rating"
                                                                                            value="0">

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="modal-footer d-flex justify-content-center align-items-center">
                                                    <form action="{{ route('operator.close') }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </form>
                                                    <form method="POST"
                                                        action="{{ route('operator.storeAndonAcc') }}">
                                                        @csrf
                                                        @if (!empty($AndonEmpSession->AndonDateSolving))
                                                            <button type="submit" class="btn btn-primary">Accepted
                                                                Andon</button>
                                                        @endif
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>

                        <hr>
                        <div style="background-color: #DBD5D5;" class="card">
                            @if (session('success'))
                                <div class="alert alert-success text-center fs-5">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('warning'))
                                <div class="alert alert-warning text-center fs-5">
                                    {{ session('warning') }}
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger text-center fs-5">
                                    {{ session('error') }}
                                </div>
                            @endif


                            <div class="row" style="background-color: #DBD5D5;">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <!-- Set max height and enable overflow-y -->
                                            <table id="leftTable" class="table table-sm">
                                                <thead>
                                                    <th>Employees Name</th>
                                                    <th>Status</th>
                                                </thead>

                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <!-- Set max height and enable overflow-y -->
                                            <table id="rightTable" class="table table-sm">
                                                <!-- Define the second table with a unique ID -->
                                                <thead>
                                                    <th>Employees Name</th>
                                                    <th>Status</th>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--/ Hoverable Table rows -->
                        </div>
                    </div>
                    <!-- SCAN Modal -->
                    <div class="modal fade" id="exampleModal" data-bs-backdrop="false" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">QR SCAN</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body row justify-content-center align-items-center">
                                    {{-- Reader SCANNER --}}
                                    <video id="preview"></video>
                                    {{-- <div style="width: 500px" id="reader"></div> --}}
                                    {{-- <div id="qr-code-scanner"></div> --}}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- end Modal --}}
                    @if (session('currentWorkOrder'))
                        {{-- @dd($WorkOrderSession) --}}
                        <!-- DETAIL Modal -->
                        <div class="modal fade" id="detailModal" data-bs-backdrop="false" tabindex="-1"
                            role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detailModalLabel">Employee Detail Activity</h5>
                                        <form action="{{ route('operator.close') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                            </button>
                                        </form>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Button Aksi -->
                                        <div class="text-center d-flex justify-content-center">
                                            @if (!is_null($WorkOrderSession) && is_null($WorkOrderSession->TaskStatus))
                                                <!-- Tombol Start -->
                                                <form action="{{ route('operator.start') }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn text-danger d-flex flex-column align-items-center">
                                                        <i class="fa fa-play-circle" style="font-size: 50px"
                                                            aria-hidden="true"></i>
                                                        Start
                                                    </button>
                                                </form>
                                            @elseif ($WorkOrderSession->TaskStatus == 'B' || $WorkOrderSession->TaskStatus == 'C')
                                                <!-- Tombol Stop -->
                                                <form action="{{ route('operator.stop') }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn text-danger d-flex flex-column align-items-center">
                                                        <i class="fa-solid fa-circle-stop fs-1"
                                                            style="margin-bottom: 5px; color: black;"></i>
                                                        STOP
                                                    </button>
                                                </form>
                                                <!-- Tombol Finish -->
                                                <form action="{{ route('operator.finish') }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn text-danger d-flex flex-column align-items-center">
                                                        <i class="fa-solid fa-circle-check fs-1"
                                                            style="color: green;"></i>
                                                        FINISH
                                                    </button>
                                                </form>
                                            @elseif ($WorkOrderSession->TaskStatus == 'S')
                                                <!-- Tombol Continue -->
                                                <form action="{{ route('operator.continue') }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn text-danger d-flex flex-column align-items-center">
                                                        <i class="fa-solid fa-circle-pause"
                                                            style="margin-bottom: 5px;"></i>
                                                        CONTINUE
                                                    </button>
                                                </form>
                                            @endif
                                        </div>

                                        <h6 class="mt-2">{{ date('d-F-y') }}</h6>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p>ID : {{ $employeeTabel->EmployeeNumber }}</p>
                                            </div>
                                            <div>
                                                <p>Nama : {{ $employeeTabel->Name }}</p>
                                            </div>
                                        </div>

                                        <!-- Hoverable Table rows -->
                                        <div class="card">
                                            <div class="table-responsive text-nowrap">
                                                <table class="table table-hover">
                                                    <thead class="bg-dark">
                                                        <tr>
                                                            <th class="text-white">WO-Opr ID</th>
                                                            <th class="text-white">Title</th>
                                                            <th class="text-white">Start</th>
                                                            <th class="text-white">Stop</th>
                                                            <th class="text-white">Task Status</th>
                                                        </tr>
                                                    </thead>
                                                    @foreach ($WorkOrderOperationSession as $task)
                                                        <tbody class="table-border-bottom-0">
                                                            <tr>
                                                                <td>
                                                                    {{ $task->WONumber . $task->OprNumber }}
                                                                </td>
                                                                <td>
                                                                    {{ $task->OprName }}
                                                                </td>
                                                                <td>
                                                                    {{ $task->TaskDateStart ? date('H:i', strtotime($task->TaskDateStart)) : '' }}
                                                                </td>
                                                                <td>
                                                                    {{ $task->TaskDateEnd ? date('H:i', strtotime($task->TaskDateEnd)) : '' }}
                                                                </td>
                                                                <td>
                                                                    @if ($task->TaskStatus == 'B')
                                                                        <span class="badge bg-primary me-1">
                                                                            Start
                                                                        </span>
                                                                    @elseif ($task->TaskStatus == 'C')
                                                                        <span class="badge bg-info me-1">
                                                                            Continue
                                                                        </span>
                                                                    @elseif ($task->TaskStatus == 'S')
                                                                        <span class="badge bg-danger me-1">
                                                                            Stop
                                                                        </span>
                                                                    @elseif ($task->TaskStatus == 'F')
                                                                        <span class="badge bg-success me-1">
                                                                            Finish
                                                                        </span>
                                                                    @endif

                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    @endforeach
                                                </table>
                                                <br>
                                            </div>
                                        </div>
                                        <!-- Hoverable Table rows -->
                                        <div class="card mt-2">
                                            <div class="table-responsive text-nowrap">
                                                <table class="table table-hover">
                                                    <thead class="bg-dark">
                                                        <tr>
                                                            <th class="text-white">Monitoring Hours</th>
                                                            <th class="text-white">Today</th>
                                                            <th class="text-white">This Month</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table-border-bottom-0">
                                                        <tr>
                                                            <td class="text-primary">Working Hours Total</td>
                                                            <td>0</td>
                                                            <td></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <h5 class="modal-title mt-4" id="detailModalLabel">Operation Progress Status
                                        </h5>
                                        <div class="d-flex mt-2">
                                            <p>WO Number : </p>
                                            <p class="text-danger">
                                                &nbsp;{{ $WorkOrderSession->WONumber . $WorkOrderSession->OprNumber }}
                                            </p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex">
                                                <p>WO-Opr. Name : </p>
                                                <p class="text-primary text-uppercase">
                                                    &nbsp;{{ $WorkOrderSession->OprName }}</p>
                                            </div>
                                            <div class="d-flex">
                                                <p>Work Center : </p>
                                                <p class="text-primary">&nbsp;{{ $WorkOrderSession->Workcenter }}</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex">
                                                <p>WO-Opr. Status : </p>
                                                <p class="text-danger">&nbsp;Issued</p>
                                            </div>
                                        </div>
                                        <!-- Hoverable Table rows -->
                                        <div class="card">
                                            <div class="table-responsive text-nowrap">
                                                <table class="table table-hover">
                                                    <thead class="bg-dark">
                                                        <tr>
                                                            <th class="text-white">Progress</th>
                                                            <th class="text-white">Plan</th>
                                                            <th class="text-white">Actual</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table-border-bottom-0">
                                                        <tr>
                                                            <td class="text-primary">Date Issued</td>
                                                            <td class="text-primary">
                                                                {{ date('j-M-y', strtotime($WorkOrderSession->OprPlanBegin)) }}
                                                            </td>
                                                            <td>29-jan-23</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-primary">Date Closed</td>
                                                            <td class="text-primary">
                                                                {{ date('j-M-y', strtotime($WorkOrderSession->OprPlanEnd)) }}
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-primary">Total Hours</td>
                                                            <td class="text-primary"></td>
                                                            <td class="text-danger">0</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <form action="{{ route('operator.close') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end Modal --}}
                    @endif
                    @if (session('WOEmployee'))
                        <!-- DETAIL Modal -->
                        <div class="modal fade" id="detailWOModal" data-bs-backdrop="true" tabindex="-1"
                            role="dialog" aria-labelledby="detailWOModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detailWOModalLabel">WO-Operation Activity Detail
                                        </h5>
                                        <form action="{{ route('operator.close') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                            </button>
                                        </form>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Button Aksi -->
                                        <div class="text-center d-flex justify-content-center">

                                            @if (session('EmployeeFinishWO'))
                                                <!-- Tombol Finish -->
                                                <form action="{{ route('operator.finish') }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn text-danger d-flex flex-column align-items-center">
                                                        <i class="fa-solid fa-circle-check fs-1"
                                                            style="color: green;"></i>
                                                        FINISH
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                        <h6 class="mt-2">{{ date('d-F-y') }}</h6>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p>ID : {{ $WOData->WONumber . $WOData->OprNumber }}</p>
                                            </div>
                                            <div>
                                                <p>Name : {{ $WOData->OprName }}</p>
                                            </div>
                                        </div>

                                        <!-- Hoverable Table rows -->
                                        <div class="card">
                                            <div class="table-responsive text-nowrap">
                                                <table class="table table-hover">
                                                    <thead class="bg-dark">
                                                        <tr>
                                                            <th class="text-white">Name</th>
                                                            <th class="text-white">ID</th>
                                                            <th class="text-white">Working Hours Total</th>
                                                        </tr>
                                                    </thead>@php
                                                        $totalMinutes = 0;
                                                    @endphp
                                                    @foreach ($groupedTasks as $name => $tasks)
                                                        <tbody class="table-border-bottom-0">
                                                            <tr>
                                                                <td>
                                                                    {{ $name }}
                                                                </td>
                                                                <td>
                                                                    {{ $tasks[0]->EmployeeNumber }}
                                                                </td>
                                                                <td>
                                                                    @php
                                                                        $totalMinutesGroup = $tasks->sum('totalMinutes');
                                                                        $totalMinutes += $totalMinutesGroup;
                                                                        $hoursGroup = floor($totalMinutesGroup / 60);
                                                                        $minutesGroup = $totalMinutesGroup % 60;
                                                                        echo $hoursGroup > 0 ? $hoursGroup . ' hours ' : '';
                                                                        echo $minutesGroup . ' minutes';
                                                                    @endphp
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    @endforeach
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <br>
                                            </div>
                                        </div>
                                        <!-- Hoverable Table rows -->
                                        <div class="card mt-2">
                                            <div class="table-responsive text-nowrap">
                                                <table class="table table-hover">
                                                    <thead class="bg-dark">
                                                        <tr>
                                                            <th class="text-white">Monitoring Hours</th>
                                                            <th class="text-white">STD</th>
                                                            <th class="text-white">Actual</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table-border-bottom-0">
                                                        <tr>
                                                            <td class="text-primary">Total Hours Consumption</td>
                                                            <td></td>
                                                            <td class="text-danger">
                                                                @php
                                                                    $totalHours = floor($totalMinutes / 60);
                                                                    $minutes = $totalMinutes % 60;
                                                                    echo $totalHours > 0 ? $totalHours . ' hours ' : '';
                                                                    echo $minutes . ' minutes';
                                                                @endphp
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <h5 class="modal-title mt-4" id="detailModalLabel">Operation Progress Status
                                        </h5>
                                        <div class="d-flex mt-2">
                                            <p>WO Number : </p>
                                            <p class="text-danger">
                                                &nbsp;{{ $WOData->WONumber . $WOData->OprNumber }}
                                            </p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex">
                                                <p>WO-Opr. Name : </p>
                                                <p class="text-primary text-uppercase">
                                                    &nbsp;{{ $WOData->OprName }}</p>
                                            </div>
                                            <div class="d-flex">
                                                <p>Work Center : </p>
                                                <p class="text-primary">&nbsp;{{ $WOData->Workcenter }}</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex">
                                                <p>WO-Opr. Status : </p>
                                                <p class="text-danger">&nbsp;Issued</p>
                                            </div>
                                        </div>
                                        <!-- Hoverable Table rows -->
                                        <div class="card">
                                            <div class="table-responsive text-nowrap">
                                                <table class="table table-hover">
                                                    <thead class="bg-dark">
                                                        <tr>
                                                            <th class="text-white">Progress</th>
                                                            <th class="text-white">Plan</th>
                                                            <th class="text-white">Actual</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table-border-bottom-0">
                                                        <tr>
                                                            <td class="text-primary">Date Issued</td>
                                                            <td class="text-primary">
                                                                {{ date('j-M-y', strtotime($WOData->OprPlanBegin)) }}
                                                            </td>
                                                            <td>29-jan-23</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-primary">Date Closed</td>
                                                            <td class="text-primary">
                                                                {{ date('j-M-y', strtotime($WOData->OprPlanEnd)) }}
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-primary">Total Hours</td>
                                                            <td class="text-primary"></td>
                                                            <td class="text-danger">
                                                                @php
                                                                    $totalHours = floor($totalMinutes / 60);
                                                                    $minutes = $totalMinutes % 60;
                                                                    echo $totalHours > 0 ? $totalHours . ' hours ' : '';
                                                                    echo $minutes . ' minutes';
                                                                @endphp
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div style="display: flex; justify-content: space-between;">
                                            <!-- Tabel Kiri -->
                                            <div style="flex: 1; margin-right: 10px;">
                                                <h5 class="modal-title mt-4 mb-2" id="detailModalLabel">
                                                    Operator Today
                                                </h5>
                                                <div class="card">
                                                    <div class="table-responsive text-nowrap">
                                                        <table class="table table-hover">
                                                            <thead class="bg-dark">
                                                                <tr>
                                                                    <th class="text-white">Name</th>
                                                                    <th class="text-white">ID</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="table-border-bottom-0">
                                                                <td>
                                                                    {{ $WOData->Name }}
                                                                </td>
                                                                <td>
                                                                    {{ $WOData->EmployeeNumber }}
                                                                </td>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Tabel Kanan -->
                                            {{-- <div style="flex: 1; margin-left: 10px;">
                                                <h5 class="modal-title mt-4 mb-2" id="detailModalLabel">
                                                    Material Issued
                                                </h5>
                                                <div class="card">
                                                    <div class="table-responsive text-nowrap">
                                                        <table class="table table-hover">
                                                            <thead class="bg-dark">
                                                                <tr>
                                                                    <th class="text-white">List Of mat</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="table-border-bottom-0">
                                                                <td>{{ $WOData->WONumber . $WOData->OprNumber . 'MP' }}
                                                                </td>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>


                                        <div class="modal-footer">
                                            <form action="{{ route('operator.close') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end Modal --}}
                    @endif
                    <!-- Footer -->
                    @include('includes.footer')
                </div>
                <!-- / Content -->

                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('node_modules/instascan/dist/instascan.min.js') }}"></script>


    <script src="{{ asset('vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <!-- Include Toastify JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <!-- Main JS -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    {{-- <script src="{{ asset('js/scan.js') }}"></script> --}}


    <!-- Page JS -->
    <script src="{{ asset('js/dashboards-analytics.js') }}"></script>

    {{-- Toast --}}
    <script>
        @if (session('added'))
            // Display a success toast notification
            Toastify({
                text: "{{ session('added') }}",
                duration: 3000,
                close: true,
                gravity: "bottom", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                style: {
                    background: "green",
                },

            }).showToast();
        @endif
    </script>

    <script>
        // variables
        var display = document.getElementById("display"),
            start = document.getElementById("start"),
            interval = null,
            status = "stop",
            seconds = 0,
            minutes = 0,
            hours = 0;


        // Cek apakah ada waktu sebelumnya di penyimpanan lokal
        if (localStorage.getItem("timerData")) {
            var timerData = JSON.parse(localStorage.getItem("timerData"));
            seconds = timerData.seconds;
            minutes = timerData.minutes;
            hours = timerData.hours;
            display.innerHTML =
                (hours ? (hours > 9 ? hours : "0" + hours) : "00") +
                ":" +
                (minutes ? (minutes > 9 ? minutes : "0" + minutes) : "00") +
                ":" +
                (seconds > 9 ? seconds : "0" + seconds);
        }

        // increments stopwatch and displays it
        function stopWatch(test) {
            seconds++;
            if (seconds >= 60) {
                seconds = 0;
                minutes++;
                if (minutes >= 60) {
                    minutes = 0;
                    hours++;
                }
            }
            // Display stopwatch
            display.innerHTML =
                (hours ? (hours > 9 ? hours : "0" + hours) : "00") +
                ":" +
                (minutes ? (minutes > 9 ? minutes : "0" + minutes) : "00") +
                ":" +
                (seconds > 9 ? seconds : "0" + seconds);

            // Simpan waktu saat ini di penyimpanan lokal
            var timerData = {
                seconds: seconds,
                minutes: minutes,
                hours: hours
            };
            localStorage.setItem("test", JSON.stringify(timerData));
        }

        // start/stop stopwatch
        function startWatch(test) {
            if (status === "stop") {
                interval = window.setInterval(stopWatch(test), 1000);
                start.innerHTML = '<i class="fa-solid fa-stop"></i>'; // Mengganti teks dengan ikon
                status = "start";
            } else {
                window.clearInterval(interval);
                start.innerHTML = '<i class="fa-solid fa-play"></i>';
                status = "stop";
            }
        }
    </script>

    @if (session('AndonEmpSession'))
        <script>
            const stepWizardItems = document.querySelectorAll(".step-wizard-item");
            const AndonDateOpen = "<?php echo $AndonEmpSession['AndonDateOpen']; ?>";
            const AndonDateReceived = "<?php echo $AndonEmpSession['AndonDateReceived']; ?>";
            const AndonDateSolving = "<?php echo $AndonEmpSession['AndonDateSolving']; ?>";
            const AndonDateAccepted = "<?php echo $AndonEmpSession['AndonDateAccepted']; ?>";
            const AndonDateClosed = "<?php echo $AndonEmpSession['AndonDateClosed']; ?>";

            function showStep(step) {
                stepWizardItems.forEach(item => {
                    item.classList.remove("current-item");
                });
                stepWizardItems[step - 0].classList.add("current-item");
            }

            function setStepColors() {
                stepWizardItems.forEach(item => {
                    const step = parseInt(item.getAttribute("data-step"));
                    item.classList.add(`step-${step}`);
                });
            }

            function setPointerCursor() {
                stepWizardItems.forEach(item => {
                    item.style.cursor = "pointer";
                });
            }

            function checkAndonStatus() {
                if (AndonDateOpen !== '' && AndonDateOpen !== 'null') {
                    showStep(1);
                    console.log('AndonDateOpen condition is met 1');
                }

                if (AndonDateReceived !== '' && AndonDateReceived !== 'null') {
                    showStep(2);
                    console.log('AndonDateOpen condition is met 2');
                }

                if (AndonDateSolving !== '' && AndonDateSolving !== 'null') {
                    showStep(3);
                    console.log('AndonDateOpen condition is met 3');
                }

                if (AndonDateAccepted !== '' && AndonDateAccepted !== 'null') {
                    showStep(4);
                    console.log('AndonDateOpen condition is met 4');
                }

                if (AndonDateClosed !== '' && AndonDateClosed !== 'null') {
                    showStep(5);
                    console.log('AndonDateOpen condition is met 5');
                }
            }

            stepWizardItems.forEach(item => {
                item.addEventListener("click", () => {
                    // Menambahkan atribut 'disabled' saat elemen diklik
                    // item.setAttribute("disabled", true);
                    // const step = parseInt(item.getAttribute("data-step"));
                    // showStep(step);
                    // setStepColors();
                });
            });

            setStepColors();
            setPointerCursor();
            checkAndonStatus();
        </script>
    @endif

    {{-- <script>
            var barcode = '';
            var interval;
            document.addEventListener('keydown', function(evt) {
                if (interval)
                    clearInterval(interval);
                if (evt.code == 'Enter') {
                    if (barcode)
                        handleBarcode(barcode);
                    barcode = '';
                    return;
                }
                if (evt.key != 'Shift')
                    barcode += evt.key;
                interval = setInterval(() => barcode = '', 20);
            });

            function handleBarcode(scanned_barcode) {
                document.querySelector('#last-barcode').innerHTML = scanned_barcode;
            }
    </script> --}}

    <script>
        $(".selectpicker").selectpicker();
    </script>
    <script>
        jQuery.noConflict();

        jQuery(document).ready(function($) {
            // Gunakan $ di sini untuk menghindari konflik dengan variabel lain
            $('#leftTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('employeerun.data') }}",
                // ajax: {
                //     url: "{{ route('workorder.index') }}",
                //     type: 'GET',
                // },
                columns: [{
                        data: 'EmployeeName',
                        name: 'EmployeeName',
                        orderable: false,
                        searchable: true,
                    },
                    {
                        data: 'Progress',
                        name: 'Progress',
                        orderable: false,
                        searchable: false,
                    },
                ],
                order: [
                    [0, 'asc']
                ], // Ini mengatur sorting default pada kolom pertama
                searching: true, // Enable searching
            });
        });
    </script>
    <script>
        jQuery.noConflict();
        jQuery(document).ready(function($) {
            // Gunakan $ di sini untuk menghindari konflik dengan variabel lain
            $('#rightTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('employeestop.data') }}",
                // ajax: {
                //     url: "{{ route('workorder.index') }}",
                //     type: 'GET',
                // },
                columns: [{
                        data: 'EmployeeName',
                        name: 'EmployeeName',
                        orderable: false,
                        searchable: true,
                    },
                    {
                        data: 'Progress',
                        name: 'Progress',
                        orderable: false,
                        searchable: false,
                    },
                ],
                order: [
                    [0, 'asc']
                ], // Ini mengatur sorting default pada kolom pertama
                searching: true, // Enable searching
            });
            if ('{{ session('employeeTaskId') }}' || '{{ session('currentWorkOrder') }}') {
                // Tampilkan modal saat halaman dimuat
                $(document).ready(function() {
                    $('#detailModal').modal('show');
                });
            }
            if ('{{ session('WOEmployee') }}') {
                // Tampilkan modal saat halaman dimuat
                $(document).ready(function() {
                    $('#detailWOModal').modal('show');
                });
            }

            @if (session('andonRiseUpWO') && session('andonRiseUpEmployeeNumber'))
                // Tampilkan modal saat halaman dimuat
                $(document).ready(function() {
                    $('#largeModal').modal('show');
                });
            @endif

            if ('{{ session('AndonEmpSession') }}') {
                // Tampilkan modal saat halaman dimuat
                $(document).ready(function() {
                    $('#andonAccepted').modal('show');
                });
            }

            // Rating stars andon
            $(document).ready(function() {
                $('.rating .fa-star').click(function() {
                    $(this).addClass('active');
                    $(this).prevAll('.fa-star').addClass('active');
                    $(this).nextAll('.fa-star').removeClass('active');

                    // Mengambil nilai peringkat yang dipilih
                    var rating = $('.rating .fa-star.active').length;

                    // Memperbarui nilai input tersembunyi
                    $('#rating').val(rating);
                });
            });

            // Scanner
            let scanner = new Instascan.Scanner({
                video: document.getElementById("preview"),
            });

            // Mendengarkan pemindaian
            scanner.addListener("scan", function(content) {
                $("#exampleModal").modal("hide");

                // Memeriksa apakah hasil pemindaian sesuai dengan format "TF00708"
                if (content.startsWith("TF")) {
                    // Mengirim hasil pemindaian karyawan ke server
                    // var tfContent = content; // Menyimpan content yang mengandung "TF"
                    $("#result").val(content);
                    // Mengirim data ke controller dengan mengirim form
                    $("#form").submit();
                }
                // Memeriksa apakah hasil pemindaian sesuai dengan format "INMH0170320"
                else if (/\w{11}$/.test(content)) {
                    $("#result").val(content);
                    // Mengirim hasil pemindaian work order ke server
                    // Mengirim data ke controller dengan mengirim form
                    $("#form").submit();
                }

                // Memeriksa apakah hasil pemindaian sesuai dengan format "X"
                else if (content.startsWith("X")) {
                    $("#result").val(content);
                    // Mengirim data ke controller dengan mengirim form
                    $("#form").submit();
                }

                // Scan andon

                if (content.startsWith("TF")) {
                    // Mengirim hasil pemindaian karyawan ke server
                    // var tfContent = content; // Menyimpan content yang mengandung "TF"
                    $("#NOEmployee").val(content);
                }

            });


            Instascan.Camera.getCameras()
                .then(function(cameras) {
                    if (cameras.length > 0) {
                        scanner.start(cameras[0]);
                    } else {
                        console.error("No cameras found.");
                    }
                })
                .catch(function(e) {
                    console.error(e);
                });


        });
    </script>



    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

</body>

</html>
