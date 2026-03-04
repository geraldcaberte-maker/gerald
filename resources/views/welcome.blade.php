
@extends('layouts.app')

@section('title', 'Preventive Maintenance')

@section('content_header')
   
@stop
 
@section('content')
<div class="card">
    <div class="card-body">
        @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
        <form action="{{ route('custodian.store') }}" method="POST">
    @csrf
<h1 style="text-align: center;"><b>PREVENTIVE MAINTENANCE CHECKLIST SYSTEM</b></h1>
            <div class="mb-4">
                <div class="bg-light p-2 border mb-3">
                    <h5  class="mb-0"><b>CUSTODIAN INFORMATION</b></h5>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="small font-weight-bold">Name of Custodian:

                        </label>
                        <select id="user_id" class="form-control form-control-sm">
                            <option value="">Select Custodian</option>
                            <option value="1">John Doe</option>
                            <option value="2">Jane Smith</option>
                            <option value="3">Michael Johnson</option>
                            <option value="4">Emily Davis</option>
                            <option value="5">David Wilson</option>
                            <option value="6">Sarah Brown</option>
                            <option value="7">James Taylor</option>
                            <option value="8">Olivia Anderson</option>   
                            <option value="9">William Martinez</option>
                            <option value="10">Ava Thomas</option>
                            <option value="11">Benjamin Lee</option>     
                        </select>
                    </div>
                    

                </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="small font-weight-bold">A.Computer</label>
                        <select id="a_type" class="form-control form-control-sm">
                            <option value="">Select Computer</option>
                            <option value="1">All-in-One</option>
                            <option value="2">Desktop</option>
                            <option value="3">Laptop</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-4">
    <div class="col-md-4">
        <label class="small font-weight-bold">A. Computer Brand / Model:</label>
    
        
              <select id="a_type" class="form-control form-control-sm">
                        <option value="">-- Select Brand --</option>
            <option value="dell">Dell</option>
            <option value="hp">HP</option>
            <option value="lenovo">Lenovo</option>
            <option value="apple">Apple</option>
             </select>
    </div>
   
    <div class="col-md-4">
        <label class="small font-weight-bold">Model:</label>
        <input type="text" name="a_serial" class="form-control form-control-sm">
    </div>
    <div class="col-md-4">
        <label class="small font-weight-bold">Year of Acquisition:</label>
        <input type="text" name="a_year" class="form-control form-control-sm">
    </div>
</div>
<div class="container mt-5">
    <h2>Add Brand</h2>

    <!-- ADD FORM -->
    <form action="{{ route('brands.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <label><b>Brand Name:</b></label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label><b>Status:</b></label>
                <input type="text" name="status" class="form-control" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Add Brand</button>
    </form>

    <h2 class="mt-5">Brand List</h2>

    <table class="table table-bordered mt-2">
        <thead>
            <tr>
                <th>Name</th>
                <th>Status</th>
                <th width="300">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($brands as $brand)
            <tr>
                <td>{{ $brand->name }}</td>
                <td>{{ $brand->status }}</td>
                <td>

                    <!-- UPDATE -->
                    <form action="{{ route('brands.update', $brand->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="text" name="name" value="{{ $brand->name }}" required>
                        <input type="text" name="status" value="{{ $brand->status }}" required>
                        <button type="submit" class="btn btn-sm btn-warning">Update</button>
                    </form>

                    <!-- DELETE -->
                    <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<label style="font-size: 20px;">B. Monitor</label>

<div class="row mb-4">
    <div class="col-md-4">
        <label class="small font-weight-bold">Brand / Model:</label>
        <input type="text" name="b_brand" class="form-control form-control-sm">
    </div>
    <div class="col-md-4">
        <label class="small font-weight-bold">Serial / Property No.:</label>
        <input type="text" name="b_serial" class="form-control form-control-sm">
    </div>
    <div class="col-md-4">
        <label class="small font-weight-bold">Year of Acquisition:</label>
        <!-- NOTE: sa model mo ang column ay c_year -->
        <input type="text" name="c_year" class="form-control form-control-sm">
    </div>
</div>

