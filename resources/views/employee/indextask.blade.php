@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between">
            <div>
                <h1 style="color: black">
                    <i class="fa-solid fa-list-check text-dark" style="margin-right: 10px;"></i>Employee Task
                </h1>
            </div>
            <div>
                <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#detailModal">
                    <i class="fas fa-eye" style="margin-right: 10px;"></i>
                    View Details
                </button>


                <!-- Modal Employee Task -->
                <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="detailModalLabel">Man Hours Details</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body row justify-content-center align-items-center">
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-hover" id="employeeTasksTable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Operation ID</th>
                                                <th>Task Date Start</th>
                                                <th>Task Date End</th>
                                                <th>Man Hours</th>
                                                <th>Task Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="detailModalLabel">
                                    Man Hours Details</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body row justify-content-center align-items-center">
                                <div class="card">
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-hover" id="myTable">
                                            <div id="daterange" class="mb-4" style="text-align:start;">
                                                Date:
                                                <input type="text" class="daterange" />
                                            </div>
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Name</th>
                                                    <th>Operation ID</th>
                                                    <th>Task Date Start</th>
                                                    <th>Task Date End</th>
                                                    <th>Man Hours</th>
                                                    <th>Task Status</th>
                                                    <th>Details</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                                @foreach ($employeetasks as $user)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $user->employees ? $user->employees->Name : 'Tidak tersedia' }}
                                                        </td>
                                                        <td>{{ $user->OprID }}</td>
                                                        <td>{{ $user->TaskDateStart }}</td>
                                                        <td>{{ $user->TaskDateEnd }}</td>
                                                        <td>{{ $user->hourRange }}</td>
                                                        <td>
                                                            @if ($user->TaskStatus == 'F')
                                                                <span class="badge bg-label-success me-1">Finish</span>
                                                            @else
                                                                <span class="badge bg-label-danger me-1">Stop</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <br>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div> --}}

            </div>
        </div>
        <hr class="my-3" />
        <!-- Import and Export Buttons -->

        <!-- Employee Table -->
        <div class="card">
            <p class="card-header"></p>
            <div class="table-responsive text-nowrap container">
                <table class="table table-hover" id="myTable1">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Employee Name</th>
                            <th>Total Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($totalMinutes as $total)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $total->Name }}</td>
                                <td class="text-center">
                                    @php
                                        $hours = floor($total->totalMinutes / 60);
                                        $minutes = $total->totalMinutes % 60;
                                        echo $hours > 0 ? $hours . ' hours ' : '';
                                        echo $minutes . ' minutes';
                                    @endphp
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
@endsection

@push('scripts')
    <script>
        // jQuery.noConflict();
        jQuery(document).ready(function($) {
            // Gunakan $ di sini untuk menghindari konflik dengan variabel lain
            $('#employeeTasksTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('employee.indextask') }}",
                columns: [{
                        data: 'DT_RowIndex', // Gunakan 'DT_RowIndex' untuk menampilkan indeks
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'Name',
                        name: 'Name',
                    },
                    {
                        data: 'OprID',
                        name: 'OprID'
                    },
                    {
                        data: 'TaskDateStart',
                        name: 'TaskDateStart'
                    },
                    {
                        data: 'TaskDateEnd',
                        name: 'TaskDateEnd'
                    },
                    {
                        data: 'manhours',
                        name: 'manhours'
                    },
                    {
                        data: 'taskStatus',
                        name: 'taskStatus'
                    },

                ],
                searching: true, // Enable searching
            });
        });
    </script>


    <script>
        $('.daterange').daterangepicker();
    </script>
    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end
                    .format('YYYY-MM-DD'));
            });
        });
    </script>
@endpush
