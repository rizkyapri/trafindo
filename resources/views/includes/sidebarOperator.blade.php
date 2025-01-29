<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    @guest
        <div class="app-brand demo">
            <a href="{{ route('dashboard') }}" class="app-brand-link">
                <span class="app-brand-logo demo">
                    <img src="{{ asset('images/trafindo.png') }}" alt="logo" style="width: 12rem">
                </span>

            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
        </div>
    @endguest
    @auth
        @if (Auth::user()->role->Name == 'Admin')
            <div class="app-brand demo">
                <a href="{{ route('dashboard') }}" class="app-brand-link">
                    <span class="app-brand-logo demo">
                        <img src="{{ asset('images/trafindo.png') }}" alt="logo" style="width: 12rem">
                    </span>

                </a>

                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                </a>
            </div>
        @elseif(Auth::user()->role->Name == 'Andon')
            <div class="app-brand demo">
                <a href="{{ route('andon.received') }}" class="app-brand-link">
                    <span class="app-brand-logo demo">
                        <img src="{{ asset('images/trafindo.png') }}" alt="logo" style="width: 12rem">
                    </span>

                </a>

                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                </a>
            </div>
        @else
            <div class="app-brand demo">
                <a href="{{ route('report.index') }}" class="app-brand-link">
                    <span class="app-brand-logo demo">
                        <img src="{{ asset('images/trafindo.png') }}" alt="logo" style="width: 12rem">
                    </span>
                </a>

                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                </a>
            </div>
        @endif
    @endauth

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-3 text-center">
        <!-- Dashboard -->
        <li class=" container ">
            <form class="input-group" style="flex-wrap: nowrap;" method="POST" action="{{ route('operator.store') }}"
                id="form">
                @csrf
                <div class="form-outline">
                    <div id="last-barcode"></div>
                    <input autofocus id="result" type="search" class="form-control" placeholder="Search"
                        name="content" oninput="this.value = this.value.toUpperCase()">
                </div>
                {{-- <button type="button" id="submit" class="btn btn-secondary"> 
                        <i class="fas fa-search"></i>
                    </button> --}}
            </form>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-sm btn-primary mt-3 text-white" id="scan" data-bs-toggle="modal"
                data-bs-target="#exampleModal">
                <i class="fa-solid fa-magnifying-glass m-2"></i>SCAN
            </button>

        </li>

        <li class="menu-item mt-5 ">
            <label for="nomorWO">No Work Order</label><br>
            @if (session('employeeTaskId') || session('currentWorkOrder'))
                <label for="nomorWO">{{ $WorkOrderSession->WONumber . $WorkOrderSession->OprNumber }}</label>
            @endif
            @if (session('WOEmployee'))
                <label for="nomorWO">{{ $WOData->WONumber . $WOData->OprNumber }}</label>
            @endif
        </li>
        <li class="menu-item mt-5">
            <label for="nomorMP">No Material</label><br>
            @if (session('employeeTaskId') || session('currentWorkOrder'))
                <label for="nomorMP">{{ $WorkOrderSession->WONumber . $WorkOrderSession->OprNumber . 'MP' }}</label>
            @endif
            @if (session('WOEmployee'))
                <label for="nomorMP">{{ $WOData->WONumber . $WOData->OprNumber . 'MP' }}</label>
            @endif
        </li>
        @if (session('employeeTaskId') || session('currentWorkOrder'))
            <li class="menu-item mt-5">
                <label for="nomorWO">Detail lihat disini</label><br>
                <button type="button" class="btn btn-sm btn-info mt-3 text-white" data-bs-toggle="modal"
                    data-bs-target="#detailModal">
                    <i class="fa-solid fa-circle-info m-2 "></i>Klik Detail
                </button>
            </li>
        @endif
        @if (session('WOEmployee'))
            <li class="menu-item mt-5">
                <label for="nomorWO">Detail lihat disini</label><br>
                <button type="button" class="btn btn-sm btn-info mt-3 text-white" data-bs-toggle="modal"
                    data-bs-target="#detailWOModal">
                    <i class="fa-solid fa-circle-info m-2 "></i>Klik Detail
                </button>
            </li>
        @endif

    </ul>
    <div class="sb-sidenav-footer text-danger" style="font-family: helvetica; font-weight:bold;">
        <div id="MyClockDisplay" class="clock text-center fs-2" onload="showTime()"></div>
    </div>
</aside>

<script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/instascan/2.0.0-rc.4/instascan.min.js" integrity="sha512-vybWo2QCh2P1jTLx7W50N3K08p8ed7VsDZDJ9Ro/gvBDG0+lusOVFwbA9zfgBOtndpDm8YYKiagvre3Fq43kSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/instascan/1.0.0/index.js" integrity="sha512-QblNATV/gin5FC8tqTM2gfCMBei2qCzTte4O6CxGp8KQ5BgC5vNNGv99uTBvzmq+AFFYFoUNhowGOOJNTIBy6A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}


<script>
    showTime();
</script>
