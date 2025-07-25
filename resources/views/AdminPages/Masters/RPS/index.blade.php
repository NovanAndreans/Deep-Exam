@extends('Templates.admin')

@section('title', 'Master RPS')

@section('content-header')
<div class="d-flex justify-content-between align-items-center">
  <h1>Master RPS</h1>
  <div aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{route(\App\Constants\Routes::routeAdminDashboard)}}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="#">Masters</a></li>
      <li class="breadcrumb-item active" aria-current="page">RPS</li>
    </ol>
  </div>
</div>
@php
$hasAddFeature = false;
$hasEditFeature = false;
$hasDeleteFeature = false;
if (count($features->features) > 0) {
foreach ($features->features as $feature) {
if ($feature['featslug'] == 'add') {
foreach ($feature->permissions as $permission) {
if ($permission->permisfeatid == $feature->id) {
$hasAddFeature = $permission->hasaccess;
break;
}
}
}
}

foreach ($features->features as $feature) {
if ($feature['featslug'] == 'edit') {
foreach ($feature->permissions as $permission) {
if ($permission->permisfeatid == $feature->id) {
$hasEditFeature = $permission->hasaccess;
break;
}
}
}
}

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
}
@endphp
@endsection

@section('content')
@includeIf('AdminPages.Masters.RPS.datatable')
@endsection

@section('content-modal')
@includeIf('AdminPages.Masters.RPS.form')
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
            {data: 'title', name: 'title'},
            {data: 'cpmk', name: 'cpmk'},
            {data: 'action', name: 'action', width: 100, orderable: false, searchable: false},
          ]
    });
    // Change page length on dropdown change
    $('#entries').on('change', function () {
            let value = $(this).val();
            table.page.len(value).draw();
        });
    $('.dataTables_filter').addClass('d-none')
  });

  $(document).ready(function () {
        $(document).on('submit', '#modal-form form', function (e) {
          e.preventDefault();

          let form = $(this)[0];  // Ambil elemen form pertama
          let formData = new FormData(form);  // Buat FormData dari elemen form

          $.ajax({
              url: $(this).attr('action'),
              type: 'POST',
              data: formData,
              processData: false,  // Jangan mengubah data form menjadi query string
              contentType: false,  // Jangan mengatur konten header
          })
          .done((response) => {
              console.log('AJAX success', response);
              $('#modal-form').modal('hide');
              setSuccess(response?.message ?? 'Berhasil!');
              table.ajax.reload();
          })
          .fail((xhr) => {
              let message = 'Tidak dapat menyimpan data';
              if (xhr.status === 400 || xhr.status === 403) {
                  let responseJSON = xhr.responseJSON || {};
                  if (responseJSON.message) {
                      message = responseJSON.message;
                  }
              }
              Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: message
              });
          });
      });
  });

  function addForm(url) {
    const hasAddFeature = {{ isset($hasAddFeature) ? json_encode($hasAddFeature) : 'null' }};
    const letItGo = !hasAddFeature;
      if (letItGo) {
        Swal.fire({
          title: 'Tidak Memiliki Akses',
          text: "Anda tidak memiliki akses untuk menambahkan data",
          icon: 'error',
        })
        return
      }
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Tambah RPS');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('post');
      $('#modal-form [name=materi]').focus();
  }

  function editForm(url) {  
    const hasEditFeature = {{ isset($hasEditFeature) ? json_encode($hasEditFeature) : 'null' }};
    const letItGo = !hasEditFeature;
      if (letItGo) {
        Swal.fire({
          title: 'Tidak Memiliki Akses',
          text: "Anda tidak memiliki akses untuk mengubah data",
          icon: 'error',
        })
        return
      }
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Edit RPS');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('put');
      $('#modal-form [name=name]').focus();

      $.get(url)
          .done((response) => {
              $('#modal-form [name=title]').val(response?.data?.title ?? '');
              $('#modal-form [name=desc]').val(response?.data?.desc ?? '');
              $('#modal-form [name=cpmk]').val(response?.data?.cpmk ?? '');
          })
          .fail((errors) => {
              alert('Tidak dapat menampilkan data');
              return;
          });
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
                        setError('Tidak dapat menghapus data')
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