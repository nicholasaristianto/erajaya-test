<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container my-3">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow rounded-3 px-4 py-2">
            <div class="container-fluid">
                <a class="navbar-brand fs-5" href="#">
                    <span class="me-2">👥</span>
                    <strong>Jumlah Karyawan</strong>
                </a>
            </div>
        </nav>
    </div>

    <main class="py-4">
        @yield('content')
    </main>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    @stack('scripts')
</body>
</html>
