<?php

namespace App\Http\Livewire;

use App\Models\EventInstance;
use Livewire\WithPagination;
use Carbon\Carbon;
use Livewire\Component;

class Timeline extends Component
{
    use WithPagination;

    public $columnOrderCriteria = "created_at";
    public $search;
    public $searchDate;
    public $startDate;
    public $endDate;
    public $ignoreYearFromQuery;

    protected $listeners = ['refreshList' => '$refresh'];

    public function removeFilters()
    {
       $this->reset();
    }

    public function updated() {
        $this->resetPage();
    }



    public function render()
    {
        return view('livewire.timeline',
            ['events' => EventInstance::
                search($this->search)->
                searchDate($this->searchDate)->
                timeInterval($this->ignoreYearFromQuery, $this->startDate, $this->endDate)->
                orderBy($this->columnOrderCriteria)->paginate(10),
            'reminders' => EventInstance::where('date', '>=', Carbon::yesterday())->where('date', '<=', Carbon::today()->addDays(30))->get()]);
    }
}
