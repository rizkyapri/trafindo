@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between">
            <div>
                <h1 style="color: black">
                    <i class="fa-solid fa-land-mine-on" style="margin-right: 10px; color: black"></i>Andon List
                </h1>
            </div>
            <div>
                <button id="toggleButton" style="display: none;" class="btn btn-primary mb-2"
                    onclick="cetakBarcode('{{ route('andon.cetakBarcode') }}')">
                    <i class="fas fa-print" style="margin-right: 10px;"></i> Print
                </button>
            </div>
        </div>

        <hr style="color: black;" class="my-3" />
        <!-- Andon Table -->
        <div class="card">
            <p class="card-header"></p>
            <div class="table-responsive text-nowrap container">
                <form action="{{ route('andon.cetakBarcode') }}" method="post" class="form-andonno">
                    @csrf
                    <div class="col-3 form-group pb-2">
                        <select id="workcenterFilter" class="form-control">
                            <option value="">All Workcenter</option> <!-- Opsi ini akan menampilkan semua data -->
                            @foreach ($workcenters as $workcenter)
                                <option value="{{ $workcenter }}">{{ 'TP-' . $workcenter }}</option>
                            @endforeach
                        </select>
                    </div>
                    <table class="andon-table table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="selectall" id="selectall"></th>
                                <th>No</th>
                                <th>Andon_No</th>
                                <th>Andon_Color</th>
                                <th>Work Center</th>
                                <th>Category Problem</th>
                            </tr>
                </form>
                </thead>
                <tbody>
                    <!-- {{-- @foreach ($andonno as $andon)
                <tr>
                    <td>
                        <input type="checkbox" name="items[]" class="checkboxid" value="{{ $andon->id }}">
                    </td>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $andon->Andon_No }}</td>
                    <td>{{ $andon->Andon_Color }}</td>
                    <td>{{ $andon->Workcenter }}</td>
                    <td>{{ $andon->CategoryProblem }}</td>
                </tr>
                @endforeach --}} -->
                </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('sweetalert::alert')
    <script src="sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Include Toastify JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        // jQuery.noConflict();
        jQuery(document).ready(function($) {
            // Gunakan $ di sini untuk menghindari konflik dengan variabel lain
            var table = $('.andon-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('andon.index') }}",
                    data: function(d) {
                        // Mengambil nilai dari dropdown filter Workcenter
                        d.workcenterFilter = $('#workcenterFilter').val();
                    }
                },
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
                        data: 'andonno',
                        name: 'andonno',
                    },
                    {
                        data: 'andoncolor',
                        name: 'andoncolor',
                    },
                    {
                        data: 'Workcenter',
                        name: 'Workcenter'
                    },
                    {
                        data: 'CategoryProblem',
                        name: 'CategoryProblem'
                    },

                ],
                searching: true, // Enable searching
            });
            // Meng-handle perubahan pada dropdown Workcenter untuk melakukan filter
            $('#workcenterFilter').change(function() {
                table.draw(); // Mengambil data ulang dengan filter yang baru
            });
        });
    </script>
    <script>
        // Print barcode
        function cetakBarcode(url) {
            if ($('input:checked').length < 1) {
                alert('Pilih data yang akan dicetak');
                return;
            } else {
                $('.form-andonno')
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
            //         var url = "{{-- route('andonno.cetakBarcode') --}}?ids=" + selectedIds.join(',');
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
