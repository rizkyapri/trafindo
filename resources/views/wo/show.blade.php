@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h2>Detail Work Order</h2>


        <div class="row">
            <div class="col">
                <label for="basic-url" class="form-label">Work Order Number</label>
                <div class="input-group mb-3">
                    {{ $workorder->WONumber }}
                </div>
            </div>
            <div class="col">
                <label for="password" class="form-label mb-3">Work Order Name</label>
                <div class="input-group mb-3">
                    {{ $workorder->WOName }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="role" class="form-label">Work Order Description</label>
                <div class="input-group mb-3">
                    {{ $workorder->WODescription }}
                </div>
            </div>
            <div class="col">
                <label for="password" class="form-label">IDMFG</label>
                <div class="input-group mb-3">
                    {{ $workorder->IDMFG }}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label for="email" class="form-label">Work Order Begin Date</label>
                <div class="input-group mb-3">
                    {{ $workorder->WOBeginDate }}
                </div>
            </div>
            <div class="col">
                <label for="telepon" class="form-label">Work Order End Date</label>
                <div class="input-group mb-3">
                    {{ $workorder->WOEndDate }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="email" class="form-label">WO Number Borig</label>
                <div class="input-group mb-3">
                    {{ $workorder->WONborig }}
                </div>
            </div>
            <div class="col">
                <label for="telepon" class="form-label">FGNborig</label>
                <div class="input-group mb-3">
                    {{ $workorder->FGNborig }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="TEST" class="form-label">BOMNborig</label>
                <div class="input-group mb-3">
                    {{ $workorder->BOMNborig }}
                </div>
            </div>
            <div class="col">
                <label for="telepon" class="form-label">Work Order Qty</label>
                <div class="input-group mb-3">
                    {{ $workorder->WOQty }}
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Work Order Note</label>
            <div class="input-group mb-3">
                {{ $workorder->WONote }}
            </div>
        </div>
        <div class="mb-3 mt-5">
            <a href="{{ route('workorder.index') }}" class="btn btn-primary">Kembali</a>
        </div>

    </div>
    </div>
@endsection
