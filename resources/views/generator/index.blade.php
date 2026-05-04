@extends('layouts.master')

@section('content')
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">CRUD Module Configurator</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form id="crudForm" action="{{ route('generator.process') }}" method="POST">
                @csrf
                
                <!-- Seksi 1: Detail Model -->
                <div class="mb-5">
                    <h5 class="fw-bold mb-3 d-flex align-items-center"><i class="bi bi-box me-2 text-primary"></i> Detail Model</h5>
                    <div class="bg-white p-4 rounded shadow-sm border border-light">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary small">Nama Model</label>
                            <input type="text" id="model_name" name="model_name" class="form-control" placeholder="Contoh: Product (Satu kata, wajib PascalCase)" required>
                            <div class="invalid-feedback" id="model-error">Nama model wajib diisi, satu kata, dan tidak boleh diawali angka!</div>
                        </div>
                        
                        <div class="mt-4 pt-3 border-top">
                            <label class="form-label fw-semibold text-secondary small mb-3">Fitur Tambahan (Opsional)</label>
                            <div class="d-flex gap-4">
                                <div class="form-check form-switch cursor-pointer">
                                    <input class="form-check-input" type="checkbox" role="switch" name="timestamps" id="timestamps" value="1" checked>
                                    <label class="form-check-label user-select-none" for="timestamps">
                                        Enable Timestamps 
                                        <i class="bi bi-info-circle text-muted ms-1" data-bs-toggle="tooltip" title="Akan menambahkan created_at dan updated_at pada tabel"></i>
                                    </label>
                                </div>
                                <div class="form-check form-switch cursor-pointer">
                                    <input class="form-check-input" type="checkbox" role="switch" name="softdeletes" id="softdeletes" value="1">
                                    <label class="form-check-label user-select-none" for="softdeletes">
                                        Enable SoftDeletes
                                        <i class="bi bi-info-circle text-muted ms-1" data-bs-toggle="tooltip" title="Data tidak benar-benar dihapus secara permanen (is_deleted)"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Seksi 2: Konfigurasi Field -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0"><i class="bi bi-list-columns me-2 text-primary"></i> Konfigurasi Field</h5>
                        <button type="button" id="add-field" class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1 shadow-sm transition">
                            <i class="bi bi-plus-circle"></i> Tambah Field
                        </button>
                    </div>
                    
                    <div class="bg-white p-4 rounded shadow-sm border border-light" id="field-wrapper">
                        <div class="row mb-3 field-group align-items-center p-2 rounded transition hover-bg-light">
                            <div class="col-md-5">
                                <label class="form-label text-secondary small fw-semibold">Nama Kolom</label>
                                <input type="text" name="field_names[]" class="form-control field-input" placeholder="contoh_kolom" required>
                                <div class="invalid-feedback">Nama kolom wajib snake_case!</div>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label text-secondary small fw-semibold">Tipe Data</label>
                                <select name="field_types[]" class="form-select">
                                    <option value="string">String (Teks Pendek)</option>
                                    <option value="text">Text (Teks Panjang)</option>
                                    <option value="integer">Integer (Angka Bulat)</option>
                                    <option value="bigInteger">Big Integer (Angka Sangat Besar)</option>
                                    <option value="decimal">Decimal (Angka Desimal / Uang)</option>
                                    <option value="float">Float (Pecahan Float)</option>
                                    <option value="double">Double (Pecahan Presisi Ganda)</option>
                                    <option value="boolean">Boolean (True/False - Ya/Tidak)</option>
                                    <option value="date">Date (Hanya Tanggal)</option>
                                    <option value="datetime">DateTime (Tanggal & Waktu)</option>
                                    <option value="image">Image (Khusus Gambar: JPG/PNG/GIF)</option>
                                    <option value="file">File (Dokumen: PDF/DOC/TXT dll)</option>
                                </select>
                            </div>
                            <div class="col-md-2 mt-4 text-end">
                                <button type="button" class="btn btn-danger btn-sm btn-remove" disabled data-bs-toggle="tooltip" title="Hapus field ini">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Area Preview Tabel (Sembunyi by default) -->
                <div id="preview-area" class="d-none mb-4">
                    <h5 class="fw-bold mb-3 d-flex align-items-center"><i class="bi bi-eye text-primary me-2"></i> Preview Struktur Tabel</h5>
                    <div class="card shadow-sm border-light">
                        <div class="card-body p-0">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Field Name</th>
                                        <th>Data Type</th>
                                    </tr>
                                </thead>
                                <tbody id="preview-tbody">
                                    <!-- Baris preview akan diisi oleh JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3 mt-4">
                    <button type="button" id="btn-preview" class="btn btn-outline-secondary w-50 py-3 fw-bold shadow-sm transition d-flex justify-content-center align-items-center gap-2">
                        <i class="bi bi-table"></i> Preview Struktur
                    </button>
                    <button type="submit" id="btn-submit" class="btn btn-primary w-50 py-3 fw-bold shadow transition d-flex justify-content-center align-items-center gap-2">
                        <i class="bi bi-magic"></i> Generate Modul Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>

