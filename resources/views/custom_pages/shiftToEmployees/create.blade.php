@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Create Add Shift To Employees</h2>
    <form action="{{ route('addShiftToEmployees.store') }}" method="POST">
        @csrf

        <input type="hidden" name="redirect_to" id="redirect_to" value="index">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="from_date">{{ __('messages.Date') }}</label>
                    <input type="date" name="from_date" class="form-control" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="to_date">{{ __('messages.To_Date') }}</label>
                    <input type="date" name="to_date" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            @foreach ($employees as $employee)
            <div class="col-md-6">
                <div class="form-group">
                    <label for="employee_{{ $employee->id }}">{{ $employee->name }}</label>
                    <select name="shifts[{{ $employee->id }}]" class="form-control" required>
                        @foreach ($shifts as $shift)
                        <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary" onclick="setRedirect('index')">{{ __('messages.Submit')}}</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('js')
<script type="text/javascript">
    function setRedirect(value) {
        document.getElementById('redirect_to').value = value;
    }
</script>
@endsection
