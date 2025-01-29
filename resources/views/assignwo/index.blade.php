@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between">
            <div>
                <h1 style="color: black">
                    <i class="fa-solid fa-user-tie text-dark" style="margin-right: 10px;"></i>Assign Work Order
                </h1>
            </div>
            <div>
                <a href="{{ route('assignwo.create') }}" class="btn btn-primary mb-2">
                    <i class="fa-solid fa-plus" style="margin-right: 10px;"></i>
                    Add New
                </a>
            </div>
        </div>
        <hr class="my-3" />

        <!-- Employee Table -->
        <div class="card">
            <p class="card-header"></p>
            <div class="table-responsive text-nowrap container">
                <form action="" method="post" class="form-employee">
                    @csrf
                    <table class="assign-data table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>WONumber</th>
                                <th>Name</th>
                                <th>Bagian</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                </form>
                </thead>
                <tbody>
                </tbody>
                </table>
            </div>
        </div>
    </div>

    <!--/ Employee Table -->

    </div>
@endsection

@push('scripts')
    <script>
        // jQuery.noConflict();
        jQuery(document).ready(function($) {
            // Gunakan $ di sini untuk menghindari konflik dengan variabel lain
            $('.assign-data').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('assignwo.index') }}",
                // ajax: {
                //     url: "{{ route('assignwo.index') }}",
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
                        data: 'Name',
                        name: 'Name',
                    },
                    {
                        data: 'Bagian',
                        name: 'Bagian'
                    },
                    {
                        data: 'Status',
                        name: 'Status'
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
