@extends('layouts.app')

@section('content')
<div class="container-fluid mt-1" style="padding-left: 80px;">
    <div class="row">
        <div class="col-lg-12">
            <!-- Card untuk Master Data -->
            <div class="card w-100 shadow-sm mb-3 mt-0" style="border: 1px solid rgba(128, 128, 128, 0.2); height: 68px;">
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
            <!-- Card untuk Tabel Parts -->
            <div class="card w-100 shadow-sm h-100" style="border: 1px solid rgba(128, 128, 128, 0.2); min-height: calc(106vh - 200px);">
                <div class="card-body p-2 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="col mx-2 my-2" style="color: #464252; font-weight: 600;">Parts</h4>
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
                            <th style="background-color: #f0f0f0; color: #6F6C78; text-transform: uppercase;">No</th>
                            <th style="background-color: #f0f0f0; color: #6F6C78; text-transform: uppercase;">Model</th>
                            <th style="background-color: #f0f0f0; color: #6F6C78; text-transform: uppercase;">Part Name</th>
                            <th style="background-color: #f0f0f0; color: #6F6C78; text-transform: uppercase;">Part Number</th>
                            <th style="background-color: #f0f0f0; color: #6F6C78; text-transform: uppercase;">Part Code</th>
                            <th style="background-color: #f0f0f0; color: #6F6C78; text-transform: uppercase;">Quantity Cart</th>
                            <th style="background-color: #f0f0f0; color: #6F6C78; text-transform: uppercase;">IMAGE</th>
                            <th style="background-color: #f0f0f0; color: #6F6C78; text-transform: uppercase;">Status</th>
                            <th style="background-color: #f0f0f0; color: #6F6C78; text-transform: uppercase;">Action</th>
                        </tr>
                        </thead>
                        <tbody id="partTableBody">
                            @forelse($parts as $part)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $part->model->model_name }}</td>
                                    <td>{{ $part->part_name }}</td>
                                    <td>{{ $part->part_number }}</td>
                                    <td>{{ $part->part_code }}</td>
                                    <td>{{ $part->capacity_in_cart }}</td>
                                    <td>
                                        <a href="#" class="text-dark image-view"" 
                                        data-id="{{ $part->id }}"
                                        data-model-id="{{ $part->model_id }}"
                                        data-illustration-filename="{{ $part->image_filename }}" >
                                            <img src="{{ asset('icons/image-view.png') }}" alt="Logo" class="mx-2" width="25">
                                        </a>
                                    </td>
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
                                            <i class="fas fa-edit" style="color: #706E7A;"></i>
                                        </a>
                                        <button type="button" class="btn btn-link text-dark btn-delete" 
                                                style="border: none; background: none;"
                                                data-id="{{ $part->id }}" 
                                                data-bs-toggle="modal"
                                                data-bs-target="#deletePartModal"
                                                {{ $part->is_active ? '' : 'disabled' }}>
                                            <i class="fas fa-trash-alt" style="color: #706E7A;"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    </div>
                    <!-- Pagination dan Nama -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <span class="fw-bold mx-3" style="color: #6F6C78;">Muhammad Apriyansyah</span>
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="{{ $parts->url(1) }}" aria-label="First">
                                        <img src="{{ asset('icons/dark/doble-arrow-left.png') }}" alt="Double Left Arrow">
                                    </a> <!-- Double left arrow -->
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="{{ $parts->previousPageUrl() }}" aria-label="Previous" @if(!$parts->onFirstPage()) disabled @endif>
                                        <img src="{{ asset('icons/dark/arrow-left.png') }}" alt="Single Left Arrow">
                                    </a> <!-- Single left arrow -->
                                </li>
                                @for ($i = 1; $i <= $parts->lastPage(); $i++)
                                    <li class="page-item @if ($i == $parts->currentPage()) active @endif">
                                        <a class="page-link" href="{{ $parts->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item">
                                    <a class="page-link" href="{{ $parts->nextPageUrl() }}" aria-label="Next" @if(!$parts->hasMorePages()) disabled @endif>
                                        <img src="{{ asset('icons/dark/arrow-right.png') }}" alt="Single Right Arrow">
                                    </a> <!-- Single right arrow -->
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="{{ $parts->url($parts->lastPage()) }}" aria-label="Last">
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
</div>