<div class="row mb-4">
    <h4>Computer Particulars</h4>

    <!-- Hardware Status -->
    <div class="col-md-12 mb-3">
        <label class="small font-weight-bold d-block">Hardware Status</label>

        <div class="form-check form-check-inline">
            <input class="form-check-input"
                   type="radio"
                   name="ab_status"
                   value="Yes">
            <label class="form-check-label">Yes</label>
        </div>

        <div class="form-check form-check-inline">
            <input class="form-check-input"
                   type="radio"
                   name="ab_status"
                   value="No">
            <label class="form-check-label">No</label>
        </div>
    </div>

    <div class="col-md-12 mb-3">
        <label class="small font-weight-bold">Remarks / Recommendation</label>
        <textarea name="ab_status_remarks"
                  class="form-control form-control-sm"
                  rows="3"></textarea>
    </div>

    <!-- Cleanliness Checks -->
    <div class="col-md-12 mb-3">
        <label class="small font-weight-bold d-block">Cleanliness Checks</label>

        <div class="form-check form-check-inline">
            <input class="form-check-input"
                   type="radio"
                   name="ab_check"
                   value="Yes">
            <label class="form-check-label">Yes</label>
        </div>

        <div class="form-check form-check-inline">
            <input class="form-check-input"
                   type="radio"
                   name="ab_check"
                   value="No">
            <label class="form-check-label">No</label>
        </div>
    </div>

    <div class="col-md-12">
        <label class="small font-weight-bold">Remarks / Recommendation</label>
        <textarea name="ab_check_remarks"
                  class="form-control form-control-sm"
                  rows="3"></textarea>
    </div>
</div>


<label style="font-size: 20px;">C. Printer (Multi-Function)</label>

<div class="row mb-4">
    <div class="col-md-4">
        <label class="small font-weight-bold">Brand / Model:</label>
        <input type="text" name="c_brand" class="form-control form-control-sm">
    </div>
    <div class="col-md-4">
        <label class="small font-weight-bold">Serial / Property No.:</label>
        <input type="text" name="c_serial" class="form-control form-control-sm">
    </div>
    <div class="col-md-4">
        <label class="small font-weight-bold">Year of Acquisition:</label>
        <input type="text" name="c_year" class="form-control form-control-sm">
    </div>
</div>

<!-- Printer Hardware Status -->
<div class="col-md-12 mb-3">
    <label class="small font-weight-bold d-block">Hardware Status</label>

    <div class="form-check form-check-inline">
        <input class="form-check-input"
               type="radio"
               name="c_status"
               value="Yes">
        <label class="form-check-label">Yes</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input"
               type="radio"
               name="c_status"
               value="No">
        <label class="form-check-label">No</label>
    </div>
</div>

<div class="col-md-12 mb-3">
    <label class="small font-weight-bold">Remarks / Recommendation</label>
    <textarea name="c_status_remarks"
              class="form-control form-control-sm"
              rows="3"></textarea>
</div>

<!-- Printer Cleanliness -->
<div class="col-md-12 mb-3">
    <label class="small font-weight-bold d-block">Cleanliness Checks</label>

    <div class="form-check form-check-inline">
        <input class="form-check-input"
               type="radio"
               name="c_check"
               value="Yes">
        <label class="form-check-label">Yes</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input"
               type="radio"
               name="c_check"
               value="No">
        <label class="form-check-label">No</label>
    </div>
</div>

<div class="col-md-12">
    <label class="small font-weight-bold">Remarks / Recommendation</label>
    <textarea name="c_check_remarks"
              class="form-control form-control-sm"
              rows="3"></textarea>
</div>

<!-- Ink Level -->
<div class="col-md-12 mb-3">
    <label class="small font-weight-bold d-block">Ink Level</label>

    <div class="form-check form-check-inline">
        <input class="form-check-input"
               type="radio"
               name="c_level"
               value="Full">
        <label class="form-check-label">Full</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input"
               type="radio"
               name="c_level"
               value="Empty">
        <label class="form-check-label">Empty</label>
    </div>
</div>

<div class="col-md-12">
    <label class="small font-weight-bold">Remarks / Recommendation</label>
    <textarea name="c_level_remarks"
              class="form-control form-control-sm"
              rows="3"></textarea>
