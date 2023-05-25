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
{{-- csrf token is needed when using ajax for data exchange --}}


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
                        <div class="row p-3 mb-2 bg-white text-dark">
                            <div class="col-lg-8">
                                <h1> Vehicles</h1>
                            </div>                          
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <button type="button" 
                                            class="btn btn-primary waves-effect float-right" 
                                            data-toggle="modal"  
                                            data-target="#addVehicleModal">
                                            Add Vehicle
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
                                            <th>Reg. Number</th>
                                            <th>Make</th>
                                            <th>Model</th>
                                            <th>Year</th>
                                            <th>Customer</th>
                                            <th>Customer NIC</th>
                                            <th>Active</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                    
                                        @if(isset($vehicleView))
                                        @if(count($vehicleView) > 0)
                                         
                                        @foreach($vehicleView as $vehicle)
                                            <tr>
                                                <td>{{$vehicle->vehicle_registration_number}}</td>
                                                <td>{{$vehicle->vehicle_make}}</td>
                                                <td>{{$vehicle->vehicle_model}}</td>
                                                <td>{{$vehicle->vehicle_manufacture_year}}</td>
                                                <td>{{$vehicle->customerRelation->customer_firstname}}</td>
                                                <td>{{$vehicle->customerRelation->customer_nic}}</td>
                                                   
                                                @if($vehicle->vehicle_status == 1)
    
                                                    <td >
                                                        <p>
                                                            <input type="checkbox" class="status"
                                                                   onchange="changeStatus('{{ $vehicle->vehicle_id}}','vehicle')"
                                                                   id="{{"c".$vehicle->vehicle_id}}" checked
                                                                   switch="none"/>
                                                            <label for="{{"c".$vehicle->vehicle_id}}"
                                                                   data-on-label="Yes"
                                                                   data-off-label="No"></label>
                                                        </p>
                                                    </td>
                                                @else
                                                    <td >
                                                        <p>
                                                            <input type="checkbox" class="status"
                                                                   onchange="changeStatus('{{ $vehicle->vehicle_id}}','vehicle')"
                                                                   id="{{"c".$vehicle->vehicle_id}}"
                                                                   switch="none"/>
                                                            <label for="{{"c".$vehicle->vehicle_id}}"
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
                                                                data-id="{{ $vehicle->vehicle_id}}"
                                                                data-name="{{ $vehicle->vehicle_id}}"
                                                                id="viewVehicle"
                                                                data-target="#viewVehicleModal">
                                                                <i class="fa fa-eye"></i>                                            
                                                        </button>
                                                        <button type="button" title="Edit"
                                                                class="btn btn-sm btn-basic  waves-effect waves-light"
                                                                data-toggle="modal"
                                                                data-id="{{ $vehicle->vehicle_id}}"
                                                                data-name="{{ $vehicle->vehicle_id}}"
                                                                id="updateVehicle"
                                                                data-target="#updateVehicleModal">
                                                                <i class="fa fa-edit"></i>
                                                        </button>
                                                        <button type="button" title="Delete"
                                                                class="btn btn-sm btn-basic  waves-effect waves-light" 
                                                                onclick="deleteVehicle({{$vehicle->vehicle_id}})">                                                        
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

    <!--Add Vehicle modal-->
