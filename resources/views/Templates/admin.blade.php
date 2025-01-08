<!DOCTYPE html>
<html lang="en">

@include('Templates.AdminComponents.header')

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        @include('Templates.AdminComponents.sidebar')


        <!-- Content Start -->
        <div class="content">

            @include('Templates.AdminComponents.navbar')
            <div class="container-fluid pt-4 px-4">
                @yield('content-header')
                @yield('content')
            </div>


            @include('Templates.AdminComponents.footer')
        </div>
        <!-- Content End -->


        @yield('content-modal')
        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    @include('Templates.AdminComponents.scripts')
</body>

</html>