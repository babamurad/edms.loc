<?php

namespace App\Livewire;

use App\Models\Department;
use App\Models\Document;
use App\Models\DocumentShare as DocumentShareModel;
use App\Models\Folder;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FileManager extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $file = 'fileName';
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

    public $show = false;
    public $content = '';

    public $dateStart = null;
    public $dateEnd = null;

    protected $queryString = [
        'dateStart' => ['except' => null],
        'dateEnd' => ['except' => null],
        'showAllFiles' => ['except' => false],
        'currentFolder' => ['except' => null]
    ];

    public $showAllFiles = false; // новое свойство для отслеживания состояния
    protected $paginationTheme = 'bootstrap';
    public $perPage = 12; // количество документов на странице

    protected function rules()
    {
        return [
            'dateStart' => 'nullable|date',
            'dateEnd' => 'nullable|date',
            'selectedUsers' => 'required|array|min:1',
            'message' => 'nullable|string|max:500'
        ];
    }

    protected $messages = [
        'selectedUsers.required' => 'Пожалуйста, выберите получателей',
        'selectedUsers.array' => 'Некорректный формат получателей',
        'selectedUsers.min' => 'Выберите хотя бы одного получателя',
        'message.max' => 'Сообщение не должно превышать 500 символов'
    ];

    private function getFolderTree($parentId = null, $level = 0)
    {
        $query = Folder::withCount([
            'documents' => function($query) {
                $query->whereNotNull('id');
            }
        ])
        ->where('parent_id', $parentId);

        // Если пользователь не админ, показываем только его папки
        if (!auth()->user()->hasRole('admin')) {
            $query->where('user_id', auth()->id());
        }

        $folders = $query->get();
        
        $tree = [];
        
        foreach ($folders as $folder) {
            $folder->level = $level;
            $tree[] = $folder;

            // Получаем документы для текущей папки
            $documents = Document::where('folder', $folder->id)
                ->when(!auth()->user()->hasRole('admin'), function($query) {
                    $query->where('user_id', auth()->id());
                })
                ->get();

            foreach ($documents as $document) {
                $document->level = $level + 1;
                $document->is_file = true;
                $tree[] = $document;
            }

            $tree = array_merge($tree, $this->getFolderTree($folder->id, $level + 1));
        }
        
        return $tree;
    }

    public function render()
    {
        $documents = $this->getDocuments();
        $folders = $this->getFolders();
        
        return view('livewire.file-manager', [
            'folders' => $folders,
            'documents' => $documents,
            'currentFolderModel' => $this->currentFolder ? Folder::find($this->currentFolder) : null,
            'breadcrumbs' => $this->getBreadcrumbs(),
            'departments' => $this->getDepartments()
        ]);
    }

    public function mount($dateStart = null, $dateEnd = null)
    {
        // Приоритет URL-параметров над query-параметрами
        $this->dateStart = $dateStart ?? request()->query('dateStart', null);
        $this->dateEnd = $dateEnd ?? request()->query('dateEnd', null);
        $this->showAllFiles = (bool) request()->query('showAllFiles', false);
        $this->currentFolder = request()->query('currentFolder', null);

        // Если есть даты в сессии, используем их
        if (!$this->dateStart && !$this->dateEnd) {
            $this->dateStart = session('filemanager_date_start');
            $this->dateEnd = session('filemanager_date_end');
        }

        // Сохраняем даты в сессию
        if ($this->dateStart && $this->dateEnd) {
            session([
                'filemanager_date_start' => $this->dateStart,
                'filemanager_date_end' => $this->dateEnd
            ]);
            
            $this->dispatch('initializeDateRange', [
                'start' => $this->dateStart,
                'end' => $this->dateEnd
            ]);
        }
    }

    public function createFolder()
    {
        $this->validate(['newFolderName' => 'required|string|max:255']);
        
        Folder::create([
            'name' => $this->newFolderName,
            'parent_id' => $this->currentFolder,
            'user_id' => auth()->user()->id
        ]);
        
        $this->newFolderName = '';
        $this->showCreateModal = false; // закрываем модальное окно после создания
        session()->flash('success', 'Папка успешно создана');
    }

    public function openFolder($folderId)
    {
        $this->currentFolder = $folderId === 'null' ? null : $folderId;
        if(auth()->user()->hasRole('admin')){
            $this->files = Document::where('folder', $this->currentFolder)->with('author')->get() ?? collect();
        } else {
            $this->files = Document::where(['user_id' => auth()->user()->id, 'folder' => $this->currentFolder])->with('author')->get() ?? collect();
        }
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
        $this->reset(['selectedUsers', 'message']);
        $this->showModal = true;
        $this->dispatch('showModal');
    }

    public function shareDocument()
    {        
        $this->validate();

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
        session()->flash('success', 'Документ успешно отправлен');
    }

    public function updatedShowAllFiles()
    {
        $this->resetPage(); // сброс страницы при переключении режима
    }

    #[On('dateRangeSelected')]
    public function handleDateRange($start, $end)
    {
        $this->dateStart = $start;
        $this->dateEnd = $end;
        $this->resetPage(); // Добавляем сброс страницы при изменении фильтра
    }

    private function getDocuments()
    {
        if ($this->showAllFiles) {
            // Показываем все файлы без учета папок
            $query = Document::with(['author', 'folderModel']);
            
            if (!auth()->user()->hasRole('admin')) {
                $query->where('user_id', auth()->id());
            }
        } else {
            // Показываем файлы текущей папки
            $query = Document::where('folder', $this->currentFolder)
                           ->with(['author', 'folderModel']);
            
            if (!auth()->user()->hasRole('admin')) {
                $query->where('user_id', auth()->id());
            }
        }

        // Фильтрация по дате с выводом отладочной информации
        if ($this->dateStart && $this->dateEnd) {
            \Log::info('Filtering by dates:', [
                'start' => $this->dateStart,
                'end' => $this->dateEnd
            ]);

            $startDate = Carbon::parse($this->dateStart)->startOfDay();
            $endDate = Carbon::parse($this->dateEnd)->endOfDay();
            
            $query->whereBetween('created_at', [
                $startDate,
                $endDate
            ]);
        }

        return $query->orderBy('created_at', 'desc')
                    ->paginate($this->perPage);
    }

    public function updatedDateStart($value)
    {
        session(['filemanager_date_start' => $value]);
        $this->resetPage();
        if ($value && $this->dateEnd) {
            $this->redirectRoute('documents', [
                'dateStart' => $value,
                'dateEnd' => $this->dateEnd
            ]);
        }
    }

    public function updatedDateEnd($value)
    {
        session(['filemanager_date_end' => $value]);
        $this->resetPage();
        if ($value && $this->dateStart) {
            $this->redirectRoute('documents', [
                'dateStart' => $this->dateStart,
                'dateEnd' => $value
            ]);
        }
    }

    private function getBreadcrumbs()
    {
        $breadcrumbs = collect();
        $currentId = $this->currentFolder;
        
        while ($currentId) {
            $folder = Folder::find($currentId);
            if ($folder) {
                $breadcrumbs->prepend($folder);
                $currentId = $folder->parent_id;
            } else {
                break;
            }
        }
        
        return $breadcrumbs;
    }

    private function getDepartments()
    {
        return Department::with(['users' => function($query) {
            $query->where('active', true)
                  ->where('id', '!=', auth()->id());
        }])->get();
    }

    private function getFolders()
    {
        $query = Folder::query();

        if ($this->showAllFiles) {
            // Показываем все папки
            $query->with(['documents', 'owner'])  // убедимся что owner загружается
                  ->when(!auth()->user()->hasRole('admin'), function($q) {
                      $q->where('user_id', auth()->id());
                  });
        } else {
            // Показываем папки текущего уровня
            $query->where('parent_id', $this->currentFolder)
                  ->with(['documents', 'owner'])  // убедимся что owner загружается
                  ->when(!auth()->user()->hasRole('admin'), function($q) {
                      $q->where('user_id', auth()->id());
                  });
        }

        // Добавляем сортировку
        $query->orderBy('name');

        return $query->paginate($this->perPage);
    }
}
