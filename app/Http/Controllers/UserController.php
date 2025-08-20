<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\User;
use App\Models\Department;
use App\Models\Role;
use Yajra\DataTables\DataTables;
use App\Models\Project; 
use App\Models\Report;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $users = User::with(['department', 'role'])
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%$search%")
                             ->orWhere('email', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        // Nhóm người dùng theo tên phòng ban
        $departmentUsers = $users->groupBy(function ($user) {
            return $user->department->name ?? 'Chưa phân loại';
        });

        $activeUserId = session()->pull('active_user_id');
        $success = session()->pull('success');

        return view('users.index', compact(
            'users',
            'search',
            'activeUserId',
            'success',
            'departmentUsers'
        ));
    }
   



public function getUsersData(Request $request)
{
    $query = User::with(['department', 'role']);

    return DataTables::of($query)
        ->addColumn('department', fn($user) => $user->department->name ?? 'Không có')
        ->addColumn('role', fn($user) => $user->role->name ?? 'Không có')
        ->addColumn('created_at', fn($user) => $user->created_at ? $user->created_at->format('d/m/Y') : '')
        ->addColumn('actions', function ($user) {
            return '
                <a href="'.route('users.edit', $user->id).'" class="btn btn-sm btn-info">Sửa</a>
                <form action="'.route('users.destroy', $user->id).'" method="POST" style="display:inline-block;">
                    '.csrf_field().method_field('DELETE').'
                    <button class="btn btn-sm btn-danger" onclick="return confirm(\'Xóa người dùng này?\')">Xoá</button>
                </form>
            ';
        })
        ->rawColumns(['actions'])
        ->make(true);
}


    public function show($id)
    {
        $user = User::with(['department', 'role'])->findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $departments = Department::all();
        $roles = Role::all();
        return view('users.edit', compact('user', 'departments', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'role_id' => 'nullable|exists:roles,id',
        ]);

        $user = User::findOrFail($id);
        $user->update($request->only('name', 'email', 'department_id', 'role_id'));

        return redirect()->route('users.index')
                         ->with('active_user_id', $id)
                         ->with('success', 'Cập nhật người dùng thành công!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
                         ->with('success', 'Đã xoá người dùng thành công!');
    }



    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
                         ->with('success', 'Đã xoá người dùng thành công!');
    }

  


    public function managersView(Request $request)
    {
        $search = $request->input('search');

        $users = User::with(['department', 'role'])
            ->whereHas('role', function ($query) {
                $query->where('name', 'Quản lí');
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%");
                });
            })
            ->paginate(10);

        return view('users.managers-list', compact('users', 'search'));
    }

    public function managersDelete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.managers-list')
                         ->with('success', 'Đã xoá người dùng thành công!');
    }

    public function create()
    {
        $user = new User();
        $departments = Department::all();
        $roles = Role::all();
        return view('users.create', compact('user', 'departments', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'department_id' => 'nullable|exists:departments,id',
            'role_id' => 'nullable|exists:roles,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'department_id' => $request->department_id,
            'role_id' => $request->role_id,
            'start_date' => now(),
        ]);

        return redirect()->route('users.index')->with('success', 'Tạo người dùng thành công!');
    }
  

public function exportCsv(): StreamedResponse
{
    $fileName = 'all_users.csv';

    $users = User::with('department', 'role')->get(); // ✅ lấy toàn bộ người dùng

    $headers = [
        "Content-type"        => "text/csv",
        "Content-Disposition" => "attachment; filename=$fileName",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    ];

    $columns = ['ID', 'Tên', 'Email', 'Ngày làm việc', 'Phòng ban', 'Chức vụ'];

    $callback = function () use ($users, $columns) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);

        foreach ($users as $user) {
            fputcsv($file, [
                $user->id,
                $user->name,
                $user->email,
                $user->created_at?->format('d/m/Y'),
                $user->department->name ?? '',
                $user->role->name ?? '',
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}


}



