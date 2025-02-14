<div>
    <h3>Файловый менеджер</h3>
    <div class="page-title-box">
        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                @foreach($breadcrumbs as $folder)
                <li class="breadcrumb-item"><a href="javascript:;" wire:click.prevent="openFolder({{ $folder->id }})" >{{ $folder->name }}</a></li>
                @endforeach
            </ol>
        </div>
    </div>
    <!-- Навигация -->
    @if ($parentFolder)
        <button wire:click="openFolder({{ $parentFolder }})" class="btn btn-secondary mb-3">Назад</button>
    @endif

    <!-- Форма создания папки -->
    <form wire:submit.prevent="createFolder" class="mb-3">
        <input type="text" wire:model="newFolderName" class="form-control" placeholder="Имя папки">
        <button type="submit" class="btn btn-primary mt-2">Создать папку</button>
    </form>

    <!-- Форма загрузки файлов -->
    <form wire:submit.prevent="upload" class="mb-3">
        <input type="file" wire:model="file" class="form-control">
        <button type="submit" class="btn btn-success mt-2">Загрузить файл</button>
    </form>

    <div class="row">
        <!-- Отображение папок -->
        @foreach ($folders as $folder)
            <div class="col-md-3 mb-3">
                <div class="card text-center p-3" wire:click="openFolder({{ $folder->id }})" style="cursor: pointer;">
                    <i class="bi bi-folder text-warning" style="font-size: 2rem;"></i>
                    <p class="mt-2">{{ $folder->name }}</p>
                </div>
            </div>
        @endforeach

        <!-- Отображение файлов -->
        @foreach ($files as $file)
            <div class="col-md-3 mb-3">
                <div class="card text-center p-3">
                    <i class="bi {{ $file->file_icon }} text-primary" style="font-size: 2rem;"></i>
                    <p class="mt-2">
                        <a href="{{ $file->file_url }}" target="_blank">{{ $file->file }}</a>
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>

