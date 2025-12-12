<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Customers - Admin</title>

  <link href="{{ asset('assets/admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/admin/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/admin/css/style.css') }}" rel="stylesheet">
</head>

<body>

  @include('admin.partials.header')
  @include('admin.partials.sidebar')

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Customers</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboards.index') }}">Home</a></li>
          <li class="breadcrumb-item active">Customers</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
      <div class="row">

        <div class="col-lg-12">
          <div class="card info-card">
            <div class="card-body">

              <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Manage Customers</h5>

                <!-- CREATE BUTTON -->
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">
                  <i class="bi bi-plus"></i> Add Customer
                </button>
              </div>
                <div class="table-responsive">
                    <table class="table align-middle ">
                        <thead>
                        <tr>
                            <th>Customer Code</th>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th class="text-end">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($customers as $customer)
                            <tr>
                            <td>{{ $customer->code }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->company }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone }}</td>

                            <td class="text-end">

                                <!-- EDIT BUTTON -->
                                <button class="btn btn-info btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $customer->id }}">
                                <i class="bi bi-pencil"></i>
                                </button>

                                <!-- DELETE -->
                                <form action="{{ route('customers.destroy', $customer->id) }}"
                                    method="POST"
                                    style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this customer?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                                </form>

                            </td>
                            </tr>

                            <!-- EDIT MODAL -->
                            <div class="modal fade" id="editModal{{ $customer->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">

                                <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-header">
                                    <h5 class="modal-title">Edit Customer</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="name" class="form-control"
                                                value="{{ $customer->name }}" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                        <label class="form-label">Company</label>
                                        <input type="text" name="company" class="form-control"
                                                value="{{ $customer->company }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control"
                                                value="{{ $customer->email }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                        <label class="form-label">Phone</label>
                                        <input type="text" name="phone" class="form-control"
                                                value="{{ $customer->phone }}">
                                        </div>

                                        <div class="col-12 mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea name="address" class="form-control" rows="3">{{ $customer->address }}</textarea>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    </div>

                                </form>

                                </div>
                            </div>
                            </div>

                        @empty
                            <tr>
                            <td colspan="6" class="text-center text-muted py-4">No customers found</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
          </div>
        </div>

      </div>
    </section>

  </main>

  @include('admin.partials.footer')


  <!-- CREATE MODAL -->
  <div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">

        <form action="{{ route('customers.store') }}" method="POST">
          @csrf

          <div class="modal-header">
            <h5 class="modal-title">Add Customer</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Company</label>
                <input type="text" name="company" class="form-control">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control">
              </div>

              <div class="col-12 mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="3"></textarea>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>

        </form>

      </div>
    </div>
  </div>


  <script src="{{ asset('assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{asset('assets/admin/js/main.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @if(session('success'))
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: "{{ session('success') }}",
        timer: 1800,
        showConfirmButton: false
      })
    </script>
  @endif

</body>
</html>
