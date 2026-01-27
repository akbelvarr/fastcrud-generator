<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AVW Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background: #f4f7fe; overflow-x: hidden; }
        /* Sidebar Tetap di Kiri */
        .sidebar { 
            width: 260px; 
            height: 100vh; 
            position: fixed; 
            left: 0; 
            top: 0; 
            background: #0d6efd; 
            color: white; 
            z-index: 1000;
        }
        /* Konten Bergeser ke Kanan */
        .main-content { 
            margin-left: 260px; 
            padding: 40px; 
            min-height: 100vh;
        }
        .sidebar a { color: rgba(255,255,255,0.8); text-decoration: none; padding: 12px 20px; display: block; }
        .sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,0.15); color: white; border-left: 4px solid white; }
    </style>
</head>
<body>

    <div class="sidebar shadow">
        <div class="p-4 text-center border-bottom border-white border-opacity-25">
            <h4 class="fw-bold m-0 text-white">AVW <span class="fw-light">Store</span></h4>
        </div>
        <nav class="mt-3">
            <a href="/generator"><i class="bi bi-cpu me-2"></i> CRUD Generator</a>
            <div class="px-3 py-2 small text-uppercase opacity-50 fw-bold mt-3">Modul Tergenerate</div>
            </nav>
    </div>

    <main class="main-content">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>
</html>