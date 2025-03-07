<?php

use App\Livewire\Category\CategoryCreate;
use App\Livewire\Category\CategoryEdit;
use App\Livewire\Category\CategoryIndex;
use App\Livewire\Department\DepartmentCreate;
use App\Livewire\Department\DepartmentEdit;
use App\Livewire\Department\DepartmentIndex;
use App\Livewire\Documents\DocumentsCreate;
use App\Livewire\Documents\DocumentsEdit;
use App\Livewire\Documents\DocumentsIndex;
use App\Livewire\Documents\DocumentsUpload;
use App\Livewire\Documents\DocumentsView;
use App\Livewire\Documents\DocumentInbox;
use App\Livewire\RoleManager;
use App\Livewire\FileManager;
use App\Livewire\UserManager\UserManager;
use App\Livewire\UserManager\UserCreate;
use App\Livewire\UserManager\UserEdit;
use App\Livewire\HomeComponent;
use App\Livewire\ProfileComponent;
use App\Livewire\User\Login;
use App\Livewire\User\Register;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function (){
    Route::get('/', HomeComponent::class)->name('home');

    Route::get('profile', ProfileComponent::class)->name('profile');

    Route::get('department', DepartmentIndex::class)->name('department');
    Route::get('department/create', DepartmentCreate::class)->name('department.create');
    Route::get('department/{id}/edit', DepartmentEdit::class)->name('department.edit');

    Route::get('category', CategoryIndex::class)->name('category');
    Route::get('category/create', CategoryCreate::class)->name('category.create');
    Route::get('category/{id}/edit', CategoryEdit::class)->name('category.edit');

    // Route::get('documents',DocumentsIndex::class)->name('documents');
    Route::get('documents/{dateStart?}/{dateEnd?}', FileManager::class)
        ->name('documents')
        ->where([
            'dateStart' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
            'dateEnd' => '[0-9]{4}-[0-9]{2}-[0-9]{2}'
        ]);
    Route::get('documents/create', DocumentsCreate::class)->name('documents.create');
    Route::get('documents/{id}/edit', DocumentsEdit::class)->name('documents.edit');
    Route::get('documents/{id}/view',DocumentsView::class)->name('documents.view');
    Route::get('documents/upload/{folder?}', DocumentsUpload::class)->name('documents.upload');

    Route::get('documents/inbox', DocumentInbox::class)->name('documents.inbox');
});

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('role-manager', RoleManager::class)->name('role-manager');

    Route::get('user-manager', UserManager::class)->name('user-manager');
    Route::get('user/create', UserCreate::class)->name('user.create');
    Route::get('user/{id}/edit', UserEdit::class)->name('user.edit');
});

// Route::get('/admin', AdminController::class)->middleware('role:admin');


Route::middleware('guest')->group(function (){
    Route::get('register', Register::class)->name('register');
    Route::get('login', Login::class)->name('login');
});

date_default_timezone_set("Asia/Ashgabat");


