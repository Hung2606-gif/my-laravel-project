<aside class="main-sidebar">
    <div>
        <h5>CHỨC NĂNG CHÍNH</h5>
        <a href="{{ url('/login') }}" class="{{ request()->is('login') ? 'active' : '' }}">
            <i class="fas fa-sign-in-alt mr-2"></i> Đăng nhập
        </a>
        <a href="{{ url('/product') }}" class="{{ request()->is('product') ? 'active' : '' }}">
            <i class="fas fa-box mr-2"></i> Sản phẩm
        </a>
        <a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}">
            <i class="fas fa-envelope mr-2"></i> Liên hệ
        </a>

        <hr class="border-gray-600 my-2">

        <h5>QUẢN LÝ</h5>
        <a href="{{ route('users.index') }}" class="{{ request()->is('users') ? 'active' : '' }}">
            <i class="fas fa-users mr-2"></i> Người dùng
        </a>
        <a href="{{ route('departments.view') }}" class="{{ request()->is('departments') ? 'active' : '' }}">
            <i class="fas fa-building mr-2"></i> Phòng ban
        </a>
        <a href="{{ route('users.managers') }}" class="{{ request()->is('users/managers') ? 'active' : '' }}">
            <i class="fas fa-user-tie mr-2"></i> Trưởng phòng
        </a>
          <li class="nav-item">
    <a href="{{ route('projects.index') }}" class="nav-link {{ request()->is('projects*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-solid fa-diagram-project"></i>
        <p>Dự án</p>
    </a>
     <a href="{{ route('reports.index') }}" class="nav-link {{ request()->is('reports*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-regular fa-flag"></i>
        <p>Báo cáo</p>
    </a>
</li>



        <hr class="border-gray-600 my-2">

        <h5>LIÊN KẾT NGOÀI</h5>
        <a href="https://facebook.com" target="_blank">
            <i class="fab fa-facebook mr-2"></i> Bài viết
        </a>
    </div>
</aside>
