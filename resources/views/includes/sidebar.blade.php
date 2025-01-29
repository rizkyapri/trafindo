<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
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
    @endif
    @if (Auth::user()->role->Name == 'Andon')
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
    @endif
    @if (Auth::user()->role->Name == 'Accounting')
        <div class="app-brand demo">
            <a href="{{ route('report.report') }}" class="app-brand-link">
                <span class="app-brand-logo demo">
                    <img src="{{ asset('images/trafindo.png') }}" alt="logo" style="width: 12rem">
                </span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
        </div>
    @endif

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- User -->
        @if (Auth::user()->role->Name == 'Admin')
            <!-- Dashboard -->
            <li class="menu-item">
                <a href="{{ route('dashboard') }}" class="menu-link">
                    <i class="menu-icon fas fa-home"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            </li>

            <!-- Layouts -->
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    {{-- <i class="menu-icon tf-icons bx bx-layout"></i> --}}
                    <i class="menu-icon tf-icons fa-solid fa-users"></i>
                    <div data-i18n="Layouts">Employee</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('employee.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Employee List</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('employee.indextask') }}" class="menu-link">
                            <div data-i18n="Without menu">Employee Task</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('department.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Department</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    {{-- <i class="menu-icon tf-icons bx bx-layout"></i> --}}
                    <i class="menu-icon tf-icons fa-solid fa-screwdriver-wrench"></i>
                    <div data-i18n="Layouts">Work Order</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('workorder.index') }}" class="menu-link">
                            <div data-i18n="Without navbar">Data Work Order</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('workorder.indexBarcode') }}" class="menu-link">
                            <div data-i18n="Container">Generate Work Order</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('assignwo.index') }}" class="menu-link">
                            <div data-i18n="Container">Assign Work Order</div>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- User --}}
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    {{-- <i class="menu-icon tf-icons bx bx-layout"></i> --}}
                    <i class="menu-icon tf-icons fa-solid fa-user"></i>
                    <div data-i18n="Layouts">Users</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('role.index') }}" class="menu-link">
                            <div data-i18n="Without navbar">Role</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('user.index') }}" class="menu-link">
                            <div data-i18n="Container">User</div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item" style="display: none;">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    {{-- <i class="menu-icon tf-icons bx bx-layout"></i> --}}
                    <i class="menu-icon tf-icons fa-solid fa-book"></i>
                    <div data-i18n="Layouts">Report</div>
                </a>

                {{-- Report --}}
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('report.index') }}" class="menu-link">
                            <div data-i18n="Without navbar">Report 303</div>
                        </a>
                    </li>

                </ul>
            </li>
        @endif

        @if (Auth::user()->role->Name == 'Andon')
            <!-- Dashboard -->
            <li class="menu-item">
                <a href="{{ route('andon.received') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-solid fa-land-mine-on"></i>
                    <div data-i18n="Analytics">Andon</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('andon.history') }}" class="menu-link">
                    <i class="menu-icon fa-solid fa-clock-rotate-left"></i>
                    <div data-i18n="Analytics">History</div>
                </a>
            </li>
        @endif

        @if (Auth::user()->role->Name == 'Accounting')
            <!-- Dashboard -->
            <li class="menu-item">
                <a href="{{ route('report.index') }}" class="menu-link">
                    {{-- <i class="menu-icon tf-icons bx bx-layout"></i> --}}
                    <i class="menu-icon tf-icons fa-solid fa-book"></i>
                    <div data-i18n="Layouts">Report 303</div>
                </a>
            </li>
        @endif

        @if (Auth::user()->role->Name == 'Admin')
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons fa-solid fa-land-mine-on"></i>
                    <div data-i18n="Analytics">Andon</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('andon.index') }}" class="menu-link">
                            <div data-i18n="Without navbar">Andon Show</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('andcat.index') }}" class="menu-link">
                            <div data-i18n="Container">Andon Category</div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons fa-solid fa-book"></i>
                    <div data-i18n="Analytics">Report</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('report.report') }}" class="menu-link">
                            <div data-i18n="Without navbar">Report 303</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Dashboard -->
        <li class="menu-item">
            <a href="{{ route('operator') }}" class="menu-link">
                <i class="menu-icon tf-icons fa-solid fa-user-astronaut"></i>
                <div data-i18n="Analytics">Operator</div>
            </a>
        </li>

    </ul>
    <div class="sb-sidenav-footer text-danger" style="font-family: helvetica; font-weight: bold">
        <div id="MyClockDisplay" class="clock text-center fs-1" onload="showTime()"></div>

    </div>
</aside>


<script>
    function showTime() {
        var date = new Date();
        var h = date.getHours(); // 0 - 23
        var m = date.getMinutes(); // 0 - 59
        var s = date.getSeconds(); // 0 - 59
        var session = "";

        // if (h < 12) {
        //     session = "AM";
        // } else {
        //     session = "PM";
        // }

        h = (h < 10) ? "0" + h : h;
        m = (m < 10) ? "0" + m : m;
        s = (s < 10) ? "0" + s : s;

        var time = h + ":" + m + ":" + s + " " + session;
        document.getElementById("MyClockDisplay").innerText = time;
        document.getElementById("MyClockDisplay").textContent = time;

        setTimeout(showTime, 1000);
    }

    showTime();
</script>