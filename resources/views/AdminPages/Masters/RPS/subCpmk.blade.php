@extends('Templates.admin')

@section('title', $data->title)

@section('content-header')
<div class="d-flex row">
    <div class="col-sm-9">
        <div class="d-flex align-items-center">
            <a href="{{route(\App\Constants\Routes::routeMasterRps)}}" class="btn btn-rounded btn-info"><i
                    class="fas fa-arrow-left"></i></a>
            <h4 class="mt-2 ms-2">{{$data->title}}</h4>
        </div>
    </div>
    <div class="col-sm-3">
        <div aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="{{route(\App\Constants\Routes::routeAdminDashboard)}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item"><a href="#">Masters</a></li>
                <li class="breadcrumb-item"><a href="{{route(\App\Constants\Routes::routeMasterRps)}}">RPS</a></li>
            </ol>
        </div>
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
<div class="col-sm-12 col-xl-12 mb-2">
    <div class="bg-light rounded h-100 p-4">
        {{-- <h3 class="mb-4">{{$data->title}}</h3> --}}
        <dl class="row mb-0">
            <dt class="col-sm-2">Description</dt>
            <dd class="col-sm-10">{{$data->desc}}</dd>

            <dt class="col-sm-2">CPMK</dt>
            <dd class="col-sm-10">{{$data->cpmk}}</dd>
        </dl>
    </div>
</div>
@endsection

@section('content')
<div class="mb-2 col-sm-12 col-md-12 col-xl-12">
    <div class="h-100 bg-light rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Sub Capaian Pembelajaran Mata Kuliah (CPMK)</h6>
        </div>
        <div class="d-flex mb-2">
            <input type="hidden" id="id-subcpmk" name="cpmk_id" value="{{$data->id}}">
            <input id="new-subcpmk" class="form-control bg-transparent" type="text" placeholder="Enter Sub CPMK">
            <button type="button" class="btn btn-primary ms-2" onclick="addSubCpmk()">Add</button>
        </div>
        <div id="subCpmkList">
            @foreach($data->subCpmk as $subCpmk)
            <div class="d-flex align-items-center border-bottom py-2 subcpmk-item" data-id="{{$subCpmk->id}}">
                <div class="w-100 ms-3">
                    <div class="d-flex w-100 align-items-center justify-content-between">
                        <span class="subcpmk-text">{{$subCpmk->subcpmk}} <div class="badge bg-success subcpmk-text-limit">{{$subCpmk->limit_bloom}}</div></span>
                        <input class="subcpmk-input form-control d-none" type="text" value="{{$subCpmk->subcpmk}}">
                        <div>
                            <button class="btn btn-sm btn-outline-warning edit-btn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-sm btn-outline-success save-btn ms-2 d-none"><i
                                    class="fa fa-check"></i></button>
                            <button class="btn btn-sm btn-outline-danger delete-btn"
                                onclick="deleteData(`{{ route('subcpmk.destroy', $subCpmk->id) }}`)">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Section untuk Meetings -->
<div class="col-sm-12 col-md-12 col-xl-12">
    <div class="h-100 bg-light rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Meetings</h6>
            <button class="btn btn-primary" onclick="addMeetingForm()">Add Meeting</button>
        </div>
        <div id="meetingList"></div>
        <div id="meetingForm" class="d-none">
            <input type="hidden" id="meeting-id">
            <div class="mb-2">
                <label>Title</label>
                <input id="meeting-title" class="form-control" type="text">
            </div>
            <div class="mb-2">
                <label>Description</label>
                <textarea id="meeting-desc" class="form-control"></textarea>
            </div>
            <div class="mb-2">
                <label>Minggu Ke</label>
                <input id="meeting-week" class="form-control" type="number">
            </div>
            <div class="mb-2">
                <label>Sub CPMK</label>
                <div id="meeting-subcpmk-container"></div>
                <button class="btn btn-sm btn-outline-success mt-2" onclick="addSubCpmkSelect()">+ Add Sub CPMK</button>
            </div>
            <button class="btn btn-success" onclick="saveMeeting()">Save</button>
            <button class="btn btn-secondary" onclick="hideMeetingForm()">Cancel</button>
        </div>
    </div>
</div>

@endsection

@section('content-modal')
@includeIf('AdminPages.Masters.RPS.kisi')
@endsection

