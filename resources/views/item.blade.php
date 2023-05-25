@include('includes/header_start')

<link href="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
<!-- Responsive datatable examples -->
<link href="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">

<!-- Plugins css -->
<link href="{{ URL::asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet"/>
<link href="{{ URL::asset('assets/css/custom_checkbox.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/css/jquery.notify.css')}}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('assets/css/mdb.css')}}" rel="stylesheet" type="text/css">

<meta name="csrf-token" content="{{ csrf_token() }}"/>


@include('includes/header_end')

<!-- Page title -->
<ul class="list-inline menu-left mb-0">
    <li class="list-inline-item">
        <button type="button" class="button-menu-mobile open-left waves-effect">
            <i class="ion-navicon"></i>
        </button>
    </li>
    <li class="hide-phone list-inline-item app-search">

    </li>
</ul>

<div class="clearfix"></div>
</nav>

</div>
<!-- Top Bar End -->

<!-- ==================
     PAGE CONTENT START
     ================== -->

     <div class="page-content-wrapper">

        <div class="container-fluid">
            <div class="col-lg-12">
                <div class="card m-b-20">
                    <div class="card-body">                       
                        <div class="row">
                            <div class="col-lg-8">
                            </div>                          
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <button type="button" 
                                            class="btn btn-primary waves-effect float-right" 
                                            data-toggle="modal"  
                                            data-target="#addItemModal">
                                            Create Item
                                    </button>    
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="table-rep-plugin">
                            <div class="table-responsive b-0" data-pattern="priority-columns">
                                <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Item Code</th>
                                            <th>Item Name</th>
                                            <th>Category</th>
                                            <th>UOM</th>
                                            <th>Unit Price</th>
                                            <th>Active</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                    
                                        @if(isset($itemView))
                                        @if(count($itemView) > 0)
                                        @foreach($itemView as $item)
                                            <tr>
                                                <td>{{$item->item_oem_code}}</td>
                                                <td>{{$item->item_short_description}}</td>
                                                <td>{{$item->categoryRelation->category_short_description}}</td> {{-- how to get category name ?????--}}
                                                <td>{{$item->uomRelation->uom_description}}</td>
                                                <td text-align: right>{{number_format($item->item_unit_price,2)}}</td>
    
                                                @if($item->item_status == 1)
    
                                                    <td >
                                                        <p>
                                                            <input type="checkbox" class="status"
                                                                   onchange="changeStatus('{{ $item->item_id}}','item')"
                                                                   id="{{"c".$item->item_id}}" checked
                                                                   switch="none"/>
                                                            <label for="{{"c".$item->item_id}}"
                                                                   data-on-label="Yes"
                                                                   data-off-label="No"></label>
                                                        </p>
                                                    </td>
                                                @else
                                                    <td >
                                                        <p>
                                                            <input type="checkbox" class="status"
                                                                   onchange="changeStatus('{{ $item->item_id}}','item')"
                                                                   id="{{"c".$item->item_id}}"
                                                                   switch="none"/>
                                                            <label for="{{"c".$item->item_id}}"
                                                                   data-on-label="Yes"
                                                                   data-off-label="No"></label>
                                                        </p>
                                                    </td>
                                                @endif
                                                <td>    
                                                    <p>
                                                        <button type="button" title="View"
                                                                class="btn btn-sm btn-basic  waves-effect waves-light"
                                                                data-toggle="modal"                                                                
                                                                data-id="{{ $item->item_id}}"
                                                                data-name="{{ $item->item_id}}"
                                                                id="viewItem"
                                                                data-target="#viewItemModal">
                                                                <i class="fa fa-eye"></i>                                            
                                                        </button>
                                                        <button type="button" title="Edit"
                                                                class="btn btn-sm btn-basic  waves-effect waves-light"
                                                                data-toggle="modal"
                                                                data-id="{{ $item->item_id}}"
                                                                data-name="{{ $item->item_id}}"
                                                                id="updateItem"
                                                                data-target="#updateItemModal">
                                                                <i class="fa fa-edit"></i>
                                                        </button>
                                                        <button type="button" title="Delete"
                                                                class="btn btn-sm btn-basic  waves-effect waves-light" 
                                                                onclick="deleteItem({{$item->item_id}})">                                                        
                                                                <i class="fa fa-times"></i>
                                                        </button>
                                                    </p>
                                                </td>                                                
                                            </tr>
                                        @endforeach
                                        @endif
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- container -->
    
    </div> <!-- Page content Wrapper -->
    
    </div> <!-- content -->

    <!--add item modal-->
