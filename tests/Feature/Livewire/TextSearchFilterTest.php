<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Timeline;
use App\Models\User;
use App\Models\EventInstance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class TextSearchFilterTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function text_filter_has_results() {
        EventInstance::create([
            'eventDescription' => 'foo',
            'isItRecurringYearly' => false,
            'date' => '1802-12-23']);


        EventInstance::create([
            'eventDescription' => 'fool',
            'isItRecurringYearly' => false,
            'date' => '2018-01-23']);

            Livewire::test(Timeline::class)
            ->set('search', "foo")
            ->assertSee('foo')
            ->assertSee('fool');

    }

    /** @test */
    public function text_filter_filters_out_results() {
        EventInstance::create([
            'eventDescription' => 'foo',
            'isItRecurringYearly' => false,
            'date' => '1802-12-23']);


        EventInstance::create([
            'eventDescription' => 'fool',
            'isItRecurringYearly' => false,
            'date' => '2018-01-23']);

            Livewire::test(Timeline::class)
            ->set('search', "xxx")
            ->assertDontSee('foo')
            ->assertDontSee('fool');

    }




}
