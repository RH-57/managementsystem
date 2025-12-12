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

        <div class="card shadow-sm border-0">
            <div class="card-body">

                <h4 class="card-title mb-4">
                    <i class="bi bi-info-circle me-1"></i> Lead Information
                </h4>

                <!-- Customer Info -->
                <div class="p-3 rounded border bg-light mb-4">
                    <h6 class="text-primary fw-bold">
                        <i class="bi bi-person-circle me-1"></i> Customer Details
                    </h6>

                    <div class="row mt-2">
                        <div class="col-md-6 mb-2">
                            <strong>Name:</strong>
                            <p class="mb-0">{{ $lead->customer->name }}</p>
                        </div>

                        <div class="col-md-6 mb-2">
                            <strong>Company:</strong>
                            <p class="mb-0">{{ $lead->customer->company ?? '-' }}</p>
                        </div>

                        <div class="col-md-6 mb-2">
                            <strong>Phone:</strong>
                            <p class="mb-0">{{ $lead->customer->phone ?? '-' }}</p>
                        </div>

                        <div class="col-md-6 mb-2">
                            <strong>Email:</strong>
                            <p class="mb-0">{{ $lead->customer->email ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Lead Info -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Lead Title:</strong>
                        <p class="mb-1">{{ $lead->title ?? '-' }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Created At:</strong>
                        <p class="mb-1">{{ $lead->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                <strong>Description:</strong>
                <div class="alert alert-secondary mt-2">
                    {{ $lead->description ?? '-' }}
                </div>

                <hr>

                <!-- ITEMS -->
                <h4 class="card-title mb-3">
                    <i class="bi bi-bag-check me-1"></i> Lead Items
                </h4>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Item Name</th>
                                <th width="80">Qty</th>
                                <th>Notes</th>
                                <th width="120">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lead->items as $item)
                            <tr>
                                <td>{{ $item->item_name }}</td>
                                <td class="fw-bold">{{ $item->qty }}</td>
                                <td>{{ $item->notes ?? '-' }}</td>
                                <td>
                                    @php
                                        $badge = match($item->status) {
                                            'pending' => 'warning',
                                            'approved' => 'success',
                                            'rejected' => 'danger',
                                            default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $badge }}">{{ ucfirst($item->status) }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <hr>

                <!-- FILES -->
                <h4 class="card-title mb-3">
                    <i class="bi bi-folder2-open me-1"></i> Uploaded Files
                </h4>

                @if($lead->files->count() > 0)
                <div class="row">
                    @foreach($lead->files as $file)
                    <div class="col-md-4 mb-3">
                        <div class="border rounded p-3 bg-light h-100 d-flex flex-column">
                            <div class="mb-2">
                                <i class="bi bi-file-earmark-text text-primary me-1"></i>
                                <strong>{{ $file->original_name }}</strong>
                            </div>

                            <div class="mt-auto">
                                <a href="" class="btn btn-sm btn-success w-100">
                                    <i class="bi bi-download me-1"></i> Download
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                    <p class="text-muted">No files uploaded.</p>
                @endif

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
