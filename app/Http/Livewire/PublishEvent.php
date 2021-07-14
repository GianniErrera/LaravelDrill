<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\EventInstance;

class PublishEvent extends Component

{

    public $date;
    public $isItYearly;
    public $eventDescription;

    protected $rules = [
        'date' => 'required|date',
        'eventDescription' => 'required|string|max:180'

    ];

    public function mount(EventInstance $event)
    {


    }

    public function publish()
    {
        $this->validate();
        $event = new EventInstance();
        $event->eventDescription = $this->eventDescription;
        $event->isItRecurringYearly = $this->isItYearly;
        $event->date = $this->date;
        $event->save();
        $this->emitTo('timeline', 'refreshList');
        $this->reset(['date', 'eventDescription', 'isItYearly']);

    }

    public function render()
    {
        return view('livewire.publish-event');
    }
}
