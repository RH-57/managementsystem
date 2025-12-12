<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Edit Lead - Admin</title>

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('assets/admin/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/admin/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('assets/admin/css/style.css')}}" rel="stylesheet">
</head>

<body>

@include('admin.partials.header')
@include('admin.partials.sidebar')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Edit Lead</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboards.index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('leads.index') }}">Leads</a></li>
                <li class="breadcrumb-item active">{{ $lead->code }}</li>
            </ol>
        </nav>
    </div>

    <section class="section">

<form action="{{ route('leads.update', $lead->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<!-- HIDDEN INPUT UNTUK DELETED ITEMS -->
<input type="hidden" name="deleted_items" id="deleted_items">

<div class="card shadow-sm border-0">
    <div class="card-body">

        <h4 class="card-title mb-4">
            <i class="bi bi-pencil-square me-1"></i> Edit Lead Information
        </h4>

        <!-- CUSTOMER -->
        <div class="mb-4">
            <label class="form-label fw-bold">Customer</label>
            <select class="form-select" name="customer_id" id="customerSelect" required>
                <option value="">-- Select Customer --</option>
                @foreach($customers as $cus)
                    <option value="{{ $cus->id }}"
                        data-name="{{ $cus->name }}"
                        data-company="{{ $cus->company }}"
                        data-phone="{{ $cus->phone }}"
                        data-email="{{ $cus->email }}"
                        @if($lead->customer_id == $cus->id) selected @endif>
                        {{ $cus->name }}
                    </option>
                @endforeach
            </select>

            <div id="customerDetail" class="p-3 mt-3 border rounded bg-light">

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Name</label>
                        <input type="text" id="detail_name" class="form-control" disabled
                               value="{{ $lead->customer->name }}">
                    </div>

                    <div class="col-md-6 mb-2">
                        <label class="form-label">Company Name</label>
                        <input type="text" id="detail_company" class="form-control" disabled
                               value="{{ $lead->customer->company }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Phone</label>
                        <input type="text" id="detail_phone" class="form-control" disabled
                               value="{{ $lead->customer->phone }}">
                    </div>

                    <div class="col-md-6 mb-2">
                        <label class="form-label">Email</label>
                        <input type="text" id="detail_email" class="form-control" disabled
                               value="{{ $lead->customer->email }}">
                    </div>
                </div>

            </div>
        </div>

        <!-- TITLE -->
        <div class="mb-3">
            <label class="form-label fw-bold">Title</label>
            <input type="text" class="form-control" name="title" value="{{ $lead->title }}">
        </div>

        <!-- DESCRIPTION -->
        <div class="mb-4">
            <label class="form-label fw-bold">Description</label>
            <textarea class="form-control" name="description" rows="3">{{ $lead->description }}</textarea>
        </div>

        <hr>

        <!-- ITEMS -->
        <h4 class="card-title mb-3">
            <i class="bi bi-bag me-1"></i> Lead Items
        </h4>

        <div id="items-wrapper">
            @foreach($lead->items as $idx => $item)
            <div class="row g-3 item-row mb-3 p-3 border rounded bg-light">

                <input type="hidden" name="items[{{ $loop->index }}][id]" value="{{ $item->id }}">

                <div class="col-md-5">
                    <label>Item Name</label>
                    <input type="text" name="items[{{ $idx }}][item_name]" class="form-control"
                           value="{{ $item->item_name }}" required>
                </div>

                <div class="col-md-2">
                    <label>Qty</label>
                    <input type="number" name="items[{{ $idx }}][qty]" class="form-control"
                           value="{{ $item->qty }}" required>
                </div>

                <div class="col-md-4">
                    <label>Notes</label>
                    <input type="text" name="items[{{ $idx }}][notes]" class="form-control"
                           value="{{ $item->notes }}">
                </div>

                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-item w-100">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>

            </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-sm btn-secondary mt-2" id="add-item">
            + Add Item
        </button>

        <hr>

        <!-- FILES -->
        <h4 class="card-title mb-3">
            <i class="bi bi-folder2-open me-1"></i> Existing Files
        </h4>

        <div class="row">
            @foreach($lead->files as $file)
            <div class="col-md-4 mb-3">
                <div class="border p-3 rounded bg-light h-100">
                    <strong>{{ $file->original_name }}</strong>

                    <div class="mt-2 d-flex justify-content-between">
                        <a href="" class="btn btn-success btn-sm">
                            <i class="bi bi-download"></i>
                        </a>

                        <a href="{{ route('lead.deleteFile', $file->id) }}"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Delete this file?')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <hr>

        <h4 class="card-title mb-3">Upload New Files</h4>
        <input type="file" name="files[]" class="form-control" multiple>

        <button class="btn btn-primary mt-4 px-4">
            <i class="bi bi-check-circle me-1"></i> Update Lead
        </button>

    </div>
</div>

</form>

    </section>

</main>

@include('admin.partials.footer')

<script>
let itemIndex = {{ $lead->items->count() }};
let deletedItems = [];

// Add Item
document.getElementById('add-item').addEventListener('click', function() {

    let html = `
        <div class="row item-row mb-3">

            <div class="col-md-4">
                <label>Item Name</label>
                <input type="text" name="items[${itemIndex}][item_name]" class="form-control" required>
            </div>

            <div class="col-md-3">
                <label>Qty</label>
                <input type="number" name="items[${itemIndex}][qty]" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label>Notes</label>
                <input type="text" name="items[${itemIndex}][notes]" class="form-control">
            </div>

            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm remove-item">X</button>
            </div>
        </div>
    `;

    // FIXED → Ganti item-container menjadi items-wrapper
    document.getElementById('items-wrapper').insertAdjacentHTML('beforeend', html);

    itemIndex++;
});

// Remove Item
document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-item')) {

        const row = e.target.closest('.item-row');

        // jika item lama → push id ke array
        const idInput = row.querySelector('input[name*="[id]"]');
        if (idInput) {
            deletedItems.push(idInput.value);
            document.getElementById('deleted_items').value = JSON.stringify(deletedItems);
        }

        row.remove();
    }
});
</script>

<script>
document.getElementById('customerSelect').addEventListener('change', function() {
    const s = this.options[this.selectedIndex];
    if (!this.value) return;

    document.getElementById("detail_name").value = s.dataset.name;
    document.getElementById("detail_company").value = s.dataset.company;
    document.getElementById("detail_phone").value = s.dataset.phone;
    document.getElementById("detail_email").value = s.dataset.email;
});
</script>

</body>
</html>
