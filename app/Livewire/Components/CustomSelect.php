<?php

namespace App\Livewire\Components;

use Livewire\Component;

class CustomSelect extends Component
{
    public $options;
    public $selected = null;
    public $placeholder;

    public function mount($options, $placeholder = 'Выберите...', $selected = null)
    {
        $this->options = $options;
        $this->placeholder = $placeholder;
        $this->selected = $selected;
    }

    public function render()
    {
        return view('livewire.components.custom-select', [
            'options' => $this->options
        ]);
    }

    public function updatedSelected($value)
    {
        $this->dispatch('optionSelected', $value);
    }
}
