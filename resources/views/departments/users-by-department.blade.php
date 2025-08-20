@extends('layouts.admin')

@section('content')
<div class="flex">
  

    <div class="flex-1 px-6 pt-6">
        <h2 class="text-2xl font-bold mb-4">
            Nhân viên {{ $department === 'none' || $department === null ? 'Chưa phân loại' : $department }}
        </h2>

        <form method="GET" class="mb-4 flex items-center">
            <input type="text" name="search" value="{{ $search }}" placeholder="Tìm kiếm..." class="border p-2 rounded">
            <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tìm</button>
        </form>

        <table class="w-full border text-left" id="user-table">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Tên</th>
                    <th class="border px-4 py-2">Email</th>
                    <th class="border px-4 py-2">Vai trò</th>
                    <th class="border px-4 py-2">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr data-id="{{ $user->id }}">
                    <td class="border px-4 py-2">{{ $user->id }}</td>
                    <td class="border px-4 py-2 editable" data-field="name">{{ $user->name }}</td>
                    <td class="border px-4 py-2 editable" data-field="email">{{ $user->email }}</td>
                    <td class="border px-4 py-2">{{ $user->role->name ?? 'N/A' }}</td>
                    <td class="border px-4 py-2 text-center">
                        <div class="flex justify-center gap-2">
                            <button class="edit-btn bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Sửa</button>

                            <form method="POST" action="{{ route('users.delete', $user->id) }}" onsubmit="return confirm('Bạn có chắc chắn muốn xoá người dùng này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Xoá</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
</div>

{{-- Inline Edit Script --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');
            const isEditing = this.textContent === 'Lưu';
            const cells = row.querySelectorAll('.editable');

            if (!isEditing) {
                cells.forEach(cell => {
                    const text = cell.textContent.trim();
                    cell.innerHTML = `<input type="text" class="border p-1 rounded w-full" value="${text}">`;
                });
                this.textContent = 'Lưu';
                this.classList.replace('bg-blue-500', 'bg-green-500');
            } else {
                const userId = row.getAttribute('data-id');
                const data = {};
                cells.forEach(cell => {
                    const field = cell.dataset.field;
                    const input = cell.querySelector('input');
                    if (input) {
                        data[field] = input.value;
                        cell.textContent = input.value;
                    }
                });

                fetch(`/users/${userId}/inline-update`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify(data),
                }).then(response => response.json()).then(result => {
                    if (result.success) {
                        alert('Cập nhật thành công!');
                    } else {
                        alert('Cập nhật thất bại!');
                    }
                }).catch(() => alert('Lỗi khi gửi dữ liệu.'));

                this.textContent = 'Sửa';
                this.classList.replace('bg-green-500', 'bg-blue-500');
            }
        });
    });
});
</script>
@endsection
