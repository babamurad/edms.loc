<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <a href="/" class="logo logo-light">
        <span class="logo-lg">
            <img src="{{ asset('assets/images/logo-sm.png') }}" alt="logo">
            <span class="text-white ms-1 fs-20">Häkimlik</span>
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo">
        </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="/" class="logo logo-dark">
        <span class="logo-lg">
            <img src="{{ asset('assets/images/logo-sm.png') }}" alt="dark logo">
            <span class="text-white ms-1 fs-20">Hakimlik</span>
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo">
        </span>
    </a>

    <!-- Sidebar -left -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title">Main</li>

            <li class="side-nav-item">
                <a href="{{ route('home') }}" class="side-nav-link  {{ request()->is('/') ? 'active' : '' }}">
                    <i class="ri-dashboard-3-line"></i>
                    <span> {{ __('Dashboard') }} </span>
                </a>
            </li>
            @if (auth()->user()->hasRole('admin'))
             <li class="side-nav-item {{ request()->routeIs('department') || request()->routeIs('department.create') || request()->routeIs('department.edit') ? 'menuitem-active' : '' }}">
                <a href="{{ route('department') }}" class="side-nav-link {{ request()->routeIs('department') || request()->routeIs('department.create') || request()->routeIs('department.edit') ? 'active' : '' }}">
                    <i class="ri-archive-drawer-fill"></i>
                    <span> {{ __('Departments') }} </span>
                </a>
            </li>
            <li class="side-nav-item {{ request()->routeIs('category') || request()->routeIs('category.create') || request()->routeIs("category.edit") ? 'menuitem-active' : '' }}">
                <a href="{{ route('category') }}" class="side-nav-link">
                    <i class="ri-briefcase-line"></i>
                    <span> {{ __('Category') }} </span>
                </a>
            </li>
            <li class="side-nav-item @if(request()->routeIs('role-manager')) menuitem-active @endif">
                <a href="{{ route('role-manager') }}" class="side-nav-link">
                    <i class="ri-user-settings-fill"></i>
                    <span> {{ __('Role Manager') }} </span>
                </a>
            </li>
            <li class="side-nav-item {{ request()->routeIs('user-manager') || request()->routeIs('user.create') || request()->routeIs('user.edit') ? 'menuitem-active' : '' }}">
                <a href="{{ route('user-manager') }}" class="side-nav-link {{ request()->routeIs('user-manager') || request()->routeIs('user.create') || request()->routeIs('user.edit') ? 'active' : '' }}">
                    <i class="ri-team-fill"></i>
                    <span> {{ __('User Manager') }} </span>
                </a>
            </li>   
            @endif

            <li class="side-nav-item">
                <a href="{{ route('documents.upload') }}" 
                   class="side-nav-link {{ request()->routeIs('documents.upload') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-plus"></i>
                    <span> {{ __('Create Document') }} </span>
                </a>
            </li>
            
            <li class="side-nav-item">
                <a href="{{ route('documents') }}" 
                   class="side-nav-link {{ request()->routeIs('documents') ? 'active' : '' }}">
                    <i class="ri-file-list-fill"></i>
                    <span> {{ __('Documents') }} </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('documents.inbox') }}" class="side-nav-link {{ request()->routeIs('documents.inbox') ? 'active' : '' }}">
                    <i class="bi bi-inbox"></i>
                    <span>{{ __('Inbox') }}</span>
                    @php
                        $unreadCount = \App\Models\DocumentShare::where('recipient_id', auth()->id())
                            ->whereNull('read_at')
                            ->count();
                    @endphp
                    @if($unreadCount > 0)
                        <span class="badge bg-danger rounded-pill">{{ $unreadCount }}</span>
                    @endif
                </a>
            </li>
            
            <li class="side-nav-item">
                <a href="{{ route('documents.outbox') }}" class="side-nav-link {{ request()->routeIs('documents.outbox') ? 'active' : '' }}">
                    <i class="bi bi-send"></i>
                    <span>{{ __('Outbox') }}</span>
                </a>
            </li>

        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>
