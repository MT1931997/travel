@extends('layouts.superAdmin')
@section('title')
    edit client
@endsection



@section('contentheaderlink')
    <a href="{{ route('clients.index') }}"> client </a>
@endsection

@section('contentheaderactive')
    Edit
@endsection


@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center"> edit client</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">


            <form action="{{ route('clients.update', $client->id) }}" method="POST">
                @csrf
                @method('PUT')



             
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('messages.Name') }}</label>
                        <input name="name" id="name" class="form-control" value="{{ old('name', $client->name) }}">
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('messages.phone') }}</label>
                        <input name="phone" id="phone" class="form-control" value="{{ old('phone', $client->phone) }}">
                        @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>SubDomain</label>
                        <input name="subdomain" id="subdomain" class="form-control" value="{{ old('subdomain', $client->subdomain) }}" disabled>
                        @error('subdomain')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('messages.Email') }}</label>
                        <input name="email" id="email" class="form-control" value="{{ old('email', $client->email) }}">
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('messages.Password') }} (Leave blank if you don't want to change)</label>
                        <input name="password" id="password" class="form-control" value="">
                        @error('password')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>



                <div class="col-md-12">
                    <div class="form-group text-center">
                        <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm"> update</button>
                        <a href="{{ route('clients.index') }}" class="btn btn-sm btn-danger">cancel</a>

                    </div>
                </div>

            </form>




        </div>




    </div>
    </div>
@endsection


@section('script')
@endsection
