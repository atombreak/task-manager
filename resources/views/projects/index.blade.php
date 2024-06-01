@extends('layouts.app')

@section('content')
<a href="{{ route('tasks.index') }}" class="btn btn-secondary">Go To Tasks</a>
<h2>Projects</h2>
<a href="{{ route('projects.create') }}" class="btn btn-success mb-2">Create Project</a>
<ul class="list-group">
    @foreach($projects as $project)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        {{ $project->name }}
        <span>
            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-primary btn-sm">Edit</a>
            <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </span>
    </li>
    @endforeach
</ul>
@endsection
