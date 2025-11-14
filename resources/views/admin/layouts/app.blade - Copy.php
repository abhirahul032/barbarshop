<!DOCTYPE html>
<html>
<head>
    <title>@yield('title') - Admin Panel</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    @stack('css')
</head>
<body>

<nav class="navbar navbar-dark bg-dark px-3">
    <a href="{{ route('admin.dashboard') }}" class="navbar-brand">Admin Panel</a>

    <a href="{{ route('admin.logout') }}" class="btn btn-danger btn-sm">Logout</a>
</nav>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-md-2 bg-light vh-100 border-end p-0">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="list-group-item"><a href="{{ route('admin.store.index') }}">Stores</a></li>
                <li class="list-group-item"><a href="{{ route('admin.package.index') }}">Packages</a></li>
            </ul>
        </div>

        <!-- Content -->
        <div class="col-md-10 p-4">
            @yield('content')
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('js')

</body>
</html>
