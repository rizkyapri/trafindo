@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between">
            <div>
                <h1 style="color: black">
                    <i class="fa-solid fa-barcode text-dark" style="margin-right: 10px;"></i>Generate WO
                </h1>
            </div>
            <div>
                <!-- Button trigger modal -->
                <button id="toggleButton" style="display: none;" class="btn btn-primary mb-2"
                    onclick="cetakBarcode('{{ route('workorder.cetakBarcode') }}')">
                    <i class="fas fa-print" style="margin-right: 10px;"></i> Print
                </button>
            </div>
        </div>
        <div class="card-body">

            {{-- </div>
        <hr class="my-3" /> --}}

            <!-- Hoverable Table rows -->
            <div class="card">
                <p class="card-header"></p>
                <div class="table-responsive text-nowrap container">
                    <form action="" method="post" class="form-wo">
                        @csrf
                        <table class="generate-data table table-hover">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" name="selectall" id="selectall"></th>
                                    <th>No</th>
                                    <th>WO Number</th>
                                    <th>Opr Name</th>
                                    <th>Trafo Number</th>
                                    <th>Work Center</th>
                                </tr>
                    </form>
                    </thead>
                    <tbody class="">
                    </tbody>
                    </table>
                </div>
            </div>
            <!--/ Hoverable Table rows -->
        </div>
    @endsection

    @push('scripts')
        <script>
            // jQuery.noConflict();
            jQuery(document).ready(function($) {
                // Gunakan $ di sini untuk menghindari konflik dengan variabel lain
                $('.generate-data').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('workorder.indexBarcode') }}",
                    // ajax: {
                    //     url: "{{ route('workorder.indexBarcode') }}",
                    //     type: 'GET',
                    // },
                    columns: [{
                            data: 'action',
                            name: 'action',
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
                            data: 'WONumber',
                            name: 'WONumber',
                        },
                        {
                            data: 'OprName',
                            name: 'OprName'
                        },
                        {
                            data: 'Trafo',
                            name: 'Trafo'
                        },
                        {
                            data: 'Workcenter',
                            name: 'Workcenter'
                        },

                    ],
                    searching: true, // Enable searching
                });
            });
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

            // Print barcode
            function cetakBarcode(url) {
                if ($('input:checked').length < 1) {
                    alert('Pilih data yang akan dicetak');
                    return;
                } else {
                    $('.form-wo')
                        .attr('target', '_blank')
                        .attr('action', url)
                        .submit();
                }
            }
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

                // // Print button click event
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
    @endpush
