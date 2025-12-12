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
        <h1>Leads</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboards.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Leads</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="card info-card customers-card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Manage <span>| Leads</span></h5>
                    <a class="btn btn-sm btn-primary" href="{{ route('leads.create') }}">
                        Add Lead
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Customer</th>
                                <th>Title</th>
                                <th>Total Items</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($leads as $lead)
                            <tr>
                                <td>{{ $lead->code }}</td>
                                <td>{{ $lead->customer->name }}</td>
                                <td>{{ $lead->title ?? '-' }}</td>
                                <td>{{ $lead->items->count() }}</td>
                                <td>{{ $lead->created_at->format('d M Y') }}</td>

                                <td>
                                    <a href="{{ route('leads.show', $lead->id) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('leads.destroy', $lead->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Delete this lead?')"
                                            class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
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
