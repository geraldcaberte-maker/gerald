@extends('sub_category.index')

@section('content')
<div class="card">
   
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-lg-9 col-md-10 col-sm-12">

      <h2 class="mb-4 text-center">Employee Record Form</h2>

      <form id="employeeForm">

        <!-- Personal Information -->
        <div class="card mb-3 shadow-sm">
          <div class="card-header bg-primary text-white">
            Personal Information
          </div>
          <div class="card-body">

            <div class="row mb-2">
              <div class="col-md-4">
                <label>ID Number</label>
                <input type="text" class="form-control" name="id_number" required>
              </div>
              <div class="col-md-4">
                <label>First Name</label>
                <input type="text" class="form-control" name="first_name" required>
              </div>
              <div class="col-md-4">
                <label>Middle Name</label>
                <input type="text" class="form-control" name="middle_name">
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-md-4">
                <label>Middle Initial</label>
                <input type="text" class="form-control" name="middle_initial" maxlength="1">
              </div>
              <div class="col-md-4">
                <label>Last Name</label>
                <input type="text" class="form-control" name="last_name" required>
              </div>
              <div class="col-md-4">
                <label>Extension Name</label>
                <input type="text" class="form-control" name="extension_name">
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-md-4">
                <label>Birthdate</label>
                <input type="date" class="form-control" name="birthdate">
              </div>
              <div class="col-md-4">
                <label>Sex</label>
                <select class="form-control" name="sex">
                  <option value="">Select</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Other">Other</option>
                </select>
              </div>
              <div class="col-md-4">
                <label>Civil Status</label>
                <select class="form-control" name="civil_status">
                  <option value="">Select</option>
                  <option value="Single">Single</option>
                  <option value="Married">Married</option>
                  <option value="Widowed">Widowed</option>
                  <option value="Separated">Separated</option>
                </select>
              </div>
            </div>

          </div>
        </div>

        <!-- Contact Information -->
        <div class="card mb-3 shadow-sm">
          <div class="card-header bg-success text-white">
            Contact Information
          </div>
          <div class="card-body">

            <div class="row mb-2">
              <div class="col-md-6">
                <label>Email</label>
                <input type="email" class="form-control" name="email" required>
              </div>
              <div class="col-md-6">
                <label>Secondary Email</label>
                <input type="email" class="form-control" name="secondary_email">
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-md-6">
                <label>Telephone Number</label>
                <input type="text" class="form-control" name="telephone_number">
              </div>
              <div class="col-md-6">
                <label>Cellphone Number</label>
                <input type="text" class="form-control" name="cellphone_number">
              </div>
            </div>

          </div>
        </div>

        <!-- Employment Information -->
        <div class="card mb-3 shadow-sm">
          <div class="card-header bg-info text-white">
            Employment Information
          </div>
          <div class="card-body">

            <div class="row mb-2">
              <div class="col-md-4">
                <label>Status of Appointment</label>
                <select class="form-control" name="status_of_appointment_id">
                  <option value="">Select</option>
                </select>
              </div>
              <div class="col-md-4">
                <label>Employment Status</label>
                <input type="text" class="form-control" name="employmentstatus">
              </div>
              <div class="col-md-4">
                <label>Appointment Type</label>
                <select class="form-control" name="appointment_type_id">
                  <option value="">Select</option>
                </select>
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-md-4">
                <label>Item Number</label>
                <input type="text" class="form-control" name="item_number">
              </div>
            </div>

          </div>
        </div>

        <div class="text-end">
          <button type="submit" class="btn btn-primary px-4">
            Save Employee
          </button>
        </div>

      </form>

    </div>
  </div>
</div>
</div>