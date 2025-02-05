<?php

use App\Livewire\Department\DepartmentCreate;
use App\Livewire\Department\DepartmentEdit;
use App\Livewire\Department\DepartmentIndex;
use App\Livewire\HomeComponent;
use App\Livewire\User\Login;
use App\Livewire\User\Register;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', HomeComponent::class)->name('home');
Route::get('register', Register::class)->name('register');
Route::get('login', Login::class)->name('login');

Route::get('department', DepartmentIndex::class)->name('department');
Route::get('department/create', DepartmentCreate::class)->name('department.create');
Route::get('department/{id}/edit', DepartmentEdit::class)->name('department.edit');

