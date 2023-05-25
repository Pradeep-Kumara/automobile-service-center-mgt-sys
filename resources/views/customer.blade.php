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
                        <div class="row p-3 mb-2 bg-white text-dark">
                            <div class="col-lg-8">
                                <h1>Customer</h1>
                            </div>                          
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <button type="button" 
                                            class="btn btn-primary waves-effect float-right" 
                                            data-toggle="modal"  
                                            data-target="#addCustomerModal">
                                            Create Customer
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
                                            <th>NIC</th>
                                            <th>Name</th>
                                            <th>Mobile Number</th>
                                            <th>Address</th>
                                            <th>Email</th>
                                            <th>Active</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                    
                                        @if(isset($customerView))
                                        @if(count($customerView) > 0)
                                         
                                        @foreach($customerView as $customer)
                                            <tr>
                                                <td>{{$customer->customer_nic}}</td>
                                                <td>{{$customer->customer_firstname}}</td>
                                                <td>{{$customer->customer_mobile}}</td>
                                                <td>{{$customer->customer_address}}</td>
                                                <td>{{$customer->customer_email}}</td>
                                                                                                   
                                                @if($customer->customer_status == 1)
    
                                                    <td >
                                                        <p>
                                                            <input type="checkbox" class="status"
                                                                   onchange="changeStatus('{{ $customer->customer_id}}','customer')"
                                                                   id="{{"c".$customer->customer_id}}" checked
                                                                   switch="none"/>
                                                            <label for="{{"c".$customer->customer_id}}"
                                                                   data-on-label="Yes"
                                                                   data-off-label="No"></label>
                                                        </p>
                                                    </td>
                                                @else
                                                    <td >
                                                        <p>
                                                            <input type="checkbox" class="status"
                                                                   onchange="changeStatus('{{ $customer->customer_id}}','customer')"
                                                                   id="{{"c".$customer->customer_id}}"
                                                                   switch="none"/>
                                                            <label for="{{"c".$customer->customer_id}}"
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
                                                                data-id="{{ $customer->customer_id}}"
                                                                data-name="{{ $customer->customer_id}}"
                                                                id="viewCustomer"
                                                                data-target="#viewCustomerModal">
                                                                <i class="fa fa-eye"></i>                                            
                                                        </button>
                                                        <button type="button" title="Edit"
                                                                class="btn btn-sm btn-basic  waves-effect waves-light"
                                                                data-toggle="modal"
                                                                data-id="{{ $customer->customer_id}}"
                                                                data-name="{{ $customer->customer_id}}"
                                                                id="updateCustomer"
                                                                data-target="#updateCustomerModal">
                                                                <i class="fa fa-edit"></i>
                                                        </button>
                                                        <button type="button" title="Delete"
                                                                class="btn btn-sm btn-basic  waves-effect waves-light" 
                                                                onclick="deleteCustomer({{$customer->customer_id}})">                                                        
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

    <!--add customer modal-->
<div    class="modal fade" 
    id="addCustomerModal"
    role="dialog"
    aria-labelledby="mySmallModalLabel" 
    aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0">Create Customer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>

        <div class="modal-body">
            {{-- row 1 --}}
            <div class="row bg-light">             
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>NIC<span style="color: red"> *</span></label>    
                        <input  type="text" 
                                class="form-control" 
                                name="nic"
                                id="nic" 
                                required placeholder="National ID / PP number">
                        <span class="text-danger" id="nicError"></span>
                        <input type='hidden' id="customer_id" name = "customer_id" value ="{{"$customer->customer_id"}}">
                    </div>
                </div>                                       
            
                     
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>First Name<span style="color: red"> *</span></label>    
                        <input  type="text" 
                                class="form-control" 
                                name="firstname"
                                id="firstname" 
                                required placeholder="First Name">
                        <span class="text-danger" id="firstnameError"></span>
                    </div>
                </div>                                       
            
                         
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Last Name<span style="color: red"> *</span></label>    
                        <input  type="text" 
                                class="form-control" 
                                name="lastname"
                                id="lastname" 
                                required placeholder="Last Name">
                                
                        <span class="text-danger" id="lastnameError"></span>
                    </div>
                </div>                                       
            </div>

        {{-- row 2 --}}
            <div class="row"> 

                <div class="col-lg-12">
                    <div class="form-group">
                        <label>Address</span></label>
                        <input  type="text" 
                                class="form-control" 
                                name="address"
                                id="address" 
                                placeholder="Enter Home Number"/>
                        <span class="text-danger" id="addressError"></span>
                    </div>
                </div> 
                
                {{-- <div class="col-lg-4">
                    <div class="form-group">
                        <label>Street</span></label>
                        <input  type="text" 
                                class="form-control" 
                                name="street"
                                id="street" 
                                placeholder="Enter Street Name"/>
                        <span class="text-danger" id="addressError"></span>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label>City</span></label>
                        <input  type="text" 
                                class="form-control" 
                                name="city"
                                id="city" 
                                placeholder="Enter City Name"/>
                        <span class="text-danger" id="addressError"></span>
                    </div>
                </div> --}}
            
            </div>
            {{-- row 3 --}}
            <div class ="row bg-light">              
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Mobile Number</label>
                        <input type="text" class="form-control" name="mobile" id="mobile" 
                        placeholder="07x12x456x"/>                     
                        <span class="text-danger" id="mobileError"></span>
                    </div>                 
                </div>
                <div class="col-lg-8">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" name="email" id="email" 
                        placeholder="sample@sample.com"/>                     
                        <span class="text-danger" id="emailError"></span>
                    </div>                   
                </div>

            </div>
            {{-- row 4 --}}

            <div class="row">
                <div class="col-lg-4" style="padding-top: 14px">
                    <button type="button" class="btn btn-md btn-outline-primary waves-effect"  onclick="createCustomer()">Save Customer</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!--View Customer modal-->

