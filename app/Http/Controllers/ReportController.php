<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Yajra\DataTables\DataTables;
use App\Models\Report;
class ReportController extends Controller
{
public function create()
{
    $users = \App\Models\User::all();
    return view('users.reportCreate', compact('users'));
}
public function index(Request $request)
{
    $search = $request->input('search');

    $reports = Report::query();

    if ($search) {
        $reports->where(function ($query) use ($search) {
            $query->where('report_name', 'like', "%{$search}%")
                  ->orWhere('user_id', 'like', "%{$search}%");
        });
    }

    $reports = $reports->orderBy('id', 'desc')->get();

    return view('reports.index', compact('reports'));
}
public function data(Request $request)
{
    $query = Report::with('user');

    if ($search = $request->input('search.value')) { 
        $query->where(function ($q) use ($search) {
            $q->where('report_name', 'like', "%$search%")
              ->orWhereHas('user', function ($q2) use ($search) {
                  $q2->where('name', 'like', "%$search%");
              });
        });
    }

   return DataTables::of($query)
        ->addColumn('name', function ($report) {
    return $report->user->name ?? 'Không rõ';
        })
        ->editColumn('report_date', function ($report) {
            return $report->report_date
                ? \Carbon\Carbon::parse($report->report_date)->format('l, d F Y')
                : '';
        })
        ->addColumn('actions', function ($report) {
            return view('reports.partials.actions', compact('report'))->render();
        })
        ->rawColumns(['actions'])
        ->make(true);
}

public function destroy($id)
{
    $report = Report::findOrFail($id);
    $report->delete();

    return redirect()->route('reports.index')->with('success', 'Báo cáo đã được xóa');
}
public function edit(Request $request, $id)
{
    $report = Report::with('user')->findOrFail($id);
    $users = User::all();

    if ($request->isMethod('post')) {
        $request->validate([
            'report_name' => 'required',
            'report_date' => 'required|date',
            'content' => 'required',
            'working_hours' => 'required|numeric',
            'user_id' => 'required|exists:users,id', 
            'job' => 'required',
        ]);

        $report->update([
            'report_name' => $request->report_name,
            'report_date' => $request->report_date,
            'content' => $request->content,
            'working_hours' => $request ->working_hours,
            'job' => $request->job,
            'user_id' => $request->user_id, 
        ]);

        return redirect()->route('reports.index')->with('success', 'Cập nhật thành công!');
    }

    return view('reports.edit', compact('report', 'users'));
}


public function store(Request $request)
{
    $request->validate([
        'report_name' => 'required|string|max:255',
        'report_date' => 'nullable|date',
        'content' => 'required',
         'working_hours' => 'required|numeric',
        'job' => 'required|string|max:255',
    ]);

    $report = \App\Models\Report::create([
        'report_name' => $request->report_name,
        'report_date' => $request->report_date,
        'content' => $request->content,
        'working_hours' => $request->working_hours,
        'job' => $request->job,
        'user_id' => $request->user_id, 
    ]);

    return redirect()->route('reports.index')->with('success', 'Đã tạo thành công báo cáo!');
}
}