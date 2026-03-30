@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-body">
        <button class="btn btn-primary mb-3" onclick="addserver()">Add System/server</button>

        <h1><i class="fa-duotone fa-thin fa-layer"></i> System / Server</h1>
        <table id="category-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                      <th>System/Server</th>
             
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="server_tbody">

            </tbody>
        </table>
    </div>
</div>
@endsection

<div class="modal fade bs-example-modal-lg" id="serverModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title">Title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="server_Form">
                    @csrf
                    <div class="row">
                        <input type="hidden" id="system_server_id" name="system_server_id">
                        <div class="col-md-12">
                            <label for="description">System/Server</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                             
                          
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect text-left" onclick="saveserver()">Save</button>
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
window.onload = function () {
    fetchsystem_server();
};

// OPEN MODAL FOR ADD
function addserver() {
      $('#modal-title').text('Add ');
       $('#system_server_id').val('');
    $('#serverModal').modal('show');
   $('#name').val('');
 
}
function fetchsystem_server() {
    $('#server_tbody').empty();

    $.ajax({
        url: "{{ route('system_server.fetch') }}",
        method: 'POST',
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function (response) {
              console.log(response);
            //    $('#server_tbody').html(response);
            $.each(response, function (index, catergory) {
           
                $('#server_tbody').append(`
                    <tr>
                        <td>${index + 1}</td>
                        <td>${catergory.system_server}</td>
                    
                        <td>
                            <button class="btn btn-sm btn-info"
                                onclick="editserver('${catergory.id}')">
                                Edit
                            </button>
                            <button class="btn btn-sm btn-danger"
                                onclick="deleteserver('${catergory.id}')">
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
function saveserver(){

    let name = $('#name').val().trim();



    // ✅ FRONTEND VALIDATION
    if (name === "") {
        toastr.error("system_server is required.");
        return;
    }


    var formData = $('#server_Form').serialize();

    $.ajax({
        url: "{{ route('system_server.save') }}",
        method: 'POST',
        data: formData,
        success: function(response) {
            $('#serverModal').modal('hide');

            if(response.status == 'true') {
                toastr.success('System Server saved successfully!', 'Success');
            } else {
                toastr.error('Failed to save system server.', 'Error');
            }

            fetchsystem_server();
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
function editserver(id) {

    $.ajax({
        url: "{{ route('system_server.info') }}",
        method: 'POST',
        data: {
            _token: "{{ csrf_token() }}",
           system_server_id: id
        },
        success: function (response) {

            $('#modal-title').text('Edit System server');
            $('#system_server_id').val(response.id);
            $('#system_server').val(response.system_server);
       

            $('#serverModal').modal('show');
        },
        error: function (xhr) {
            console.error(xhr.responseText);
        }
    });
}

// DELETE
function deleteserver(id) {
        if (confirm('Are you sure you want to delete this system server?')) {
            $.ajax({
                url: "{{ route('system_server.delete') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                  system_server_id: id
                },
                success: function(response) {
                    console.log(response);
                    if(response.status == 'true') {
                        toastr.success('System deleted successfully!', 'Success');
                    } else {
                        toastr.error('Failed to delete System', 'Error');
                    }
                    fetchsystem_server(); // Refresh the sub category list
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

    
}
</script>