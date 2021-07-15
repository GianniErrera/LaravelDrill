<?php

namespace App\Http\Livewire;

use App\Models\EventInstance;

use Livewire\Component;

class Timeline extends Component
{

    public $columnOrderCriteria = "created_at";
    public $search;
    public $searchDate;

    protected $listeners = ['refreshList' => '$refresh'];

    public function updated()
    {
       $this->render();
    }

    public function render()
    {
        return view('livewire.timeline',
            ['events' => EventInstance::
            where(function($subquery) { $subquery->
                where('eventDescription', 'like', '%' . $this->search . '%')->
                whereDate('date', '=', $this->searchDate);
                })->
            orderBy($this->columnOrderCriteria)->get()]);
    }
}
