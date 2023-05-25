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
                                            data-target="#addTaskModal">
                                            Add Task
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
                                            <th>Task</th>
                                            <th>Description</th>
                                            <th>Duration</th>
                                            <th>Cost</th>
                                            <th>Price</th>
                                            <th>Active</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                    
                                        @if(isset($taskView))
                                        @if(count($taskView) > 0)
                                        @foreach($taskView as $task)
                                            <tr>
                                                <td>{{$task->task_short_description}}</td>
                                                <td>{{$task->task_long_description}}</td>
                                                <td>{{$task->task_estimated_duration}}</td> {{-- how to get category name ?????--}}
                                                <td>{{number_format($task->task_cost,2)}}</td>
                                                <td>{{number_format($task->task_price,2)}}</td>
                                                {{-- <td text-align: right>{{number_format($item->item_unit_price,2)}}</td> --}}
    
                                                @if($task->task_status == 1)
    
                                                    <td >
                                                        <p>
                                                            <input type="checkbox" class="status"
                                                                   onchange="changeStatus('{{ $task->task_id}}','task')"
                                                                   id="{{"c".$task->task_id}}" checked
                                                                   switch="none"/>
                                                            <label for="{{"c".$task->task_id}}"
                                                                   data-on-label="Yes"
                                                                   data-off-label="No"></label>
                                                        </p>
                                                    </td>
                                                @else
                                                    <td >
                                                        <p>
                                                            <input type="checkbox" class="status"
                                                                   onchange="changeStatus('{{ $task->task_id}}','task')"
                                                                   id="{{"c".$task->task_id}}"
                                                                   switch="none"/>
                                                            <label for="{{"c".$task->task_id}}"
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
                                                                data-id="{{ $task->task_id}}"
                                                                data-name="{{ $task->task_id}}"
                                                                id="viewTask"
                                                                data-target="#viewTaskModal">
                                                                <i class="fa fa-eye"></i>                                            
                                                        </button>
                                                        <button type="button" title="Edit"
                                                                class="btn btn-sm btn-basic  waves-effect waves-light"
                                                                data-toggle="modal"
                                                                data-id="{{ $task->task_id}}"
                                                                data-name="{{ $task->task_id}}"
                                                                id="updateTask"
                                                                data-target="#updateTaskModal">
                                                                <i class="fa fa-edit"></i>
                                                        </button>
                                                        <button type="button" title="Delete"
                                                                class="btn btn-sm btn-basic  waves-effect waves-light" 
                                                                onclick="deleteTask({{$task->task_id}})">                                                        
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

    <!--add Task modal-->
<div    class="modal fade" 
        id="addTaskModal"
        role="dialog"
        aria-labelledby="mySmallModalLabel" 
        aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Add Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>                                       
                    <div class="modal-body">
                        
                        <div class="form-group bg-light">
                            <div class="form-group row">
                                <label for="saveTaskName" class="col-sm-4 col-form-label">Task Name</label>
                                <div class="col-sm-8">
                                    <input  type="text" 
                                    class="form-control" 
                                    name="saveTaskName"
                                    id="saveTaskName" 
                                    placeholder="Task ID/Name"/>
                                    <span class="text-danger" id="saveTaskNameError"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="saveTaskDesc" class="col-sm-4 col-form-label">Description</label>
                                <div class="col-sm-8">
                                    <input  type="text" 
                                    class="form-control" 
                                    name="saveTaskDesc"
                                    id="saveTaskDesc" 
                                    placeholder="Description"/>
                                    <span class="text-danger" id="saveTaskDescError"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="saveTaskDuration" class="col-sm-4 col-form-label">Duration (Hrs)</label>
                                <div class="col-sm-8">
                                    <input  type="text" 
                                    class="form-control" 
                                    name="saveTaskDuration"
                                    id="saveTaskDuration" 
                                    placeholder="Duration in hours"/>
                                    <span class="text-danger" id="saveTaskDurationError"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="saveTaskCost" class="col-sm-4 col-form-label">Estimated Cost (LKR)</label>
                                <div class="col-sm-8">
                                    <input  type="text" 
                                    class="form-control" 
                                    name="saveTaskCost"
                                    id="saveTaskCost" 
                                    placeholder="Cost per duration"/>
                                    <span class="text-danger" id="saveTaskCostError"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="saveTaskPrice" class="col-sm-4 col-form-label">Estimated Price (LKR)</label>
                                <div class="col-sm-8">
                                    <input  type="text" 
                                    class="form-control" 
                                    name="saveTaskPrice"
                                    id="saveTaskPrice" 
                                    placeholder="Price per duration"/>
                                    <span class="text-danger" id="saveTaskPriceError"></span>
                                </div>
                            </div>             
                            <div class="row">
                                <div class="col-lg-4" style="padding-top: 14px">
                                    <button type="button" class="btn btn-md btn-outline-primary waves-effect"  onclick="saveTask()">Save Task</button>
                                </div>
                            </div>
                        </div>
                    </div>
            
        </div>
    </div>
