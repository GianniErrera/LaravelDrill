<?php

namespace App\Http\Livewire;

use App\Models\EventInstance;

use Livewire\Component;

class Timeline extends Component
{

    public $columnOrderCriteria = "created_at";
    public $search;
    public $searchDate;
    public $startDate;
    public $endDate;
    public $excludeCurrentYear;

    protected $listeners = ['refreshList' => '$refresh'];

    public function removeFilters()
    {
       $this->reset();
    }

    public function render()
    {
        return view('livewire.timeline',
            ['events' => EventInstance::
                search($this->search)->
                searchDate($this->searchDate)->
                exceptCurrentYear($this->excludeCurrentYear)->
                timeInterval($this->startDate, $this->endDate)->
                orderBy($this->columnOrderCriteria)->get()]);
    }
}
