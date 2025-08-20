<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Yajra\DataTables\DataTables;
use App\Models\Project; 
class ProjectController extends Controller
{
public function create()
{
    $users = \App\Models\User::all();
    return view('projects.create', compact('users'));
}

public function index(Request $request)
{
    $search = $request->input('search');

    $projects = Project::query();

    if ($search) {
        $projects->where(function ($query) use ($search) {
            $query->where('project_name', 'like', "%{$search}%")
                  ->orWhere('user_id', 'like', "%{$search}%");
        });
    }

    $projects = $projects->orderBy('id', 'desc')->get();

    return view('projects.index', compact('projects'));
}
public function data(Request $request)
{
    $query = Project::with('users');

    if ($search = $request->input('search.value')) { 
        $query->where(function ($q) use ($search) {
            $q->where('project_name', 'like', "%$search%")
              ->orWhereHas('user', function ($q2) use ($search) {
                  $q2->where('name', 'like', "%$search%");
              });
        });
    }

   return DataTables::of($query)
        ->addColumn('name', function ($project) {
            return $project->users->pluck('name')->implode(', ');
        })
        ->editColumn('project_date', function ($project) {
            return $project->project_date
                ? \Carbon\Carbon::parse($project->project_date)->format('d/m/Y')
                : '';
        })
        ->addColumn('actions', function ($project) {
            return view('projects.partials.actions', compact('project'))->render();
        })
        ->rawColumns(['actions'])
        ->make(true);
}

public function destroy($id)
{
    $project = Project::findOrFail($id);
    $project->delete();

    return redirect()->route('projects.index')->with('success', 'Đã xoá dự án thành công.');
}
public function edit(Request $request, $id)
{
    $project = Project::with('users')->findOrFail($id);
    $users = User::all();

    if ($request->isMethod('post')) {
        $request->validate([
            'project_name' => 'required',
            'project_date' => 'required|date',
            'user_id' => 'required|array',
            'user_id.*' => 'exists:users,id',
            
        ]);

        
        $project->update([
            'project_name' => $request->project_name,
            'project_date' => $request->project_date,
           
        ]);

       
        $project->users()->sync($request->user_id);

        return redirect()->route('projects.index')->with('success', 'Cập nhật thành công!');
    }

    return view('projects.edit', compact('project', 'users'));
}


public function store(Request $request)
{
    $request->validate([
        'project_name' => 'required|string|max:255',
        'project_date' => 'nullable|date',
        'user_id' => 'required|array',
        'user_id.*' => 'exists:users,id',
        
    ]);

    
    $project = \App\Models\Project::create([
        'project_name' => $request->project_name,
        'project_date' => $request->project_date,
     
    ]);

    
    $project->users()->attach($request->user_id);

    return redirect()->route('projects.index')->with('success', 'Dự án đã được tạo thành công!');
} 
}