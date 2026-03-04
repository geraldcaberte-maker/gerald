@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-body">
        <button class="btn btn-primary mb-3" onclick="addequipment()">Add Equipment Type</button>

        <h1><i class="fa-duotone fa-thin fa-layer"></i> Equipment Types</h1>
        <table id="category-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                      <th>Status</th>
                    <th>category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="equipment_type_tbody">

            </tbody>
        </table>
    </div>
</div>
@endsection

<div class="modal fade bs-example-modal-lg" id="equipmentTypeModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title">Title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="equipmentTypeForm">
                    @csrf
                    <div class="row">
                        <input type="hidden" id="equipment_type_id" name="equipment_type_id">
                        <div class="col-md-12">
                            <label for="status">Status</label>
                            <input type="text" class="form-control" id="status" name="status" required>
                            <label for="category">category</label>
                            <input type="text" class="form-control" id="category" name="category" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect text-left" onclick="saveEquipmentType()">Save</button>
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
window.onload = function () {
    fetchEquipmentTypes();
};

// OPEN MODAL FOR ADD
function addequipment() {
    $('#modal-title').text('Add Equipment Type');
    $('#equipmentTypeForm')[0].reset();
    $('#equipment_type_id').val('');
    $('#equipmentTypeModal').modal('show');
}

// FETCH DATA
function fetchEquipmentTypes() {
    $('#equipment_type_tbody').empty();

    $.ajax({
        url: "{{ route('equipment_type.fetch') }}",
        method: 'POST',
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function (response) {

            $.each(response, function (index, category) {
                $('#equipment_type_tbody').append(`
                    <tr>
                        <td>${index + 1}</td>
                        <td>${category.status}</td>
                        <td>${category.category}</td>
                        <td>
                            <button class="btn btn-sm btn-info"
                                onclick="editEquipmentType('${category.id}')">
                                Edit
                            </button>
                            <button class="btn btn-sm btn-danger"
                                onclick="deleteEquipmentType('${category.id}')">
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
function saveEquipmentType(){

    let status = $('#status').val().trim();
    let category = $('#category').val().trim();

      $('#equipmentTypeModal').modal('show');

    // ✅ FRONTEND VALIDATION
    if (status === "") {
        toastr.error("Status: is required.");
        return;
    }

    if (status=== "") {
        toastr.error("Status: is required.");
        return;
    }

    if (category === "") {
        toastr.error("Category: is required.");
        return;
    }

    var formData = $('#equipmentTypeForm').serialize();

    $.ajax({
        url: "{{ route('equipment_type.save') }}",
        method: 'POST',
        data: formData,
        success: function(response) {
            $('#equipmentTypeModal').modal('hide');

            if(response.status == 'true') {
                toastr.success('Equipment Type saved successfully!', 'Success');
            } else {
                toastr.error('Failed to save equipment type.', 'Error');
            }

            fetchEquipmentTypes();
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
function editEquipmentType(id) {

    $.ajax({
        url: "{{ route('equipment_type.info') }}",
        method: 'POST',
        data: {
            _token: "{{ csrf_token() }}",
            equipment_type_id: id
        },
        success: function (response) {

            $('#modal-title').text('Edit Equipment Type');
            $('#equipment_type_id').val(response.id);
            $('#status').val(response.status);
            $('#category').val(response.category);
            $('#name').val(response.description);

            $('#equipmentTypeModal').modal('show');
        },
        error: function (xhr) {
            console.error(xhr.responseText);
        }
    });
}

// DELETE
function deleteEquipmentType(id) {
        if (confirm('Are you sure you want to delete this equipment type?')) {
            $.ajax({
                url: "{{ route('equipment_type.delete') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    equipment_type_id: id
                },
                success: function(response) {
                    console.log(response);
                    if(response.status == 'true') {
                        toastr.success('Equipment Type deleted successfully!', 'Success');
                    } else {
                        toastr.error('Failed to delete equipment type.', 'Error');
                    }
                    fetchEquipmentTypes(); // Refresh the equipment type list
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

        function fetchEquipmentTypes() {
        $('#equipment_type_tbody').empty();
        $.ajax({
            url: "{{ route('equipment_type.fetch') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log(response);
                $('#equipment_type_tbody').html(response);
                $.each(response, function(index, equipment_type) {
                    $('#equipment_type_tbody').append(
                        `<tr>
                            <td>${index + 1}</td>
                            <td>${equipment_type.description}</td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="editEquipmentType('${equipment_type.id}')">Edit</button>
                                <button class="btn btn-sm btn-danger" onclick="deleteEquipmentType('${equipment_type.id}')">Delete</button>
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