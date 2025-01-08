@extends('Templates.admin')

@section('title', 'Master Users')

@push('css')
<style>
  .toggle-password {
    cursor: pointer;
    color: #6c757d;
  }

  .toggle-password:hover {
    color: #000;
  }

  .dataTables_length {
    display: none !important;
  }
</style>
@endpush

@section('content-header')
<h1>Master Users</h1>
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
@includeIf('AdminPages.Masters.Users.datatable')
@endsection

@section('content-modal')
@includeIf('AdminPages.Masters.Users.form')
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
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'roles', name: 'roles'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
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
      $('#modal-form .modal-title').text('Tambah User');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('post');
      $('#modal-form [name=name]').focus();

      $('#password, #password_confirmation').attr('required', true);
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
      $('#modal-form .modal-title').text('Edit User');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('put');
      $('#modal-form [name=name]').focus();

      $('#password, #password_confirmation').attr('required', false);

      $.get(url)
          .done((response) => {
              $('#modal-form [name=role_id]').val(response?.data?.role_id ?? '');
              $('#modal-form [name=name]').val(response?.data?.name ?? '');
              $('#modal-form [name=gender_id]').val(response?.data?.gender_id ?? '');
              $('#modal-form [name=username]').val(response?.data?.username ?? '');
              $('#modal-form [name=email]').val(response?.data?.email ?? '');
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