<div    class="modal fade" 
        id="addVehicleModal"
        role="dialog"
        aria-labelledby="mySmallModalLabel" 
        aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Add Vehicle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                {{-- row 1 --}}
                <div class="row bg-light">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Customer NIC<span style="color: red"> *</span></label>
                        <select onChange="viewCustomerName(this.value)" class="form-control select2 tab" name="customer" id="customer" required>
                            <option value="" disabled selected>Select customer </option>
                            @if(isset($customerView))
                                @foreach($customerView as $customer)
                                    <option value="{{"$customer->customer_id"}}">{{$customer->customer_nic}} </option>
                                @endforeach
                            @endif
                        </select>
                        <span class="text-danger" id="customerError"></span>
                    </div>
                </div>               
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Name</label>    
                            <input  type="text" 
                                    class="form-control" 
                                    name="name"
                                    id="name" 
                                    required placeholder="Name"
                                    readonly>
                            <span class="text-danger" id="nameError"></span>
                            <input type='hidden' id="customer_id" name = "customer_id" value ="{{"$customer->customer_id"}}">
                        </div>
                    </div>
                                                           
                </div>

            {{-- row 2 --}}
                <div class="row"> 

                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Vehicle Reg. Number<span style="color: red"> *</span></label>
                        <input  type="text" 
                                class="form-control" 
                                name="regNumber"
                                id="regNumber" 
                                placeholder="ex: CAT-1789 / KW-4325 etc"/>
                        <span class="text-danger" id="regNumberError"></span>
                    </div>
                </div>   
                
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Make<span style="color: red"> *</span></label>
                        <input type="text" 
                                class="form-control" 
                                name="make"
                                id="make" 
                                required 
                                placeholder=" example: Toyota / Susuki / Honda etc."/>
                        <span class="text-danger" id="makeError"></span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Model <span style="color: red"> *</span></label>
                        <input type="text" 
                                class="form-control" 
                                name="model"
                                id="model" 
                                required 
                                placeholder="example: Vits / Allione / Camry etc"/>
                        <span class="text-danger" id="modelError"></span>
                    </div>
                </div>
                
                </div>
                {{-- row 3 --}}
                <div class ="row bg-light">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Year</label>                                                           
                                <select class="form-control select2 tab" name="year" id="year">
                                    @for ($year = date('Y'); $year > date('Y') - 100; $year--)
                                    <option value="{{$year}}">
                                            {{$year}}
                                    </option>
                                    @endfor
                              </select>                           
                            <span class="text-danger" id="yearError"></span>
                        </div>                 
                    </div>               
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Engine Number</label>
                            <input type="text" class="form-control" name="engine" id="engine" />                     
                            <span class="text-danger" id="engineError"></span>
                        </div>                 
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Chassis Number</label>
                            <input type="text" class="form-control" name="chassis" id="chassis" />                     
                            <span class="text-danger" id="ChassisError"></span>
                        </div>                   
                    </div>

                </div>
                {{-- row 4 --}}
                <div class="row">
                    <div class="col-lg-12">
                        <label>Remarks</label>
                        <textarea class="form-control" 
                                rows="1"
                                name="vehicleRemarks"
                                id="vehicleRemarks"
                                placeholder="Write additional remarks here...."></textarea>
                    </div> 
                </div>

                {{-- row 5 --}}
                <div class="row">
                    <div class="col-lg-4" style="padding-top: 14px">
                        <button type="button" class="btn btn-md btn-outline-primary waves-effect"  onclick="saveVehicle()">Save Vehicle</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Update Vehicle modal-->
