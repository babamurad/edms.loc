<div class="card">
        <form wire:submit.prevent="saveDocument">
            @csrf
        <div class="card-header">
            <h4 class="header-title">Document</h4>
        </div>
        <div class="card-body" x-data="{ activeTab: 'attributes', contentDocs: '' }">

            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="title" class="form-label">{{ __('Title') }}</label>
                        <input type="text" id="title" class="form-control" wire:model="title" wire:keyup="generateSlug()">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="slug" class="form-label">{{ __('Slug') }}</label>
                        <input type="text" id="slug" class="form-control" wire:model="slug">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="department" class="form-label">{{ __('Departments') }}</label>
                        <select class="form-select" id="department" wire:model="selectedDepartment">
                            <option value="" selected>{{ __('Select an department') }}</option>
                            @foreach($departments as $department)
                                <option wire:key="{{ $department->id }}" value="{{ $department->id }}">{{ $department->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="category" class="form-label">{{ __('Categories') }}</label>
                        <select class="form-select" id="category" wire:model="selectedCategory">
                            <option value="" selected>{{ __('Select an category') }}</option>
                            @foreach($categories as $category)
                                <option wire:key="{{ $category->id }}" value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="category" class="form-label">{{ __('Statuses') }}</label>
                        <select class="form-select" id="category" wire:model="selectedStatus">
                            <option value="" selected>{{ __('Select an status') }}</option>
                            @foreach($statuses as $status)
                                <option wire:key="{{ $status->id }}" value="{{ $status->id }}">{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="mb-3">
                                <label for="example-fileinput" class="form-label">Default file
                                    input</label>
                                <input type="file" id="example-fileinput" class="form-control" wire:model="file">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <div class="form-check form-switch my-4">
                                    <input type="checkbox" class="form-check-input" id="customSwitch1" style="cursor: pointer;">
                                    <label class="form-check-label" for="customSwitch1" style="cursor: pointer;">{{ __('Published') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save me-1"></i>{{ __('Save') }}</button>
            <a href="{{ route('documents') }}" type="button" class="btn btn-secondary"><i class="mdi mdi-cancel me-1"></i>{{ __('Cancel') }}</a>
        </div>
    </form>

</div>
