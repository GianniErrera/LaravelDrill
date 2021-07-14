<?php

namespace App\Http\Livewire;

use App\Models\EventInstance;

use Livewire\Component;

class Timeline extends Component
{

    public $columnOrderCriteria = "created_at";

    protected $listeners = ['refreshList' => '$refresh'];

    public function updated()
    {
       $this->render();
    }

    public function render()
    {
        return view('livewire.timeline', ['events' => EventInstance::orderBy($this->columnOrderCriteria)->get()]);
    }
}
