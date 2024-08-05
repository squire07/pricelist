@extends('adminlte::page')

@section('title', 'Products')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Products</h1>
            </div>
            <div class="col-sm-6 text-right">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add" {{ Helper::BP(9,2) }}>Add Product</button>
            </div>
        </div>
    </div>
@stop

@php
    $show_button_state = Helper::BP(9,3);
    $edit_button_state = Helper::BP(9,4);
@endphp

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <table id="dt_role" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Code</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Brand</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">SRP</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Created By</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td class="text-center">{{ $product->id }}</td>
                                <td class="text-center">{{ $product->code }}</td>
                                <td class="text-left">{{ $product->description }}</td>
                                <td class="text-center">{{ $product->brands->name ?? null }}</td>
                                <td class="text-center">{{ $product->product_category->name ?? null}}</td>
                                <td class="text-center">{{ $product->orig_srp }}</td>
                                <td class="text-center">
                                    @if($product->status == 1)
                                        <span class="badge badge-success">Enabled</span>
                                    @else
                                        <span class="badge badge-danger">Disabled</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $product->created_by }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-default btn_show" 
                                    data-toggle="modal"
                                    data-target="#modal-show"
                                    data-id="{{ $product->id }}"
                                    data-uuid="{{ $product->uuid }}"
                                    data-product-name="{{ $product->name }}"
                                    data-product-description="{{ $product->description }}"
                                    data-product-upc="{{ $product->upc }}" 
                                    data-product-code="{{ $product->code }}" 
                                    data-product-product_category="{{ $product->product_category->name ?? null}}" 
                                    data-product-brands="{{ $product->brands->name ?? null}}" 
                                    data-product-size="{{ $product->size }}" 
                                    data-product-uom="{{ $product->uom }}" 
                                    data-product-uom_abbrv="{{ $product->uom_abbrv }}" 
                                    data-product-pack_size="{{ $product->pack_size }}" 
                                    data-product-size_in_kg="{{ $product->size_in_kg }}" 
                                    data-product-packs_per_case="{{ $product->packs_per_case }}" 
                                    data-product-orig_srp="{{ $product->orig_srp }}" 
                                    data-product-spec_srp="{{ $product->spec_srp }}" 
                                    data-product-remarks="{{ $product->remarks }}" 
                                    data-product-updated_by="{{ $product->updated_by }}"
                                    data-product-images="{{ $product->images }}"
                                    data-product-status="{{ $product->status }}"
                                    {{ $show_button_state }}>
                                    <i class="far fa-eye"></i>&nbsp;Show
                                </button>
                                    <button type="button" class="btn btn-sm btn-primary btn_edit" 
                                        data-toggle="modal" 
                                        data-target="#modal-edit" 
                                        data-id="{{ $product->id }}"
                                        data-uuid="{{ $product->uuid }}"
                                        data-product-name="{{ $product->name }}"
                                        data-product-description="{{ $product->description }}"
                                        data-product-upc="{{ $product->upc }}" 
                                        data-product-code="{{ $product->code }}" 
                                        data-product-product_category="{{ $product->category_id }}" 
                                        data-product-brands="{{ $product->brand_id}}" 
                                        data-product-size="{{ $product->size }}" 
                                        data-product-uom="{{ $product->uom }}" 
                                        data-product-uom_abbrv="{{ $product->uom_abbrv }}" 
                                        data-product-pack_size="{{ $product->pack_size }}" 
                                        data-product-size_in_kg="{{ $product->size_in_kg }}" 
                                        data-product-packs_per_case="{{ $product->packs_per_case }}" 
                                        data-product-orig_srp="{{ $product->orig_srp }}" 
                                        data-product-spec_srp="{{ $product->spec_srp }}" 
                                        data-product-remarks="{{ $product->remarks }}" 
                                        data-product-updated_by="{{ $product->updated_by }}"
                                        data-product-images="{{ $product->images }}"
                                        data-product-status="{{ $product->status }}"
                                        {{ $edit_button_state }}>
                                        <i class="fas fa-pencil-alt"></i>&nbsp;Edit
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>    
        </div>
    </div>

    <div class="row">
        <div class="modal fade" id="modal-add" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create New Product</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="form-horizontal" action="{{ route('products.store') }}" method="POST" id="form_modal_add" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="name" data-required="true">Name</label>
                                <textarea rows="3" class="form-control form-control-sm" name="name" id="modal_add_name" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="description">Full Product Name</label>
                                <textarea rows="3" class="form-control form-control-sm" name="description" id="modal_add_description" required readonly></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="code" data-required="true">Code</label>
                                <input type="text" class="form-control form-control-sm" name="code" maxlength="4" id="modal_add_code" required> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                              <label for="brand_id" data-required="true">Brand Category</label>
                                <select class="form-control form-control-sm" name="brand_id" id="modal_add_brand_id" required>
                                    <option value="" selected disabled>-- Select Category --</option>
                                        @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                              <label for="category" data-required="true">Product Category</label>
                                <select class="form-control form-control-sm" name="category_id" id="modal_add_category_id" required>
                                    <option value="" selected disabled>-- Select Category --</option>
                                        @foreach($product_categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="email" data-required="true">Original SRP</label>
                                <input type="text" class="form-control form-control-sm" name="orig_srp" id="modal_add_orig_srp" placeholder="0.00" required>
                            </div>
                            <div class="col-6">
                                <label for="email" data-required="true">Special SRP</label>
                                <input type="text" class="form-control form-control-sm" name="spec_srp" id="modal_add_spec_srp" placeholder="0.00" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="email" data-required="true">UOM</label>
                                <select class="form-control form-control-sm" name="uom" id="modal_add_uom" required>
                                    <option value="" selected disabled> -- Select UOM --</option>
                                    <option value="KILOGRAMS">KILOGRAMS</option>
                                    <option value="GRAMS">GRAMS</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="email">UOM Abbrv</label>
                                <input type="text" class="form-control form-control-sm" name="uom_abbrv" id="modal_add_uom_abbrv" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="email" data-required="true">Size</label>
                                <input type="text" class="form-control form-control-sm" name="size" id="modal_add_size" required>
                            </div>
                            <div class="col-6">
                                <label for="email">Pack Size</label>
                                <input type="text" class="form-control form-control-sm" name="pack_size" id="modal_add_pack_size" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="email">Packs per Case</label>
                                <input type="text" class="form-control form-control-sm" name="packs_per_case" id="modal_add_packs_per_case">
                            </div>
                            <div class="col-6">
                                <label for="email">Size in KG</label>
                                <input type="text" class="form-control form-control-sm" name="size_in_kg" id="modal_add_size_in_kg" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="email">Remarks</label>
                                <textarea rows="3" class="form-control form-control-sm" name="remarks" id="modal_add_remarks"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="image">Product Image</label>
                                <input type="file" class="form-control-file" name="images" id="modal_add_image" accept="image/*" onchange="displayImage(this)">
                                <div class="image-container">
                                    <img src="" alt="Preview Image" id="add_image_preview" class="uploaded-image">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm m-2"><i class="fas fa-save mr-2"></i>Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    {{--  modal for create --}}
    <div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Product</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="form-horizontal" action="" method="POST" id="form_modal_edit" autocomplete="off">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="name" data-required="true">Name</label>
                                <textarea rows="3" class="form-control form-control-sm" name="name" id="modal_edit_name" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="description" data-required="true">Full Product Name</label>
                                <textarea rows="3" class="form-control form-control-sm" name="description" id="modal_edit_description" required readonly></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="code" data-required="true">Code</label>
                                <input type="text" class="form-control form-control-sm" name="code" maxlength="4" id="modal_edit_code" required> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                              <label for="brand_id" data-required="true">Brand Category</label>
                                <select class="form-control form-control-sm" name="brand_id" id="modal_edit_brand_id" required>
                                    <option value="" selected disabled>-- Select Category --</option>
                                        @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                              <label for="category" data-required="true">Product Category</label>
                                <select class="form-control form-control-sm" name="category_id" id="modal_edit_category_id" required>
                                    <option value="" selected disabled>-- Select Category --</option>
                                        @foreach($product_categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="email" data-required="true">Original SRP</label>
                                <input type="text" class="form-control form-control-sm" name="orig_srp" id="modal_edit_orig_srp" placeholder="0.00" required>
                            </div>
                            <div class="col-6">
                                <label for="email" data-required="true">Special SRP</label>
                                <input type="text" class="form-control form-control-sm" name="spec_srp" id="modal_edit_spec_srp" placeholder="0.00" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="email" data-required="true">UOM</label>
                                <select class="form-control form-control-sm" name="uom" id="modal_edit_uom" required>
                                    <option value="" disabled> -- Select UOM --</option>
                                    <option value="KILOGRAMS">KILOGRAMS</option>
                                    <option value="GRAMS">GRAMS</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="email">UOM Abbrv</label>
                                <input type="text" class="form-control form-control-sm" name="uom_abbrv" id="modal_edit_uom_abbrv" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="email" data-required="true">Size</label>
                                <input type="text" class="form-control form-control-sm" name="size" id="modal_edit_size" required>
                            </div>
                            <div class="col-6">
                                <label for="email">Pack Size</label>
                                <input type="text" class="form-control form-control-sm" name="pack_size" id="modal_edit_pack_size" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="email">Packs per Case</label>
                                <input type="text" class="form-control form-control-sm" name="packs_per_case" id="modal_edit_packs_per_case">
                            </div>
                            <div class="col-6">
                                <label for="email">Size in KG</label>
                                <input type="text" class="form-control form-control-sm" name="size_in_kg" id="modal_edit_size_in_kg">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="email">Remarks</label>
                                <textarea rows="3" class="form-control form-control-sm" name="remarks" id="modal_edit_remarks"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <label for="code">Product Status</label>
                                <div class="col-12">
                                    <input type="radio" name="status" value="1">
                                    <label for="" class="mr-4">Enabled</label>
                                    <input type="radio" name="status" value="0">
                                    <label for="">Disabled</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="image">Change Image?</label>
                                <input type="file" class="form-control-file" name="images" id="modal_edit_image" accept="image/*" onchange="displayImage(this)">
                                <div class="image-container">
                                    <img src="" alt="Preview Image" id="edit_image_preview" class="uploaded-image">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm m-2" id="btn_modal_edit_submit"><i class="fas fa-save mr-2"></i>Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--  modal for show --}}
    <div class="modal fade" id="modal-show" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Product Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">      
                    <div class="row">
                        <table class="table table-borderless">
                            <div class="col-12">
                                <div id="product_image_container">
                                    <img id="modal_show_images" class="img-fluid" alt="Product Image">
                                </div>
                            </div>
                            <tr>
                                <td width="25%">Status</td>
                                <td>
                                    <span id="modal_show_status" style="font-weight:bold"></span>
                                    <span id="status_badge"></span>
                                </td>
                            </tr>
                            <tr>
                                <td width="25%">Name</td>
                                <td><span id="modal_show_name" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Description</td>
                                <td><span id="modal_show_description" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Code</td>
                                <td><span id="modal_show_code" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Brand</td>
                                <td><span id="modal_show_brands" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Category</td>
                                <td><span id="modal_show_product_category" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Size</td>
                                <td><span id="modal_show_size" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">UOM</td>
                                <td><span id="modal_show_uom" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">UOM Abbrv</td>
                                <td><span id="modal_show_uom_abbrv" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Pack Size</td>
                                <td><span id="modal_show_pack_size" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Packs per Case</td>
                                <td><span id="modal_show_packs_per_case" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Orig SRP</td>
                                <td><span id="modal_show_orig_srp" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Spec SRP</td>
                                <td><span id="modal_show_spec_srp" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Remarks</td>
                                <td><span id="modal_show_remarks" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Updated By</td>
                                <td><span id="modal_show_updated_by" style="font-weight:bold"></span></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal">Close</button>
                </div>
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

/* Style for text within labels */
label[for][data-required="true"]::after {
    content: " *";
    color: red;
}
</style>

@endsection

@section('adminlte_js')
<script>

    // initialize select2 on this page using bootstrap 4 theme
    $('.select2').select2({
        theme: 'bootstrap4'
    });


    $(document).ready(function() {
        $('#dt_role').DataTable({
            dom: 'Bfrtip',
            autoWidth: true,
            responsive: true,
            order: [[ 0, "asc" ]],
            searching: true,
            lengthMenu: [[10, 25, 50, -1], ['10 rows', '25 rows', '50 rows', "Show All"]],  
            buttons: [
                {
                    extend: 'pageLength',
                    className: 'btn-default btn-sm',
                },
            ],
            columnDefs: [ 
                {
                    targets: [8], // column index (start from 0)
                    orderable: false, // set orderable false for selected columns
                }
            ],
            initComplete: function () {
                $("#dt_role").wrap("<div style='overflow:auto;width:100%;position:relative;'></div>");

                var elements = document.getElementsByClassName('btn-secondary');
                while(elements.length > 0){
                    elements[0].classList.remove('btn-secondary');
                }
            }
        });

        // use class instead of id because the button are repeating. ID can be only used once
        $(document).on('click', '.btn_edit', function() {
            var uuid = $(this).attr("data-uuid");
            var name = $(this).attr("data-product-name");
            var description = $(this).attr("data-product-description");
            var code = $(this).attr("data-product-code");
            var product_category = $(this).attr("data-product-product_category");
            var brands = $(this).attr("data-product-brands");
            var size = $(this).attr("data-product-size");
            var uom = $(this).attr("data-product-uom");
            var uom_abbrv = $(this).attr("data-product-uom_abbrv");
            var pack_size = $(this).attr("data-product-pack_size");
            var size_in_kg = $(this).attr("data-product-size_in_kg");
            var packs_per_case = $(this).attr("data-product-packs_per_case");
            var orig_srp = $(this).attr("data-product-orig_srp");
            var spec_srp = $(this).attr("data-product-spec_srp");
            var remarks = $(this).attr("data-product-remarks");
            var updated_by = $(this).attr("data-product-updated_by");
            var images = $(this).attr("data-product-images");
            var status = $(this).attr("data-product-status");

            $('#modal_edit_name').val(name);
            $('#modal_edit_description').val(description);
            $('#modal_edit_code').val(code);
            $('#modal_edit_size').val(size);
            $('#modal_edit_uom').val(uom);
            $('#modal_edit_uom_abbrv').val(uom_abbrv);
            $('#modal_edit_pack_size').val(pack_size);
            $('#modal_edit_size_in_kg').val(size_in_kg);
            $('#modal_edit_packs_per_case').val(packs_per_case);
            $('#modal_edit_orig_srp').val(orig_srp);
            $('#modal_edit_spec_srp').val(spec_srp);
            $('#modal_edit_remarks').val(remarks);
            $('#modal_edit_updated_by').val(updated_by);
            $('#modal_edit_images').attr('src', images);
            $('#modal_edit_category_id option[value=' + product_category + ']').attr('selected', 'selected');
            $('#modal_edit_brand_id option[value=' + brands + ']').attr('selected', 'selected');

            // Set status radio button based on the 'status' value
            if(status == 1) {
                $('input[type="radio"][value="1"]').prop('checked', true);
            } else if(status == 0) {
                $('input[type="radio"][value="0"]').prop('checked', true);
            } 

            // define the edit form action
            let action = window.location.origin + "/products/" + uuid;
            $('#form_modal_edit').attr('action', action);
        });

        $(document).on('click', '.btn_show', function() {
            var uuid = $(this).attr("data-uuid");
            var name = $(this).attr("data-product-name");
            var description = $(this).attr("data-product-description");
            var code = $(this).attr("data-product-code");
            var product_category = $(this).attr("data-product-product_category");
            var brands = $(this).attr("data-product-brands");
            var size = $(this).attr("data-product-size");
            var uom = $(this).attr("data-product-uom");
            var uom_abbrv = $(this).attr("data-product-uom_abbrv");
            var pack_size = $(this).attr("data-product-pack_size");
            var packs_per_case = $(this).attr("data-product-packs_per_case");
            var orig_srp = $(this).attr("data-product-orig_srp");
            var spec_srp = $(this).attr("data-product-spec_srp");
            var remarks = $(this).attr("data-product-remarks");
            var updated_by = $(this).attr("data-product-updated_by");
            var images = $(this).attr("data-product-images");
            var status = $(this).attr("data-product-status");

            // Set multiple attributes
            $('#modal_show_name').text(name);
            $('#modal_show_description').text(description);
            $('#modal_show_code').text(code);
            $('#modal_show_product_category').text(product_category);
            $('#modal_show_brands').text(brands);
            $('#modal_show_size').text(size);
            $('#modal_show_uom').text(uom);
            $('#modal_show_uom_abbrv').text(uom_abbrv);
            $('#modal_show_pack_size').text(pack_size);
            $('#modal_show_packs_per_case').text(packs_per_case);
            $('#modal_show_orig_srp').text(orig_srp);
            $('#modal_show_spec_srp').text(spec_srp);
            $('#modal_show_remarks').text(remarks);
            $('#modal_show_updated_by').text(updated_by);
            $('#modal_show_images').attr('src', images);

            // Set status display based on value
            if (status === '1') {
                $('#modal_show_status').text('Enabled').removeClass('badge-danger').addClass('badge-success');
            } else {
                $('#modal_show_status').text('Disabled').removeClass('badge-success').addClass('badge-danger');
            }
        });


        // Prevent from redirecting back to homepage when cancel button is clicked accidentally
        $('#modal-add , #modal-edit').on("hide.bs.modal", function (e) {

            if (!$('#modal-add , #modal-edit').hasClass('programmatic')) {
                e.preventDefault();
                swal.fire({
                    title: 'Are you sure?',
                    text: "Please confirm that you want to cancel",
                    type: 'warning',
                    showCancelButton: true,
                    allowEnterKey: false,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                }).then(function(result) {
                    if (result.value) {
                        $('#modal-add , #modal-edit').addClass('programmatic');
                        $('#modal-add , #modal-edit').modal('hide');
                        e.stopPropagation();
                        $('#modal_add_name').val('');
                        $('#modal_add_size').val('');
                        $('#modal_add_packs_per_case').val('');
                        $('#modal_add_description').val('');
                        $('#modal_add_code').val('');
                        $('#modal_add_brand_id').val(''); 
                        $('#modal_add_uom').val(''); 
                        $('#modal_add_category_id').val(null).trigger('change');
                        $('#modal_add_remarks').val(''); 
                        $('#modal_add_uom_abbrv').val(''); 
                        $('#modal_add_pack_size').val(''); 
                        $('#modal_add_orig_srp').val(''); 
                        $('#modal_add_spec_srp').val(''); 
                    } else {
                        e.stopPropagation();

                    }
                });

            }
            return true;
        });

        $('#modal-add , #modal-edit').on('hidden.bs.modal', function () {
        $('#modal-add , #modal-edit').removeClass('programmatic');
        });

        // Prevent user from using enter key
            $("input:text, button").keypress(function(event) {
            if (event.keyCode === 10 || event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        $( '#modal-add, #modal-edit' ).on( 'keypress', function( e ) {
        if( event.keyCode === 10 || e.keyCode === 13 ) {
            e.preventDefault();
            $( this ).trigger( 'submit' );
        }
        });

        
        $("#modal_add_name, #modal_add_description, #modal_add_address, #modal_edit_name, #modal_edit_description, #modal_edit_name, #modal_add_remarks").on("keypress", function(event) {
            const forbiddenChars = ["/", "\\"];
            if (forbiddenChars.includes(event.key)) {
                event.preventDefault(); // Prevent adding the character
            }
        });

        $('#modal_add_code, #modal_add_name, #modal_add_description, #modal_edit_code, #modal_edit_name, #modal_edit_description, #modal_edit_remarks').on('input', function() {
            var inputText = $(this).val();
            var uppercaseText = inputText.toUpperCase();
            $(this).val(uppercaseText);
        });

        $('#modal_add_orig_srp, #modal_add_spec_srp, #modal_edit_orig_srp, #modal_edit_spec_srp').on('input', function() {
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
        $('#modal_add_orig_srp, #modal_add_spec_srp, #modal_edit_orig_srp, #modal_edit_spec_srp').on('blur', function() {
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

        $("#modal_add_size, #modal_add_pack_size, #modal_edit_size, #modal_edit_pack_size").on('input', function() {
            // Get the current input value
            let value = $(this).val();

            // Remove any non-digit characters except for one dot
            value = value.replace(/[^0-9.]/g, '');

            // Limit to two decimal places
            const parts = value.split('.');
            if (parts.length > 1) {
                parts[1] = parts[1].slice(0, 2); // Keep only two decimal places
                value = parts.join('.');
            }

            // Update the input value with the formatted value
            $(this).val(value);
        });

        
        $("#modal_add_packs_per_case, #modal_edit_packs_per_case").on('keypress', function() {
            return event.charCode >= 48 && event.charCode <= 57;
        });

        // --------------------- START OF AUTO CONCATE OF ADD FULL PRODUCT NAME --------------------------//
        
        // Select the input fields
        var add_name_input = $('#modal_add_name, #moda_edit_name');
        var add_size_input = $('#modal_add_size, #modal_edit_size');
        var add_uom_input = $('#modal_add_uom_abbrv, #modal_edit_uom_abbrv');

        // Select the readonly full name input
        var full_product_name_input = $('#modal_add_description, #modal_edit_description');

        console.log(full_product_name_input);

        // Add an input event listener to the name and middle name fields
        add_name_input.on('input', updateFullName);
        add_size_input.on('input', updateFullName);
        add_uom_input.on('input', updateFullName);

        // Function to update the full name based on the entered values
        function updateFullName() {
            var fullName = add_name_input.val().toUpperCase() + ' ' + add_size_input.val() + ' ' + add_uom_input.val();
            full_product_name_input.val(fullName);
        }
        // --------------------- END OF ADD CONCATE OF ADD FULL PRODUCT NAME --------------------------//

        // --------------------- START OF AUTO CONCATE OF EDIT FULL PRODUCT NAME --------------------------//
          
        // Select the input fields
        var edit_name_input = $('#modal_edit_name');
        var edit_size_input = $('#modal_edit_size');
        var edit_uom_input = $('#modal_edit_uom_abbrv');

        // Select the readonly full name input
        var edit_product_name_input = $('#modal_edit_description');

        // edit an input event listener to the name and middle name fields
        edit_name_input.on('input', editFullName);
        edit_size_input.on('input', editFullName);
        edit_uom_input.on('input', editFullName);

        // Function to update the full name based on the entered values
        function editFullName() {
            var fullName = edit_name_input.val().toUpperCase() + ' ' + edit_size_input.val() + ' ' + edit_uom_input.val();
            edit_product_name_input.val(fullName);
        }

        // --------------------- END OF EDIT CONCATE OF ADD FULL PRODUCT NAME --------------------------//
        // Add input event listener to the Size input
        $('#modal_add_size').on('input', updatePackSize);
        
        function updateUOMAbbrvAndSize() {
        var selectedUOM = $('#modal_add_uom').val();
        var sizeValue = parseFloat($('#modal_add_size').val());

        if (isNaN(sizeValue)) {
            sizeValue = 0; // Default to 0 if size is not a valid number
        }

        switch (selectedUOM) {
            case 'KILOGRAMS':
                $('#modal_add_uom_abbrv').val('KG');
                $('#modal_add_size_in_kg').val(sizeValue); // Size in KG same as entered size
                break;
            case 'GRAMS':
                $('#modal_add_uom_abbrv').val('G');
                $('#modal_add_size_in_kg').val((sizeValue / 1000)); // Size in KG calculated from grams
                break;
            default:
                $('#modal_add_uom_abbrv').val('');
                $('#modal_add_size_in_kg').val('');
                break;
            }

            // Update Pack Size when UOM changes
            updatePackSize();
        }

        // Bind the updateUOMAbbrvAndSize function to the change event of UOM select
        $('#modal_add_uom').on('change', updateUOMAbbrvAndSize);

        // Bind the updateUOMAbbrvAndSize function to the input event of Size input
        $('#modal_add_size').on('input', updateUOMAbbrvAndSize);

        // Optional: You can also trigger the UOM change event initially to set the initial values
        $('#modal_add_uom').trigger('change');

        function updatePackSize() {
        // Get the Size value input
            var sizeInput = $('#modal_add_size, #modal_edit_size').val().trim(); // Get the input value and trim whitespace

            // Check if the input is a valid number
            if (!sizeInput || isNaN(sizeInput)) {
                // If input is empty or not a valid number, set a default value or display an error
                $('#modal_add_pack_size, #modal_edit_pack_size').val('');
                return; // Exit the function early
            }

            // Convert the Size value to a float
            var sizeValue = parseFloat(sizeInput);

            // Check if sizeValue is a valid number
            if (isNaN(sizeValue)) {
                // If parsing resulted in NaN (shouldn't happen if input was validated)
                $('#modal_add_pack_size, #modal_edit_pack_size').val('');
                return; // Exit the function early
            }

            // Round the sizeValue to 2 decimal places
            //sizeValue = sizeValue.toFixed(2);

            // Get the UOM Abbreviation
            var uomAbbrv = $('#modal_add_uom_abbrv, #modal_edit_uom_abbrv').val();

            // Update Pack Size based on Size and UOM Abbreviation
            $('#modal_add_pack_size, #modal_edit_pack_size').val(sizeValue + ' ' + uomAbbrv);
        }
    });


    // ----------- AUTO POPULATE EDIT DESCRIPTION -------------//

    // edit input event listener to the Size input
    $('#modal_edit_size').on('input', editPackSize);

    function editUOMAbbrv() {
        var selectedUOM = $('#modal_edit_uom').val();
        var sizeValue = parseFloat($('#modal_edit_size').val());

        if (isNaN(sizeValue)) {
            sizeValue = 0; // Default to 0 if size is not a valid number
        }

        switch (selectedUOM) {
            case 'KILOGRAMS':
                $('#modal_edit_uom_abbrv').val('KG');
                $('#modal_edit_size_in_kg').val(sizeValue); // Size in KG same as entered size
                break;
            case 'GRAMS':
                $('#modal_edit_uom_abbrv').val('G');
                $('#modal_edit_size_in_kg').val((sizeValue / 1000)); // Size in KG calculated from grams
                break;
            default:
                $('#modal_edit_uom_abbrv').val('');
                $('#modal_edit_size_in_kg').val('');
                break;
            }

            // Update Pack Size when UOM changes
            editPackSize();
        }

        // Bind the updateUOMAbbrvAndSize function to the change event of UOM select
        $('#modal_edit_uom').on('change', editUOMAbbrv);

        // Bind the updateUOMAbbrvAndSize function to the input event of Size input
        $('#modal_edit_size').on('input', editUOMAbbrv);

        // Optional: You can also trigger the UOM change event initially to set the initial values
        $('#modal_edit_uom').trigger('change');

    function editPackSize() {
        // Get the Size value input
        var sizeInput = $('#modal_edit_size').val().trim(); // Get the input value and trim whitespace

        // Check if the input is a valid number
        if (!sizeInput || isNaN(sizeInput)) {
            // If input is empty or not a valid number, set a default value or display an error
            $('#modal_edit_pack_size').val('');
            return; // Exit the function early
        }

        // Convert the Size value to a float
        var sizeValue = parseFloat(sizeInput);

        // Check if sizeValue is a valid number
        if (isNaN(sizeValue)) {
            // If parsing resulted in NaN (shouldn't happen if input was validated)
            $('#modal_edit_pack_size').val('');
            return; // Exit the function early
        }

        // // Round the sizeValue to 2 decimal places
        // sizeValue = sizeValue.toFixed(2);

        // Get the UOM Abbreviation
        var uomAbbrv = $('#modal_edit_uom_abbrv').val();

        // Update Pack Size based on Size and UOM Abbreviation
        $('#modal_edit_pack_size').val(sizeValue + ' ' + uomAbbrv);
    }

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