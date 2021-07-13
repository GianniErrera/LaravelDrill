<?php

namespace App\Http\Livewire;

use App\Models\Event;

use Livewire\Component;

class Timeline extends Component
{
    public function render()
    {
        return view('livewire.timeline', ['events' => Event::latest()->get()]);
    }
}
