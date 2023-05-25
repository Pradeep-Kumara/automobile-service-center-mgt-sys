@include('includes/header_start')

<link href="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
    type="text/css" />
<link href="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet"
    type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
    type="text/css" />
<link href="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">

<!-- Plugins css -->
<link href="{{ URL::asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}"
    rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}"
    rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css') }}"
    rel="stylesheet" />
<link href="{{ URL::asset('assets/css/custom_checkbox.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/css/jquery.notify.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('assets/css/mdb.css') }}" rel="stylesheet" type="text/css">

<meta name="csrf-token" content="{{ csrf_token() }}" />


@include('includes/header_end')

<!-- Page title -->
<ul class="list-inline menu-left mb-0">
    <li class="list-inline-item">
        <button type="button" class="button-menu-mobile open-left waves-effect">
            <i class="ion-navicon"></i>
        </button>
    </li>
    <li class="hide-phone list-inline-item app-search">
        <h3 class="page-title">Service Processing - Job Card</h3>
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
    <div class="row">
        <div class="col-lg-4">
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger alert-dismissible " id="errorAlert2" style="display:none">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>

                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="customer" class="col-sm-4 col-form-label">Order No</label>
                        <div class="col-sm-8">
                            <select class="form-control select2 tab" onchange="getOrderDetail(this.value)"
                                name="customer" required>
                                <option value="" disabled selected>Select Order No
                                </option>

                                @foreach ($orderNo as $order)
                                    <option value="{{ "$order->order_id" }}">
                                        {{-- {{ "$order->order_code" }} - --}}
                                        {{-- {{ "$order->order_id" }} --}}
                                        {{ "$order->order_code" }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="date" class="col-sm-4 col-form-label">Date</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" id="Jobate" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="customer" class="col-sm-4 col-form-label">Customer</label>
                        <div class="col-sm-8">
                            <select class="form-control  select2 tab" disabled name="customer" id="customer" required>
                                <option value="" disabled selected>Select Customer
                                </option>

                                @foreach ($customers as $customer)
                                    <option value="{{ "$customer->customer_id" }}">
                                        {{ "$customer->customer_firstname" }}
                                        {{ "$customer->customer_lastname" }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="vehicle" class="col-sm-4 col-form-label">Vehicle</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="vehicle" readonly
                                placeholder="select vehicle number">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="mobile" class="col-sm-4 col-form-label">Mobile</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" readonly id="mobile">
                        </div>
                    </div>
                    <div class="form-group row">
                        {{-- <label for="start"
                            class="col-sm-4 col-form-label">Time</label> --}}
                        <div class="col-sm-6">
                            <label>Start Time</label>
                            <input type="time" class="form-control" readonly id="start">
                        </div>
                        <div class="col-sm-6">
                            <label>End Time</label>
                            <input type="time" class="form-control" readonly id="end">
                           
                        </div>
                        
                    </div>

                    <div class="form-group row">
                        <label for="duration" class="col-sm-4 col-form-label">Duration</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" readonly id="duration">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cost" class="col-sm-4 col-form-label">Spending</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" readonly id="cost">
                        </div>
                    </div>
                    <div class="form-group row" id="refundArea" style="display:none"> 
                        <label for="cost" class="col-sm-4 col-form-label">Refund</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" readonly id="refundAmount">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <button type="button" id="startBtn" class="btn btn-primary saveBtn btn-block" onclick="jobStart()">Job
                                Start</button>
                                <button type="button" class="btn btn-primary" id="waitButton" style="display: none">
                                    <i class="fa fa-circle-o-notch fa-spin"></i> Plsease Wait</button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" id="endTimeBtn" class="btn btn-primary saveBtn btn-block"
                                onclick="jobEnd()">Job End</button>
                                
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <div class="col-lg-8">
            {{-- <div class="col-lg-6"> --}}
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary waves-effect float-right"
                                    data-toggle="modal" data-target="#addTaskModal">
                                    Add Task(s)
                                </button>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="table-rep-plugin">
                        <div class="table-responsive b-0" data-pattern="priority-columns">
                            <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Task</th>
                                        <th>Duration(hrs.)</th>
                                        <th>Spending(Rs.)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="taskTable">

                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
            <div class="card m-b-20">
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-8">
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary waves-effect float-right"
                                    data-toggle="modal" data-target="#addItemModal">
                                    Add Item(s)
                                </button>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-rep-plugin">
                                <div class="table-responsive b-0" data-pattern="priority-columns">
                                    <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Quantity(units)</th>
                                                <th>Spending(Rs.)</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="itemTable">

                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- </div> --}}
        </div><!-- container -->
    </div>
</div>
</div> <!-- Page content Wrapper -->


