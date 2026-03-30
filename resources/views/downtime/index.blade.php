@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-body">
        <button class="btn btn-primary mb-3" onclick="adddowntime()">Downtime</button>

        <h1><i class="fa-duotone fa-thin fa-layer"></i> Downtime Records</h1>
        <table id="category-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                      <th>System/System</th>
                    <th>Description Error</th>
                    <th>Start<br>Date & Time</br></th>
                      <th>End<br>Date & Time</br></th>
                      <th>Remarks</th>
                         <th>Actions</th>
                </tr>
            </thead>
            <tbody id="downtime_tbody">

            </tbody>
        </table>
    </div>
</div>
@endsection

<div class="modal fade bs-example-modal-lg" id="downtimeModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title">Title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="downtimeForm">
                    @csrf
                    <div class="row">
                        <input type="hidden" id="downtime_id" name="downtime_id">
                        <div class="col-md-12">
                            <label for="description">System/Server</label>
                            <select type="text" class="form-control" id="system_id" name="system_id" required>
                             </select>
                            <label for="description">Description/Error</label>
                            <input type="text" class="form-control" id="description" name="description" required>
                             <label for="start">Start</label>
                            <input type="text" class="form-control" id="start" name="start" required>
                             <label for="end">End</label>
                            <input type="text" class="form-control" id="end" name="end" required>
                            <label for="remarks">Remarks</label>
                            <input type="text" class="form-control" id="remarks" name="remarks" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect text-left" onclick="savedowntime()">Save</button>
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
window.onload = function () {
    fetchdowntime();
};

// OPEN MODAL FOR ADD
function adddowntime() {
      $('#modal-title').text('Add ');
    $('#downtimeForm')[0].reset();
    $('#downtime_id').val('');
    $('#downtimeModal').modal('show');
$.ajax({
url:"{{route('system_server.fetch')}}",
method:'POST',
data: {
    _token:"{{csrf_token()}}"
},
success:function(categories){
    $('#system_id').empty();
    console.log(categories);
        $('#system_id ').append(`<option value="">Select System</option>`); 
    $.each(categories, function(index, category) {
        $('#system_id').append(`<option value="${category.id}">${category.description}</option>`);
    });
}
});
}

function fetchdowntime() {
    $('#downtime_tbody').empty();

    $.ajax({
        url: "{{ route('downtime.fetch') }}",
        method: 'POST',
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function (response) {

            $.each(response, function (index, data) {
                $('#downtime_tbody').append(`
                    <tr>
                        <td>${index + 1}</td>
                        <td>${data.category.system_id}</td>
                        <td>${data.description}</td>
                         <td>${data.start}</td>
                          <td>${data.end}</td>
                           <td>${data.remarks}</td>
                        <td>
                            <button class="btn btn-sm btn-info"
                                onclick="editdowntime('${data.id}')">
                                Edit
                            </button>
                            <button class="btn btn-sm btn-danger"
                                onclick="deletedowntime('${data.id}')">
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
function savedowntime(){

    let system_id = $('#system_id').val().trim();
    let description = $('#description').val().trim();
    let start = $('#start').val().trim();
    let end = $('end').val().trim();
    let remarks = $('#remarks').val().trim();

      $('#downtimeModal').modal('show');

    // ✅ FRONTEND VALIDATION
    if (system_id === "") {
        toastr.error("System: is required.");
        return;
    }

    if (description === "") {
        toastr.error("Description   : is required.");
        return;
    }

    if (start === "") {
        toastr.error("start   : is required.");
        return;
    }
     if (end === "") {
        toastr.error("end  : is required.");
        return;
    }

    var formData = $('#downtimeForm').serialize();

    $.ajax({
        url: "{{ route('downtime.save') }}",
        method: 'POST',
        data: formData,
        success: function(response) {
            $('#downtimeModal').modal('hide');

            if(response.status == 'true') {
                toastr.success('Downtime Records saved successfully!', 'Success');
            } else {
                toastr.error('Failed to save Downtime.', 'Error');
            }

            fetchdowntime();
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
function editdowntime(id) {

    $.ajax({
        url: "{{ route('downtime.info') }}",
        method: 'POST',
        data: {
            _token: "{{ csrf_token() }}",
            downtime_id: id
        },
        success: function (response) {

            $('#modal-title').text('Edit Sub Category');
            $('#downtime_id').val(response.id);
            $('#system_id').val(response.system_id);
            $('#name').val(response.description);
              $('#start').val(response.start);
                    $('#end').val(response.end);
                          $('#remarks').val(response.remarks);
            $('#downtimeModal').modal('show');
        },
        error: function (xhr) {
            console.error(xhr.responseText);
        }
    });
}

// DELETE
function deletedowntime(id) {
        if (confirm('Are you sure you want to delete this Records?')) {
            $.ajax({
                url: "{{ route('downtime.delete') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    system_id: id
                },
                success: function(response) {
                    console.log(response);
                    if(response.status == 'true') {
                        toastr.success('Downtime Records deleted successfully!', 'Success');
                    } else {
                        toastr.error('Failed to delete Records', 'Error');
                    }
                    fetchdowntime(); // Refresh the sub category list
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

    
}
</script>