@extends('adminlte::page')

@section('title', 'Test Build Report')

@section('content_header')
    <h1>Test Build Report</h1>

    {{-- <form action="generate" method="GET">
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label>Start Date:</label>
                    <input type="date" class="form-control datetimepicker-input input-date" name="start_date" id="start_date" required/>
                <label>End Date:</label>
                    <input type="date" class="form-control datetimepicker-input input-date" name="end_date" id="end_date" required/>           
            </div>      
        <input type="submit" class="btn btn-info" name="submit" value="Generate">       
        </div> 
    </form> --}}
    <div class="form-group">
        <label>Date range:</label>
        <div class="input-group">
        <div class="input-group-prepend">
        <span class="input-group-text">
        <i class="far fa-calendar-alt"></i>
        </span>
        </div>
        <input type="text" class="form-control float-right" id="reservation">
        </div>
        
        </div>
    <script>
        // document.getElementById("start_date").valueAsDate = new Date();
        // document.getElementById("end_date").valueAsDate = new Date();
        <script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });

    //Date and time picker
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
}
</script>
    </script>
@endsection
