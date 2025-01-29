@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between">
            <div>
                <h1 style="color: black">
                    <i class="fa-solid fa-user-tie" style="margin-right: 10px; color: black"></i>User
                </h1>
            </div>
            <div>
                <button id="toggleButton" style="display: none;" class="btn btn-success mb-2"
                    onclick="cetakBarcode('{{ route('employee.cetakBarcode') }}')">
                    <i class="fas fa-print" style="margin-right: 10px;"></i> Print
                </button>
                <a href="{{ route('user.create') }}" class="btn btn-primary mb-2">
                    <i class="fa-solid fa-plus" style="margin-right: 10px;"></i>
                    Add New
                </a>
            </div>
        </div>
        <hr class="my-3" />

        <!-- Employee Table -->
        <div class="card">
            <p class="card-header"></p>
            <div class="table-responsive text-nowrap container">
                <form action="{{ route('employee.cetakBarcode') }}" method="post" class="form-employee">
                    @csrf
                    <table class="table table-hover text-nowrap" id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Category Problem</th>
                                <th>Action</th>
                            </tr>
                </form>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($user as $users)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $users->username }}</td>
                            <td>{{ $users->role->Name }}</td>
                            <td>
                                @if ($users->andoncat == !null)
                                    {{ $users->andoncat->CategoryProblem }}
                                @else
                                    <span class="badge bg-secondary me-1">No Data</span>
                                @endif
                            </td>
                            {{-- <td>{{ $users->andoncat->CategoryProblem }}</td> --}}
                            <td>
                                <form onsubmit="return confirm('Are you sure? ');"
                                    action="{{ route('user.destroy', $users->id) }}" method="POST">
                                    <a href="{{ route('user.edit', $users->id) }}" class="btn btn-sm btn-warning"><i
                                            class="fas fa-edit"></i></a>
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('user.destroy', $users->id) }}" class="btn btn-sm btn-danger"
                                        data-confirm-delete="true"><i class="fas fa-trash-alt"
                                            data-confirm-delete="true"></i></a>
                                </form>
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
@endsection
