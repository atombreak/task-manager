<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::all();
        $projectId = $request->get('project_id');

        if ($projectId) {
            $tasks = Task::where('project_id', $projectId)->orderBy('priority', 'asc')->get();
        } else {
            $tasks = Task::orderBy('priority', 'asc')->get();
        }

        return view('tasks.index', compact('tasks', 'projects', 'projectId'));
    }

    public function create()
    {
        $projects = Project::all();
        return view('tasks.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'project_id' => 'required|exists:projects,id',
        ]);

        $priority = Task::where('project_id', $request->project_id)->max('priority') + 1;

        Task::create([
            'name' => $request->name,
            'priority' => $priority,
            'project_id' => $request->project_id,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        $projects = Project::all();
        return view('tasks.edit', compact('task', 'projects'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required',
            'project_id' => 'required|exists:projects,id',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    // public function reorder(Request $request)
    // {
    //     $tasks = $request->tasks;
    //     foreach ($tasks as $index => $task_id) {
    //         $task = Task::find($task_id);
    //         $task->priority = $index + 1;
    //         $task->save();
    //     }
    //     return response()->json(['status' => 'success']);
    // }
    public function reorder(Request $request)
    {
        $tasks = $request->tasks;
        foreach ($tasks as $index => $task_id) {
            $task = Task::find($task_id);
            $task->priority = $index + 1;
            $task->save();
        }
        return response()->json(['status' => 'success']);
    }
}
