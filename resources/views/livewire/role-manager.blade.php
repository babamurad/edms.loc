<div>
    <div class="card">
        <div class="card-header">
            <h4>{{ __('Role Management') }}</h4>
        </div>
        <div class="card-body">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <h5>{{ __('Select a user') }}</h5>
                    <livewire:components.custom-select 
                        :options="$userOptions"
                        :selected="$selectedUser"
                        placeholder="{{ __('Select a user...') }}"
                        wire:key="user-select" />

                    <select wire:model.live="selectedRole" class="form-control mt-2">
                        <option value="">{{ __('Select a role') }}</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>

                    <button wire:click="assignRole" class="btn btn-primary mt-2">{{ __('Assign role') }}</button>
                </div>

                <div class="col-md-6">
                    @if($selectedUser)
                        <h5>{{ __('Current user roles') }}</h5>
                        @if(count($userRoles) > 0)
                            <div class="list-group">
                                @foreach($userRoles as $role)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $role->name }}
                                        <button wire:click="removeRole({{ $role->id }})" 
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('{{ __('Are you sure you want to remove this role?') }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info">
                                {{ __('User has no assigned roles') }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
