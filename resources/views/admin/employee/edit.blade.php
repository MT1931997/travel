  @extends('layouts.admin')

@section('title', __('messages.edit_employee'))

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('messages.edit_employee') }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.employee.update', $employee->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">{{ __('messages.Name') }}</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $employee->name) }}" required>
            </div>

            <div class="form-group">
                <label for="username">{{ __('messages.username') }}</label>
                <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $employee->phone) }}">
            </div>

            <div class="form-group">
                <label for="password">{{ __('messages.Password') }}</label>
                <input type="password" name="password" id="password" class="form-control">
                <small>{{ __('messages.leave_blank') }}</small>
            </div>



            <div class="form-group">
                <label for="activate">{{ __('messages.Activate') }}</label>
                <select name="activate" id="activate" class="form-control">
                    <option value="1" {{ old('activate', $employee->activate) == 1 ? 'selected' : '' }}>{{ __('messages.Yes') }}</option>
                    <option value="2" {{ old('activate', $employee->activate) == 2 ? 'selected' : '' }}>{{ __('messages.No') }}</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="image">{{ __('admin.roles') }} :</label>
                @foreach ($roles as $role)
                    <br>
                    <input {{ in_array($role->id, old('roles') ? old('roles') : []) ? 'checked' : '' }}
                        class="ml-5" type="checkbox" name="roles[]" id="role_{{ $role->id }}"
                        value="{{ $role->id }}" {{in_array($role->id,$adminRole)? 'checked' : ''}}>
                    <label for="role_{{ $role->id }}"> {{ $role->name }}. </label>
                    <br>
                @endforeach
            </div>
            <hr>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
                <a href="{{ route('admin.employee.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
