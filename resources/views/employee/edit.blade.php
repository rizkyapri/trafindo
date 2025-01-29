@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h1 class="my-4"style=color:black>
            <i class='fa-solid fa-pen-to-square'></i>
            Edit Employee
        </h1>
        <!-- Basic with Icons -->
        <div>
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('employee.update', $employee->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Name</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bx-user"></i></span>
                                    <input type="text" class="form-control" id="basic-icon-default-fullname"
                                        placeholder="Input Name" aria-label="John Doe" value="{{ $employee->Name }}"
                                        name="Name" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('Name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-company">Number Employee</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-company2" class="input-group-text"><i
                                            class="fa-regular fa-id-badge"></i></span>
                                    <input type="text" id="basic-icon-default-company" class="form-control"
                                        placeholder="Input Number of Employee" aria-label="ACME Inc."
                                        value="{{ $employee->EmployeeNumber }}" name="EmployeeNumber"
                                        aria-describedby="basic-icon-default-company2" />
                                </div>
                                @error('EmployeeNumber')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-email">Department</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-buildings"></i></span>
                                    <select class="form-select @error('department') is-invalid @enderror"
                                        aria-label="department" id="department" name="department">
                                        <option selected disabled>- Choose department -</option>
                                        @foreach ($dept as $department)
                                            <option value="{{ $department->id }}"
                                                {{ $employee->department_id == $department->id ? 'selected' : '' }}>
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
                                    <span id="basic-icon-default-phone2" class="input-group-text"><i
                                            class="uil uil-trophy"></i></span>
                                    <input type="text" id="basic-icon-default-phone" class="form-control phone-mask"
                                        placeholder="Title" aria-label="658 799 8941" value="{{ $employee->Title }}"
                                        name="title" aria-describedby="basic-icon-default-phone2" />
                                </div>
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <input type="radio" value="{{ $employee->InProgress }}" name="InProgress" style="display: none;"
                            checked>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-company">Photograph</label>
                            <div class="col-sm-10">
                                <div class="card mb-3">
                                    <div class="card-body" style="width: 300px;">
                                        <div>
                                            <input class="dropify" name="Photo" type="file" id="Photo"
                                                data-allowed-file-extensions="jpg png jpeg" data-show-errors="true"
                                                data-default-file="{{ asset('storage/employee/' . $employee->Photograph) }}">
                                        </div>
                                    </div>
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
                                    <textarea style="height: 100px;" id="basic-icon-default-message" class="form-control" name="notes"
                                        aria-label="Hi, Do you have a moment to talk Joe?" aria-describedby="basic-icon-default-message2">{{ $employee->Notes }}</textarea>
                                </div>
                                @error('notes')
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
