@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between">
            <div>
                <h1 style="color: black">
                    <i class="fa-solid fa-layer-group" style="color: #000000;"></i>
                    Andon Category Edit
                </h1>
            </div>
            <!-- <div>

                        <a href="{{ route('assignwo.create') }}" class="btn btn-primary mb-2">
                            <i class="fa-solid fa-plus" style="margin-right: 10px;"></i>
                            Add New
                        </a>
                    </div> -->

        </div>
        <hr style="color: black;" class="my-3" />

        <!-- Employee Table -->
        <div class="card">
            <p class="card-header"></p>
            <div class="table-responsive text-nowrap container">
                <form action="" method="post" class="form-employee">
                    @csrf
                    <table class="table table-hover" id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Code Andon</th>
                                <th>Category Problem</th>
                                <th>Assigned To</th>
                                <th>Guard</th>
                                <th>Contact Person</th>
                                <th>HP WA</th>
                                <th>Edit</th>
                            </tr>
                </form>
                </thead>
                <tbody>
                    @foreach ($andcat as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->CodeAndon }}</td>
                            <td>{{ $user->CategoryProblem }}</td>
                            <td>{{ $user->AssignTo }}</td>
                            <td>
                                @if ($user->employee)
                                    {{ $user->employee->EmployeeNumber }}
                                @else
                                    <span class="badge bg-label-secondary me-1">No Data</span>
                                @endif
                            </td>
                            <td>{{ $user->ContactPerson }}</td>
                            <td>{{ $user->HP_WA }}</td>

                            <td class="text-center">
                                <a href="{{ route('andcat.edit', $user->id) }}" class="btn btn-sm btn-primary"><i
                                        class="fas fa-edit"></i></a>
                            </td>

                        </tr>
                </tbody>
                @endforeach
                </table>
            </div>
        </div>
    </div>

    <!--/ Employee Table -->

    </div>
@endsection
