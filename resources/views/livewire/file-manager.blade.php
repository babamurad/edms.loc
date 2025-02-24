@push('select2-css')
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <!-- Select2 css -->
    <link href="{{ asset('assets/vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" /> --}}
@endpush

@push('select2-js')
    {{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
        <!--  Select2 Plugin Js -->
    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            initSelect2();
        });

        window.addEventListener('showModal', event=> {
            setTimeout(() => {
                initSelect2();
                // $('.share-select').select2();    
            }, 100);
        });

        function initSelect2() {
            let select = $('#share-select');

            $('#share-select').on("change", function (e) { console.log("change"); });            
            
            if (select.hasClass("select2-hidden-accessible")) {
                select.select2('destroy');
            }
            
            select.select2({
                // theme: 'bootstrap-5',
                width: '100%',
                dropdownParent: select.closest('.modal-content'),
                language: {
                    searching: function() {
                        return "Поиск...";
                    },
                    noResults: function() {
                        return "Результатов не найдено";
                    }
                },
                placeholder: 'Выберите получателей',
                allowClear: true
            }).on('select2:select select2:unselect', function(e) {
                let data = select.val();
                //var data = e.params.data;
                //console.log(data);
                @this.set('selectedUsers', data || []);                
            });
        }
    </script>
@endpush
<div> 
    <div class="row">
        <x-slot name="title">{{ __('Documents') }}</x-slot>
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:;" wire:click.prevent="openFolder(null)"> {{ auth()->user()->name }} </a>
                        </li>
                        @foreach($breadcrumbs as $folder)
                        <li class="breadcrumb-item">
                            <a href="javascript:;" wire:click.prevent="openFolder({{ $folder->id }})">{{ $folder->name }}</a>
                        </li>
                        @endforeach
                    </ol>
                </div>
                <h4 class="page-title">{{ __('Documents') }}</h4>
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
            </div>            
        </div>
    </div>
    <div x-data="{ showDeleteModal: @entangle('showDeleteModal'), showRenameModal: @entangle('showRenameModal'), showCreateModal: @entangle('showCreateModal'), showFileDeleteModal: @entangle('showFileDeleteModal') }">
        <div class="p-3">
            <button class="btn btn-primary mb-3" wire:click="$set('showCreateModal', true)">
                <i class="bi bi-folder-plus"></i> Создать папку
            </button>

            <a href="{{ route('documents.upload', ['folder' => $currentFolder]) }}" class="btn btn-primary mb-3 ms-2">
                <i class="bi bi-upload"></i> Загрузить документ
            </a>

            @if($currentFolder)
                <button class="btn btn-secondary mb-3 ms-2" wire:click="openFolder('{{ $currentFolderModel?->parent_id ?? 'null' }}')">
                    <i class="bi bi-arrow-up"></i> Наверх
                </button>
            @endif

            <div class="row">
                <!-- Отображение папок -->
                @foreach ($folders as $folder)
                    <div class="col-md-3 my-3">
                        <div class="card text-center p-3">
                            <div class="card-content">
                                <a href="javascript:;" wire:click.prevent="openFolder({{ $folder->id }})" class="text-decoration-none">
                                    <i class="bi bi-folder-fill text-warning" style="font-size: 2rem;"></i>
                                    <p class="mt-2 mb-0">{{ $folder->name }}</p>
                                    <span class="badge bg-primary rounded-pill">{{ $folder->documents_count }}</span>
                                </a>
                            </div>
                            <div class="d-flex justify-content-center mt-2">
                                <button wire:click="confirmFolderRename({{ $folder->id }})" 
                                        class="btn btn-sm btn-primary me-1">
                                    <i class="bi bi-pencil"></i>
                                </button>                                
                                <button wire:click="confirmFolderDelete({{ $folder->id }})" 
                                        class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Отображение файлов -->
                @foreach ($files as $file)
                    <div class="col-md-3 my-3">
                        <div class="card text-center p-3">
                            <i class="bi {{ $file->file_icon }} text-primary" style="font-size: 2rem;"></i>
                            <p class="mt-2">
                                <a href="{{ $file->file_url }}" target="_blank">{{ $file->file }}</a>
                            </p>
                            <div class="d-flex justify-content-center">
                                <a href="{{ asset($file->FileUrl) }}" target="_blank" class="btn btn-sm btn-success me-1">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('documents.edit', ['id' => $file->id]) }}" class="btn btn-sm btn-info me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-primary me-1" wire:click="openShareModal({{ $file->id }})">
                                    <i class="bi bi-share"></i> 
                                </button>
                                <button wire:click="confirmFileDelete({{ $file->id }})" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>                    
                    </div>
                @endforeach
            </div>
            
            {{-- <select class="select2" name="states[]" multiple="multiple">
                <option value="AL">Alabama</option>
                <option value="WY">Wyoming</option>
              </select> --}}

        </div>

    @if($showModal)
    <div class="modal show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Share Document</h5>
                    <button type="button" class="btn-close" wire:click="$set('showModal', false)"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3" wire:ignore>
                        <label class="form-label">Выберите получателей</label>
                        <select class="form-control share-select @error('selectedUsers') is-invalid @enderror" 
                                multiple 
                                wire:model="selectedUsers"
                                id="share-select">
                            @foreach($departments as $department)
                                @if($department->users->count() > 0)                                
                                    <optgroup label="{{ $department->title }}">
                                        @foreach($department->users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    @error('selectedUsers')
                        <div class="invalid-feedback d-block mb-3">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="mb-3">
                        <label class="form-label">Сообщение (необязательно)</label>
                        <textarea 
                            class="form-control @error('message') is-invalid @enderror" 
                            wire:model="message" 
                            rows="3"
                            placeholder="Введите сообщение для получателей"></textarea>
                        @error('message')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="$set('showModal', false)">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="shareDocument">Share</button>
                </div>
            </div>
        </div>
    </div>

    @endif

        <!-- Модальное окно создания папки -->
        <div x-show="showCreateModal" 
             class="modal fade show" 
             style="display: block; background-color: rgba(0,0,0,0.5);"
             tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Создание новой папки</h5>
                        <button type="button" class="btn-close" wire:click="$set('showCreateModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="newFolderName" class="form-label">Имя папки</label>
                            <input type="text" 
                                   class="form-control @error('newFolderName') is-invalid @enderror" 
                                   id="newFolderName" 
                                   wire:model="newFolderName">
                            @error('newFolderName')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showCreateModal', false)">Отмена</button>
                        <button type="button" class="btn btn-primary" wire:click="createFolder">Создать</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Модальное окно подтверждения удаления -->
        <div x-show="showDeleteModal" 
             class="modal fade show" 
             style="display: block; background-color: rgba(0,0,0,0.5);"
             tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Подтверждение удаления</h5>
                        <button type="button" class="btn-close" wire:click="$set('showDeleteModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <p>Вы уверены, что хотите удалить эту папку?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showDeleteModal', false)">Отмена</button>
                        <button type="button" class="btn btn-danger" wire:click="deleteFolder">Удалить</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Модальное окно переименования -->
        <div x-show="showRenameModal" 
             class="modal fade show" 
             style="display: block; background-color: rgba(0,0,0,0.5);"
             tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Переименование папки</h5>
                        <button type="button" class="btn-close" wire:click="$set('showRenameModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="newName" class="form-label">Новое имя папки</label>
                            <input type="text" 
                                   class="form-control @error('newName') is-invalid @enderror" 
                                   id="newName" 
                                   wire:model="newName">
                            @error('newName')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showRenameModal', false)">Отмена</button>
                        <button type="button" class="btn btn-primary" wire:click="renameFolder">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Модальное окно подтверждения удаления файла -->
        <div x-show="showFileDeleteModal" 
             class="modal fade show" 
             style="display: block; background-color: rgba(0,0,0,0.5);"
             tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Подтверждение удаления</h5>
                        <button type="button" class="btn-close" wire:click="$set('showFileDeleteModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <p>Вы уверены, что хотите удалить этот файл?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showFileDeleteModal', false)">Отмена</button>
                        <button type="button" class="btn btn-danger" wire:click="deleteFile">Удалить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

