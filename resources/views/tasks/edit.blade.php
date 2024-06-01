@extends('layouts.app')

@section('content')
<a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back</a>
<h2>Edit Task</h2>
<form action="{{ route('tasks.update', $task->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Task Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $task->name }}" required>
    </div>
    <div class="form-group">
        <label for="project_id">Project</label>
        <select class="form-control" id="project_id" name="project_id" required>
            @foreach($projects as $project)
            <option value="{{ $project->id }}" {{ $task->project_id == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection
