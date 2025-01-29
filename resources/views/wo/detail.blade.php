    @extends('layouts.main')

    @section('content')
        <div class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="detaillabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Work Order Detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <p class="card-header"></p>
                            <div class="table-responsive text-nowrap container">
                                <table class="table table-hover" id="myTable">
                                    @foreach ($wo as $workorder)
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>{{ $workorder->id }}</th>
                                            </tr>
                                            <tr>
                                                <th>Work Number</th>
                                                <th>{{ $workorder->work_order }}</th>
                                            </tr>
                                            <tr>
                                                <th>Work Order Begin Date</th>
                                                <th>{{ $workorder->WO_BEGIN_DATE }}</th>
                                            </tr>
                                            <tr>
                                                <th>Work Order End Date</th>
                                                <th>{{ $workorder->WO_END_DATE }}</th>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <th>{{ $workorder->ST_WO }}</th>
                                            </tr>
                                            <tr>
                                                <th>Op</th>
                                                <th>{{ $workorder->Op }}</th>
                                            </tr>
                                            <tr>
                                                <th>Description</th>
                                                <th>{{ $workorder->Description }}</th>
                                            </tr>
                                            <tr>
                                                <th>Op Begin Date</th>
                                                <th>{{ $workorder->Op_Begin_Date }}</th>
                                            </tr>
                                            <tr>
                                                <th>Op End Date</th>
                                                <th>{{ $workorder->Op_End_Date }}</th>
                                            </tr>
                                            <tr>
                                                <th>Std Setup Time</th>
                                                <th>{{ $workorder->Std_Setup_Time }}</th>
                                            </tr>
                                            <tr>
                                                <th>Std Run Time</th>
                                                <th>{{ $workorder->Std_Run_Time }}</th>
                                            </tr>
                                            <tr>
                                                <th>Op Status</th>
                                                <th>{{ $workorder->Op_Status }}</th>
                                            </tr>
                                            <tr>
                                                <th>WO Note</th>
                                                <th>{{ $workorder->WONote }}</th>
                                            </tr>
                                            <tr>
                                                <th>BOM</th>
                                                <th>{{ $workorder->BOM }}</th>
                                            </tr>
                                            <tr>
                                                <th>BRG</th>
                                                <th>{{ $workorder->BRG }}</th>
                                            </tr>
                                            <tr>
                                                <th>Quantity</th>
                                                <th>{{ $workorder->qty }}</th>
                                            </tr>
                                            <tr>
                                                <th>stn</th>
                                                <th>{{ $workorder->stn }}</th>
                                            </tr>
                                            <tr>
                                                <th>wc</th>
                                                <th>{{ $workorder->wc }}</th>
                                            </tr>
                                            {{-- <tr>
                                    <th>MatPickID</th>
                                    <th>{{ $workorder->WONote }}</th>
                                </tr> --}}

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
        </div>
