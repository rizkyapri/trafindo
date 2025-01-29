@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between">
            <div>
                <h1 style="color: black">
                    <i class="fa-solid fa-building text-dark" style="margin-right: 10px;"></i>Department
                </h1>
            </div>
            <div>
                <a href="{{ route('department.create') }}" class="btn btn-primary mb-2">
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
                <table class="table table-hover" id="myTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($dept as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td class="text-center">
                                    <form onsubmit="return confirm('Are you sure? ');"
                                        action="{{ route('department.destroy', $user->id) }}" method="POST">
                                        <a href="{{ route('department.edit', $user->id) }}"
                                            class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('department.destroy', $user->id) }}" class="btn btn-sm btn-danger"
                                            data-confirm-delete="true"><i class="fas fa-trash-alt"></i></a>
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
