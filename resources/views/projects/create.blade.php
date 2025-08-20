@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<div class="container-fluid">
    <section class="content-header">
        <h1>Thêm Dự Án</h1>
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
                <form action="{{ route('projects.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="project_name">Tên dự án <span class="text-danger">*</span></label>
                        <input type="text" name="project_name" id="project_name" class="form-control" value="{{ old('project_name') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="project_date">Ngày thực hiện</label>
                        <input type="date" name="project_date" id="project_date" class="form-control" value="{{ old('project_date') }}">
                    </div>

    
<div class="form-group">
    <label for="id_label_multiple">Người thực hiện <span class="text-danger">*</span></label>
    <select name="user_id[]" class="form-control" id="id_label_multiple" multiple>
        @foreach ($users as $user)
            <option value="{{ $user->id }}" {{ collect(old('user_id'))->contains($user->id) ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
</div>
<input type="button" class="btn btn-danger btn-sm clearSelect2" value="Clear">
 


                    <div class="form-group mt-4">
                        <a href="{{ route('projects.index') }}" class="btn btn-secondary">Quay lại</a>
                        <button type="submit" class="btn btn-primary">Lưu dự án</button>
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
        
        $('#id_label_multiple').select2({
            closeOnSelect: true,
            placeholder: "Chọn người thực hiện",
            allowClear: true
        });

      
       
    });
</script>
@endsection






