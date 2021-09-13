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
    public $singleDate;
    public $startDate;
    public $endDate;
    public $ignoreYearFromQuery;
    public $singleDateQuery;


    protected $listeners = ["refreshList" => '$refresh',
                            "singleDate" => "getSelectedDate",
                            "searchRange" => "getSearchRange",
                            "resetSearchDate" => "resetSearchDate",
                            "resetDateRange" => "resetDateRange"];

    protected $rules = [
        'endDate' => "after:startDate"
    ];


    public function getSelectedDate($date) {
        $this->singleDate = $date;
        $this->resetPage();
    }

    public function getSearchRange($startDate, $endDate) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->resetPage();
    }

    public function removeFilters() {
        $this->reset();
        $this->resetPage();
        $this->emit('clearSingleDatepicker');
        $this->emit('clearRangeDatepicker');
    }



    public function updatedSingleDateQuery() {


        if($this->singleDateQuery == true) { // if singlequery is true we clear the other picker and vice versa
            $this->startDate = "";
            $this->endDate = "";
            $this->emit('clearSingleDatepicker');
        } else {
            $this->singleDate = "";
            $this->emit('clearRangeDatepicker');
        }
        $this->resetPage(); // this sets paginator to 1

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
                searchDate($this->ignoreYearFromQuery, $this->singleDate)->
                timeInterval($this->ignoreYearFromQuery, $this->startDate, $this->endDate)->
                orderBy($this->columnOrderCriteria, "desc")->paginate(10)
            ]);
    }
}
