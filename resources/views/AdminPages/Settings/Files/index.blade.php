@extends('Templates.admin')

@section('title', 'Master Users')

@push('css')
<style>
  .dataTables_length {
    display: none !important;
  }
</style>
@endpush

@section('content-header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Setting Files</h1>
    <div aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route(\App\Constants\Routes::routeAdminDashboard)}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Settings</a></li>
            <li class="breadcrumb-item active" aria-current="page">Files</li>
        </ol>
    </div>
</div>

@php
$hasViewImgFeature = false;
$hasDeleteFeature = false;
if (count($features->features) > 0) {
foreach ($features->features as $feature) {
if ($feature['featslug'] == 'delete') {
foreach ($feature->permissions as $permission) {
if ($permission->permisfeatid == $feature->id) {
$hasDeleteFeature = $permission->hasaccess;
break;
}
}
}
}

foreach ($features->features as $feature) {
if ($feature['featslug'] == 'viewimg') {
foreach ($feature->permissions as $permission) {
if ($permission->permisfeatid == $feature->id) {
$hasViewImgFeature = $permission->hasaccess;
break;
}
}
}
}
}
@endphp
@endsection

@section('content')
@includeIf('AdminPages.Settings.Files.datatable')
@endsection

@section('content-modal')
@includeIf('AdminPages.Settings.Files.form')
@endsection

@push('script')
<script type="text/javascript">
  var table
  $(function () {
      $('#datatable-search').keyup(function(){
          $('#datatable').DataTable().search($(this).val()).draw();
      })
      
    table = $('#datatable').DataTable({
        "bFilter": true,
        processing: true,
        serverSide: true,
        ajax: "{{ url()->current() }}",
        "drawCallback": function () {
              $('.dataTables_paginate > .paginate_button').addClass('page-link p-2');
          },
          pageLength: 5,
        columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
              {data: 'filename', name: 'filename'},
              {data: 'type', name: 'type'},
              {data: 'mimetype', name: 'mimetype'},
              {data: 'filesize', name: 'filesize'},
              {data: 'action', name: 'action'},
          ]
    });
    // Change page length on dropdown change
    $('#entries').on('change', function () {
            let value = $(this).val();
            table.page.len(value).draw();
        });
    $('.dataTables_filter').addClass('d-none')
  });

  function viewImg(url, title) {
      const hasViewImgFeature = {{ isset($hasViewImgFeature) ? json_encode($hasViewImgFeature) : 'null' }};
      const letItGo = !hasViewImgFeature;
        if (letItGo) {
          Swal.fire({
            title: 'Tidak Memiliki Akses',
            text: "Anda tidak memiliki akses untuk melihat gambar",
            icon: 'error',
          })
          return
        }
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('');
        $('#img-viewer').attr('src', url);
        $('#img-title').text(title);
    }

    function deleteData(url) {
      const hasDeleteFeature = {{ isset($hasDeleteFeature) ? json_encode($hasDeleteFeature) : 'null' }};
      const letItGo = !hasDeleteFeature;
        if (letItGo) {
          Swal.fire({
            title: 'Tidak Memiliki Akses',
            text: "Anda tidak memiliki akses untuk menghapus data",
            icon: 'error',
          })
          return
        }
      Swal.fire({
        title: 'Apakah Anda Yakin ?',
        text: "Anda tidak akan dapat mengembalikan ini !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yakin',
        cancelButtonText: 'Tidak'
      }).then((result) => {
        if (result.isConfirmed) {
          $.post(url, {
                          '_token': $('[name=csrf-token]').attr('content'),
                          '_method': 'delete'
                      })
                      .done((response) => {
                          setSuccess(response?.message + '\n' +'Akun '+response.data.name +' terhapus.')
                          table.ajax.reload();
                      })
                      .fail((errors) => {
                          alert('Tidak dapat menghapus data');
                          return;
                      });
        }
      })
    }
</script>
<script>
  document.addEventListener("DOMContentLoaded", () => {
      const toggles = document.querySelectorAll('.toggle-password');

      toggles.forEach(toggle => {
          toggle.addEventListener('click', () => {
              const input = document.querySelector(toggle.getAttribute('data-target'));
              const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
              input.setAttribute('type', type);

              // Ganti ikon mata
              toggle.classList.toggle('fa-eye');
              toggle.classList.toggle('fa-eye-slash');
          });
      });
  });
</script>
@endpush