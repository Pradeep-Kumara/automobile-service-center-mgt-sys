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
        <div class="col-lg-6">
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="row">   
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-primary waves-effect float-right"
                                    data-toggle="modal"  data-target="#addRefundModal" >
                                Set Refund Amount</button>
                        </div>
                    </div>
                    <div class="table-rep-plugin">
                        <div class="table-responsive b-0" data-pattern="priority-columns">
                            <table  class="table table-striped table-bordered"
                                    cellspacing="0"
                                    width="100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if(isset($refund))
                                            @if(count($refund)==0)
                                                <tr>
                                                    <td colspan="6" style="text-align: center;font-weight: bold  ">Sorry, No Results Found.
                                                    </td>
                                                </tr>
                                            @endif
                                        
                                        @foreach($refund as $refund)
                                            <tr>
                                                <td>{{$refund->refund_id}}</td>
                                                <td>{{$refund->refund_amount}}</td>
                                                <td>{{$refund->created_at}}</td>
                                                <td>
                                                    <p>   
                                                        <button type="button" 
                                                                class="btn btn-sm btn-basic  waves-effect waves-light" 
                                                                onclick="deleteRecord({{$refund->refund_id}})">                                                        
                                                                <i class="fa fa-times"></i>
                                                        </button>
                                                    </p>
                                                </td>
                                            </tr>
                                        @endforeach
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

<!--Add refund modal-->
<div class="modal fade" id="addRefundModal" tabindex="-1"
     role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Add refund record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
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
                            <label for="example-text-input" class="col-form-label">Refund Amount<span style="color: red"> *</span></label>

                            <input type="text" class="form-control" name="refundAmount" id="refundAmount" required placeholder="00.00"/>
                            <small class="text-danger">{{ $errors->first('refundAmount')}}</small>
                    </div>
                <button type="button" class="btn btn-md btn-outline-primary waves-effect" onclick="saveRefund()">
                    Save Refund
                </button>
                </div>
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
        $('form').parsley();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') //?????
            }
        });
        
    });
    $(document).on("wheel", "input[type=number]", function (e) {    /////?????
        $(this).blur();
    }); 


    $('.modal').on('hidden.bs.modal', function () { //bootstrap.min.css or bootstrap.css


        $('#errorAlert').hide(); //hide the error
        $('#errorAlert').html(''); //delete the text in the error

        $('#errorAlert1').hide();
        $('#errorAlert1').html('');
        $('input').val('');

    });
   
    function saveRefund() {
        
         $('#errorAlert').hide();
         $('#errorAlert').html("");

         var refundAmount = $("#refundAmount").val();
                 
        $.post('saveRefund',{
            refundAmount:refundAmount
        },function (data) {
    
           if (data.errors != null) {
                $('#errorAlert').show();
                $.each(data.errors, function (key, value) {
                    $('#errorAlert').append('<p>' + value + '</p>');
                });
            }
            if (data.success != null) {
                notify({
                    type: "success",
                    title: 'RECORD SAVED',
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
                    $('#addRefundModal').modal('hide');
                }, 200);
                location.reload();
            }
            
        });

    }

    function deleteRecord(refundId){ //defined varible in ajax is categoryId
        
        swal({
    title: 'Do you really want to delete this record?',   
    dangerMode:true,
    buttons: true,
    showCancelButton: true,
    confirmButtonText: 'YES',
    cancelButtonText: 'NO',
    confirmButtonClass: 'btn btn-md btn-danger waves-effect',
    cancelButtonClass: 'btn btn-md btn-primary waves-effect',
    buttonsStyling: false
    }).then(function () {
        $.post('deleteRefund',{
            refundId:refundId,  //1st var is to send to backend and second one is what we passes inside the function as parameter
},function (data){

            if (data.success != null) {
    notify({
        type: "success",
        title: 'RECORD DELETED',
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

       
    $(document).ready(function(){
        $( document ).on( 'focus', ':input', function(){
            $( this ).attr( 'autocomplete', 'off' );
        });
    });

</script>


@include('includes/footer_end')