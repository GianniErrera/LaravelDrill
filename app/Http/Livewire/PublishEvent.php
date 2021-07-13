<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Event;

class PublishEvent extends Component

{

    public $date;
    public $isItYearly;
    public $eventDescription;

    protected $rules = [
        'date' => 'required|date',
        'eventDescription' => 'required|string|max:180'

    ];

    public function publishEvent()
    {
        $this->validate();
        $event = new Event();
        $event->eventDescription = $this->eventDescription;
        $event->isItRecurringYearly = $this->isItYearly;
        $event->date = $this->date;
        $event->save();

        $this->reset(['date', 'eventDescription', 'isItYearly']);
    }

    public function render()
    {
        return view('livewire.publish-event');
    }
}
