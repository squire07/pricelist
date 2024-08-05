@extends('adminlte::page')

@section('title', 'employee Management')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Employee Details</h1>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
        <h5>Employee Information</h5>
            <div class="row">
                <div class="ribbon-wrapper ribbon-lg">
                    <div class="ribbon 
                        @if ($employee->active === 1)
                            badge-success
                        @else
                            badge-danger
                        @endif
                        text-md text-bold" id="ribbon_bg">
                        {{ $employee->active === 1 ? 'Active' : 'Inactive' }}
                    </div>
                </div>
                <div class="col-md-5 col-sm-12">
                    First Name: <span class="text-bold">{{ $employee->first_name }}</span>
                    <br>
                    Middle Name: <span class="text-bold">{{ $employee->middle_name }}</span>
                    <br>
                    Last Name: <span class="text-bold">{{ $employee->last_name }}</span>
                    <br>
                    Gender: <span class="text-bold">{{ $employee->gender }}</span>
                    <br>
                    Civil Status: <span class="text-bold">{{ $employee->civil_status }}</span>
                    <br>
                    Birthdate: <span class="text-bold">{{ $employee->birthdate }}</span>
                    <br>
                    Age: <span class="text-bold">{{ $employee->age }}</span>
                    <br>
                    Religion: <span class="text-bold">{{ $employee->religion }}</span>
                </div>
                <div class="col-md-5 col-sm-12">
                    Height: <span class="text-bold">{{ $employee->height }}</span>
                    <br>
                    Weight: <span class="text-bold">{{ $employee->weight }}</span>
                    <br>
                    Nationality: <span class="text-bold">{{ $employee->nationality }}</span>
                    <br>
                    Company: <span class="text-bold">{{ $employee->company->name ?? '' }}</span>
                    <br>
                    Department: <span class="text-bold">{{ $employee->department->name ?? '' }}</span>
                    <br>
                    Role: <span class="text-bold">{{ $employee->role->name ?? '' }}</span>
                    <br>
                    Agent Category: <span class="text-bold">{{ $employee->agentcategory->name ?? '' }}</span>
                    <br>
                    Remarks: <span class="text-bold">{{ $employee->remarks }}</span>
                </div>
                <div class="col-md-2 col-sm-12">    
                    @if ($employee->images)
                        <img src="{{ asset($employee->images) }}" alt="Employee Image" class="img-fluid"
                            width="120" height="120"> <!-- Set desired width and height -->
                    @else
                        *No Image Available
                    @endif
                    <br>
                    <span class="text-bold">{{ $employee->code }}</span>
                    <br>
                    <span class="text-bold">{{ $employee->full_name }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
        <h5>Additional Details</h5>
            <div class="row">
                    <div class="col-md-5 col-sm-12">
                    TIN: <span class="text-bold">{{ $employee->tin }}</span>
                    <br>
                    Philhealth: <span class="text-bold">{{ $employee->philhealth }}</span>
                    <br>
                    SSS: <span class="text-bold">{{ $employee->sss }}</span>
                    <br>
                    PAG-IBIG: <span class="text-bold">{{ $employee->pagibig }}</span>
                    <br>
                    National ID: <span class="text-bold">{{ $employee->national_id }}</span>
                    <br>
                    UMID: <span class="text-bold">{{ $employee->umid }}</span>
                    <br>
                    Passport: <span class="text-bold">{{ $employee->passport }}</span>
                    <br>
                    Drivers License: <span class="text-bold">{{ $employee->drivers_license }}</span>
                </div>
                <div class="col-md-5 col-sm-12">
                    Street: <span class="text-bold">{{ $employee->street }}</span>
                    <br>
                    Barangay: <span class="text-bold">{{ $employee->barangays->name ?? ''}}</span>
                    <br>
                    City: <span class="text-bold">{{ $employee->cities->name ?? ''}}</span>
                    <br>
                    Province: <span class="text-bold">{{ $employee->provinces->name ?? ''}}</span>
                    <br>
                    Zip Code: <span class="text-bold">{{ $employee->zip_code }}</span>
                    <br>
                    Contact Number: <span class="text-bold">{{ $employee->contact_number }}</span>
                    <br>
                    Emergency Contact Name: <span class="text-bold">{{ $employee->emergency_contact_name }}</span>
                    <br>
                    Emergency Contact Number: <span class="text-bold">{{ $employee->emergency_contact_number }}</span>
                </div>
            </div>
        </div>
    </div>

    @php
    $allowedRoles = [1,2]; // Define an array of allowed role_id values
    @endphp

    @if(in_array(auth()->user()->role_id, $allowedRoles))
    <div class="card mt-4">
        <div class="card-body">
        <h5>Payroll Details</h5>
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    Employment Type: <span class="text-bold">{{ $employee->employee_type }}</span>
                    <br>
                    Pay Frequency: <span class="text-bold">{{ $employee->pay_frequency }}</span>
                    <br>
                    Date Hired: <span class="text-bold">{{ $employee->date_hired }}</span>
                    <br>
                    Date Separated: <span class="text-bold">{{ $employee->date_separated }}</span>
                </div>
                <div class="col-md-5 col-sm-12">
                    Basic Pay: <span class="text-bold">{{ $employee->basic_pay ?? '' }}</span>
                    <br>
                    Rate Per Day: <span class="text-bold">{{ $employee->rate_per_day ?? '' }}</span>
                    <br>
                    Rate Per Hour: <span class="text-bold">{{ $employee->rate_per_hour ?? ''}}</span>
                    <br>
                    OT Rate per Hour: <span class="text-bold">{{ $employee->ot_rate_per_hour ?? ''}}</span>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- hidden form to submit SO for invoicing --}}
    <!-- <form id="form_for_submit" method="POST">
        @method('PATCH')
            <input type="hidden" name="uuid" id="hidden_uuid">
            <input type="hidden" name="employee_status" value="Completed">
            <input type="hidden" name="delivered_date" id="hidden_delivered_date">
        @csrf
    </form> -->
@endsection

@section('adminlte_css')
<style>
.table-bordered {
    border: 0px solid #dee2e6;
}

tfoot tr td:first-child {
    border: none !important;
}

</style>
@endsection

@section('adminlte_js')
<script>
$(document).ready(function() {
    $('#posting_datetime').datetimepicker({
            defaultDate: new Date(), 
            maxDate: new Date(),
            icons: { 
                time: 'far fa-clock' 
            } 
        });


    $('#btn-for-submit').on('click', function() {
        var uuid = $(this).data("uuid");
        var dr_no = $(this).data("dr-no");

        // Get the current date in YYYY-MM-DD format
        var currentDate = new Date().toISOString().slice(0, 10);

        // Show the confirmation with date input
        Swal.fire({
            title: 'Are you sure you want to finalize order # ' + dr_no + ' ?\n\nEnter actual employee date.',
            icon: 'warning',
            html: '<input id="datepicker" type="date" class="form-control" autofocus value="' + currentDate + '">',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Complete Order!',
            onOpen: function() {
                // No need to initialize a datepicker library, use native behavior
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Add uuid dynamically to hidden uuid field
                $('#hidden_uuid').val(uuid);

                // Get the selected date from the datepicker input
                var date_delivered = $('#datepicker').val();

                // Set the selected date in the hidden field
                $('#hidden_delivered_date').val(date_delivered);

                // Update the action of form_for_submit
                $('#form_for_submit').attr('action', window.location.origin + '/employee-management/' + uuid);

                // Submit the form
                $('#form_for_submit').submit();
            }
        });
    });
});
</script>
@endsection