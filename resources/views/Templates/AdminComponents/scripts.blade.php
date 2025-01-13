<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('Admin/lib/chart/chart.min.js')}}"></script>
<script src="{{asset('Admin/lib/easing/easing.min.js')}}"></script>
<script src="{{asset('Admin/lib/waypoints/waypoints.min.js')}}"></script>
<script src="{{asset('Admin/lib/owlcarousel/owl.carousel.min.js')}}"></script>
<script src="{{asset('Admin/lib/tempusdominus/js/moment.min.js')}}"></script>
<script src="{{asset('Admin/lib/tempusdominus/js/moment-timezone.min.js')}}"></script>
<script src="{{asset('Admin/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js')}}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('Admin/js/components-table.js') }}"></script>
<script src="{{ asset('Admin/lib/datatables/jquery.dataTables.min.js') }}" defer></script>
<script src="{{ asset('Admin/lib/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- Template Javascript -->
<script src="{{asset('Admin/js/main.js')}}"></script>

<script>
  $(document).ready(function() {
    $("body").tooltip({ selector: '[data-bs-toggle=tooltip]' });
});
</script>

<script>
  var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
  
  function setSuccess(title) {
    Toast.fire({
      icon: 'success',
      title: title
    });
  }

    function setError(title) {
      Toast.fire({
        icon: 'error',
        title: title
      });
    }
</script>

@stack('script')