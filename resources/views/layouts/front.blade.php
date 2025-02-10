<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <!-- Heading -->
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="text-center mb-4">
          <h2 class="fw-bold">Join Us Today!</h2>
          <p class="text-muted">Fill out the form below to register your information.</p>
        </div>
      </div>
    </div>

    <!-- Form Card -->
    <div class="row justify-content-center">
      <div class="col-md-6">
        <!-- Success Message -->
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <!-- Error Message -->
        @if ($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <!-- Registration Form -->
        <div class="card shadow">
          <div class="card-body">
            <form action="{{ route('customer.store') }}" method="POST" enctype='multipart/form-data'>
              @csrf
              <!-- Name -->
              <div class="mb-3">
                <div class="form-group">
                    <label>  {{ __('messages.Name') }} </label>
                    <input name="name" id="name" class="form-control" value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <div class="form-group">
                    <label> {{ __('messages.Phone') }}</label>
                    <input name="phone" id="notes" class="form-control" value="{{ old('phone') }}">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <div class="form-group">
                    <label> {{ __('messages.date_of_birth') }} </label>
                    <input type="date" name="date_of_birth" id="name" class="form-control" value="{{ old('date_of_birth') }}">
                    @error('date_of_birth')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

         

    

            <div class="mb-3">
                <div class="form-group">
                    <label> {{ __('messages.Address') }}</label>
                    <input name="address" id="address" class="form-control" value="{{ old('address') }}">
                    @error('address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
       



            <div class="mb-3">
                <div class="form-group">
                    <img src="" id="image-preview" alt="Selected Image" height="50px" width="50px" style="display: none;">
                  <button class="btn">{{ __('messages.Photo of passport') }} </button>
                 <input  type="file" id="Item_img" name="photo_of_passport" class="form-control" onchange="previewImage()">
                    @error('photo_of_passport')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    </div>
            </div>

            <div class="mb-3">
                <div class="form-group">
                    <label> {{ __('messages.Date of passport end') }} </label>
                    <input type="date" name="date_of_passport_end" id="name" class="form-control" value="{{ old('date_of_passport_end') }}">
                    @error('date_of_passport_end')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

          


              <!-- Submit Button -->
              <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
