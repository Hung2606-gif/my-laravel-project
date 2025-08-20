@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="container-fluid">
    <section class="content-header">
        <h1>Sửa báo cáo</h1>
    </section>

    <section class="content mt-3">
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Lỗi!</strong> Vui lòng kiểm tra lại dữ liệu.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="{{ route('reports.edit', ['id' => $report->id]) }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="report_name">Tên báo cáo <span class="text-danger">*</span></label>
                        <input type="text" name="report_name" id="report_name" class="form-control"
                            value="{{ old('report_name', $report->report_name) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="report_date">Ngày thực hiện</label>
                        <input type="date" name="report_date" id="report_date" class="form-control"
                            value="{{ old('report_date', $report->report_date) }}">
                    </div>
                      <div class="form-group">
                        <label for="content">Nội dung <span class="text-danger">*</span></label>
                        <input type="text" name="content" id="content" class="form-control"
                            value="{{ old('content', $report->content) }}" required>
                    </div>
                      <div class="form-group">
                        <label for="working_hours">Thời gian làm việc<span class="text-danger">*</span></label>
                        <input type="decimal" name="working_hours" id="working_hours" class="form-control"
                            value="{{ old('working_hours', $report->working_hours) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="user_id">Người thực hiện <span class="text-danger">*</span></label>
                        <select name="user_id" class="form-control" id="user_id" required>
                            <option value="">-- Chọn người thực hiện --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('user_id', $report->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-sm btn-outline-secondary mt-2 clearSelect2">Bỏ chọn</button>
                    </div>

                    <div class="form-group">
                        <label for="job">Vai trò <span class="text-danger">*</span></label>
                        <input type="text" name="job" id="job" class="form-control"
                            value="{{ old('job', $report->job) }}" required>
                    </div>

                    <div class="form-group mt-4">
                        <a href="{{ route('users.reportIndex') }}" class="btn btn-secondary">Quay lại</a>
                        <button type="submit" class="btn btn-success">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        $('#user_id').select2({
            placeholder: "Chọn người thực hiện",
            allowClear: true,
            width: '100%'
        });

        $('.clearSelect2').on('click', function () {
            $('#user_id').val(null).trigger('change');
        });
    });
</script>
@endsection
