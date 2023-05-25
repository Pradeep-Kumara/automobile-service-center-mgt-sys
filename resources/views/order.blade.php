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
    </li>
    <li class="hide-phone list-inline-item app-search">
        <h3 class="page-title">Service Booking</h3>
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
                        <label for="date" class="col-sm-4 col-form-label">Date</label>
                        <div class="col-sm-8">
                            <input type="text" autocomplete="off" class="form-control datepicker-autoclose" placeholder="dd/mm/yy"
                                id="date">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="customer" class="col-sm-4 col-form-label">Customer</label>
                        <div class="col-sm-8">
                            <select class="form-control select2 tab" onchange="getCusDetail(this.value)" name="customer"
                                id="customer" required>
                                <option value="" disabled selected>Select Customer
                                </option>
                                @if (\Illuminate\Support\Facades\Auth::user()->user_role_id == 1)

                                    @foreach ($customers as $customer)
                                        @if (\Illuminate\Support\Facades\Auth::user()->user_id == $customer->customer_user_id)
                                            <option value="{{ "$customer->customer_id" }}">
                                                {{ "$customer->customer_firstname" }}
                                                {{ "$customer->customer_lastname" }}
                                            </option>
                                        @endif
                                    @endforeach
                                @else
                                    @foreach ($customers as $customer)
                                        <option value="{{ "$customer->customer_id" }}">
                                            {{ "$customer->customer_firstname" }}
                                            {{ "$customer->customer_lastname" }}
                                        </option>
                                    @endforeach
                                @endif

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="vehicle" class="col-sm-4 col-form-label">Vehicle</label>
                        <div class="col-sm-8">
                            <select class="form-control select2 tab" name="vehicle" id="vehicle" required>
                                <option value="" disabled selected>Select Vehicle
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="mobile" class="col-sm-4 col-form-label">Mobile</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" readonly id="mobile">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label>Start Time</label>
                            <input type="time" class="form-control" id="start">
                        </div>
                        <div class="col-sm-6">
                            <label>End End</label>
                            <input type="time" class="form-control" id="end">
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
                    <div class="form-group row">
                        <div class="col-sm-6">Require Refund</div>
                        <div class="col-sm-6">
                            <div class="form-check ">
                                <input class="form-check-input" type="checkbox" value="1" id="requireRefund" onClick="displayRefundValue();">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">Refund Charge</div>
                        <div class="col-sm-6">
                            <div class="form-check ">
                                <input class="form-control" type="text" id="requireRefundAmount" readonly style="display: none">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="button" class="btn btn-primary" id="paymentBtn"
                                onclick="saveBooking()">Process to Payment</button>
                            <button type="button" class="btn btn-primary" id="waitButton" style="display: none">
                                <i class="fa fa-circle-o-notch fa-spin"></i> Plsease Wait</button>
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
                        <div class="alert alert-danger alert-dismissible " id="errorAlert" style="display:none">
                            <button type="button" class="fa fa-eye" data-dismiss="alert" aria-label="Close">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('form').parsley();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        tableData();
        // document.getElementById('date').valueAsDate = new Date();

        $('#datepicker-autoclose').datepicker('setDate', 'today');
        var date = new Date();
        date.setDate(date.getDate());
        jQuery('.datepicker-autoclose').datepicker({
            autoclose: true,
            todayHighlight: true,
            startDate: date
        });
    });

    $(document).on("wheel", "input[type=number]", function(e) {
        $(this).blur();
    });

    function tableData() {
        $.post('viewTableData', {

        }, function(data) {

            $("#taskTable").html(data.tableData2);
            $("#itemTable").html(data.tableData);

            if (data.totalService != 0 || data.total != 0) {
                $("#saveBtn").show();
            } else {
                $("#saveBtn").hide();
            }

            if (data.totalService != null) {

                if (data.startTime != null) {

                    $("#start").val(data.startTime.schedule_endtime)
                } else {
                    $("#start").val('08:30')
                }
                $("#end").val(data.result);
                $("#duration").val(data.endTime);

                $("#cost").val(data.total + data.totalService);
                //    $("#cost").val('9500.00'); //remove this and correct it
            }

        })
    }

    function getCusDetail() {
        var CusID = $("#customer").val();
        if (CusID) {
            $.post('getCusDetail', {
                CusID: CusID
            }, function(data) {
                console.log(data)
                if (data.options) {
                    $("#vehicle").html(data.options);
                }

                if (data.getCustomerDetail.customer_mobile) {
                    $("#mobile").val(data.getCustomerDetail.customer_mobile);
                }

            })
        }
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

    //function getStartTime() {

        // var date = $("#date").val();
      
        // $.post('getFutureDateStartTime', {
        //     date: date
        // }, function(data) {
        //         console.log(data)
        // })
    //}


  

    $('.modal').on('hidden.bs.modal', function() { 
        $('#errorAlert').hide(); 
        $('#errorAlert').html(''); 

        $('#errorAlert1').hide();
        $('#errorAlert1').html('');
        $('#taskPrice').val('');
        $('#taskDuration').val('');

        $('#itemPrice').val('');
        $('#qty').val('');
        $(".select2").val('').trigger('change');
    });

    function addTask() {

        $("#errorAlert").hide();
        $("#errorAlert").html('');
        $("#errorAlert2").hide();
        $("#errorAlert2").html('');


        var task = $("#task").val();

        $.post('addTask', {
            task: task
        }, function(data) {

            if (data.errors != null) {
                $('#errorAlert').show();
                $.each(data.errors, function(key, value) {
                    $('#errorAlert').append('<p>' + value + '</p>');
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

                $(".select2").val('').trigger('change');
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
        $("#errorAlert2").hide();
        $("#errorAlert2").html('');


        var item = $("#item").val();
        var qty = $("#qty").val();

        $.post('addItem', {
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

                $(".select2").val('').trigger('change');
                setTimeout(function() {
                    $('#addItemModal').modal('hide');
                }, 200);
                tableData();
            }
        })

    }




    function deleteTask(taskID) {

        $("#errorAlert2").hide();
        $("#errorAlert2").html('');

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
            $.post('deleteTask', {
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
        $("#errorAlert2").hide();
        $("#errorAlert2").html('');


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
            $.post('deleteOrderItem', {
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

        $.post('viewTaskById', {
            taskId: taskId
        }, function(data) {

            $("#vTask").val(data.order_task_temp_task_id).trigger('change');
            $("#vTaskPrice").val(data.order_task_temp_price);
            $("#vTaskDuration").val(data.order_task_temp_duration);
        });
    });


    $(document).on('click', '#viewItem', function() {
        var itemId = $(this).data("id");

        $.post('viewItemById', {
            itemId: itemId
        }, function(data) {

            $("#vItem").val(data.order_item_temp_item_id).trigger('change');
            $("#vItemPrice").val(data.order_item_temp_price);
            $("#vQty").val(data.order_item_temp_quantity);
        });
    });




function displayRefundValue(){

    var requireRefund = $('#requireRefund:checked').val();
        if (requireRefund != 1) {
            var requireRefund = 0;
        } else {
            var requireRefund = $('#requireRefund:checked').val();
        }

        if (requireRefund== 0){
            $('#requireRefundAmount').hide();
            
        }else{
            $('#requireRefundAmount').show();

            $.post('requireRefundAmount',{

            }, function(data){
                $('#requireRefundAmount').val(data.refund_amount);
            });

        }
   
}
    

    function saveBooking() {

        $("#errorAlert2").hide();
        $("#errorAlert2").html('');

        $("#paymentBtn").hide();
        $("#waitButton").show();

        var customer = $("#customer").val();
        var vehicle = $("#vehicle").val();

        var requireRefund = $('#requireRefund:checked').val();
        if (requireRefund != 1) {
            var requireRefund = 0;
        } else {
            var requireRefund = $('#requireRefund:checked').val();
        }


        $.post('saveBooking', {
            customer: customer,
            vehicle: vehicle,
            requireRefund: requireRefund
        }, function(data) {
            if (data.errors != null) {
                $("#paymentBtn").show();
                $("#waitButton").hide();
                $('#errorAlert2').show();
                $.each(data.errors, function(key, value) {
                    $('#errorAlert2').append('<p>' + value + '</p>');
                });
            }
            if (data.success != null) {
                notify({
                    type: "success", //alert | success | error | warning | info
                    title: 'Your booking has been saved',
                    autoHide: true, //true | false
                    delay: 2500, //number ms
                    position: {
                        x: "right",
                        y: "top"
                    },
                    icon: '<img src="{{ URL::asset('assets/images/correct.png') }}" />',

                    message: data.success,
                });
                // setTimeout(function() {
                //     location.reload();
                // }, 500);
                $("#paymentBtn").hide();
                $("#waitButton").show();
                window.location.href = "payment";

            }
        })
    }

</script>
@include('includes/footer_end')
