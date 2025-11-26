@extends('backend.layout.main')
@section('content')

<style>
    .img_display_container{    
        width: 100%;
        height: 100%;
        overflow: hidden;
        position: relative;
        z-index: 1;
    }
    .product-img-display{
        height: 600px;
        width: 800px;
        border-width: 5px;
        border-radius: 10px;
        position: fixed;
        padding: 2px;
        background-color: #007bff;
        align-content: center;
        box-shadow: 0px 0px 5px 5px rgba(40, 40, 40, 0.5);
        z-index: 9999;
    }
    .blured_layer{
        width: 100%;
        height: 100%;
        border-width: 5px;
        border-radius: 10px;
        position: absolute;
        top: 0px; left: 0px; right: 0px; bottom: 0px;
        filter: blur(10px);
        z-index: 1;
    }
    .image_container{
        height: 100%;
        width: 100%;
        border-radius: 8.96px;
        object-fit: cover;
        object-position: center;
        overflow: hidden;
    }
    .img_btn_container{
        height: 100%;
        width: 100%;
        position: absolute;
        top: 0;
        left: 0;
        overflow: hidden;
        padding: 10px 10px;
    }
    .bottom-controler-btn,
    .top-controler-btn{
        border-width: 0;
        border-radius: 20px;
        height: 30px;
        width: 30px;
        background-color: rgba(0, 132, 255, 0.0);
    }
    .bottom-controler-btn:hover,
    .top-controler-btn:hover{
        border-width: 0;
        border-radius: 20px;
        height: 30px;
        width: 30px;
        background-color: rgba(109, 211, 255, 0.5);
    }
    .bottom-controller, 
    .top-controller,
    .action-btn{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .controllers{
        width: 100%;
        position: absolute;
        left: 0;
        overflow: hidden;
        padding: 10px 10px;
    }
    .top-controller { 
        top: 0; 
        justify-content: right;
    }
    .bottom-controller { bottom: 0; gap: 10px; }
    .top-controler-btn i{
        font-size: 20px; 
        color:#7d7d7d; 
        transform: scale(0.85, 0.85);
    }
    .thin-icon{
        transform: scale(0.85); 
    }

    .image_container img#view_image{
        height: 100%;
        width: 100%;
        object-fit: contain;
        object-position: center;
    }
    .product-image-container {
        text-align: center;
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .product-image-container img {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .carousel-control-prev,
    .carousel-control-next {
        background-color: rgba(0, 0, 0, 0.3);
        border-radius: 50%;
        width: 40px;
        height: 40px;
        top: 50%;
        transform: translateY(-50%);
    }

    .carousel-control-prev {
        left: 10px;
    }

    .carousel-control-next {
        right: 10px;
    }

    /* Zoom functionality styles */
    .zoom-container {
        position: relative;
        overflow: hidden;
        cursor: zoom-in;
    }

    .zoom-container::after {
        content: "🔍 Hover to zoom";
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
        z-index: 1002;
    }

    .zoom-container:hover::after {
        opacity: 1;
    }

    .zoom-container img {
        transition: transform 0.3s ease;
    }

    .zoom-container:hover img {
        transform: scale(1.5);
    }

    .zoom-lens {
        position: absolute;
        border: 2px solid #007bff;
        background-color: rgba(0, 123, 255, 0.1);
        width: 100px;
        height: 100px;
        display: none;
        pointer-events: none;
        z-index: 1000;
    }

    .zoom-result {
        position: absolute;
        top: 0;
        left: 100%;
        width: 400px;
        height: 400px;
        border: 2px solid #007bff;
        background-color: white;
        display: none;
        z-index: 1001;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    @media (max-width: 768px) {
        .zoom-result {
            left: 0;
            top: 100%;
            width: 300px;
            height: 300px;
        }
    }

    .zoom-result img {
        position: absolute;
        max-width: none;
        max-height: none;
    }
</style>

<!-- Handle success messages from URL parameters -->
@if(request('success') == 'created')
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> Product created successfully.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if(request('success') == 'updated')
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> Product updated successfully.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- Debug session messages -->
@if(session('create_message'))
<div class="alert alert-success">
    {{ session('create_message') }}
</div>
@endif
@if(session('edit_message'))
<div class="alert alert-success">
    {{ session('edit_message') }}
</div>
@endif

@if(session("not_permitted"))
<div class="alert alert-danger alert-dismissible text-center">
    {!! session("not_permitted") !!}
</div>
@endif

@if(session("message"))
<div class="alert alert-danger alert-dismissible text-center">
    {!! session("message") !!}
</div>
@endif

<x-success-message key="create_message" />
<x-success-message key="edit_message" />
<x-success-message key="import_message" />

<section>
    <div class="container-fluid">
        @if(in_array("products-add", $all_permission))
        <a href="{{route('products.create')}}" class="btn btn-info add-product-btn"><i class="dripicons-plus"></i> {{__('file.add_product')}}</a>
        <a href="#" data-toggle="modal" data-target="#importProduct" class="btn btn-primary add-product-btn"><i class="dripicons-copy"></i> {{__('file.import_product')}}</a>
        <!-- this button will navigate visualize the table editor -->
        <a href="#" class="btn btn-danger edit-product-btn"><i title="database" class="fa fa-database"></i> {{__('file.edit_table')}}</a>
        @endif
        @if( in_array("products-edit", $all_permission) && in_array('ecommerce',explode(',',$general_setting->modules)) )
        <a href="{{route('product.allProductInStock')}}" class="btn btn-dark add-product-btn"><i class="dripicons-stack"></i> {{__('file.All Product In Stock')}}</a>
        <a href="{{route('product.showAllProductOnline')}}" class="btn btn-dark add-product-btn"><i class="dripicons-wifi"></i> {{__('file.Show All Product Online')}}</a>
        @endif
        <div class="card mt-3 card-product-filter">
            <h3 class="text-center mt-3">{{__('file.Filter Products')}}</h3>
            <div class="card-body">
                {!! Form::open(['route' => 'products.index', 'method' => 'get']) !!}
                <div class="row">
                    <div class="col-md-3 offset-3 @if(\Auth::user()->role_id > 2){{'d-none'}}@endif">
                        <div class="form-group">
                            <label>{{__('file.Warehouse')}}</label>
                            <select id="warehouse_id" name="warehouse_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins">
                                <option value="0">{{__('file.All Warehouse')}}</option>
                                @foreach($lims_warehouse_list as $warehouse)
                                <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 mt-3">
                        <div class="form-group">
                            <button class="btn btn-primary" id="filter-btn" type="submit">{{__('file.submit')}}</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="card mt-3 d-none card-edit-dbtable">
            <h3 class="text-center mt-3">{{__('file.Filter Products')}}</h3>
            <div class="card-body">
                {!! Form::open(['route' => 'products.index', 'method' => 'get']) !!}
                <div class="row">
                    <div class="col-md-3 offset-3 @if(\Auth::user()->role_id > 2){{'d-none'}}@endif">
                        <div class="form-group">
                            <label>{{__('file.Warehouse')}}</label>
                            <select id="warehouse_id" name="warehouse_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins">
                                <option value="0">{{__('file.All Warehouse')}}</option>
                                @foreach($lims_warehouse_list as $warehouse)
                                <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 mt-3">
                        <div class="form-group">
                            <button class="btn btn-primary" id="filter-btn" type="submit">{{__('file.submit')}}</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>

    </div>
    <div class="table-responsive">
        <table id="product-data-table" class="table" style="width: 100%">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{__('file.product')}}</th>
                    <th>{{__('file.Code')}}</th>
                    <th>{{__('file.Brand')}}</th>
                    <th>{{__('file.category')}}</th>
                    <th>{{__('file.Quantity')}}</th>
                    <th>{{__('file.Unit')}}</th>
                    <th>{{__('file.Price')}}</th>
                    <th>{{__('file.Cost')}}</th>
                    <th>{{__('Stock Worth') . '(' . __('file.Price') . '/' . __('file.Cost') . ')'}}</th>
                    @foreach($custom_fields as $fieldName)
                    <th>{{$fieldName}}</th>
                    @endforeach
                    <th class="not-exported">{{__('action')}}</th>
                </tr>
            </thead>
        </table>
    </div>
</section>

<!-- import product from file section -->
<div id="importProduct" tabindex="-1" role="dialog" aria-labellefiley="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['route' => 'product.import', 'method' => 'post', 'files' => true]) !!}
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">Import Product</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
            </div>
            <div class="modal-body">
                <p class="italic"><small>{{__('file.The field labels marked with * are required input fields')}}.</small></p>
                <p>{{__('file.The correct column order is')}} (image, name*, code*, type*, brand, category*, unit_code*, cost*, price*, product_details, variant_name, item_code, additional_price) {{__('file.and you must follow this')}}.</p>
                <p>{{__('file.To display Image it must be stored in')}} images/product {{__('file.directory')}}. {{__('file.Image name must be same as product name')}}</p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('file.Upload CSV File')}} *</label>
                            {{Form::file('file', array('class' => 'form-control','required'))}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> {{__('file.Sample File')}}</label>
                            <a href="sample_file/sample_products.csv" class="btn btn-info btn-block btn-md"><i class="dripicons-download"></i> {{__('file.Download')}}</a>
                        </div>
                    </div>
                </div>
                {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<!-- product details section -->
<div id="product-details" tabindex="-1" role="dialog" aria-labellefiley="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">{{trans('Product Details')}}</h5>
                <button id="print-btn" type="button" class="btn btn-default btn-sm ml-3"><i class="dripicons-print"></i> {{__('file.Print')}}</button>
                <button id="zoom-toggle" type="button" class="btn btn-info btn-sm ml-2" title="Toggle Zoom"><i class="fa fa-search-plus"></i> Zoom</button>
                <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
            </div>
            <div class="modal-body">
                <!-- Large Image Section at Top -->
                <div class="row mb-4">
                    <div class="col-md-12" id="slider-content"></div>
                </div>

                <!-- Product Details Section -->
                <div class="row">
                    <div class="col-md-12" id="product-content"></div>
                </div>

                <!-- Additional Sections -->
                @if($role_id <= 2)
                    <div class="row mt-3">
                    <div class="col-md-12" id="product-warehouse-section">
                        <h5><b>{{__('file.Warehouse Quantity')}}</b></h5>
                        <table class="table table-bordered table-hover product-warehouse-list">
                            <thead>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
            </div>
            @endif

            <div class="row mt-3">
                <div class="col-md-7" id="product-variant-section">
                    <h5>{{__('file.Product Variant Information')}}</h5>
                    <table class="table table-bordered table-hover product-variant-list">
                        <thead>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                @if($role_id <= 2)
                    <div class="col-md-5" id="product-variant-warehouse-section">
                    <h5>{{__('file.Warehouse quantity of product variants')}}</h5>
                    <table class="table table-bordered table-hover product-variant-warehouse-list">
                        <thead>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
            </div>
            @endif
        </div>

        <h5 id="combo-header"></h5>
        <table class="table table-bordered table-hover item-list">
            <thead>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
</div>
</div>

<div id="product-img-display" role="dialog" class="product-img-display d-none">
    <div id="blured_layer" class="blured_layer"></div>
    <div id="img_display_container" class="img_display_container"></div>
</div>

@endsection
@push('scripts')
<script>
    $("ul#product").siblings('a').attr('aria-expanded', 'true');
    $("ul#product").addClass("show");
    $("ul#product #product-list-menu").addClass("active");

    @if(config('database.connections.saleprosaas_landlord'))
    if (localStorage.getItem("message")) {
        alert(localStorage.getItem("message"));
        localStorage.removeItem("message");
    }

    $('.img_display_container').addClass('d-none').removeClass('show');

    numberOfProduct = <?php echo json_encode($numberOfProduct) ?>;
    $.ajax({
        type: 'GET',
        async: false,
        url: '{{route("package.fetchData", $general_setting->package_id)}}',
        success: function(data) {
            if (data['number_of_product'] > 0 && data['number_of_product'] <= numberOfProduct) {
                $("a.add-product-btn").addClass('d-none');
            }
        }
    });
    @endif

    function confirmDelete() {
        if (confirm("Are you sure want to delete?")) {
            return true;
        }
        return false;
    }

    var columns = [{
        "data": "key"
    }, {
        "data": "name"
    }, {
        "data": "code"
    }, {
        "data": "brand"
    }, {
        "data": "category"
    }, {
        "data": "qty"
    }, {
        "data": "unit"
    }, {
        "data": "price"
    }, {
        "data": "cost"
    }, {
        "data": "stock_worth"
    }];
    var field_name = <?php echo json_encode($field_name) ?>;
    for (i = 0; i < field_name.length; i++) {
        columns.push({
            "data": field_name[i]
        });
    }
    columns.push({
        "data": "options"
    });

    var isMouseDown = false;
    let mouseStartX = 0, elOffsetX = 0;
    let mouseStartY = 0, elOffsetY = 0;
    var elOffset = 0; 
    var warehouse = [];
    var variant = [];
    var qty = [];
    var htmltext;
    var slidertext;
    var product_id = [];
    var all_permission = <?php echo json_encode($all_permission) ?>;
    console.log(all_permission.toString());
    console.log(all_permission.indexOf("products-edit"));
    var role_id = <?php echo json_encode($role_id) ?>;
    var user_verified = <?php echo json_encode(env('USER_VERIFIED')) ?>;
    var logoUrl = <?php echo json_encode(url('logo', $general_setting->site_logo)) ?>;
    var warehouse_id = <?php echo json_encode($warehouse_id); ?>;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#warehouse_id").val(warehouse_id);

    $("#select_all").on("change", function() {
        if ($(this).is(':checked')) {
            $("tbody input[type='checkbox']").prop('checked', true);
        } else {
            $("tbody input[type='checkbox']").prop('checked', false);
        }
    });

    $(document).on("click", "tr.product-link td:not(:first-child, :last-child)", function() {
        productDetails($(this).parent().data('product'), $(this).parent().data('image'));
    });

    $(document).on("click", ".view", function() {
        var product = $(this).parent().parent().parent().parent().parent().data('product');
        var imagedata = $(this).parent().parent().parent().parent().parent().data('imagedata');
        // console.log(product);
        productDetails(product, imagedata);
    });

    $("#print-btn").on("click", function() {
        var divToPrint = document.getElementById('product-details');
        var newWin = window.open('', 'Print-Window');
        newWin.document.open();
        newWin.document.write('<link rel="stylesheet" href="<?php echo asset('vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css"><style type="text/css">@media print {.modal-dialog { max-width: 1000px;} }</style><body onload="window.print()">' + divToPrint.innerHTML + '</body>');
        newWin.document.close();
        setTimeout(function() {
            newWin.close();
        }, 10);
    });

    

    function productDetails(product, imagedata) {
        product[11] = product[11].replace(/@/g, '"');
        htmltext = slidertext = '';

        //console.log("In product Details: ", product, imageData);

        htmltext = '<p><b>{{__("file.Type")}}: </b>' + product[0] +
            '</p><p><b>{{__("file.name")}}: </b>' + product[1] +
            '</p><p><b>{{__("file.Code")}}: </b>' + product[2] +
            '</p><p><b>{{__("file.Brand")}}: </b>' + product[3] +
            '</p><p><b>{{__("file.category")}}: </b>' + product[4] +
            '</p><p><b>{{__("file.Quantity")}}: </b>' + product[17] +
            '</p><p><b>{{__("file.Unit")}}: </b>' + product[5] +
            '</p><p><b>{{__("file.Cost")}}: </b>' + product[6] +
            '</p><p><b>{{__("file.Price")}}: </b>' + product[7] +
            '</p><p><b>{{__("file.Tax")}}: </b>' + product[8] +
            // '</p><p>{{__("file.Tax Method")}} : '+product[9]+
            '</p><p><b>{{__("file.Alert Quantity")}} : </b>' + product[10] +
            '</p><p><b>{{__("file.Product Details")}}: </b></p>' + product[11];

        if (product[18]) {
            var product_image = product[18].split(",");
            if (product_image.length > 1) {
                slidertext = '<div class="product-image-container"><div id="product-img-slider" class="carousel slide" data-ride="carousel"><div class="carousel-inner">';
                for (var i = 0; i < product_image.length; i++) {
                    if (!i)
                        slidertext += '<div class="carousel-item active"><div class="zoom-container"><img src="images/product/' + product_image[i] + '" class="img-fluid zoom-image" style="max-height: 500px; width: 100%; object-fit: contain;" data-zoom-src="images/product/' + product_image[i] + '"><div class="zoom-lens"></div><div class="zoom-result"><img src="images/product/' + product_image[i] + '"></div></div></div>';
                    else
                        slidertext += '<div class="carousel-item"><div class="zoom-container"><img src="images/product/' + product_image[i] + '" class="img-fluid zoom-image" style="max-height: 500px; width: 100%; object-fit: contain;" data-zoom-src="images/product/' + product_image[i] + '"><div class="zoom-lens"></div><div class="zoom-result"><img src="images/product/' + product_image[i] + '"></div></div></div>';
                }
                slidertext += '</div><a class="carousel-control-prev" href="#product-img-slider" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span></a><a class="carousel-control-next" href="#product-img-slider" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span></a></div></div>';
            } else {
                slidertext = '<div class="product-image-container"><div class="zoom-container"><img src="images/product/' + product[18] + '" class="img-fluid zoom-image" style="max-height: 500px; width: 100%; object-fit: contain;" data-zoom-src="images/product/' + product[18] + '"><div class="zoom-lens"></div><div class="zoom-result"><img src="images/product/' + product[18] + '"></div></div></div>';
            }
        } else {
            slidertext = '<div class="product-image-container"><div class="zoom-container"><img src="images/product/default.png" class="img-fluid zoom-image" style="max-height: 500px; width: 100%; object-fit: contain;" data-zoom-src="images/product/zummXD2dvAtI.png"><div class="zoom-lens"></div><div class="zoom-result"><img src="images/product/zummXD2dvAtI.png"></div></div></div>';
        }
        $("#combo-header").text('');
        $("table.item-list thead").remove();
        $("table.item-list tbody").remove();
        $("table.product-warehouse-list thead").remove();
        $("table.product-warehouse-list tbody").remove();
        $(".product-variant-list thead").remove();
        $(".product-variant-list tbody").remove();
        $(".product-variant-warehouse-list thead").remove();
        $(".product-variant-warehouse-list tbody").remove();
        $("#product-warehouse-section").addClass('d-none');
        $("#product-variant-section").addClass('d-none');
        $("#product-variant-warehouse-section").addClass('d-none');
        if (product[0] == 'combo') {
            $("#combo-header").text('{{__("file.Combo Products")}}');
            product_list = product[13].split(",");
            variant_list = product[14].split(",");
            qty_list = product[15].split(",");
            price_list = product[16].split(",");
            $(".item-list thead").remove();
            $(".item-list tbody").remove();
            var newHead = $("<thead>");
            var newBody = $("<tbody>");
            var newRow = $("<tr>");
            newRow.append('<th>{{__("file.product")}}</th><th>{{__("file.Quantity")}}</th><th>{{__("file.Price")}}</th>');
            newHead.append(newRow);

            $(product_list).each(function(i) {
                if (!variant_list[i])
                    variant_list[i] = 0;
                $.get('products/getdata/' + product_list[i] + '/' + variant_list[i], function(data) {
                    var newRow = $("<tr>");
                    var cols = '';
                    cols += '<td>' + data['name'] + ' [' + data['code'] + ']</td>';
                    cols += '<td>' + qty_list[i] + '</td>';
                    cols += '<td>' + price_list[i] + '</td>';

                    newRow.append(cols);
                    newBody.append(newRow);
                });
            });

            $("table.item-list").append(newHead);
            $("table.item-list").append(newBody);
        }
        if (product[0] == 'standard' || product[0] == 'combo') {
            console.log(product);
            if (false) {
                $.get('products/variant-data/' + product[12], function(variantData) {
                    var newHead = $("<thead>");
                    var newBody = $("<tbody>");
                    var newRow = $("<tr>");
                    newRow.append('<th>{{__("file.Variant")}}</th><th>{{__("file.Item Code")}}</th><th>{{__("file.Additional Cost")}}</th><th>{{__("file.Additional Price")}}</th><th>{{__("file.Qty")}}</th>');
                    newHead.append(newRow);
                    $.each(variantData, function(i) {
                        var newRow = $("<tr>");
                        var cols = '';
                        cols += '<td>' + variantData[i]['name'] + '</td>';
                        cols += '<td>' + variantData[i]['item_code'] + '</td>';
                        if (variantData[i]['additional_cost'])
                            cols += '<td>' + variantData[i]['additional_cost'] + '</td>';
                        else
                            cols += '<td>0</td>';
                        if (variantData[i]['additional_price'])
                            cols += '<td>' + variantData[i]['additional_price'] + '</td>';
                        else
                            cols += '<td>0</td>';
                        cols += '<td>' + variantData[i]['qty'] + '</td>';

                        newRow.append(cols);
                        newBody.append(newRow);
                    });
                    $("table.product-variant-list").append(newHead);
                    $("table.product-variant-list").append(newBody);
                });
                $("#product-variant-section").removeClass('d-none');
            }
            if (role_id <= 2) {
                console.log(product);
                $.get('products/product_warehouse/' + product[12], function(data) {
                    if (data.product_warehouse[0].length != 0) {
                        const warehouse = data.product_warehouse[0];
                        const qty = data.product_warehouse[1];
                        const location = data.product_warehouse[2];
                        const batch = data.product_warehouse[3];
                        const expired_date = data.product_warehouse[4];
                        const imei_numbers = data.product_warehouse[5];
                        // console.log(imei_numbers, 'hi imei');
                        var newHead = $("<thead>");
                        var newBody = $("<tbody>");
                        var newRow = $("<tr>");
                        var productQty = 0;
                        newRow.append('<th>{{__("file.Warehouse")}}</th><th>{{__("file.Quantity")}}</th><th>{{__("file.Location")}}</th><th>{{__("file.Expired Date")}}</th>');
                        newHead.append(newRow);
                        $.each(warehouse, function(windex){
                            console.log("product_warehouse: ", location[windex]);
                            $.each(location[windex], function(index) {
                                // productQty += qty[index];
                                var newRow = $("<tr>");
                                var cols = '';
                                cols += '<td>' + warehouse[windex] + '</td>';
                                cols += '<td>' + qty[windex][index] + '</td>';
                                cols += '<td>' + location[windex][index] + '</td>';
                                cols += '<td>' + expired_date[index] + '</td>';

                                newRow.append(cols);
                                newBody.append(newRow);
                                $("table.product-warehouse-list").append(newHead);
                                $("table.product-warehouse-list").append(newBody);
                            });
                        });
                        // console.log(productQty);
                        $("#product-warehouse-section").removeClass('d-none');
                    }
                    if (data.product_variant_warehouse[0].length != 0) {
                        warehouse = data.product_variant_warehouse[0];
                        variant = data.product_variant_warehouse[1];
                        qty = data.product_variant_warehouse[2];
                        var newHead = $("<thead>");
                        var newBody = $("<tbody>");
                        var newRow = $("<tr>");
                        newRow.append('<th>{{__("file.Warehouse")}}</th><th>{{__("file.Variant")}}</th><th>{{__("file.Quantity")}}</th>');
                        newHead.append(newRow);
                        $.each(warehouse, function(index) {
                            var newRow = $("<tr>");
                            var cols = '';
                            cols += '<td>' + warehouse[index] + '</td>';
                            cols += '<td>' + variant[index] + '</td>';
                            cols += '<td>' + qty[index] + '</td>';

                            newRow.append(cols);
                            newBody.append(newRow);
                            $("table.product-variant-warehouse-list").append(newHead);
                            $("table.product-variant-warehouse-list").append(newBody);
                        });
                        $("#product-variant-warehouse-section").removeClass('d-none');
                    }
                });
            }
        }

        $('#product-content').html(htmltext);
        $('#slider-content').html(slidertext);
        $('#product-details').modal('show');
        $('#product-img-slider').carousel(0);
    }

    $(document).ready(function() {
        var table = $('#product-data-table').DataTable({
            responsive: true,

            fixedHeader: {
                header: true,
                footer: true
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "products/product-data",
                data: {
                    all_permission: all_permission,
                    warehouse_id: warehouse_id,

                },
                dataType: "json",
                type: "post",
                error: function(xhr, error, code) {
                    console.error("AJAX Error: " + error + " | " + code);
                    console.error("XHR Object: ", xhr);
                }
            },
            "createdRow": function(row, data, dataIndex) {
                $(row).addClass('product-link');
                $(row).attr('data-product', data['product']);
                $(row).attr('data-imagedata', data['imagedata']);
            },
            "columns": columns,
            'language': {
                /*'searchPlaceholder': "{{__('file.Type Product Name or Code')}}",*/
                'lengthMenu': '_MENU_ {{__("file.records per page")}}',
                "info": '<small>{{__("file.Showing")}} _START_ - _END_ (_TOTAL_)</small>',
                "search": '{{__("file.Search")}}',
                'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
                }
            },
            order: [
                ['2', 'asc']
            ],
            'columnDefs': [{
                    "orderable": false,
                    'targets': [0, 9, 10]
                },
                {
                    'render': function(data, type, row, meta) {
                        if (type === 'display') {
                            data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                        }

                        return data;
                    },
                    'checkboxes': {
                        'selectRow': true,
                        'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                    },
                    'targets': [0]
                }
            ],
            'select': {
                style: 'multi',
                selector: 'td:first-child'
            },
            'lengthMenu': [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            dom: '<"row"lfB>rtip',
            buttons: [{
                    extend: 'pdf',
                    text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
                    exportOptions: {
                        columns: ':visible:not(.not-exported)',
                        rows: ':visible',
                        stripHtml: false
                    },
                    customize: function(doc) {
                        for (var i = 1; i < doc.content[1].table.body.length; i++) {
                            if (doc.content[1].table.body[i][0].text.indexOf('<img src=') !== -1) {
                                var imagehtml = doc.content[1].table.body[i][0].text;
                                var regex = /<img.*?src=['"](.*?)['"]/;
                                var src = regex.exec(imagehtml)[1];
                                var tempImage = new Image();
                                tempImage.src = src;
                                var canvas = document.createElement("canvas");
                                canvas.width = tempImage.width;
                                canvas.height = tempImage.height;
                                var ctx = canvas.getContext("2d");
                                ctx.drawImage(tempImage, 0, 0);
                                var imagedata = canvas.toDataURL("image/png");
                                delete doc.content[1].table.body[i][0].text;
                                doc.content[1].table.body[i][0].image = imagedata;
                                doc.content[1].table.body[i][0].fit = [30, 30];
                            }
                        }
                    },
                },
                {
                    extend: 'excel',
                    text: '<i title="export to excel" class="dripicons-document-new"></i>',
                    exportOptions: {
                        columns: ':visible:not(.not-exported)',
                        rows: ':visible',
                        format: {
                            body: function(data, row, column, node) {
                                if (column === 0 && (data.indexOf('<img src=') !== -1)) {
                                    var regex = /<img.*?src=['"](.*?)['"]/;
                                    data = regex.exec(data)[1];
                                }
                                return data;
                            }
                        }
                    }
                },
                {
                    extend: 'csv',
                    text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                    exportOptions: {
                        columns: ':visible:not(.not-exported)',
                        rows: ':visible',
                        format: {
                            body: function(data, row, column, node) {
                                if (column === 0 && (data.indexOf('<img src=') !== -1)) {
                                    var regex = /<img.*?src=['"](.*?)['"]/;
                                    data = regex.exec(data)[1];
                                }
                                return data;
                            }
                        }
                    }
                },
                {
                    extend: 'print',
                    title: '',
                    text: '<i title="print" class="fa fa-print"></i>',
                    exportOptions: {
                        columns: ':visible:not(.not-exported)',
                        rows: ':visible',
                        stripHtml: false
                    },
                    repeatingHead: {
                        logo: logoUrl,
                        logoPosition: 'left',
                        logoStyle: '',
                        title: '<h3>Product List</h3>'
                    }
                    /*customize: function ( win ) {
                        $(win.document.body)
                            .prepend(
                                '<img src="http://datatables.net/media/images/logo-fade.png" style="margin:10px;" />'
                            );
                    }*/
                },
                {
                    text: '<i title="delete" class="dripicons-cross"></i>',
                    className: 'buttons-delete',
                    action: function(e, dt, node, config) {
                        if (user_verified == '1') {
                            product_id.length = 0;
                            $(':checkbox:checked').each(function(i) {
                                if (i) {
                                    var product_data = $(this).closest('tr').data('product');
                                    if (product_data)
                                        product_id[i - 1] = product_data[12];
                                }
                            });
                            if (product_id.length && confirmDelete()) {
                                $.ajax({
                                    type: 'POST',
                                    url: 'products/deletebyselection',
                                    data: {
                                        productIdArray: product_id
                                    },
                                    success: function(data) {
                                        alert(data);
                                        //dt.rows({ page: 'current', selected: true }).deselect();
                                        dt.rows({
                                            page: 'current',
                                            selected: true
                                        }).remove().draw(false);
                                    }
                                });
                            } else if (!product_id.length)
                                alert('No product is selected!');
                        } else
                            alert('This feature is disable for demo!');
                    }
                },
                {
                    extend: 'colvis',
                    text: '<i title="column visibility" class="fa fa-eye"></i>',
                    columns: ':gt(0)'
                },
            ],
        });
    });

    var product_data_images = [];
    const popup = $("#product-img-display");
    $('#product-data-table').on('mouseenter', 'tbody tr td div img', function(event){
        // creating the animation of how the image will appear
        var style = document.createElement('style');
        style.innerHTML = `
        @keyframes dynamicFade {
            0% { opacity: 0.8; }
            100% { opacity: 1; }
        }
        .product-img-display{
            animation: dynamicFade 0.5s ease-in-out forwards;
        }`;
        document.head.appendChild(style);

        var winDimension = {width: $(window)[0].innerWidth, height: $(window)[0].innerHeight}; 
        $('#img_display_container').empty();
        var prod_img_popup = document.getElementById('product-img-display');
        var blured_img_popup = document.getElementById('blured_layer');
        var content = `
            <div id="image_container" class="image_container">
                <img id="view_image" src="${$(this).attr('src')}">
            </div>
            <div id="img_btn_container" class="img_btn_container">
                <div class="controllers top-controller">
                    <button id="maximize-btn" class="top-controler-btn maximize-btn"><i class="far fa-square"></i></button>
                    <button id="close-btn" class="top-controler-btn close-btn"><i class="fas fa-times thin-icon"></i></button>
                </div>
                <div class="controllers bottom-controller">
                    <button id="back_btn" class="bottom-controler-btn action-btn back-btn"><i class="fa fa-chevron-left"></i></button>
                    <button id="forward_btn" class="bottom-controler-btn action-btn forward-btn"><i class="fa fa-chevron-right"></i></button>
                </div>
            </div>
            `;
        $('#img_display_container').append(content);
        var image_container = document.getElementById("image_container");
        $('#product-img-display').removeClass('d-none');
        var popup_dimensions = prod_img_popup.getBoundingClientRect();

        // Update position of the div
        if(elOffset){    
            prod_img_popup.style.left = elOffsetX;
            prod_img_popup.style.top = elOffsetY;
        }else{
            prod_img_popup.style.left = (winDimension.width - popup_dimensions.width)/2 - 20 + 'px';
            prod_img_popup.style.top = (winDimension.height - popup_dimensions.height)/2 - 20 + 'px';
        }
        prod_img_popup.style.display = 'block';
        blured_img_popup.style.backgroundImage = `url(${$(this).attr('src')})`;
        blured_img_popup.style.filter = "blur(10px)";
        
        var images = $(this).parent().parent().parent().data("product")[18];
        product_data_images = images.split(',');
    });

    $('#img_display_container').on('click', '.img_btn_container .top-controller .close-btn',function(event){
        console.log("close btn clicked")
        let $popup = $('#product-img-display');
        $popup.css({
            width: $popup.data('origin-width') + 'px',
            height: $popup.data('origin-height') + 'px'
        });
        $popup.data('maximized', false);
        $popup.addClass('d-none');
    });

    $('#img_display_container').on('click', '.img_btn_container .top-controller .maximize-btn',function(event){
        console.log("maximized btn clicked")
        let $popup = $('#product-img-display');
        let popup = $popup[0];
    
        $popup.addClass('d-none');

        if(!$popup.data('maximized')){
            $popup.data('origin-width', $popup.width());
            $popup.data('origin-height', $popup.height());

            $popup.css({
                width: $(window).innerWidth() + 'px',
                height: $(window).innerHeight() + 'px',
                top: '1px',
                left: '1px',
            });

            $popup.data('maximized', true);
        }else{
            $popup.css({
                width: $popup.data('origin-width') + 'px',
                height: $popup.data('origin-height') + 'px',
                left: ($(window).innerWidth() - $popup.data('origin-width'))/2 - 20 + 'px',
                top: ($(window).innerHeight() - $popup.data('origin-height'))/2 - 20 + 'px',
            });

            $popup.data('maximized', false);
        }

        $popup.removeClass('d-none');
        
    });

    popup.on('mouseenter',function(event){
        var prod_img_popup = document.getElementById('product-img-display');
        var blured_img_pop = document.getElementById('blured_layer');
        var image_container = $('#image_container');
        var image = "";
        var image_counter = 0;
        prod_img_popup.style.display = 'block';

        $("#back_btn").on("click", function(){
            if(image_counter != 0 ) image_counter -= 1;
            else if(image_counter == 0 ) image_counter = (product_data_images.length-1);
            image = `<img id="view_image" src="images/product/${product_data_images[image_counter]}">`;
            blured_img_pop.style.backgroundImage = `url('images/product/${product_data_images[image_counter]}'')`;
            blured_img_pop.style.filter = "blur(20px)";
            image_container.find('img').remove();
            image_container.append(image);
            console.log("image_counter backward", product_data_images[image_counter]);
        })

        $("#forward_btn").on("click", function(){
            console.log("image_counter forward", product_data_images, image_counter);
            if(image_counter != (product_data_images.length-1) ) image_counter += 1;
            else if(image_counter == ( product_data_images.length-1) ) image_counter = 0;
            image = `<img id="view_image" src="images/product/${product_data_images[image_counter]}">`;
            blured_img_pop.style.backgroundImage = `url('images/product/${product_data_images[image_counter]}')`;
            blured_img_pop.style.filter = "blur(20px)";
            image_container.find('img').remove();
            image_container.append(image);
        })

    });

    popup.on('mousedown', function(event){
        console.log(event);
        if(event.button == 0){
            isMouseDown = true;
            mouseStartX = event.pageX;
            mouseStartY = event.pageY;

            
            const offset = popup.offset();

            elOffsetX = offset.left;
            elOffsetY = offset.top;
            event.preventDefault();
        }
    })

    popup.on('mouseup', function(event){
            isMouseDown = false;
    })

    popup.on('mousemove',function(event){
        console.log(isMouseDown);
        if(isMouseDown){    
            var offsetMouseX = event.pageX - mouseStartX;
            var offsetMouseY = event.pageY - mouseStartY;
            console.log(offsetMouseX, offsetMouseY);
            var x = elOffsetX + offsetMouseX;
            var y = elOffsetY + offsetMouseY;
            console.log(x, y)
            popup.css({
                left: x + 'px',
                top: y + 'px',
            })
        };
    })
    
    $('#product-data-table tbody tr').each(function() {
        $(this).find('td').each(function() {
            if ($(this).attr('colspan')) {
                $(this).removeAttr('colspan');
            }
        });
    });
    $('#close')

    if (all_permission.indexOf("products-delete") == -1)
        $('.buttons-delete').addClass('d-none');

    $('select').selectpicker();

    // Edit table functionality
    $(".edit-product-btn").on("click", function() {
        if (all_permission.indexOf("products-edit") != -1) {
            $(".card-edit-dbtable").removeClass("d-none")
        }
    })

    // Zoom functionality
    function initZoom() {
        $('.zoom-container').each(function() {
            var container = $(this);
            var img = container.find('.zoom-image');
            var lens = container.find('.zoom-lens');
            var result = container.find('.zoom-result');
            var resultImg = result.find('img');

            container.on('mouseenter', function() {
                lens.show();
                result.show();
            });

            container.on('mouseleave', function() {
                lens.hide();
                result.hide();
            });

            container.on('mousemove', function(e) {
                var rect = img[0].getBoundingClientRect();
                var x = e.clientX - rect.left;
                var y = e.clientY - rect.top;

                // Calculate lens position
                var lensX = x - lens.width() / 2;
                var lensY = y - lens.height() / 2;

                // Keep lens within image bounds
                if (lensX < 0) lensX = 0;
                if (lensY < 0) lensY = 0;
                if (lensX > img.width() - lens.width()) lensX = img.width() - lens.width();
                if (lensY > img.height() - lens.height()) lensY = img.height() - lens.height();

                lens.css({
                    left: lensX + 'px',
                    top: lensY + 'px'
                });

                // Calculate zoom
                var ratioX = result.width() / lens.width();
                var ratioY = result.height() / lens.height();

                resultImg.css({
                    left: -lensX * ratioX + 'px',
                    top: -lensY * ratioY + 'px',
                    width: img.width() * ratioX + 'px',
                    height: img.height() * ratioY + 'px'
                });
            });
        });
    }

    // Initialize zoom when modal is shown
    $('#product-details').on('shown.bs.modal', function() {
        setTimeout(function() {
            initZoom();
        }, 100);
    });

    // Re-initialize zoom when carousel slides change
    $('#product-img-slider').on('slid.bs.carousel', function() {
        setTimeout(function() {
            initZoom();
        }, 100);
    });

    // Zoom toggle functionality
    var zoomEnabled = true;
    $('#zoom-toggle').on('click', function() {
        zoomEnabled = !zoomEnabled;
        if (zoomEnabled) {
            $(this).removeClass('btn-secondary').addClass('btn-info');
            $(this).html('<i class="fa fa-search-plus"></i> Zoom');
            $('.zoom-container').css('cursor', 'zoom-in');
            $('.zoom-container').off('mouseenter mouseleave mousemove').on('mouseenter mouseleave mousemove', function() {
                if (zoomEnabled) {
                    // Re-attach zoom events
                    initZoom();
                }
            });
        } else {
            $(this).removeClass('btn-info').addClass('btn-secondary');
            $(this).html('<i class="fa fa-search-minus"></i> Zoom');
            $('.zoom-container').css('cursor', 'default');
            $('.zoom-container').off('mouseenter mouseleave mousemove');
            $('.zoom-lens, .zoom-result').hide();
        }
    });
</script>
@endpush