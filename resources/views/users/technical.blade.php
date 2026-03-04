

@extends('layouts.app')
@section('content')
<h1>Technical Assistance here</h1>
    
         

    {{-- ADD NEW BRAND CARD --}}
    <div class="card mb-4 shadow-sm">
      
        <div class="card-body">
            <form id="addTechnicalForm">
                @csrf
                <input type="hidden" id="technical_id" name="technical_id">
                     {{-- SELECT COMPUTER TYPE --}}
                <div class="row mb-3">
                    <div class="col-md-12 mb-3 mb-md-0">
        <label class="form-label fw-bold">Select Type of Computer:</label>
        <select id="a_type" class="form-control form-control-sm" name="type_computer">
            <option value="">Select type of Computer</option>
            <option value="1">All-in-One</option>
            <option value="2">Desktop</option>
            <option value="3">Laptop</option>
        </select>
    </div>
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label class="form-label fw-bold">Model:</label>
                        <input type="text" class="form-control" id="model" name="model" placeholder="Enter Technical Name">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Status:</label>
                        <select class="form-control" id="status" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <button type="button" class="btn btn-success" onclick="savetechnical()">Save</button>
            </form>
        </div>
    </div>
<table id="type" class="table table-bordered">
            <thead>
                <tr>
                    <th>Type of Computer</th>
                    <th>Model</th>
                    <th>Status</th>
                    <th>Actions</th>
                    
                </tr>
            </thead>
            <tbody id="brand">

            </tbody>
        </table>
                    

@endsection
<script>
    window.onload = function() {
        fetchtechnical();
    };


//save technical
    function savetechnical() {
        var formData = $('#addTechnicalForm').serialize();
        console.log(formData);
        $.ajax({
            url: "{{ route('technical.save') }}",
            method: 'POST',
            data: formData,
            success: function(response) {
                console.log(response);
                $('#addTechnicalForm')[0].reset();
                if(response.status == 'true') {
                     toastr.success('Technical saved successfully!', 'Success');
                } else {
                    toastr.error('Failed to save technical.', 'Error');
                }
                fetchtechnical(); // Refresh the technical list
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }

    function editTechnical(id) {
        $.ajax({
            url: "{{ route('technical.info') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                technical_id: id
            },
            success: function(response) {
                console.log(response);
                $('#modal-title').text('Edit Technical');
                $('#technical_id').val(response.id);
                $('#name').val(response.description);
                $('#categoryModal').modal('show');
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }
    function deleteTechnical(id) {
        if (confirm('Are you sure you want to delete this technical?')) {
            $.ajax({
                url: "{{ route('technical.delete') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    technical_id: id
                },
                success: function(response) {
                    console.log(response);
                    if(response.status == 'true') {
                        toastr.success('Technical deleted successfully!', 'Success');
                    } else {
                        toastr.error('Failed to delete technical.', 'Error');
                    }
                    fetchtechnical(); // Refresh the technical list
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }
    }
</script>