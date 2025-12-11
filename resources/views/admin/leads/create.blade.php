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
        <h1>Create Lead</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboards.index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('leads.index') }}">Leads</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </nav>
    </div>

    <section class="section">

    <form action="{{ route('leads.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card">
        <div class="card-body">

            <h5 class="card-title">Lead Information</h5>

            <!-- Customer -->
            <div class="mb-3">
                <label class="form-label">Customer</label>
                <select class="form-select" name="customer_id" required>
                    <option value="">-- Select Customer --</option>
                    @foreach($customers as $cus)
                        <option value="{{ $cus->id }}">{{ $cus->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Title -->
            <div class="mb-3">
                <label class="form-label">Title (optional)</label>
                <input type="text" class="form-control" name="title">
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label class="form-label">Description (optional)</label>
                <textarea class="form-control" name="description" rows="3"></textarea>
            </div>

            <hr>

            <h5 class="card-title">Lead Items</h5>

            <div id="items-wrapper">

                <div class="row g-3 item-row">
                    <div class="col-md-5">
                        <label>Item Name</label>
                        <input type="text" name="items[0][item_name]" class="form-control" required>
                    </div>

                    <div class="col-md-2">
                        <label>Qty</label>
                        <input type="number" name="items[0][qty]" class="form-control" value="1" required>
                    </div>

                    <div class="col-md-5">
                        <label>Notes</label>
                        <input type="text" name="items[0][notes]" class="form-control">
                    </div>
                </div>

            </div>

            <button type="button" class="btn btn-sm btn-secondary mt-3" id="add-item">
                + Add Item
            </button>

            <hr>

            <h5 class="card-title">Supporting Files</h5>

            <div class="mb-3">
                <label class="form-label">Upload Files</label>
                <input type="file" name="files[]" class="form-control" multiple>
                <small class="text-muted">Images / PDF / Docs allowed</small>
            </div>

            <button class="btn btn-primary mt-3">Save Lead</button>

        </div>
    </div>

    </form>

    </section>



  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  @include('admin.partials.footer')
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script>
    let index = 1;

    document.getElementById('add-item').addEventListener('click', function () {

        let wrapper = document.getElementById('items-wrapper');

        let html = `
            <div class="row g-3 item-row mt-2">
                <div class="col-md-5">
                    <label>Item Name</label>
                    <input type="text" name="items[${index}][item_name]" class="form-control" required>
                </div>

                <div class="col-md-2">
                    <label>Qty</label>
                    <input type="number" name="items[${index}][qty]" class="form-control" value="1" required>
                </div>

                <div class="col-md-5">
                    <label>Notes</label>
                    <input type="text" name="items[${index}][notes]" class="form-control">
                </div>
            </div>
        `;

        wrapper.insertAdjacentHTML('beforeend', html);

        index++;
    });
    </script>

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
