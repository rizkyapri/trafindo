@extends('layouts.main')

@section('content')
    <main style: height: 100%;">
        <div class="container-fluid px-4">
            <div class="d-flex justify-content-between mb-3 mt-4">
                <h1 style="color: black">
                    <i class="fa-solid fa-clipboard-user"></i>
                    Role
                </h1>
                <div>
                    <a href="{{ route('role.create') }}" class="btn btn-primary mb-2">
                        <i class="fa-solid fa-plus" style="margin-right: 10px;"></i>
                        Create New
                    </a>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <table id="dataTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $role->Name }}</td>
                                    <td>
                                        <form onsubmit="return confirm('Are you sure? ');"
                                            action="{{ route('role.destroy', $role->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('role.edit', $role->id) }}" class="btn btn-sm btn-warning"><i
                                                    class="fas fa-edit"></i></a>
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                data-confirm-delete="true"><i class="fas fa-trash-alt"
                                                    data-confirm-delete="true"></i></button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    @include('sweetalert::alert')
    <script src="sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
@endsection
