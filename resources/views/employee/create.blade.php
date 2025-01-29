@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h1 class="my-2" style="color: black">
            <i class='fa-solid fa-user-plus'></i>
            Create Employee
        </h1>
        <hr class="my-3" />
        <!-- Basic with Icons -->
        <div>
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">

                </div>
                <div class="card-body">
                    <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Name</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bx-user"></i></span>
                                    <input type="text" class="form-control" id="basic-icon-default-fullname"
                                        name="EmployeeName" placeholder="Input Name" aria-label="John Doe"
                                        aria-describedby="basic-icon-default-fullname2" value="{{ old('EmployeeName') }}" />
                                </div>
                                @error('EmployeeName')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-company">Employee Number</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-company2" class="input-group-text"><i
                                            class="fa-regular fa-id-badge"></i></span>
                                    <input type="text" id="basic-icon-default-company" class="form-control"
                                        placeholder="Input Employee Number" aria-label="ACME Inc." name="EmployeeNumber"
                                        aria-describedby="basic-icon-default-company2"
                                        value="{{ old('EmployeeNumber') }}" />
                                </div>
                                @error('EmployeeNumber')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-email">Department Name</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-buildings"></i></span>
                                    <select class="form-select @error('department') is-invalid @enderror"
                                        aria-label="department" id="department" name="department">
                                        <option selected disabled>- Choose department -</option>
                                        @foreach ($dept as $department)
                                            <option value="{{ $department->id }}"
                                                {{ old('department') == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('department')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-phone">title</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-phone2" class="input-group-text">
                                        <i class="uil uil-trophy"></i></span>
                                    <input type="text" id="basic-icon-default-phone" class="form-control phone-mask"
                                        placeholder="Title" aria-label="Department" name="Title"
                                        value="{{ old('Title') }}" aria-describedby="basic-icon-default-phone2" />
                                </div>
                                @error('Title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <input type="radio" value="2" name="InProgress" style="display: none;" checked>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-company">Photograph</label>
                            <div class="col-sm-10">
                                <div class="mb-3" style="width: 250px;">
                                    <input class="dropify" name="Photo" type="file" id="Photo"
                                        data-allowed-file-extensions="jpg png jpeg" data-show-errors="true">
                                </div>
                                @error('Photo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-message">Notes</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-message2" class="input-group-text"><i
                                            class="bx bx-comment"></i></span>
                                    <textarea style="height: 100px;" id="basic-icon-default-message" name="Notes" class="form-control"
                                        placeholder="Hi, Do you have notes?" aria-label="Hi, Do you have notes?"
                                        aria-describedby="basic-icon-default-message2">{{ old('Notes') }}</textarea>
                                </div>
                                @error('Notes')
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