<style>
    .transition { transition: all 0.3s ease; }
    .hover-bg-light:hover { background-color: #f8fafc !important; }
    .cursor-pointer { cursor: pointer; }
    .form-switch .form-check-input { width: 2.5em; cursor: pointer; }
    .btn-primary { background-color: #3b82f6; border: none; }
    .btn-primary:hover { background-color: #2563eb; transform: translateY(-1px); }
    .btn-primary:disabled { background-color: #94a3b8; transform: none; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Init Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        const form = document.getElementById('crudForm');
        const modelInput = document.getElementById('model_name');
        const submitBtn = document.getElementById('btn-submit');
        const wrapper = document.getElementById('field-wrapper');
        const btnAdd = document.getElementById('add-field');

        // Validasi real-time form
        function validateForm() {
            let isValid = true;
            
            // Validasi Model Name
            const modelVal = modelInput.value.trim();
            const modelRegex = /^[A-Z][a-zA-Z]*$/; // PascalCase, no number at start, single word
            
            if(modelVal === '' || !modelRegex.test(modelVal)) {
                modelInput.classList.add('is-invalid');
                isValid = false;
            } else {
                modelInput.classList.remove('is-invalid');
                modelInput.classList.add('is-valid');
            }

            // Validasi Field Names
            const fieldInputs = document.querySelectorAll('.field-input');
            const fieldRegex = /^[a-z0-9_]+$/; // snake_case
            
            fieldInputs.forEach(input => {
                const val = input.value.trim();
                if(val === '' || !fieldRegex.test(val) || val.startsWith('_')) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                }
            });

            submitBtn.disabled = !isValid;
        }

        // Attach listeners
        modelInput.addEventListener('input', validateForm);
        wrapper.addEventListener('input', validateForm);

        // Tambah field baru
        btnAdd.addEventListener('click', function() {
            let groups = document.querySelectorAll('.field-group');
            let newField = groups[0].cloneNode(true);
            
            // Reset state
            let input = newField.querySelector('.field-input');
            input.value = '';
            input.classList.remove('is-valid', 'is-invalid');
            
            // Enable remove button
            let removeBtn = newField.querySelector('.btn-remove');
            removeBtn.disabled = false;
            
            // Animasi masuk (hilang dulu, lalu timbul)
            newField.style.opacity = '0';
            wrapper.appendChild(newField);
            
            setTimeout(() => {
                newField.style.opacity = '1';
                newField.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                input.focus();
                validateForm();
            }, 50);
            
            updateRemoveButtons();
        });

        // Hapus field
        wrapper.addEventListener('click', function(e) {
            let removeBtn = e.target.closest('.btn-remove');
            if (removeBtn) {
                let groups = document.querySelectorAll('.field-group');
                if (groups.length > 1) {
                    let group = removeBtn.closest('.field-group');
                    group.style.opacity = '0';
                    group.style.transform = 'scale(0.95)';
                    
                    setTimeout(() => {
                        group.remove();
                        validateForm();
                        updateRemoveButtons();
                    }, 300);
                }
            }
        });

        function updateRemoveButtons() {
            let groups = document.querySelectorAll('.field-group');
            let firstRemoveBtn = groups[0].querySelector('.btn-remove');
            if(groups.length === 1) {
                firstRemoveBtn.disabled = true;
            } else {
                firstRemoveBtn.disabled = false;
            }
        }

        // --- Logika Preview Struktur Tabel ---
        const btnPreview = document.getElementById('btn-preview');
        const previewArea = document.getElementById('preview-area');
        const previewTbody = document.getElementById('preview-tbody');

        btnPreview.addEventListener('click', function() {
            // Bersihkan tbody
            previewTbody.innerHTML = '';
            
            const fieldNames = document.querySelectorAll('input[name="field_names[]"]');
            const fieldTypes = document.querySelectorAll('select[name="field_types[]"]');
            const hasTimestamps = document.getElementById('timestamps').checked;
            const hasSoftdeletes = document.getElementById('softdeletes').checked;

            // Tambahkan ID sebagai primary key bawaan Laravel
            previewTbody.innerHTML += `
                <tr>
                    <td class="ps-4 fw-bold">id <span class="badge bg-primary ms-2" style="font-size:0.6rem">PK</span></td>
                    <td class="text-secondary">bigIncrements</td>
                </tr>
            `;

            // Loop untuk setiap field input dari user
            for (let i = 0; i < fieldNames.length; i++) {
                const name = fieldNames[i].value.trim();
                const type = fieldTypes[i].options[fieldTypes[i].selectedIndex].text;
                
                if (name) {
                    previewTbody.innerHTML += `
                        <tr>
                            <td class="ps-4 fw-semibold text-dark">${name}</td>
                            <td class="text-secondary">${type}</td>
                        </tr>
                    `;
                }
            }

            // Tambahkan bawaan timestamps
            if (hasTimestamps) {
                previewTbody.innerHTML += `
                    <tr>
                        <td class="ps-4 fw-semibold text-muted">created_at</td>
                        <td class="text-muted">timestamp</td>
                    </tr>
                    <tr>
                        <td class="ps-4 fw-semibold text-muted">updated_at</td>
                        <td class="text-muted">timestamp</td>
                    </tr>
                `;
            }

            // Tambahkan bawaan softdeletes
            if (hasSoftdeletes) {
                previewTbody.innerHTML += `
                    <tr>
                        <td class="ps-4 fw-semibold text-muted">deleted_at</td>
                        <td class="text-muted">timestamp</td>
                    </tr>
                `;
            }

            // Tampilkan area preview
            previewArea.classList.remove('d-none');
            previewArea.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });
    });
</script>
@endsection
