@extends('Templates.auth')
@section('content')
<!-- Sign Up Start -->
<div class="container-fluid">
    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
            <form action="{{route(\App\Constants\Routes::routeSignupAction)}}" method="post"
                class="animate__animated animate__zoomIn">
                @csrf
                <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <a href="index.html" class="">
                            <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>DASHMIN</h3>
                        </a>
                        <h3>Sign Up</h3>
                    </div>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="form-floating mb-4">
                        <select name="role" class="form-select" id="role" aria-label="Floating label select example">
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                        <label for="role">Role</label>
                    </div>
                    <div class="form-floating mb-4">
                        <select name="class" class="form-select" id="class" aria-label="Floating label select example">
                            <option value="">Select Kelas</option>
                            @foreach ($classes as $class)
                            <option value="{{$class->id}}">{{$class->name}}</option>
                            @endforeach
                        </select>
                        <label for="class">Class</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="name" type="text" class="form-control" id="name" placeholder="Name">
                        <label for="name">Fullname</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="email" type="email" class="form-control" id="email" placeholder="Email">
                        <label for="email">Email address</label>
                    </div>
                    <div class="form-floating mb-4 position-relative">
                        <input name="password" type="password" minlength="8" class="form-control" id="password"
                            placeholder="Password">
                        <label for="password">Password</label>
                        <i class="fa fa-eye position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer toggle-password"
                            data-target="#password"></i>
                    </div>
                    <div class="form-floating mb-4 position-relative">
                        <input name="password_confirmation" type="password" minlength="8" class="form-control"
                            id="password_confirmation" placeholder="Password Confirmation">
                        <label for="password_confirmation">Password Confirmation</label>
                        <i class="fa fa-eye position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer toggle-password"
                            data-target="#password_confirmation"></i>
                    </div>

                    <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign Up</button>
                    <p class="text-center mb-0">Already have an Account? <a
                            href="{{route(\App\Constants\Routes::routeSignin)}}">Sign In</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Sign Up End -->
@endsection