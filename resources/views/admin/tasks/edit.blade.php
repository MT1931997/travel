@extends('layouts.admin')

@section('title', __('messages.Edit Task'))

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('messages.Edit Task') }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>{{ __('messages.Title') }}</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $task->title) }}">
                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>{{ __('messages.Description') }}</label>
                <textarea name="description" class="form-control">{{ old('description', $task->description) }}</textarea>
                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>{{ __('messages.Start Date') }}</label>
                <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $task->start_date) }}">
                @error('start_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>{{ __('messages.Due Date') }}</label>
                <input type="date" name="due_date" class="form-control" value="{{ old('due_date', $task->due_date) }}">
                @error('due_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>{{ __('messages.Status') }}</label>
                <select name="status" class="form-control">
                    <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>
                        {{ __('messages.Pending') }}
                    </option>
                    <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>
                        {{ __('messages.In Progress') }}
                    </option>
                    <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>
                        {{ __('messages.Completed') }}
                    </option>
                </select>
                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>{{ __('messages.Assign to Employee') }}</label>
                <select name="admin_id" class="form-control">
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ old('admin_id', $task->admin_id) == $employee->id ? 'selected' : '' }}>
                            {{ $employee->name }}
                        </option>
                    @endforeach
                </select>
                @error('admin_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-primary">{{ __('messages.Update') }}</button>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">{{ __('messages.Cancel') }}</a>
        </form>
    </div>
</div>
@endsection
