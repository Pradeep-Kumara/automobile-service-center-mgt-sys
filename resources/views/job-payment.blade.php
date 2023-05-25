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
                   

                    <div class="table-rep-plugin">
                        <div class="table-responsive b-0" data-pattern="priority-columns">
                            <table  id="datatable" class="table table-striped table-bordered"
                                    cellspacing="0"
                                    width="100%">
                                <thead>
                                <tr>
                                    <th>Order No</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Advance Paid</th>
                                    <th>Balance Paid</th>
                                   
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($jobCards))
                                    @if(count($jobCards)==0)
                                        <tr>
                                            <td colspan="7" style="text-align: center;font-weight: bold  ">Sorry, No Results Found.
                                            </td>
                                        </tr>
                                    @endif
                                    @foreach($jobCards as $jobCard)
                                        <tr>
                                            <td>JO-{{$jobCard->order_order_id}}</td>
                                            <td>{{\App\Customer::find($jobCard->jobcard_customer_id)->customer_firstname}}
                                                {{\App\Customer::find($jobCard->jobcard_customer_id)->customer_lastname}}
                                            </td>
                                            <td>{{$jobCard->jobcard_date}}</td>
                                            <td>{{$jobCard->jobcard_total}}</td>
                                            <td>{{$jobCard->jobcard_advance_paid}}</td>
                                            <td>{{$jobCard->jobcard_paid_amount}}</td>
                                               
                                            <td>

                                                @if ($jobCard->jobcard_status==2)
                                                <h6><span class="badge badge-secondary">Setelement Completed</span></h6>
                                                @else
                                                <p>
                                                        
                                                     

                                                    <a class="tn btn-sm btn-primary  waves-effect waves-light"
                                                                    href="{{ route('balancePayment', ['idOrder' => $jobCard->jobcard_id]) }}">
                                                                    Process to Payment</a>
                                                  
                                                </p> 
                                                @endif
                                                   
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


   

</script>


@include('includes/footer_end')