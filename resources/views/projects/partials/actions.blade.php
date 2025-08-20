<a href="{{ route('projects.edit', ['id' => $project->id]) }}" class="btn btn-sm btn-primary">Sửa</a>

<form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Xoá dự án này?');">
    @csrf
    @method('GET')
    <button type="submit" class="btn btn-sm btn-danger">Xoá</button>
</form>