<div    class="modal fade" 
        id="addItemModal"
        role="dialog"
        aria-labelledby="mySmallModalLabel" 
        aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Create Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                {{-- row 1 --}}
                <div class="row bg-light">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Category<span style="color: red"> *</span></label>
                        <select class="form-control select2 tab" name="category" id="category" required>
                            <option value="" disabled selected>Select Category </option>
                            @if(isset($categoryView))
                                @foreach($categoryView as $category)
                                    <option value="{{"$category->category_id"}}">{{$category->category_short_description}} </option>
                                @endforeach
                            @endif
                        </select>
                        <span class="text-danger" id="categoryError"></span>
                    </div>
                </div>               
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Item Name<span style="color: red"> *</span></label>
                            <input  type="text" 
                                    class="form-control" 
                                    name="itemName"
                                    id="itemName" 
                                    required placeholder="Item Name"/>
                            <span class="text-danger" id="itemNameError"></span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Description</label>
                            <input  type="text" 
                                    class="form-control" 
                                    name="itemDescription"
                                    id="itemDescription" 
                                    placeholder="Description"/>
                            <span class="text-danger" id="itemDescriptionError"></span>
                        </div>
                    </div>
                </div>

            {{-- row 2 --}}
                <div class="row"> 
                
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>OEM Code<span style="color: red"> *</span></label>
                        <input type="text" 
                                class="form-control" 
                                name="oemCode"
                                id="oemCode" 
                                required 
                                placeholder="OEM Code"/>
                        <span class="text-danger" id="oemCodeError"></span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Manufacturer Code</label>
                        <input type="text" 
                                class="form-control" 
                                name="manufacturerCode"
                                id="manufacturerCode" 
                                required 
                                placeholder="Manufacturer Code"/>
                        <span class="text-danger" id="manufacturerCodeError"></span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Status</label>
                        <input type="text" 
                                class="form-control" 
                                name="itemStatus"
                                id="itemStatus" 
                                required 
                                />
                        <span class="text-danger" id="itemStatusError"></span>
                    </div>
                </div>
                
                </div>
                {{-- row 3 --}}
                <div class ="row bg-light">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>UOM<span style="color: red"> *</span></label>
                            <select class="form-control select2 tab" name="uom" id="uom" required>
                                <option value="" disabled selected>Select unit of measure </option>
                                @if(isset($uomView))
                                    @foreach($uomView as $uom)
                                        <option value="{{"$uom->uom_id"}}">{{$uom->uom_code}} </option>
                                    @endforeach
                                @endif
                            </select>                            
                            <span class="text-danger" id="uomError"></span>
                        </div>                 
                    </div>               
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Unit Cost<span style="color: red"> *</span></label>
                            <input type="number" 
                                class="form-control" 
                                name="unitCost"
                                oninput="this.value = Math.abs(this.value)"
                                id="unitCost" 
                                required 
                                placeholder="0.00"/>
                            <span class="text-danger" id="unitCostError"></span>
                        </div>                 
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Unit Price<span style="color: red"> *</span></label>
                            <input type="number" 
                                    class="form-control" 
                                    name="unitPrice"
                                    oninput="this.value = Math.abs(this.value)"
                                    id="unitPrice" required placeholder="0.00"/>
                            <span class="text-danger" id="unitPriceError"></span>
                        </div>                 
                    </div>

                </div>
                {{-- row 4 --}}
                <div class="row">
                    <div class="col-lg-12">
                        <label>Remarks</label>
                        <textarea class="form-control" 
                                rows="1"
                                name="itemRemarks"
                                id="itemRemarks"
                                placeholder="Write additional remarks here...."></textarea>
                    </div> 
                </div>

                {{-- row 5 --}}
                <div class="row">
                    <div class="col-lg-4" style="padding-top: 14px">
                        <button type="button" class="btn btn-md btn-outline-primary waves-effect"  onclick="saveItem()">Save Item</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--View Item modal-->
