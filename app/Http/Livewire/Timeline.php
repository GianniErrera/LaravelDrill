<?php

namespace App\Http\Livewire;

use App\Models\Event;
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
        $this->startDate = "";
        $this->endDate = "";
        $this->emit('clearRangeDatepicker');
        $this->resetPage();
    }

    public function getSearchRange($startDate, $endDate) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->singleDate = "";
        $this->emit('clearSingleDatepicker');
        $this->resetPage();
    }

    public function removeFilters() {
        $this->reset();
        $this->resetPage();
        $this->emit('clearSingleDatepicker');
        $this->emit('clearRangeDatepicker');
    }



    public function updatedColumnOrderCriteria() {
        $this->resetPage();
    }

    public function updatedSearch() {
        $this->resetPage();
    }


    public function updatedIgnoreYearFromQuery() {
       $this->resetPage();
   }


    public function render() {
        return view('livewire.timeline',
            ['events' => Event::
                search($this->search)->
                searchDate($this->ignoreYearFromQuery, $this->singleDate)->
                timeInterval($this->ignoreYearFromQuery, $this->startDate, $this->endDate)->
                orderBy($this->columnOrderCriteria, "desc")->paginate(10)
            ]);
    }
}
