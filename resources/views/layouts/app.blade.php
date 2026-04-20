<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrix Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f4f7fa;
            padding-top: 90px;
        }

        .titan-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .titan-container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .btn-deploy {
            background: #0f172a;
            color: white;
            border-radius: 14px;
            padding: 12px 24px;
            font-weight: 700;
            border: none;
            transition: 0.3s;
        }

        .btn-deploy:hover {
            background: #4f46e5;
            transform: translateY(-2px);
            color: white;
        }

        .modal-content {
            border-radius: 28px;
            border: none;
            padding: 15px;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px;
            background: #f8fafc;
            border: 2px solid #f8fafc;
        }

        .form-control:focus {
            border-color: #4f46e5;
            box-shadow: none;
            background: white;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg titan-nav fixed-top">
        <div class="container-fluid titan-container">
            <a class="navbar-brand fw-bolder fs-4" href="#"><i class="bi bi-intersect text-primary me-2"></i>Matrix.</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link fw-bold px-3" href="{{ route('dashboard') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold px-3 active text-primary" href="{{ route('products.index') }}">Products</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold px-3" href="#">Orders</a></li>
                </ul>
                <div class="dropdown">
                    <button class="btn btn-light rounded-pill fw-bold dropdown-toggle" data-bs-toggle="dropdown">Admin Console</button>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-3" style="border-radius: 15px;">
                        <li><a class="dropdown-item py-2" href="#"><i class="bi bi-gear me-2"></i> Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>