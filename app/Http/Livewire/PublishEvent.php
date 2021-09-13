<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\EventInstance;
use Livewire\Livewire;

class PublishEvent extends Component

{

    public $date;
    public $isItYearly;
    public $eventDescription;
    public $dateForHumans;

    protected $listeners = ['publishDate' => 'setDate'];

    protected $rules = [
        'date' => 'required|date',
        'eventDescription' => 'required|string|max:180'

    ];

    public function setDate($date) {
        $this->date = $date;
        $this->dateForHumans = date('j F Y', strtotime($this->date));

    }

    public function publish()
    {
        $this->validate();
        $event = new EventInstance();
        $event->eventDescription = $this->eventDescription;
        $event->isItRecurringYearly = $this->isItYearly;
        $event->date = $this->date; // I have to change format since changing $date format changes also on display
        $event->save();
        $this->emitTo('timeline', 'refreshList');
        $this->reset(['date', 'eventDescription', 'isItYearly', 'dateForHumans']);
        session()->flash('message', 'Event successfully published.');
        $this->emit('eventPublished');
    }

    public function render()
    {
        return view('livewire.publish-event');
    }
}
