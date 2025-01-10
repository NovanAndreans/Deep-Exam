<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="index.html" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>DASHMIN</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="{{$pp ?? asset('Admin/img/user.jpg')}}" alt=""
                    style="width: 40px; height: 40px;">
                <div
                    class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                </div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">{{Auth::user()->name}}</h6>
                <span>{{myType(Auth::user()->role_id)}}</span>
            </div>
        </div>
        <div class="navbar-nav w-100">

            @foreach ($menus as $item)
            @php
            $hasParentViewFeature = false;
            // Periksa jika `features` adalah array dan cari `featslug` dengan nilai 'view'
            if (count($item->features) > 0) {
            foreach ($item->features as $feature) {
            if ($feature['featslug'] == 'view') {
            foreach ($feature->permissions as $permission) {
            if ($permission->permisfeatid == $feature->id) {
            $hasParentViewFeature = $permission->hasaccess;
            break;
            }
            }
            }
            }
            }
            @endphp
            @if (count($item->children) == 0 && $hasParentViewFeature)
            <a href="{{ route($item->menuroute) }}" class="nav-item nav-link {{ activeMenu($item->menuroute) }}"><i
                    class="{{$item->menuicon ?? 'fa fa-question'}}"></i>{{$item->menunm}}</a>
            @else
            @php
            $hasParentViewFeature = false;
            // Periksa jika `features` adalah array dan cari `featslug` dengan nilai 'view'
            if (count($item->features) > 0) {
            foreach ($item->features as $feature) {
            if ($feature['featslug'] == 'view') {
            foreach ($feature->permissions as $permission) {
            if ($permission->permisfeatid == $feature->id) {
            $hasParentViewFeature = $permission->hasaccess;
            break;
            }
            }
            }
            }
            }
            @endphp
            @if ($hasParentViewFeature)
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle {{ activeParentMenu($item->menunm) }}"
                    data-bs-toggle="dropdown" aria-expanded="{{ activeParentMenuExpand($item->menunm) }}"><i class="{{$item->menuicon}}"></i>{{$item->menunm}}</a>
                <div class="dropdown-menu bg-transparent border-0 {{ activeParentMenuExpanded($item->menunm) }}">
                    @if (!empty($item->children) && count($item->children) > 0)
                    @foreach ($item->children as $child)
                    @php
                    $hasViewFeature = false;
                    // Periksa jika `features` adalah array dan cari `featslug` dengan nilai 'view'
                    if (count($child->features) > 0) {
                    foreach ($child->features as $feature) {
                    if ($feature['featslug'] == 'view') {
                    foreach ($feature->permissions as $permission) {
                    if ($permission->permisfeatid == $feature->id) {
                    $hasViewFeature = $permission->hasaccess;
                    break;
                    }
                    }
                    }
                    }
                    }
                    @endphp
                    @if ($hasViewFeature)
                    <a href="{{ route($child->menuroute) }}" class="dropdown-item {{ activeMenu($child->menuroute) }}"> <i
                            class="me-3 {{$child->menuicon ?? 'fa fa-question'}}"></i>{{$child->menunm}}</a>
                    @endif
                    @endforeach
                    @endif
                </div>
            </div>
            @endif
            @endif
            @endforeach
        </div>
    </nav>
</div>
<!-- Sidebar End -->