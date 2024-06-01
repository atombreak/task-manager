<form action="{{ $task ? route('tasks.update', $task->id) : route('tasks.store') }}" method="POST">
    @csrf
    @if ($task)
        @method('PUT')
    @endif
    <div class="form-group">
        <label for="name">Task Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $task->name ?? '') }}" required>
    </div>
    <div class="form-group">
        <label for="project_id">Project</label>
        <select class="form-control" id="project_id" name="project_id" required>
            @foreach($projects as $project)
                <option value="{{ $project->id }}" {{ (old('project_id') ?? $task->project_id ?? '') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
</form>
