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
            <!-- Card untuk Tabel Models -->
            <div class="card w-100 shadow-sm h-100"
                style="border: 1px solid rgba(128, 128, 128, 0.2); min-height: calc(106vh - 200px);">
                <div class="card-body p-2 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="col mx-2" style="color: #2F3349;">Models</h2>
                        <div class="col-auto d-flex align-items-center">
                            <input type="text" id="search" class="form-control me-2" style="width: 200px;"
                                placeholder="Search Model" value="{{ request()->query('search') }}">
                            <span class="mx-2"
                                style="width: 1px; height: 30px; background-color: rgba(0, 0, 0, 0.2);"></span>
                            <button type="button" class="btn btn-custom-submit" data-bs-toggle="modal"
                                data-bs-target="#addModelModal" style="width: 160px;">+ Add New Model</button>
                        </div>
                    </div>
                    <div class="table-responsive flex-grow-1">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th style="background-color: #f0f0f0;">No</th>
                                    <th style="background-color: #f0f0f0;">Model Name</th>
                                    <th style="background-color: #f0f0f0;">Description</th>
                                    <th style="background-color: #f0f0f0;">Status</th>
                                    <th style="background-color: #f0f0f0;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="modelTableBody">
                                @foreach($models as $model)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $model->model_name ?? 'Tidak ada data' }}</td>
                                        <td>{{ $model->model_description ?? 'Tidak ada data' }}</td>
                                        <td>
                                            <span class="badge {{ $model->is_active ? 'badge-active' : 'badge-inactive' }}">
                                                {{ $model->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="#" class="text-dark btn-edit" data-id="{{ $model->id }}"
                                                data-name="{{ $model->model_name ?? 'Tidak ada data' }}"
                                                data-description="{{ $model->model_description ?? 'Tidak ada data' }}"
                                                data-last-update="{{ !is_null($model->updated_at) ? \Carbon\Carbon::parse($model->updated_at)->format('d F Y H:i:s') : 'Tidak ada data' }}"
                                                {{ $model->is_active ? '' : 'disabled' }} 
                                                style="{{ $model->is_active ? '' : 'pointer-events: none; opacity: 0.5;' }}"> <!-- Styling jika disabled -->
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-link text-dark btn-delete" 
                                                style="border: none; background: none;"
                                                data-id="{{ $model->id }}" 
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModelModal"
                                                {{ $model->is_active ? '' : 'disabled' }}> <!-- Nonaktifkan tombol jika inactive -->
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                        
                <!-- Pagination dan Nama -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <span class="fw-bold mx-3" style="color: #2F3349;">Muhammad Apriyansyah</span>
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="{{ $models->url(1) }}" aria-label="First">&laquo;&laquo;</a> <!-- Double left arrow -->
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="{{ $models->previousPageUrl() }}" aria-label="Previous" @if(!$models->onFirstPage()) disabled @endif>&laquo;</a> <!-- Single left arrow -->
                            </li>
                            @for ($i = 1; $i <= $models->lastPage(); $i++)
                                <li class="page-item @if ($i == $models->currentPage()) active @endif">
                                    <a class="page-link" href="{{ $models->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item">
                                <a class="page-link" href="{{ $models->nextPageUrl() }}" aria-label="Next" @if(!$models->hasMorePages()) disabled @endif>&raquo;</a> <!-- Single right arrow -->
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="{{ $models->url($models->lastPage()) }}" aria-label="Last">&raquo;&raquo;</a> <!-- Double right arrow -->
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Add New Model -->
<div class="modal fade" id="addModelModal" tabindex="-1" aria-labelledby="addModelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModelModalLabel">
                    <i class="fas fa-plus me-2 text-success"></i> Add New Model
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('models.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="model_name" class="form-label">Model Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="model_name" name="model_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="model_description" class="form-label">Description <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="model_description" name="model_description"
                            required>
                    </div>
                    <div class="text-end">
                        <button type="reset" class="btn btn-transparent-danger">Cancel</button>
                        <button type="submit" class="btn btn-custom-submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Update Model -->
<div class="modal fade" id="editModelModal" tabindex="-1" aria-labelledby="editModelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModelModalLabel">
                    <i class="fas fa-edit me-2 text-info"></i> Update Model
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="position: relative;">
                <div class="mb-4">
                    <span id="last_update_time"
                        style="opacity: 0.7; position: absolute; top: 10px; right: 20px; font-style: italic; font-size: 0.8rem;"></span>
                </div>
                <form id="editModelForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_model_name" class="form-label">Model Name <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_model_name" name="model_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_model_description" class="form-label">Description <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_model_description" name="model_description"
                            required>
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

<!-- Modal untuk Konfirmasi Hapus Data -->
<div class="modal fade" id="deleteModelModal" tabindex="-1" aria-labelledby="deleteModelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModelModalLabel">
                    Delete Item
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h1><i class="fas fa-trash-alt me-2 text-danger my-3" style="font-size: 2.5rem;"></i></h1>
                <h4 class="fw-bold my-3">Are you sure to delete this item?</h4>
                <p class="mt-3">If you delete this data, it will be deleted permanently.</p>
            </div>
            <div class="modal-footer justify-content-center" style="border-top: none;">
                <button type="button" class="btn btn-transparent-danger" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteModelForm" action="" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-custom-submit">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.btn-edit');
        const deleteButtons = document.querySelectorAll('.btn-delete');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const modelId = this.getAttribute('data-id');
                const modelName = this.getAttribute('data-name');
                const modelDescription = this.getAttribute('data-description');
                const lastUpdateTime = this.getAttribute('data-last-update');

                // Set the action of the form
                document.getElementById('editModelForm').action = `/models/${modelId}`;

                // Set the values in the input fields
                document.getElementById('edit_model_name').value = modelName;
                document.getElementById('edit_model_description').value = modelDescription;

                // Set the last update time
                document.getElementById('last_update_time').innerText = `Last Update: ${lastUpdateTime}`;

                // Show the modal
                var editModal = new bootstrap.Modal(document.getElementById('editModelModal'));
                editModal.show();
            });
        });

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const modelId = this.getAttribute('data-id');
                // Set the action of the delete form
                document.getElementById('deleteModelForm').action = `/models/${modelId}`;
            });
        });

        // Real-time search functionality
        document.getElementById('search').addEventListener('keyup', function () {
            const query = this.value;
            fetch(`{{ route('search.models') }}?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('modelTableBody');
                    tableBody.innerHTML = '';
        
                    if (data.length === 0) {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td colspan="5" class="text-center">Tidak ada data</td>
                        `;
                        tableBody.appendChild(row);
                    } else {
                        data.forEach((model, index) => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${index + 1}</td>
                                <td>${model.model_name ?? 'Tidak ada data'}</td>
                                <td>${model.model_description ?? 'Tidak ada data'}</td>
                                <td>
                                    <span class="badge ${model.is_active ? 'badge-active' : 'badge-inactive'}">
                                        ${model.is_active ? 'Active' : 'Inactive'}
                                    </span>
                                </td>
                                <td>
                                    <a href="#" class="text-dark btn-edit" data-id="${model.id}"
                                        data-name="${model.model_name ?? 'Tidak ada data'}"
                                        data-description="${model.model_description ?? 'Tidak ada data'}"
                                        data-last-update="${model.updated_at ? new Date(model.updated_at).toLocaleString() : 'Tidak ada data'}"
                                        ${model.is_active ? '' : 'disabled'} 
                                        style="${model.is_active ? '' : 'pointer-events: none; opacity: 0.5;'}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-link text-dark btn-delete" 
                                        style="border: none; background: none;"
                                        data-id="${model.id}" 
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModelModal"
                                        ${model.is_active ? '' : 'disabled'}>
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            `;
                            tableBody.appendChild(row);
                        });
                    }
                });
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