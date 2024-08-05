@extends('adminlte::page')

@section('title', 'Employees')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Employee</h1>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" id="basic-info-tab" data-toggle="tab" href="#basic-info">Basic Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="image-info-tab" data-toggle="tab" href="#image-info">Image</a>
            </li>
        </ul>

        <!-- Tab Content -->
        <form class="tab-content" action="{{ route('employees.update', $employees->uuid) }}" method="POST" id="form_employee" autocomplete="off" enctype="multipart/form-data">
            <div class="tab-pane fade show active" id="basic-info">
                <!-- Basic Information Fields -->
                <div class="card mt-4">
                    <div class="card-body">
                    <h5>Employee Information</h5>
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4 col-sm-12 mb-3">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-bold">Employee Number&nbsp;<span></span></span>
                                    </div>
                                    <input type="text" class="form-control form-control-sm" id="" value="{{ $employees->code }}" readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <label for="first_name" data-required="true">First Name</label>
                                <input type="text" class="form-control form-control-sm" name="first_name" id="modal_add_first_name" value="{{ $employees->first_name }}" required>
                            </div>
                            <div class="col-md-2">
                                <label for="middle_name">Middle Name</label>
                                <input type="text" class="form-control form-control-sm" name="middle_name" id="modal_add_middle_name" value="{{ $employees->middle_name }}">
                            </div>
                            <div class="col-md-2">
                                <label for="last_name" data-required="true">Last Name</label>
                                <input type="text" class="form-control form-control-sm" name="last_name" id="modal_add_last_name" value="{{ $employees->last_name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="full_name">Full Name</label>
                                <input type="text" class="form-control form-control-sm" name="full_name" id="modal_add_full_name" value="{{ $employees->full_name }}" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="gender">Gender</label>
                                <div>
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" value="MALE" {{ $employees->gender === 'MALE' ? 'checked' : '' }}> Male
                                    </label>
                                    &nbsp;
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" value="FEMALE" {{ $employees->gender === 'FEMALE' ? 'checked' : '' }}> Female
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="civil_status">Civil Status</label>
                                <div>
                                    <label class="radio-inline">
                                        <input type="radio" name="civil_status" value="SINGLE" {{ $employees->civil_status === 'SINGLE' ? 'checked' : '' }}> Single
                                    </label>
                                    &nbsp;
                                    <label class="radio-inline">
                                        <input type="radio" name="civil_status" value="MARRIED" {{ $employees->civil_status === 'MARRIED' ? 'checked' : '' }}> Married
                                    </label>
                                    &nbsp;
                                    <label class="radio-inline">
                                        <input type="radio" name="civil_status" value="WIDOWED" {{ $employees->civil_status === 'WIDOWED' ? 'checked' : '' }}> Widowed
                                    </label>
                                    &nbsp;
                                    <label class="radio-inline">
                                        <input type="radio" name="civil_status" value="LEGALLY SEPARATED" {{ $employees->civil_status === 'LEGALLY SEPARATED' ? 'checked' : '' }}> Legally Separated
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label for="birthdate" data-required="true">Birthdate</label>
                                @php
                                    // Convert the birthdate to the correct format for input type date
                                    $formattedBirthdate = date('Y-m-d', strtotime($employees->birthdate));
                                @endphp
                                <input type="date" class="form-control form-control-sm" name="birthdate" value="{{ $formattedBirthdate }}" id="modal_add_birthdate" required>
                            </div>
                            <div class="col-md-1">
                                <label for="age">Age</label>
                                <input type="text" class="form-control form-control-sm" name="age" maxlength="5" id="modal_add_age" value="{{ $employees->age }}" readonly>
                            </div>
                            <div class="col-md-2">
                                <label for="height">Height</label>
                                <input type="text" class="form-control form-control-sm" name="height" maxlength="6" id="modal_add_height" pattern="[0-9]+" placeholder="in cm" value="{{ $employees->height }}">
                            </div>
                            <div class="col-md-2">
                                <label for="weight">Weight</label>
                                <input type="text" class="form-control form-control-sm" name="weight" maxlength="6" id="modal_add_weight" pattern="[0-9]+" placeholder="in kgs" value="{{ $employees->weight }}">
                            </div>
                            <div class="col-md-3">
                                <label for="religion">Religion</label>
                                <input type="text" class="form-control form-control-sm" name="religion" maxlength="25" id="modal_add_religion" pattern="[a-zA-Z0-9\s]+" value="{{ $employees->religion }}">
                            </div>
                            <div class="col-md-2">
                                <label for="nationality">Nationality</label>
                                <input type="text" class="form-control form-control-sm" name="nationality" maxlength="25" id="modal_add_nationality" pattern="[a-zA-Z0-9\s]+" value="{{ $employees->nationality }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="company">Company</label>
                                <select class="form-control form-control-sm" name="company_id" id="modal_add_company" readonly>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ $company->id == 1 ? 'selected' : '' }}>{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="department" data-required="true">Department</label>
                                <select class="form-control form-control-sm" name="department_id" id="modal_add_department_id" required>
                                    <option value="" disabled>-- Select Department --</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ $department->id == $employees->department_id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="role" data-required="true">Role</label>
                                <select class="form-control form-control-sm" name="role_id" id="modal_add_role_id" required>
                                    <option value="" selected disabled>-- Select Role --</option>
                                    @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ $role->id == $employees->role_id ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="agent_category" data-required="true">Agent Category</label>
                                <select class="form-control form-control-sm" name="agent_category" id="modal_add_agent_category" required>
                                    <option value="" selected disabled>-- Select Category --</option>
                                    @foreach($agent_categories as $category)
                                            <option value="{{ $category->id }}" {{ $category->id == $employees->agent_category ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-body">
                    <h5>Employee Details</h5>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="tin">TIN</label>
                                <input type="text" class="form-control form-control-sm" name="tin" id="modal_add_tin" value="{{ $employees->tin }}">
                            </div>
                            <div class="col-md-3">
                                <label for="phic">Philhealth</label>
                                <input type="text" class="form-control form-control-sm" name="philhealth" id="modal_add_philhealth" value="{{ $employees->phic }}">
                            </div>
                            <div class="col-md-3">
                                <label for="sss">SSS</label>
                                <input type="text" class="form-control form-control-sm" name="sss" maxlength="25" id="modal_add_sss" value="{{ $employees->sss }}">
                            </div>
                            <div class="col-md-3">
                                <label for="hdmf">Pag-Ibig</label>
                                <input type="text" class="form-control form-control-sm" name="pagibig" maxlength="25" id="modal_add_pagibig" value="{{ $employees->hdmf }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="national_id">National ID</label>
                                <input type="text" class="form-control form-control-sm" name="national_id" maxlength="25" id="modal_add_national_id" value="{{ $employees->national_id }}">
                            </div>
                            <div class="col-md-3">
                                <label for="umid">UMID</label>
                                <input type="text" class="form-control form-control-sm" name="umid" maxlength="25" id="modal_add_umid" value="{{ $employees->umid }}">
                            </div>
                            <div class="col-md-3">
                                <label for="passport">Passport</label>
                                <input type="text" class="form-control form-control-sm" name="passport" maxlength="25" id="modal_add_passport" value="{{ $employees->passport }}">
                            </div>
                            <div class="col-md-3">
                                <label for="drivers_license">Driver's License</label>
                                <input type="text" class="form-control form-control-sm" name="drivers_license" maxlength="25" id="modal_add_drivers_license" value="{{ $employees->drivers_license }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="province" data-required="true">Province</label>
                                <select class="form-control form-control-sm select2 select2-primary" name="province" id="modal_edit_province" required>
                                    <option value="" disabled>-- Select Province --</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" {{ $province->id == $employees->province ? 'selected' : '' }}>{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="city" data-required="true">City</label>
                                <select class="form-control form-control-sm select2 select2-primary" name="city" id="modal_edit_city" required>
                                    <option value="" disabled>-- Select City --</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ $city->id == $employees->city ? 'selected' : '' }}>{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="barangay">Barangay</label>
                                <select class="form-control form-control-sm select2 select2-primary" name="barangay" id="modal_edit_barangay" disabled>
                                    <option value="" selected disabled>-- Select Barangay --</option>
                                    @foreach($barangays as $barangay)
                                        <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="street">Barangay (Current Selected)</label>
                                <input type="text" class="form-control form-control-sm" style="color: red" value="{{ $employees->barangays->name }}" readonly>
                            </div>
                            <div class="col-md-2">
                                <label for="street" data-required="true">Street</label>
                                <input type="text" class="form-control form-control-sm" name="street" id="modal_add_street" value="{{ $employees->street }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="zip_code">Zip Code</label>
                                <input type="text" class="form-control form-control-sm" name="zip_code" maxlength="4" id="modal_add_zip_code" value="{{ $employees->zip_code }}">
                            </div>
                            <div class="col-md-3">
                                <label for="contact_details" data-required="true">Contact Number</label>
                                <input type="text" class="form-control form-control-sm" name="contact_number" maxlength="11" id="modal_add_contact_number" value="{{ $employees->contact_details }}" required>
                            </div>
                            <div class="col-md-3">
                                <label for="emergency_contact_name">Emergency Contact Name</label>
                                <input type="text" class="form-control form-control-sm" name="emergency_contact_name"  id="modal_add_emergency_contact_name" value="{{ $employees->emergency_contact_name }}">
                            </div>
                            <div class="col-md-3">
                                <label for="emergency_contact_number">Emergency Contact Number</label>
                                <input type="text" class="form-control form-control-sm" name="emergency_contact_number" maxlength="11" id="modal_add_emergency_contact_number" value="{{ $employees->emergency_contact_number }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="employees_type" data-required="true">Employment Type</label>
                                <select class="form-control form-control-sm" name="employees_type" id="modal_add_employees_type" required>
                                    <option value="NULL">-- Select Type --</option>
                                    <option value="PROBATIONARY" {{ $employees->employee_type == 'PROBATIONARY' ? 'selected' : '' }}>PROBATIONARY</option>
                                    <option value="REGULAR" {{ $employees->employee_type == 'REGULAR' ? 'selected' : '' }}>REGULAR</option>
                                    <option value="CASUAL" {{ $employees->employee_type == 'CASUAL' ? 'selected' : '' }}>CASUAL</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="pay_frequency" data-required="true">Pay Frequency</label>
                                <select class="form-control form-control-sm" name="pay_frequency" id="modal_add_pay_frequency" required>
                                    <option value="NULL">-- Select --</option>
                                    <option value="DAILY" {{ $employees->pay_frequency == 'DAILY' ? 'selected' : '' }}>DAILY</option>
                                    <option value="MONTHLY" {{ $employees->pay_frequency == 'MONTHLY' ? 'selected' : '' }}>MONTHLY</option>
                                  </select>
                            </div>
                            <div class="col-md-3">
                                <label for="date_hired" data-required="true">Date Hired</label>
                                @php
                                    // Convert the birthdate to the correct format for input type date
                                    $formattedDateHired = date('Y-m-d', strtotime($employees->date_hired));
                                @endphp
                                <input type="date" class="form-control form-control-sm" name="date_hired" id="modal_add_date_hired" value="{{ $formattedDateHired }}" required>
                            </div>
                            <div class="col-md-3">
                                <label for="date_separated">Date Separated</label>
                                @php
                                    // Convert the birthdate to the correct format for input type date
                                    $formattedDateSeparated = date('Y-m-d', strtotime($employees->date_separated));
                                @endphp
                                <input type="date" class="form-control form-control-sm" name="date_separated" id="modal_add_date_separated" value="{{ $formattedDateSeparated }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="basic_pay" data-required="true">Basic Pay</label>
                                <input type="text" class="form-control form-control-sm" name="basic_pay" maxlength="6" id="modal_add_basic_pay" placeholder="0.00" value="{{ number_format($employees->basic_pay, 2) }}" required>
                            </div>
                            <div class="col-md-3">
                                <label for="rate_per_day">Rate per Day</label>
                                <input type="text" class="form-control form-control-sm" name="rate_per_day" maxlength="6" id="modal_add_rate_per_day" placeholder="0.00" value="{{ number_format($employees->rate_per_day, 2) }}">
                            </div>
                            <div class="col-md-3">
                                <label for="rate_per_hour">Rate per Hour</label>
                                <input type="text" class="form-control form-control-sm" name="rate_per_hour" maxlength="6" id="modal_add_rate_per_hour" placeholder="0.00" value="{{ number_format($employees->rate_per_hour, 2) }}">
                            </div>
                            <div class="col-md-3">
                                <label for="ot_rate_per_hour">OT Rate per Hour</label>
                                <input type="text" class="form-control form-control-sm" name="ot_rate_per_hour" maxlength="6" id="modal_add_ot_rate_per_hour" placeholder="0.00" value="{{ number_format($employees->ot_rate_per_hour, 2) }}">
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-md-3 col-sm-12">
                                <label for="code">Employee Status</label>
                                <div class="col-12">
                                    <input type="radio" name="active" value="1" {{ $employees->active == 1 ? 'checked' : '' }}>
                                    <label for="" class="mr-4">Active</label>
                                    <input type="radio" name="active" value="0" {{ $employees->active == 0 ? 'checked' : '' }}>
                                    <label for="">Inactive</label>
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-12">
                                <label for="remarks">Remarks</label>
                                <input type="text" class="form-control form-control-sm" name="remarks" maxlength="6" id="modal_add_remarks" value="{{ $employees->remarks }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="image-info">
                <!-- Image Information Fields -->
                <div class="card mt-4">
                    @if ($employees->images)
                        <div class="card-body">
                            <div class="row">
                                <label for="image">Employee Image</label>
                                <input type="file" class="form-control-file" name="images" id="modal_add_image" accept="image/*" onchange="displayImage(this)">
                                <div class="image-container mt-3">
                                    <img src="{{ asset($employees->images) }}" alt="Preview Image" id="add_image_preview" class="uploaded-image">
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card-body">
                            <p>No Image Available</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Common Modal Footer -->
            <div class="card mt-4">
                <div class="card-body">
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <button type="button" class="btn btn-danger" id="btn-cancel-record" data-dismiss="modal">Cancel</button>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

<style>
    .custom-select-dropdown {
        background: transparent;
        border: none;
        padding: 0;
        outline: none;
        margin: 0;
        width: 125px;
        /* for dark mode only; remove if not dark-mode */
        color: white; 
    }

    input[type="text2"], textarea {
      color: #ffffff;
      text-align: left;
      border: none;
      outline: none;
      font-weight: bold;
    }

    select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
    
    #add_image_preview {
        display: block;
        margin: auto;
        max-width: 100%;
        max-height: 100%;
        border: 2px solid #ccc; /* You can customize the border color */
        box-sizing: border-box; /* Ensures that the border is included in the total width/height */
    }
    
    #edit_image_preview {
        display: block;
        margin: auto;
        max-width: 100%;
        max-height: 100%;
        border: 2px solid #ccc; /* You can customize the border color */
        box-sizing: border-box; /* Ensures that the border is included in the total width/height */
    }
    
    #show_images {
        display: block;
        margin: auto;
        max-width: 100%;
        max-height: 100%;
        border: 2px solid #ccc; /* You can customize the border color */
        box-sizing: border-box; /* Ensures that the border is included in the total width/height */
    }
    
    .custom-input-text {
    background: transparent;
    border: none;
    padding: 0;
    outline: none;
    margin: 0;
    width: 125px;
    /* for dark mode only; remove if not dark-mode */
    color: white; 
    } 

    .custom-input-text:read-only {
        background: transparent;
    }

    .table-bordered {
        border: 0px solid #dee2e6;
    }

    tfoot tr td:first-child {
        border: none !important;
    }

    /* Dynamic rows - tbody */
    /* Apply styles to even rows */
    tbody tr:nth-child(even) {
    background-color: transparent;
    }

    /* Apply styles to odd rows */
    tbody tr:nth-child(odd) {
    background-color: transparent;
    }

    #add_customers + .select2-container .select2-selection,
    #item_name + .select2-container .select2-selection,
    #modal_edit_province + .select2-container .select2-selection,
    #modal_edit_city + .select2-container .select2-selection,
    #modal_edit_barangay + .select2-container .select2-selection {
        background-color: transparent !important;
    }


    /* Target the Select2 dropdown text color */
    .select2-container .select2-selection--single .select2-selection__rendered {
        color: white !important;
        font-size: 14px !important; /* Adjust the font size as needed */
    }

    /* Optionally, change the placeholder color to white */
    .select2-container .select2-selection--single .select2-selection__placeholder {
        color: white !important;
        font-size: 14px !important; /* Adjust the font size as needed */
    }

    /* Style for text within labels */
    label[for][data-required="true"]::after {
        content: " *";
        color: red;
    }
