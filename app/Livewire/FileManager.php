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

    public function render()
    {
        $currentFolderModel = $this->currentFolder ? Folder::find($this->currentFolder) : null;
        $parentFolder = $currentFolderModel ? $currentFolderModel->parent_id : null;

        $folders = Folder::where('parent_id', '=', $this->currentFolder)->get();

        $breadcrumbs = collect();
        $parent = $currentFolderModel;
        while ($parent) {
            $breadcrumbs->prepend($parent);
            $parent = $parent->parent;
        }

        return view('livewire.file-manager', compact('folders', 'currentFolderModel', 'parentFolder', 'breadcrumbs'));
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
}
