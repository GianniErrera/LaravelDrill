<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\CreateEvent;
use App\Models\User;
use App\Models\EventInstance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class TimelineTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function timeline_has_events() {

        EventInstance::factory()->count(20)->create();

        $this->assertDatabaseCount('events', 20);
    }

    /** @test */
    public function events_in_different_years() {


        EventInstance::create([
            'eventDescription' => 'foo',
            'isItRecurringYearly' => false,
            'date' => '1802-12-23']);


        EventInstance::create([
            'eventDescription' => 'too',
            'isItRecurringYearly' => false,
            'date' => '2018-01-23']);


            Livewire::test('timeline')
            ->set('ignoreYearFromQuery', false)
            ->set('startDate', '2016-12-23')
            ->set('endDate', '2018-01-24')
            ->assertSet('ignoreYearFromQuery', false)
            ->assertSee('too')
            ->assertDontSee('foo');


    }

    /** @test */
    public function events_in_wrong_date_range() {

        EventInstance::create([
            'eventDescription' => 'foo',
            'isItRecurringYearly' => false,
            'date' => '1802-12-23']);


        EventInstance::create([
            'eventDescription' => 'too',
            'isItRecurringYearly' => false,
            'date' => '2018-01-23']);


            Livewire::test('timeline')
            ->set('ignoreYearFromQuery', false)
            ->set('startDate', '2019-01-20')
            ->set('endDate', '2019-01-24')
            ->assertHasNoErrors()
            ->assertDontSee('too', 'foo');



    }

    /** @test */
    public function startDateAfterEndDate() {


        Livewire::test('timeline')
        ->set('ignoreYearFromQuery', false)
        ->set('startDate', '2018-01-20')
        ->set('endDate', '2018-01-10')
        ->assertSet('ignoreYearFromQuery', false)
        ->assertHasErrors(['endDate']);

    }


}
