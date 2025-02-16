<?php

namespace App\Livewire;

use App\Models\Document;
use App\Models\Folder;
use Livewire\Component;
use Livewire\WithFileUploads;

class FileManager extends Component
{
    use WithFileUploads;

    public $file;
    public $currentFolder = null;
    public $newFolderName;
    public $files = [];
    public $showDeleteModal = false;
    public $folderToDelete;

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
        $currentFolderModel = $this->currentFolder ? Folder::find($this->currentFolder) : null;
        $parentFolder = $currentFolderModel ? $currentFolderModel->parent_id : null;

        $folders = Folder::where('parent_id', '=', $this->currentFolder)->get();
        $folderTree = $this->getFolderTree();

        $breadcrumbs = collect();
        $parent = $currentFolderModel;
        while ($parent) {
            $breadcrumbs->prepend($parent);
            $parent = $parent->parent;
        }

        return view('livewire.file-manager', compact(
            'folders', 
            'currentFolderModel', 
            'parentFolder', 
            'breadcrumbs',
            'folderTree'
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
    }

    public function openFolder($folderId)
    {
        $this->currentFolder = $folderId;
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
        
        // Проверяем, есть ли в папке документы или подпапки
        if ($folder->documents()->count() > 0 || $folder->children()->count() > 0) {
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
}
