@extends('layouts.app')


@section('content')
<button class="btn btn-primary mb-4 same-btn" onclick="addCategory()">Add form</button>
  
   {{--  COMPUTER display--}}
<div class="card">
      
    <div class="table-responsive" >
     
        <h1>Monitoring </h1>
        <table class="table table-bordered table-striped" id="categories-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>System</th>
                    <th>Error</th>
                    <th>Requirments</th>
                    <th>Raised By</th>
                   <th>Office</th>
                    <th>Module</th>
                    <th>Action Taken</th>
                      <th>Update Status</th>
                    <th>Target Date Start</th>
                    <th>Target Date End</th>
                      <th>Status</th>
                    <th>Date Accomplished</th>
                    <th>Date Reviewed</th>
                      <th>Upload Date</th>
                    <th>Back-up Date</th>
                    <th>Back-up Location</th>
                      <th>File link</th>
                    <th>Remakrs</th>
                </tr>
            </thead>
            <tbody id="category_tbody">

            </tbody>
        </table>
    </div>
</div>
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
                        <input type="hidden" id="eac_id" name="eac_id">
                        <div class="col-md-12">
                            <label for="description"> Date</label>
                            <input type="date" class="form-control" id="Date" name="Date" required>
                              <label for="system">System</label>
                            <select class="form-control" id="system_id" name="system_id" required>
                            <option value="">Select option</option>
                            <option value="VRS">VRS</option>
                            <option value="feedback portal">Feedback Portal</option>
                            </select>
                         <label for ="error">Type of Error</label>
                            <select class="form-control" id="type_error" name="type_error" required>
                           <option  value="">Select option</option>
                                <option value="404">404</option>
                                  <option  value="504">504</option>
                            </select>
                       <label for="requirments">Requirments </label>
                            <input type="text" class="form-control" id="requirments" name="requirments" required>
                        <label for="raised">Raised By</label>
                            <select class="form-control" id="raised_by" name="raised_by" required>
                             <option value="reymark" >reymark</option>
                            </select>
                        <label for="office">Office</label>
                            <select  class="form-control" id="office" name="office" required>
                                    <option  value="DICT">DICT</option>
                            </select>
                         <label for="module">Module</label>
                            <input type="text" class="form-control" id="module" name="module" required>
                         <label for="action">Action Taken</label>
                            <input type="text" class="form-control" id="action" name="action" required>
                         <label for="updatestatus">Update Status</label>
                            <input type="text" class="form-control" id="update_status" name="update_status" required>
                         <label for="targetdatestart">Target Date start</label>
                            <input type="date" class="form-control" id="target_start" name="target_start" required>
                         <label for="targetend">Target End</label>
                            <input type="date" class="form-control" id="target_end" name="target_end" required>
                           <label for="status">Status</label>
                            <input type="text" class="form-control" id="status" name="status" required>
                           <label for="dateaccomplished">Date Accomplished</label>
                            <input type="date" class="form-control" id="date_accomplished" name="date_accomplished" required>
                           <label for="datereviewed">Date Reviewed</label>
                            <input type="date" class="form-control" id="date_reviewed" name="date_reviewed" required>
                            <label for="uploaddate">Upload Date</label>
                            <input type="date" class="form-control" id="upload_date" name="upload_date" required>
                            <label for="backupdate">Backup Date</label>
                            <input type="date" class="form-control" id="backup_date" name="backup_date" required>
                            <label for="backuplocation">Backup Location</label>
                            <input type="text" class="form-control" id="backup_location" name="backup_location" required>
                            <label for="filelink">File link</label>
                            <input type="text" class="form-control" id="filelink" name="filelink" required>
                            <label for="remarks">Remarks</label>
                            <input type="text" class="form-control" id="remarks" name="remarks" required>
                          </div>
                    </div>
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect text-left" onclick="saveCategory()">Save</button>
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>

    </div>
  


@stop
<script>
     window.onload = function() {
        fetchCategories();
    };
  
function addCategory() {
   $('#modal-title').text('Error and Concern');
         $('#eac_id').val('');
         $('#Date').val('');
        $('#categoryModal').modal('show');
        
     
$.ajax({
url:"{{route('type_error.fetch')}}",
method:'POST',
data: {
    _token:"{{csrf_token()}}"
},
success:function(categories){
    $('#type_error').empty();
    console.log(categories);
        $('#type_error').append(`<option value="">Select Category</option>`); 
    $.each(categories, function(index, category) {
        $('#type_error').append(`<option value="${category.id}">${category.description}</option>`);
    });
}
});
}
 
    function fetchCategories() {
        $('#category_tbody').empty();
        $.ajax({
            url: "{{ route('error_and_concern.fetch') }}",
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
                            <td>${category.Date}</td>
                              <td>${category.system_id}</td>
                                <td>${category.type_error}</td>
                                  <td>${category.requirments}</td>
                                    <td>${category.raised_by}</td>
                                      <td>${category.office}</td>
                                        <td>${category.module}</td>
                                          <td>${category.action}</td>
                                            <td>${category.update_status}</td>
                                              <td>${category.target_start}</td>
                                                <td>${category.target_end}</td>
                                                  <td>${category.status}</td>
                                                    <td>${category.date_accomplished}</td>
                                                      <td>${category.date_reviewed}</td>
                                                        <td>${category.upload_date}</td>
                                                          <td>${category.backup_date}</td>
                                                            <td>${category.backup_location}</td>
                                                              <td>${category.filelink}</td>
                                                                <td>${category.remarks}</td>
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

  function saveCategory() {

    let Date = $('#Date').val().trim();
  


    // ✅ FRONTEND VALIDATION
    if (Date === "") {
        toastr.error("Date name is required.");
        return;
    }

    var formData = $('#categoryForm').serialize();

    $.ajax({
        url: "{{ route('error_and_concern.save') }}",
        method: 'POST',
        data: formData,
        success: function(response) {
            $('#categoryModal').modal('hide');

            if(response.status == 'true') {
                toastr.success('error and concern  saved successfully!', 'Success');
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
            url: "{{ route('error_and_concern.info') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                eac_id: id
            },
            success: function(response) {
                console.log(response);
                $('#modal-title').text('Edit Category');
                $('#eac_id').val(response.id);
                $('#Date').val(response.description);
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
                url: "{{ route('error_and_concern.delete') }}",
                method: 'POST',
                data: {
                    eac_id: id,
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