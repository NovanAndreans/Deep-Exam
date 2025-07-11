@extends('Templates.auth')
@section('content')

    <div class="container-fluid d-flex align-items-center justify-content-center bg-light" style="min-height: 100vh;">
        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
            <form action="{{ route(\App\Constants\Routes::routeSigninAction) }}" method="post">
                @csrf
                <div class="bg-white rounded-5 shadow-lg p-4 p-sm-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-semibold">Sign in</h2>
                        <p class="text-muted small">Use your account</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger small rounded-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control rounded-3" id="email"
                            placeholder="name@example.com" required>
                        <label for="email">Email address</label>
                    </div>

                    <div class="form-floating mb-3 position-relative">
                        <input name="password" type="password" class="form-control rounded-3" id="password"
                            placeholder="Password" required>
                        <label for="password">Password</label>
                        <i class="fa fa-eye position-absolute top-50 end-0 translate-middle-y me-3 toggle-password"
                            style="cursor: pointer;" data-target="#password"></i>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-semibold">Signin</button>

                    <p class="text-center text-muted mt-4 mb-0 small">
                        Don't have an account?
                        <a href="{{ route(\App\Constants\Routes::routeSignup) }}" class="text-primary">Create account</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <!-- Toggle Password Script -->
    @push('scripts')
        <script>
            document.querySelectorAll('.toggle-password').forEach(function(icon) {
                icon.addEventListener('click', function() {
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