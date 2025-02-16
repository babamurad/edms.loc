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
use App\Livewire\HomeComponent;
use App\Livewire\User\Login;
use App\Livewire\User\Register;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function (){
    Route::get('/', HomeComponent::class)->name('home');

    Route::get('department', DepartmentIndex::class)->name('department');
    Route::get('department/create', DepartmentCreate::class)->name('department.create');
    Route::get('department/{id}/edit', DepartmentEdit::class)->name('department.edit');

    Route::get('category', CategoryIndex::class)->name('category');
    Route::get('category/create', CategoryCreate::class)->name('category.create');
    Route::get('category/{id}/edit', CategoryEdit::class)->name('category.edit');

    Route::get('documents',DocumentsIndex::class)->name('documents');
    Route::get('documents/create', DocumentsCreate::class)->name('documents.create');
    Route::get('documents/{id}/edit', DocumentsEdit::class)->name('documents.edit');
    Route::get('documents/{id}/view',DocumentsView::class)->name('documents.view');
    Route::get('documents/upload/{folder?}', DocumentsUpload::class)->name('documents.upload');
});

Route::middleware('guest')->group(function (){
    Route::get('register', Register::class)->name('register');
    Route::get('login', Login::class)->name('login');
});




