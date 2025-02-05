<div class="row" x-data="{showModal: false}">
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
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
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
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($departments as $department)

                    <tr>
                        <td>{{ $department->id }}</td>
                        <td>{{ $department->title }}</td>
                        <td><span class="badge bg-primary">{{ $department->slug }}</span></td>
                        <td>{{ $department->description }}</td>
                        <td>
                            <a type="button" href="{{ route('department.edit', ['id' => $department->id]) }}" class="btn btn-sm btn-success" style="float: none;"><span class="mdi mdi-pencil"></span></a>
                            <button type="button" class="btn btn-sm btn-danger" style="float: none;" x-on:click="showModal = !showModal" wire:click="delete({{ $department->id }})"><i class="bi bi-trash-fill"></i></button>
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
            <!-- Top modal content -->

        </div> <!-- end card body-->
    </div>

    <div id="top-modal" class="modal fade"
         :class="showModal ? 'show' : ''"
         :style="{ display: showModal ? 'block' : 'none' }"
         x-show="showModal">
        <div class="modal-dialog modal-top">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="topModalLabel">Modal Heading</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>Text in a modal</h5>
                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div x-data="{ open: false }">
        <button x-on:click="open = ! open">Toggle Dropdown</button>

        <div x-show="open">
            Dropdown Contents...
        </div>
    </div>
</div>