<div class="modal fade" id="updateVehicleModal" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Vehicle details</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body">
                {{-- <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissible " id="errorAlert1" style="display:none">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div> --}}
                <div class="form-group">
                    <div class="form-group row">
                        <label for="updateRegNumber" class="col-sm-4 col-form-label">Registration Number</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="updateRegNumber">
                          <span class="text-danger" id="updateRegNumberError"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="updateMake" class="col-sm-4 col-form-label">Make</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="updateMake">
                          <span class="text-danger" id="updateMakeError"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="updateModel" class="col-sm-4 col-form-label">Model</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="updateModel">
                          <span class="text-danger" id="updateModelError"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="updateEngine" class="col-sm-4 col-form-label">Engine Number</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="updateEngine">
                          <span class="text-danger" id="updateEngineError"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="updateChassis" class="col-sm-4 col-form-label">Chassis Number</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="updateChassis">
                          <span class="text-danger" id="updateChassisError"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="updateYear" class="col-sm-4 col-form-label">Year</label>
                        <div class="col-sm-8">
                            <select class="form-control select2 tab" name="year" id="year">
                                @for ($year = date('Y'); $year > date('Y') - 100; $year--)
                                <option value="{{$year}}">
                                        {{$year}}
                                </option>
                                @endfor
                          </select>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="updateCustomer" class="col-sm-4 col-form-label">Customer</label>
                        <div class="col-sm-8">

                          <select class="form-control select2 tab" name="updateCustomerList" id="updateCustomerList" required>
                            <option value="" disabled selected>Select customer </option>
                            @if(isset($customerView))
                                @foreach($customerView as $customer)
                                    <option value="{{"$customer->customer_id"}}">{{$customer->customer_nic}} </option>
                                @endforeach
                            @endif
                        </select>
                        <span class="text-danger" id="updateCustomerListError"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="updateRemarks" class="col-sm-4 col-form-label">Remarks</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="updateRemarks">
                        </div>
                    </div>

                    {{-- <label for="updateItemDescription" class="col-form-label">Item Description</label>
                    <input type="text" class="form-control" name="updateItemDescription" id="updateItemDescription"/> --}}
                    {{-- <label for="example-text-input" class="col-form-label">Category Description<span style="color: red"> *</span></label>
                    <input type="text" class="form-control" name="updateCategoryName" id="updateCategoryName" required placeholder="Category Name"/> --}}
                    {{--<small class="text-danger">{{ $errors->first('uCategory') }}</small>--}}
                </div>
                <button type="submit" class="btn btn-md btn-outline-primary waves-effect" onclick="updateVehicle()"> Update Vehicle</button>
            </div>
            <input type="hidden" id="hiddenItemId">
        </div>
    </div>
</div>

<!--View Vehicle modal-->
<div class="modal fade" id="viewVehicleModal" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Vehicle Details</h5>
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
                        <label for="viewRegNumber" class="col-sm-4 col-form-label">Registration Number</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewRegNumber" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewMake" class="col-sm-4 col-form-label">Make</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewMake" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewModel" class="col-sm-4 col-form-label">Model</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewModel" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewChassis" class="col-sm-4 col-form-label">Chassis number</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewChassis" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewChassis" class="col-sm-4 col-form-label">Engine number</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewEngine" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewYear" class="col-sm-4 col-form-label">Year</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewYear" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewStatus" class="col-sm-4 col-form-label">Status</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewStatus" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ViewCusName" class="col-sm-4 col-form-label">Customer Name</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="ViewCusName" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewCusNic" class="col-sm-4 col-form-label"> Customer NIC</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewCusNic" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewRemarks" class="col-sm-4 col-form-label"> Remarks</label>
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

            $('#updateRegNumberError').html("");
            $("#updateMakeError").html("");
            $('#updateModelError').html("");
            $('#updateEngineError').html("");
            $('#updateChassisError').html("");
            $('updateCustomerListError').html("");
            
            $('#customerError').html("");
            $("#regNumberError").html("");
            $('#nameError').html("");
            $('#makeError').html("");
            $('#modelError').html("");
            $("#yearError").html("");
            $("#engineError").html("");
            $("#chassisError").html("");
            $('input').val('');
        });

    function changeStatus(dataID, tableName) {        
        $.post('activateDeactivate', {id: dataID, table: tableName}, function (data) {
            
        });
    }
    
    function saveVehicle() {        
        //alert("test");
    $('#customerError').html("");
    $("#regNumberError").html("");
    $('#nameError').html("");
    $('#makeError').html("");
    $('#modelError').html("");
    $("#yearError").html("");
    $("#engineError").html("");
    $("#chassisError").html("");

    var customer = $("#customer").val();
    //var name = $("#name").val();
    var regNumber = $("#regNumber").val();
    var make = $("#make").val();
    var model=$("#model").val();
    var year=$("#year").val();
    var engine=$("#engine").val();
    var chassis=$("#chassis").val();
    var vehicleRemarks=$("#vehicleRemarks").val();
    //var customer_id=$("#customer_id").val();

$.post('saveVehicle', {
    customer:customer,
    regNumber:regNumber,
    make:make,
    model:model,
    year:year,
    engine:engine,
    chassis:chassis,
    vehicleRemarks:vehicleRemarks,
    //customer_id:customer_id,
    
}, function (data) {
       // console.log(data);
    if (data.errors != null) {
        
        if(data.errors.error){
            var p = document.getElementById('regNumberError');
                p.innerHTML = data.errors.error; //this is a custom
        }

        if(data.errors.customer){
            var p = document.getElementById('customerError');
            p.innerHTML = data.errors.customer;
        }
      
        if(data.errors.regNumber){
            var p = document.getElementById('regNumberError');
            p.innerHTML = data.errors.regNumber;
        }

        if(data.errors.make){
            var p = document.getElementById('makeError');
            p.innerHTML = data.errors.make;
        }

        if(data.errors.model){
            var p = document.getElementById('modelError');
            p.innerHTML = data.errors.model;
        }
        
    }
    if (data.success != null) {
        //$(".select2").val('').trigger('change');
        notify({
            type: "success", 
            title: 'VEHICLE SAVED SUCCESSFULLY',
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
            $('#addVehicleModal').modal('hide');
        }, 200);
       location.reload();
    }
   
});
}

        //view vehicle details
        $(document).on('click', '#viewVehicle', function () {
                var vehicleID = $(this).data("id");

                $.post('viewVehicle', {vehicleID: vehicleID}, 
                function (data) {
                    $("#hiddenVehicleId").val(data.getVehicleDetail.vehicle_id);
                    //$("#updateCategoryDescription").val(data.getVehicleDetail.category_long_description);
                    $("#viewRegNumber").val(data.getVehicleDetail.vehicle_registration_number);
                    $("#viewMake").val(data.getVehicleDetail.vehicle_make);
                    $("#viewModel").val(data.getVehicleDetail.vehicle_model);
                    $("#viewChassis").val(data.getVehicleDetail.vehicle_chassis_number);
                    $("#viewEngine").val(data.getVehicleDetail.vehicle_engine_number);
                    $("#viewYear").val(data.getVehicleDetail.vehicle_manufacture_year);
                    $("#viewStatus").val(data.getVehicleDetail.vehicle_status);
                    $("#ViewCusName").val(data.getCustomerDetail.customer_firstname);
                    $("#viewCusNic").val(data.getCustomerDetail.customer_nic);
                    $("#viewRemarks").val(data.getVehicleDetail.vehicle_remarks);

                });
            });

        //view customer name when selecting the ID
        function viewCustomerName(customerID){ 

            $.post('viewCustomerName', {
                customerID:customerID
            },function(data){ //returned via controller
            
            //console.log (data);
            
            $("#name").val(data.customer_firstname);
            //$("customer_id").val(data.customer_id);

            });
}


