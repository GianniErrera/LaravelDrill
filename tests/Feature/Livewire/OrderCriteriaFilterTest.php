<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Timeline;
use App\Models\User;
use App\Models\EventInstance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class OrderCriteriaFilterTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function order_by_creation_date() {
        EventInstance::create([
            'eventDescription' => 'foo',
            'isItRecurringYearly' => false,
            'date' => '1802-12-23']);


        EventInstance::create([
            'eventDescription' => 'fool',
            'isItRecurringYearly' => false,
            'date' => '1715-01-23']);

            Livewire::test(Timeline::class)
            ->set('columnOrderCriteria', "created_at")
            ->assertSeeInOrder(['foo', 'fool'])
            ->assertSee('fool');

    }

    /** @test */
    public function order_by_date() {
        EventInstance::create([
            'eventDescription' => 'foo',
            'isItRecurringYearly' => false,
            'date' => '1802-12-23']);


        EventInstance::create([
            'eventDescription' => 'fool',
            'isItRecurringYearly' => false,
            'date' => '1715-01-23']);

            Livewire::test(Timeline::class)
            ->set('columnOrderCriteria', "date")
            ->assertSeeInOrder(['fool', 'foo']);

    }




}
