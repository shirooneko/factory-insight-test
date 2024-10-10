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
            <div class="card w-100 shadow-sm h-100" style="border: 1px solid rgba(128, 128, 128, 0.2); min-height: calc(106vh - 200px);">
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
                        <table class="table text-center">
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
                                            <a href="#" class="text-dark btn-edit" 
                                            data-id="{{ $part->id }}"
                                            data-name="{{ $part->part_name ?? 'Tidak ada data' }}"
                                            data-part-number="{{ $part->part_number }}"
                                            data-part-code="{{ $part->part_code }}" 
                                            data-capacity="{{ $part->capacity_in_cart }}" 
                                            data-model-id="{{ $part->model_id }}"
                                            data-illustration-filename="{{ $part->image_filename }}" 
                                            data-last-update="{{ !is_null($part->updated_at) ? \Carbon\Carbon::parse($part->updated_at)->format('d F Y H:i:s') : 'Tidak ada data' }}"
                                            {{ $part->is_active ? '' : 'disabled' }} 
                                            style="{{ $part->is_active ? '' : 'pointer-events: none; opacity: 0.5;' }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-link text-dark btn-delete" 
                                                    style="border: none; background: none;"
                                                    data-id="{{ $part->id }}" 
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deletePartModal"
                                                    {{ $part->is_active ? '' : 'disabled' }}>
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
                                    <a class="page-link" href="{{ $parts->url(1) }}" aria-label="First">&laquo;&laquo;</a> <!-- Double left arrow -->
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="{{ $parts->previousPageUrl() }}" aria-label="Previous" @if(!$parts->onFirstPage()) disabled @endif>&laquo;</a> <!-- Single left arrow -->
                                </li>
                                @for ($i = 1; $i <= $parts->lastPage(); $i++)
                                    <li class="page-item @if ($i == $parts->currentPage()) active @endif">
                                        <a class="page-link" href="{{ $parts->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item">
                                    <a class="page-link" href="{{ $parts->nextPageUrl() }}" aria-label="Next" @if($parts->hasMorePages()) disabled @endif>&raquo;</a> <!-- Single right arrow -->
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="{{ $parts->url($parts->lastPage()) }}" aria-label="Last">&raquo;&raquo;</a> <!-- Double right arrow -->
                                </li>
                            </ul>
                        </nav>
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
                <form action="{{ route('parts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="part_name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="part_name" name="part_name" required>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-9">
                            <label for="model_id" class="form-label">Model <span class="text-danger">*</span></label>
                            <select class="form-control" id="model_id" name="model_id" required>
                                <option value="" disabled selected>Select a model</option>
                                @foreach($models as $model)
                                    <option value="{{ $model->id }}">{{ $model->model_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="part_code" class="form-label">Part Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="part_code" name="part_code" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-9">
                            <label for="part_number" class="form-label">Part Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="part_number" name="part_number" value="{{ $nextPartNumber }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="capacity" class="form-label">Qty Carts <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="capacity" name="capacity" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image <span class="text-danger">*</span></label>
                        <div class="d-flex justify-content-between">
                            <div class="text-center">
                                <div class="card" style="width: 150px;">
                                    <div class="card-header text-white small" style="background-color: rgba(0, 0, 0, 0.8);">
                                        Illustration Fix
                                    </div>
                                    <label for="illustration_fix" class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center no-rounded-top p-0" style="width: 100%; height: 150px; border-top: none;">
                                        <img src="{{ $part->illustration_fix ? asset('illustrations/' . $part->illustration_fix) : asset('icons/light/add-image.svg') }}" alt="Illustration Fix" class="img-fluid" id="illustration_fix_preview" />
                                    </label>
                                    <input type="file" name="illustration_fix" id="illustration_fix" class="d-none" accept="image/*" onchange="previewImage(event, 'illustration_fix_preview')" required>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="card" style="width: 150px;">
                                    <div class="card-header text-white small" style="background-color: rgba(0, 0, 0, 0.8);">
                                        Illustration Move
                                    </div>
                                    <label for="illustration_move" class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center no-rounded-top p-0" style="width: 100%; height: 150px; border-top: none;">
                                        <img src="{{ $part->illustration_move ? asset('illustrations/' . $part->illustration_move) : asset('icons/light/add-image.svg') }}" alt="Illustration Move" class="img-fluid" id="illustration_move_preview" />
                                    </label>
                                    <input type="file" name="illustration_move" id="illustration_move" class="d-none" accept="image/*" onchange="previewImage(event, 'illustration_move_preview')">
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="card" style="width: 150px;">
                                    <div class="card-header text-white small" style="background-color: rgba(0, 0, 0, 0.8);">
                                        Illustration Core
                                    </div>
                                    <label for="illustration_core" class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center no-rounded-top p-0" style="width: 100%; height: 150px; border-top: none;">
                                        <img src="{{ $part->illustration_core ? asset('illustrations/' . $part->illustration_core) : asset('icons/light/add-image.svg') }}" alt="Illustration Core" class="img-fluid" id="illustration_core_preview" />
                                    </label>
                                    <input type="file" name="illustration_core" id="illustration_core" class="d-none" accept="image/*" onchange="previewImage(event, 'illustration_core_preview')">
                                </div>
                            </div>
                        </div>
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
                <div class="mb-4">
                <span id="last_update_time_part" 
                    style="opacity: 0.7; position: absolute; top: 10px; right: 20px; font-style: italic; font-size: 0.8rem;"></span>

                </div>
                <form id="editPartForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_part_name" class="form-label">Part Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_part_name" name="part_name" required>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-9">
                            <label for="edit_model_id" class="form-label">Model <span class="text-danger">*</span></label>
                            <select class="form-control" id="edit_model_id" name="model_id" required>
                                <option value="" disabled selected>Select a model</option>
                                @foreach($models as $model)
                                    <option value="{{ $model->id }}">{{ $model->model_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="edit_part_code" class="form-label">Part Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_part_code" name="part_code" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-9">
                            <label for="edit_part_number" class="form-label">Part Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_part_number" name="part_number" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="edit_capacity" class="form-label">Qty Carts <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_capacity" name="capacity" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image <span class="text-danger">*</span></label>
                        <div class="d-flex justify-content-between">
                            <div class="text-center">
                                <div class="card" style="width: 150px;">
                                    <div class="card-header text-white small" style="background-color: rgba(0, 0, 0, 0.8);">
                                        Illustration Fix
                                    </div>
                                    <label for="edit_illustration_fix" class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center no-rounded-top p-0" style="width: 100%; height: 150px; border-top: none;">
                                        <img src="{{ isset($part) && $part->illustration_fix ? asset('illustrations/' . $part->illustration_fix) : asset('icons/light/add-image.svg') }}" alt="Illustration Fix" class="img-fluid" id="edit_illustration_fix_preview" style="width: 100%; height: 100%; object-fit: cover; padding: 0; margin: 0;" />
                                    </label>
                                    <input type="file" name="illustration_fix" id="edit_illustration_fix" class="d-none" accept="image/*" onchange="previewImage(event, 'edit_illustration_fix_preview')">
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="card" style="width: 150px;">
                                    <div class="card-header text-white small" style="background-color: rgba(0, 0, 0, 0.8);">
                                        Illustration Move
                                    </div>
                                    <label for="edit_illustration_move" class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center no-rounded-top p-0" style="width: 100%; height: 150px; border-top: none;">
                                        <img src="{{ isset($part) && $part->illustration_move ? asset('illustrations/' . $part->illustration_move) : asset('icons/light/add-image.svg') }}" alt="Illustration Move" class="img-fluid" id="edit_illustration_move_preview" style="width: 100%; height: 100%; object-fit: cover; padding: 0; margin: 0;" />
                                    </label>
                                    <input type="file" name="illustration_move" id="edit_illustration_move" class="d-none" accept="image/*" onchange="previewImage(event, 'edit_illustration_move_preview')">
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="card" style="width: 150px;">
                                    <div class="card-header text-white small" style="background-color: rgba(0, 0, 0, 0.8);">
                                        Illustration Core
                                    </div>
                                    <label for="edit_illustration_core" class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center no-rounded-top p-0" style="width: 100%; height: 150px; border-top: none;">
                                        <img src="{{ isset($part) && $part->illustration_core ? asset('illustrations/' . $part->illustration_core) : asset('icons/light/add-image.svg') }}" alt="Illustration Core" class="img-fluid" id="edit_illustration_core_preview" style="width: 100%; height: 100%; object-fit: cover; padding: 0; margin: 0;" />
                                    </label>
                                    <input type="file" name="illustration_core" id="edit_illustration_core" class="d-none" accept="image/*" onchange="previewImage(event, 'edit_illustration_core_preview')">
                                </div>
                            </div>
                        </div>
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

<!-- Modal untuk Konfirmasi Hapus Data Part -->
<div class="modal fade" id="deletePartModal" tabindex="-1" aria-labelledby="deletePartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePartModalLabel">
                    Delete Part
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h1><i class="fas fa-trash-alt me-2 text-danger my-3" style="font-size: 2.5rem;"></i></h1>
                <h4 class="fw-bold my-3">Are you sure to delete this part?</h4>
                <p class="mt-3">If you delete this data, it will be deleted permanently.</p>
            </div>
            <div class="modal-footer justify-content-center" style="border-top: none;">
                <button type="button" class="btn btn-transparent-danger" data-bs-dismiss="modal">Cancel</button>
                <form id="deletePartForm" action="" method="POST" style="display:inline;">
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
    const nextPartNumber = "{{ $nextPartNumber }}"; // Ambil nilai nextPartNumber dari backend
    var editPartModal = new bootstrap.Modal(document.getElementById('editPartModal'));

    $(document).on('click', '.btn-edit', function (e) {
        e.preventDefault();

        const partId = $(this).data('id');
        const partName = $(this).data('name');
        const partNumber = $(this).data('part-number') || nextPartNumber; // Cek part_number
        const partCode = $(this).data('part-code');
        const capacity = $(this).data('capacity');
        const modelId = $(this).data('model-id');
        const lastUpdate = $(this).data('last-update'); // Ambil last_update

        // Ambil data filename dari data part
        const illustrationFilenames = $(this).data('illustration-filename') || {};
        const illustrationFix = illustrationFilenames.illustration_fix || '';
        const illustrationMove = illustrationFilenames.illustration_move || '';
        const illustrationCore = illustrationFilenames.illustration_core || '';

        // Set URL action untuk form
        $('#editPartForm').attr('action', `/parts/${partId}`);
        $('#edit_part_name').val(partName);
        $('#edit_part_number').val(partNumber);
        $('#edit_part_code').val(partCode);
        $('#edit_capacity').val(capacity);
        $('#edit_model_id').val(modelId);

        // Set gambar untuk preview dari database atau tampilkan ikon default
        $('#edit_illustration_fix_preview').attr('src', illustrationFix ? `{{ asset('illustrations/') }}/${illustrationFix}` : `{{ asset('icons/light/add-image.svg') }}`);
        $('#edit_illustration_move_preview').attr('src', illustrationMove ? `{{ asset('illustrations/') }}/${illustrationMove}` : `{{ asset('icons/light/add-image.svg') }}`);
        $('#edit_illustration_core_preview').attr('src', illustrationCore ? `{{ asset('illustrations/') }}/${illustrationCore}` : `{{ asset('icons/light/add-image.svg') }}`);

        // Tampilkan last update di modal
        document.getElementById('last_update_time_part').textContent = `Last Update: ${lastUpdate}`;

        // Tampilkan modal
        editPartModal.show();
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.btn-delete');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const partId = this.getAttribute('data-id');
            // Set the action of the delete form
            document.getElementById('deletePartForm').action = `/parts/${partId}`;
        });
    });
});

