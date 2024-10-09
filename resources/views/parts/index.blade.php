@extends('layouts.app')

@section('content')
<div class="container-fluid mt-1">
    <div class="row">
    <div class="col-lg-12">
            <!-- Card untuk Master Data -->
            <div class="card w-100 shadow-sm mb-4" style="border: 1px solid rgba(128, 128, 128, 0.2); height: 60px;">
                <div class="card-body p-2 h-100 d-flex align-items-center">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('icons/light/master-data-light.png') }}" alt="Master Data" class="mx-3" width="25">
                            <h4 class="mb-0 fw-bold" style="color: #2F3349;">Master Data</h4>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="mr-4">
                                <span id="currentDateTime" class="mx-2" style="color: #2F3349; font-weight: bold;"></span>
                                <i class="fas fa-sun mx-2" style="color: #2F3349;"></i>
                                <i class="fas fa-phone mx-2" style="color: #2F3349;"></i>
                                <img src="{{ asset('icons/light/user-light.png') }}" alt="Logo" class="mx-2" width="25">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <!-- Card untuk Tabel Parts -->
            <div class="card w-100 shadow-sm h-100" style="border: 1px solid rgba(128, 128, 128, 0.2); min-height: calc(100vh - 200px);">
                <div class="card-body p-2 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="col mx-2" style="color: #2F3349;">Parts</h2>
                        <div class="col-auto d-flex align-items-center">
                            <input type="text" id="search" class="form-control me-2" style="width: 200px;" placeholder="Search Part" value="{{ request()->query('search') }}">
                            <span class="mx-2" style="width: 1px; height: 30px; background-color: rgba(0, 0, 0, 0.2);"></span>
                            <button type="button" class="btn btn-custom-submit" data-bs-toggle="modal" data-bs-target="#addPartModal" style="width: 160px;">+ Add New Part</button>
                        </div>
                    </div>
                    <div class="table-responsive flex-grow-1">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="background-color: #f0f0f0;">No</th>
                                    <th style="background-color: #f0f0f0;">Model</th>
                                    <th style="background-color: #f0f0f0;">Part Name</th>
                                    <th style="background-color: #f0f0f0;">Part Number</th>
                                    <th style="background-color: #f0f0f0;">Part Code</th>
                                    <th style="background-color: #f0f0f0;">Quantity Cart</th>
                                    <th style="background-color: #f0f0f0;">Status</th>
                                    <th style="background-color: #f0f0f0;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="partTableBody">
                                @foreach($parts as $part)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $part->model->model_name }}</td>
                                        <td>{{ $part->part_name }}</td>
                                        <td>{{ $part->part_number }}</td>
                                        <td>{{ $part->part_code }}</td>
                                        <td>{{ $part->capacity_in_cart }}</td>
                                        <td>
                                            <span class="badge {{ $part->is_active ? 'badge-active' : 'badge-inactive' }}">
                                                {{ $part->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="#" class="text-dark btn-edit" data-id="{{ $part->id }}"
                                                data-name="{{ $part->part_name ?? 'Tidak ada data' }}"
                                                data-description="{{ $part->model->model_description ?? 'Tidak ada data' }}"
                                                data-last-update="{{ !is_null($part->updated_at) ? \Carbon\Carbon::parse($part->updated_at)->format('d F Y H:i:s') : 'Tidak ada data' }}"
                                                {{ $part->is_active ? '' : 'disabled' }} 
                                                style="{{ $part->is_active ? '' : 'pointer-events: none; opacity: 0.5;' }}"> <!-- Styling jika disabled -->
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-link text-dark btn-delete" 
                                                style="border: none; background: none;"
                                                data-id="{{ $part->id }}" 
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModelModal"
                                                {{ $part->is_active ? '' : 'disabled' }}> <!-- Nonaktifkan tombol jika inactive -->
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Add New Part -->
<div class="modal fade" id="addPartModal" tabindex="-1" aria-labelledby="addPartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPartModalLabel">
                    <i class="fas fa-plus me-2 text-success"></i> Add New Part
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('parts.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="part_name" class="form-label">Part Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="part_name" name="part_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="part_number" class="form-label">Part Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="part_number" name="part_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="part_code" class="form-label">Part Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="part_code" name="part_code" required>
                    </div>
                    <div class="mb-3">
                        <label for="capacity_in_cart" class="form-label">Quantity Cart <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="capacity_in_cart" name="capacity_in_cart" required>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-transparent-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-custom-submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Update Part -->
<div class="modal fade" id="editPartModal" tabindex="-1" aria-labelledby="editPartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPartModalLabel">
                    <i class="fas fa-edit me-2 text-info"></i> Update Part
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPartForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_part_name" class="form-label">Part Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_part_name" name="part_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_part_number" class="form-label">Part Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_part_number" name="part_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_part_code" class="form-label">Part Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_part_code" name="part_code" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_capacity_in_cart" class="form-label">Quantity Cart <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="edit_capacity_in_cart" name="capacity_in_cart" required>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-transparent-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-custom-submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Script untuk Edit Part
    $(document).ready(function () {
        $('#partTableBody').on('click', '.btn-warning', function () {
            const row = $(this).closest('tr');
            const partId = row.find('td:eq(0)').text();
            const partName = row.find('td:eq(2)').text();
            const partNumber = row.find('td:eq(3)').text();
            const partCode = row.find('td:eq(4)').text();
            const capacity = row.find('td:eq(5)').text();

            $('#editPartForm').attr('action', `/parts/${partId}`);
            $('#edit_part_name').val(partName);
            $('#edit_part_number').val(partNumber);
            $('#edit_part_code').val(partCode);
            $('#edit_capacity_in_cart').val(capacity);
            $('#editPartModal').modal('show');
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function updateDateTime() {
            const dateOptions = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
            const timeOptions = { hour: '2-digit', minute: '2-digit', hour12: false };
            const now = new Date();
            
            const weekday = now.toLocaleDateString('en-US', { weekday: 'long' });
            const day = now.toLocaleDateString('en-US', { day: 'numeric' });
            const month = now.toLocaleDateString('en-US', { month: 'long' });
            const year = now.toLocaleDateString('en-US', { year: 'numeric' });
            const formattedDate = `${weekday}, ${day} ${month} ${year}`;
            
            const formattedTime = now.toLocaleTimeString('en-US', timeOptions);
            document.getElementById('currentDateTime').innerText = `${formattedDate} - ${formattedTime}`;
        }

        updateDateTime();
        setInterval(updateDateTime, 60000); // Update every minute
    });
</script>
@endsection