<div class="modal fade" id="viewItemModal" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Item Details</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-group row">
                        <label for="viewOemCode" class="col-sm-4 col-form-label">OEM Code</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewOemCode" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewManufacturerCode" class="col-sm-4 col-form-label">Manufacturer Code</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewManufacturerCode" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewCategory" class="col-sm-4 col-form-label">Category</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewCategory" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewItemName" class="col-sm-4 col-form-label">Item Name</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewItemName" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewItemDesc" class="col-sm-4 col-form-label">Item Description</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewItemDesc" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewUom" class="col-sm-4 col-form-label">UOM</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewUom" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewUnitCost" class="col-sm-4 col-form-label">Unit Cost</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewUnitCost" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewUnitPrice" class="col-sm-4 col-form-label">Unit Price</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewUnitPrice" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewStatus" class="col-sm-4 col-form-label">Status</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewStatus" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewRemarks" class="col-sm-4 col-form-label">Remarks</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewRemarks" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-md btn-outline-primary waves-effect float-right" data-dismiss="modal" >Close</button>
                        </div>
                    </div> 
                </div>
            </div>
            <input type="hidden" id="hiddenVehicleId">
        </div>
    </div>
</div>

<!--Update Item modal-->
<div class="modal fade" id="updateItemModal" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Edit Item</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissible " id="errorAlert1" style="display:none">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-group row">
                        <label for="updateOemCode" class="col-sm-4 col-form-label">Item OEM Code</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="updateOemCode" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="updateManufacturerCode" class="col-sm-4 col-form-label">Manufacturer Code</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="updateManufacturerCode" id="updateManufacturerCode"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="updateItemName" class="col-sm-4 col-form-label">Item Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="updateItemName" id="updateItemName"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="updateItemDesc" class="col-sm-4 col-form-label">Item Description</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="updateItemDesc" id="updateItemDesc"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="updateUnitCost" class="col-sm-4 col-form-label">Unit Cost</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="updateUnitCost" id="updateUnitCost"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="updateUnitPrice" class="col-sm-4 col-form-label">Unit Price</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="updateUnitPrice" id="updateUnitPrice"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="updateRemarks" class="col-sm-4 col-form-label">Remarks</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="updateRemarks" id="updateRemarks"/>
                        </div>
                    </div>

                    
                    {{-- <label for="example-text-input" class="col-form-label">Category Description<span style="color: red"> *</span></label>
                    <input type="text" class="form-control" name="updateCategoryName" id="updateCategoryName" required placeholder="Category Name"/> --}}
                    {{-- <small class="text-danger">{{ $errors->first('uCategory') }}</small> --}}
                    
                </div>
                <button type="submit" class="btn btn-md btn-outline-primary waves-effect" onclick="updateItem()"> Update Item</button>
            </div>
            <input type="hidden" id="hiddenItemId">
        </div>
    </div>
</div>

@include('includes/footer_start')

<!-- Plugins js -->
<script src="{{ URL::asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js')}}"
        type="text/javascript"></script>

<!-- Plugins Init js -->
<script src="{{ URL::asset('assets/pages/form-advanced.js')}}"></script>

<!-- Required datatable js -->
<script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
<!-- Buttons examples -->
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/jszip.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/pdfmake.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/vfs_fonts.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.html5.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.print.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.colVis.min.js')}}"></script>
<!-- Responsive examples -->
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.responsive.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>

<script src="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
<script src="{{ URL::asset('assets/pages/sweet-alert.init.js')}}"></script>

<!-- Datatable init js -->
<script src="{{ URL::asset('assets/pages/datatables.init.js')}}"></script>

