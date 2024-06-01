@extends('layouts.app')

@section('content')
<a href="{{ route('projects.index') }}" class="btn btn-secondary">Back</a>
<h2>Create Project</h2>
<form action="{{ route('projects.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Project Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection
