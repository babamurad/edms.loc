<div>
    <div class="card">
        <div class="card-header">
            <h4>Управление ролями</h4>
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
                    <h5>Выберите пользователя</h5>
                    <livewire:components.custom-select 
                        :options="$userOptions"
                        :selected="$selectedUser"
                        placeholder="Выберите пользователя..."
                        wire:key="user-select" />

                    <select wire:model.live="selectedRole" class="form-control mt-2">
                        <option value="">Выберите роль</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>

                    <button wire:click="assignRole" class="btn btn-primary mt-2">Назначить роль</button>
                </div>

                <div class="col-md-6">
                    @if($selectedUser)
                        <h5>Текущие роли пользователя</h5>
                        @if(count($userRoles) > 0)
                            <div class="list-group">
                                @foreach($userRoles as $role)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $role->name }}
                                        <button wire:click="removeRole({{ $role->id }})" 
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Вы уверены, что хотите удалить эту роль?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info">
                                У пользователя нет назначенных ролей
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