<!-- Parsley js -->
<script type="text/javascript" src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/bootstrap-notify.js')}}"></script>
<script src="{{ URL::asset('assets/js/jquery.notify.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('form').parsley();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
    });
    $(document).on("wheel", "input[type=number]", function (e) {
        $(this).blur();
    });


    $('.modal').on('hidden.bs.modal', function () { 
            //$('#errorAlert').hide(); 
            //$('#errorAlert').html(''); 
            $('#errorAlert1').hide();
            $('#errorAlert1').html('');
            $('input').val('');

            $('#categoryError').html("");
            $('#itemNameError').html("");
            $('#itemDescriptionError').html("");
            $('#oemCodeError').html("");
            $('#manufacturerCodeError').html("");
            $("#itemStatusError").html("");
            $("#uomError").html("");
            $("#unitCostError").html("");
            $("#unitPriceError").html("");

        });

    function changeStatus(dataID, tableName) {
        
        $.post('activateDeactivate', {id: dataID, table: tableName}, function (data) {
           
        });
    }
    
    function saveItem() {
        
        $('#categoryError').html("");
        $('#itemNameError').html("");
        $('#itemDescriptionError').html("");
        $('#oemCodeError').html("");
        $('#manufacturerCodeError').html("");
        $("#itemStatusError").html("");
        $("#uomError").html("");
        $("#unitCostError").html("");
        $("#unitPriceError").html("");
        //$("#remarksError").html("");

        var itemCategory = $("#category").val();
        var itemName = $("#itemName").val();
        var itemDescription = $("#itemDescription").val();
        var itemOemCode = $("#oemCode").val();
        var itemManufacturerCode=$("#manufacturerCode").val();
        //var itemStatus=$("#minQty").val();
        var itemUom=$("#uom").val();
        var itemUnitCost=$("#unitCost").val();
        var itemUnitPrice=$("#unitPrice").val();
        var itemRemarks=$("#itemRemarks").val();

$.post('saveItem', {
    itemCategory: itemCategory,
    itemName: itemName,
    itemDescription: itemDescription,
    itemOemCode: itemOemCode,
    itemManufacturerCode:itemManufacturerCode,
    itemUom:itemUom,
    itemUnitCost:itemUnitCost,
    itemUnitPrice:itemUnitPrice,
    itemRemarks:itemRemarks,
     
}, function (data) {
    
    if (data.errors != null) {

        if(data.errors.itemCategory){
            var p = document.getElementById('categoryError');
            p.innerHTML = data.errors.itemCategory;
        }

        if(data.errors.itemName){
            var p = document.getElementById('itemNameError');
            p.innerHTML = data.errors.itemName;
        }

        if(data.errors.itemOemCode){
            var p = document.getElementById('oemCodeError');
            p.innerHTML = data.errors.itemOemCode;
        }

        if(data.errors.itemUom){
            var p = document.getElementById('uomError');
            p.innerHTML = data.errors.itemUom;
        }

        if(data.errors.itemUnitCost){
            var p = document.getElementById('unitCostError');
            p.innerHTML = data.errors.itemUnitCost;
        }

        if(data.errors.itemUnitPrice){
            var p = document.getElementById('unitPriceError');
            p.innerHTML = data.errors.itemUnitPrice;
        }

    }
    if (data.success != null) {
        $(".select2").val('').trigger('change');
        notify({
            type: "success",
            title: 'PRODUCT SAVED SUCCESSFULLY',
            autoHide: true,
            delay: 2500, 
            position: {
                x: "right",
                y: "top"
            },
            icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',

            message: data.success,
        });

        $('input').val("");
        $('textarea').val("");
        $(".select2").val('').trigger('change');
        setTimeout(function () {
            $('#addItemModal').modal('hide');
        }, 200);
       location.reload();
    }
});
}