<!-- Modal untuk Ilustrasi View -->
<div class="modal fade" id="illustrationViewModal" tabindex="-1" aria-labelledby="illustrationViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="illustrationViewModalLabel">
                    <i class="fas fa-image me-2 text-info"></i> Ilustrasi View
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 text-center">
                    <label class="form-label">Illustration Fix</label>
                    <p id="illustration_fix_filename" class="text-muted"></p>
                    <img id="illustration_fix_image" src="" alt="Illustration Fix" class="img-fluid" />
                </div>
                <div class="mb-3 text-center">
                    <label class="form-label">Illustration Move</label>
                    <p id="illustration_move_filename" class="text-muted"></p>
                    <img id="illustration_move_image" src="" alt="Illustration Move" class="img-fluid" />
                </div>
                <div class="mb-3 text-center">
                    <label class="form-label">Illustration Core</label>
                    <p id="illustration_core_filename" class="text-muted"></p>
                    <img id="illustration_core_image" src="" alt="Illustration Core" class="img-fluid" />
                </div>
            </div>
            <div class="text-end">
                <button type="button" class="btn btn-transparent-danger mx-4 my-3" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Menangani klik pada tautan image-view
    $(document).on('click', '.image-view', function (e) {
        e.preventDefault();

        const illustrationFilenames = $(this).data('illustration-filename') || {};
        const illustrationFix = illustrationFilenames.illustration_fix || '';
        const illustrationMove = illustrationFilenames.illustration_move || '';
        const illustrationCore = illustrationFilenames.illustration_core || '';

        // Mengatur src gambar di modal
        $('#illustration_fix_image').attr('src', illustrationFix ? `{{ asset('illustrations/') }}/${illustrationFix}` : `{{ asset('icons/light/add-image.svg') }}`);
        $('#illustration_move_image').attr('src', illustrationMove ? `{{ asset('illustrations/') }}/${illustrationMove}` : `{{ asset('icons/light/add-image.svg') }}`);
        $('#illustration_core_image').attr('src', illustrationCore ? `{{ asset('illustrations/') }}/${illustrationCore}` : `{{ asset('icons/light/add-image.svg') }}`);

        // Tampilkan modal
        const illustrationViewModal = new bootstrap.Modal(document.getElementById('illustrationViewModal'));
        illustrationViewModal.show();
    });
});
</script>

