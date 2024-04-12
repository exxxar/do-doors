<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Hinge;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\HingeController
 */
final class HingeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $hinges = Hinge::factory()->count(3)->create();

        $response = $this->get(route('hinge.index'));

        $response->assertOk();
        $response->assertViewIs('hinge.index');
        $response->assertViewHas('hinges');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('hinge.create'));

        $response->assertOk();
        $response->assertViewIs('hinge.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\HingeController::class,
            'store',
            \App\Http\Requests\HingeStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $price = $this->faker->randomFloat(/** double_attributes **/);

        $response = $this->post(route('hinge.store'), [
            'price' => $price,
        ]);

        $hinges = Hinge::query()
            ->where('price', $price)
            ->get();
        $this->assertCount(1, $hinges);
        $hinge = $hinges->first();

        $response->assertRedirect(route('hinge.index'));
        $response->assertSessionHas('hinge.id', $hinge->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $hinge = Hinge::factory()->create();

        $response = $this->get(route('hinge.show', $hinge));

        $response->assertOk();
        $response->assertViewIs('hinge.show');
        $response->assertViewHas('hinge');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $hinge = Hinge::factory()->create();

        $response = $this->get(route('hinge.edit', $hinge));

        $response->assertOk();
        $response->assertViewIs('hinge.edit');
        $response->assertViewHas('hinge');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\HingeController::class,
            'update',
            \App\Http\Requests\HingeUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $hinge = Hinge::factory()->create();
        $price = $this->faker->randomFloat(/** double_attributes **/);

        $response = $this->put(route('hinge.update', $hinge), [
            'price' => $price,
        ]);

        $hinge->refresh();

        $response->assertRedirect(route('hinge.index'));
        $response->assertSessionHas('hinge.id', $hinge->id);

        $this->assertEquals($price, $hinge->price);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $hinge = Hinge::factory()->create();

        $response = $this->delete(route('hinge.destroy', $hinge));

        $response->assertRedirect(route('hinge.index'));

        $this->assertModelMissing($hinge);
    }
}
