@include('includes.header_account')

<!-- Begin page -->

<div class="wrapper-page">

    <div class="card">
        <div class="card-body">

            <img src="{{ URL::asset('assets/images/spl_logo.png')}}"  class="rounded mx-auto d-block" height="40px" width="50px" alt="logo">
            <h3 class="text-center m-0"> <strong>Stephens' Pvt Ltd</strong></h3>    
            
            <br>
            <img src="{{ URL::asset('assets/images/logo.jpg')}}"  class="rounded mx-auto d-block" height="80px" width="120px" alt="logo">

            <div class="p-3">
                <h4 class="text-muted font-18 m-b-5 text-center">Welcome!</h4>
                <p class="text-muted text-center">Sign in to continue to Vehicle Service System.</p>

                @if(\Session::has('error'))
                    <div class="alert alert-danger alert-dismissible ">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p>{{ \Session::get('error') }}</p>
                    </div>
                @endif

                @if(\Session::has('warning'))
                    <div class="alert alert-warning alert-dismissible ">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p style="color:red;">{{ \Session::get('warning') }}</p>
                    </div>
                @endif


                <form class="form-horizontal m-t-30" action="{{ route('login') }}" method="POST">
                {{--<form class="form-horizontal m-t-30" action="{{ route('authenticate') }}" method="POST">--}}

                    <div class="form-group">
                        <label for="username">Username / NIC</label>
                        <input type="text" class="form-control" id="username" name="username"
                               placeholder="Enter your NIC">
                        <small class="text-danger">{{ $errors->first('username') }}</small>
                    </div>

                    <div class="form-group">
                        <label for="pass">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                        <small class="text-danger">{{ $errors->first('password') }}</small>
                    </div>
                    <input type="hidden" name="_token" value="{{ Session::token() }}">

                    <div class="form-group row m-t-20">
                        <div class="col-sm-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="rememberme" id="customControlInline">
                                <label class="custom-control-label" for="customControlInline">Remember me</label>
                            </div>
                        </div>
                        <div class="col-sm-6 text-right">
                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>

                    <div class="form-group m-t-10 mb-0 row">
                        <div class="col-12 m-t-20">
                            <a href="pages-recoverpw" class="text-muted"><i class="mdi mdi-lock"></i> Forgot your password?</a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="m-t-40 text-center">
        <p>Don't have an account ? <a href="{{route('signup')}}" class="font-500 font-14 text-primary font-secondary"> Sign-up Now </a></p>
        <p>

            Crafted By Geeth for BIT-UCSC

        </p>

    </div>

</div>

@include('includes.footer_account')