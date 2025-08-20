@extends('layouts.admin')

@section('content')
<div class="flex">
    

    {{-- Nội dung chính --}}
    <div class="flex-1 px-6 pt-6">
        {{-- Danh sách phòng ban --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            @forelse ($departments as $department)
                <div class="relative bg-blue-100 text-blue-900 px-4 py-4 rounded shadow hover:bg-blue-200 transition text-center">
                    {{-- Nút xoá --}}
                    <form action="{{ route('departments.destroy', $department->id) }}" method="POST"
                          onsubmit="return confirm('Bạn có chắc chắn muốn xoá phòng ban này?')"
                          class="absolute top-2 right-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 text-lg">✖</button>
                    </form>

                    {{-- Tên phòng ban --}}
                    <a href="{{ route('departments.view', ['department' => $department->name]) }}"
                       class="block font-semibold text-lg hover:underline">
                        {{ $department->name }}
                    </a>
                </div>
            @empty
                <div class="text-center col-span-full text-gray-500">Không có phòng ban nào.</div>
            @endforelse
        </div>

        {{-- Phân trang --}}
        <div class="mb-6">
            {{ $departments->links() }}
        </div>

        {{-- Nút hiện form --}}
        <div class="mb-4">
            <button id="show-department-form"
                    class="bg-blue-500 hover:bg-blue-600 text-black px-4 py-2 rounded font-semibold">
                Thêm phòng ban
            </button>
        </div>

        {{-- Form thêm phòng ban --}}
        <div id="department-form" class="bg-blue-500 p-4 rounded shadow w-full md:w-1/2 mb-6 hidden">
            <form method="POST" action="{{ route('departments.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block mb-1 font-medium">Tên phòng ban</label>
                    <input type="text" id="name" name="name"
                           class="w-full px-4 py-2 border rounded focus:outline-none focus:ring"
                           placeholder="Nhập tên phòng ban" required minlength="2" maxlength="100">
                </div>
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-black px-4 py-2 rounded font-semibold">
                    Lưu phòng ban
                </button>

                {{-- Nút đóng --}}
                <button type="button" id="hide-department-form"
                        class="ml-2 text-sm text-gray-500 underline hover:text-gray-700">
                    Hủy
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#show-department-form').click(function () {
            $('#department-form').slideDown(() => {
                $('#name').focus(); // focus vào input khi hiện form
            });
        });

        $('#hide-department-form').click(function () {
            $('#department-form').slideUp();
        });
    });
</script>
@endsection