</script>





<script>
    function previewImage(event, previewId) {
        const input = event.target;
        const file = input.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById(previewId);
                preview.src = e.target.result;
                preview.style.width = '100%';
                preview.style.height = '100%';
                preview.style.objectFit = 'cover';
                preview.style.padding = '0';
                preview.style.margin = '0';
            };
            reader.readAsDataURL(file);
        } else {
            alert('Please select a valid image file.');
            input.value = ''; // Clear the input
        }
    }
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Real-time search functionality
    document.getElementById('search').addEventListener('keyup', function () {
        const query = this.value;
        fetch(`{{ route('search.parts') }}?query=${query}`)
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('partTableBody');
                tableBody.innerHTML = '';

                if (data.length === 0) {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td colspan="8" class="text-center">Tidak ada data</td>
                    `;
                    tableBody.appendChild(row);
                } else {
                    data.forEach((part, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${index + 1}</td>
                            <td>${part.model ? part.model.model_name : ''}</td>
                            <td>${part.part_name || ''}</td>
                            <td>${part.part_number || ''}</td>
                            <td>${part.part_code || ''}</td>
                            <td>${part.capacity_in_cart || ''}</td>
                            <td>
                                <span class="badge ${part.is_active ? 'badge-active' : 'badge-inactive'}">
                                    ${part.is_active ? 'Active' : 'Inactive'}
                                </span>
                            </td>
                            <td>
                                <a href="#" class="text-dark btn-edit" 
                                   data-id="${part.id}"
                                   data-name="${part.part_name || ''}"
                                   data-part-number="${part.part_number || ''}"
                                   data-part-code="${part.part_code || ''}" 
                                   data-capacity="${part.capacity_in_cart || ''}" 
                                   data-model-id="${part.model ? part.model.id : ''}"
                                   data-illustration-filename="${part.image_filename || ''}" 
                                   data-last-update="${part.updated_at ? new Date(part.updated_at).toLocaleString() : ''}"
                                   ${part.is_active ? '' : 'disabled'} 
                                   style="${part.is_active ? '' : 'pointer-events: none; opacity: 0.5;'}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-link text-dark btn-delete" 
                                        style="border: none; background: none;"
                                        data-id="${part.id}" 
                                        data-bs-toggle="modal"
                                        data-bs-target="#deletePartModal"
                                        ${part.is_active ? '' : 'disabled'}>
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


@endsection
