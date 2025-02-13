<div class="row" x-data="{delId: @entangle('delId'), showModal: @entangle('showModal')}">
    <x-slot name="title">{{ __('Documents') }}</x-slot>
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Velonic</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                    <li class="breadcrumb-item active">Starter</li>
                </ol>
            </div>
            <h4 class="page-title">{{ __('Documents') }}</h4>
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
            <div class="row">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="header-title">{{ __('Documents List') }}</h4>
                    <div>
{{--                        <a href="{{ route('documents.create') }}" type="button" class="btn btn-primary">{{ __('Create') }}</a>--}}
                        <a href="{{ route('documents.upload') }}" type="button" class="btn btn-primary">{{ __('Upload') }}</a>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive-sm">
                <table class="table table-hover table-centered mb-0">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Department</th>
                        <th>Slug</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($documents as $document)
                        <tr @wire:key="{{ $this->delId }}">
                            <td>{{ $document->id }}</td>
                            <td><a href="{{ route('category.edit', ['id' => $document->id]) }}">{{ $document->title }}</a></td>
                            <td><span class="badge bg-primary">{{ @$document->department->title }}</span></td>
                            <td>{{ $document->slug }}</td>
                            <td>
                                <a type="button" href="{{ route('documents.edit', ['id' => $document->id]) }}" class="btn btn-sm btn-success" style="float: none;"><span class="mdi mdi-pencil"></span></a>
                                <button type="button" class="btn btn-sm btn-danger" style="float: none;"
                                        {{--                                        data-bs-toggle="modal" data-bs-target="#ConfirmDelete" --}}

                                        @click="showModal = true, delId={{ $document->id }}">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                @if(!$documents)
                    <p>No items found.</p>
                @else
                    {{ $documents->links() }}
                @endif
            </div> <!-- end table-responsive-->
            <!-- Top modal content -->

        </div> <!-- end card body-->
    </div>

    <div x-show="showModal" class="modal-backdrop" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);"></div>
    <!-- Modal -->
    <div class="fade modal"
         :class="{ 'show': showModal }"
         :style="{ display: showModal ? 'block' : 'none' }"
         x-show="showModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @wire:key="{{ $delId }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('Delete confirm')}}</h5>
                    <button type="button" class="btn-close" @click="showModal = false" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Are you sure you want to delete?') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="showModal = false">{{__('No')}}</button>
                    <button type="button" class="btn btn-danger" @click="showModal = false; $wire.destroy()">{{__('Yes')}}</button>
                </div>
            </div>
        </div>
    </div>

</div>
