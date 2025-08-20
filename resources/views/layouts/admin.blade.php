<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{--@vite(['resources/css/app.css', 'resources/js/app.js'])--}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

 <style>
    * {
    box-sizing: border-box;
}

html, body {
    margin: 0;
    padding: 0;
    height: 100%;
    width: 100%;
    font-family: 'Segoe UI', sans-serif;
    overflow: hidden; /* ngăn tràn màn hình */
}

/* Sidebar */
.main-sidebar {
    width: 250px;
    background-color: #343a40;
    color: white;
    display: flex;
    flex-direction: column;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    overflow-y: auto;
    z-index: 100;
}

/* Sidebar links */
.main-sidebar a {
    color: #c2c7d0;
    padding: 12px 20px;
    display: block;
    text-decoration: none;
}

.main-sidebar a:hover,
.main-sidebar .active {
    background-color: #007bff;
    color: white;
}

/* Wrapper (to the right of sidebar) */
.main-wrapper {
    margin-left: 250px;
    display: flex;
    flex-direction: column;
    height: 100vh;
    overflow: hidden;
    width: calc(100% - 250px);
}

/* Navbar */
.navbar {
    height: 70px;
    background: #fff;
    border-bottom: 1px solid #007bff;
    padding: 0 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-shrink: 0;
    z-index: 1000;
    position: sticky;
    top: 0;
}

/* Main content area */
.main-content {
    flex: 1;
    padding: 20px;
    overflow: auto;
    background-image: url('https://img5.thuthuatphanmem.vn/uploads/2021/12/06/hinh-nen-may-tinh-mau-tim-nhat_084501443.png');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
}

/* Footer */
.main-footer {
    height: 50px;
    background: #f8f9fa;
    text-align: center;
    line-height: 50px;
    border-top: 1px solid #ddd;
    flex-shrink: 0;
}

/* TABLE FIX */
.table-responsive {
    width: 100%;
    overflow-x: auto;
}

table {
    background-color: white;
    border-collapse: collapse;
    width: 100%;
    margin-top: 10px;
    min-width: 800px; /* tránh co bảng */
}

table th, table td {
    border: 1px solid #ccc;
    padding: 8px 12px;
    text-align: left;
    white-space: nowrap;
    vertical-align: middle;
}

table th {
    background-color: #f1f1f1;
}

/* DataTable fix */
#users-table {
    width: 100% !important;
    table-layout: auto;
}

/* Scrollbar styling */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-thumb {
    background-color: #999;
    border-radius: 10px;
} 
/* Fix Select2 bị che khuất bởi các phần tử khác */
.select2-container {
    z-index: 9999 !important;
}
.select2-dropdown {
    z-index: 99999 !important;
}

</style>
<!-- jQuery -->

</head>
<body>

    {{-- Sidebar --}}
    <aside class="main-sidebar">
        @include('admin.partials.sidebar')
    </aside>

    {{-- Wrapper --}}
    <div class="main-wrapper">
        {{-- Navbar --}}
        <nav class="navbar">
            <div>
                <a href="{{ url('/home') }}" class="text-blue-700 font-bold text-lg mr-4">🏠 Trang chủ</a>
                <a href="{{ route('dashboard') }}" class="text-sm text-blue-600 hover:text-blue-400">📊 Bảng điều khiển</a>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm font-medium text-gray-700">
                    <i class="fa fa-user"></i> {{ Auth::user()->name ?? 'Khách' }}
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white text-sm px-3 py-1 rounded hover:bg-red-600">
                        Đăng xuất
                    </button>
                </form>
            </div>
        </nav>

        {{-- Main content --}}
        <main class="main-content">
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="main-footer">
            &copy; {{ date('Y') }} <a href="#">YourCompany</a>. Đã đăng ký bản quyền.
        </footer>
    </div>
 @yield('scripts')
</body>
</html>
