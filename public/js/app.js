import './bootstrap';
function adduser() {
    $.ajax({
        url: '/users',
        method: 'POST',
        data: {
            id: $('#id').val(),
            user_id: $('#user_id').val(),
            a_type: $('#a_type').val(),
            a_brand: $('#a_brand').val(),
            a_serial: $('#a_serial').val(),
            a_year: $('#a_year').val(),
            b_brand: $('#b_brand').val(),
            b_serial: $('#b_serial').val(),
            c_year: $('#c_year').val(),
            ab_status: $('input[name="ab_status"]:checked').val(),
            ab_status_remarks: $('#ab_status_remarks').val(),
            ab_check: $('input[name="ab_check"]:checked').val(),
            ab_check_remarks: $('#ab_check_remarks').val(),
            c_brand: $('#c_brand').val(),
            c_serial: $('#c_serial').val(),
            c_status: $('input[name="c_status"]:checked').val(),
            c_status_remarks: $('#c_status_remarks').val(),
            c_check: $('input[name="c_check"]:checked').val(),
            c_check_remarks: $('#c_check_remarks').val(),
            c_level: $('input[name="c_level"]:checked').val(),
            c_level_remarks: $('#c_level_remarks').val(),
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            alert('User added successfully!');
            location.reload();
        },
        error: function(xhr) {
            alert('Error adding user');
        }
    }); 
}
<script src="{{ asset('js/app.js') }}"></script>
