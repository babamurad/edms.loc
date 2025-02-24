<?php

namespace App\Livewire;

use App\Models\Department;
use App\Models\Document;
use App\Models\DocumentShare as DocumentShareModel;
use App\Models\Folder;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class FileManager extends Component
{
    use WithFileUploads;

    public $file;
    public $currentFolder = null;
    public $newFolderName;
    public $files = [];
    public $showDeleteModal = false;
    public $folderToDelete;
    public $showRenameModal = false;
    public $folderToRename;
    public $newName;
    public $showCreateModal = false;
    public $showFileDeleteModal = false;
    public $fileToDelete;

    public $selectedFileId = null;
    public $selectedUsers = [];
    public $message;
    public $showModal = false;

    private function getFolderTree($parentId = null, $level = 0)
    {
        // Используем withCount для подсчета документов
        $folders = Folder::withCount([
            'documents' => function($query) {
                $query->whereNotNull('id');
            }
        ])
        ->where('parent_id', $parentId)
        ->get();
        
        $tree = [];
        
        foreach ($folders as $folder) {
            $folder->level = $level;
            $tree[] = $folder;
            $tree = array_merge($tree, $this->getFolderTree($folder->id, $level + 1));
        }
        
        return $tree;
    }

    public function render()
    {
        $departments = Department::with(['users' => function($query) {
            $query->where('active', true)
                  ->where('id', '!=', auth()->id());
        }])->get();
        
        $currentFolderModel = $this->currentFolder ? Folder::find($this->currentFolder) : null;
        $parentFolder = $currentFolderModel ? $currentFolderModel->parent_id : null;

        // Получаем папки текущего уровня
        $folders = Folder::where('parent_id', '=', $this->currentFolder)->get();
        $folderTree = $this->getFolderTree();
        
        // Получаем файлы текущей папки
        $files = Document::where('folder', $this->currentFolder)->get() ?? collect();

        $breadcrumbs = collect();
        $parent = $currentFolderModel;
        while ($parent) {
            $breadcrumbs->prepend($parent);
            $parent = $parent->parent;
        }

        return view('livewire.file-manager', compact(
            'folders', 
            'files',
            'currentFolderModel', 
            'parentFolder', 
            'breadcrumbs',
            'folderTree',
            'departments'
        ));
    }

    public function mount()
    {
        $this->files = Document::where('folder', $this->currentFolder)->get() ?? collect();
    }

    public function createFolder()
    {
        $this->validate(['newFolderName' => 'required|string|max:255']);
        
        Folder::create([
            'name' => $this->newFolderName,
            'parent_id' => $this->currentFolder
        ]);
        
        $this->newFolderName = '';
        $this->showCreateModal = false; // закрываем модальное окно после создания
        session()->flash('success', 'Папка успешно создана');
    }

    public function openFolder($folderId)
    {
        $this->currentFolder = $folderId === 'null' ? null : $folderId;
        $this->files = Document::where('folder', $this->currentFolder)->get() ?? collect();
    }

    public function confirmFolderDelete($folderId)
    {
        $this->folderToDelete = $folderId;
        $this->showDeleteModal = true;
    }

    public function deleteFolder()
    {
        $folder = Folder::findOrFail($this->folderToDelete);
        
        // Заменяем children() на subfolders()
        if ($folder->documents()->count() > 0 || $folder->subfolders()->count() > 0) {
            session()->flash('error', 'Невозможно удалить папку, содержащую файлы или подпапки');
            $this->showDeleteModal = false;
            return;
        }

        $folder->delete();
        $this->showDeleteModal = false;
        session()->flash('success', 'Папка успешно удалена');
        
        // Если мы удалили текущую открытую папку, возвращаемся к родительской
        if ($this->currentFolder == $this->folderToDelete) {
            $this->openFolder($folder->parent_id);
        }
    }

    public function confirmFolderRename($folderId)
    {
        $folder = Folder::findOrFail($folderId);
        $this->folderToRename = $folderId;
        $this->newName = $folder->name;
        $this->showRenameModal = true;
    }

    public function renameFolder()
    {
        $this->validate([
            'newName' => 'required|string|max:255'
        ]);

        $folder = Folder::findOrFail($this->folderToRename);
        $folder->name = $this->newName;
        $folder->save();

        $this->showRenameModal = false;
        session()->flash('success', 'Папка успешно переименована');
    }

    public function confirmFileDelete($fileId)
    {
        $this->fileToDelete = $fileId;
        $this->showFileDeleteModal = true;
    }

    public function deleteFile()
    {
        $document = Document::findOrFail($this->fileToDelete);
        
        // Удаляем физический файл
        $filePath = 'public/documents/' . auth()->user()->name . '/' . $document->file;
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
        
        // Удаляем запись из базы данных
        $document->delete();
        
        $this->showFileDeleteModal = false;
        session()->flash('success', 'Файл успешно удален');
        
        // Обновляем список файлов
        $this->files = Document::where('folder', $this->currentFolder)->get() ?? collect();
    }

    public function openShareModal($fileId)
    {
        $this->selectedFileId = $fileId;
        $this->showModal = true;
        $this->dispatch('showModal');
    }

    public function shareDocument()
    {
        $this->validate([
            'selectedUsers' => 'required|array|min:1',
            'message' => 'nullable|string'
        ]);

        foreach ($this->selectedUsers as $userId) {
            DocumentShareModel::create([
                'document_id' => $this->selectedFileId,
                'sender_id' => auth()->id(),
                'recipient_id' => $userId,
                'status_id' => 1,
                'message' => $this->message
            ]);
        }

        $this->reset(['selectedUsers', 'message']);
        $this->showModal = false;
        session()->flash('success', 'Document shared successfully');
    }
}
