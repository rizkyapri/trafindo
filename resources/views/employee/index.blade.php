@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between">
            <div>
                <h1 style="color: black">
                    <i class="fa-solid fa-user-tie text-dark" style="margin-right: 10px;"></i>Employee List
                </h1>
            </div>
            <div>
                <button id="toggleButton" style="display: none;" class="btn btn-primary mb-2"
                    onclick="cetakBarcode('{{ route('employee.cetakBarcode') }}')">
                    <i class="fas fa-print" style="margin-right: 10px;"></i> Print
                </button>
                <a href="{{ route('employee.create') }}" class="btn btn-primary mb-2">
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
                <form action="{{ route('employee.cetakBarcode') }}" method="post" class="form-employee">
                    @csrf
                    <table class="employee-data table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="selectall" id="selectall"></th>
                                <th>No</th>
                                <th>Name</th>
                                <th>Number</th>
                                <th>Department</th>
                                <th>Title</th>
                                <th>Photo</th>
                                <th>Notes</th>
                                <th>Progress</th>
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
    @include('sweetalert::alert')
    <script src="sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Include Toastify JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    {{-- FOR AJAX YAJRA --}}
    <script>
        // jQuery.noConflict();
        jQuery(document).ready(function($) {
            // Gunakan $ di sini untuk menghindari konflik dengan variabel lain
            $('.employee-data').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('employee.index') }}",
                // ajax: {
                //     url: "{{ route('employee.index') }}",
                //     type: 'GET',
                // },
                columns: [{
                        data: 'checkbox', // Gunakan 'DT_RowIndex' untuk menampilkan indeks
                        name: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
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
                        data: 'Number',
                        name: 'Number'
                    },
                    {
                        data: 'Department',
                        name: 'Department'
                    },
                    {
                        data: 'Title',
                        name: 'Title'
                    },
                    {
                        data: 'Photo',
                        name: 'Photo'
                    },
                    {
                        data: 'Notes',
                        name: 'Notes'
                    },
                    {
                        data: 'Progress',
                        name: 'Progress'
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

    {{-- Toast --}}
    <script>
        function cetakBarcode(url) {
            if ($('input:checked').length < 1) {
                alert('Pilih data yang akan dicetak');
                return;
            } else {
                $('.form-employee')
                    .attr('target', '_blank')
                    .attr('action', url)
                    .submit();
            }
        }
    </script>

    {{-- Script for select all checkbox --}}
    <script>
        $(document).ready(function() {
            $('#selectall').click(function() {
                var checked = this.checked;
                $('input[name="items[]"]').each(function() {
                    this.checked = checked;
                });
            });
        });
    </script>

    {{-- Toggle print button on select all --}}
    <script>
        $(document).ready(function() {
            $("#selectall").click(function() {
                $(".checkboxid").prop('checked', $(this).prop('checked'));
                $("#toggleButton").toggle($(".checkboxid:checked").length > 0);
            });

            $(".checkboxid").click(function() {
                $("#toggleButton").toggle($(".checkboxid:checked").length > 0);
            });
        });
    </script>

    {{-- Menampilkan print button jika di checked --}}
    <script>
        // Function to toggle print button visibility
        function togglePrintButton() {
            var checkedCheckboxes = $('input.checkboxid:checked');

            if (checkedCheckboxes.length > 0) {
                $('#toggleButton').show();
            } else {
                $('#toggleButton').hide();
            }
        }

        $(document).ready(function() {
            // Handle checkbox change event
            $('body').on('change', '.checkboxid', function() {
                togglePrintButton();
            });

            // Handle select all checkbox click event
            $('#selectall').click(function() {
                togglePrintButton();
            });

            // Initial toggle for page load
            togglePrintButton();

            // Print button click event
            // $('#toggleButton').click(function() {
            //     var selectedIds = $('input.checkboxid:checked').map(function() {
            //         return $(this).val();
            //     }).get();

            //     if (selectedIds.length > 0) {
            //         var url = "{{ route('employee.cetakBarcode') }}?ids=" + selectedIds.join(',');
            //         cetakBarcode(url);
            //     } else {
            //         alert('No items selected for printing.');
            //     }
            // });
        });
    </script>

    {{-- Toggle print button on select --}}
    {{-- <script>
    $(document).ready(function() {
        $("#checkboxid").click(function() {
            $("#toggleButton").toggle(); // Toggle the visibility of the content div
        });
    });
</script> --}}
@endpush
