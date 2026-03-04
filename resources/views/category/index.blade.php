
@extends('layouts.app')


@section('content')


<button class="btn btn-primary mb-4 same-btn" onclick="addCategory()">Add Category</button>
  
   {{--  COMPUTER display--}}
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
            <tbody id="category_tbody">

            </tbody>
        </table>
    </div>
</div>

@endsection

{{--category modal--}}
<div class="modal fade bs-example-modal-lg" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title">Computer</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="categoryForm">
                    @csrf
                    <div class="row">
                        <input type="hidden" id="category_id" name="category_id">
                        <div class="col-md-12">
                            <label for="description"> Category</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect text-left" onclick="saveCategory()">Save</button>
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
    <!-- /.modal-dialog -->
</div>
<style>
.same-btn {
        width: 320px;
    }
</style>
<script>
    window.onload = function() {
        fetchCategories();
    };
  
    function addCategory() {
        $('#modal-title').text('Computer (Category)');
         $('#category_id').val('');
         $('#name').val('');
        $('#categoryModal').modal('show');
    }

    
    function fetchCategories() {
        $('#category_tbody').empty();
        $.ajax({
            url: "{{ route('category.fetch') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log(response);
                $('#category_tbody').html(response);
                $.each(response, function(index, category) {
                    $('#category_tbody').append(
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
//save category
  function saveCategory() {

    let name = $('#name').val().trim();

    // ✅ FRONTEND VALIDATION
    if (name === "") {
        toastr.error("Category name is required.");
        return;
    }

    var formData = $('#categoryForm').serialize();

    $.ajax({
        url: "{{ route('category.save') }}",
        method: 'POST',
        data: formData,
        success: function(response) {
            $('#categoryModal').modal('hide');

            if(response.status == 'true') {
                toastr.success('Category saved successfully!', 'Success');
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
            url: "{{ route('category.info') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                category_id: id
            },
            success: function(response) {
                console.log(response);
                $('#modal-title').text('Edit Category');
                $('#category_id').val(response.id);
                $('#name').val(response.description);
                $('#categoryModal').modal('show');
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
                url: "{{ route('category.delete') }}",
                method: 'POST',
                data: {
                    category_id: id,
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