@extends('layouts.app')

@section('content')
<div class="container-fluid mt-1" style="padding-left: 80px;">
    <div class="row">
        <div class="col-lg-12 mt-0" style="margin-top: -1000px ;">
            <!-- Card untuk Master Data -->
            <div class="card w-100 shadow-sm mb-3 mt-0" style="border: 1px solid rgba(128, 128, 128, 0.2); height: 68px; ">
                <div class="card-body p-2 h-100 d-flex align-items-center">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('icons/light/master-data-light.png') }}" alt="Master Data" class="mx-3" width="29">
                            <h4 class="mb-0 fw-bold" style="color: #2F3349;">Master Data</h4>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="mr-4 d-flex align-items-center">
                                <span id="currentDateTime" class="mx-2" style="color: #2F3349; font-weight: bold; font-style: italic;"></span>
                                <span style="background-color: #7266EE; color: white; display: inline-flex; justify-content: center; align-items: center; width: 63px; height: 28px; border-radius: 4px; font-style: italic ; margin-right: 10px ; margin-left: 5px ;">Shift 1</span>
                                <img src="{{ asset('icons/dark/sun.png') }}" alt="Logo" class="mx-2" width="29" height="29">
                                <img src="{{ asset('icons/dark/phone.png') }}" alt="Logo" class="mx-2" width="33" height="28.71">
                                <img src="{{ asset('icons/dark/profile-light.png') }}" alt="Logo" class="mx-2" width="40">
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
                    <h4 class="col mx-2 my-2" style="color: #464252; font-weight: 600;">Models</h4>
                        <div class="col-auto d-flex align-items-center">
                            <input type="text" id="search" class="form-control me-2" style="width: 200px;"
                                placeholder="Search Model" value="{{ request()->query('search') }}">
                            <span class="mx-2"
                                style="width: 1px; height: 30px; background-color: rgba(0, 0, 0, 0.2);"></span>
                                <button type="button" class="btn btn-custom-submit" data-bs-toggle="modal"
                                    data-bs-target="#addModelModal" 
                                    style="width: 190px;">+ Add New Model</button>

                        </div>
                    </div>
                    <div class="table-responsive flex-grow-1">
                        <table class="table text-center">
                            <thead>
                            <tr>
                                <th style="background-color: #f0f0f0; color: #6F6C78; text-transform: uppercase;">No</th>
                                <th style="background-color: #f0f0f0; color: #6F6C78; text-transform: uppercase;">Model Name</th>
                                <th style="background-color: #f0f0f0; color: #6F6C78; text-transform: uppercase;">Description</th>
                                <th style="background-color: #f0f0f0; color: #6F6C78; text-transform: uppercase;">Status</th>
                                <th style="background-color: #f0f0f0; color: #6F6C78; text-transform: uppercase;">Action</th>
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
                                                style="{{ $model->is_active ? '' : 'pointer-events: none; opacity: 0.5;' }}">
                                                <i class="fas fa-edit" style="color: #706E7A;"></i> <!-- Warna ikon edit -->
                                            </a>
                                            <button type="button" class="btn btn-link text-dark btn-delete" 
                                                style="border: none; background: none;"
                                                data-id="{{ $model->id }}" 
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModelModal"
                                                {{ $model->is_active ? '' : 'disabled' }}>
                                                <i class="fas fa-trash-alt" style="color: #706E7A;"></i> <!-- Warna ikon delete -->
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                        
                <!-- Pagination dan Nama -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <span class="mx-3" style="color: #6F6C78;"><b>Muhammad Apriyansyah</b></span>
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="{{ $models->url(1) }}" aria-label="First">
                                    <img src="{{ asset('icons/dark/doble-arrow-left.png') }}" alt="Double Left Arrow">
                                </a> <!-- Double left arrow -->
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="{{ $models->previousPageUrl() }}" aria-label="Previous" @if(!$models->onFirstPage()) disabled @endif>
                                    <img src="{{ asset('icons/dark/arrow-left.png') }}" alt="Single Left Arrow">
                                </a> <!-- Single left arrow -->
                            </li>
                            @for ($i = 1; $i <= $models->lastPage(); $i++)
                                <li class="page-item @if ($i == $models->currentPage()) active @endif">
                                    <a class="page-link" href="{{ $models->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item">
                                <a class="page-link" href="{{ $models->nextPageUrl() }}" aria-label="Next" @if(!$models->hasMorePages()) disabled @endif>
                                    <img src="{{ asset('icons/dark/arrow-right.png') }}" alt="Single Right Arrow">
                                </a> <!-- Single right arrow -->
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="{{ $models->url($models->lastPage()) }}" aria-label="Last">
                                    <img src="{{ asset('icons/dark/doble-arrow-right.png') }}" alt="Double Right Arrow">
                                </a> <!-- Double right arrow -->
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
    <div class="modal-dialog modal-dialog-centered"  style="width: 544px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModelModalLabel" style="display: flex; align-items: center;">
                    <i class="fas fa-plus" style="color: #32CD32; margin-right: 8px;"></i> 
                    <span style="color: #3B3B3B; font-weight: 600;">Add Model</span>
                </h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('models.store') }}" method="POST" style="display: flex; flex-direction: column; align-items: center;">
                    @csrf
                    <div class="mb-2" style="width: 90%;">
                        <label for="model_name" class="form-label" style="font-weight: 300; color: #4C4C4C;">Name<span class="text-danger">*</span></label>
                        <input type="text" id="model_name" name="model_name" required 
                               style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                    <div class="mb-3" style="width: 90%;">
                        <label for="model_description" class="form-label" style="font-weight: 300; color: #4C4C4C;">Description<span class="text-danger">*</span></label>
                        <input type="text" id="model_description" name="model_description" required 
                               style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                    <div class="text-end" style="margin-top: 20px; width: 90%;">
                        <button type="reset" style="background-color: #FFE2E3; color: #FF5559; border: none; padding: 8px 20px; border-radius: 4px; margin-right: 8px; font-weight: 600;">Cancel</button>
                        <button type="submit" style="background-color: #7367F0; color: white; border: none; padding: 8px 20px; border-radius: 4px; font-weight: 600;">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal untuk Update Model -->
