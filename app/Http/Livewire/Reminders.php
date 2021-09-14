<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Event;
use Carbon\Carbon;

class Reminders extends Component
{
    public function render()
    {
        return view('livewire.reminders', [
            'reminders' => Event::
                where('date', '>=', Carbon::yesterday())->
                where('date', '<=', Carbon::today()->addDays(30))->
                orderBy('date')->
                get()
        ]);
    }
}
