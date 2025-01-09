@extends('Templates.admin')

@section('title', 'Setting Permissions')

@section('content-header')
    <h1>Setting Permissions</h1>
    @php
        $hasAddFeature = false;
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
        }
    @endphp
@endsection

@section('content')
<div class="card p-3">
    <div class="card-header">
        <h4>{{ $roleActive }}</h4>
        <div class="card-header-form">
            <form method="GET" action="{{ route('permissions.index') }}">
                <select class="form-select" name="role" onchange="this.form.submit()">
                    @if ($roleActiveId)
                        <option value="{{ Crypt::encryptString($roleActiveId) }}">{{ $roleActive }}</option>
                    @endif
                    @foreach ($roles as $item)
                        @if ($item->id != $roleActiveId)
                            <option value="{{ Crypt::encryptString($item->id) }}">{{ $item->name }}</option>
                        @endif
                    @endforeach
                </select>
            </form>
        </div>
    </div>
    <div class="card-body p-0 row">
        @php $i = 0; @endphp
        @foreach ($menus as $item)
            @php $i++; @endphp
            <div class="col-12 py-3 row" style="background-color: {{ $i % 2 == 0 ? '#f0f0f0' : 'transparent' }}">
                <div class="col-2">
                    {{ $item->menunm }}
                </div>
                @foreach ($item->features as $feature)
                    <div class="col-2">
                        {{ $feature->feattitle }}
                        @php
                            $isChecked = false;
                            foreach ($data as $dataItem) {
                                if ($feature->id == $dataItem->permisfeatid) {
                                    $isChecked = true;
                                    break;
                                }
                            }
                        @endphp
                        <form id="permission-form" class="form-check form-switch" action="{{ route('permission.toggle') }}" method="post">
                            @csrf
                            <input type="checkbox" 
                                class="form-check-input" 
                                style="width: 15px; height: 15px; background-color: {{ $isChecked ? '#1089ff' : '#ff4d4d' }};" 
                                name="features[]" 
                                value="{{ $feature->id }}"
                                role="switch" 
                                {{ $isChecked ? 'checked' : '' }}
                                onchange="togglePermission(this)"  data-bs-toggle="tooltip" data-bs-placement="bottom" title={{ $isChecked ? 'Disallow' : 'Allow' }}>
                            <input type="hidden" name="role" value="{{ $roleActiveId }}">
                        </form>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
@endsection

@push('script')
<script>
    function togglePermission(checkbox) {
        const hasAddFeature = {{ isset($hasAddFeature) ? json_encode($hasAddFeature) : 'null' }};
        if (!hasAddFeature) {
            Swal.fire({
                title: 'Tidak Memiliki Akses',
                text: 'Anda tidak memiliki akses untuk menambahkan data',
                icon: 'error',
            });
            checkbox.checked = !checkbox.checked; // Revert the checkbox state
            return;
        }

        var form = $('#permission-form');
        var url = form.attr('action');
        var role = form.find('input[name="role"]').val();
        var feature = $(checkbox).val();
        var isChecked = checkbox.checked;

        // Update the checkbox color dynamically
        checkbox.style.backgroundColor = isChecked ? '#1089ff' : '#ff4d4d';

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                role: role,
                feature: feature,
                is_checked: isChecked
            },
            success: function(response) {
                if (response.success) {
                    setSuccess(response.message);
                } else {
                    setSuccess('Error: ' + response.message);
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                setSuccess('An error occurred.');
            }
        });
    }
</script>
@endpush
