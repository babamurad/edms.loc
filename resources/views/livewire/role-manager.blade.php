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
    </div>
</div>
