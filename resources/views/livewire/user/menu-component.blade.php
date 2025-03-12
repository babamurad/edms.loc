<li class="dropdown">
    <a class="nav-link dropdown-toggle arrow-none nav-user" data-bs-toggle="dropdown" href="#" role="button"
        aria-haspopup="false" aria-expanded="false">
        <span class="account-user-avatar">
            @if(auth()->user()->avatar)
                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="user-image" width="32" class="rounded-circle">
            @else
                <img src="{{ asset('assets/images/avatar-1.png') }}" alt="user-image" width="32" class="rounded-circle">
            @endif
        </span>
        <span class="d-lg-block d-none">
            <h5 class="my-0 fw-normal">{{ auth()->user()->name?? 'Name' }} <i
                    class="ri-arrow-down-s-line d-none d-sm-inline-block align-middle"></i></h5>
        </span>
    </a>
    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
        <!-- item-->
        <div class=" dropdown-header noti-title">
            <h6 class="text-overflow m-0">Welcome !</h6>
        </div>

        <!-- item-->
        <a href="{{ route('profile') }}" class="dropdown-item">
            <i class="ri-account-circle-line fs-18 align-middle me-1"></i>
            <span>My Account</span>
        </a>

        {{-- <!-- item-->
        <a href="pages-faq.html" class="dropdown-item">
            <i class="ri-customer-service-2-line fs-18 align-middle me-1"></i>
            <span>Support</span>
        </a>

        <!-- item-->
        <a href="auth-lock-screen.html" class="dropdown-item">
            <i class="ri-lock-password-line fs-18 align-middle me-1"></i>
            <span>Lock Screen</span>
        </a> --}}

        <!-- item-->
        <a href="#" class="dropdown-item" wire:click="logout">
            <i class="ri-logout-box-line fs-18 align-middle me-1"></i>
            <span>Logout</span>
        </a>
    </div>
</li>
