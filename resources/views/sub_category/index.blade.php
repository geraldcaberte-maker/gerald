@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-body">
        <button class="btn btn-primary mb-3" onclick="addSubCategory()">Add Sub Category</button>

        <h1><i class="fa-duotone fa-thin fa-layer"></i> Sub Categories</h1>
        <table id="category-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                      <th>category_id</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="sub_category_tbody">

            </tbody>
        </table>
    </div>
</div>
@endsection

<div class="modal fade bs-example-modal-lg" id="sub_CategoryModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title">Title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="sub_CategoryForm">
                    @csrf
                    <div class="row">
                        <input type="hidden" id="sub_category_id" name="sub_category_id">
                        <div class="col-md-12">
                            <label for="description">category ID</label>
                            <select type="text" class="form-control" id="category_id" name="category_id" required>
                             </select>
                            <label for="description">Description</label>
                            <input type="text" class="form-control" id="description" name="description" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect text-left" onclick="saveSubCategory()">Save</button>
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
window.onload = function () {
    fetchSubCategories();
};

// OPEN MODAL FOR ADD
function addSubCategory() {
      $('#modal-title').text('Add ');
    $('#sub_CategoryForm')[0].reset();
    $('#sub_category_id').val('');
    $('#sub_CategoryModal').modal('show');
$.ajax({
url:"{{route('category.fetch')}}",
method:'POST',
data: {
    _token:"{{csrf_token()}}"
},
success:function(categories){
    $('#category_id').empty();
    console.log(categories);
        $('#category_id ').append(`<option value="">Select Category</option>`); 
    $.each(categories, function(index, category) {
        $('#category_id').append(`<option value="${category.id}">${category.description}</option>`);
    });
}
});
}

function fetchSubCategories() {
    $('#sub_category_tbody').empty();

    $.ajax({
        url: "{{ route('sub_category.fetch') }}",
        method: 'POST',
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function (response) {

            $.each(response, function (index, data) {
                $('#sub_category_tbody').append(`
                    <tr>
                        <td>${index + 1}</td>
                        <td>${data.category.description}</td>
                        <td>${data.description}</td>
                        <td>
                            <button class="btn btn-sm btn-info"
                                onclick="editSubCategory('${data.id}')">
                                Edit
                            </button>
                            <button class="btn btn-sm btn-danger"
                                onclick="deleteSubCategory('${data.id}')">
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
function saveSubCategory(){

    let category_id = $('#category_id').val().trim();
    let description = $('#description').val().trim();

      $('#sub_CategoryModal').modal('show');

    // ✅ FRONTEND VALIDATION
    if (category_id === "") {
        toastr.error("Category ID: is required.");
        return;
    }

    if (description === "") {
        toastr.error("Description   : is required.");
        return;
    }

    if (description === "") {
        toastr.error("Description   : is required.");
        return;
    }

    var formData = $('#sub_CategoryForm').serialize();

    $.ajax({
        url: "{{ route('sub_category.save') }}",
        method: 'POST',
        data: formData,
        success: function(response) {
            $('#sub_CategoryModal').modal('hide');

            if(response.status == 'true') {
                toastr.success('Sub Category saved successfully!', 'Success');
            } else {
                toastr.error('Failed to save sub category.', 'Error');
            }

            fetchSubCategories();
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
function editSubCategory(id) {





    $.ajax({
        url: "{{ route('sub_category.info') }}",
        method: 'POST',
        data: {
            _token: "{{ csrf_token() }}",
            sub_category_id: id
        },
        success: function (response) {

            $('#modal-title').text('Edit Sub Category');
            $('#sub_category_id').val(response.id);
            $('#category_id').val(response.category_id);
            $('#name').val(response.description);

            $('#sub_CategoryModal').modal('show');
  $('#category_id').empty();
    console.log(categories);
        $('#category_id ').append(`<option value="">Select Category</option>`); 
    $.each(categories, function(index, category) {
        $('#category_id').append(`<option value="${category.id}">${category.description}</option>`);
    });


        },
        error: function (xhr) {
            console.error(xhr.responseText);
        }
    });
}

// DELETE
function deleteSubCategory(id) {
        if (confirm('Are you sure you want to delete this sub category?')) {
            $.ajax({
                url: "{{ route('sub_category.delete') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    sub_category_id: id
                },
                success: function(response) {
                    console.log(response);
                    if(response.status == 'true') {
                        toastr.success('Sub Category deleted successfully!', 'Success');
                    } else {
                        toastr.error('Failed to delete sub category.', 'Error');
                    }
                    fetchSubCategories(); // Refresh the sub category list
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

    
}
</script>