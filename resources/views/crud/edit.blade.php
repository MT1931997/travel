@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route($routeName . '.update', $data->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            @if (($is_there_radio_tree && $existing_classes !== null) || ($is_there_radio_tree_self && $existing_classes !== null))
                                @if ($existing_classes->isNotEmpty())
                                    <div class="radio-list-tree">
                                        @foreach ($existing_classes as $class)
                                            <label class="parent">
                                                <span class="toggle-icon">▶</span> <!-- Icon for toggling visibility -->
                                                <input type="radio" name="selected_class_id"
                                                       value="{{ $class->id }}" {{ $data->selected_class_id == $class->id ? 'checked' : '' }}>
                                                       {{ $class->name }}
                                            </label>
                                        @endforeach
                                    </div>
                                @else
                                    <p>No existing classes found. Please create a new one.</p>
                                @endif
                            @else
                                <p>Radio tree functionality is disabled or not applicable.</p>
                            @endif

                            @php
                                $optionsIndex = 0;
                            @endphp

                            @foreach ($columns_view as $index => $column_view)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="{{ $columns_table_name[$index] }}">{{ $column_view }}:</label>
                                        @if ($inputTypes[$index] == 'text')
                                            <input type="text" name="{{ $columns_table_name[$index] }}" class="form-control"
                                                   value="{{ old($columns_table_name[$index], $data->{$columns_table_name[$index]}) }}"
                                                   @if ($required[$index] == 'required') required @endif>
                                        @elseif($inputTypes[$index] == 'text_area')
                                            <textarea name="{{ $columns_table_name[$index] }}" class="form-control"
                                                      @if ($required[$index] == 'required') required @endif>{{ old($columns_table_name[$index], $data->{$columns_table_name[$index]}) }}</textarea>
                                        @elseif($inputTypes[$index] == 'date')
                                            <input type="date" name="{{ $columns_table_name[$index] }}" class="form-control"
                                                   value="{{ old($columns_table_name[$index], $data->{$columns_table_name[$index]}) }}"
                                                   @if ($required[$index] == 'required') required @endif>
                                        @elseif($inputTypes[$index] == 'date_time')
                                            <input type="datetime-local" name="{{ $columns_table_name[$index] }}" class="form-control"
                                                   value="{{ old($columns_table_name[$index], $data->{$columns_table_name[$index]}) }}"
                                                   @if ($required[$index] == 'required') required @endif>
                                        @elseif($inputTypes[$index] == 'photo')
                                            <input type="file" name="{{ $columns_table_name[$index] }}" class="form-control"
                                                   @if ($required[$index] == 'required') required @endif>
                                            @if ($data->{$columns_table_name[$index]})
                                                <br>
                                                <img src="{{ asset('storage/' . $data->{$columns_table_name[$index]}) }}" alt="Current Image" width="100">
                                            @endif
                                        @elseif($inputTypes[$index] == 'options')
                                            @include('inputs.options', [
                                                'name' => $columns_table_name[$index],
                                                'options' => $options[$optionsIndex] ?? [],
                                                'selected' => old($columns_table_name[$index], $data->{$columns_table_name[$index]}),
                                                'required' => $required[$index],
                                            ])
                                            @php
                                                $optionsIndex++;
                                            @endphp
                                        @elseif($inputTypes[$index] == 'search_select')
                                            @include('inputs.search_select', [
                                                'name' => $columns_table_name[$index],
                                                'selected' => old($columns_table_name[$index], $data->{$columns_table_name[$index]}),
                                                'required' => $required[$index],
                                            ])
                                        @elseif($inputTypes[$index] == 'select_another_table_multiple')
                                            @include('inputs.select_another_model_multiple', [
                                                'name' => $columns_table_name[$index],
                                                'optionsFromTable' => $optionsFromTable,
                                                'selected' => old($columns_table_name[$index], $data->{$columns_table_name[$index]}),
                                                'required' => $required[$index],
                                            ])
                                        @elseif($inputTypes[$index] == 'select_another_table')
                                            @include('inputs.select_another_model', [
                                                'name' => $columns_table_name[$index],
                                                'optionsFromTable' => $optionsFromTable,
                                                'selected' => old($columns_table_name[$index], $data->{$columns_table_name[$index]}),
                                                'required' => $required[$index],
                                            ])
                                        @elseif($inputTypes[$index] == 'select_another_table_two')
                                            @include('inputs.select_another_model_two', [
                                                'name' => $columns_table_name[$index],
                                                'optionsFromTable2' => $optionsFromTable2,
                                                'selected' => old($columns_table_name[$index], $data->{$columns_table_name[$index]}),
                                                'required' => $required[$index],
                                            ])
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <br>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">{{__('messages.Update')}}</button>
                            <a href="{{ route($routeName . '.index') }}" class="btn btn-danger">{{__('messages.Cancel')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