</div>
<!--View Item modal-->
<div class="modal fade" id="viewTaskModal" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Task Details</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-group row">
                        <label for="viewTaskName" class="col-sm-4 col-form-label">Task Name</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewTaskName" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewTaskDesc" class="col-sm-4 col-form-label">Description</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewTaskDesc" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewTaskDuration" class="col-sm-4 col-form-label">Duration (hrs.)</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewTaskDuration" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewTaskCost" class="col-sm-4 col-form-label">Estimated Cost (LKR)</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewTaskCost" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewTaskPrice" class="col-sm-4 col-form-label">Estimated Price (LKR)</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewTaskPrice" readonly>
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

<!--Update Task modal-->
<div class="modal fade" id="updateTaskModal" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Edit Task</h5>
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
                        <label for="updateTaskName" class="col-sm-4 col-form-label">Task Name</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="updateTaskName" id="updateTaskName">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="updateTaskDesc" class="col-sm-4 col-form-label">Description</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="updateTaskDesc" id="updateTaskDesc"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="updateTaskDuration" class="col-sm-4 col-form-label">Estimated Duration</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="updateTaskDuration" id="updateTaskDuration"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="updateTaskCost" class="col-sm-4 col-form-label">Estimated Cost (LKR)</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="updateTaskCost" id="updateTaskCost"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="updateTaskPrice" class="col-sm-4 col-form-label">Estimated Price (LKR)</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="updateTaskPrice" id="updateTaskPrice"/>
                        </div>
                    </div>

                <button type="submit" class="btn btn-md btn-outline-primary waves-effect" onclick="updateTask()"> Update Item</button>
            </div>
            <input type="hidden" id="hiddenTaskId">
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
            $('#saveTaskNameError').html("");
            $("#saveTaskDescError").html("");
            $('#saveTaskDurationError').html("");
            $('#saveTaskCostError').html("");
            $('#saveTaskPriceError').html("");

            $('#errorAlert').hide();
            $('#errorAlert').html('');

            $('input').val('');


        });

    function changeStatus(dataID, tableName) {
        
        $.post('activateDeactivate', {id: dataID, table: tableName}, function (data) {
           
        });
    }
    
    function saveTask() {
        
        $('#saveTaskNameError').html("");
        $("#saveTaskDescError").html("");
        $('#saveTaskDurationError').html("");
        $('#saveTaskCostError').html("");
        $('#saveTaskPriceError').html("");
        
        var taskName = $("#saveTaskName").val();
        var taskDesc = $("#saveTaskDesc").val();
        var taskDuration = $("#saveTaskDuration").val();
        var taskCost = $("#saveTaskCost").val();
        var taskPrice = $("#saveTaskPrice").val();
        
$.post('saveTask', {
    taskName:taskName,
    taskDesc:taskDesc,
    taskDuration:taskDuration,
    taskCost:taskCost,
    taskPrice:taskPrice,
     
    }, function (data) {
    
    if (data.errors != null) {

        if(data.errors.error){
            var p = document.getElementById('saveTaskNameError');
                p.innerHTML = data.errors.error; //this is a custom
        }

        if(data.errors.taskName){
            var p = document.getElementById('saveTaskNameError');
            p.innerHTML = data.errors.taskName;
        }

        if(data.errors.taskDesc){
            var p = document.getElementById('saveTaskDescError');
            p.innerHTML = data.errors.taskDesc;
        }

        if(data.errors.taskDuration){
            var p = document.getElementById('saveTaskDurationError');
            p.innerHTML = data.errors.taskDuration;
        }

        if(data.errors.taskCost){
            var p = document.getElementById('saveTaskCostError');
            p.innerHTML = data.errors.taskCost;
        }

        if(data.errors.taskPrice){
            var p = document.getElementById('saveTaskPriceError');
            p.innerHTML = data.errors.taskPrice;
        }

    }
    if (data.success != null) {
        $(".select2").val('').trigger('change');
        notify({
            type: "success",
            title: 'TASK SAVED SUCCESSFULLY',
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
            $('#addTaskModal').modal('hide');
        }, 200);
       location.reload();
    }
});
}