<!-- Modal untuk Add New Part -->
<div class="modal fade" id="addPartModal" tabindex="-1" aria-labelledby="addPartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 571px; max-width: 100%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPartModalLabel">
                    <i class="fas fa-plus me-2 text-success"></i> Add Part
                </h5>
            </div>
            <div class="modal-body" style="padding: 15px; display: flex; justify-content: center;">
                <form action="{{ route('parts.store') }}" method="POST" enctype="multipart/form-data" style="max-width: 500px; width: 100%; margin-top: 30px;">
                    @csrf
                    <div class="mb-3">
                        <label for="part_name" class="form-label">Part Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="part_name" name="part_name" required style="font-style: italic; color: #929292;">
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
                            <input type="text" class="form-control" id="part_code" name="part_code" required style="font-style: italic; color: #929292;">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-9">
                            <label for="part_number" class="form-label">Part Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="part_number" name="part_number" value="{{ $nextPartNumber }}" readonly style="font-style: italic; color: #929292;">
                        </div>
                        <div class="col-md-3">
                            <label for="capacity" class="form-label">Qty Carts <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="capacity" name="capacity" required style="font-style: italic; color: #929292;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image <span class="text-danger">*</span></label>
                        <div class="d-flex justify-content-between">
                            <div class="text-center">
                                <div class="card" style="width: 160px;">
                                    <div class="card-header text-white small" style="background-color: #2F3349;">
                                        Illustration Fix
                                    </div>
                                    <label for="illustration_fix" class="btn d-flex flex-column align-items-center justify-content-center no-rounded-top p-0" style="width: 100%; height: 150px; border-top: none; border: 1px solid #C2C2C2; border-radius: 0;">
                                        <img src="{{ asset('icons/light/add-image.svg') }}" alt="Add Illustration Fix" class="img-fluid" id="illustration_fix_preview" />
                                    </label>
                                    <input type="file" name="illustration_fix" id="illustration_fix" class="d-none" accept="image/*" onchange="previewImage(event, 'illustration_fix_preview')" required>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="card" style="width: 160px;">
                                    <div class="card-header text-white small" style="background-color: #2F3349;">
                                        Illustration Move
                                    </div>
                                    <label for="illustration_move" class="btn d-flex flex-column align-items-center justify-content-center no-rounded-top p-0" style="width: 100%; height: 150px; border-top: none; border: 1px solid #C2C2C2; border-radius: 0;">
                                        <img src="{{ asset('icons/light/add-image.svg') }}" alt="Add Illustration Move" class="img-fluid" id="illustration_move_preview" />
                                    </label>
                                    <input type="file" name="illustration_move" id="illustration_move" class="d-none" accept="image/*" onchange="previewImage(event, 'illustration_move_preview')">
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="card" style="width: 160px;">
                                    <div class="card-header text-white small" style="background-color: #2F3349;">
                                        Illustration Core
                                    </div>
                                    <label for="illustration_core" class="btn d-flex flex-column align-items-center justify-content-center no-rounded-top p-0" style="width: 100%; height: 150px; border-top: none; border: 1px solid #C2C2C2; border-radius: 0;">
                                        <img src="{{ asset('icons/light/add-image.svg') }}" alt="Add Illustration Core" class="img-fluid" id="illustration_core_preview" />
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
    <div class="modal-dialog modal-dialog-centered" style="width: 571px; max-width: 100%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPartModalLabel">
                    <i class="fas fa-edit me-2 text-info"></i> Edit Part
                </h5>
            </div>
            <div class="modal-body" style="padding: 15px; display: flex; justify-content: center;">
                <div class="mb-5">
                    <span id="last_update_time_part" 
                        style="opacity: 0.7; position: absolute; top: 10px; right: 33px; font-style: italic; font-size: 0.8rem;"></span>
                </div>
                <form id="editPartForm" action="" method="POST" enctype="multipart/form-data" style="max-width: 500px; width: 100%; margin-top: 30px">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_part_name" class="form-label">Part Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_part_name" name="part_name" required style="font-style: italic; color: #929292;">
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
                            <input type="text" class="form-control" id="edit_part_code" name="part_code" required style="font-style: italic; color: #929292;">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-9">
                            <label for="edit_part_number" class="form-label">Part Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_part_number" name="part_number" readonly style="font-style: italic; color: #929292;">
                        </div>
                        <div class="col-md-3">
                            <label for="edit_capacity" class="form-label">Qty Carts <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_capacity" name="capacity" required style="font-style: italic; color: #929292;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image <span class="text-danger">*</span></label>
                        <div class="d-flex justify-content-between">
                            <!-- Illustration Fix -->
                            <div class="text-center">
                                <div class="card" style="width: 160px;">
                                    <div class="card-header text-white small" style="background-color: #2F3349;">
                                        Illustration Fix
                                    </div>
                                    <label for="edit_illustration_fix" class="btn d-flex flex-column align-items-center justify-content-center no-rounded-top p-0" style="width: 100%; height: 150px; border-top: none; border: 1px solid #C2C2C2; border-radius: 0;">
                                        @if($part->illustration_fix && file_exists(public_path('illustrations/' . $part->illustration_fix)))
                                            <!-- Gambar default -->
                                            <img src="{{ asset('icons/light/add-image.svg') }}" 
                                                alt="Add Illustration Fix" 
                                                class="img-fluid img-default" 
                                                id="edit_illustration_fix_default" />
                                        @else
                                            <!-- Gambar dari database -->
                                            <img src="{{ asset('illustrations/' . $part->illustration_fix) }}" 
                                                alt="Illustration Fix" 
                                                class="img-fluid" 
                                                id="edit_illustration_fix_preview" />
                                        @endif
                                    </label>
                                    <input type="file" name="illustration_fix" id="edit_illustration_fix" class="d-none" accept="image/*" onchange="previewImage(event, 'edit_illustration_fix_preview')">
                                </div>
                            </div>

                            <!-- Illustration Move -->
                            <div class="text-center">
                                <div class="card" style="width: 160px;">
                                    <div class="card-header text-white small" style="background-color: #2F3349;">
                                        Illustration Move
                                    </div>
                                    <label for="edit_illustration_move" class="btn d-flex flex-column align-items-center justify-content-center no-rounded-top p-0" style="width: 100%; height: 150px; border-top: none; border: 1px solid #C2C2C2; border-radius: 0;">
                                        @if($part->illustration_move && file_exists(public_path('illustrations/' . $part->illustration_move)))
                                            <!-- Gambar default -->
                                            <img src="{{ asset('icons/light/add-image.svg') }}" 
                                                alt="Add Illustration Move" 
                                                class="img-fluid img-default" 
                                                id="edit_illustration_move_default" />
                                        @else
                                            <!-- Gambar dari database -->
                                            <img src="{{ asset('illustrations/' . $part->illustration_move) }}" 
                                                alt="Illustration Move" 
                                                class="img-fluid" 
                                                id="edit_illustration_move_preview" />
                                        @endif
                                    </label>
                                    <input type="file" name="illustration_move" id="edit_illustration_move" class="d-none" accept="image/*" onchange="previewImage(event, 'edit_illustration_move_preview')">
                                </div>
                            </div>

                            <!-- Illustration Core -->
                            <div class="text-center">
                                <div class="card" style="width: 160px;">
                                    <div class="card-header text-white small" style="background-color: #2F3349;">
                                        Illustration Core
                                    </div>
                                    <label for="edit_illustration_core" class="btn d-flex flex-column align-items-center justify-content-center no-rounded-top p-0" style="width: 100%; height: 150px; border-top: none; border: 1px solid #C2C2C2; border-radius: 0;">
                                        @if($part->illustration_core && file_exists(public_path('illustrations/' . $part->illustration_core)))
                                            <!-- Gambar default -->
                                            <img src="{{ asset('icons/light/add-image.svg') }}" 
                                                alt="Add Illustration Core" 
                                                class="img-fluid img-default" 
                                                id="edit_illustration_core_default" />
                                        @else
                                            <!-- Gambar dari database -->
                                            <img src="{{ asset('illustrations/' . $part->illustration_core) }}" 
                                                alt="Illustration Core" 
                                                class="img-fluid" 
                                                id="edit_illustration_core_preview" />
                                        @endif
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
    <div class="modal-dialog modal-dialog-centered" style="width: 514px; max-width: 100%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePartModalLabel">
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
                        <td colspan="9" class="text-center">Tidak ada data</td>
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
                                <a href="#" class="text-dark image-view" 
                                   data-id="${part.id}"
                                   data-model-id="${part.model ? part.model.id : ''}"
                                   data-illustration-filename="${part.image_filename || ''}">
                                    <img src="{{ asset('icons/image-view.png') }}" alt="Logo" class="mx-2" width="25">
                                </a>
                            </td>
                            <td>
                                <span class="badge ${part.is_active ? 'badge-active' : 'badge-inactive'}">
                                    ${part.is_active ? 'Active' : 'Inactive'}
                                </span>
                            </td>
                            <td>
                                <a href="#" class="text-dark btn-edit" 
                                   data-id="${part.id}"
                                   data-name="${part.part_name || 'Tidak ada data'}"
                                   data-part-number="${part.part_number || ''}"
                                   data-part-code="${part.part_code || ''}" 
                                   data-capacity="${part.capacity_in_cart || ''}" 
                                   data-model-id="${part.model_id || ''}"
                                   data-illustration-filename="${part.image_filename || ''}" 
                                   data-last-update="${part.updated_at ? (new Date(part.updated_at)).toLocaleString('en-GB', { 
                                            day: '2-digit', 
                                            month: 'long', 
                                            year: 'numeric', 
                                            hour: '2-digit', 
                                            minute: '2-digit', 
                                            second: '2-digit', 
                                            hour12: false 
                                        }).replace(' at ', ' ') : 'No data available'}"
                                   ${part.is_active ? '' : 'disabled'} 
                                   style="${part.is_active ? '' : 'pointer-events: none; opacity: 0.5;'}">
                                    <i class="fas fa-edit" style="color: #706E7A;"></i>
                                </a>
                                <button type="button" class="btn btn-link text-dark btn-delete" 
                                        style="border: none; background: none;"
                                        data-id="${part.id}" 
                                        data-bs-toggle="modal"
                                        data-bs-target="#deletePartModal"
                                        ${part.is_active ? '' : 'disabled'}>
                                    <i class="fas fa-trash-alt" style="color: #706E7A;"></i>
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
