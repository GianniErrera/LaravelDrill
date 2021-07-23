<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\PublishEvent;
use App\Models\User;
use App\Models\EventInstance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class PublishEventTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function user_can_publish_event()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(PublishEvent::class)
            ->set('eventDescription', 'foo')
            ->set('isItYearly', false)
            ->set('date', '1800-01-24')
            ->call('publish');


            $this->assertDatabaseHas('events', [
                'eventDescription' => 'foo',
            ]);
    }

    /** @test */
    public function event_description_missing()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(PublishEvent::class)
            ->set('eventDescription', "")
            ->set('isItYearly', false)
            ->set('date', '1800-01-24')
            ->call('publish')
            ->assertHasErrors(['eventDescription']);
    }

    /** @test */
    public function date_missing()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(PublishEvent::class)
            ->set('eventDescription', null)
            ->set('isItYearly', false)
            ->set('date', '')
            ->call('publish')
            ->assertHasErrors(['date']);
    }


    /** @test */
    public function the_component_can_render()
    {

        $this->actingAs(User::factory()->create());

        $component = Livewire::test(PublishEvent::class);

        $component->assertStatus(200);
    }
}
