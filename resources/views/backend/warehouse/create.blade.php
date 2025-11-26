@extends('backend.layout.main')
@section('content')

<x-validation-error fieldName="name" />
<x-success-message key="message" />
<x-error-message key="not_permitted" />

<section>
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-md-6">
                <a href="#" data-toggle="modal" data-target="#createModal" class="btn btn-info add-warehouse-btn"><i class="dripicons-plus"></i> {{__('file.Add Warehouse')}}</a>
                <a href="#" data-toggle="modal" data-target="#importWarehouse" class="btn btn-primary add-warehouse-btn"><i class="dripicons-copy"></i> {{__('file.Import Warehouse')}}</a>
            </div>
                         <div class="col-md-6">
                 <form method="GET" action="{{ url('warehouse') }}" class="form-inline justify-content-end" id="search-form">
                     <div class="input-group">
                         <input type="text" name="search" class="form-control" placeholder="Search warehouses..." value="{{ request('search') }}" id="search-input">
                         <div class="input-group-append">
                             <button type="submit" class="btn btn-outline-secondary" id="search-btn">
                                 <i class="fa fa-search"></i>
                             </button>
                             @if(request('search'))
                                 <a href="{{ url('warehouse') }}" class="btn btn-outline-danger" title="Clear search">
                                     <i class="fa fa-times"></i>
                                 </a>
                             @endif
                         </div>
                     </div>
                 </form>
             </div>
        </div>
    </div>
    <div class="table-responsive">
        <table id="warehouse-table" class="table">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{__('file.Warehouse')}}</th>
                    <th>{{__('file.Phone Number')}}</th>
                    <th>{{__('file.Email')}}</th>
                    <th>{{__('file.Address')}}</th>
                    <th>{{__('file.Number of Product')}}</th>
                    <th>{{__('file.Stock Quantity')}}</th>
                    <th class="not-exported">{{__('file.action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lims_warehouse_all as $warehouse)
                <?php
                    // Calculate product count and stock quantity for each warehouse
                    $number_of_product = App\Models\Product_Warehouse::
                    join('products', 'product_warehouse.product_id', '=', 'products.id')
                    ->where([ ['product_warehouse.warehouse_id', $warehouse->id],
                              ['products.is_active', true]
                    ])->count();

                    $stock_qty = App\Models\Product_Warehouse::
                    join('products', 'product_warehouse.product_id', '=', 'products.id')
                    ->where([ ['product_warehouse.warehouse_id', $warehouse->id],
                              ['products.is_active', true]
                    ])->sum('product_warehouse.qty');
                ?>
                <tr data-id="{{$warehouse->id}}">
                    <td>{{$loop->iteration}}</td>
                    <td>{{ $warehouse->name }}</td>
                    <td>{{ $warehouse->phone}}</td>
                    <td>{{ $warehouse->email}}</td>
                    <td>{{ $warehouse->address}}</td>
                    <td>{{$number_of_product}}</td>
                    <td>{{$stock_qty}}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{__('file.action')}}
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                <li>
                                    <button type="button" data-id="{{$warehouse->id}}" class="open-EditWarehouseDialog btn btn-link" data-toggle="modal" data-target="#editModal"><i class="dripicons-document-edit"></i> {{__('file.edit')}}
                                </button>
                                </li>
                                <li class="divider"></li>
                                {{ Form::open(['route' => ['warehouse.destroy', $warehouse->id], 'method' => 'DELETE'] ) }}
                                <li>
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="dripicons-trash"></i> {{__('file.delete')}}</button>
                                </li>
                                {{ Form::close() }}
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="text-muted">
            Showing {{ $lims_warehouse_all->firstItem() ?? 0 }} to {{ $lims_warehouse_all->lastItem() ?? 0 }} of {{ $lims_warehouse_all->total() }} warehouses
        </div>
        <div>
            {{ $lims_warehouse_all->links() }}
        </div>
    </div>
</section>

<div id="createModal" tabindex="-1" role="dialog" aria-labellefiley="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
  <div role="document" class="modal-dialog">
    <div class="modal-content">
        {!! Form::open(['route' => 'warehouse.store', 'method' => 'post']) !!}
      <div class="modal-header">
        <h5 id="exampleModalLabel" class="modal-title">{{__('file.Add Warehouse')}}</h5>
        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
      </div>
      <div class="modal-body">
        <p class="italic"><small>{{__('file.The field labels marked with * are required input fields')}}.</small></p>
          <div class="form-group">
            <label>{{__('file.name')}} *</label>
            <input type="text" placeholder="{{ __('Type WareHouse Name') }}" name="name" required="required" class="form-control">
          </div>
          <div class="form-group">
            <label>{{__('file.Phone Number')}} *</label>
            <input type="text" name="phone" class="form-control" required>
          </div>
          <div class="form-group">
            <label>{{__('file.Email')}}</label>
            <input type="email" name="email" placeholder="example@example.com" class="form-control">
          </div>
          <div class="form-group">
            <label>{{__('file.Address')}} *</label>
            <textarea required class="form-control" rows="3" name="address"></textarea>
          </div>
          <div class="form-group">
            <input type="submit" value="{{__('file.submit')}}" class="btn btn-primary">
          </div>
      </div>
      {{ Form::close() }}
    </div>
  </div>
</div>

<div id="editModal" tabindex="-1" role="dialog" aria-labellefiley="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
  <div role="document" class="modal-dialog">
    <div class="modal-content">
        {!! Form::open(['route' => ['warehouse.update',1], 'method' => 'put']) !!}
      <div class="modal-header">
        <h5 id="exampleModalLabel" class="modal-title"> {{__('file.Update Warehouse')}}</h5>
        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
      </div>
      <div class="modal-body">
        <p class="italic"><small>{{__('file.The field labels marked with * are required input fields')}}.</small></p>
          <div class="form-group">
            <input type="hidden" name="warehouse_id">
            <label>{{__('file.name')}} *</label>
            <input type="text" placeholder="{{ __('file.Type WareHouse Name') }}" name="name" required="required" class="form-control">
          </div>
          <div class="form-group">
            <label>{{__('file.Phone Number')}} *</label>
            <input type="text" name="phone" class="form-control" required>
          </div>
          <div class="form-group">
            <label>{{__('file.Email')}}</label>
            <input type="email" name="email" placeholder="example@example.com" class="form-control">
          </div>
          <div class="form-group">
            <label>{{__('file.Address')}} *</label>
            <textarea class="form-control" rows="3" name="address" required></textarea>
          </div>
          <div class="form-group">
            <input type="submit" value="{{__('file.submit')}}" class="btn btn-primary">
          </div>
      </div>
      {{ Form::close() }}
    </div>
  </div>
</div>

<div id="importWarehouse" tabindex="-1" role="dialog" aria-labellefiley="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
  <div role="document" class="modal-dialog">
    <div class="modal-content">
        {!! Form::open(['route' => 'warehouse.import', 'method' => 'post', 'files' => true]) !!}
      <div class="modal-header">
        <h5 id="exampleModalLabel" class="modal-title">{{__('file.Import Warehouse')}}</h5>
        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
      </div>
      <div class="modal-body">
        <p class="italic"><small>{{__('file.The field labels marked with * are required input fields')}}.</small></p>
         <p>{{__('file.The correct column order is')}} (name*, phone, email, address*) {{__('file.and you must follow this')}}.</p>
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
                      <a href="sample_file/sample_warehouse.csv" class="btn btn-info btn-block btn-md"><i class="dripicons-download"></i>  {{__('file.Download')}}</a>
                  </div>
              </div>
        </div>
        <input type="submit" value="{{__('file.submit')}}" class="btn btn-primary">
      </div>
      {{ Form::close() }}
    </div>
  </div>
</div>


@endsection

@push('scripts')
<script type="text/javascript">

    $("ul#setting").siblings('a').attr('aria-expanded','true');
    $("ul#setting").addClass("show");
    $("ul#setting #warehouse-menu").addClass("active");

    @if(config('database.connections.saleprosaas_landlord'))
        numberOfWarehouse = <?php echo json_encode($numberOfWarehouse)?>;
        $.ajax({
            type: 'GET',
            async: false,
            url: '{{route("package.fetchData", $general_setting->package_id)}}',
            success: function(data) {
                if(data['number_of_warehouse'] > 0 && data['number_of_warehouse'] <= numberOfWarehouse) {
                    $("a.add-warehouse-btn").addClass('d-none');
                }
            }
        });
    @endif

    var warehouse_id = [];
    var user_verified = <?php echo json_encode(env('USER_VERIFIED')) ?>;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

  function confirmDelete() {
      if (confirm("Are you sure want to delete?")) {
          return true;
      }
      return false;
  }

    $(document).ready(function() {

        $(document).on('click', '.open-EditWarehouseDialog', function() {
            var url = "warehouse/"
            var id = $(this).data('id').toString();
            url = url.concat(id).concat("/edit");

            $.get(url, function(data) {
                $("#editModal input[name='name']").val(data['name']);
                $("#editModal input[name='phone']").val(data['phone']);
                $("#editModal input[name='email']").val(data['email']);
                $("#editModal textarea[name='address']").val(data['address']);
                $("#editModal input[name='warehouse_id']").val(data['id']);

            });
        });
  });

  $('#warehouse-table').DataTable( {
        "order": [],
        "paging": false, // Disable DataTable pagination since we're using Laravel pagination
        "searching": true,
        "info": false, // Disable DataTable info since we have Laravel pagination
        'language': {
            'lengthMenu': '_MENU_ {{__("file.records per page")}}',
             "info":      '<small>{{__("file.Showing")}} _START_ - _END_ (_TOTAL_)</small>',
            "search":  '{{__("file.Search")}}',
            'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
            }
        },
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 5, 6, 7]
            },
            {
                'render': function(data, type, row, meta){
                    if(type === 'display'){
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
        'select': { style: 'multi',  selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: '<"row"fB>rtip', // Removed 'l' (length menu) since we're using Laravel pagination
        buttons: [
            {
                extend: 'pdf',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'excel',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                text: '<i title="delete" class="dripicons-cross"></i>',
                className: 'buttons-delete',
                action: function ( e, dt, node, config ) {
                    if(user_verified == '1') {
                        warehouse_id.length = 0;
                        $(':checkbox:checked').each(function(i){
                            if(i){
                                warehouse_id[i-1] = $(this).closest('tr').data('id');
                            }
                        });
                        if(warehouse_id.length && confirm("Are you sure want to delete?")) {
                            $.ajax({
                                type:'POST',
                                url:'warehouse/deletebyselection',
                                data:{
                                    warehouseIdArray: warehouse_id
                                },
                                success:function(data){
                                    $(':checkbox:checked').each(function(i) {
                                            if (i) {
                                                 dt.row($(this).closest('tr')).remove().draw(false);
                                            }
                                        });
                                        alert(data);
                                }
                            });

                            // dt.rows({ page: 'current', selected: true }).remove().draw(false);
                        }
                        else if(!warehouse_id.length)
                            alert('No warehouse is selected!');
                    }
                    else
                        alert('This feature is disable for demo!');
                }
            },
            {
                extend: 'colvis',
                text: '<i title="" class="fa fa-eye"></i>',
                columns: ':gt(0)'
            },
        ],
    } );

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Search functionality improvements
$(document).ready(function() {
    // Auto-submit search after 500ms delay
    var searchTimer;
    $('#search-input').on('input', function() {
        clearTimeout(searchTimer);
        var searchTerm = $(this).val();
        
        searchTimer = setTimeout(function() {
            if (searchTerm.length >= 2 || searchTerm.length === 0) {
                $('#search-form').submit();
            }
        }, 500);
    });
    
    // Show loading state during search
    $('#search-form').on('submit', function() {
        $('#search-btn').html('<i class="fa fa-spinner fa-spin"></i>');
        $('#search-btn').prop('disabled', true);
    });
    
    // Reset search button after page load
    $('#search-btn').html('<i class="fa fa-search"></i>');
    $('#search-btn').prop('disabled', false);
});

$( "#select_all" ).on( "change", function() {
    if ($(this).is(':checked')) {
        $("tbody input[type='checkbox']").prop('checked', true);
    }
    else {
        $("tbody input[type='checkbox']").prop('checked', false);
    }
});

$("#export").on("click", function(e){
    e.preventDefault();
    var warehouse = [];
    $(':checkbox:checked').each(function(i){
      warehouse[i] = $(this).val();
    });
    $.ajax({
       type:'POST',
       url:'/exportwarehouse',
       data:{

            warehouseArray: warehouse
        },
       success:function(data){
        alert('Exported to CSV file successfully! Click Ok to download file');
        window.location.href = data;
       }
    });
});
</script>
@endpush
