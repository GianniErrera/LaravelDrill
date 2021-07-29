<?php

namespace App\Http\Livewire;

use App\Models\EventInstance;
use Livewire\WithPagination;
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
    public $singleDateQuery;

    protected $listeners = ['refreshList' => '$refresh',
                             "selectDate" => 'getSelectedDate',
                             "searchRange" => 'searchRange',
                             "resetSearchDate" => 'resetSearchDate',
                             'resetDateRange' => 'resetDateRange'];

    protected $rules = [
        'endDate' => "after:startDate"
    ];
    public function getSelectedDate( $date ) {
        $this->searchDate = $date;
        $this->resetPage();
    }

    public function removeFilters() {
        $this->reset();
    }

    public function searchRange($startDate, $endDate) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function resetSearchDate() {
        $this->searchDate = "";
        $this->resetPage();
    }

    public function resetDateRange() {
        $this->startDate = "";
        $this->endDate = "";
        $this->resetPage();
    }

    public function updatedSingleDateQuery() {
        if($this->singleDateQuery) {
            $this->startDate = "";
            $this->endDate = "";
            $this->resetPage();
        }
        else {
            $this->searchDate = "";
            $this->resetPage();
        }

    }

    public function updatedColumnOrderCriteria() {
        $this->resetPage();
    }

    public function updatedSearch() {
        $this->resetPage();
    }

    public function updatedSearchDate() {
        dd($this->searchDate);
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
        if($this->startDate && $this->endDate && $this->ignoreYearFromQuery) {
            $this->resetErrorBag();
            $this->resetValidation();
        }
        elseif($this->startDate && $this->endDate) {
            $this->validate();
        }
       $this->resetPage(); // this should always be triggered
   }

   public function hydrate() {
        $this->resetErrorBag();
        $this->resetValidation();
    }


    public function render() {
        return view('livewire.timeline',
            ['events' => EventInstance::
                search($this->search)->
                searchDate($this->searchDate)->
                timeInterval($this->ignoreYearFromQuery, $this->startDate, $this->endDate)->
                orderBy($this->columnOrderCriteria)->paginate(10)
            ]);
    }
}
