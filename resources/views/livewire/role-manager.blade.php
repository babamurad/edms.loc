<div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4>Управление ролями</h4>
                <button class="btn btn-primary" wire:click="$set('showCreateModal', true)">
                    Создать роль
                </button>
            </div>
        </div>
        <div class="card-body">
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

            <h5>Выберите пользователя</h5>
            <livewire:components.custom-select 
                :options="$userOptions"
                :selected="$selectedUser"
                placeholder="Выберите пользователя..."
                wire:key="user-select" />

            <select wire:model="selectedRole" class="form-control mt-2">
                <option value="">Выберите роль</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>

            <button wire:click="assignRole" class="btn btn-primary mt-2">Назначить роль</button>

            <!-- Модальное окно создания роли -->
            @if($showCreateModal)
                <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Создать новую роль</h5>
                                <button type="button" class="btn-close" wire:click="$set('showCreateModal', false)"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Название роли</label>
                                    <input type="text" class="form-control @error('newRoleName') is-invalid @enderror" 
                                           wire:model="newRoleName">
                                    @error('newRoleName')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" wire:click="$set('showCreateModal', false)">
                                    Отмена
                                </button>
                                <button type="button" class="btn btn-primary" wire:click="createRole">
                                    Создать
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@php
$categories = App\Models\Category::all()->map(function($category) {
    return [
        'value' => $category->id,
        'label' => $category->title
    ];
});
$selectedCat = null;
@endphp
    <livewire:components.custom-select 
                :options="$categories"
                :selected="$selectedUser"
                placeholder="Выберите category..."
                wire:key="user-select" />
</div>
