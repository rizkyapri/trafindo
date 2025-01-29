
@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between">
            <div>
                <h1>
                    <i class="fa-solid fa-book" style="margin-right: 10px;"></i>Report Employee
                </h1>
            </div>
            <div>
                <a href="{{ route('employee.excel') }}">
                    <button id="toggleButton" class="btn btn-success mb-2">
                        <i class="fas fa-print"></i> Export Excel
                    </button></a>
            </div>
        </div>
        <hr class="my-3" />

            {{-- <div class="table-responsive text-nowrap container">
                <div style="margin-right:80%;" class="mb-4 mt-3">
                    <label for="TypeaheadBasic" class="form-label">Basic</label>
                    <input id="TypeaheadBasic" class="form-control typeahead" type="text" autocomplete="off" placeholder="Enter states from USA" />
                  </div> --}}
          
        <!-- Employee Table -->
        <div class="card">
            <p class="card-header"></p>
            <div class="table-responsive text-nowrap container">
                <form action="{{ route('employee.cetakBarcode') }}" method="post" class="form-employee">
                    @csrf
                    <table class="table table-hover" id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Employee Number</th>
                                <th>Department</th>
                                <th>Title</th>
                                <th>Photo</th>
                                <th>Notes</th>
                                <th>Progress</th>
                                {{-- <th>Action</th> --}}
                            </tr>
                </form>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($employees as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->Name }}</td>
                            <td>{{ $user->EmployeeNumber }}</td>
                            <td>
                                {{ $user->DepartmentName }}
                            </td>
                            <td>
                                <span class="badge bg-label-primary me-1">{{ $user->Title }}</span>
                            </td>
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal{{ $user->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal{{ $user->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel{{ $user->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel{{ $user->id }}">
                                                    {{ $user->Name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                </button>
                                            </div>
                                            <div class="modal-body row justify-content-center align-items-center">
                                                <img src="{{ asset('storage/employee/' . $user->Photograph) }}"
                                                    style="width: 100%;">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{ $user->Notes }}
                            </td>
                            <td>
                                @if ($user->InProgress == 0)
                                    <span class="badge bg-label-danger me-1">Stop</span>
                                @else
                                    <span class="badge bg-label-primary me-1">Run</span>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
                </table>



            </div>
        </div>
    </div>

    <!--/ Employee Table -->

    </div>
    <script src="assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script> 
@endsection
