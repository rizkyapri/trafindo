@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h1 class="my-4" style="color: black">
            <i class="fa-solid fa-pen-to-square"></i>
            Edit Andon Category
        </h1>
        <!-- Basic with Icons -->
        <div class="">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between"></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('andcat.update', $andcat->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Guard ID</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <select class="selectpicker @error('employee') is-invalid @enderror"
                                        data-style="btn-secondary" data-live-search="true" aria-label="employee"
                                        id="employee" name="Guard_EmployeeID">
                                        <option selected disabled>- Choose Employee -</option>
                                        @foreach ($name as $employee)
                                            <option value="{{ $employee->id }}" data-employee-name="{{ $employee->Name }}"
                                                {{ $andcat->Guard_EmployeeID == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->Name }} | {{ $employee->EmployeeNumber }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('employee')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Contact Person</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control" id="contactPerson" placeholder="Input Name"
                                        aria-label="John Doe" value="" name="contact"
                                        aria-describedby="basic-icon-default-fullname2" readonly />
                                </div>
                                @error('contact')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Nomor Whatsapp</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control" id="basic-icon-default-fullname"
                                        placeholder="Input No WA" aria-label="John Doe" value="" name="nomorWA"
                                        aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('nomorWA')
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
@push('scripts')
    <script>
        // Ambil elemen dropdown "Employee" dan input "Contact Person"
        var employeeDropdown = document.getElementById('employee');
        var contactPersonInput = document.getElementById('contactPerson');

        // Tambahkan event listener untuk mengubah nilai input "Contact Person" saat pilihan "Employee" berubah
        employeeDropdown.addEventListener('change', function() {
            var selectedEmployee = employeeDropdown.options[employeeDropdown.selectedIndex];
            // contactPersonInput.value = selectedEmployee.text; // Menggunakan teks yang dipilih dari dropdown
            var employeeName = selectedEmployee.getAttribute('data-employee-name');

            if (employeeName) {
                var splitName = employeeName.split('|')[0].trim(); // Mengambil nama karyawan saja
                contactPersonInput.value = splitName;
            } else {
                contactPersonInput.value = ''; // Reset nilai input jika tidak ada karyawan yang dipilih
            }
        });
    </script>
@endpush
