@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between">
            <div>
                <h1>
                    <i class="fa-solid fa-book" style="margin-right: 10px;"></i>Report TPH - 260
                </h1>
            </div>
            <div>
                <a href="{{ route('employee.excel') }}">
                    <button id="toggleButton" class="btn btn-success mb-2">
                        <i class="fas fa-print"></i> Export Excel
                    </button></a>
            </div>
        </div>
        <hr class="my-3" />
        <div class="d-flex justify-content-between">
            <h4>PPIC Produksi Line 2 - LAPORAN BIAYA PRODUKSI</h4>
            {{-- <div class="mb-3">
                <select id="selectpickerLiveSearch" class="selectpicker w-100" data-style="btn-info"
                    data-live-search="true">
                    @foreach ($wo as $workorder)
                        <option value="{{ $workorder->id }}">
                            {{ $workorder->WONumber }}
                        </option>
                    @endforeach
                </select>
            </div> --}}
        </div>
        {{-- <div class="table-responsive text-nowrap container">
                <div style="margin-right:80%;" class="mb-4 mt-3">
                    <label for="TypeaheadBasic" class="form-label">Basic</label>
                    <input id="TypeaheadBasic" class="form-control typeahead" type="text" autocomplete="off" placeholder="Enter states from USA" />
                  </div> --}}

        <!-- Employee Table -->
        <div class="card">
            <p class="card-header"></p>
            <div class="table-responsive text-nowrap container">
                <form action="{{ route('employee.cetakBarcode') }}" method="post" class="form-employee">
                    @csrf
                    <table class="table table-hover" id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>WO Number</th>
                                <th>KVA</th>
                                <th>Qty</th>
                                <th>Man Hour</th>
                                <th>Details</th>
                                {{-- <th>Action</th> --}}
                            </tr>
                </form>
                </thead>
                <tbody class="table-border-bottom-0">

                    @foreach ($wo as $workorder)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $workorder->WONumber }}</td>
                            <td>{{ $workorder->WONumber }}</td>
                            <td>{{ $workorder->WONumber }}</td>
                            <td>{{ $workorder->WONumber }}</td>
                            <td>{{ $workorder->WONumber }}</td>
                            <td style="text-align:center;">
                                <!-- Button to trigger the modal -->
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal{{ $workorder->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <div class="modal fade" id="exampleModal{{ $workorder->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel{{ $workorder->id }}" aria-hidden="true">
                                    <div class="modal-dialog " role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel{{ $workorder->id }}">
                                                    {{ $workorder->WONumber }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                </button>
                                            </div>
                                            <div class="modal-body row justify-content-center align-items-center">
                                                <div class="card">
                                                    <div class="table-responsive text-nowrap container">
                                                        <table class="table table-hover" id="myTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>{{ $loop->iteration }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Work Number</th>
                                                                    <th>{{ $workorder->WONumber }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Work Order Begin Date</th>
                                                                    <th>{{ $workorder->WOBeginDate }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Work Order End Date</th>
                                                                    <th>{{ $workorder->WOEndDate }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Work Order Status</th>
                                                                    <th>{{ $workorder->WOStatus }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <th>IDMFG</th>
                                                                    <th>{{ $workorder->IDMFG }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <th>WOnborig</th>
                                                                    <th>{{ $workorder->WOnborig }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <th>FGnborig</th>
                                                                    <th>{{ $workorder->FGnborig }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <th>BOMnborig</th>
                                                                    <th>{{ $workorder->BOMnborig }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Work Order Quantity</th>
                                                                    <th>{{ $workorder->WOqty }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Work Order Note</th>
                                                                    <th>{{ $workorder->WOnote }}</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- end modal --}}
                            </td>


                        </tr>
                    @endforeach
                </tbody>
                </table>



            </div>
        </div>
    </div>

    <!--/ Employee Table -->

    </div>

    <script>
        var bloodhoundBasicExample = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: states
        });

        $(".typeahead-bloodhound").typeahead({
            highlight: true,
            minLength: 1
        }, {
            name: "states",
            source: bloodhoundBasicExample
        });
    </script>
@endsection
