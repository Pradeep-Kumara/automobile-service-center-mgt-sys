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
        <h3 class="page-title">{{$title}}</h3>
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
        <div class="col-lg-8">
            <div class="card m-b-20">
                <div class="card-body">
                   
                    <div class="row">   
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-primary waves-effect float-right"
                                    data-toggle="modal"  data-target="#addUserModal" >
                                Add User</button>
                        </div>
                    </div>
                    <div class="table-rep-plugin">
                        <div class="table-responsive b-0" data-pattern="priority-columns">
                            <table  class="table table-striped table-bordered"
                                    cellspacing="0"
                                    width="100%">
                                <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>User Name</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($userView))
                                    @if(count($userView)==0)
                                        <tr>
                                            <td colspan="6" style="text-align: center;font-weight: bold  ">Sorry, No Users Found.
                                            </td>
                                        </tr>
                                    @endif
                                    @foreach($userView as $user)
                                        <tr>
                                            <td>{{$user->user_id}}</td>
                                            <td>{{$user->user_name}}</td>
                                            <td>{{$user->roleRelation->role_name}}</td>
                                                @if($user->user_status == 1)
    
                                                    <td >
                                                        <p>
                                                            <input type="checkbox" class="status"
                                                                   onchange="changeStatus('{{ $user->user_id}}','user')"
                                                                   id="{{"c".$user->user_id}}" checked
                                                                   switch="none"/>
                                                            <label for="{{"c".$user->user_id}}"
                                                                   data-on-label="Yes"
                                                                   data-off-label="No"></label>
                                                        </p>
                                                    </td>
                                                @else
                                                    <td >
                                                        <p>
                                                            <input type="checkbox" class="status"
                                                                   onchange="changeStatus('{{ $user->user_id}}','user')"
                                                                   id="{{"c".$user->user_id}}"
                                                                   switch="none"/>
                                                            <label for="{{"c".$user->user_id}}"
                                                                   data-on-label="Yes"
                                                                   data-off-label="No"></label>
                                                        </p>
                                                    </td>
                                                @endif
                                                <td>
                                                    <p>
                                                        {{-- <button type="button" title="View"
                                                                class="btn btn-sm btn-basic  waves-effect waves-light"
                                                                data-toggle="modal"                                                                
                                                                data-id="{{ $user->user_id}}"
                                                                data-name="{{ $user->user_id}}"
                                                                id="viewUser"
                                                                data-target="#viewUserModal">
                                                                <i class="fa fa-eye"></i>                                            
                                                        </button> --}}
                                                        <button type="button"
                                                                class="btn btn-sm btn-basic  waves-effect waves-light"
                                                                data-toggle="modal"
                                                                data-id="{{ $user->user_id}}"
                                                                id="updateUser" 
                                                                data-target="#updateUserModal">
                                                                <i class="fa fa-edit"></i>
                                                        </button>
                                                        <button type="button" 
                                                                class="btn btn-sm btn-basic  waves-effect waves-light" 
                                                                onclick="deleteUser({{$user->user_id}})">                                                        
                                                                <i class="fa fa-times"></i>
                                                        </button>
                                                    </p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- container -->

</div> <!-- Page content Wrapper -->

</div> <!-- content -->

<!--Add User modal-->
<div class="modal fade" id="addUserModal" tabindex="-1"
     role="dialog"
     aria-labelledby="mySmallModalLabel" 
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                    </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissible" id="errorAlert" style="display:none">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                        </div>
                    </div>
                </div>
                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label">User Name<span style="color: red"> *</span></label>
                        <input type="text" class="form-control" name="saveUsername" id="saveUsername" required/>
                        <small class="text-danger" id="saveUsernameError"></small>                         
                    </div>
                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label"> Mobile Number</label>
                        <input type="text" class="form-control" name="saveMobile" id="saveMobile" required />
                        <small class="text-danger" id="saveMobileError"></small>                        
                    </div>
                    <div class="form-group">
                        <label for="savePassword">Password<span style="color: red"> *</span></label>
                        <input type="password" class="form-control" id="savePassword" autocomplete="off" name="savePassword" placeholder="Enter password">
                        <small class="text-danger" id="savePasswordError"></small>
                    </div>
                    <div class="form-group">
                        <label>User Role<span style="color: red"> *</span></label>
                        <select class="form-control select2 tab" name="saveRole" id="saveRole" required>
                            <option value="" disabled selected>Select user role </option>
                            @if(isset($roleView))
                                @foreach($roleView as $role)
                                    <option value="{{"$role->role_id"}}">{{$role->role_name}} </option>
                                @endforeach
                            @endif
                        </select>
                        <span class="text-danger" id="saveRoleError"></span>
                    </div>
                    <div class="row">
                        <div class="col-lg-4" style="padding-top: 14px">
                            <button type="button" class="btn btn-md btn-outline-primary waves-effect"  onclick="createUser()">Create User</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--Update category modal-->
