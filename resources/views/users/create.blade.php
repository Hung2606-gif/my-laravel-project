@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Tạo người dùng mới</h2>

    <form id="createUserForm" method="POST" action="{{ route('users.store') }}">
        @csrf

        {{-- Tên --}}
        <div class="mb-4">
            <label for="name" class="block font-semibold">Tên</label>
            <input id="name" name="name" value="{{ old('name') }}" 
                   class="w-full border p-2 rounded" required>
            <div id="nameError" class="text-red-500 text-sm mt-1 hidden"></div>
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <label for="email" class="block font-semibold">Email</label>
            <input id="email" name="email" value="{{ old('email') }}" 
                   class="w-full border p-2 rounded" required>
            <div id="emailError" class="text-red-500 text-sm mt-1 hidden"></div>
        </div>

        {{-- Phòng ban --}}
        <div class="mb-4">
            <label for="department_id" class="block font-semibold">Phòng ban</label>
            <select name="department_id" id="department_id" class="w-full border rounded p-2">
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}" 
                        {{ old('department_id') == $department->id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Chức vụ --}}
        <div class="mb-4">
            <label for="role_id" class="block font-semibold">Chức vụ</label>
            <select name="role_id" id="role_id" class="w-full border rounded p-2">
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" 
                        {{ old('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Nút hành động --}}
        <div class="flex justify-between items-center">
            <a href="{{ route('users.index') }}" class="text-gray-600 hover:underline">← Quay lại</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tạo</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script type="module">
    $.validator.addMethod("noSpecialChars", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9\sÀ-ỹà-ỹ]+$/.test(value);
    }, "Tên không được chứa ký tự đặc biệt");

    $(function () {
        $("#createUserForm").validate({
            rules: {
                name: {
                    required: true,
                    noSpecialChars: true,
                    rangelength: [8, 10],
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
                }
            },
            messages: {
                name: {
                    required: "Vui lòng nhập tên",
                    rangelength: "Tên phải dài từ 3 đến 50 ký tự"
                },
                email: {
                    required: "Vui lòng nhập email",
                    email: "Email không đúng định dạng"
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
    });
</script>
@endsection

 