function updateTask() {
                $('#errorAlert').hide();
                $('#errorAlert').html("");
                var updateTaskName = $("#updateTaskName").val();
                var updateTaskDesc = $("#updateTaskDesc").val();
                var updateTaskDuration = $("#updateTaskDuration").val();
                var updateTaskCost = $("#updateTaskCost").val();
                var updateTaskPrice = $("#updateTaskPrice").val();
                var hiddenTaskId = $("#hiddenTaskId").val();
                                
                $.post('updateTask',
                
                {
                    updateTaskName:updateTaskName,
                    updateTaskDesc:updateTaskDesc,
                    updateTaskDuration:updateTaskDuration,
                    updateTaskCost:updateTaskCost,
                    updateTaskPrice:updateTaskPrice,
                    hiddenTaskId:hiddenTaskId,


                },  function (data) {

                    if (data.errors != null) {
                        console.log(data);
                        $('#errorAlert').show();
                        $.each(data.errors, function (key, value) {
                             $('#errorAlert').append('<p>' + value + '</p>');
                         });
                    }
                    if (data.success != null) {
                        notify({
                            type: "success", 
                            title: 'TASK UPDATED SUCESSFULLY',
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

 
 //view Task details
 $(document).on('click', '#viewTask', function () {
                var taskId = $(this).data("id");

                $.post('viewTask', {taskId: taskId}, 
                function (data) {
                    
                    $("#viewTaskName").val(data.getTaskDetail.task_short_description);
                    $("#viewTaskDesc").val(data.getTaskDetail.task_long_description);
                    $("#viewTaskDuration").val(data.getTaskDetail.task_estimated_duration);
                    $("#viewTaskCost").val(data.getTaskDetail.task_cost);
                    $("#viewTaskPrice").val(data.getTaskDetail.task_price);
                });
            });


function deleteTask(taskID){ //defined varible in ajax is categoryId
    //console.log(taskID);
            swal({
        title: 'Do you really want to delete this Task?',
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

            //console.log(taskID);
            $.post('deleteMasterTask',{
                taskID:taskID,
                
            },function (data){
                //console.log(data);
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
  

//update Task details
        $(document).on('click', '#updateTask', function () {
        var taskId = $(this).data("id");
            $.post('getByTaskId', {
                taskId: taskId
            }, function (data)
                          
            {

                console.log(data);  
                $("#hiddenTaskId").val(data.task_id);
                $("#updateTaskName").val(data.task_short_description);
                $("#updateTaskDesc").val(data.task_long_description);
                $("#updateTaskDuration").val(data.task_estimated_duration);
                $("#updateTaskCost").val(data.task_cost);                  
                $("#updateTaskPrice").val(data.task_price);

        });
    });

        $(document).ready(function(){
            $( document ).on( 'focus', ':input', function(){
                $( this ).attr( 'autocomplete', 'off' );
            });
        });

</script>
@include('includes/footer_end')