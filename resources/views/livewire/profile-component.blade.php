<div class="row" x-data="{isEdit: @entangle('isEdit')}">
    <x-slot name="title">{{ __('Profile') }}</x-slot>
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('DMS') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Profile') }}</li>
                </ol>
            </div>
            <h4 class="page-title">{{ __('Profile') }}</h4>
            @include('livewire.partials.alerts')
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex  justify-content-between">
                <h4 class="header-title">{{ __('Profile') }}</h4>
                <div>
                    <button type="button" :class="isEdit ? 'btn btn-secondary' : 'btn btn-primary'" @click='isEdit = !isEdit'>
                        <i class="ri-edit-line me-1 fs-16 lh-1" x-show="!isEdit"></i>
                        <i class="ri-delete-back-2-line me-1 fs-16 lh-1" x-show="isEdit"></i>
                        <span x-text="isEdit ? '{{ __('Cancel') }}' : '{{ __('Edit') }}'"></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="profile-desk">

                <h5 class="mt-4 fs-17 text-dark">{{ __('Contact Information') }}</h5>

                <div class="row" x-show="!isEdit">
                    <div class="col-sm-4">
                        @if(auth()->user()->avatar)
                        <img class="img-fluid w-80 rounded" src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="">
                        @else
                        <img class="img-fluid w-80 rounded" src="{{ asset('assets/images/avatar-1.png') }}" alt="">
                        @endif
                    </div>
                    <div class="col-sm-8">
                        <table class="table table-condensed mb-0 border-top">
                            <tbody>
                                <tr>
                                    <th scope="row">{{ __('Name') }}</th>
                                    <td>
                                        {{ $name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('Email') }}</th>
                                    <td>
                                        {{ $email }}
                                    </td>
                                </tr>
        
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="user-profile-content" x-show="isEdit">
                    <form wire:submit.prevent="save">
                        <div class="row row-cols-sm-2 row-cols-1">
                            <div class="col-sm-4">
                                <div class="col-mb-12">
                                    <div wire:loading wire:target="newavatar" class="position-absolute top-50 start-50 translate-middle">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">{{ __('Loading...') }}</span>
                                        </div>
                                    </div>
                                    
                                    <div wire:loading.remove wire:target="newavatar">
                                        @if ($newavatar)
                                            <img class="img-fluid w-80" src="{{ $newavatar->temporaryUrl() }}" alt="{{ auth()->user()->name }}">
                                        @elseif(auth()->user()->avatar)
                                            <img class="img-fluid w-80" src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}">
                                        @else
                                            <img class="img-fluid w-80" src="{{ asset('assets/images/avatar-1.png') }}" alt="">
                                        @endif
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-sm-8">
                                <div class="mb-12">
                                    <label class="form-label" for="FullName">{{ __('Full Name') }}</label>
                                    <input type="text" wire:model="name" id="FullName" class="form-control">
                                </div>
                                <div class="mb-12">
                                    <label class="form-label" for="Email">{{ __('Email') }}</label>
                                    <input type="email" wire:model="email" id="Email" class="form-control">
                                </div>                            
                                <div class="mb-12">
                                    <label class="form-label" for="Password">{{ __('Password') }}</label>
                                    <input type="password" placeholder="{{ __('6 - 15 Characters') }}" id="Password" class="form-control">                                
                                    <span class="fs-13 text-muted">{{ __('Leave empty if you don\'t want to change') }}</span>
                                </div>
                                <div class="mb-12">
                                    <label class="form-label" for="RePassword">{{ __('Re-Password') }}</label>
                                    <input type="password" placeholder="{{ __('6 - 15 Characters') }}" id="RePassword" class="form-control">
                                </div>
                                <div class="col-md-12 mt-3">
                                    <i class="mdi mdi-camera mr-1"></i>
                                    <label class="form-label">{{ __('File input') }}</label>
                                    <input class="form-control" type="file" wire:model.live="newavatar" wire:change="saveNewAvatar">
                                    @error('newavatar')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="pt-2">
                                    <button type="submit" class="btn btn-primary"><i class="ri-save-line me-1 fs-16 lh-1"></i> {{ __('Save') }}</button>
                                    <button type="button" class="btn btn-secondary" x-show="isEdit" @click="isEdit = false">
                                        <i class="ri-delete-back-2-line me-1 fs-16 lh-1"></i>{{ __('Cancel') }}
                                    </button>
                                </div>
                            </div>
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
