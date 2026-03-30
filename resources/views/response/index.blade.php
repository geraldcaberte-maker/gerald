@extends('layouts.app')
@section('content')

<table class="table table-bordered">
@foreach($responses as $res)
    <h4>PMS ID: {{ $res->id }}</h4>

    @foreach($res->answers as $ans)
        <p>
            <b>{{ $ans->question->question }}:</b>
            {{ $ans->answer }}
        </p>
    @endforeach
@endforeach
    <tbody id="response_tbody"></tbody>
</table>
<button class="btn btn-primary mb-4 same-btn" onclick="addResponse()">Conduct PMS</button>
  <div class="col-md-12">
                         

<!-- Modal --><div id="overlay" onclick="closeModal()" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:black;opacity:0.5;z-index:999;"></div>

<div id="detailsModal" style="display:none;position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);background:white;padding:20px;z-index:1000;">
    <div id="modalContent"></div>
    <button onclick="closeModal()">Close</button>
</div>

@endsection




{{-- Response Modal --}}
<div class="modal fade bs-example-modal-lg" id="responseModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" >
    <div class="modal-dialog modal-lg" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header position-relative justify-content-center">
                <h4 class="modal-title" id="modal-title">
                    <img src="{{ asset('nmp.png') }}" alt="logo" height="70" class="light-logo" />
                </h4>
            </div>
            <div class="modal-body">
                <form id="responseForm">
                    @csrf
                        <label style="font-size:26px;   font-weight:bold;">
                            PREVENTIVE MAINTENANCE CHECKLIST
                        </label>
                            <div class="form-group mb-3">
                        <div class="row">
                            <input type="hidden" id="application_id" name="application_id">
                            <div class="col-md-6">
                                <label>Custodian name</label>
                                <select class="form-control" id="user_id" name="user_id" required>
                                    <option value="">Select one...</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Division</label>
                                 <input type="hidden" id="division_id" name="division_id" value="1626918984026574882672">

                                 <input type="text" class="form-control" name="division_id" placeholder="Enter division" required>
                            </div>

                        </div>
                    </div>
                    <div id="category_id"></div>
                       <div class="row">
                           <div class="col-md-6">
                            <label >Preventive By</label>
                            <select class="form-control" id="ict_staff" name="ict_staff" required>
                                 </select>
                            </div>
                            <div class="col-md-6">
                                <label>Custodian</label>
                                <select class="form-control" id="custodian" name="custodian" required>
                                    <option value="">Select one...</option>
                                </select>
                            </div>
                               </div>
                </form>
            </div>
            <div class="modal-footer">
         
                <button type="button" class="btn btn-primary px-4" onclick="saveResponse()">Submit</button>
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>

function addResponse() {
   
    getStaffs();
    getQuestion();
    getIctStaffs();
     getsections();
    $('#responseForm')[0].reset();
    $('#category_id').html('');
    $('#responseModal').modal('show');
}
function getStaffs(){
    $('#user_id').empty();
    var html = '';
    $.ajax({
        url:"{{ route('response.staffs')}}",
        method: 'POST',
        data: {_token: "{{ csrf_token() }}"},
        success: function(data){
            html+=`<option disabled selected>Select one...</option>`;
            $.each(data, function(index, staff) {
                html+=`<option value="${staff.user_id}">${staff.fullname}</option>`;
            });
            $('#user_id').append(html);
        },
    });
}


