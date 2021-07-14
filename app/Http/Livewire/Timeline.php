<?php

namespace App\Http\Livewire;

use App\Models\EventInstance;

use Livewire\Component;

class Timeline extends Component
{

    protected $listeners = ['refreshList' => '$refresh'];

    public function test()
    {
        dd('OK');
    }

    public function render()
    {
        return view('livewire.timeline', ['events' => EventInstance::latest()->get()]);
    }
}
