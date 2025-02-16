<div>
    <div class="row">
        <x-slot name="title">{{ __('Documents') }}</x-slot>
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        @foreach($breadcrumbs as $folder)
                        <li class="breadcrumb-item"><a href="javascript:;" wire:click.prevent="openFolder({{ $folder->id }})" >{{ $folder->name }}</a></li>
                        @endforeach
                    </ol>
                </div>
                <h4 class="page-title">{{ __('Documents') }}</h4>
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
            </div>            
        </div>
    </div>
    <div class="d-flex" x-data="{ showDeleteModal: @entangle('showDeleteModal') }">
        <!-- Боковая панель с деревом папок -->
        <div class="folder-tree border-end" style="width: 250px; min-height: 100vh; padding: 15px;">
            {{-- <h5>Структура папок</h5> --}}
            <ul class="list-unstyled">
                <li>
                    <a href="javascript:;" wire:click.prevent="openFolder(null)" class="text-decoration-none">
                        <i class="bi bi-folder-fill text-warning"></i> Корневая папка
                        <span class="badge bg-primary rounded-pill">{{ App\Models\Document::where('folder', null)->count() }}</span>
                    </a>
                </li>
                @foreach($folderTree as $treeFolder)
                    <li style="margin-left: {{ $treeFolder->level * 20 }}px">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="javascript:;" 
                               wire:click.prevent="openFolder({{ $treeFolder->id }})"
                               class="text-decoration-none {{ $currentFolder == $treeFolder->id ? 'fw-bold' : '' }}">
                                <i class="bi bi-folder{{ $currentFolder == $treeFolder->id ? '-fill' : '' }} text-warning"></i>
                                {{ $treeFolder->name }}
                                <span class="badge bg-primary rounded-pill">{{ $treeFolder->documents_count }}</span>
                            </a>
                            <button wire:click="confirmFolderDelete({{ $treeFolder->id }})" 
                                    class="btn btn-sm btn-danger ms-2">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    
        <!-- Основное содержимое -->
        <div class="flex-grow-1 p-3">
            <h3>Файловый менеджер</h3>           
    
            <!-- Форма создания папки -->
            <form wire:submit.prevent="createFolder" class="mb-3">
                <input type="text" wire:model="newFolderName" class="form-control" placeholder="Имя папки">
                <button type="submit" class="btn btn-primary mt-2">Создать папку</button>
            </form>
    
            <a href="{{ route('documents.upload', ['folder' => $currentFolder]) }}" class="btn btn-primary mt-2">Загрузить документ</a>
    
            <div class="row">
    
                <!-- Отображение файлов -->
                @foreach ($files as $file)
                    <div class="col-md-3 my-3">
                        <div class="card text-center p-3">
                            <i class="bi {{ $file->file_icon }} text-primary" style="font-size: 2rem;"></i>
                            <p class="mt-2">
                                <a href="{{ $file->file_url }}" target="_blank">{{ $file->file }}</a>
                            </p>
                            <div class="d-flex justify-content-center">
                                <a href="{{ asset($file->FileUrl) }}" target="_blank" class="btn btn-sm btn-success me-1"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('documents.edit', ['id' => $file->id]) }}" class="btn btn-sm btn-info me-1"><i class="bi bi-pencil"></i></a>
                                <button wire:click="delete({{ $file->id }})" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>                    
                    </div>
                @endforeach
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
    </div>
</div>

