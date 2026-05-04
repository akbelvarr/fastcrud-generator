<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastCRUD</title>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body { 
            background: #f8fafc;
            font-family: 'Inter', sans-serif;
            color: #334155;
        }

        .main-content { 
            padding: 3rem;
            max-width: 1100px;
            margin: auto;
            min-height: 100vh;
        }

        /* Card Style */
        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 
                        0 2px 4px -1px rgba(0,0,0,0.03);
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid #e2e8f0;
            border-top-left-radius: 0.75rem !important;
            border-top-right-radius: 0.75rem !important;
            padding: 1.25rem 1.5rem;
        }

        /* Button */
        .btn {
            font-weight: 500;
            border-radius: 0.375rem;
            padding: 0.5rem 1rem;
            transition: all 0.2s;
        }

        /* Input */
        .form-control, .form-select {
            border-color: #cbd5e1;
            border-radius: 0.375rem;
            padding: 0.5rem 0.75rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
        }

        /* FastCRUD Header */
        .app-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .app-header h1 {
            font-weight: 700;
            color: #2563eb;
        }

        .app-header p {
            color: #64748b;
            margin-bottom: 0;
        }
    </style>
</head>

<body>

<main class="main-content">

    <!-- FastCRUD Branding -->
    <div class="app-header">
        <h1>FastCRUD</h1>
        <p>Laravel CRUD Module Generator</p>
    </div>

    <!-- Page Content -->
    @yield('content')

</main>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@stack('scripts')

</body>
</html>