@push('script')
<script type="text/javascript">
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
                        setSuccess(response?.message)
                        window.location.reload()
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
    function addSubCpmk() {
        let newSubCpmk = document.getElementById('new-subcpmk').value.trim();
        let CpmkId = document.getElementById('id-subcpmk').value.trim();
        if (!newSubCpmk) return;

        $.ajax({
            url: "{{ route('subcpmk.store') }}", // Endpoint Laravel
            type: "POST",
            data: {
                subcpmk: newSubCpmk,
                cpmk_id: CpmkId,
                _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token Laravel
            },
            success: function(response) {
                if (response.message) {
                    let newElement = `
                    <div class="d-flex align-items-center border-bottom py-2 subcpmk-item" data-id="${response.data.id}">
                        <div class="w-100 ms-3">
                            <div class="d-flex w-100 align-items-center justify-content-between">
                                <span class="subcpmk-text">${response.data.subcpmk} <div class="badge bg-success subcpmk-text-limit">${response.data.limit_bloom}</div></span>
                                <input class="subcpmk-input form-control d-none" type="text" value="${response.data.subcpmk}">
                                <div>
                                    <button class="btn btn-sm btn-outline-warning edit-btn"><i class="fa fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-success save-btn d-none ms-2"><i class="fa fa-check"></i></button>
                                    <button class="btn btn-sm btn-outline-danger delete-btn"
                                        onclick="deleteData('{{ route('subcpmk.destroy', '') }}/${response.data.id}')">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>`;

                    document.getElementById('subCpmkList').insertAdjacentHTML('beforeend', newElement);
                    document.getElementById('new-subcpmk').value = "";
                    addEventListeners();
                    window.location.reload()
                } else {
                    alert('Gagal menambahkan Sub CPMK.');
                }
            },
            error: function(xhr) {
                alert('Terjadi kesalahan: ' + xhr.responseText);
            }
        });
    }


    function addEventListeners() {
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                let parent = this.closest('.subcpmk-item');
                let text = parent.querySelector('.subcpmk-text');
                let input = parent.querySelector('.subcpmk-input');
                let saveBtn = parent.querySelector('.save-btn');
                let deleteBtn = parent.querySelector('.delete-btn');

                text.classList.add('d-none');
                input.classList.remove('d-none');
                this.classList.add('d-none');
                saveBtn.classList.remove('d-none');
                deleteBtn.classList.add('d-none');
            });
        });

        document.querySelectorAll('.save-btn').forEach(button => {
            button.addEventListener('click', function() {
                let parent = this.closest('.subcpmk-item');
                let text = parent.querySelector('.subcpmk-text');
                let limit = parent.querySelector('.subcpmk-text-limit');
                let input = parent.querySelector('.subcpmk-input');
                let editBtn = parent.querySelector('.edit-btn');
                let deleteBtn = parent.querySelector('.delete-btn');
                let subCpmkId = parent.getAttribute('data-id'); // Ambil ID SubCPMK

                let updatedValue = input.value.trim();
                if (!updatedValue) return;

                // Kirim data ke server menggunakan AJAX
                $.ajax({
                    url: `{{ url('masters/subcpmk') }}/${subCpmkId}`, // Pastikan URL sesuai dengan Laravel resource
                    type: "POST", // Laravel tidak menerima PUT langsung dari form
                    data: {
                        _method: "PUT", // Override dengan metode PUT
                        subcpmk: updatedValue,
                        _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token Laravel
                    },
                    success: function(response) {
                        if (response.message) {
                            text.textContent = updatedValue;
                            limit.textContent = response.data.limit_bloom;
                            text.classList.remove('d-none');
                            input.classList.add('d-none');
                            button.classList.add('d-none');
                            editBtn.classList.remove('d-none');
                            deleteBtn.classList.remove('d-none');
                            window.location.reload()
                        } else {
                            alert('Gagal memperbarui Sub CPMK.');
                        }
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });

            });
        });
    }

    document.addEventListener("DOMContentLoaded", () => {
        addEventListeners();
    });
</script>

