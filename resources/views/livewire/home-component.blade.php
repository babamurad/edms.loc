<div>
    <x-slot name="title">Document Managment System</x-slot>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Velonic</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                    <li class="breadcrumb-item active">Welcome!</li>
                </ol>
            </div>
            <h4 class="page-title">Document Managment System</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xxl-3 col-sm-6">
        <div class="card widget-flat text-bg-pink">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-building-2-line widget-icon"></i>
                </div>
                <h6 class="text-uppercase mt-0" title="Departments">Departments</h6>
                <h2 class="my-2">{{ $departments }}</h2>
            </div>
        </div>
    </div> <!-- end col-->

    <div class="col-xxl-3 col-sm-6">
        <div class="card widget-flat text-bg-purple">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-folder-2-line widget-icon"></i>
                </div>
                <h6 class="text-uppercase mt-0" title="Categories">Categories</h6>
                <h2 class="my-2">{{ $categories }}</h2>
            </div>
        </div>
    </div> <!-- end col-->

    <div class="col-xxl-3 col-sm-6">
        <div class="card widget-flat text-bg-info">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-file-list-3-line widget-icon"></i>
                </div>
                <h6 class="text-uppercase mt-0" title="Documents">Documents</h6>
                <h2 class="my-2">{{ $documents }}</h2>
            </div>
        </div>
    </div> <!-- end col-->

    <div class="col-xxl-3 col-sm-6">
        <div class="card widget-flat text-bg-primary">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-team-line widget-icon"></i>
                </div>
                <h6 class="text-uppercase mt-0" title="Users">Users</h6>
                <h2 class="my-2">{{ $users }}</h2>
            </div>
        </div>
    </div> <!-- end col-->
</div>
</div>
@push('apex-chart')
<!-- Apex Charts js -->
<script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
<!-- Dashboard App js -->
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush
