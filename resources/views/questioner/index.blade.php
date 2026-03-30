@extends('layouts.app')
@section('content')

<div class="card">
    <div class="card-body">
         <button class="btn btn-primary mb-3" onclick="addQuestioner()">Add Questioner</button>
        <h1>Questionaire</h1>
        <table id="questioner-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Category</th>
                    <th>Question</th>
                    <th>Input Type</th>
                    <th>Is required?</th>
                    <th>Sorting</th>
                    <th>Action</th>


                </tr>
            </thead>
            <tbody id="questioner_tbody">

            </tbody>
        </table>
    </div>
</div>
@endsection

<div class="modal fade bs-example-modal-lg" id="QuestionerModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title">Title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="queForm">
                    @csrf
                    <div class="row">
                        <input type="hidden" id="questioner_id" name="questioner_id">
                        <div class="col-md-12">
                            <label for="question_id">Category</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                <option value="">laptop</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="question">Question</label>
                            <input type="text" class="form-control" id="question" name="question" required>
                        </div>
                            

                        <div class="col-md-12">
                            <label for="input_type">Input Type</label>
                            <select class="form-control" id="input_type" name="input_type" required>
                                <option value="text">Text</option>
                                <option value="number">Number</option>
                                <option value="radio">Radio(Yes/No)</option>
                                  <option value="ram">Computer(RAM/,HARD.)</option>
                                  <option value="adminICT">Admin ICT</option>
                                  <option value="connection">Connection checks</option>
                                      <option value="restore">Restore Point</option>
                                       <option value="applicant">applicant</option>
                                       <option value="peripherals">peripherals</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label for="input_type">Is required?</label>
                            <select class="form-control" id="is_required" name="is_required" required>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label for="sorting">Sorting</label>
                            <input type="text" class="form-control" id="sorting" name="sorting" required>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect text-left" onclick="saveQuestioner()">Save</button>
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    window.onload = function() {
        fetchQuestioner();
    }
// add questionaire modal
   function addQuestioner() {
        $('#modal-title').text('Add Questioner');
        getCategory();
        $('#questioner_id').val('');
        $('#queForm')[0].reset();
        $('#QuestionerModal').modal('show');
    }
    function getCategory(){
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

    function fetchQuestioner() {
        $('#questioner_tbody').empty();
        $.ajax({
            url: "{{ route('questioner.fetch') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log(response);
                $('#questioner_tbody').html(response);
                $.each(response, function(index, questioner) {
                    $('#questioner_tbody').append(
                        `<tr>
                            <td>${index + 1}</td>
                            <td>${questioner.category_id}</td>
                            <td>${questioner.question}</td>
                            <td>${questioner.input_type}</td>
                            <td>${questioner.is_required}</td>
                            <td>${questioner.sorting}</td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="editQuestioner('${questioner.id}')">Edit</button>
                                <button class="btn btn-sm btn-danger" onclick="deleteQuestioner('${questioner.id}')">Delete</button>
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

    function saveQuestioner() {
            let category_id = $('#category_id').val().trim();
    let question = $('#question').val().trim();
    let sorting = $('#sorting').val().trim();
        $('#QuestionerModal').modal('show');

    if (question ==="") {
       toastr.error("Question   : is required.");
      return;
 }

if (sorting === "") {
  toastr.error("Sorting   : is required.");
     return;
    } 
 

    var formData = $('#queForm').serialize();
    
        $.ajax({
            url: "{{ route('questioner.save') }}",
            method: 'POST',
            data: formData,
            success: function(response) {
                console.log(response);
                $('#QuestionerModal').modal('hide');
                if(response.status == 'true') {
                     toastr.success('Questioner saved successfully!', 'Success');
                } else {
                    toastr.error('Failed to save questioner.', 'Error');
                }
                fetchQuestioner(); // Refresh the questioner list
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }

    function editQuestioner(id) {
        getCategory();
        $.ajax({
            url: "{{ route('questioner.info') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                questioner_id: id
            }, 
            success: function(response) {
            
                $('#modal-title').text('Edit Questioner');
                $('#questioner_id').val(response.id);
                $('#category_id').val(response.category_id);
                $('#question').val(response.question);
                $('#sorting').val(response.sorting);
                $('#input_type').val(response.input_type);
                $('#is_required').val(response.is_required);
                $('#QuestionerModal').modal('show');
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
  
    }


   function deleteQuestioner(id) {

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
                url: "{{ route('questioner.delete') }}",
                method: 'POST',
                data: {
                    questioner_id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {

                    if(response.status == 'true') {
                        toastr.success('Deleted successfully!', 'Success');
                    } else {
                        toastr.error('Delete failed.', 'Error');
                    }

                    fetchQuestioner();
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });

        }

    });
}

</script>
