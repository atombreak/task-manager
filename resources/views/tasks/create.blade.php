@extends('layouts.app')

@section('content')
<a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back</a>
<h2>Create Task</h2>
<form action="{{ route('tasks.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Task Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="project_id">Project</label>
        <select class="form-control" id="project_id" name="project_id" required>
            @foreach($projects as $project)
            <option value="{{ $project->id }}">{{ $project->name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection
