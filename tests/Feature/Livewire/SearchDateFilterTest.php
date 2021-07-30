<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Timeline;
use App\Models\User;
use App\Models\EventInstance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class SearchDateFilterTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function date_search_finds_record() {
        EventInstance::create([
            'eventDescription' => 'foo',
            'isItRecurringYearly' => false,
            'date' => '1802-12-23']);


        EventInstance::create([
            'eventDescription' => 'fool',
            'isItRecurringYearly' => false,
            'date' => '1715-01-23']);

            Livewire::test(Timeline::class)
            ->set('searchDate', "1802-12-23")
            ->assertSee('foo')
            ->assertDontSee('fool');

    }

    /** @test */
    public function dateSearchNoResults() {
        EventInstance::create([
            'eventDescription' => 'foo',
            'isItRecurringYearly' => false,
            'date' => '1802-12-23']);


        EventInstance::create([
            'eventDescription' => 'fool',
            'isItRecurringYearly' => false,
            'date' => '1715-01-23']);

            Livewire::test(Timeline::class)
            ->set('searchDate', "date")
            ->assertDontSee('foo');

    }




}
