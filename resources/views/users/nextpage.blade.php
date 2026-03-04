@extends('layouts.app')

@section('content')
<div class="container mt-5">

    {{-- PAGE TITLE --}}
    <h2 class="mb-4 text-center fw-bold">PREVENTIVE MAINTENANCE CHECKLIST SYSTEM</h2>

    {{-- SELECT COMPUTER TYPE --}}
    <div class="mb-4">
        <label class="form-label fw-bold">Select Type of Computer:</label>
        <select id="a_type" class="form-control form-control-sm">
            <option value="">Select type of Computer</option>
            <option value="1">All-in-One</option>
            <option value="2">Desktop</option>
            <option value="3">Laptop</option>
        </select>
    </div>

    {{-- ADD NEW BRAND CARD --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white fw-bold">Add Equipment Brand</div>
        <div class="card-body">
            <form id="addBrandForm" onsubmit="return false;">
                <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label class="form-label fw-bold">Model:</label>
                        <input type="text" class="form-control" id="brandName" placeholder="Enter Brand Name">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Status:</label>
                        <select class="form-control" id="brandStatus">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <button type="button" class="btn btn-success" onclick="saveBrand()">Save</button>
            </form>
        </div>
    </div>

    {{-- BRAND TABLE CARD --}}
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white fw-bold">Brand List</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0" id="brandTable">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th width="200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        <tr data-id="{{ $brand->id }}">
                            <td>{{ $brand->name }}</td>
                            <td>{{ $brand->status == 1 ? 'Active' : 'Inactive' }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning me-2" onclick="editBrand({{ $brand->id }}, this)">Edit</button>
                                <button class="btn btn-sm btn-danger" onclick="deleteBrand({{ $brand->id }}, this)">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@section('css')
<style>
.card { border-radius: 8px; }
h2 { letter-spacing: 1px; }
.table th, .table td { vertical-align: middle; }
.btn { min-width: 70px; }
.shadow-sm { box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
</style>
@stop
@section('js')
<script>
    // Kunin ang CSRF token mula sa meta tag (declare once)
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

     function saveCategory() {
        var formData = $('#categoryForm').serialize();
        $.ajax({
            url: "{{ route('category.save') }}",
            method: 'POST',
            data: formData,
            success: function(response) {
                console.log(response);
                $('#categoryModal').modal('hide');
                if(response.status == 'true') {
                     toastr.success('Category saved successfully!', 'Success');
                } else {
                    toastr.error('Failed to save category.', 'Error');
                }
                fetchCategories(); // Refresh the category list
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }
    window.editBrand = function(id, button) {
        let row = button.closest('tr');
        let name = prompt("Edit Brand Name", row.cells[0].innerText);
        if (name === null) return;

        let status = prompt("Edit Status (1=Active,0=Inactive)", row.cells[1].innerText == 'Active' ? 1 : 0);
        if (status === null) return;

        fetch(`/brands/update/${id}`, {
            method: 'POST', // POST route sa Laravel mo
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ name: name, status: status })
        })
        .then(res => res.json())
        .then(data => {
            fetchBrands(); // auto-refresh table
            alert('Brand updated!');
        })
        .catch(err => console.error(err));
    };

    window.deleteBrand = function(id, button) {
    if (!confirm("Delete this brand?")) return;

    fetch(`/brands/destroy/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json' // para hindi mag-return ng HTML
        }
    })
    .then(res => {
        if (!res.ok) throw new Error('Network response was not OK');
        return res.json();
    })
    .then(data => {
        fetchBrands(); // auto-refresh table
        alert('Brand deleted!');
    })
    .catch(err => console.error(err));
};

</script>
@endsection

