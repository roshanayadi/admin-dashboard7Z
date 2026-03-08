<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - DAS Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        :root {
            --primary: #059669;
            --primary-dark: #047857;
            --primary-light: #d1fae5;
            --secondary: #1e40af;
            --accent: #f59e0b;
            --danger: #dc2626;
            --success: #16a34a;
            --warning: #ea580c;
            --dark: #1f2937;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --sidebar-width: 260px;
            --header-height: 64px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--gray-50);
            color: var(--dark);
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0; top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #064e3b 0%, #065f46 50%, #047857 100%);
            color: white;
            z-index: 100;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }
        .sidebar-header {
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-header .logo-icon {
            width: 40px; height: 40px;
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
        }
        .sidebar-header h2 {
            font-size: 18px;
            font-weight: 700;
        }
        .sidebar-header small {
            font-size: 11px;
            opacity: 0.7;
        }
        .sidebar-close {
            display: none;
            background: none; border: none; color: white;
            font-size: 20px; cursor: pointer;
            margin-left: auto;
        }

        .nav-list {
            list-style: none;
            padding: 15px 12px;
        }
        .nav-group-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255,255,255,0.4);
            padding: 20px 12px 8px;
            font-weight: 600;
        }
        .nav-item a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 16px;
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            margin-bottom: 2px;
        }
        .nav-item a:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        .nav-item a.active {
            background: rgba(255,255,255,0.2);
            color: white;
            font-weight: 600;
        }
        .nav-item a i { width: 20px; text-align: center; font-size: 15px; }
        .nav-badge {
            margin-left: auto;
            background: var(--accent);
            color: #000;
            font-size: 11px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 10px;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        /* Top Header */
        .top-header {
            background: white;
            height: var(--header-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            border-bottom: 1px solid var(--gray-200);
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .top-header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .mobile-toggle {
            display: none;
            background: none; border: none;
            font-size: 20px; cursor: pointer;
            color: var(--gray-600);
        }
        .page-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--dark);
        }
        .top-header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .header-btn {
            background: none; border: none;
            color: var(--gray-500);
            font-size: 18px;
            cursor: pointer;
            position: relative;
            padding: 8px;
            border-radius: 8px;
            transition: 0.2s;
        }
        .header-btn:hover { background: var(--gray-100); color: var(--primary); }
        .header-btn .badge {
            position: absolute;
            top: 2px; right: 2px;
            width: 18px; height: 18px;
            background: var(--danger);
            color: white;
            font-size: 10px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
        }
        .user-menu {
            display: flex; align-items: center; gap: 10px;
            cursor: pointer;
            padding: 6px 12px;
            border-radius: 8px;
            transition: 0.2s;
        }
        .user-menu:hover { background: var(--gray-100); }
        .user-avatar {
            width: 36px; height: 36px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
            font-size: 14px;
        }
        .user-info { text-align: right; }
        .user-info .name { font-size: 13px; font-weight: 600; }
        .user-info .role { font-size: 11px; color: var(--gray-400); text-transform: capitalize; }

        /* Content Area */
        .content-area {
            padding: 24px;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid var(--gray-200);
            transition: all 0.2s;
        }
        .stat-card:hover {
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transform: translateY(-2px);
        }
        .stat-card .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }
        .stat-card .stat-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
        }
        .stat-icon.green { background: var(--primary-light); color: var(--primary); }
        .stat-icon.blue { background: #dbeafe; color: var(--secondary); }
        .stat-icon.yellow { background: #fef3c7; color: var(--accent); }
        .stat-icon.red { background: #fee2e2; color: var(--danger); }
        .stat-icon.purple { background: #ede9fe; color: #7c3aed; }

        .stat-card .stat-value {
            font-size: 28px;
            font-weight: 800;
            color: var(--dark);
        }
        .stat-card .stat-label {
            font-size: 13px;
            color: var(--gray-500);
            margin-top: 4px;
        }

        /* Card */
        .card {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--gray-200);
            margin-bottom: 24px;
        }
        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card-header h3 {
            font-size: 16px;
            font-weight: 700;
        }
        .card-body { padding: 24px; }

        /* Table */
        .table-responsive { overflow-x: auto; }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th {
            background: var(--gray-50);
            padding: 12px 16px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--gray-500);
            border-bottom: 1px solid var(--gray-200);
        }
        table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--gray-100);
            font-size: 14px;
        }
        table tr:hover td { background: var(--gray-50); }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-success { background: #dcfce7; color: #16a34a; }
        .badge-warning { background: #fef3c7; color: #d97706; }
        .badge-danger { background: #fee2e2; color: #dc2626; }
        .badge-info { background: #dbeafe; color: #2563eb; }
        .badge-secondary { background: var(--gray-100); color: var(--gray-600); }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            text-decoration: none;
        }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-secondary { background: var(--gray-100); color: var(--gray-700); border: 1px solid var(--gray-300); }
        .btn-secondary:hover { background: var(--gray-200); }
        .btn-danger { background: var(--danger); color: white; }
        .btn-danger:hover { background: #b91c1c; }
        .btn-warning { background: var(--accent); color: white; }
        .btn-sm { padding: 6px 12px; font-size: 12px; }
        .btn-icon {
            width: 32px; height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
        }

        /* Forms */
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 6px;
        }
        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: border-color 0.2s;
            background: white;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        }
        textarea.form-control { resize: vertical; min-height: 100px; }
        select.form-control { cursor: pointer; }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        /* Alert */
        .alert {
            padding: 14px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .alert-warning { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }

        /* Pagination */
        .pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 20px 0;
        }
        .pagination a, .pagination span {
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 13px;
            text-decoration: none;
            border: 1px solid var(--gray-200);
            color: var(--gray-600);
        }
        .pagination .active span {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        .pagination a:hover { background: var(--gray-100); }

        /* Search & Filters */
        .filters-bar {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .search-input {
            flex: 1;
            min-width: 250px;
            position: relative;
        }
        .search-input input {
            width: 100%;
            padding: 10px 14px 10px 40px;
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            font-size: 14px;
        }
        .search-input input:focus { outline: none; border-color: var(--primary); }
        .search-input i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
        }

        /* Activity list */
        .activity-list { list-style: none; }
        .activity-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid var(--gray-100);
        }
        .activity-item:last-child { border-bottom: none; }
        .activity-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            margin-top: 6px;
            flex-shrink: 0;
        }
        .activity-dot.green { background: var(--success); }
        .activity-dot.blue { background: var(--secondary); }
        .activity-dot.yellow { background: var(--accent); }
        .activity-dot.red { background: var(--danger); }
        .activity-text { font-size: 13px; color: var(--gray-600); }
        .activity-time { font-size: 11px; color: var(--gray-400); margin-top: 2px; }

        /* Two-column layout */
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 40px;
            color: var(--gray-400);
        }
        .empty-state i { font-size: 48px; margin-bottom: 16px; }
        .empty-state p { font-size: 14px; }

        /* Mobile overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 99;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .grid-2 { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .sidebar-close { display: block; }
            .sidebar-overlay.open { display: block; }
            .mobile-toggle { display: block; }
            .main-content { margin-left: 0; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .content-area { padding: 16px; }
            .user-info { display: none; }
        }
        @media (max-width: 480px) {
            .stats-grid { grid-template-columns: 1fr; }
        }

        /* Image preview */
        .img-preview {
            width: 60px; height: 60px;
            border-radius: 8px;
            object-fit: cover;
        }

        /* Delete confirm */
        .confirm-delete {
            display: inline;
        }
        .confirm-delete form {
            display: inline;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon"><i class="fas fa-leaf"></i></div>
            <div>
                <h2>DAS Admin</h2>
                <small>Agriculture System</small>
            </div>
            <button class="sidebar-close" onclick="toggleSidebar()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <ul class="nav-list">
            <li class="nav-group-title">Main</li>
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-group-title">Content</li>
            <li class="nav-item">
                <a href="{{ route('admin.blogs.index') }}" class="{{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
                    <i class="fas fa-blog"></i> <span>Blogs</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.gallery.index') }}" class="{{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                    <i class="fas fa-images"></i> <span>Gallery</span>
                </a>
            </li>

            <li class="nav-group-title">People</li>
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> <span>Users</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.admins.index') }}" class="{{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                    <i class="fas fa-user-shield"></i> <span>Admins</span>
                </a>
            </li>

            <li class="nav-group-title">Communication</li>
            <li class="nav-item">
                <a href="{{ route('admin.contacts.index') }}" class="{{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i> <span>Contacts</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.feedback.index') }}" class="{{ request()->routeIs('admin.feedback.*') ? 'active' : '' }}">
                    <i class="fas fa-star"></i> <span>Feedback</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.sms-email.index') }}" class="{{ request()->routeIs('admin.sms-email.*') ? 'active' : '' }}">
                    <i class="fas fa-paper-plane"></i> <span>SMS & Email</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.notifications.index') }}" class="{{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
                    <i class="fas fa-bell"></i> <span>Notifications</span>
                </a>
            </li>

            <li class="nav-group-title">System</li>
            <li class="nav-item">
                <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i> <span>Settings</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <header class="top-header">
            <div class="top-header-left">
                <button class="mobile-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title">@yield('title', 'Dashboard')</h1>
            </div>
            <div class="top-header-right">
                <a href="{{ route('admin.notifications.index') }}" class="header-btn">
                    <i class="fas fa-bell"></i>
                    @if(($unreadCount = \App\Models\Notification::unread()->count()) > 0)
                        <span class="badge">{{ $unreadCount }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.profile') }}" class="user-menu">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->guard('admin')->user()->full_name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="user-info">
                        <div class="name">{{ auth()->guard('admin')->user()->full_name ?? 'Admin' }}</div>
                        <div class="role">{{ auth()->guard('admin')->user()->role ?? 'admin' }}</div>
                    </div>
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="header-btn" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </header>

        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('open');
        }

        // Auto-dismiss alerts after 5s
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });
    </script>
    @stack('scripts')
</body>
</html>
