<?php

use App\Livewire\Category\CategoryCreate;
use App\Livewire\Category\CategoryEdit;
use App\Livewire\Category\CategoryIndex;
use App\Livewire\Department\DepartmentCreate;
use App\Livewire\Department\DepartmentEdit;
use App\Livewire\Department\DepartmentIndex;
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
});

Route::middleware('guest')->group(function (){
    Route::get('register', Register::class)->name('register');
    Route::get('login', Login::class)->name('login');
});




