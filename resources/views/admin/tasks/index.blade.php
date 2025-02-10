@extends('layouts.admin')

@section('title', __('messages.tasks'))

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title card_title_center"> {{ __('messages.tasks') }} </h3>
    
        <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-success"> {{ __('messages.New') }} {{
        __('messages.tasks') }}</a>
    </div>
    <div class="card-body">
        @if($tasks->count())
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>{{ __('messages.Title') }}</th>
                            <th>{{ __('messages.Employee') }}</th>
                            <th>{{ __('messages.Status') }}</th>
                            <th>{{ __('messages.Due Date') }}</th>
                            <th>{{ __('messages.Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                            <tr>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->employee->name ?? __('messages.Not Available') }}</td>
                                <td>
                                    <span class="badge 
                                        @if($task->status == 'pending') badge-warning
                                        @elseif($task->status == 'in_progress') badge-info
                                        @else badge-success
                                        @endif">
                                        {{ ucfirst($task->status) }}
                                    </span>
                                </td>
                                <td>{{ $task->due_date ?? __('messages.Not Available') }}</td>
                                <td class="text-center">
                                  
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary btn-sm">
                                        {{ __('messages.Edit') }}
                                    </a>
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('messages.Are you sure?') }}')">
                                            {{ __('messages.Delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $tasks->links() }}
            </div>
        @else
            <div class="alert alert-warning text-center">
                {{ __('messages.No tasks found') }}
            </div>
        @endif
    </div>
</div>
@endsection
