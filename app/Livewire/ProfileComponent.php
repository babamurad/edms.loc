<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ProfileComponent extends Component
{
    use WithFileUploads;
    public $isEdit = false;
    public $name, $email, $password;
    public $avatar;
    public $newavatar;

    protected function rules()
    {
        return [
            'name' => 'required|min:3|max:50|string',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'password' => 'nullable|min:6',
        ];
    }

    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->email = auth()->user()->email;
        $this->avatar = auth()->user()->avatar;
    }

    public function save()
    {
        $this->validate($this->rules());

        $user = auth()->user();
        $updateData = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        // Обработка аватара
        if ($this->newavatar) {
            // Удаляем старый аватар если есть
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            // Сохраняем новый аватар
            $imageName = time() . '.' . $this->newavatar->getClientOriginalExtension();
            $path = $this->newavatar->storeAs('avatars', $imageName, 'public');
            
            $updateData['avatar'] = $path;
            $this->avatar = $path;
            $this->newavatar = null;
        }

        // Обновляем данные пользователя
        $user->update($updateData);

        // Обновляем пароль если он был изменен
        if ($this->password) {
            $user->update(['password' => bcrypt($this->password)]);
        }

        $this->isEdit = false;
        $this->dispatch('change-profile-image');
        session()->flash('success', 'Profile updated successfully.');
    }

    public function saveNewAvatar()
    {
        if ($this->newavatar) {
            $user = auth()->user();
            
            // Добавляем отладочную информацию
            logger('Saving avatar...');
            logger('User ID: ' . $user->id);
            
            // Удаляем старый аватар если есть
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
                logger('Old avatar deleted: ' . $user->avatar);
            }
            
            // Сохраняем новый аватар
            $imageName = time() . '.' . $this->newavatar->getClientOriginalExtension();
            $path = $this->newavatar->storeAs('avatars', $imageName, 'public');
            logger('New avatar path: ' . $path);
            
            // Обновляем в базе данных напрямую через модель
            $user->avatar = $path;
            $saved = $user->save();
            
            logger('Save result: ' . ($saved ? 'true' : 'false'));
            logger('User avatar after save: ' . $user->avatar);
            
            // Обновляем локальное состояние
            $this->avatar = $path;
            
            // Очищаем временный файл
            $this->newavatar = null;

            // Проверяем обновление
            $freshUser = User::find($user->id);
            logger('User avatar from fresh model: ' . $freshUser->avatar);
        }
    }

    public function render()
    {
        return view('livewire.profile-component');
    }
}