<div class="modal fade" id="editModelModal" tabindex="-1" aria-labelledby="editModelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 544px; max-width: 100%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModelModalLabel" style="display: flex; align-items: center;">
                    <i class="fas fa-edit" style="color: #00BFFF; margin-right: 8px;"></i> 
                    <span style="color: #3B3B3B; font-weight: 600;">Update Model</span>
                </h5>
                <!-- Tombol silang dihapus untuk konsistensi -->
            </div>
            <div class="modal-body" style="position: relative;">
                <span id="last_update_time" style="opacity: 0.7; position: absolute; top: 10px; right: 20px; font-style: italic; font-size: 0.8rem;"></span>
                <form id="editModelForm" action="" method="POST" style="display: flex; flex-direction: column; align-items: center; margin-top: 30px;">
                    @csrf
                    @method('PUT')
                    <div class="mb-3" style="width: 90%;">
                        <label for="edit_model_name" class="form-label" style="font-weight: 300; color: #4C4C4C;">Name <span class="text-danger">*</span></label>
                        <input type="text" id="edit_model_name" name="model_name" required 
                               style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                    <div class="mb-3" style="width: 90%;">
                        <label for="edit_model_description" class="form-label" style="font-weight: 300; color: #4C4C4C;">Description <span class="text-danger">*</span></label>
                        <input type="text" id="edit_model_description" name="model_description" required 
                               style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                    <div class="text-end" style="margin-top: 20px; width: 90%;">
                        <button type="button" style="background-color: #FFE2E3; color: #FF5559; border: none; padding: 8px 20px; border-radius: 4px; margin-right: 8px; font-weight: 600;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" style="background-color: #7367F0; color: white; border: none; padding: 8px 20px; border-radius: 4px; font-weight: 600;">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal untuk Konfirmasi Hapus Data -->
<div class="modal fade" id="deleteModelModal" tabindex="-1" aria-labelledby="deleteModelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 514px; max-width: 100%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModelModalLabel">
                    Delete Item
                </h5>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('icons/trash.png') }}" alt="" srcset="" width="98" height="98">
                <h4 class="fw-bold my-3 mt-4" style="color: #4C4C4C; ">Are you sure to delete this item?</h4>
                <p class="mt-3" style="color: #939393 ;">If you delete this data, it will be deleted permanently.</p>
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
        // Function to add event listeners for edit and delete buttons
        function addEventListeners() {
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

                    // Show the modal first
                    var editModal = new bootstrap.Modal(document.getElementById('editModelModal'));
                    editModal.show();

                    // Now set the values in the input fields
                    document.getElementById('edit_model_name').value = modelName;
                    document.getElementById('edit_model_description').value = modelDescription;

                    // Set the last update time
                    document.getElementById('last_update_time').innerText = `Last Update: ${lastUpdateTime}`;
                });
            });

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const modelId = this.getAttribute('data-id');
                    // Set the action of the delete form
                    document.getElementById('deleteModelForm').action = `/models/${modelId}`;
                });
            });
        }

        // Initial event listener setup
        addEventListeners();

        // Real-time search functionality
        document.getElementById('search').addEventListener('keyup', function () {
            const query = this.value;
            fetch(`{{ route('search.models') }}?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('modelTableBody');
                    tableBody.innerHTML = ''; // Clear the table body

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
                                        data-name="${model.model_name ?? 'No data available'}"
                                        data-description="${model.model_description ?? 'No data available'}"
                                        data-last-update="${model.updated_at ? 
                                            (new Date(model.updated_at)).toLocaleString('en-GB', { 
                                                day: '2-digit', 
                                                month: 'long', 
                                                year: 'numeric', 
                                                hour: '2-digit', 
                                                minute: '2-digit', 
                                                second: '2-digit', 
                                                hour12: false 
                                            }).replace(' at ', ' ') : 'No data available'}"
                                        ${model.is_active ? '' : 'disabled'} 
                                        style="${model.is_active ? '' : 'pointer-events: none; opacity: 0.5;'}">
                                        <i class="fas fa-edit" style="color: #706E7A;"></i>
                                    </a>
                                    <button type="button" class="btn btn-link text-dark btn-delete" 
                                        style="border: none; background: none;"
                                        data-id="${model.id}" 
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModelModal"
                                        ${model.is_active ? '' : 'disabled'}>
                                        <i class="fas fa-trash-alt" style="color: #706E7A;"></i>
                                    </button>
                                </td>
                            `;
                            tableBody.appendChild(row);
                        });
                    }

                    // Call the function to add event listeners again after updating the table
                    addEventListeners();
                })
                .catch(error => {
                    console.error('Error:', error);
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