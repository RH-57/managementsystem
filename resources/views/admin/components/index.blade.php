<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Components - Admin</title>

  <link href="{{ asset('assets/admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/admin/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/admin/css/style.css') }}" rel="stylesheet">
</head>

<body>

  @include('admin.partials.header')
  @include('admin.partials.sidebar')

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Components</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboards.index') }}">Home</a></li>
          <li class="breadcrumb-item active">Components</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
      <div class="row">

        <div class="col-lg-12">
          <div class="card info-card">
            <div class="card-body">

              <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Manage Components</h5>

                <!-- Button trigger Create Modal -->
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">
                  <i class="bi bi-plus"></i> Add Component
                </button>
              </div>

              <table class="table align-middle">
                <thead>
                  <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th class="text-end">Action</th>
                  </tr>
                </thead>
                <tbody>

                  @forelse($components as $component)
                    <tr>
                      <td>{{ $component->code }}</td>
                      <td>{{ $component->name }}</td>
                      <td>{{ $component->unit?->name }} ({{ $component->unit?->symbol }})</td>
                      <td>Rp {{ number_format($component->price, 0, ',', '.') }}</td>

                      <td class="text-end">

                        <!-- EDIT BUTTON -->
                        <button class="btn btn-info btn-sm"
                          data-bs-toggle="modal"
                          data-bs-target="#editModal{{ $component->id }}">
                          <i class="bi bi-pencil"></i>
                        </button>

                        <!-- DELETE FORM -->
                        <form action="{{ route('components.destroy', $component->id) }}"
                              method="POST"
                              style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this component?')">
                            <i class="bi bi-trash"></i>
                          </button>
                        </form>
                      </td>
                    </tr>

                    <!-- EDIT MODAL -->
                    <div class="modal fade" id="editModal{{ $component->id }}" tabindex="-1">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <form action="{{ route('components.update', $component->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="modal-header">
                              <h5 class="modal-title">Edit Component</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                              <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control"
                                  value="{{ $component->name }}" required>
                              </div>

                              <div class="mb-3">
                                <label class="form-label">Unit</label>
                                <select name="unit_id" class="form-select" required>
                                  <option value="">Choose Unit</option>
                                  @foreach($units as $unit)
                                    <option value="{{ $unit->id }}"
                                      {{ $unit->id == $component->unit_id ? 'selected' : '' }}>
                                      {{ $unit->name }} ({{ $unit->symbol }})
                                    </option>
                                  @endforeach
                                </select>
                              </div>

                              <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" name="price" class="form-control"
                                  value="{{ $component->price }}" required>
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
                      <td colspan="6" class="text-center text-muted py-4">No components found</td>
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

        <form action="{{ route('components.store') }}" method="POST">
          @csrf

          <div class="modal-header">
            <h5 class="modal-title">Add New Component</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body">

            <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Unit</label>
              <select name="unit_id" class="form-select" required>
                <option value="">Choose Unit</option>
                @foreach($units as $unit)
                  <option value="{{ $unit->id }}">{{ $unit->name }} ({{ $unit->symbol }})</option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Price</label>
              <input type="number" name="price" class="form-control" required>
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
