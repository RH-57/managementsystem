<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Units - Admin</title>

  <link href="{{ asset('assets/admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/admin/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/admin/css/style.css') }}" rel="stylesheet">
</head>

<body>

  @include('admin.partials.header')
  @include('admin.partials.sidebar')

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Units</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboards.index') }}">Home</a></li>
          <li class="breadcrumb-item active">Units</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
      <div class="row">

        <div class="col-lg-12">
          <div class="card info-card">
            <div class="card-body">

              <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Manage Units</h5>

                <!-- Button trigger Create Modal -->
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">
                  <i class="bi bi-plus"></i> Add Unit
                </button>
              </div>

              <table class="table align-middle">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Symbol</th>
                    <th class="text-end">Action</th>
                  </tr>
                </thead>
                <tbody>

                  @forelse($units as $unit)
                    <tr>
                      <td>{{ $unit->name }}</td>
                      <td>{{ $unit->symbol }}</td>
                      <td class="text-end">

                        <!-- EDIT BUTTON -->
                        <button class="btn btn-info btn-sm"
                          data-bs-toggle="modal"
                          data-bs-target="#editModal{{ $unit->id }}">
                          <i class="bi bi-pencil"></i>
                        </button>

                        <!-- DELETE FORM -->
                        <form action="{{ route('units.destroy', $unit->id) }}"
                              method="POST"
                              style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this unit?')">
                            <i class="bi bi-trash"></i>
                          </button>
                        </form>
                      </td>
                    </tr>

                    <!-- EDIT MODAL -->
                    <div class="modal fade" id="editModal{{ $unit->id }}" tabindex="-1">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <form action="{{ route('units.update', $unit->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="modal-header">
                              <h5 class="modal-title">Edit Unit</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                              <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control"
                                  value="{{ $unit->name }}" required>
                              </div>

                              <div class="mb-3">
                                <label class="form-label">Symbol</label>
                                <input type="text" name="symbol" class="form-control"
                                  value="{{ $unit->symbol }}" required>
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
                      <td colspan="3" class="text-center text-muted py-4">No units found</td>
                    </tr>
                  @endforelse

                </tbody>
              </table>

            </div>
          </div>
        </div>

      </div>
    </section>

  </main>

  @include('admin.partials.footer')

  <!-- CREATE MODAL -->
  <div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <form action="{{ route('units.store') }}" method="POST">
          @csrf

          <div class="modal-header">
            <h5 class="modal-title">Add New Unit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Symbol</label>
              <input type="text" name="symbol" class="form-control" required>
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
        timer: 2000,
        showConfirmButton: false
      })
    </script>
  @endif

</body>
</html>
