<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Notification;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    public function eachEmployeeTask($status)
    {
        // Get the authenticated admin
        $admin = auth()->user();

        // Check if the admin is a super admin
        if ($admin->is_super == 1) {
            // Show all tasks for super admin
            $tasks = Task::where('status',$status)->get();
        } else {
            // Show tasks where admin_id matches the logged-in admin
            $tasks = Task::where('admin_id', $admin->id)->where('status',$status)->get();
        }

        // Return the view with tasks data
        return view('admin.tasks.employee', compact('tasks'));
    }


    public function index()
    {
        $tasks = Task::with('employee', 'creator')->paginate(10);
        return view('admin.tasks.index', compact('tasks'));
    }

    public function create()
    {
        $employees = Admin::all(); // Fetch all employees
        return view('admin.tasks.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:pending,in_progress,completed',
            'admin_id' => 'required|exists:admins,id',
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'due_date' => $request->due_date,
            'status' => $request->status,
            'admin_id' => $request->admin_id,
            'created_by' => Auth::id(),
        ]);

           // Save the notification
           $noti = new Notification([
            'title' => 'You Have New Task Check That',
            'body' => $request->description,
            'admin_id' => $request->admin_id,
        ]);

          $noti->save();

        return redirect()->route('tasks.index')->with('success', 'Task created successfully');
    }

    // public function show($id)
    // {
    //     $task = Task::with('employee', 'creator')->findOrFail($id);
    //     return view('admin.tasks.show', compact('task'));
    // }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $employees = Admin::all();
        return view('admin.tasks.edit', compact('task', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:pending,in_progress,completed',
            'admin_id' => 'required|exists:admins,id',
        ]);

        $task = Task::findOrFail($id);
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'due_date' => $request->due_date,
            'status' => $request->status,
            'admin_id' => $request->admin_id,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
    }
}
