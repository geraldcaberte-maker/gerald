@extends('layouts.app')
@section('content')

<h2> Add type of error </h2>
<button class="btn btn-primary mb-4 same-btn" onclick="addtype_error()">Add</button>

<div class="card">
      
    <div class="card-body">
     
        <h1>Computer </h1>
        <table id="categories-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="type_error_tbody">

            </tbody>
        </table>
    </div>

    <div class="modal fade bs-example-modal-lg" id="type_errorModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title">Types of Error</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="categoryForm">
                    @csrf
                    <div class="row">
                        <input type="hidden" id="type_error_id" name="type_error_id">
                        <div class="col-md-12">
                            <label for="description"> Description</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect text-left" onclick="savetype_error()">Save</button>
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
    <!-- /.modal-dialog -->
</div>
</div>
@stop
<script>
    window.onload = function() {
        fetchCategories();
    };
  
    function addtype_error() {
        $('#modal-title').text('types or Error');
         $('#type_error_id').val('');
         $('#name').val('');
        $('#type_errorModal').modal('show');
    }
 function fetchCategories() {
        $('#type_error_tbody').empty();
        $.ajax({
            url: "{{ route('type_error.fetch') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log(response);
                $('#type_error_tbody').html(response);
                $.each(response, function(index, category) {
                    $('#type_error_tbody').append(
                        `<tr>
                            <td>${index + 1}</td>
                            <td>${category.description}</td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="editCategory('${category.id}')">Edit</button>
                                <button class="btn btn-sm btn-danger" onclick="deleteCategory('${category.id}')">Delete</button>
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
function savetype_error() {

    let name = $('#name').val().trim();

    // ✅ FRONTEND VALIDATION
    if (name === "") {
        toastr.error("type or Error  is required.");
        return;
    }

    var formData = $('#categoryForm').serialize();

    $.ajax({
        url: "{{ route('type_error.save') }}",
        method: 'POST',
        data: formData,
        success: function(response) {
            $('type_errorModal').modal('hide');

            if(response.status == 'true') {
                toastr.success('Types of Error saved successfully!', 'Success');
            } else {
                toastr.error('Failed to save category.', 'Error');
            }
  fetchCategories();
            
        },
        error: function(xhr) {

            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;

                Object.keys(errors).forEach(function(key) {
                    toastr.error(errors[key][0]);
                });
            } else {
                console.error(xhr.responseText);
            }
        }
    });
  
}

    function editCategory(id) {
        $.ajax({
            url: "{{ route('type_error.info') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                type_error_id: id
            },
            success: function(response) {
                console.log(response);
                $('#modal-title').text('Edit Category');
                $('#type_error_id').val(response.id);
                $('#name').val(response.description);
                $('#type_errorModal').modal('show');
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }

    function deleteCategory(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "This record will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
    
            if (result.isConfirmed) {

            $.ajax({
                url: "{{ route('type_error.delete') }}",
                method: 'POST',
                data: {
                   type_error_id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {

                    if(response.status == 'true') {
                        toastr.success('Deleted successfully!', 'Success');
                    } else {
                        toastr.error('Delete failed.', 'Error');
                    }

                    fetchCategories();
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });

        }

    });
    }




    
</script>