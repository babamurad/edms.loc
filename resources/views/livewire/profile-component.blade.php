<div class="row" x-data="{isEdit: @entangle('isEdit')}">
    <x-slot name="title">{{ __('Profile') }}</x-slot>
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Velonic</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                    <li class="breadcrumb-item active">Starter</li>
                </ol>
            </div>
            <h4 class="page-title">{{ __('Categories') }}</h4>
            @include('livewire.partials.alerts')
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex  justify-content-between">
                <h4 class="header-title">{{ __('Profile') }}</h4>
                <button type="button" class="btn btn-primary" @click='isEdit = !isEdit'>
                    <span x-text="isEdit ? 'Сохранить' : 'Редактировать'"></span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="profile-desk">

                <h5 class="mt-4 fs-17 text-dark">Contact Information</h5>

                <table class="table table-condensed mb-0 border-top" x-show="!isEdit">
                    <tbody>
                        <tr>
                            <th scope="row">Name</th>
                            <td>
                                {{ $name }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Email</th>
                            <td>
                                {{ $email }}
                            </td>
                        </tr>

                    </tbody>
                </table>

                <div class="user-profile-content" x-show="isEdit">
                    <form wire:submit.prevent="save">
                        <div class="row row-cols-sm-2 row-cols-1">
                            <div class="mb-2">
                                <label class="form-label" for="FullName">Full Name</label>
                                <input type="text" wire:model="name" id="FullName" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="Email">Email</label>
                                <input type="email" wire:model="email" id="Email" class="form-control">
                            </div>                            
                            <div class="mb-3">
                                <label class="form-label" for="Password">Password</label>
                                <input type="password" placeholder="6 - 15 Characters" id="Password" class="form-control">                                
                                <span class="fs-13 text-muted">Оставьте пустым если не хотите изменить</span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="RePassword">Re-Password</label>
                                <input type="password" placeholder="6 - 15 Characters" id="RePassword" class="form-control">
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit"><i class="ri-save-line me-1 fs-16 lh-1"></i> Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