function updateItem() {
                $('#errorAlert1').hide();
                $('#errorAlert1').html("");
                var updateOemCode = $("#updateOemCode").val();
                var updateManufacturerCode = $("#updateManufacturerCode").val();
                var updateItemName = $("#updateItemName").val();
                var updateItemDesc = $("#updateItemDesc").val();
                var updateUnitCost = $("#updateUnitCost").val();
                var updateUnitPrice = $("#updateUnitPrice").val();
                var updateRemarks = $("#updateRemarks").val();
                var hiddenItemId=$("#hiddenItemId").val();
                
                $.post('updateItem',
                
                {
                    oemCode:updateOemCode,
                    manufacturerCode:updateManufacturerCode,
                    itemName:updateItemName,
                    itemDesc:updateItemDesc,
                    unitCost:updateUnitCost,
                    unitPrice:updateUnitPrice,
                    remarks:updateRemarks,
                    hiddenItemId:hiddenItemId,

                },  function (data) {

                    if (data.errors != null) {
                        console.log(data);
                        $('#errorAlert1').show();
                        $.each(data.errors, function (key, value) {
                             $('#errorAlert1').append('<p>' + value + '</p>');
                         });
                    }
                    if (data.success != null) {
                        notify({
                            type: "success", 
                            title: 'ITEM UPDATED SUCESSFULLY',
                            autoHide: true, 
                            delay: 2500,
                            position: {
                                x: "right",
                                y: "top"
                            },
                            icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',
                            message: data.success,
                        });
                        
                        location.reload();
                    }
                });
    }

 
 //view Item details
 $(document).on('click', '#viewItem', function () {
                var ItemId = $(this).data("id");

                $.post('viewItem', {ItemId: ItemId}, 
                function (data) {
                    
                    $("#viewOemCode").val(data.getItemDetail.item_oem_code);
                    $("#viewManufacturerCode").val(data.getItemDetail.item_manufacturer_code);
                    $("#viewCategory").val(data.getCategoryDetail.category_short_description);
                    $("#viewItemName").val(data.getItemDetail.item_short_description);
                    $("#viewItemDesc").val(data.getItemDetail.item_long_description);
                    $("#viewUom").val(data.getUomDetail.uom_code);                    
                    $("#viewUnitCost").val(data.getItemDetail.item_unit_cost);
                    $("#viewUnitPrice").val(data.getItemDetail.item_unit_price);
                    $("#viewStatus").val(data.getItemDetail.item_status);
                    $("#viewRemarks").val(data.getItemDetail.item_remarks);
                });
            });


function deleteItem(itemId){
            swal({
        title: 'Do you really want to delete this Item?',
        dangerMode:true,
        buttons: true,
        showCancelButton: true,
        confirmButtonText: 'YES',
        cancelButtonText: 'NO',
        confirmButtonClass: 'btn btn-md btn-danger waves-effect',
        cancelButtonClass: 'btn btn-md btn-primary waves-effect',
        buttonsStyling: false
        }).then(function () {
            $.post('deleteItem',{
                itemId:itemId,  
            },function (data){
                if (data.success != null) {
        notify({
            type: "success", 
            title: 'ITEM DELETED',
            autoHide: true, 
            delay: 2500,
            position: {
                x: "right",
                y: "top"
            },
            icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',
            message: data.success,
        });
        
        location.reload(); 
    }
});
}), function () { 
}
    
}

//update Item details
        $(document).on('click', '#updateItem', function () {
        var itemId = $(this).data("id");
            $.post('getByItemId', {
                itemId: itemId
            }, function (data)            
            {
                $("#hiddenItemId").val(data.item_id);
                $("#updateOemCode").val(data.item_oem_code);
                $("#updateManufacturerCode").val(data.item_manufacturer_code);
                //$("#updateCategory").val(data.category_short_description);
                $("#updateItemName").val(data.item_short_description);
                $("#updateItemDesc").val(data.item_long_description);
                //$("#updateUom").val(data.uom_code);                    
                $("#updateUnitCost").val(data.item_unit_cost);
                $("#updateUnitPrice").val(data.item_unit_price);
                $("#updateRemarks").val(data.item_remarks);
            });
        });


        $(document).ready(function(){
            $( document ).on( 'focus', ':input', function(){
                $( this ).attr( 'autocomplete', 'off' );
            });
        });

</script>
@include('includes/footer_end')