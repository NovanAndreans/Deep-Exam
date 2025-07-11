@extends('Templates.auth')
@section('content')

<!-- Sign Up Start -->
<div class="container-fluid bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
        <form action="{{ route(\App\Constants\Routes::routeSignupAction) }}" method="post"
            class="animate_animated animate_fadeInUp">
            @csrf
            <div class="bg-white rounded-4 shadow-lg p-4 p-sm-5 my-4 mx-3">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-primary">Create Account</h2>
                    <p class="text-muted">Start your journey with us</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger small">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-floating mb-3">
                    <select name="role" class="form-select" id="role">
                        <option value="">Select Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    <label for="role">Role</label>
                </div>

                <div class="form-floating mb-3">
                    <input name="name" type="text" class="form-control" id="name" placeholder="Fullname">
                    <label for="name">Fullname</label>
                </div>

                <div class="form-floating mb-3">
                    <input name="email" type="email" class="form-control" id="email" placeholder="Email">
                    <label for="email">Email address</label>
                </div>

                <div class="form-floating mb-3 position-relative">
                    <input name="password" type="password" class="form-control" id="password" minlength="8" placeholder="Password">
                    <label for="password">Password</label>
                    <i class="fa fa-eye toggle-password position-absolute end-0 top-50 translate-middle-y me-3"
                       data-target="#password" style="cursor: pointer;"></i>
                </div>

                <div class="form-floating mb-4 position-relative">
                    <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" minlength="8" placeholder="Password Confirmation">
                    <label for="password_confirmation">Confirm Password</label>
                    <i class="fa fa-eye toggle-password position-absolute end-0 top-50 translate-middle-y me-3"
                       data-target="#password_confirmation" style="cursor: pointer;"></i>
                </div>

                <button type="submit" class="btn btn-primary py-3 w-100 rounded-3">Sign Up</button>

                <p class="text-center text-muted mt-3 mb-0 small">Already have an account? <a href="{{ route(\App\Constants\Routes::routeSignin) }}" class="text-primary">Sign In</a></p>
            </div>
        </form>
    </div>
</div>
<!-- Sign Up End -->

<!-- Toggle Password Script -->
@push('scripts')
<script>
    document.querySelectorAll('.toggle-password').forEach(function (icon) {
        icon.addEventListener('click', function () {
            const targetInput = document.querySelector(this.getAttribute('data-target'));
            const type = targetInput.getAttribute('type') === 'password' ? 'text' : 'password';
            targetInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    });
</script>
@endpush

@endsection