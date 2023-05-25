<!-- Loader -->
<div id="preloader">
    <div id="status">
        <div class="spinner"></div>
    </div>
</div>

<!-- Begin page -->
<div id="wrapper">

    <!-- ========== Left Sidebar Start ========== -->
    <div class="left side-menu">

        <!-- LOGO -->
        <div class="topbar-left">
            <div class="">
                <!--<a href="index" class="logo text-center">Fonik</a>-->

                {{-- <a href="{{ URL::asset('index')}}" class="logo"><img src="{{ URL::asset('assets/images/home.png')}}"
                                                                     height="40" alt="logo"></a> --}}
                <a href="/" class="logo"><img src="{{ URL::asset('assets/images/home.png')}}" height="40" alt="logo"></a>

            </div>
        </div>

        <div class="sidebar-inner slimscrollleft">
            <div id="sidebar-menu">
                <ul>
                    <li class="menu-title">Operations Menu</li>
                    <li>
                        <a href="/" class="waves-effect">
                            <i class="fa fa-area-chart"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
            @if (\Illuminate\Support\Facades\Auth::user()->user_role_id == 2 ||
                 \Illuminate\Support\Facades\Auth::user()->user_role_id == 1 ||  
                 \Illuminate\Support\Facades\Auth::user()->user_role_id == 3)          
                    <li>
                        <a href="order" class="waves-effect">
                            <i class="fa fa-shopping-basket"></i>
                            <span>Job Order</span>
                        </a>
                    </li>
            @endif

            @if (\Illuminate\Support\Facades\Auth::user()->user_role_id == 2 || 
                 \Illuminate\Support\Facades\Auth::user()->user_role_id == 3 || 
                 \Illuminate\Support\Facades\Auth::user()->user_role_id == 4) 
                    <li>
                        <a href="job-card" class="waves-effect">
                            <i class="fa fa-wrench"></i>
                            <span>Job Card</span>
                        </a>
                    </li>
            @endif
            
            @if (\Illuminate\Support\Facades\Auth::user()->user_role_id == 2 ||
                 \Illuminate\Support\Facades\Auth::user()->user_role_id == 1 ||  
                 \Illuminate\Support\Facades\Auth::user()->user_role_id == 3)  
                    <li>           
                        <a href="job-payment" class="waves-effect">
                            <i class="fa fa-money"></i>
                            <span>Settlement</span>
                        </a>
                    </li>     
            @endif
                   
                </ul>
            </div>

           
            <div id="sidebar-menu">
                {{-- @if (\Illuminate\Support\Facades\Auth::user()->user_role_id == 2 || 
                    \Illuminate\Support\Facades\Auth::user()->user_role_id == 3)  --}}
                <ul>
                    <li class="menu-title">Master files</li>

                    @if (\Illuminate\Support\Facades\Auth::user()->user_role_id == 2 || 
                        \Illuminate\Support\Facades\Auth::user()->user_role_id == 3)
                        <li>
                            <a href="customer" class="waves-effect">
                                <i class="fa fa-book"></i>
                                <span>Customer Master</span>
                            </a>
                        </li>
                    @endif
                    
                    @if (\Illuminate\Support\Facades\Auth::user()->user_role_id == 2 ||
                        \Illuminate\Support\Facades\Auth::user()->user_role_id == 1 || 
                        \Illuminate\Support\Facades\Auth::user()->user_role_id == 3)
                        <li>
                            <a href="vehicle" class="waves-effect">
                                <i class="fa fa-car"></i>
                                <span>Vehicle Master</span>
                            </a>
                        </li>
                    @endif

                    @if (\Illuminate\Support\Facades\Auth::user()->user_role_id == 2 || 
                        \Illuminate\Support\Facades\Auth::user()->user_role_id == 3)
                        <li>
                            <a href="item" class="waves-effect">
                                <i class="fa fa-shopping-cart"></i>
                                <span>Item Master</span>
                            </a>
                        </li>
                    @endif

                    @if (\Illuminate\Support\Facades\Auth::user()->user_role_id == 2 || 
                        \Illuminate\Support\Facades\Auth::user()->user_role_id == 3)
                    <li>
                        <a href="task" class="waves-effect">
                            <i class="fa fa-tasks"></i>
                            <span>Task Master</span>
                        </a>
                    </li>
                    @endif

                    @if (\Illuminate\Support\Facades\Auth::user()->user_role_id == 2 || 
                        \Illuminate\Support\Facades\Auth::user()->user_role_id == 3)
                    <li>
                        <a href="user" class="waves-effect">
                            <i class="fa fa-tasks"></i>
                            <span>User Master</span>
                        </a>
                    </li>
                    @endif

                </ul>
                {{-- @endif --}}

            </div>
            <div id="sidebar-menu">

                @if (\Illuminate\Support\Facades\Auth::user()->user_role_id == 2)
                <ul>
                    <li class="menu-title">Settings</li>
                    <li>
                        <a href="category" class="waves-effect">
                        <i class="fa fa-user"></i>
                        <span> Item Category</span>
                    </a>
                    </li> 
                    <li>
                        <a href="uom" class="waves-effect">
                        <i class="fa fa-cogs"></i>
                        <span>Unit of measure</span>
                    </a>
                    </li>
                    <li>
                        <a href="refund" class="waves-effect">
                        <i class="fa fa-money"></i>
                        <span> Refund amount setup</span>
                    </a>
                    </li>
                    <li>
                        <a href="advance" class="waves-effect">
                        <i class="fa fa-money"></i>
                        <span>Advance payment</span>
                    </a>
                    </li>
                </ul>
                @endif
                
            </div>
            <div id="sidebar-menu">

                @if (\Illuminate\Support\Facades\Auth::user()->user_role_id == 2 ||
                    \Illuminate\Support\Facades\Auth::user()->user_role_id == 3
                    )
                <ul>
                    <li class="menu-title">Reports</li>

                    
                    <li>
                        <a href="serviceHistory" class="waves-effect">
                            <i class="fa fa-file-text-o"></i>
                            <span>Service History</span>
                        </a>
                    </li>
                                        
                    <li>
                        <a href="completedJobs" class="waves-effect">
                            <i class="fa fa-file-text-o"></i>
                            <span>Completed Jobs</span>
                        </a>
                    </li>
                    <li>
                        <a href="jobEfficiency" class="waves-effect">
                            <i class="fa fa-file-text-o"></i>
                            <span>Job efficiency </span>
                        </a>
                    </li>
                    <li>
                        <a href="revenue" class="waves-effect">
                            <i class="fa fa-file-text-o"></i>
                            <span>Revenue Report</span> 
                        </a>
                    </li>
                    {{-- <li>
                        <a href="inventoryConsumed" class="waves-effect">
                            <i class="fa fa-file-text-o"></i>
                            <span>Inventory consumed</span> 
                        </a>
                    </li> --}}
                    <li>
                        <a href="vehicleList" class="waves-effect">
                            <i class="fa fa-file-text-o"></i>
                            <span>Vehicle List</span> 
                        </a>
                    </li>
                </ul>
                @endif
            </div>

            {{-- @endif --}}
            <div class="clearfix"></div>
        </div> <!-- end sidebarinner -->
    </div>
    <!-- Left Sidebar End -->
