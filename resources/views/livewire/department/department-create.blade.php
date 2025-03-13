<div class="row">
    <x-slot name="title">{{ __('Create Department') }}</x-slot>
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('department') }}">{{ __('Departments') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Create') }}</li>
                </ol>
            </div>
            <h4 class="page-title">{{ __('Create Department') }}</h4>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex  justify-content-between">
                <h4 class="header-title">{{ __('Create Department') }}</h4>
                <div class="justify-content-right">
                    <button type="button" class="btn btn-primary" wire:click="create">{{ __('Save') }}</button>
                    <a type="button" href="{{ route('department') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form class="needs-validation" wire:submit.prevent="create">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="validationCustom01">{{ __('Title') }}</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="validationCustom01" placeholder="{{ __('Title') }}" wire:model="title" wire:keyup="generateSlug()">
                            <div class="valid-feedback">
                                {{ __('Looks good!') }}
                            </div>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="validationCustom02">{{ __('Slug') }}</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="validationCustom02" wire:model="slug">
                            <div class="valid-feedback">
                                {{ __('Looks good!') }}
                            </div>
                            @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="example-textarea" class="form-label">{{ __('Description') }}</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="example-textarea" rows="5" wire:model="description"></textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <button class="btn btn-primary" type="submit">{{__('Save')}}</button>
                <a type="button" href="{{ route('department') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
            </form>

        </div> <!-- end card body-->
    </div>
</div>


