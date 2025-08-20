<nav class="bg-white border-b border-blue-300 shadow fixed top-0 left-0 w-full z-50">
    <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
        <!-- Bên trái: Logo & menu -->
        <div class="flex items-center gap-6">
            <a href="{{ url('/home') }}" class="text-blue-700 text-lg font-bold hover:text-blue-500">
                Trang chủ
            </a>
            <a href="{{ route('dashboard') }}" class="text-sm text-blue-600 hover:text-blue-400">
                Bảng điều khiển
            </a>
        </div>

        <!-- Bên phải: Tên người dùng và đăng xuất -->
        <div class="flex items-center gap-4">
            <span class="text-sm font-medium text-gray-700">
                {{ Auth::user()->name ?? 'Khách' }}
            </span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="text-sm bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                    Đăng xuất
                </button>
            </form>
        </div>
    </div>
</nav>
