<?php

namespace App\Livewire;

use Exception;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Outerweb\Settings\Facades\Setting;

class Homepage extends Component
{
    public function render()
    {
        return view('livewire.homepage');
    }
}
