@extends('layouts.admin')



@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Chỉnh sửa thông tin người dùng</h2>

    <form id="editUserForm" method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')

        {{-- Tên --}}
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Tên</label>
            <input 
                id="name" 
                name="name" 
                type="text"
                value="{{ old('name', $user->name) }}" 
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                required
            >
            @error('name')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input 
                id="email" 
                name="email" 
                type="email"
                value="{{ old('email', $user->email) }}" 
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                required
            >
            @error('email')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Phòng ban --}}
        <div class="mb-4">
            <label for="department_id" class="block text-sm font-medium text-gray-700">Phòng ban</label>
            <select 
                name="department_id" 
                id="department_id" 
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                required
            >
                @forelse ($departments as $department)
                    <option value="{{ $department->id }}" {{ $user->department_id == $department->id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @empty
                    <option value="">Không có phòng ban</option>
                @endforelse
            </select>
            @error('department_id')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Chức vụ --}}
        <div class="mb-6">
            <label for="role_id" class="block text-sm font-medium text-gray-700">Chức vụ</label>
            <select 
                name="role_id" 
                id="role_id" 
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                required
            >
                @forelse ($roles as $role)
                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @empty
                    <option value="">Không có chức vụ</option>
                @endforelse
            </select>
            @error('role_id')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Nút hành động --}}
        <div class="flex items-center justify-between">
            <a href="{{ route('users.index') }}" class="text-sm text-gray-600 hover:underline">
                ← Quay lại danh sách
            </a>
            <button 
                type="submit" 
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none"
            >
                Cập nhật
            </button>
        </div>
    </form>
</div>
@endsection


@section('scripts')
<script type="module">
    // Thêm phương thức kiểm tra ký tự đặc biệt
    $.validator.addMethod("noSpecialChars", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9\sÀ-ỹà-ỹ]+$/.test(value);
    }, "Tên không được chứa ký tự đặc biệt");

    $(function () {
        $("#editUserForm").validate({
            rules: {
                name: {
                    required: true,
                    noSpecialChars: true,
                    rangelength: [3, 50],
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                email: {
                    required: true,
                    email: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                department_id: "required",
                role_id: "required"
            },
            messages: {
                name: {
                    required: "Vui lòng nhập tên",
                    rangelength: "Tên phải từ 3 đến 50 ký tự"
                },
                email: {
                    required: "Vui lòng nhập email",
                    email: "Email không đúng định dạng"
                },
                department_id: {
                    required: "Vui lòng chọn phòng ban"
                },
                role_id: {
                    required: "Vui lòng chọn chức vụ"
                }
            },
            errorPlacement: function (error, element) {
                const id = element.attr('id') + "Error";
                $("#" + id).removeClass('hidden').html(error);
            },
            success: function (label, element) {
                const id = $(element).attr('id') + "Error";
                $("#" + id).addClass('hidden').html("");
            }
        });
         $(document).ready(function () {
   
  });
    });
</script>
@endsection