function updateVehicle() {

        $('#updateRegNumberError').html("");
        $("#updateMakeError").html("");
        $('#updateModelError').html("");
        $('#updateEngineError').html("");
        //$('#updateCustomerError')
        $('#updateChassisError').html("");
        $('updateCustomerListError').html("");

        var updateRegNumber = $('#updateRegNumber').val();
        var updateMake = $('#updateMake').val();
        var updateModel = $('#updateModel').val();
        var updateEngine = $('#updateEngine').val();
        var updateChassis = $('#updateChassis').val();
        var updateYear = $('#updateYear').val();
        var updateCustomer = $('#updateCustomerList').val();
        var updateRemarks = $('#updateRemarks').val();
        var hiddenVehicleId = $('#hiddenVehicleId').val();
       
            $.post('updateVehicle',{

                updateRegNumber:updateRegNumber,
                updateMake:updateMake,
                updateModel:updateModel,
                updateEngine:updateEngine,
                updateChassis:updateChassis,
                updateYear:updateYear,
                updateCustomer:updateCustomer,
                updateRemarks:updateRemarks,
                hiddenVehicleId:hiddenVehicleId,

                    
                },  function (data) {
                    // if (data.errors != null) {
                    //     $('#errorAlert1').show();
                    //     $.each(data.errors, function (key, value) {
                    //         $('#errorAlert1').append('<p>' + value + '</p>');
                    //     });
                    // }
                    //console.log(data);
                    if (data.errors != null) {

                        if(data.errors.updateRegNumber){
                        var p = document.getElementById('updateRegNumberError');
                        p.innerHTML = data.errors.updateRegNumber;
                        }
                        
                        if(data.errors.updateMake){
                            var p = document.getElementById('updateMakeError');
                            p.innerHTML = data.errors.updateMake;
                        }

                        if(data.errors.updateModel){
                            var p = document.getElementById('updateModelError');
                            p.innerHTML = data.errors.updateModel;
                        }

                        if(data.errors.updateCustomer){
                            var p = document.getElementById('updateCustomerListError');
                            p.innerHTML = data.errors.updateCustomer;
                        }

                    }
                    
                    

                    if (data.success != null) {
                        notify({
                            type: "success", 
                            title: 'VEHICLE UPDATED SUCESSFULLY',
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

function deleteVehicle(vehicleId){ //defined varible in ajax is categoryId
            swal({
        title: 'Do you really want to delete this Vehicle?',
        //type: 'warning',
        dangerMode:true,
        buttons: true,
        showCancelButton: true,
        confirmButtonText: 'YES',
        cancelButtonText: 'NO',
        confirmButtonClass: 'btn btn-md btn-danger waves-effect',
        cancelButtonClass: 'btn btn-md btn-primary waves-effect',
        buttonsStyling: false
        }).then(function () {
            $.post('deleteVehicle',{
                vehicleId:vehicleId,
            },function (data){
                if (data.success != null) {
        notify({
            type: "success", //alert | success | error | warning | info
            title: 'VEHICLE DELETED',
            autoHide: true, //true | false
            delay: 2500, //number ms
            position: {
                x: "right",
                y: "top"
            },
            icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',
            message: data.success,
        });
        //$('input').val('');  
        /**removed coz no modal**/
        // setTimeout(function () {
        //     $('#addCategoryModal').modal('hide');
        // }, 200);
        location.reload(); //refreshes the location 
    }
});
}), function () { 
}
    
}
        $(document).on('click', '#updateVehicle', function () {
        var vehicleId = $(this).data("id");
            $.post('getByVehicleId', 
            {
                vehicleId: vehicleId
            }, function (data){
                $("#hiddenVehicleId").val(data.getVehicleDetails.vehicle_id);
                $("#updateRegNumber").val(data.getVehicleDetails.vehicle_registration_number);
                $("#updateMake").val(data.getVehicleDetails.vehicle_make);
                $("#updateModel").val(data.getVehicleDetails.vehicle_model);
                $("#updateEngine").val(data.getVehicleDetails.vehicle_engine_number);
                $("#updateChassis").val(data.getVehicleDetails.vehicle_chassis_number);
                $("#updateYear").val(data.getVehicleDetails.vehicle_manufacture_year);
                $("#updateCustomer").val(data.getCustomerDetails.customer_nic);
                $("#updateRemarks").val(data.getVehicleDetails.vehicle_remarks);
                $("#updateCustomerList").val(data.getVehicleDetails.vehicle_customer_id).trigger('change');
               // $("#updateCustomerList").val(data.)
                
            });
        });
        $(document).ready(function(){
            $( document ).on( 'focus', ':input', function(){
                $( this ).attr( 'autocomplete', 'off' );
            });
        });

</script>
@include('includes/footer_end')