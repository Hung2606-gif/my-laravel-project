@extends('layouts.admin')

@section('content')

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<div class="container-fluid">
    <section class="content-header">
        <h1>Người dùng <small>Danh sách</small></h1>
    </section>





    <section class="content">
        {{-- Thông báo thành công --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        {{-- Form tìm kiếm và nút thêm --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <form method="GET" action="{{ route('users.index') }}" class="form-inline">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Tên hoặc Email"
                           class="form-control mr-2">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </form>
                <a href="{{ route('users.create') }}" class="btn btn-success">+ Thêm người dùng</a>
            </div>

            {{-- Bảng danh sách --}}
           <div class="card-body">
    <div class="table-responsive">
        <table id="users-table" class="table table-bordered table-hover w-100">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Ngày làm việc</th>
                    <th>Phòng ban</th>
                    <th>Chức vụ</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>{{ $user->department->name ?? 'Không có' }}</td>
                        <td>{{ $user->role->name ?? 'Không có' }}</td>
                        <td>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-info">Sửa</a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc muốn xoá người dùng này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Xoá</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <a href="{{ route('users.export.csv') }}" class="btn btn-success mb-3">
    Export người dùng 
</a>

        </table>
    </div>
</div>

            {{-- Phân trang --}}
            <div class="card-footer clearfix">
               
            </div>
        </div>
    </section>
</div>
@endsection

{{-- Scripts --}}
@section('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- Bootstrap 4 JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<!-- Zip (cần thiết cho CSV) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script>
   $(document).ready(function () {
    

    if ($.fn.DataTable.isDataTable('#users-table')) {
    $('#users-table').DataTable().destroy(); 
    $('#users-table').empty(); 
}

    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('users.data') }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'created_at', name: 'created_at' },
            { data: 'department', name: 'department.name' },
            { data: 'role', name: 'role.name' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
             
        ], 
            language: {
                search: "Tìm kiếm:",
                zeroRecords: "Không tìm thấy kết quả phù hợp",
                info: "Hiển thị _START_ đến _END_ trong _TOTAL_ dòng",
                infoEmpty: "Không có dữ liệu",
                lengthMenu: "Hiển thị _MENU_ dòng",
                paginate: {
                    previous: "← Trước",
                    next: "Tiếp →"
                }
            }
        });
   

        const el = document.getElementById('user-{{ $activeUserId }}');
        if (el) {
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            el.classList.add('border', 'border-primary');
        }
    
    });
</script>
@endsection





