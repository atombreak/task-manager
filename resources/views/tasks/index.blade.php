@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h2>Tasks</h2>
        <form method="GET" action="{{ route('tasks.index') }}" class="mb-4">
            <div class="form-group">
                <label for="project_id">Filter by Project</label>
                <select class="form-control" id="project_id" name="project_id" onchange="this.form.submit()">
                    <option value="">All Projects</option>
                    @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ $projectId == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>
        </form>
        <a href="{{ route('tasks.create') }}" class="btn btn-success mb-2">Create Task</a>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Priority</th>
                    <th>Task Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="task-list">
                @foreach($tasks as $task)
                <tr data-id="{{ $task->id }}">
                    <td>#{{ $task->priority }}</td>
                    <td>{{ $task->name }}</td>
                    <td>
                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-4">
        <h2>Projects</h2>
        <a href="{{ route('projects.create') }}" class="btn btn-success mb-2">Create Project</a>
        <ul class="list-group">
            @foreach($projects as $project)
            <li class="list-group-item">{{ $project->name }}</li>
            @endforeach
        </ul>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(function() {
        $('#task-list').sortable({
            update: function(event, ui) {
                var taskIds = $(this).sortable('toArray', { attribute: 'data-id' });
                $.ajax({
                    url: '{{ route("tasks.reorder") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        tasks: taskIds
                    },
                    success: function(data) {
                        updateTaskPriorities(taskIds);
                    }
                });
            }
        }).disableSelection();
    });

    function updateTaskPriorities(taskIds) {
        taskIds.forEach((id, index) => {
            $('tr[data-id="' + id + '"] td:first').text('#' + (index + 1));
        });
    }
</script>
@endsection
