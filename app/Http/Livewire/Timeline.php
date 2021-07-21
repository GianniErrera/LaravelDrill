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

    protected $rules = [
        'endDate' => "after:startDate"
    ];

    public function removeFilters() {
        $this->reset();
    }

    public function updatedColumnOrderCriteria() {
        $this->resetPage();
    }

    public function updatedSearch() {
        $this->resetPage();
    }

    public function updatedSearchDate() {
        $this->resetPage();
    }

    public function updatedStartDate() {
        if($this->endDate && !$this->ignoreYearFromQuery) {
            $this->validate();
        }
        $this->resetPage(); // this should always be triggered
    }

    public function updatedEndDate() {
        if($this->startDate && !$this->ignoreYearFromQuery) {
            $this->validate();
        }
        $this->resetPage(); // this should always be triggered
    }

    public function updatedIgnoreYearFromQuery() {
        if($this->startDate && $this->endDate) {
            $this->validate();
        }
       $this->resetPage(); // this should always be triggered
   }


    public function render() {
        return view('livewire.timeline',
            ['events' => EventInstance::
                search($this->search)->
                searchDate($this->searchDate)->
                timeInterval($this->ignoreYearFromQuery, $this->startDate, $this->endDate)->
                orderBy($this->columnOrderCriteria)->paginate(10),
             'reminders' => EventInstance::
                where('date', '>=', Carbon::yesterday())->
                where('date', '<=', Carbon::today()->addDays(30))->
                orderBy('date')->
                get()
            ]);
    }
}
