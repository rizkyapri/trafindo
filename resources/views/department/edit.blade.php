@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h1 class="my-4" style="color: black">
            <i class="fa-solid fa-edit"></i>
            Edit Department
        </h1>
        <!-- Basic with Icons -->
        <div class="">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between"></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('department.update', $department->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Name</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bx-buildings"></i></span>
                                    <input type="text" class="form-control" id="basic-icon-default-fullname"
                                        placeholder="Input Name" aria-label="John Doe" value="{{ $department->name }}"
                                        name="name" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
