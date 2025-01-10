<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('Guest/lib/wow/wow.min.j')}}s"></script>
<script src="{{asset('Guest/lib/easing/easing.min.js')}}"></script>
<script src="{{asset('Guest/lib/waypoints/waypoints.min.js')}}"></script>
<script src="{{asset('Guest/lib/owlcarousel/owl.carousel.min.js')}}"></script>

<!-- Template Javascript -->
<script src="{{asset('Guest/js/main.js')}}"></script>
<!-- Notification Scripts -->
<script src="{{ asset('Guest/lib/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
    $(document).ready(function() {

    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });

    @if(Session::has('success'))
      Toast.fire({
        icon: 'success',
        title: "{{ Session::get('success') }}"
      });
    @endif

    @if(Session::has('error'))
      Toast.fire({
        icon: 'error',
        title: "{{ Session::get('error') }}"
      });
    @endif
  });
</script>