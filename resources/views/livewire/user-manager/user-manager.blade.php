<div class="row" x-data="{delId: @entangle('delId'), showModal: @entangle('showModal')}">
    <x-slot name="title">{{ __('Users') }}</x-slot>
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Velonic</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </div>
            <h4 class="page-title">{{ __('Users') }}</h4>
            @include('livewire.partials.alerts')
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="header-title">{{ __('Users List') }}</h4>
                <a href="{{ route('user.create') }}" type="button" class="btn btn-primary">Create</a>
            </div>
        </div>
        <div class="card-body">
            <!-- Добавляем панель поиска и фильтрации -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <input 
                            wire:model.live="search" 
                            type="text" 
                            class="form-control" 
                            placeholder="Search by name or email..."
                        >
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                    </div>
                </div>
                <div class="col-md-4">
                    <select wire:model.live="selectedDepartment" class="form-select">
                        <option value="">All Departments</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select wire:model.live="perPage" class="form-select">
                        <option value="8">8 per page</option>
                        <option value="15">15 per page</option>
                        <option value="25">25 per page</option>
                        <option value="50">50 per page</option>
                    </select>
                </div>
            </div>

            <!-- Существующая таблица -->
            <div class="table-responsive-sm">
                <table class="table table-hover table-centered mb-0">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Roles</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr wire:key="{{ $user->id }}">
                            <td>{{ $user->id }}</td>
                            <td><a href="{{ route('user.edit', $user->id) }}">{{ $user->name }}</a></td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->department)
                                    <span class="badge bg-primary">{{ $user->department->title }}</span>
                                @else
                                    <span class="badge bg-secondary">No Department</span>
                                @endif
                            </td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="badge bg-info">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-info me-1">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            @click="showModal = true; delId = {{ $user->id }}">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                
                @if($users->isEmpty())
                    <div class="text-center py-3">
                        <p class="text-muted">No users found matching your criteria.</p>
                    </div>
                @else
                    <div class="mt-3">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

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
         x-transition:leave-end="opacity-0">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Delete confirm')}}</h5>
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

    <div x-show="showModal" class="modal-backdrop" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);"></div>
</div>
