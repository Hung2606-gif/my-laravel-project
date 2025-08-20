<a href="{{ route('reports.edit', ['id' => $report->id]) }}" class="btn btn-sm btn-primary">Sửa</a>

<form action="{{ route('reports.destroy', $report->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Xoá báo cáo này?');">
    @csrf
    @method('GET')
    <button type="submit" class="btn btn-sm btn-danger">Xoá</button>
</form>
