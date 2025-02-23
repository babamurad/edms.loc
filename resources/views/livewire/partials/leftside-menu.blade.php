<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <a href="index.html" class="logo logo-light">
        <span class="logo-lg">
            <img src="assets/images/logo.png" alt="logo">
        </span>
        <span class="logo-sm">
            <img src="assets/images/logo-sm.png" alt="small logo">
        </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="index.html" class="logo logo-dark">
        <span class="logo-lg">
            <img src="assets/images/logo-dark.png" alt="dark logo">
        </span>
        <span class="logo-sm">
            <img src="assets/images/logo-sm.png" alt="small logo">
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
                    <span> Dashboard </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('department') }}" class="side-nav-link {{ request()->is('department') ? 'active' : '' }}">
                    <i class="ri-archive-drawer-fill"></i>
                    <span> {{ __('Departments') }} </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{ route('category') }}" class="side-nav-link {{ request()->is('category') ? 'active' : '' }}">
                    <i class="ri-briefcase-line"></i>
                    <span> {{ __('Category') }} </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{ route('documents') }}" class="side-nav-link {{ request()->is('documents') ? 'active' : '' }}">
                    <i class="ri-file-list-fill"></i>
                    <span> {{ __('Documents') }} </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{ route('documents.inbox') }}" class="side-nav-link">
                    <i class="bi bi-inbox"></i>
                    <span>Inbox</span>
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
                <a href="{{ route('role-manager') }}" class="side-nav-link {{ request()->is('role-manager') ? 'active' : '' }}">
                    <i class="ri-user-settings-fill"></i>
                    <span> {{ __('Roles Manager') }} </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{ route('user-manager') }}" class="side-nav-link {{ request()->is('user-manager') ? 'active' : '' }}">
                    <i class="ri-team-fill"></i>
                    <span> {{ __('User Manager') }} </span>
                </a>
            </li>

        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>