</div>



         <div class="mb-4">
    <div class="bg-light p-2 border mb-3">
        <h5 class="mb-0"><b>Others</b></h5>
    </div>
    
    <div class="table-responsive">
        <table class="table table-bordered table-sm" id="others-table">
            <thead class="bg-light text-uppercase small">
                <tr>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Serial / Property No.</th>
                    <th>Year of Acquisition</th>
                    <th>Remarks</th>
                    <th width="60" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>    <select id="a_type" class="form-control form-control-sm">
                            <option value="">Select Computer</option>
                            <option value="1">All-in-One</option>
                            <option value="2">Desktop</option>
                            <option value="3">Laptop</option>
                        </select></td>
                    <td><input type="text" name="others[0][brand]" class="form-control form-control-sm border-0"></td>
                    <td><input type="text" name="others[0][serial]" class="form-control form-control-sm border-0"></td>
                    <td><input type="text" name="others[0][year]" class="form-control form-control-sm border-0"></td>
                    <td><input type="text" name="others[0][remarks]" class="form-control form-control-sm border-0"></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- ADD BUTTON SA ILALIM -->
    <div class="mt-2">
        <button type="button" class="btn btn-success btn-sm" onclick="addRow()">
            + Add row
        </button>
    </div>
</div>

</div>

                </div>
                
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary px-4">Save Maintenance Report</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('css')

<style>
.save-btn-wrapper {
    margin-top: 20px;
}

/* ===== PAGE TITLE ===== */
.content-header h1 {
    font-weight: 700;
    letter-spacing: 2px;
    color: #2c3e50;
}

/* ===== MAIN CARD ===== */
.card {
    border-radius: 8px;
    border: 1px solid #dcdcdc;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}

/* ===== SECTION HEADER ===== */
.bg-light {
    background: linear-gradient(to right, #1f2d3d, #3c8dbc) !important;
    color: white !important;
    border-radius: 4px;
}

.bg-light h5 {
    font-weight: 600;
    letter-spacing: 1px;
}

/* ===== LABEL STYLE ===== */
label {
    font-size: 13px;
    letter-spacing: .5px;
    color: #34495e;
}

/* ===== INPUT STYLE ===== */
.form-control-sm {
    border-radius: 4px;
    border: 1px solid #ced4da;
    transition: 0.2s ease;
}

.form-control-sm:focus {
    border-color: #3c8dbc;
    box-shadow: 0 0 0 0.1rem rgba(60,141,188,.25);
}

/* ===== TABLE STYLE ===== */
.table thead {
    background-color: #2c3e50 !important;
    color: white;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: .5px;
}

.table-bordered td,
.table-bordered th {
    border: 1px solid #dee2e6 !important;
}

.table td {
    vertical-align: middle !important;
}

/* ===== CHECKBOX STYLE ===== */
input[type="checkbox"] {
    width: 16px;
    height: 16px;
    cursor: pointer;
}

/* ===== BUTTON STYLE ===== */
.btn-primary {
    background-color: #1f2d3d;
    border-color: #1f2d3d;
}

.btn-primary:hover {
    background-color: #3c8dbc;
    border-color: #3c8dbc;
}

.btn-success {
    background-color: #28a745;
}

.btn-danger {
    background-color: #dc3545;
}

/* ===== REMOVE INPUT BORDER SA TABLE ONLY ===== */
.table input.form-control {
    background-color: transparent;
    border: none;
    box-shadow: none;
}

/* ===== HOVER EFFECT ===== */
.table tbody tr:hover {
    background-color: #f4f6f9;
}

</style>
@stop


@section('js')
<script>
   @section('js')
<script>
@section('js')
<script>
let rowIndex = 1;

function addRow() {
    let table = document.getElementById("others-table").getElementsByTagName('tbody')[0];

    let newRow = table.insertRow();

    newRow.innerHTML = `
        <td><input type="text" name="others[${rowIndex}][name]" class="form-control form-control-sm border-0"></td>
        <td><input type="text" name="others[${rowIndex}][brand]" class="form-control form-control-sm border-0"></td>
        <td><input type="text" name="others[${rowIndex}][serial]" class="form-control form-control-sm border-0"></td>
        <td><input type="text" name="others[${rowIndex}][year]" class="form-control form-control-sm border-0"></td>
        <td><input type="text" name="others[${rowIndex}][remarks]" class="form-control form-control-sm border-0"></td>
        <td class="text-center">
            <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>
        </td>
    `;

    rowIndex++;
}

function removeRow(button) {
    button.closest("tr").remove();
}
</script>
@stop

</script>
@stop

</script>
@stop