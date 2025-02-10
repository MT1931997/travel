@extends('layouts.admin')

@section('css')
    <style>
        .radio-list-tree {
            display: block;
            margin-left: 20px;
        }

        .parent {
            display: block;
            margin-bottom: 10px;
        }

        .children {
            display: block;
            /* Ensure children are block-level elements */
            margin-left: 20px;
            /* Indent child elements */
        }

        .hidden {
            display: none;
            /* Hide elements when the 'hidden' class is applied */
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route($routeName . '.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                @if (($is_there_radio_tree && $existing_classes !== null) || ($is_there_radio_tree_self && $existing_classes !== null))
                                    @if ($existing_classes->isNotEmpty())
                                        <div class="radio-list-tree">
                                            @foreach ($existing_classes as $class)
                                                <label class="parent">
                                                    <span class="toggle-icon">▶</span> <!-- Icon for toggling visibility -->
                                                    <input type="radio" name="selected_class_id"
                                                        value="{{ $class->id }}"> {{ $class->name }}
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
                                                <input type="text" name="{{ $columns_table_name[$index] }}"
                                                    class="form-control" @if ($required[$index] == 'required') required @endif>
                                            @elseif($inputTypes[$index] == 'text_area')
                                                <textarea name="{{ $columns_table_name[$index] }}" class="form-control"
                                                    @if ($required[$index] == 'required') required @endif></textarea>
                                            @elseif($inputTypes[$index] == 'date')
                                                <input type="date" name="{{ $columns_table_name[$index] }}"
                                                    class="form-control" @if ($required[$index] == 'required') required @endif>
                                            @elseif($inputTypes[$index] == 'time')
                                                <input type="time" name="{{ $columns_table_name[$index] }}"
                                                    class="form-control" @if ($required[$index] == 'required') required @endif>
                                            @elseif($inputTypes[$index] == 'date_time')
                                                <input type="datetime-local" name="{{ $columns_table_name[$index] }}"
                                                    class="form-control" @if ($required[$index] == 'required') required @endif>
                                            @elseif($inputTypes[$index] == 'photo')
                                                <input type="file" name="{{ $columns_table_name[$index] }}"
                                                    class="form-control" @if ($required[$index] == 'required') required @endif>
                                            @elseif($inputTypes[$index] == 'options')
                                                @include('inputs.options', [
                                                    'name' => $columns_table_name[$index],
                                                    'options' => $options[$optionsIndex] ?? [],
                                                    'required' => $required[$index],
                                                ])
                                                @php
                                                    $optionsIndex++;
                                                @endphp
                                            @elseif($inputTypes[$index] == 'search_select')
                                                @include('inputs.search_select', [
                                                    'name' => $columns_table_name[$index],
                                                    'required' => $required[$index],
                                                ])
                                            @elseif($inputTypes[$index] == 'search_select2')
                                                @include('inputs.search_select2', [
                                                    'name' => $columns_table_name[$index],
                                                    'required' => $required[$index],
                                                ])
                                            @elseif($inputTypes[$index] == 'select_another_table_multiple')
                                                @include('inputs.select_another_model_multiple', [
                                                    'name' => $columns_table_name[$index],
                                                    'optionsFromTable' => $optionsFromTable,
                                                    'required' => $required[$index],
                                                ])
                                            @elseif($inputTypes[$index] == 'select_another_table')
                                                @include('inputs.select_another_model', [
                                                    'name' => $columns_table_name[$index],
                                                    'optionsFromTable' => $optionsFromTable,
                                                    'required' => $required[$index],
                                                ])
                                            @elseif($inputTypes[$index] == 'select_another_table_two')
                                                @include('inputs.select_another_model_two', [
                                                    'name' => $columns_table_name[$index],
                                                    'optionsFromTable2' => $optionsFromTable2,
                                                    'required' => $required[$index],
                                                ])
                                            @elseif($inputTypes[$index] == 'select_another_table_three')
                                                @include('inputs.select_another_model_three', [
                                                    'name' => $columns_table_name[$index],
                                                    'optionsFromTable3' => $optionsFromTable3,
                                                    'required' => $required[$index],
                                                ])
                                            @elseif($inputTypes[$index] == 'select_another_table_four')
                                                @include('inputs.select_another_model_four', [
                                                    'name' => $columns_table_name[$index],
                                                    'optionsFromTable4' => $optionsFromTable4,
                                                    'required' => $required[$index],
                                                ])
                                            @endif
                                        </div>
                                    </div>
                                @endforeach



                            </div>
                            <br>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route($routeName . '.index') }}" class="btn btn-danger">cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toggleIcons = document.querySelectorAll('.toggle-icon');

            toggleIcons.forEach(icon => {
                const children = icon.parentNode.nextElementSibling;

                icon.addEventListener('click', function() {
                    // Toggle the 'hidden' class on the children element
                    children.classList.toggle('hidden');
                    // Change the icon based on the visibility of the children
                    this.textContent = children.classList.contains('hidden') ? '▶' : '▼';
                });
            });
        });
    </script>
@endsection
