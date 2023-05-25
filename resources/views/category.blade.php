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
        <div class="col-lg-12">
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="row">   
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-primary waves-effect float-right"
                                    data-toggle="modal"  data-target="#addCategoryModal" >
                                Add Category</button>
                        </div>
                    </div>


                    <div class="table-rep-plugin">
                        <div class="table-responsive b-0" data-pattern="priority-columns">
                            <table  class="table table-striped table-bordered"
                                    cellspacing="0"
                                    width="100%">
                                <thead>
                                <tr>
                                    <th>Category ID</th>
                                    <th>Category Name</th>
                                    <th>Category Desc</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($categories))
                                    @if(count($categories)==0)
                                        <tr>
                                            <td colspan="6" style="text-align: center;font-weight: bold  ">Sorry, No Results Found.
                                            </td>
                                        </tr>
                                    @endif
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>{{$category->category_id}}</td>
                                            <td>{{$category->category_short_description}}</td>
                                            <td>{{$category->category_long_description}}</td>
                                                                                        
                                                @if($category->category_status == 1)

                                                    <td>
                                                        <p>
                                                            <input type="checkbox"
                                                                   onchange="changeStatus('{{ $category->category_id}}','category')"
                                                                   id="{{"c".$category->category_id}}" checked
                                                                   switch="none"/>
                                                            <label for="{{"c".$category->category_id}}"
                                                                   data-on-label="On"
                                                                   data-off-label="Off"></label>
                                                        </p>
                                                    </td>
                                                @else
                                                    <td>
                                                        <p>
                                                            <input type="checkbox"
                                                                   onchange="changeStatus('{{ $category->category_id}}','category')"
                                                                   id="{{"c".$category->category_id}}"
                                                                   switch="none"/>
                                                            <label for="{{"c".$category->category_id}}"
                                                                   data-on-label="On"
                                                                   data-off-label="Off"></label>
                                                        </p>
                                                    </td>
                                            @endif
                                            <td>

                                                    <p>
                                                        <button type="button" title="View"
                                                                class="btn btn-sm btn-basic  waves-effect waves-light"
                                                                data-toggle="modal"                                                                
                                                                data-id="{{ $category->category_id}}"
                                                                data-name="{{ $category->category_id}}"
                                                                id="viewCategory"
                                                                data-target="#viewCategoryModal">
                                                                <i class="fa fa-eye"></i>                                            
                                                        </button>
                                                        <button type="button"
                                                                class="btn btn-sm btn-basic  waves-effect waves-light"
                                                                data-toggle="modal"
                                                                data-id="{{ $category->category_id}}"
                                                                id="updateCategoryID" 
                                                                data-target="#updateCategoryModal">
                                                                <i class="fa fa-edit"></i>
                                                        </button>
                                                        <button type="button" 
                                                                class="btn btn-sm btn-basic  waves-effect waves-light" 
                                                                onclick="deleteCategory({{$category->category_id}})">                                                        
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

<!--Add category modal-->
<div class="modal fade" id="addCategoryModal" tabindex="-1"
     role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Add Category</h5>
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
                            <label for="example-text-input" class="col-form-label">Category<span style="color: red"> *</span></label>

                            <input type="text" class="form-control" name="category" id="category" required placeholder="Ex: Lubricant"/>
                            <small class="text-danger">{{ $errors->first('category')}}</small>
                    </div>
                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label">Category Description</label>

                        <input type="text" class="form-control" name="categoryDescription" id="categoryDescription" required placeholder="Description of Lubricant"/>
                        <small class="text-danger">{{ $errors->first('category')}}</small>
                    </div>
                <button type="button" class="btn btn-md btn-outline-primary waves-effect" onclick="saveCategory()">
                    Save Category
                </button>
                </div>
            </div>
        </div>
    </div>
</div>


<!--Update category modal-->
<div class="modal fade" id="updateCategoryModal" tabindex="-1"
     role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Edit Category</h5>
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
                    <label for="example-text-input" class="col-form-label">Category Description</label>
                    <input type="text" class="form-control" name="updateCategoryDescription" id="updateCategoryDescription"/>
                    
                </div>
                <button type="submit" class="btn btn-md btn-outline-primary waves-effect" onclick="updateCategory()"> Update Category</button>
            </div>
            <input type="hidden" id="hiddenCategoryId">
        </div>
    </div>
</div>
</div>


<!--View category modal-->
<div class="modal fade" id="viewCategoryModal" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Category Details</h5>
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
                        <label for="viewCategoryId" class="col-sm-4 col-form-label">Category ID</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewCategoryId" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewCategoryName" class="col-sm-4 col-form-label">Category Name</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewCategoryName" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="viewCategoryDesc" class="col-sm-4 col-form-label">Category Description</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="viewCategoryDesc" readonly>
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


        $('#errorAlert').hide(); 
        $('#errorAlert').html(''); 

        $('#errorAlert1').hide();
        $('#errorAlert1').html('');
        $('input').val('');

    });

    function changeStatus(dataID, tableName) {

        $.post('activateDeactivate', {id: dataID, table: tableName}, function (data) {

        });
    }

    function saveCategory() {
        

         $('#errorAlert').hide();
         $('#errorAlert').html("");

         var category = $("#category").val(); 
         var categoryDescription = $("#categoryDescription").val();
         
        
        $.post('saveCategory',{
            category:category,  
            categoryDescription:categoryDescription
            },function (data) { 

    
           if (data.errors != null) {
                $('#errorAlert').show();
                $.each(data.errors, function (key, value) {
                    $('#errorAlert').append('<p>' + value + '</p>');
                });
            }
            if (data.success != null) {
                notify({
                    type: "success", //alert | success | error | warning | info
                    title: 'CATEGORY SAVED',
                    autoHide: true, //true | false
                    delay: 2500, //number ms
                    position: {
                        x: "right",
                        y: "top"
                    },
                    icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',

                    message: data.success,
                });
                $('input').val(''); 
                setTimeout(function () {
                    $('#addCategoryModal').modal('hide');
                }, 200);
                location.reload(); 
            }
           
            
        });

    }

    //view category details
    $(document).on('click', '#viewCategory', function () {
        var categoryId = $(this).data("id");

        $.post('viewCategory', {
            categoryId: categoryId
        }, 
        function (data) {

            //console.log(data);
            $("#viewCategoryId").val(data.category_id);
            $("#viewCategoryName").val(data.category_short_description);
            $("#viewCategoryDesc").val(data.category_long_description);
            

        });
    });


    function updateCategory() {

        $('#errorAlert1').hide();
        $('#errorAlert1').html("");

        var updateCategoryDescription = $("#updateCategoryDescription").val();
        var hiddenCategoryId=$("#hiddenCategoryId").val();

        $.post('updateCategory',{
            updateCategoryDescription:updateCategoryDescription,
            hiddenCategoryId:hiddenCategoryId,
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
                    title: 'CATEGORY UPDATED SUCESSFULLY',
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

    function deleteCategory(categoryId){ 
        
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
                    $.post('deleteCategory',{
            categoryId:categoryId,  
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

    $(document).on('click', '#updateCategoryID', function () {
        var categoryId = $(this).data("id");

        $.post('getByCategoryId', {categoryId: categoryId}, function (data) {
            $("#hiddenCategoryId").val(data.category_id);
            $("#updateCategoryDescription").val(data.category_long_description);
        });
    });

    $(document).ready(function(){
        $( document ).on( 'focus', ':input', function(){
            $( this ).attr( 'autocomplete', 'off' );
        });
    });

</script>


@include('includes/footer_end')