<script>
    function fetchMeetings() {
        var meetings = @json($data->meeting);

        let meetingHtml = '';
        meetings.forEach(meeting => {
            meetingHtml += `
                <div class="border-bottom py-2 d-flex justify-content-between align-items-center">
                    <div>
                        <strong>${meeting.title}</strong> (Minggu ${meeting.minggu_ke})
                        <p class="mb-0">${meeting.desc}</p>
                    </div>
                    <div>
                        <button class="btn btn-sm ${meeting.kisi.length > 0 ? 'btn-success' : 'btn-info'} me-2" 
                            onclick="${meeting.kisi.length > 0 ? `lihatKisi(${meeting.id})` : `createKisi(${meeting.id})`}">
                            <i class="fas fa-clipboard-list"></i>
                        </button>
                        <button class="btn btn-sm btn-warning me-2" onclick="editMeeting(${meeting.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteMeeting(${meeting.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
        });

        $('#meetingList').html(meetingHtml);
    }
    function addMeetingForm() { 
        showMeetingForm()
            $('#meeting-id').val('');
            $('#meeting-title').val('');
            $('#meeting-desc').val('');
            $('#meeting-week').val('');
     }

    function showMeetingForm() {
        $('#meetingForm').removeClass('d-none');
    }

    function hideMeetingForm() {
        $('#meetingForm').addClass('d-none');
    }

    function addSubCpmkSelect() {
        $('#meeting-subcpmk-container').append(`<div class="d-flex mb-2">
            <select class="form-control subcpmk-select">
                @foreach($data->subCpmk as $subCpmk)
                <option value="{{$subCpmk->id}}">{{$subCpmk->subcpmk}}</option>
                @endforeach
            </select>
            <button class="btn btn-sm btn-danger ms-2" onclick="$(this).parent().remove()">Remove</button>
        </div>`);
    }

    function saveMeeting() {
        let subcpmks = $('.subcpmk-select').map(function() { return $(this).val(); }).get();
        let data = {
            title: $('#meeting-title').val(),
            desc: $('#meeting-desc').val(),
            minggu_ke: $('#meeting-week').val(),
            rps_id: {{$data->id}},
            subcpmks: subcpmks,
            _token: $('meta[name="csrf-token"]').attr('content')
        };
        let id = $('#meeting-id').val();
        let url = id ? `{{ url('masters/meeting') }}/${id}` : "{{ route('meeting.store') }}";
        let method = id ? "PUT" : "POST";

        $.ajax({ url, type: method, data, success: function() { window.location.reload() } });
    }

    function editMeeting(id) {
        $.get(`{{ url('masters/meeting') }}/${id}`, function(response) {
            if (response.message) {
                // Isi form dengan data dari server
                $('#meeting-id').val(response.data.id);
                $('#meeting-title').val(response.data.title);
                $('#meeting-desc').val(response.data.desc);
                $('#meeting-week').val(response.data.minggu_ke);
                
                // Hapus elemen sebelumnya dan isi ulang container SubCPMK
                let subCpmkHtml = '';
                response.data.sub_cpmk.forEach(s => {
                    subCpmkHtml += `
                        <div class="d-flex mb-2">
                            <select class="form-control subcpmk-select">
                                <option value="${s.id}" selected>${s.subcpmk}</option>
                            </select>
                            <button type="button" class="btn btn-sm btn-danger ms-2 remove-subcpmk">Remove</button>
                        </div>`;
                });
                $('#meeting-subcpmk-container').html(subCpmkHtml);

                // Pastikan tombol "Remove" dapat menghapus elemen dengan aman
                $('.remove-subcpmk').click(function() {
                    $(this).parent().remove();
                });

                // Tampilkan form editing
                showMeetingForm();
            } else {
                alert('Gagal mengambil data. Coba lagi.');
            }
        }).fail(function() {
            alert('Terjadi kesalahan dalam mengambil data meeting.');
        });
    }

    function deleteMeeting(id) {
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
            $.ajax({ url: `{{ url('masters/meeting') }}/${id}`, type: "DELETE", data: { _token: $('meta[name="csrf-token"]').attr('content') }, success: window.location.reload() });
        }
        })
    }

    function createKisi(id) {
        Swal.fire({
            title: "Kisi-kisi masih belum ada, apakah anda ingin dibuatkan sekarang ?",
            showCancelButton: true,
            confirmButtonText: "Yes",
            showLoaderOnConfirm: true,
            preConfirm: async (login) => {
                try {
                const githubUrl = `
                    {{ url('masters/meeting/generate-kisi') }}/${id}
                `;
                const response = await fetch(githubUrl);
                if (!response.ok) {
                    return Swal.showValidationMessage(`
                    ${JSON.stringify(await response.json())}
                    `);
                }
                return response.json();
                } catch (error) {
                Swal.showValidationMessage(`
                    Request failed: ${error}
                `);
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.reload()
            }
        });
    }

    function lihatKisi(id) {
        // Initialize the HTML content
        var kisiHtml = '';

        // Show a loading message or spinner while waiting for the data
        $('#modal-content').html('<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');

        $.get(`{{ url('masters/meeting') }}/${id}`, function(response) {
            $('#exampleModalLabel').text(response.data.title);
            if (response.message) {
                // Group the items by taksonomi_bloom and then by type
                var groupedKisi = {};

                response.data.kisi.forEach(item => {
                    // Group by taksonomi_bloom first
                    if (!groupedKisi[item.taksonomi_bloom]) {
                        groupedKisi[item.taksonomi_bloom] = {};
                    }
                    
                    // Then group by type within each taksonomi_bloom
                    if (!groupedKisi[item.taksonomi_bloom][item.type]) {
                        groupedKisi[item.taksonomi_bloom][item.type] = [];
                    }
                    groupedKisi[item.taksonomi_bloom][item.type].push(item);
                });

                // Create the structure for the modal
                kisiHtml += `<div class="container">`;

                // Create two columns: one for Kognitif, one for Afektif
                kisiHtml += `<div class="row">`;

                // Left Column (Kognitif)
                kisiHtml += `<div class="col-md-6">`;
                if (groupedKisi["Kognitif"]) {
                    kisiHtml += `<div class="accordion" id="kognitifAccordion">`;

                    // Display taksonomi_bloom label for Kognitif
                    kisiHtml += `<h5 class="mb-3">Kognitif</h5>`;
                    
                    Object.keys(groupedKisi["Kognitif"]).forEach(type => {
                        kisiHtml += `
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-${type}">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-${type}" aria-expanded="true" aria-controls="collapse-${type}">
                                        ${type}
                                    </button>
                                </h2>
                                <div id="collapse-${type}" class="accordion-collapse collapse" aria-labelledby="heading-${type}" data-bs-parent="#kognitifAccordion">
                                    <div class="accordion-body">
                        `;

                        groupedKisi["Kognitif"][type].forEach(item => {
                            kisiHtml += `
                                <div class="mb-3">
                                    <p class="font-weight-bold text-muted">${item.type}</p>
                                    <p>${item.kisi_kisi}</p>
                                </div>
                            `;
                        });

                        kisiHtml += `</div></div></div>`;
                    });

                    kisiHtml += `</div>`; // End of Kognitif Accordion
                }
                kisiHtml += `</div>`; // End of Left Column (Kognitif)

                // Right Column (Afektif)
                kisiHtml += `<div class="col-md-6">`;
                if (groupedKisi["Afektif"]) {
                    kisiHtml += `<div class="accordion" id="afektifAccordion">`;

                    // Display taksonomi_bloom label for Afektif
                    kisiHtml += `<h5 class="mb-3">Afektif</h5>`;
                    
                    Object.keys(groupedKisi["Afektif"]).forEach(type => {
                        kisiHtml += `
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-${type}">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-${type}" aria-expanded="true" aria-controls="collapse-${type}">
                                        ${type}
                                    </button>
                                </h2>
                                <div id="collapse-${type}" class="accordion-collapse collapse" aria-labelledby="heading-${type}" data-bs-parent="#afektifAccordion">
                                    <div class="accordion-body">
                        `;

                        groupedKisi["Afektif"][type].forEach(item => {
                            kisiHtml += `
                                <div class="mb-3">
                                    <p class="font-weight-bold text-muted">${item.type}</p>
                                    <p>${item.kisi_kisi}</p>
                                </div>
                            `;
                        });

                        kisiHtml += `</div></div></div>`;
                    });

                    kisiHtml += `</div>`; // End of Afektif Accordion
                }
                kisiHtml += `</div>`; // End of Right Column (Afektif)

                kisiHtml += `</div>`; // End of Row

                kisiHtml += `</div>`; // End of Container

            } else {
                alert('Gagal mengambil data. Coba lagi.');
            }
        }).fail(function() {
            alert('Terjadi kesalahan dalam mengambil data meeting.');
        }).always(function() {
            // Ensure the modal content is updated after the request completes (whether success or failure)
            $('#modal-content').html(kisiHtml);

            // Show the modal
            $('#modal-form').modal('show');
        });
    }

    $(document).ready(fetchMeetings);
</script>
@endpush