</style>

@stop

@section('adminlte_js')
<script>
    $(document).ready(function() {

        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
        theme: 'bootstrap4'
        }); 
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#modal_add_code, #modal_add_first_name, #modal_add_middle_name, #modal_add_last_name, #modal_add_emergency_contact_name').on('input', function() {
                var inputText = $(this).val();
                var uppercaseText = inputText.toUpperCase();
                $(this).val(uppercaseText);
            });

        // Select the input fields
        var first_name_input = $('#modal_add_first_name');
        var middle_name_input = $('#modal_add_middle_name');
        var last_name_input = $('#modal_add_last_name');

        // Select the readonly full name input
        var full_name_input = $('#modal_add_full_name');

        // Add an input event listener to the name and middle name fields
        first_name_input.on('input', updateFullName);
        middle_name_input.on('input', updateFullName);
        last_name_input.on('input', updateFullName);

        // Function to update the full name based on the entered values
        function updateFullName() {
            var fullName = first_name_input.val().toUpperCase() + ' ' + middle_name_input.val().toUpperCase() + ' ' + last_name_input.val().toUpperCase();
            full_name_input.val(fullName);
        }

        $('#modal_add_birthdate').on('input', function() {
            const birthdate = new Date($(this).val());
            const today = new Date();

            // Check if the entered birthdate is valid (not in the future)
            if (birthdate > today) {
                // If birthdate is in the future, reset the input value and show a SweetAlert message
                $(this).val(''); // Reset the birthdate input field
                $('#modal_add_age').val(''); // Clear the age input field

                // Display SweetAlert message
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Birthdate',
                    text: 'Please select a birthdate that is not in the future.',
                    confirmButtonText: 'OK'
                });

                return; // Exit the function
            }

            // Calculate the age
            let age = today.getFullYear() - birthdate.getFullYear();

            // Adjust age based on the current month and day
            if (today.getMonth() < birthdate.getMonth() || 
                (today.getMonth() === birthdate.getMonth() && today.getDate() < birthdate.getDate())) {
                age--;
            }

            // Update the age input field with the calculated age
            $('#modal_add_age').val(age);
        });


        $('#modal_add_height, #modal_add_weight').on('input', function(e) {
            // Get the value entered by the user
            let inputValue = $(this).val();

            // Remove any non-numeric characters using a regular expression
            inputValue = inputValue.replace(/\D/g, ''); // \D matches any non-digit character

            // Update the input field value with the filtered numeric value
            $(this).val(inputValue);
        });

        $('#modal_add_first_name, #modal_add_middle_name, #modal_add_last_name, #modal_add_nationality, #modal_add_religion, #modal_add_city, #modal_add_province, #modal_add_emergency_contact_name').on('keypress', function(event) {
            var inputValue = event.key;
            // Check if the pressed key is a letter (a-z or A-Z) or a space
            if (!/^[a-zA-Z\s]*$/.test(inputValue)) {
                event.preventDefault(); // Prevent the input if not a letter or space
            }
        });

        $('#modal_add_tin, #modal_add_philhealth, #modal_add_sss, #modal_add_pagibig, #modal_add_umid, #modal_add_national_id, #modal_add_zip_code, #modal_add_contact_number, #modal_add_emergency_contact_number').on('input', function() {
            var inputValue = $(this).val();
            // Define the pattern to allow only numbers and dashes
            var pattern = /^[\d-]*$/;

            // Test if the input value matches the pattern
            if (!pattern.test(inputValue)) {
                // Invalid input detected, remove invalid characters
                $(this).val(inputValue.replace(/[^\d-]/g, ''));
            }
        });

        $('#modal_add_basic_pay, #modal_add_rate_per_day, #modal_add_rate_per_hour, #modal_add_ot_rate_per_hour').on('input', function() {
            let value = $(this).val().trim(); // Trim whitespace
            value = value.replace(/[^0-9.]/g, ''); // Remove non-numeric characters

            const parts = value.split('.'); // Split into integer and decimal parts
            let integerPart = parts[0];
            let decimalPart = parts[1];

            // Ensure only one dot for decimal part
            if (decimalPart !== undefined) {
                decimalPart = decimalPart.slice(0, 2); // Limit decimal part to 2 digits
            }

            // Reconstruct value with proper decimal format
            if (decimalPart !== undefined) {
                value = integerPart + '.' + decimalPart;
            } else {
                value = integerPart;
            }

            $(this).val(value);
        });

        // Add blur event listener
        $('#modal_add_basic_pay, #modal_add_rate_per_day, #modal_add_rate_per_hour, #modal_add_ot_rate_per_hour').on('blur', function() {
            let value = $(this).val().trim();

            // Check if value is valid number
            if (value === '') {
                $(this).val('0.00'); // Set default value if empty
            } else {
                let floatValue = parseFloat(value);
                if (!isNaN(floatValue)) {
                    // Format to 2 decimal places
                    $(this).val(floatValue.toFixed(2));
                } else {
                    $(this).val('0.00'); // Set default value if parsing fails
                }
            }
        });
        $('#btn-cancel-record').on('click', function() {
            // show the confirmation
            Swal.fire({
                title: 'Are you Sure?',
                    text: 'All unsaved progress will be lost.',
                    icon: 'warning',
                    showCancelButton: true,
                    allowEnterKey: false,
                    allowOutsideClick: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = "/employees";
                }
            }
            );
        });
        $('#modal_add_date_hired, #modal_add_date_separated').on('input', function() {
            const birthdate = new Date($(this).val());
            const today = new Date();

            // Check if the entered birthdate is valid (not in the future)
            if (birthdate > today) {
                // If birthdate is in the future, reset the input value and show a SweetAlert message
                $(this).val(''); // Reset the birthdate input field

                // Display SweetAlert message
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Date',
                    text: 'Please select a date that is not in the future.',
                    confirmButtonText: 'OK'
                });

                return; // Exit the function
            }
        });
    });

        // Handle province selection
        $('#modal_edit_province').on('change', function() {
            var provinceId = $(this).val();
            if (provinceId) {
                $('#modal_edit_city').prop('disabled', false);
                $.ajax({
                    url: '/get-cities/' + provinceId, // Replace with your route to fetch cities by province
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#modal_edit_city').empty();
                        $('#modal_edit_city').append('<option value="" selected disabled>-- Select City --</option>');
                        $.each(data, function(index, city) {
                            $('#modal_edit_city').append('<option value="' + city.id + '">' + city.name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                $('#modal_edit_city').empty().prop('disabled', true);
            }
        });

        $('#modal_edit_city').on('change', function() {
            var cityId = $(this).val();
            if (cityId) {
                $('#modal_edit_barangay').prop('disabled', false);
                $.ajax({
                    url: '/get-barangays/' + cityId, // Replace with your route to fetch barangays by city
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#modal_edit_barangay').empty();
                        $('#modal_edit_barangay').append('<option value="" selected disabled>-- Select Barangay --</option>');
                        $.each(data, function(index, barangay) {
                            $('#modal_edit_barangay').append('<option value="' + barangay.id + '">' + barangay.name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                $('#modal_edit_barangay').empty().prop('disabled', true);
            }
        });



        function displayImage(input) {
        var preview = $('#add_image_preview , #edit_image_preview'); // or $('#edit_image_preview') for the edit case
        var file = input.files[0];
        var reader = new FileReader();

        reader.onloadend = function () {
            preview.attr('src', reader.result);
            preview.css('display', 'block');
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.attr('src', '');
            preview.css('display', 'none');
        }
    }
</script>
@endsection
