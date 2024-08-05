@extends('adminlte::page')

@section('title', 'Employees')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Employee Management</h1>
            </div>                           
            <div class="col-sm-6 text-right">
            <a href="{{ url('employees/create') }}" class="btn btn-primary {{ Helper::BP(8,2) }}"><i class="fas fa-user-plus"></i> Add New Employee</a>
            </div>
        </div>
    </div>
@stop

@php
    $show_button_state = Helper::BP(8,3);
    $edit_button_state = Helper::BP(8,4);
@endphp

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">


                <table id="dt_sales_orders" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">Code</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Department</th>
                            <th class="text-center">Job Title</th>
                            <th class="text-center">Active</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                            <tr>
                                <td class="text-center"><a href="{{ url('employees/' . $employee->uuid ) }}" class="{{ Helper::BP(8,3) }}" target="_self">{{ $employee->code }}</a></td>
                                <td class="text-center">{{ $employee->full_name }}</td>
                                <td class="text-center">{{ $employee->department->name ?? NULL }}</td>
                                <td class="text-center">{{ $employee->role->name ?? NULL}}</td>
                                <td class="text-center">
                                    @if($employee->active == 1)
                                        <i class="fas fa-check-circle" style="color:#28a745"></i>
                                    @else
                                        <i class="fas fa-times-circle" style="color:#dc3545"></i>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ url('employees/' . $employee->uuid . '/edit' ) }}" 
                                        class="btn btn-primary {{ Helper::BP(8,4) }}">
                                        <i class="far fa-edit"></i>&nbsp;Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>    
        </div>
    </div>

<style>
    input[type="text2"], textarea {
      color: #ffffff;
      text-align: left;
      border: none;
      outline: none;
      font-weight: bold;
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
    
    #modal_show_images {
        display: block;
        margin: auto;
        max-width: 100%;
        max-height: 100%;
        border: 2px solid #ccc; /* You can customize the border color */
        box-sizing: border-box; /* Ensures that the border is included in the total width/height */
    }
    
    </style>


@endsection

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
        
        // re-initialize the datatable
        $('#dt_sales_orders').DataTable({
            dom: 'Bfrtip',
            // serverSide: true,
            // processing: true,
            deferRender: true,
            paging: true,
            searching: true,
            lengthMenu: [[10, 25, 50, -1], ['10 rows', '25 rows', '50 rows', "Show All"]],  
            order: [[4, 'desc']],
            buttons: [
                {
                    extend: 'pageLength',
                    className: 'btn-default btn-sm',
                },
            ],
            language: {
                processing: "<img src='{{ asset('images/spinloader.gif') }}' width='32px'>&nbsp;&nbsp;Loading. Please wait..."
            },
        });

        $('#modal_add_code, #modal_add_first_name, #modal_add_middle_name, #modal_add_last_name').on('input', function() {
                var inputText = $(this).val();
                var uppercaseText = inputText.toUpperCase();
                $(this).val(uppercaseText);
            });
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

        // Function to display image on tab
        function displayImage(input) {
        var preview = $('#add_image_preview'); // or $('#edit_image_preview') for the edit case
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