<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Visual CRUD Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">CRUD Generator Visual</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('generator.process') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama Model (Contoh: Product)</label>
                                <input type="text" name="model_name" class="form-control" placeholder="Masukkan satu kata..." required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Daftar Kolom (Fields)</label>
                                <div id="field-wrapper">
                                    <div class="row mb-2 field-group">
                                        <div class="col-md-5">
                                            <input type="text" name="field_names[]" class="form-control" placeholder="Nama Kolom (ex: harga)" required>
                                        </div>
                                        <div class="col-md-5">
                                            <select name="field_types[]" class="form-control">
                                                <option value="string">String (Teks Pendek)</option>
                                                <option value="text">Text (Teks Panjang)</option>
                                                <option value="integer">Integer (Angka)</option>
                                                <option value="boolean">Boolean (True/False)</option>
                                                <option value="date">Date (Tanggal)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger btn-remove">Hapus</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" id="add-field" class="btn btn-secondary btn-sm mt-2">+ Tambah Kolom</button>
                            </div>

                            <script>
                                document.getElementById('add-field').addEventListener('click', function() {
                                    let wrapper = document.getElementById('field-wrapper');
                                    let newField = document.querySelector('.field-group').cloneNode(true);
                                    newField.querySelector('input').value = '';
                                    wrapper.appendChild(newField);
                                });

                                document.addEventListener('click', function(e) {
                                    if (e.target.classList.contains('btn-remove')) {
                                        let groups = document.querySelectorAll('.field-group');
                                        if (groups.length > 1) {
                                            e.target.closest('.field-group').remove();
                                        }
                                    }
                                });
                            </script>
                            <button type="submit" class="btn btn-primary w-100">Gass Generate!</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>