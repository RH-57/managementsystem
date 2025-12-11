<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Leads - Admin</title>
  <meta content="" name="description">
  <meta content="" name="keywords">


  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('assets/admin/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/admin/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('assets/admin/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('assets/admin/css/style.css')}}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  @include('admin.partials.header')
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  @include('admin.partials.sidebar')
  <!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
        <h1>Lead Details</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboards.index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('leads.index') }}">Leads</a></li>
                <li class="breadcrumb-item active">{{ $lead->code }}</li>
            </ol>
        </nav>
    </div>

    <section class="section">

    <div class="card">
        <div class="card-body">

            <h5 class="card-title">Lead Info</h5>

            <p><strong>Customer:</strong> {{ $lead->customer->name }}</p>
            <p><strong>Title:</strong> {{ $lead->title }}</p>
            <p><strong>Description:</strong> {{ $lead->description }}</p>
            <p><strong>Created:</strong> {{ $lead->created_at->format('d M Y') }}</p>

            <hr>

            <h5 class="card-title">Items</h5>

            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th><th>Qty</th><th>Notes</th><th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lead->items as $item)
                    <tr>
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ $item->notes }}</td>
                        <td>{{ $item->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <hr>

            <h5 class="card-title">Files</h5>

            <ul>
                @foreach($lead->files as $file)
                <li>
                    {{ $file->original_name }}
                    <a href="" class="btn btn-sm btn-success">Download</a>
                </li>
                @endforeach
            </ul>

        </div>
    </div>

    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  @include('admin.partials.footer')
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{asset('assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>


  <!-- Template Main JS File -->
  <script src="{{asset('assets/admin/js/main.js')}}"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session('success') }}",
            timer: 2000,
            showConfirmButton: false
        })
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ session('error') }}",
            timer: 3000,
            showConfirmButton: true
        })
    </script>
    @endif
</body>

</html>
