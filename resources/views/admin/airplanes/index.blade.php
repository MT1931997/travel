@extends('layouts.admin')
@section('title')
    {{ __('messages.airplanes') }}
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center"> {{ __('messages.airplanes') }} </h3>
        
            <a href="{{ route('airplanes.create') }}" class="btn btn-sm btn-success"> {{ __('messages.New') }} {{
            __('messages.airplanes') }}</a>
        </div>
        <div class="card-body">
            <form method="get" action="{{ route('airplanes.index') }}" enctype="multipart/form-data">
                @csrf
                <div class="row my-3">
                    <div class="col-md-3">
                        <input autofocus type="text" placeholder="{{ __('messages.Search') }}" name="search" class="form-control" value="{{ request('search') }}">
                    </div>
          
                    <div class="col-md-3">
                        <button class="btn btn-success "> {{ __('messages.Search') }} </button>
                    </div>
                </div>
            </form>

            <div class="clearfix"></div>

            <div id="ajax_responce_serarchDiv" class="col-md-12">
                @can('airplane-table')
                    @if (@isset($data) && !@empty($data) && count($data) > 0)
                        <table id="example2" class="table table-bordered table-hover">
                            <thead class="custom_thead">
                                <th>{{ __('messages.Name') }}</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($data as $info)
                                    <tr>
                                        <td>{{ $info->name }}</td>
                                        <td>
                                            @can('airplane-edit')
                                                <a href="{{ route('airplanes.edit', $info->id) }}" class="btn btn-sm btn-primary">
                                                    {{ __('messages.Edit') }}
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        {{ $data->appends(['search' => $searchQuery])->links() }}
                    @else
                        <div class="alert alert-danger">
                            {{ __('messages.No_data') }}
                        </div>
                    @endif
                @endcan
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/admin/js/airplanes.js') }}"></script>
@endsection
