@extends('adminlte::page')

@section('title', 'Sales Orders')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Sales Orders</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ url('sales-orders/create') }}" target="_self" class="btn btn-primary"><i class="fas fa-cart-plus"></i> Create Sales Order</a>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <div class="form-group">
                    <label>Date range:</label>
                    <div class="col-sm-6">
                    <div class="input-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text">
                    <i class="far fa-calendar-alt"></i>
                    </span>
                    </div>
                    <input type="text" class="form-control float-right" id="reservation">
                    </div>
                    </div>
                    </div>
                <table id="dt_sales_orders" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">SO #</th>
                            <th class="text-center">Transaction Type</th>
                            <th class="text-center">BCID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Total Amount</th>
                            <th class="text-center">Total NUC</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Created By</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>    
        </div>
    </div>

    {{-- hidden form to submit SO for invoicing --}}
    <form id="form_for_invoicing" method="POST">
        @method('PATCH')
            <input type="hidden" name="uuid" id="hidden_uuid">
            <input type="hidden" name="status_id" value="2">
        @csrf
    </form>
@endsection

@section('adminlte_js')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#dt_sales_orders').DataTable({
            dom: 'Bfrtip',
            serverSide: true,
            processing: true,
            deferRender: true,
            paging: true,
            searching: true,
            lengthMenu: [[10, 25, 50, -1], ['10 rows', '25 rows', '50 rows', "Show All"]],  
            buttons: [
                {
                    extend: 'pageLength',
                    className: 'btn-default btn-sm',
                },
            ],
            ajax: $.fn.dataTable.pipeline({
                url: "{{ route('sales_orders_list') }}",
                pages: 20 // number of pages to fetch
            }),
            columns: [
                {
                    data: 'so_no',
                    class: 'text-center',
                    render: function(data, type, row, meta){
                        if(type === 'display'){
                            return '<a href="' + window.location.origin + '/sales-orders/' + row.uuid + '" target="_self">' + data + '</a>';
                        }
                    }
                },
                {data: 'transaction_type.name', class: 'text-center'},
                {data: 'bcid', class: 'text-center'},
                {data: 'distributor_name', class: 'text-center'},
                {data: 'total_amount', class: 'text-right'},
                {data: 'total_nuc', class: 'text-right'},
                {
                    data: 'status.name',
                    class: 'text-center',
                    render: function(data, type, row, meta) {
                        return '<span class="badge badge-info">' + data.toUpperCase() + '</span>'
                    }
                },
                {data: 'created_by', class: 'text-center'},
                {
                    data: 'id',
                    class: 'text-center',
                    searchable: false,
                    orderable: false, 
                    render: function(data, type, row, meta){
                        if(type === 'display'){
                            return '<button class="btn btn-sm btn-default mx-1 btn-for-invoice" data-uuid="' + row.uuid + '" data-so-no="' + row.so_no + '"><i class="fas fa-sign-in-alt"></i>&nbsp;Submit</button>' + 
                            '<a href="' + window.location.origin + '/sales-orders/' + row.uuid + '/edit' + '"target="_self" class="btn btn-sm btn-primary mx-1"><i class="fas fa-edit"></i>&nbsp;Edit</a>';
                        }
                    }

                },
            ],
            language: {
                processing: "<img src='{{ asset('images/spinloader.gif') }}' width='32px'>&nbsp;&nbsp;Loading. Please wait..."
            },

        });

        // use this format to target any class that is dynamically created by js 
        $(document).on('click','.btn-for-invoice', function() {
            var uuid = $(this).attr("data-uuid");
            var so_no = $(this).attr("data-so-no");

            // show the confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: 'Submit ' + so_no + ' for Invoicing!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // add uuid dynamically to hidden uuid field
                    $('#hidden_uuid').val(uuid);

                    // update the action of form_for_invoicing 
                    $('#form_for_invoicing').attr('action', window.location.origin + '/sales-orders/' + uuid);

                    // finally, submit the form
                    $('#form_for_invoicing').submit();
                }
            });
        });
    });
</script>
@endsection

@section('adminlte_js')
<script src="../../plugins/jquery/jquery.min.js"></script>

<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="../../plugins/select2/js/select2.full.min.js"></script>

<script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>

<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/jquery.inputmask.min.js"></script>

<script src="../../plugins/daterangepicker/daterangepicker.js"></script>

<script src="../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>

<script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

<script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>

<script src="../../plugins/bs-stepper/js/bs-stepper.min.js"></script>

<script src="../../plugins/dropzone/min/dropzone.min.js"></script>

<script src="../../dist/js/adminlte.min.js?v=3.2.0"></script>

<script src="../../dist/js/demo.js"></script>


<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker

  })
  // BS-Stepper Init
  document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
  })

  // DropzoneJS Demo Code Start
  Dropzone.autoDiscover = false

  // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
  var previewNode = document.querySelector("#template")
  previewNode.id = ""
  var previewTemplate = previewNode.parentNode.innerHTML
  previewNode.parentNode.removeChild(previewNode)

  var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
    url: "/target-url", // Set the url
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    parallelUploads: 20,
    previewTemplate: previewTemplate,
    autoQueue: false, // Make sure the files aren't queued until manually added
    previewsContainer: "#previews", // Define the container to display the previews
    clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
  })

  myDropzone.on("addedfile", function(file) {
    // Hookup the start button
    file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
  })

  // Update the total progress bar
  myDropzone.on("totaluploadprogress", function(progress) {
    document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
  })

  myDropzone.on("sending", function(file) {
    // Show the total progress bar when upload starts
    document.querySelector("#total-progress").style.opacity = "1"
    // And disable the start button
    file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
  })

  // Hide the total progress bar when nothing's uploading anymore
  myDropzone.on("queuecomplete", function(progress) {
    document.querySelector("#total-progress").style.opacity = "0"
  })

  // Setup the buttons for all transfers
  // The "add files" button doesn't need to be setup because the config
  // `clickable` has already been specified.
  document.querySelector("#actions .start").onclick = function() {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
  }
  document.querySelector("#actions .cancel").onclick = function() {
    myDropzone.removeAllFiles(true)
  }
  // DropzoneJS Demo Code End
</script>
@endsection