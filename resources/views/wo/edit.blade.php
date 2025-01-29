@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h1 class="my-4" style="color: black">
            <i class='fa-solid fa-pen-to-square'></i>
            Edit Status WO
        </h1>
        <!-- Basic with Icons -->
        <div>
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('workorder.update', $workorder->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Status</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="status">
                                    <option value="1" {{ $workorder->OprStatus == '1' ? 'selected' : '' }}>Open
                                    </option>
                                    <option value="2" {{ $workorder->OprStatus == '2' ? 'selected' : '' }}>Close
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">

                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('workorder.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
