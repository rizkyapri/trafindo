@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h1 class="my-4" style="color: black">
            <i class="fa-solid fa-user-pen"></i>
            Edit User
        </h1>
        <!-- Basic with Icons -->
        <div>
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('user.update', $user->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Username</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bx-user"></i></span>
                                    <input type="text" class="form-control" id="basic-icon-default-fullname"
                                        placeholder="Input Username" aria-label="John Doe" value="{{ $user->username }}"
                                        name="username" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-company">Password</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-company2" class="input-group-text"><i
                                            class="bx bx-key"></i></span>
                                    <input type="password" id="basic-icon-default-company" class="form-control"
                                        placeholder="Input password" aria-label="ACME Inc." name="password"
                                        aria-describedby="basic-icon-default-company2" />
                                </div>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-email">Role</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bxs-user-account"></i></span>
                                    <select class="form-select @error('role') is-invalid @enderror" aria-label="role"
                                        id="role" name="role">
                                        <option selected disabled>- Choose role -</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                {{ $role->Name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('role')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3" id="andoncat-field" style="display: none;">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-email">Andon Category
                                Problem</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-error"></i></span>
                                    <select class="form-select @error('andoncat') is-invalid @enderror"
                                        aria-label="andoncat" id="andoncat" name="andoncat">
                                        <option selected disabled>- Choose andoncat -</option>
                                        @foreach ($andoncat as $andon)
                                            <option value="{{ $andon->id }}"
                                                {{ $user->andoncat_id == $andon->id ? 'selected' : '' }}>
                                                {{ $andon->CategoryProblem }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('andoncat')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">

                                <button type="submit" class="btn btn-primary">Submit    </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        $(document).ready(function() {
            // Pilih elemen dropdown "Role" berdasarkan ID
            var roleDropdown = $('#role');

            // Pilih elemen dropdown "Andon Category Problem" berdasarkan ID
            var andonCatField = $('#andoncat-field');

            // Saat halaman dimuat, periksa peran yang sudah dipilih
            if (roleDropdown.val() === '2') {
                andonCatField.show();
            } else {
                andonCatField.hide();
            }

            // Saat peran (role) berubah
            roleDropdown.on('change', function() {
                // Jika peran yang dipilih adalah "Andon," tampilkan dropdown "Andon Category Problem"
                if (roleDropdown.val() === '2') {
                    andonCatField.show();
                } else {
                    // Jika peran yang dipilih bukan "Andon," sembunyikan dropdown "Andon Category Problem"
                    andonCatField.hide();
                }
            });
        });
    </script>
@endsection
