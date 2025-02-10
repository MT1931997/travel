@extends('layouts.admin')
@section('title')
    {{ __('messages.users') }}
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center"> {{ __('messages.users') }} </h3>

            <a href="{{ route('users.create') }}" class="btn btn-sm btn-success"> {{ __('messages.New') }} {{
            __('messages.users') }}</a>
        </div>
        <div class="card-body">
            <form method="get" action="{{ route('users.index') }}" enctype="multipart/form-data">
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
                @can('customer-table')
                    @if (@isset($data) && !@empty($data) && count($data) > 0)
                        <table id="example2" class="table table-bordered table-hover">
                            <thead class="custom_thead">
                                <th>{{ __('messages.Name') }}</th>
                                <th>{{ __('messages.Phone') }}</th>
                                <th>{{ __('messages.Photo of passport') }}</th>
                                <th>{{ __('messages.Address') }}</th>
                                <th>{{ __('messages.Companies') }}</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($data as $info)
                                    <tr>
                                        <td>{{ $info->name }}</td>
                                        <td>{{ $info->phone }}</td>
                                        <td>
                                            @if ($info->photo_of_passport)

                                                <div class="image">
                                                   <img class="custom_img" src="{{ asset('assets/admin/uploads').'/'.$info->photo_of_passport }}"  >

                                                </div>
                                              @else
                                                No Photo
                                            @endif
                                        </td>
                                        <td>{{$info->address}}</td>
                                        <td>
                                            @if($info->companies->isNotEmpty())
                                                @foreach($info->companies as $company)
                                                    {{ $company->name }}{{ !$loop->last ? ', ' : '' }}
                                                @endforeach
                                            @else
                                                {{ __('No Companies Assigned') }}
                                            @endif
                                        </td>
                                        <td>
                                            @can('customer-edit')
                                                <a href="{{ route('users.edit', $info->id) }}" class="btn btn-sm btn-primary">
                                                    {{ __('messages.Edit') }}
                                                </a>
                                            @endcan
                                            @can('customer-edit')
                                                <a href="{{ route('users.show', $info->id) }}" class="btn btn-sm btn-secondary">
                                                    {{ __('messages.Show') }}
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
    <script src="{{ asset('assets/admin/js/users.js') }}"></script>
@endsection
