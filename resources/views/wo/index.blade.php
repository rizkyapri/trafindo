@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between">
            <div>
                <h1 style="color:black">
                    <i class="fa-solid fa-list-ul text-dark" style="margin-right: 10px;"></i>Work Order
                </h1>
            </div>
            <div>
                <!-- Modal -->
                <div class="modal fade @if ($errors->any()) show @endif" id="importdata" tabindex="-1"
                    role="dialog" aria-labelledby="importdatalabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form action="{{ route('workorder.import') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <input class="dropify" name="file" type="file" id="file"
                                            data-allowed-file-extensions="xlsx xlsv xls" data-show-errors="true">
                                    </div>
                                    @error('file')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="text-end">
                                        <button class="btn btn-primary">Import Data</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- Dropdown --}}
                <div class="btn-group me-3">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Import Data
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li>
                            <a class="dropdown-item" style="cursor: pointer;" data-bs-toggle="modal"
                                data-bs-target="#importdata">Import Excel</a>
                        </li>
                        <li><a href="{{ asset('Template/Template.xlsx') }}" class="dropdown-item"
                                href="javascript:void(0);">Download Template</a></li>
                        {{-- <li><a href="#" class="dropdown-item" href="javascript:void(0);"><strong>Tarik Data
                                    API</strong></a></li> --}}
                    </ul>
                </div>

                {{-- <a href="#" class="btn btn-primary">
                    <i class="fa-solid fa-plus" style="margin-right: 10px;"></i>

                </a> --}}

            </div>
        </div>

        <hr style="color: black;" class="my-3" />

        <!-- Hoverable Table rows -->
        <div class="card">
            <p class="card-header">
            </p>
            <div class="table-responsive text-nowrap container">
                <table class="data-table table table-hover" id="wo-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>WO Number</th>
                            <th>WO Name</th>
                            <th>WO Begin Date</th>
                            <th>WO End Date</th>
                            <th>WO Status</th>
                            <th>WO Description</th>
                            <th>WO Note</th>
                            <th>Qty</th>
                            <th width="105px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Hoverable Table rows -->
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if ($errors->any())
                // Open the modal if there are validation errors
                $('#importdata').modal('show');
            @endif
        });
    </script>
    <script>
        //   var halo = 'saya kiki';
        //   console.log(halo);
        jQuery.noConflict();
        jQuery(document).ready(function($) {
            // Gunakan $ di sini untuk menghindari konflik dengan variabel lain
            $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('workorder.index') }}",
                // ajax: {
                //     url: "{{ route('workorder.index') }}",
                //     type: 'GET',
                // },
                columns: [{
                        data: 'DT_RowIndex', // Gunakan 'DT_RowIndex' untuk menampilkan indeks
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'WONumber',
                        name: 'WONumber',
                    },
                    {
                        data: 'WOName',
                        name: 'WOName'
                    },
                    {
                        data: 'WOBeginDate',
                        name: 'WOBeginDate'
                    },
                    {
                        data: 'WOEndDate',
                        name: 'WOEndDate'
                    },
                    {
                        data: 'WOStatus',
                        name: 'WOStatus',
                    },
                    {
                        data: 'WODescription',
                        name: 'WODescription'
                    },
                    {
                        data: 'WOnote',
                        name: 'WOnote'
                    },
                    {
                        data: 'WOqty',
                        name: 'WOqty'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                searching: true, // Enable searching
            });
        });
    </script>
@endpush
