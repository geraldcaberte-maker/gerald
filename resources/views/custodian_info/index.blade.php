@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-body">
        <button class="btn btn-primary mb-3" onclick="addCustodian()">Add Custodian</button>

        <h1><i class="fa-duotone fa-thin fa-layer"></i> Custodians</h1>
        <table id="category-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                      <th>user_id</th>
                    <th>brand</th>
                    <th>model</th>
                    <th>type</th>
                    <th>serial_number</th>
                    <th>mac-address</th>
                    <th>ip-address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="custodian_tbody">

            </tbody>
        </table>
    </div>
</div>
@endsection

<div class="modal fade bs-example-modal-lg" id="custodianModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title">Title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="custodianForm">
                    @csrf
                    <div class="row">
                        <input type="hidden" id="custodian_id" name="custodian_id">
                        <div class="col-md-12">
                            <label for="user_id">user_id</label>
                            <input type="text" class="form-control" id="user_id" name="user_id" required>
                            <label for="brand">brand</label>
                            <input type="text" class="form-control" id="brand" name="brand" required>
                            <label for="model">model</label>
                            <input type="text" class="form-control" id="model" name="model" required>
                            <label for="type">type</label>
                            <input type="text" class="form-control" id="type" name="type" required>
                            <label for="serial_number">serial_number</label>
                            <input type="text" class="form-control" id="serial_number" name="serial_number" required>
                            <label for="mac_address">mac-address</label>
                            <input type="text" class="form-control" id="mac_address" name="mac_address" required>
                            <label for="ip_address">ip-address</label>
                            <input type="text" class="form-control" id="ip_address" name="ip_address" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect text-left" onclick="saveCustodian()">Save</button>
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
window.onload = function () {
    fetchCustodians();
};

// OPEN MODAL FOR ADD
function addCustodian() {
    $('#modal-title').text('Add Custodian');
    $('#custodianForm')[0].reset();
    $('#custodian_id').val('');
    $('#custodianModal').modal('show');
}

// FETCH DATA
function fetchCustodians() {
    $('#custodian_tbody').empty();

    $.ajax({
        url: "{{ route('custodian_info.fetch') }}",
        method: 'POST',
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function (response) {

            $.each(response, function (index, custodian) {
                $('#custodian_tbody').append(`
                    <tr>
                        <td>${index + 1}</td>
                        <td>${custodian.user_id}</td>
                        <td>${custodian.brand}</td>
                        <td>${custodian.model}</td>
                        <td>${custodian.type}</td>
                        <td>${custodian.serial_number}</td>
                        <td>${custodian.mac_address}</td>
                        <td>${custodian.ip_address}</td>
                        <td>
                            <button class="btn btn-sm btn-info"
                                onclick="editCustodian('${custodian.id}')">
                                Edit
                            </button>
                            <button class="btn btn-sm btn-danger"
                                onclick="deleteCustodian('${custodian.id}')">
                                Delete
                            </button>
                        </td>
                    </tr>
                `);
            });
        },
        error: function (xhr) {
            console.error(xhr.responseText);
        }
    });
}

// SAVE (ADD + UPDATE)
function saveCustodian(){

    let user_id = $('#user_id').val().trim();
    let brand = $('#brand').val().trim();
    let model = $('#model').val().trim();
    let type = $('#type').val().trim();
    let serial_number = $('#serial_number').val().trim();
    let mac_address = $('#mac_address').val().trim();
    let ip_address = $('#ip_address').val().trim();

      $('#custodianModal').modal('show');

    // ✅ FRONTEND VALIDATION
    if (user_id === "") {
        toastr.error("User ID: is required.");
        return;
    }

    if (brand === "") {
        toastr.error("Brand   : is required.");
        return;
    }

    if (model === "") {
        toastr.error("Model   : is required.");
        return;
    }
    if (type === "") {
        toastr.error("Type   : is required.");
        return;
    }
    if (serial_number === "") {
        toastr.error("Serial Number   : is required.");
        return;
    }
    if (mac_address === "") {
        toastr.error("MAC Address   : is required.");
        return;
    }
    if (ip_address === "") {
        toastr.error("IP Address   : is required.");
        return;
    }

    var formData = $('#custodianForm').serialize();

    $.ajax({
        url: "{{ route('custodian_info.save') }}",
        method: 'POST',
        data: formData,
        success: function(response) {
            $('#custodianModal').modal('hide');

            if(response.status == 'true') {
                toastr.success('Custodian saved successfully!', 'Success');
            } else {
                toastr.error('Failed to save custodian.', 'Error');
            }

            fetchCustodians();
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;

                Object.keys(errors).forEach(function(key) {
                    toastr.error(errors[key][0]);
                });
            }
        }
    });
}

// EDIT
function editCustodian(id) {

    $.ajax({
        url: "{{ route('custodian_info.info') }}",
        method: 'POST',
        data: {
            _token: "{{ csrf_token() }}",
            custodian_id: id
        },
        success: function (response) {

            $('#modal-title').text('Edit Custodian');
            $('#custodian_id').val(response.id);
            $('#user_id').val(response.user_id);
            $('#brand').val(response.brand);
            $('#model').val(response.model);
            $('#type').val(response.type);
            $('#serial_number').val(response.serial_number);
            $('#mac_address').val(response.mac_address);
            $('#ip_address').val(response.ip_address);
            $('#name').val(response.description);

            $('#custodianModal').modal('show');
        },
        error: function (xhr) {
            console.error(xhr.responseText);
        }
    });
}

// DELETE
function deleteCustodian(id) {
        if (confirm('Are you sure you want to delete this custodian?')) {
            $.ajax({
                url: "{{ route('custodian_info.delete') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    custodian_info_id: id
                },
                success: function(response) {
                    console.log(response);
                    if(response.status == 'true') {
                        toastr.success('Custodian deleted successfully!', 'Success');
                    } else {
                        toastr.error('Failed to delete custodian.', 'Error');
                    }
                    fetchCustodians(); // Refresh the custodian list
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

        function fetchCustodians() {
        $('#custodian_tbody').empty();
        $.ajax({
            url: "{{ route('custodian_info.fetch') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log(response);
                $('#custodian_tbody').html(response);
                $.each(response, function(index, custodian_info) {
                    $('#custodian_tbody').append(
                        `<tr>
                            <td>${index + 1}</td>
                            <td>${custodian_info.description}</td>
                    
                            <td>
                                <button class="btn btn-sm btn-info" onclick="editCustodian('${custodian_info.id}')">Edit</button>
                                <button class="btn btn-sm btn-danger" onclick="deleteCustodian('${custodian_info.id}')">Delete</button>
                            </td>
                        </tr>`
                    );
                });
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }
}
</script>