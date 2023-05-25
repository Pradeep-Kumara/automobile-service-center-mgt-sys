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
<link href="{{ URL::asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
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
        <h3 class="page-title">{{ $title }}</h3>
            
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
                        <form action="{{ route('completedJobs') }}" method="get">
                            {{ csrf_field() }}

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-group row">
                                                <label for="fromDate" class="col-sm-4 col-form-label">From Date</label>
                                                <div class="col-sm-8">
                                                <input type="date" class="form-control" name ="fromDate" id="fromDate" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-group row">
                                                <label for="toDate" class="col-sm-4 col-form-label">To Date</label>
                                                <div class="col-sm-8">
                                                    <input type="date" class="form-control" name ="toDate" id="toDate" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">                                    
                                    <div class="col-lg-12">
                                        <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <button type="submit"  class="btn btn-primary">Search</button>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card m-b-20">
                    <div class="card-body">
    
                        <h5 style="text-align: center">Here is your report!</h4>
                        <div class="table-rep-plugin">
                            <div class="table-responsive b-0" data-pattern="priority-columns">
                                <table id="datatable-buttons" class="table table-striped table-bordered data-table"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Job ID</th>
                                            <th>Job Date</th>
                                            <th>Vehicle Number</th>
                                            <th>Model</th>
                                            <th>Customer</th>
                                            <th>Job Value (LKR)</th>
                                            <th>Job Duration (hrs.)</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        
                                        @if (count($joblist) != 0)  
                                            @foreach ($joblist as $job)
                                                <tr>
                                                    <td>{{ $job->jobcard_id }}</td>                                                    
                                                    <td>{{ $job->jobcard_date }}</td>
                                                    <td>{{ $job->vehicle_registration_number}}</td>
                                                    <td>{{ $job->vehicle_model}}</td>
                                                    <td>{{ $job->customer_firstname}} {{$job->customer_lastname}} </td>  
                                                    <td>{{ $job->jobcard_total }}</td>
                                                    <td>{{ $job->jobcard_duration}}</td>                                                                         
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
        </div>
    </div>


@include('includes/footer_start')

<!-- Plugins js -->
<script src="{{ URL::asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}" type="text/javascript">
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

    });
    $(document).on("wheel", "input[type=number]", function(e) { 
        $(this).blur();
    });

</script>


@include('includes/footer_end')
