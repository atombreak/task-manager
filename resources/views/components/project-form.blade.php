<form id="projectForm" action="{{ $project ? route('projects.update', $project->id) : route('projects.store') }}" method="POST">
    @csrf
    @if ($project)
        @method('PUT')
    @endif
    <div class="form-group">
        <label for="name">Project Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $project->name ?? '') }}" required>
    </div>
    <button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
</form>