<div class="modal fade" id="viewCustomerModal" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Customer Details</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-group row">
                        <label for="viewNic" class="col-sm-4 col-form-label">NIC</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewNic" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewFirstName" class="col-sm-4 col-form-label">First Name</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewFirstName" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewLastName" class="col-sm-4 col-form-label">Last Name</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewLastName" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewAddres" class="col-sm-4 col-form-label">Address</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewAddres" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewMobile" class="col-sm-4 col-form-label">Mobile number</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewMobile" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewEmail" class="col-sm-4 col-form-label">Email</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewEmail" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-md btn-outline-primary waves-effect float-right" data-dismiss="modal" >Close</button>
                        </div>
                    </div> 
                </div>
            </div>
            {{-- <input type="hidden" id="hiddenCustomerId"> --}}
        </div>
    </div>
</div>


<!--Update Customer modal-->

<div class="modal fade" id="updateCustomerModal" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Edit Customer</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissible " id="errorAlert" style="display:none">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-group row">
                        <label for="updateNic" class="col-sm-4 col-form-label">NIC</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name ="updateNic" id="updateNic" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="updateFirstName" class="col-sm-4 col-form-label">First Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="updateFirstName" id="updateFirstName"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="updateLastName" class="col-sm-4 col-form-label">Last Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="updateLastName" id="updateLastName"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="updateAddress" class="col-sm-4 col-form-label">Address</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="updateAddress" id="updateAddress"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="updateMobile" class="col-sm-4 col-form-label">Mobile</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="updateMobile" id="updateMobile"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="updateEmail" class="col-sm-4 col-form-label">Email</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="updateEmail" id="updateEmail"/>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-md btn-outline-primary waves-effect" onclick="updateCustomer()"> Update Customer</button>
            </div>
            <input type="hidden" id="hiddenCustomerId">
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
            // $('#errorAlert1').hide();
            // $('#errorAlert1').html('');
            // $('input').val('');
            $('#errorAlert').hide();
            $('#errorAlert').html('');
            $('input').val('');

            $('#nicError').html("");
            $('#firstnameError').html("");
            $('#lastnameError').html("");
            $('#addressError').html("");
            $('#mobileError').html("");
            $("#emailError").html("");

            // $("#uomError").html("");
            // $("#unitCostError").html("");
            // $("#unitPriceError").html("");

        });

    
    function changeStatus(dataID, tableName) {        
        $.post('activateDeactivate', {id: dataID, table: tableName}, function (data) {
           
        });
    }
    
    
    function createCustomer() {
        
        $('#nicError').html("");
        $('#firstnameError').html("");
        $('#lastnameError').html("");
        //$('#addressError').html("");
        $('#mobileError').html("");
        $("#emailError").html("");
        
        var nic = $("#nic").val();
        var firstname = $("#firstname").val();
        var lastname = $("#lastname").val();
        var address = $("#address").val();
        var mobile=$("#mobile").val();
        var email=$("#email").val();
        //var street = $("#street").val();
        //var city = $("#city").val();
        

$.post('saveCustomer', {
    nic: nic,
    firstname: firstname,
    lastname: lastname,
    address: address,
    mobile:mobile,
    email:email,
    // city:city,
    //street:street,
    
     
}, function (data) {
    //console.log(data);
    
    if (data.errors != null) {

        if(data.errors.nic){
            var p = document.getElementById('nicError');
            p.innerHTML = data.errors.firstname;
        }

        if(data.errors.firstname){
            var p = document.getElementById('firstnameError');
            p.innerHTML = data.errors.firstname;
        }

        if(data.errors.lastname){
            var p = document.getElementById('lastnameError');
            p.innerHTML = data.errors.lastname;
        }

        // if(data.errors.address){
        //     var p = document.getElementById('addressError');
        //     p.innerHTML = data.errors.address;
        // }

        if(data.errors.mobile){
            var p = document.getElementById('mobileError');
            p.innerHTML = data.errors.mobile;
        }

        if(data.errors.email){
            var p = document.getElementById('emailError');
            p.innerHTML = data.errors.email;
        }

    }
    if (data.success != null) {
       // $(".select2").val('').trigger('change');
        notify({
            type: "success",
            title: 'CUSTOMER SAVED SUCCESSFULLY',
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
            $('#addCustomerModal').modal('hide');
        }, 200);
       location.reload();
    }
});
}


