<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Matrix Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f4f7fa; 
            color: #1a202c; 
            padding-top: 100px; /* Space for fixed navbar */
        }

        /* --- Luxury Navbar --- */
        .titan-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 15px 0;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 800;
            letter-spacing: -1px;
            font-size: 1.5rem;
            color: #0f172a !important;
        }

        .nav-link {
            font-weight: 600;
            color: #64748b !important;
            margin: 0 10px;
            font-size: 0.9rem;
            transition: 0.2s;
        }

        .nav-link:hover, .nav-link.active {
            color: #4f46e5 !important;
        }

        /* Custom User Dropdown in Nav */
        .nav-user-dropdown {
            border-radius: 20px;
            border: none;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 10px;
            margin-top: 15px;
        }

        .dropdown-item {
            border-radius: 12px;
            padding: 10px 15px;
            font-weight: 600;
            font-size: 0.85rem;
            color: #475569;
        }

        .dropdown-item:hover {
            background-color: #f8fafc;
            color: #4f46e5;
        }

        .dropdown-item.text-danger:hover {
            background-color: #fef2f2;
            color: #ef4444;
        }

        /* --- Original Matrix Styling --- */
        .titan-container { max-width: 1300px; margin: 0 auto; padding: 0 20px; }
        .titan-header { margin-bottom: 50px; border-left: 6px solid #4f46e5; padding-left: 25px; }
        .titan-title { font-weight: 800; letter-spacing: -1.5px; font-size: 2.8rem; color: #0f172a; }
        .titan-subtitle { font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 2px; font-size: 0.75rem; }

        .btn-deploy { 
            background: #0f172a; color: white; border-radius: 16px; padding: 14px 28px; 
            font-weight: 700; border: none; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.15);
        }
        .btn-deploy:hover { background: #4f46e5; transform: translateY(-3px); color: white; box-shadow: 0 15px 30px rgba(79, 70, 229, 0.3); }

        .user-card { 
            background: white; border: 1px solid rgba(0,0,0,0.04); border-radius: 24px; 
            padding: 30px; margin-bottom: 20px; transition: all 0.4s ease; 
            display: flex; align-items: center; position: relative; overflow: hidden;
        }
        .user-card:hover { transform: scale(1.01); border-color: #4f46e5; box-shadow: 0 30px 60px rgba(0,0,0,0.05); }
        .user-card::after { 
            content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; 
            background: #4f46e5; opacity: 0; transition: 0.3s; 
        }
        .user-card:hover::after { opacity: 1; }

        .avatar-wrapper { position: relative; margin-right: 25px; }
        .avatar-box { 
            width: 70px; height: 70px; border-radius: 20px; background: #f8fafc; 
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 1.5rem; color: #4f46e5; border: 2px solid #f1f5f9;
        }
        .status-dot { 
            position: absolute; bottom: -2px; right: -2px; width: 18px; height: 18px; 
            background: #10b981; border: 4px solid white; border-radius: 50%; 
        }

        .u-name { font-weight: 800; font-size: 1.35rem; color: #0f172a; margin-bottom: 2px; }
        .u-email { font-weight: 500; color: #94a3b8; font-size: 0.9rem; }
        .u-badge { 
            background: #f1f5f9; color: #475569; font-weight: 700; 
            text-transform: uppercase; font-size: 0.65rem; padding: 6px 14px; border-radius: 10px;
        }

        .btn-action { 
            width: 45px; height: 45px; border-radius: 14px; border: 1px solid #f1f5f9;
            display: inline-flex; align-items: center; justify-content: center; 
            background: white; color: #94a3b8; transition: all 0.2s;
        }
        .btn-edit:hover { background: #4f46e5; color: white; border-color: #4f46e5; }
        .btn-delete:hover { background: #ef4444; color: white; border-color: #ef4444; }

        .modal-content { border-radius: 32px; border: none; padding: 20px; box-shadow: 0 50px 100px rgba(0,0,0,0.2); }
        .form-control { 
            border-radius: 16px; padding: 14px 20px; background: #f8fafc; border: 2px solid #f8fafc;
            font-weight: 600;
        }
        .form-control:focus { background: white; border-color: #4f46e5; box-shadow: none; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg titan-nav fixed-top">
    <div class="container-fluid titan-container">
        <a class="navbar-brand" href="#">
            <i class="bi bi-cpu-fill text-primary me-2"></i>Matrix<span style="color:#4f46e5">.</span>
        </a>
        
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <i class="bi bi-list fs-2"></i>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#"><i class="bi bi-house-door me-1"></i> Home</a>
                </li>
                <li class="nav-item">
                    <!-- <a class="nav-link" href="#"><i class="bi bi-box-seam me-1"></i> Products</a> -->
                     <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
    <i class="bi bi-box-seam me-1"></i> Products
</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-shield-check me-1"></i> Security</a>
                </li>
            </ul>
            
            <div class="dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                    <div class="avatar-box" style="width: 35px; height: 35px; font-size: 0.8rem; border-radius: 10px; margin-right: 10px;">AD</div>
                    <span class="fw-bold text-dark d-none d-sm-inline">Admin</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end nav-user-dropdown">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i> Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout Protocol
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="titan-container">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-end titan-header">
        <div>
            <span class="titan-subtitle">Core Infrastructure</span>
            <h1 class="titan-title">User <span style="color:#4f46e5">Matrix.</span></h1>
        </div>
        <button class="btn btn-deploy" data-bs-toggle="modal" data-bs-target="#userModal" onclick="resetForm()">
            <i class="bi bi-plus-lg me-2"></i> Deploy User
        </button>
    </div>

    @if(session('success'))
    <div class="alert alert-success border-0 shadow-sm rounded-4 p-3 animate__animated animate__fadeInDown">
        <i class="bi bi-check-circle-fill me-2"></i> <strong>Protocol Success:</strong> {{ session('success') }}
    </div>
    @endif

    <div class="row g-0">
        @forelse($users as $user)
        <div class="col-12 user-card">
            <div class="avatar-wrapper">
                <div class="avatar-box">{{ substr($user->name, 0, 1) }}</div>
                <div class="status-dot"></div>
            </div>
            
            <div class="flex-grow-1">
                <div class="u-name">{{ $user->name }}</div>
                <div class="u-email">{{ $user->email }}</div>
            </div>

            <div class="d-none d-lg-block mx-5 text-center">
                <span class="u-badge">Verified Member</span>
                <div class="mt-2 text-muted small fw-bold">Joined: {{ $user->created_at->format('M d, Y') }}</div>
            </div>

            <div class="d-flex gap-2">
                <button class="btn-action btn-edit" onclick="openEditModal('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}')">
                    <i class="bi bi-pencil-square"></i>
                </button>
                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-action btn-delete" onclick="return confirm('Archive user?')">
                        <i class="bi bi-trash3-fill"></i>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <h4 class="text-muted fw-light">The directory is currently empty.</h4>
        </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>

<div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h3 class="fw-bolder" id="modalTitle">Deploy Entity</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="userForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="modal-body">
                    <div class="mb-4">
                        <label class="form-label small fw-black text-uppercase tracking-wider">Name</label>
                        <input type="text" name="name" id="userName" class="form-control" required placeholder="Real Name">
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-black text-uppercase tracking-wider">Email</label>
                        <input type="email" name="email" id="userEmail" class="form-control" required placeholder="name@company.com">
                    </div>
                    <div class="mb-3" id="passWrapper">
                        <label class="form-label small fw-black text-uppercase tracking-wider">Password</label>
                        <input type="password" name="password" id="userPass" class="form-control" placeholder="Create secret">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-4 px-4 py-3 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-deploy px-5 py-3">Confirm Protocol</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const modal = new bootstrap.Modal(document.getElementById('userModal'));
    
    function resetForm() {
        document.getElementById('modalTitle').innerText = "Deploy Entity";
        document.getElementById('formMethod').value = "POST";
        document.getElementById('userForm').action = "{{ route('users.store') }}";
        document.getElementById('passWrapper').style.display = 'block';
        document.getElementById('userForm').reset();
    }

    function openEditModal(id, name, email) {
        document.getElementById('modalTitle').innerText = "Modify Entity";
        document.getElementById('formMethod').value = "PUT";
        document.getElementById('userForm').action = "/users/" + id;
        document.getElementById('passWrapper').style.display = 'none';
        document.getElementById('userName').value = name;
        document.getElementById('userEmail').value = email;
        modal.show();
    }
</script>

</body>
</html>