function getIctStaffs(){
    $('#ict_staff').empty();
    var html = '';
    $.ajax({
        url:"{{ route('response.ict_staffs')}}",
        method: 'POST',
        data: {_token: "{{ csrf_token() }}"},
        success: function(data){
            html+=`<option disabled selected>Select one...</option>`;
            $.each(data, function(index, staff) {
                html+=`<option value="${staff.user_id}">${staff.fullname}</option>`;
            });
            $('#ict_staff').append(html);
        },
    });
}function getsections(){
    $('#divisions').empty(); // dito mo ilalagay yung sections

    let html = '<option value="">Select Section</option>';

    $.ajax({
        url: "{{ route('response.sections') }}",
        method: 'POST',
        data: { _token: "{{ csrf_token() }}" },
        success: function(data){
            $.each(data, function(index, sec){
                html += `<option value="${sec.id}">${sec.section_code}</option>`;
            });

            $('#divisions').html(html);
        }
    });
}
function getQuestion(){
    
    $.ajax({
        url: "{{ route('response.questioner') }}",
        method: 'POST',
        data: {_token: "{{ csrf_token() }}"},
        success: function(categories){

            let text = "";

            $.each(categories, function(index, category) {

                     
                let desc = category.description.toLowerCase().trim();
                let icon = 'fa-folder';

                if(desc.includes('computer')){
                    icon = 'fa-desktop';
                }
                else if(desc.includes('monitor')){
                    icon = 'fa-tv';
                }
                else if(desc.includes('printer')){
                    icon = 'fa-print';
                }
                else if(desc.includes('scanner')){
                    icon = 'fa-file-alt';
                }
                else if(desc.includes('peripheral')){
                    icon = 'fa-keyboard';
                }

                // ✅ CATEGORY TITLE WITH ICON
                text += `
                <h4 class="category-title">
                    <i class="fas ${icon} me-2"></i> ${category.description}
                </h4>`;

                // =============================
                // QUESTIONS LOOP
                // =============================
                $.each(category.questions, function(key, ques) {

                    text += `<div class="mb-2 question-container">
                                <label>${ques.question}</label>`;

                        // ✅ TEXT
                        if(ques.input_type == 'text'){
                            text += `<input type="text" class="form-control" name="text_${ques.id}">`;
                        }

                        // ✅ NUMBER
                        else if(ques.input_type == 'number'){
                            text += `<input type="number" class="form-control" name="number_${ques.id}">`;
                        }

                   else if(ques.input_type == 'radio'){
                        text += `
                        <div style="display:flex; gap:20px; margin-top:5px;">
                            <label>
                                <input type="radio" name="question_${ques.id}" value="1"
                                    onclick="hideRemarks(${ques.id})"> Yes
                            </label>
                            <label>
                                <input type="radio" name="question_${ques.id}" value="0"
                                    onclick="showRemarks(${ques.id})"> No
                            </label>
                        </div>
                        <div class="remarks-container-${ques.id}"></div>
                        `;
                    }

           
                    if(desc.includes('computer') && ques.input_type == 'ram'){
                        text += `
                          <div style="display:flex; gap:20px; margin-top:5px;">
                            <label>
                                <input type="radio" name="question_${ques.id}" value="1"
                                    onclick="hideRemarks(${ques.id})"> Yes
                            </label>
                            <label>
                                <input type="radio" name="question_${ques.id}" value="0"
                                    onclick="showRemarks(${ques.id})"> No
                            </label>
                        </div>
                        <div class="remarks-container-${ques.id}"></div>
                        
                        <div class="mb-2">
                            <input type="text" class="form-control form-control-sm"
                                placeholder="RAM" name="ramm_${ques.id}">
                        </div>
                        <div class="mb-2">
                            <input type="text" class="form-control form-control-sm"
                                placeholder="STORAGE" name="storage_${ques.id}">
                        </div>
                        <div class="mb-2">
                            <input type="text" class="form-control form-control-sm"
                                placeholder="CPU" name="cpu_${ques.id}">
                        </div>
                        `;
                    }
  
                 else if(ques.input_type == 'adminICT'){
    text += `
    <div style="margin-top:8px;">
        <div style="display:flex; margin-bottom:8px;">
            <div style="margin-right:30px;">
                <input type="radio"
                    name="question_${ques.id}"
                    value="1"
                    onclick="toggleRemarks(this)">
                <label>Yes</label>
            </div>
            <div>
                <input type="radio"
                    name="question_${ques.id}"
                    value="0"
                    onclick="toggleRemarks(this)">
                <label>No</label>
            </div>
        </div>

        <div class="remarks-container-${ques.id}"></div>
    </div>`;
} 
                    else if(ques.input_type == 'restore'){
                text += `
                <div style="margin-top:8px;">
                    <div style="display:flex; margin-bottom:8px;">
                        <div style="margin-right:30px;">
                            <input type="radio"
                                name="question_${ques.id}"
                                value="1"
                                onclick="toggleRestoreRemarks(this)">
                            <label>Yes</label>
                        </div>
                        <div>
                            <input type="radio"
                                name="question_${ques.id}"
                                value="0"
                                onclick="toggleRestoreRemarks(this)">
                            <label>No</label>
                        </div>
                    </div>

                    <div class="remarks-container-${ques.id}"></div>
                </div>`;
            }

                    if(ques.input_type == 'connection'){
                        text += `
                          <div style="display:flex; gap:20px; margin-top:5px;">
                            <label>
                                <input type="radio" name="question_${ques.id}" value="1"
                                    onclick="hideRemarks(${ques.id})"> Yes
                            </label>
                            <label>
                                <input type="radio" name="question_${ques.id}" value="0"
                                    onclick="showRemarks(${ques.id})"> No
                            </label>
                        </div>
                        <div class="remarks-container-${ques.id}"></div>
                        <div class="mb-2">
                            <input type="text" class="form-control form-control-sm"
                                placeholder="Enter MAC Address" name="mac_${ques.id}">
                        </div>
                        <div class="mb-2">
                            <input type="text" class="form-control form-control-sm"
                                placeholder="Enter IP Address" name="ip_${ques.id}">
                        </div>
                        `;
                    }
                    if(ques.input_type == 'applicant'){
                        text += `
                <button type="button" class="btn btn-success btn-sm mb-2"
                    onclick="addTextbox(${ques.id})">Add Application</button>
                               <div style="display:flex; margin-bottom:8px;">
            <div style="margin-right:30px;">
                <input type="radio"
                    name="question_${ques.id}"
                    value="1"
                    onclick="handleApplicantYes(${ques.id})">
                <label>Yes</label>
            </div>

            <div>
                <input type="radio"
                    name="question_${ques.id}"
                    value="0"
                    onclick="handleApplicantNo(${ques.id})">
                <label>No</label>
            </div>
        </div>

        <!-- REMARKS -->
        <div class="remarks-container-${ques.id}"></div>

                        <div style="display:flex; gap:5px; font-weight:bold;">
                            <div style="flex:1;">NAME</div>
                            <div style="flex:1;">EXPIRATION</div>
                            <div style="width:45px;"></div>
                        </div>


                <div id="application-container-${ques.id}"></div>
                        <div class="textbox-container-${ques.id}"></div>
                        `;
                    }

                    // =============================
                    // 5️⃣ PERIPHERALS
                    // =============================
                    if(desc.includes('peripheral') && ques.input_type == 'peripherals'){
                        text += `
                                  
                <input type="hidden" id="peripherals_id" name="peripherals_id">
                      <button type="button" class="btn btn-primary btn-sm mb-2"
                  onclick="addPeripheral(${ques.id})">+</button>
                    <div id="peripheral-container-${ques.id}"></div>
                        <div class="peripheral-container-${ques.id}"></div>
                        `;
                    }

                    text += `</div>`;
                });

            });
              

            $('#category_id').html(text);
        }
    });
}

