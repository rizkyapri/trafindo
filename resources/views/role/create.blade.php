@extends('layouts.main')

@section('content')
    <main style=height : 100%;">
        <div class="container-fluid px-4">
            <h1 class="my-4" style="color: black;">
                <i class='bx bxs-user-account' style="font-size: 40px"></i> Create Role
            </h1>
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('role.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('role.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
