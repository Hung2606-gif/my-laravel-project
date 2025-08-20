<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Department;
use Yajra\DataTables\DataTables;

class DepartmentController extends Controller
{
public function view()
{
    $departments = Department::paginate(9); 
    return view('departments.list', compact('departments'));
}


  public function show(Request $request, $department = null)
{
    $search = $request->input('search', '');
    $query = User::with(['department', 'role']);

    if ($department === 'none' || $department === null) {
        $query->whereNull('department_id');
    } else {
        // Lấy ID của phòng ban từ tên
        $departmentModel = Department::where('name', $department)->first();

        if (!$departmentModel) {
            return view('users.users-by-department', [
                'users' => collect(), 
                'search' => $search,
                'activeUserId' => null
            ]);
        }

        $query->where('department_id', $departmentModel->id);
    }

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    $query->orderBy('role_id', 'asc')->orderBy('id', 'asc');

    $users = $query->paginate(10)->withQueryString();
    $activeUserId = session()->pull('active_user_id');

    return view('departments.users-by-department', compact('users', 'department', 'search', 'activeUserId'));
}

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
        ]);

        Department::create(['name' => $request->name]);

        return redirect()->route('departments.store')
                         ->with('success', 'Thêm phòng ban thành công!');
    }
     public function delete($id)
    {
        $department = Department::findOrFail($id);

        if ($department->users()->count() > 0) {
            return back()->with('error', 'Không thể xoá phòng ban đang có nhân viên.');
        }

        $department->delete();

        return back()->with('success', 'Xoá phòng ban thành công!');
    }

}