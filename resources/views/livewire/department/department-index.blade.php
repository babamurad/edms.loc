<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Velonic</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                    <li class="breadcrumb-item active">Starter</li>
                </ol>
            </div>
            <h4 class="page-title">{{ __('Departments') }}</h4>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex  justify-content-between">
                <h4 class="header-title">{{ __('Departments List') }}</h4>
                <a href="{{ route('department.create') }}" type="button" class="btn btn-primary">Create</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive-sm">
                <table class="table table-hover table-centered mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($departments as $department)
                        
                    <tr>
                        <td>Lightweight Jacket</td>
                        <td>$20.00</td>
                        <td><span class="badge bg-primary">184 Pcs</span></td>
                        <td>$3,680.00</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-success" style="float: none;"><span class="mdi mdi-pencil"></span></button>
                            <button type="button" class="btn btn-sm btn-danger" style="float: none;"><span class="mdi mdi-pencil"></span></button>
                        </td>
                    </tr>
                    @endforeach

                    </tbody>
                </table>
                @if(!$departments)
                <p>No items found.</p>
                @else
                {{ $departments->links() }}
                @endif
            </div> <!-- end table-responsive-->

        </div> <!-- end card body-->
    </div>
</div>

