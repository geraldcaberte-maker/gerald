@extends('layouts.app')
@section('content')
 <button class="btn btn-primary mb-4 same-btn" onclick="addResponse()">Conduct PMS</button>
<div class="card">
      
    <div class="card-body">
     
        <h1>Computer </h1>
        <table id="responses-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Status</th>
                    <th>Remarks</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="response_tbody">

            </tbody>
        </table>
    </div>
</div>
   @endsection

<div class="modal fade bs-example-modal-lg" id="responseModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
   <h1><i class="fa-duotone fa-thin fa-layer"></i> Response Record</h1>
   <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title">Response</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="responseForm">
                    @csrf
                    <div class="row">
                        <input type="hidden" id="response" name="response">
                        <div class="col-md-12">
                            <label for="nameID">Name/ID</label>
                            <input type="text" class="form-control" id="question_id" name="question_id" required>
                            <label for="status"> Status</label>
                            <input type="text" class="form-control" id="status" name="status" required>
                            <label for="remarks"> Remarks</label>
                            <input type="text" class="form-control" id="remarks" name="remarks" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect text-left" onclick="saveResponse()">Save</button>
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
  function saveResponse() {

    let question_id = $('#question_id').val().trim();
    let status = $('#status').val().trim();
    let remarks = $('#remarks').val().trim();

    // ✅ FRONTEND VALIDATION
    if (question_id=== "") {
        toastr.error("Name/ID is required.");
        return;
    }

    var formData = $('#responseForm').serialize();

    $.ajax({
        url: "{{ route('response.save') }}",
        method: 'POST',
        data: formData,
        success: function(response) {
            $('#responseModal').modal('hide');

            if(response.status == 'true') {
                toastr.success('Response saved successfully!', 'Success');
            } else {
                toastr.error('Failed to save response.', 'Error');
            }

            fetchResponses();
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
    function addResponse() {
        $('#modal-title').text('Computer (Response)');
         $('#response_id').val('');
         $('#question_id').val('');
         $('#status').val('');
         $('#remarks').val('');
        $('#responseModal').modal('show');
    }

    
    function fetchResponses() {
        $('#response_tbody').empty();
        $.ajax({
            url: "{{ route('response.fetch') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log(response);
                $('#response_tbody').html(response);
                $.each(response, function(index, response) {
                    $('#response_tbody').append(
                        `<tr>
                            <td>${index + 1}</td>
                            <td>${response.question_id}</td>
                            <td>${response.status}</td>
                            <td>${response.remarks}</td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="editResponse('${response.id}')">Edit</button>
                                <button class="btn btn-sm btn-danger" onclick="deleteResponse('${response.id}')">Delete</button>
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
//save response
  function saveResponse() {

    let response_id = $('#question_id').val().trim();
    let status = $('#status').val().trim();
    let remarks = $('#remarks').val().trim();

    // ✅ FRONTEND VALIDATION
    if (response_id === "") {
        toastr.error("question ID is required.");
        return;
    }

    var formData = $('#responseForm').serialize();

    $.ajax({
        url: "{{ route('response.save') }}",
        method: 'POST',
        data: formData,
        success: function(response) {
            $('#responseModal').modal('hide');

            if(response.status == 'true') {
                toastr.success('Response saved successfully!', 'Success');
            } else {
                toastr.error('Failed to save response.', 'Error');
            }

            fetchResponses();
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


    function editResponse(id) {
        $.ajax({
            url: "{{ route('response.info') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                response_id: id
            },
            success: function(response) {
                console.log(response);
                $('#modal-title').text('Edit Response');
                $('#ques_id').val(response.question_id);
                $('#status').val(response.status);
                $('#remarks').val(response.remarks);
                $('#responseModal').modal('show');
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }
    function deleteResponse(id) {
        if (confirm('Are you sure you want to delete this response?')) {
            $.ajax({
                url: "{{ route('response.delete') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    response_id: id
                },
                success: function(response) {
                    console.log(response);
                    if(response.status == 'true') {
                        toastr.success('Response deleted successfully!', 'Success');
                    } else {
                        toastr.error('Failed to delete response.', 'Error');
                    }
                    fetchResponses(); // Refresh the response list
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }
}
</script>   