<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Add Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
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
                    <label>Item</label>
                    <select class="form-control select2 tab" onchange="getItemDetail(this.value);" name="item" id="item"
                        required>
                        <option value="" disabled selected>Select Item
                        </option>
                        @if (isset($items))
                            @foreach ($items as $item)
                                <option value="{{ "$item->item_id" }}">
                                    {{ "$item->item_short_description" }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label for="example-text-input" class="col-form-label">Task Price</label>
                    <input type="text" class="form-control" readonly name="itemPrice" id="itemPrice" required
                        placeholder="0.00" />

                </div>
                <div class="form-group">
                    <label for="example-text-input" class="col-form-label">Qty</label>
                    <input type="text" class="form-control" name="qty" id="qty" required placeholder="0" />

                </div>
                <button type="button" class="btn btn-md btn-primary waves-effect" onclick="addItem()">
                    Add Item
                </button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Add Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissible " id="errorAlertTask" style="display:none">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Tasks</label>
                    <select class="form-control select2 tab" onchange="getTaskDetail(this.value);" name="task" id="task"
                        required>
                        <option value="" disabled selected>Select Tasks
                        </option>
                        @if (isset($tasks))
                            @foreach ($tasks as $task)
                                <option value="{{ "$task->task_id" }}">
                                    {{ "$task->task_short_description" }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label for="example-text-input" class="col-form-label">Task Price</label>
                    <input type="text" class="form-control" readonly name="taskPrice" id="taskPrice" required
                        placeholder="0.00" />

                </div>
                <div class="form-group">
                    <label for="example-text-input" class="col-form-label">Task Duration</label>
                    <input type="text" class="form-control" readonly name="taskDuration" id="taskDuration" required
                        placeholder="1 Hr" />

                </div>
                <button type="button" class="btn btn-md btn-primary waves-effect" onclick="addTask()">
                    Add Task
                </button>
            </div>
        </div>
    </div>
</div>
</div>


<div class="modal fade" id="viewTaskModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">View Task</h5>
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
                    <label>Tasks</label>
                    <select class="form-control select2 tab" disabled name="vTask" id="vTask" required>
                        <option value="" disabled selected>Select Tasks
                        </option>
                        @if (isset($tasks))
                            @foreach ($tasks as $task)
                                <option value="{{ "$task->task_id" }}">
                                    {{ "$task->task_short_description" }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label for="example-text-input" class="col-form-label">Task Price</label>
                    <input type="text" class="form-control" readonly name="vTaskPrice" id="vTaskPrice" required
                        placeholder="0.00" />

                </div>
                <div class="form-group">
                    <label for="example-text-input" class="col-form-label">Task Duration</label>
                    <input type="text" class="form-control" readonly name="vTaskDuration" id="vTaskDuration" required
                        placeholder="1 Hr" />

                </div>

            </div>
        </div>
    </div>
</div>
</div>



<div class="modal fade" id="viewItemModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">View Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body">


                <div class="form-group">
                    <label>Item</label>
                    <select class="form-control select2 tab" disabled name="vItem" id="vItem" required>
                        <option value="" disabled selected>Select Item
                        </option>
                        @if (isset($items))
                            @foreach ($items as $item)
                                <option value="{{ "$item->item_id" }}">
                                    {{ "$item->item_short_description" }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label for="example-text-input" class="col-form-label">Task Price</label>
                    <input type="text" class="form-control" readonly name="vItemPrice" id="vItemPrice" required
                        placeholder="0.00" />

                </div>
                <div class="form-group">
                    <label for="example-text-input" class="col-form-label">Qty</label>
                    <input type="text" class="form-control" readonly name="vQty" id="vQty" required placeholder="0" />

                </div>

            </div>
        </div>
        <input type="hidden" id="orderID" name="orderID" />
        <input type="hidden" id="jobStartTime" name="Time" />


    </div>
</div>
@include('includes/footer_start')

<!-- Plugins js -->
<script src="{{ URL::asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"
    type="text/javascript">
</script>
<script src="{{ URL::asset('assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}"
    type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js') }}"
    type="text/javascript"></script>

<!-- Plugins Init js -->
<script src="{{ URL::asset('assets/pages/form-advanced.js') }}"></script>

<!-- Required datatable js -->
<script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Buttons examples -->
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.colVis.min.js') }}"></script>
<!-- Responsive examples -->
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>

<script src="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('assets/pages/sweet-alert.init.js') }}"></script>

<!-- Datatable init js -->
<script src="{{ URL::asset('assets/pages/datatables.init.js') }}"></script>

<!-- Parsley js -->
<script type="text/javascript" src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/bootstrap-notify.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery.notify.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('form').parsley();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        deleteData();


    });




    $(document).on("wheel", "input[type=number]", function(e) {
        $(this).blur();
    });

    function deleteData() {

        $.post('deleteJobData', {}, function(data) {

            if (data) {
                $("#taskTable").html(data.tableData2);
                $("#itemTable").html(data.tableData);

                if (data.totalService != 0 || data.total != 0) {
                    $(".saveBtn").show();
                    $("#endTimeBtn").hide();
                } else {
                    $(".saveBtn").hide();
                    $("#endTimeBtn").hide();
                }

                if (data.totalService != null) {

                    if (data.orderID) {
                        $("#end").val(data.result);
                        $("#duration").val(data.endTime);
                    }

                    $("#cost").val(data.total + data.totalService);
                }
            }
        })
    }


    function tableData(totalCost) {
      
        var orderID = $("#orderID").val();

        $.post('viewJobTableData', {
            orderID: orderID
        }, function(data) {
            console.log(data)
            $("#taskTable").html(data.tableData2);
            $("#itemTable").html(data.tableData);

            if (data.totalService != 0 || data.total != 0) {
                $(".saveBtn").show();
                $("#endTimeBtn").hide();
            } else {
                $(".saveBtn").hide();
                $("#endTimeBtn").hide();
            }

            if (data.totalService != null) {

                if (data.orderID) {
                    $("#end").val(data.result);
                    $("#duration").val(data.endTime);
                }

                if(totalCost!=null){
                    $("#cost").val(totalCost);
                }else{
                    $("#cost").val(data.total + data.totalService);
                }
                
                //    $("#cost").val('5800'); 
            }
        })
    }

    function getOrderDetail(orderID) {
        $.post('loadTempData', {
            orderID: orderID
        }, function(data) {
         
            $("#orderID").val(data.orderDetail.order_id);
            $("#customer").val(data.orderDetail.order_customer_id).trigger('change');
            $("#vehicle").val(data.vehicleNo.vehicle_registration_number);
            $("#mobile").val(data.mobileNo);
            $("#start").val(data.orderDetail.order_estimated_start_time);
            $("#end").val(data.orderDetail.order_estimated_end_time);
            $("#duration").val(data.orderDetail.order_estimated_duration);
            $("#cost").val(data.total);
            $("#Jobate").val(data.orderDetail.order_date);
            if(data.refundAmount!=null){
                $("#refundArea").show();
                $("#refundAmount").val(data.refundAmount)
            }else{
                $("#refundArea").hide();
            }
            tableData(data.total);
        })
    }



    function getTaskDetail(taskID) {


        $.post('getTaskByID', {
            taskID: taskID
        }, function(data) {

            $("#taskPrice").val(data.task_price);
            $("#taskDuration").val(data.task_estimated_duration);
        })
    }

    function getItemDetail(itemID) {

        $.post('getItemByID', {
            itemID: itemID
        }, function(data) {
            $("#itemPrice").val(data.item_unit_price);

        })
    }

    $('.modal').on('hidden.bs.modal', function() { //bootstrap.min.css or bootstrap.css
        $('#errorAlert').hide(); //hide the error
        $('#errorAlert').html(''); //delete the text in the error

        $('#errorAlert1').hide();
        $('#errorAlert1').html('');
        $('#taskPrice').val('');
        $('#taskDuration').val('');

        $("#errorAlertTask").hide();
        $("#errorAlertTask").html('');
        $('#itemPrice').val('');
        $('#qty').val('');
    });

    function addTask() {

        $("#errorAlertTask").hide();
        $("#errorAlertTask").html('');
        var task = $("#task").val();

        $.post('addJobTask', {
            task: task
        }, function(data) {

            if (data.errors != null) {
                $('#errorAlertTask').show();
                $.each(data.errors, function(key, value) {
                    $('#errorAlertTask').append('<p>' + value + '</p>');
                });
            }
            if (data.success != null) {
                notify({
                    type: "success", //alert | success | error | warning | info
                    title: 'TASK SAVED',
                    autoHide: true, //true | false
                    delay: 2500, //number ms
                    position: {
                        x: "right",
                        y: "top"
                    },
                    icon: '<img src="{{ URL::asset('assets/images/correct.png') }}" />',

                    message: data.success,
                });

                $("#task").val('').trigger('change');
                setTimeout(function() {
                    $('#addTaskModal').modal('hide');
                }, 200);
                tableData();
            }
        })

    }


    function addItem() {


        $("#errorAlert1").hide();
        $("#errorAlert1").html('');

        var item = $("#item").val();
        var qty = $("#qty").val();

        $.post('addJobItem', {
            item: item,
            qty: qty
        }, function(data) {

            if (data.errors != null) {
                $('#errorAlert1').show();
                $.each(data.errors, function(key, value) {
                    $('#errorAlert1').append('<p>' + value + '</p>');
                });
            }
            if (data.success != null) {
                notify({
                    type: "success", //alert | success | error | warning | info
                    title: 'ITEM SAVED',
                    autoHide: true, //true | false
                    delay: 2500, //number ms
                    position: {
                        x: "right",
                        y: "top"
                    },
                    icon: '<img src="{{ URL::asset('assets/images/correct.png') }}" />',

                    message: data.success,
                });

                $("#item").val('').trigger('change');
                setTimeout(function() {
                    $('#addItemModal').modal('hide');
                }, 200);
                tableData();
            }
        })

    }




    function deleteTask(taskID) {


        swal({
            title: 'Do you really want to delete this task?',
            //type: 'warning',
            dangerMode: true,
            buttons: true,
            showCancelButton: true,
            confirmButtonText: 'YES',
            cancelButtonText: 'NO',
            confirmButtonClass: 'btn btn-md btn-danger waves-effect',
            cancelButtonClass: 'btn btn-md btn-primary waves-effect',
            buttonsStyling: false
        }).then(function() {
            $.post('deleteJobTask', {
                taskID: taskID
            }, function(data) {

                if (data.success != null) {
                    notify({
                        type: "success", //alert | success | error | warning | info
                        title: 'TASK DELETED',
                        autoHide: true, //true | false
                        delay: 2500, //number ms
                        position: {
                            x: "right",
                            y: "top"
                        },
                        icon: '<img src="{{ URL::asset('assets/images/correct.png') }}" />',

                        message: data.success,
                    });
                    tableData();
                }
            })

        })
    }


    function deleteItem(itemID) {


        swal({
            title: 'Do you really want to delete this item?',
            //type: 'warning',
            dangerMode: true,
            buttons: true,
            showCancelButton: true,
            confirmButtonText: 'YES',
            cancelButtonText: 'NO',
            confirmButtonClass: 'btn btn-md btn-danger waves-effect',
            cancelButtonClass: 'btn btn-md btn-primary waves-effect',
            buttonsStyling: false
        }).then(function() {
            $.post('deleteJobOrderItem', {
                itemID: itemID
            }, function(data) {

                if (data.success != null) {
                    notify({
                        type: "success", //alert | success | error | warning | info
                        title: 'ITEM DELETED',
                        autoHide: true, //true | false
                        delay: 2500, //number ms
                        position: {
                            x: "right",
                            y: "top"
                        },
                        icon: '<img src="{{ URL::asset('assets/images/correct.png ') }}" />',

                        message: data.success,
                    });
                    tableData();
                }
            })

        })
    }



    $(document).on('click', '#viewTask', function() {
        var taskId = $(this).data("id");


        $.post('viewJobTaskById', {
            taskId: taskId
        }, function(data) {

            $("#vTask").val(data.job_task_task_id).trigger('change');
            $("#vTaskPrice").val(data.job_task_temp_price);
            $("#vTaskDuration").val(data.job_task_temp_duration);
        });
    });


    $(document).on('click', '#viewItem', function() {
        var itemId = $(this).data("id");


        $.post('viewJobItemById', {
            itemId: itemId
        }, function(data) {

            $("#vItem").val(data.job_item_item_id).trigger('change');
            $("#vItemPrice").val(data.job_item_temp_price);
            $("#vQty").val(data.job_item_temp_quantity);
        });
    });


    function jobStart() {

        var today = new Date();
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();

        $("#jobStartTime").val(time);
        $("#endTimeBtn").show();

    }


    function jobEnd() {

        $("#waitButton").show();
        $("#endTimeBtn").hide();
        $("#startBtn").hide();

        var jobStartTime = $("#jobStartTime").val();
        var today = new Date();
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        var jobEndTime = time;
        var orderID = $("#orderID").val();
        var end = $("#end").val();
        var duration = $("#duration").val();

        $.post('savejob', {
            jobStartTime: jobStartTime,
            jobEndTime: jobEndTime,
            orderID: orderID,
            end: end,
            duration: duration
        }, function(data) {
            if (data.success != null) {

                $("#waitButton").show();
                $("#endTimeBtn").hide();
                $("#startBtn").hide();
                
                notify({
                    type: "success", //alert | success | error | warning | info
                    title: 'JOB COMPLETED',
                    autoHide: true, //true | false
                    delay: 2500, //number ms
                    position: {
                        x: "right",
                        y: "top"
                    },
                    icon: '<img src="{{ URL::asset('assets/images/correct.png ') }}" />',

                    message: data.success,
                });
              location.reload();
                
            }
        })
    }

</script>
@include('includes/footer_end')