function updateCustomer() 
{
                $('#errorAlert').hide();
                $('#errorAlert').html("");

                var updateNic = $("#updateNic").val();
                var updateFirstName = $("#updateFirstName").val();
                var updateLastName = $("#updateLastName").val();
                var updateAddress = $("#updateAddress").val();
                var updateMobile = $("#updateMobile").val();
                var updateEmail = $("#updateEmail").val();
                var hiddenCustomerId=$("#hiddenCustomerId").val();
                
                $.post('updateCustomer',
                        {   
                            updateNic:updateNic,
                            updateFirstName:updateFirstName,
                            updateLastName:updateLastName,
                            updateAddress:updateAddress,
                            updateMobile:updateMobile,
                            updateEmail:updateEmail,
                            hiddenCustomerId:hiddenCustomerId,

                        },  function (data) {

                                if (data.errors != null) {
                                    //console.log(data);
                                    $('#errorAlert').show();
                                    $.each(data.errors, function (key, value) {
                                        $('#errorAlert').append('<p>' + value + '</p>');
                                    });
                                }
                                if (data.success != null) {
                                    notify({
                                        type: "success", 
                                        title: 'CUSTOMER UPDATED SUCESSFULLY',
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

 
 
 //view Customer details
 $(document).on('click', '#viewCustomer', function () {
                var customerId = $(this).data("id");

                $.post('viewCustomer', {customerId: customerId}, 
                function (data) {
                    
                    $("#viewNic").val(data.customer.customer_nic);
                    $("#viewFirstName").val(data.customer.customer_firstname);
                    $("#viewLastName").val(data.customer.customer_lastname);
                    $("#viewAddres").val(data.customer.customer_address);
                    $("#viewMobile").val(data.customer.customer_mobile);
                    $("#viewEmail").val(data.customer.customer_email);                    
                   
                });
            });




function deleteCustomer(customerId)
{
                        swal({
                    title: 'Do you really want to delete this Customer?',
                    dangerMode:true,
                    buttons: true,
                    showCancelButton: true,
                    confirmButtonText: 'YES',
                    cancelButtonText: 'NO',
                    confirmButtonClass: 'btn btn-md btn-danger waves-effect',
                    cancelButtonClass: 'btn btn-md btn-primary waves-effect',
                    buttonsStyling: false
                    }).then(function ()
                         {
                            $.post('deleteCustomer',{
                                customerId:customerId,  
                            },function (data){
                                if (data.success != null) {
                                notify({
                                    type: "success", 
                                    title: 'CUSTOMER DELETED',
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
                        }), function () { }
                                        
    
}



//update Customer details
        $(document).on('click', '#updateCustomer', function () {
        var customerID = $(this).data("id");
        //console.log(customerID);
            $.post('getByCustomerId', {
                customerID: customerID
            }, function (data)            
            {
                //console.log(data);
                                
                $("#hiddenCustomerId").val(data.customer_id);
                $("#updateNic").val(data.customer_nic);
                $("#updateFirstName").val(data.customer_firstname);
                $("#updateLastName").val(data.customer_lastname);
                $("#updateAddress").val(data.customer_address);                   
                $("#updateMobile").val(data.customer_mobile);
                $("#updateEmail").val(data.customer_email);
               
            });
        });


        $(document).ready(function(){
            $( document ).on( 'focus', ':input', function(){
                $( this ).attr( 'autocomplete', 'off' );
            });
        });

</script>
@include('includes/footer_end')
