<?php

namespace App\Http\Livewire\Backend;

use Livewire\Component;

class Dashboard extends Component
{
    public $title;

    public function mount(){
        $this->title = 'Dashboard';
    }

    public function render()
    {
        return view('livewire.backend.dashboard')->layout('layouts.backend');
    }
}
