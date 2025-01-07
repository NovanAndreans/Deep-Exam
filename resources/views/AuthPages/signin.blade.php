@extends('Templates.auth')
@section('content')
<!-- Sign In Start -->
<div class="container-fluid">
    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
            <form action="{{route(\App\Constants\Routes::routeSigninAction)}}" method="post">
                @csrf
                <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <a href="index.html" class="">
                            <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>DASHMIN</h3>
                        </a>
                        <h3>Sign In</h3>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control" id="floatingInput"
                            placeholder="name@example.com">
                        <label for="floatingInput">Email address</label>
                    </div>
                    <div class="form-floating mb-4 position-relative">
                        <input name="password" type="password" minlength="8" class="form-control" id="password"
                            placeholder="Password">
                        <label for="password">Password</label>
                        <i class="fa fa-eye position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer toggle-password"
                            data-target="#password"></i>
                    </div>
                    <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>
                    <p class="text-center mb-0">Don't have an Account? <a href="{{route(\App\Constants\Routes::routeSignup)}}">Sign Up</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Sign In End -->
@endsection