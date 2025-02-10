@extends('layouts.superAdmin')
@section('title')
{{ __('messages.clients') }}
@endsection


@section('content')

      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center"> {{ __('messages.New') }} {{ __('messages.clients') }}   </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">


      <form action="{{ route('clients.store') }}" method="post" enctype='multipart/form-data'>
        <div class="row">
        @csrf

    

        <div class="col-md-6">
            <div class="form-group">
              <label>  {{ __('messages.Name') }}    </label>
              <input name="name" id="name" class="form-control" value="{{ old('name') }}"    >
              @error('name')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
              <label>   {{ __('messages.Phone') }}  </label>
              <input name="phone" id="phone" class="form-control" value="{{ old('phone') }}"    >
              @error('phone')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
              <label>   {{ __('messages.Address') }}  </label>
              <input name="address" id="address" class="form-control" value="{{ old('address') }}"    >
              @error('address')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
              <label>   SubDomain  </label>
              <input name="subdomain" id="subdomain" class="form-control" value="{{ old('subdomain') }}"    >
              @error('subdomain')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
        </div>


        <div class="col-md-6">
            <div class="form-group">
              <label>   {{ __('messages.Email') }}   </label>
              <input name="email" id="email" class="form-control" value="{{ old('email') }}"    >
              @error('email')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
              <label>   {{ __('messages.Password') }}   </label>
              <input name="password" id="password" class="form-control" value="{{ old('password') }}"    >
              @error('password')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>   {{ __('messages.from_date') }}   </label>
            <input type="date" name="from_date" id="from_date" class="form-control" value="{{ old('from_date') }}"    >
            @error('from_date')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
      </div>

      <div class="col-md-6">
          <div class="form-group">
            <label>   {{ __('messages.to_date') }}   </label>
            <input type="date" name="to_date" id="to_date" class="form-control" value="{{ old('to_date') }}"    >
            @error('to_date')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
      </div>

        <div class="col-md-6">
            <div class="form-group">
              <label>   {{ __('messages.price_of_subscription') }}   </label>
              <input name="price_of_subscription" id="price_of_subscription" class="form-control" value="{{ old('price_of_subscription') }}"    >
              @error('price_of_subscription')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
        </div>




      <div class="col-md-12">
      <div class="form-group text-center">
        <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm">{{ __('messages.Submit') }} </button>
        <a href="{{ route('clients.index') }}" class="btn btn-sm btn-danger">{{ __('messages.Cancel') }}</a>

      </div>
    </div>

  </div>
            </form>



            </div>




        </div>
      </div>






@endsection


@section('script')

@endsection






