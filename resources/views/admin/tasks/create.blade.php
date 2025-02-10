@extends('layouts.admin')

@section('title', __('messages.Add New Task'))

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title card_title_center"> {{ __('messages.Add_New') }}  {{ __('messages.tasks') }} </h3>
    </div>
    <div class="card-body">
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>{{ __('messages.Title') }}</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>{{ __('messages.Description') }}</label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>{{ __('messages.Start Date') }}</label>
                <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                @error('start_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>{{ __('messages.Due Date') }}</label>
                <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}">
                @error('due_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>{{ __('messages.Status') }}</label>
                <select name="status" class="form-control">
                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>{{ __('messages.Pending') }}</option>
                    <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>{{ __('messages.In Progress') }}</option>
                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>{{ __('messages.Completed') }}</option>
                </select>
                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>{{ __('messages.Assign to Employee') }}</label>
                <select name="admin_id" class="form-control">
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ old('admin_id') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->name }}
                        </option>
                    @endforeach
                </select>
                @error('admin_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-primary">{{ __('messages.Submit') }}</button>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">{{ __('messages.Cancel') }}</a>
        </form>
    </div>
</div>
@endsection
