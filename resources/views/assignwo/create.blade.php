@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h1 class="my-2" style="color: black">
            <i class="fa-solid fa-user-tie"></i>
            Create Assign
        </h1>
        <hr class="my-3" />
        <!-- Basic with Icons -->
        <div>
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">

                </div>
                <div class="card-body">
                    <form action="{{ route('assignwo.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Name</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    {{-- <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bx-user"></i></span> --}}
                                    <select class="selectpicker @error('employee') is-invalid @enderror"
                                        data-style="btn-secondary" data-live-search="true" aria-label="employee"
                                        id="employee" name="employee">
                                        <option selected disabled>- Choose Employee -</option>
                                        @foreach ($name as $employee)
                                            <option value="{{ $employee->id }}"
                                                {{ old('employee') == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->Name }} | {{ $employee->EmployeeNumber }}
                                            </option>
                                        @endforeach
                                    </select>

                                    {{-- <select class="form-select @error('employee') is-invalid @enderror"
                                        aria-label="employee" id="employee" name="employee">
                                        <option selected disabled>- Choose Employee -</option>
                                        @foreach ($name as $employees)
                                            <option value="{{ $employees->id }}">{{ $employees->Name }} |
                                                {{ $employees->EmployeeNumber }}</option>
                                        @endforeach
                                    </select> --}}
                                </div>
                                @error('employee')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-company">WO Number</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    {{-- <span id="basic-icon-default-company2" class="input-group-text">
                                        <i class="bx bxs-user-badge"></i></span> --}}
                                    <select class="selectpicker @error('OprID') is-invalid @enderror" aria-label="OprID"
                                        id="OprID" name="OprID" data-style="btn-secondary" data-live-search="true">
                                        <option selected disabled>- Choose Work Order -</option>
                                        @foreach ($data as $employee)
                                            <option value="{{ $employee['id'] }}"
                                                {{ old('OprID') == $employee['id'] ? 'selected' : '' }}>
                                                {{ $employee['WONumber'] . $employee['OprNumber'] . ' | ' . $employee['OprName'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    {{-- <select class="form-select @error('OprID') is-invalid @enderror" aria-label="OprID"
                                        id="OprID" name="OprID">
                                        <option selected disabled>- Choose Employee -</option>
                                        @foreach ($data as $employee)
                                            <option value="{{ $employee['id'] }}">
                                                {{ $employee['WONumber'] . $employee['OprNumber'] }}</option>
                                        @endforeach
                                    </select> --}}
                                </div>
                                @error('OprID')
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