<div class="modal fade" id="updateUserModal" tabindex="-1"
     role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Edit User</h5>
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
                    <label for="updateUsername" class="col-form-label">User Name</label>
                    <input type="text" class="form-control" name="updateUsername" id="updateUsername"/>
                </div>
                <div class="form-group">
                    <label for="updatePassword" class="col-form-label">Password</label>
                    <input type="text" class="form-control" name="updatePassword" id="updatePassword"/>
                </div>
                <button type="submit" class="btn btn-md btn-outline-primary waves-effect" onclick="updateUser()"> Update User</button>
            </div>
            <input type="hidden" id="hiddenUserId">
        </div>
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


    $('#errorAlert').hide(); 
    $('#errorAlert').html('');
    $('input').val('');

});

function createUser(){
 
         $('#errorAlert').hide();
         $('#errorAlert').html("");

         var saveUsername = $("#saveUsername").val(); 
         var saveMobile = $("#saveMobile").val();
         var savePassword = $("#savePassword").val();
         var saveRole = $("#saveRole").val();

    $.post('createUser',{
        saveUsername:saveUsername,  
        saveMobile:saveMobile,
        savePassword:savePassword,  
        saveRole:saveRole,

            },function (data) { 

            console.log(data);
    
           if (data.errors != null) {
                $('#errorAlert').show();
                $.each(data.errors, function (key, value) {
                $('#errorAlert').append('<p>' + value + '</p>');
                });
            }
            if (data.success != null) {
                notify({
                    type: "success",
                    title: 'USER SAVED',
                    autoHide: true, 
                    delay: 2500, 
                    position: {
                        x: "right",
                        y: "top"
                    },
                    icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',

                    message: data.success,
                });
                $('input').val(''); 
                setTimeout(function () {
                    $('#addUserModal').modal('hide');
                }, 200);
                location.reload(); 
            }
          
            
        });

}

function changeStatus(dataID, tableName) {
    $.post('activateDeactivate', {id: dataID, table: tableName}, function (data) {
});
}



function deleteUser(userId){ 
        
        swal({
    title: 'Do you really want to delete this category?',
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
        $.post('deleteUser',{

            userId:userId,  

        },function (data){

                    if (data.success != null) {
            notify({
                type: "success", //alert | success | error | warning | info
                title: 'CATEGORY DELETED',
                autoHide: true, //true | false
                delay: 2500, //number ms
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



function updateUser() {

    $('#errorAlert1').hide();
    $('#errorAlert1').html("");

var updateUsername = $("#updateUsername").val();
var updatePassword = $("#updatePassword").val();
var hiddenUserId = $("#hiddenUserId").val();

$.post('updateUser',{
    updateUsername:updateUsername,
    updatePassword:updatePassword,
    hiddenUserId:hiddenUserId,

},function (data) {

    if (data.errors != null) {
        $('#errorAlert1').show();
        $.each(data.errors, function (key, value) {
            $('#errorAlert1').append('<p>' + value + '</p>');
        });
    }
    if (data.success != null) {
        notify({
            type: "success", 
            title: 'USERNAME AND PASSWORD UPDATED',
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

$(document).on('click', '#updateUser', function () {
        var userID = $(this).data("id");

        $.post('getByUserId', {
            userID: userID,
            }, function (data) {
            $("#hiddenUserId").val(data.user_id);
            $("#updateUsername").val(data.user_name);
        });
    });



    $(document).ready(function(){
        $( document ).on( 'focus', ':input', function(){
            $( this ).attr( 'autocomplete', 'off' );
        });
    });



</script>


@include('includes/footer_end')