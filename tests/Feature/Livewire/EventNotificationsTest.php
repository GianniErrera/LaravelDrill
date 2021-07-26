<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\PublishEvent;
use App\Models\User;
use App\Models\EventInstance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use Carbon\Carbon;

class EventNotificationsTest extends TestCase
{

    use RefreshDatabase;




    /** @test */
    public function notifications_are_displayed()
    {
        EventInstance::create([
            'eventDescription' => 'foo',
            'isItRecurringYearly' => false,
            'date' => Carbon::today()->format('Y-m-d')]);


        Livewire::test('reminders')
            ->assertSee('foo');

    }

     /** @test */
     public function notifications_in_wrong_daterange_are_not_displayed()
     {
         EventInstance::create([
             'eventDescription' => 'foo',
             'isItRecurringYearly' => false,
             'date' => Carbon::today()->subMonth()->format('Y-m-d')]);


         Livewire::test('reminders')
             ->assertDontSee('foo');

     }
}
