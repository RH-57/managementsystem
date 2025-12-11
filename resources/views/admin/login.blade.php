<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Business System</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('assets/admin/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/admin/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Nunito:300,400,600,700|Poppins:300,400,600,700" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/admin/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/admin/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/admin/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/admin/vendor/simple-datatables/style.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/admin/css/style.css') }}" rel="stylesheet">
</head>

<body>

<main>
  <div class="container">

    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

            <div class="d-flex justify-content-center py-4">
              <a href="{{ url('/') }}" class="logo d-flex align-items-center w-auto">
                <span class="d-none d-lg-block">Business System</span>
              </a>
            </div><!-- End Logo -->

            <div class="card mb-3">

              <div class="card-body">

                <div class="pt-4 pb-2">
                  <h5 class="card-title text-center pb-0 fs-4">Login</h5>
                </div>

                {{-- Error Message untuk session error --}}
                @if(session('error'))
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                @endif

                {{-- Error Message untuk validation errors --}}
                @if($errors->any())
                  <div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorAlert">
                    @foreach($errors->all() as $error)
                      {{ $error }}@if(!$loop->last)<br>@endif
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                @endif

                <form class="row g-3 needs-validation" action="{{ route('manage.attempt') }}" method="POST" novalidate id="loginForm">
                  @csrf

                  <div class="col-12">
                    <label for="yourEmail" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="yourEmail" value="{{ old('email') }}" required
                           @if($errors->has('email') && str_contains($errors->first('email'), 'Terlalu banyak')) disabled @endif>
                    @error('email')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-12">
                    <label for="yourPassword" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="yourPassword" required
                           @if($errors->has('email') && str_contains($errors->first('email'), 'Terlalu banyak')) disabled @endif>
                    @error('password')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-12">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe" {{ old('remember') ? 'checked' : '' }}
                             @if($errors->has('email') && str_contains($errors->first('email'), 'Terlalu banyak')) disabled @endif>
                      <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                  </div>

                  <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit" id="loginButton"
                            @if($errors->has('email') && str_contains($errors->first('email'), 'Terlalu banyak')) disabled @endif>
                      Login
                    </button>
                  </div>
                </form>

              </div>
            </div>

          </div>
        </div>
      </div>

    </section>

  </div>
</main><!-- End #main -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="{{ asset('assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/admin/js/main.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const errorAlert = document.getElementById('errorAlert');
    const loginForm = document.getElementById('loginForm');
    const loginButton = document.getElementById('loginButton');
    const emailInput = document.getElementById('yourEmail');
    const passwordInput = document.getElementById('yourPassword');
    const rememberInput = document.getElementById('rememberMe');

    // Cek jika ada error rate limit
    const errorText = errorAlert ? errorAlert.textContent : '';

    if (errorText.includes('Terlalu banyak')) {
        // Extract waktu tunggu dari pesan error
        const timeMatch = errorText.match(/(\d+) detik/);
        if (timeMatch) {
            const seconds = parseInt(timeMatch[1]);
            disableForm(seconds);
            startCountdown(seconds);
        }
    }

    function disableForm(seconds) {
        // Disable form elements
        if (loginButton) loginButton.disabled = true;
        if (emailInput) emailInput.disabled = true;
        if (passwordInput) passwordInput.disabled = true;
        if (rememberInput) rememberInput.disabled = true;

        // Ubah style tombol
        if (loginButton) {
            loginButton.innerHTML = `Tunggu ${seconds} detik...`;
            loginButton.classList.remove('btn-primary');
            loginButton.classList.add('btn-secondary');
        }
    }

    function enableForm() {
        // Enable form elements
        if (loginButton) loginButton.disabled = false;
        if (emailInput) emailInput.disabled = false;
        if (passwordInput) passwordInput.disabled = false;
        if (rememberInput) rememberInput.disabled = false;

        // Kembalikan style tombol
        if (loginButton) {
            loginButton.innerHTML = 'Login';
            loginButton.classList.remove('btn-secondary');
            loginButton.classList.add('btn-primary');
        }

        // Hapus error alert
        if (errorAlert) {
            errorAlert.remove();
        }
    }

    function startCountdown(seconds) {
        let timeLeft = seconds;

        const countdownInterval = setInterval(() => {
            timeLeft--;

            if (loginButton) {
                loginButton.innerHTML = `Tunggu ${timeLeft} detik...`;
            }

            if (timeLeft <= 0) {
                clearInterval(countdownInterval);
                enableForm();
            }
        }, 1000);
    }
});
</script>

</body>
</html>