function handleApplicantYes(id){
    // show application
    $('.applicant-section-' + id).show();

    // hide remarks (gamit function mo)
    hideRemarks(id);
}

function handleApplicantNo(id){
    // hide application
    $('.applicant-section-' + id).hide();

    // show remarks (gamit function mo)
    showRemarks(id);
}
function showRemarks(id){
    $('.remarks-container-' + id).html(`
        <textarea class="form-control mt-2" name="remarks[${id}]" placeholder="Please specify remarks"></textarea>
    `);
}
function hideRemarks(id){
    $('.remarks-container-' + id).empty();
}
function toggleRestoreRemarks(select){
    let questionId = select.name.split('_')[1];
    let container = $('.remarks-container-' + questionId);

    if(select.value == "1"){
        container.html(`<input type="text" class="form-control form-control-sm mt-1" placeholder="Remarks for Yes" name="remarks_yes_${questionId}">`);
    } else if(select.value == "0"){
        container.html(`<input type="text" class="form-control form-control-sm mt-1" placeholder="Remarks for No" name="remarks_no_${questionId}">`);
    }else{
        container.empty();
    }

}function addPeripheral(id){
    let html = `
        <div class="row mb-2">
            <div class="col-md-3">
                <input type="text" 
                       name="peripherals_name[${id}][]" 
                       class="form-control" 
                       placeholder="Peripheral">
            </div>
            <div class="col-md-3">
                <input type="text" 
                       name="peripherals_brand[${id}][]" 
                       class="form-control" 
                       placeholder="Brand">
            </div>
            <div class="col-md-3">
                <input type="text" 
                       name="peripherals_serial[${id}][]" 
                       class="form-control" 
                       placeholder="Serial">
            </div>
            <div class="col-md-2">
                <input type="number" 
                       name="peripherals_year[${id}][]" 
                       class="form-control" 
                       placeholder="Year">
            </div>
            <div class="col-md-1">
                <button type="button" 
                        class="btn btn-danger btn-sm" 
                        onclick="removePeripheral(this)">X</button>
            </div>
        </div>
    `;

    $('#peripheral-container-' + id).append(html);
}

