@extends('layouts.app')

@section('content')
<a href="{{ route('projects.index') }}" class="btn btn-secondary">Back</a>
<h2>Edit Project</h2>
<form action="{{ route('projects.update', $project->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Project Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $project->name }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection
