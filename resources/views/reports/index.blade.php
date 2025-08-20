@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

<div class="container-fluid">
    <section class="content-header">
        <h1>Báo cáo</h1>
    </section>

    <section class="content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <form id="search-form" class="form-inline">
                    <input type="text" name="search" id="search" placeholder="Tên báo cáo hoặc người thực hiện"
                           class="form-control mr-2">
                    
                </form>
                <a href="{{ route('reports.create') }}" class="btn btn-success">+ Thêm báo cáo</a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="reports-table" class="table table-bordered table-hover w-100">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Tên báo cáo</th>
                                <th>Ngày</th>
                                <th>Nội dung</th>
                                <th>Thời gian làm việc(h)</th>
                                <th>Người thực hiện</th>
                                <th>Vai trò</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function () {
    const table = $('#reports-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('reports.data') }}',
            data: function (d) {
                d.search = $('#search').val();
            }
        },
        columns: [
            { data: 'id' },
            { data: 'report_name' },
            { data: 'report_date' },
            { data: 'content'},
            { data: 'working_hours'},
            { data: 'name' },
           { data: 'job' },
            { data: 'actions', orderable: false, searchable: false }
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

    $('#search-form').on('submit', function (e) {
        e.preventDefault();
        table.draw();
    });
});
</script>
@endsection