function removePeripheral(btn){
    $(btn).closest('.row').remove();
}
function addTextbox(id){
    let html = `
        <div class="row mb-2">
            <div class="col-md-5">
                <input type="text" 
                       name="name[${id}][]" 
                       class="form-control" 
                       placeholder="Application Name">
            </div>
            <div class="col-md-5">
                <input type="text" 
                       name="expiration[${id}][]" 
                       class="form-control">
            </div>
        </div>
    `;

    $('#application-container-' + id).append(html);
}
function toggleRemarks(select){
    let questionId = select.name.split('_')[1];
    let container = $('.remarks-container-' + questionId);
    if(select.value == "1"){
      container.html(`<input type="text" class="form-control form-control-sm mt-1" placeholder="Remarks for Yes" name="remarks_yes_${questionId}">`);
    } 
    else if(select.value == "0"){
        container.html(`<input type="text" class="form-control form-control-sm mt-1" placeholder="Remarks for No" name="remarks_no_${questionId}">`);
    }
  
}
function saveResponse() {
    let applicationId = $('#application_id').val();
    let divisionId = $('[name="division_id"]').val();
    let ictStaff = $('#ict_staff').val();

    let answers = {};
    $('[name^="text_"], [name^="number_"], [name^="question_"]').each(function() {
        let qid = $(this).attr('name').split('_')[1];
        answers[qid] = $(this).val();
    });

    $('[type="radio"]:checked').each(function() {
        let qid = $(this).attr('name').split('_')[1];
        answers[qid] = $(this).val();
    });

    let applicants = []; 
    $('[name^="name["]').each(function(index){
        let name = $(this).val();
        let expiration = $('[name="expiration['+index+']"]').val();
        applicants.push({name, expiration});
    });

    $.ajax({
        url: "{{ route('response.save') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            application_id: applicationId,
            division_id: divisionId,
            ict_staff: ictStaff,
            answers: answers,
            applicants: applicants
        },
        success: function(res){
            if(res.status === 'success'){
                toastr.success(res.message);
                fetchResponse();
            } else {
                toastr.error(res.message);
            }
        },
        error: function(err){
            if(err.responseJSON && err.responseJSON.errors){
                let messages = Object.values(err.responseJSON.errors).flat().join('<br>');
                toastr.error(messages);
            }
        }
    });
}
</script>
<style>
    .question-container {
    margin-left: 20px; /* adjust this value */
}
.category-title {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    font-weight: bold;
    font-size: 18px;

    background: #db1359;
    color: white;
    padding: 10px;
    border-radius: 8px;
    margin: 20px 0;
}
.modal-content {
  
    border-radius: 15px;        /* rounded corners */
    box-shadow: 0 0 20px rgba(230, 46, 10, 0.5); /* shadow para pop-out effect */
    padding: 30px;
}

</style>