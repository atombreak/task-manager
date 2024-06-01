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
        <button class="btn btn-success mb-2" data-toggle="modal" data-target="#createTaskModal">Create Task</button>
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

        <button class="btn btn-success mb-2" data-toggle="modal" data-target="#createProjectModal">Create Project</button>
        <ul class="list-group" id="project-list">
            @foreach($projects as $project)
            <li class="list-group-item">
                {{ $project->name }}
                <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm float-right ml-2">Delete</button>
                </form>
                <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-primary btn-sm float-right">Edit</a>
            </li>
            @endforeach
        </ul>
    </div>
</div>

<!-- Create Task Modal -->
<x-modal id="createTaskModal" title="Create Task">
    <x-task-form :projects="$projects" />
</x-modal>

<!-- Create Project Modal -->
<x-modal id="createProjectModal" title="Create Project">
    <x-project-form />
</x-modal>
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

        $('#projectForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var actionUrl = form.attr('action');
            $.ajax({
                type: form.attr('method'),
                url: actionUrl,
                data: form.serialize(),
                success: function(response) {
                    $('#createProjectModal').modal('hide');
                    $('#project-list').append('<li class="list-group-item">' + response.name + ' <a href="{{ url("projects") }}/' + response.id + '/edit" class="btn btn-primary btn-sm float-right ml-2">Edit</a><form action="{{ url("projects") }}/' + response.id + '" method="POST" style="display:inline;"><input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="DELETE"><button type="submit" class="btn btn-danger btn-sm float-right">Delete</button></form></li>');
                    form.trigger('reset');
                },
                error: function(response) {
                    console.log('Error:', response);
                }
            });
        });

        $('#taskForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var actionUrl = form.attr('action');
            $.ajax({
                type: form.attr('method'),
                url: actionUrl,
                data: form.serialize(),
                success: function(response) {
                    $('#createTaskModal').modal('hide');
                    location.reload();
                },
                error: function(response) {
                    console.log('Error:', response);
                }
            });
        });
    });

    function updateTaskPriorities(taskIds) {
        taskIds.forEach((id, index) => {
            $('tr[data-id="' + id + '"] td:first').text('#' + (index + 1));
        });
    }
</script>
@endsection
