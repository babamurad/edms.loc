<div class="row">
    <x-slot name="title">{{ __('Create Category') }}</x-slot>
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Velonic</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                    <li class="breadcrumb-item active">Starter</li>
                </ol>
            </div>
            <h4 class="page-title">{{ __('Create Category') }}</h4>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex  justify-content-between">
                <h4 class="header-title">{{ __('Create Category') }}</h4>
                <div class="justify-content-right">
                    <button type="button" class="btn btn-primary" wire:click="create">{{ __('Save') }}</button>
                    <a type="button" href="{{ route('category') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form class="needs-validation" wire:submit.prevent="create">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="validationCustom01">{{ __('Title') }}</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="validationCustom01" placeholder="Title" wire:model="title" wire:keyup="generateSlug()">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="validationCustom02">{{ __('Slug') }}</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="validationCustom02" wire:model="slug">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="example-select" class="form-label">{{ __('Select Department') }}</label>
                            <select class="form-select" wire:model="departmentId">
                                @foreach($departments as $department)
                                    <option wire:key="{{ $department->id }}" value="{{ $department->id }}">{{ $department->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="example-textarea" class="form-label">{{ __('Description') }}</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="example-textarea" rows="5" wire:model="description"></textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <button class="btn btn-primary" type="submit">{{__('Save')}}</button>
                <a type="button" href="{{ route('category') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
            </form>

        </div> <!-- end card body-->
    </div>
</div>


