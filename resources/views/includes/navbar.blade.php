<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <!-- Search -->
    {{-- <div class="navbar-nav align-items-center">
      <div class="nav-item d-flex align-items-center">
        <i class="bx bx-search fs-4 lh-0"></i>
        <input
          type="text"
          class="form-control border-0 shadow-none"
          placeholder="Search..."
          aria-label="Search..."
        />
      </div>
    </div> --}}
    <!-- /Search -->

    {{-- Text Center TP --}}
    <div class="navbar-nav-center text-center" style="margin: 0;">
        <p class="text-danger fw-bold" style="margin: 0;">PT Trafoindo Prima Perkasa</p>
        <span class="fw-bold" style="margin: 0; color:black">Jakarta - Indonesia</span>
    </div>


    <ul class="navbar-nav flex-row align-items-center ms-auto">
        <!-- Place this tag where you want the button to render. -->

        <!-- User -->
        @auth
            @if (Auth::user()->role->Name == 'Admin' ||
                    Auth::user()->role->Name == 'Andon' ||
                    Auth::user()->role->Name == 'Accounting')
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="fa-solid fa-right-from-bracket fs-6" style="margin-right: 5px;"></i>
                            <span class="logout-text">Logout</span>
                        </button>

                    </form>
                </li>
            @endif
        @endauth


        <!--/ User -->
    </ul>
</div>

<style>
    .navbar-nav-center {
        flex-grow: 1;
    }

    @media only screen and (max-width: 767px) {
        .logout-text {
            display: none;
        }
    }

</style>

