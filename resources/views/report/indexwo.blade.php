<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Work Order</title>

    {{-- Bootstrap CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>

    @extends('layouts.main')

    @section('content')
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="d-flex justify-content-between">
                <div>
                    <h1>
                        <i class="fa-solid fa-book" style="margin-right: 10px;"></i>Report Work Order
                    </h1>
                </div>
                <div>
                    <a href="{{ route('workorder.excel') }}">
                        <button id="toggleButton" class="btn btn-success mb-2">
                            <i class="fas fa-print"></i> Export Excel
                        </button></a>
                </div>
            </div>

            <div class="card-body">

            </div>
            <hr class="my-3" />

            <!-- Hoverable Table rows -->
            <div class="card">
                <p class="card-header"></p>
                <div class="table-responsive text-nowrap container">
                    <table class="table table-hover" id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>WO Number</th>
                                <th>WO Name</th>
                                <th>WO Description</th>
                                <th>WO Begin Date</th>
                                <th>WO End Date</th>
                                <th>WO Status</th>
                                <th>IDMFG</th>
                                <th>WO nborig</th>
                                <th>FG nborig</th>
                                <th>BOM nborig</th>
                                <th>Qty</th>
                                <th>WO Note</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($wo as $workorder)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ $workorder->WONumber }}</td>
                                    <td>{{ $workorder->WOName }}</td>
                                    <td>
                                        {{ $workorder->WODescription }}
                                    </td>
                                    <td>
                                        {{ $workorder->WOBeginDate }}
                                    </td>

                                    <td>
                                        {{ $workorder->WOEndDate }}
                                    </td>
                                    <td>
                                        {{ $workorder->WOStatus }}
                                    </td>
                                    <td>
                                        {{ $workorder->IDMFG }}
                                    </td>
                                    <td>
                                        {{ $workorder->WOnborig }}
                                    </td>
                                    <td>
                                        {{ $workorder->FGnborig }}
                                    </td>
                                    <td>
                                        {{ $workorder->BOMnborig }}
                                    </td>
                                    <td>
                                        {{ $workorder->WOqty }}
                                    </td>
                                    <td>
                                        {{ $workorder->WOnote }}
                                    </td>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!--/ Hoverable Table rows -->
            <!-- Modal -->
            {{-- <div class="modal fade" id="detail{{ $workorder->id }}" tabindex="-1" role="dialog"
                aria-labelledby="detaillabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Work Order More
                                Detail</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <p class="card-header"></p>
                                <div class="table-responsive text-nowrap container">
                                    <table class="table table-hover" id="myTable">
                                        @foreach ($workorder as $wo)
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>{{ $loop->iteration }}</th>
                                                </tr>
                                                <tr>
                                                    <th>Work Number</th>
                                                    <th>{{ $wo->WONumber }}</th>
                                                </tr>
                                                <tr>
                                                    <th>Work Order Begin Date</th>
                                                    <th>{{ $wo->WOBeginDate }}</th>
                                                </tr>
                                                <tr>
                                                    <th>Work Order End Date</th>
                                                    <th>{{ $wo->WOEndDate }}</th>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <th>{{ $wo->WOStatus }}</th>
                                                </tr>
                                                <tr>
                                                    <th>Op</th>
                                                    <th>{{ $wo->IDMFG }}</th>
                                                </tr>
                                                <tr>
                                                    <th>Description</th>
                                                    <th>{{ $wo->WONborig }}</th>
                                                </tr>
                                                <tr>
                                                    <th>Op Begin Date</th>
                                                    <th>{{ $wo->FGNborig }}</th>
                                                </tr>
                                                <tr>
                                                    <th>Op End Date</th>
                                                    <th>{{ $wo->BOMNborig }}</th>
                                                </tr>
                                                <tr>
                                                    <th>WO Note</th>
                                                    <th>{{ $wo->WONote }}</th>
                                                </tr>
                                            </thead>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    @endsection

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

    {{-- <script>
        $(document).ready(function() {
            $('.show-details').click(function() {
                var workorderId = $(this).data('workorderid');
                $.ajax({
                    url: '/workorder/' + workorderId, // Sesuaikan dengan URL yang sesuai
                    type: 'GET',
                    success: function(response) {
                        $('#detailModal{{ $workorder->id }} .modal-body').html(response);
                        $('#detailModal{{ $workorder->id }}').modal('show');
                    },
                    error: function() {
                        alert('Error loading Work Order details.');
                    }
                });
            });
        });
    </script> --}}


    {{-- Bootstrap --}}
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>
