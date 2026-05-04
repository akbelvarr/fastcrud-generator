@extends('layouts.master')

@section('content')
<div class="card shadow">
    <div class="card-header bg-success text-white">
        <h4 class="mb-0 d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill"></i> Selesai!</h4>
    </div>
    <div class="card-body text-center py-5">
        <i class="bi bi-file-earmark-zip text-success" style="font-size: 5rem;"></i>
        <h3 class="fw-bold mt-4 text-dark">{{ $fileName }}</h3>
        <p class="text-secondary mb-4">Modul <strong>{{ $modelName }}</strong> telah berhasil di-generate secara utuh dan siap diunduh.</p>
        
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('generator.index') }}" class="btn btn-outline-secondary px-4 py-2 fw-bold transition">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('generator.download', ['fileName' => $fileName]) }}" class="btn btn-success px-5 py-2 fw-bold shadow transition btn-lg d-flex align-items-center gap-2">
                <i class="bi bi-download"></i> Unduh File ZIP Sekarang
            </a>
        </div>
        
        <div class="mt-5 text-start">
            <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-pill fw-semibold px-4" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                        <i class="bi bi-check-circle me-1"></i> Sudah Punya Proyek Laravel
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill fw-semibold px-4" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">
                        <i class="bi bi-question-circle me-1"></i> Belum Punya Proyek?
                    </button>
                </li>
            </ul>
            
            <div class="tab-content bg-light p-4 rounded border" id="pills-tabContent">
                <!-- Tab Punya Proyek -->
                <div class="tab-pane fade show active text-secondary small" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <h6 class="fw-bold text-dark"><i class="bi bi-info-circle text-primary"></i> Langkah Selanjutnya:</h6>
                    <ol class="mb-0 ps-3">
                        <li>Klik tombol <strong>Unduh File ZIP Sekarang</strong> di atas.</li>
                        <li>Ekstrak file `.zip` yang sudah diunduh ke dalam root direktori Laravel Anda.</li>
                        <li>Ikuti instruksi singkat di dalam file <code>README_CARA_PAKAI.txt</code> untuk mendaftarkan route dan migrasi.</li>
                    </ol>
                </div>

                <!-- Tab Pemula -->
                <div class="tab-pane fade text-secondary small" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <h6 class="fw-bold text-dark mb-3"><i class="bi bi-rocket-takeoff text-primary"></i> Panduan Membuat Proyek Laravel Baru (Khusus Pemula):</h6>
                    
                    <div class="mb-3">
                        <strong>Langkah 1:</strong> Buka CMD / Terminal di laptop Anda, lalu jalankan perintah ini untuk membuat folder proyek Laravel kosong:
                        <div class="bg-dark text-white p-2 rounded mt-1 font-monospace user-select-all cursor-pointer" onclick="copyToClipboard(this)">
                            composer create-project laravel/laravel my-project
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Langkah 2:</strong> Masuk ke folder yang baru dibuat:
                        <div class="bg-dark text-white p-2 rounded mt-1 font-monospace user-select-all cursor-pointer" onclick="copyToClipboard(this)">
                            cd my-project
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Langkah 3:</strong> Ekstrak file <code>.zip</code> yang diunduh dari sini, lalu <strong>Copy & Paste</strong> isinya ke dalam folder <code>my-project</code> tersebut. Timpa (replace) jika diminta.
                    </div>

                    <div class="mb-3">
                        <strong>Langkah 4:</strong> Buka file <code>routes/web.php</code> dan daftarkan route baru seperti petunjuk di <code>README_CARA_PAKAI.txt</code>. Lalu jalankan migrasi database otomatis (SQLite):
                        <div class="bg-dark text-white p-2 rounded mt-1 font-monospace user-select-all cursor-pointer" onclick="copyToClipboard(this)">
                            php artisan migrate
                        </div>
                        <small class="text-muted d-block mt-1"><em>(Ketik 'yes' jika ditanya untuk membuat database SQLite baru)</em></small>
                    </div>

                    <div>
                        <strong>Langkah 5:</strong> Jalankan server dan buka di browser!
                        <div class="bg-dark text-white p-2 rounded mt-1 font-monospace user-select-all cursor-pointer" onclick="copyToClipboard(this)">
                            php artisan serve
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .transition { transition: all 0.2s ease-in-out; }
    .btn-success { background-color: #10b981; border: none; }
    .btn-success:hover { background-color: #059669; transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3) !important; }
    .cursor-pointer { cursor: pointer; transition: background-color 0.2s; position: relative; }
    .cursor-pointer:hover { background-color: #343a40 !important; }
    .cursor-pointer::after {
        content: "Klik untuk Copy";
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.75rem;
        opacity: 0;
        transition: opacity 0.2s;
    }
    .cursor-pointer:hover::after { opacity: 0.7; }
</style>

<script>
    function copyToClipboard(element) {
        const text = element.innerText.trim();
        navigator.clipboard.writeText(text).then(() => {
            const originalHtml = element.innerHTML;
            element.innerHTML = '<i class="bi bi-check2"></i> Disalin!';
            element.classList.add('text-success');
            setTimeout(() => {
                element.innerHTML = originalHtml;
                element.classList.remove('text-success');
            }, 1000);
        });
    }
</script>
@endsection
