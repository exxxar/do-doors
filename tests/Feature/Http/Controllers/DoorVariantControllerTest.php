<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\DoorVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DoorVariantController
 */
final class DoorVariantControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $doorVariants = DoorVariant::factory()->count(3)->create();

        $response = $this->get(route('door-variant.index'));

        $response->assertOk();
        $response->assertViewIs('doorVariant.index');
        $response->assertViewHas('doorVariants');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('door-variant.create'));

        $response->assertOk();
        $response->assertViewIs('doorVariant.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DoorVariantController::class,
            'store',
            \App\Http\Requests\DoorVariantStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $price = $this->faker->randomFloat(/** double_attributes **/);

        $response = $this->post(route('door-variant.store'), [
            'price' => $price,
        ]);

        $doorVariants = DoorVariant::query()
            ->where('price', $price)
            ->get();
        $this->assertCount(1, $doorVariants);
        $doorVariant = $doorVariants->first();

        $response->assertRedirect(route('door-variant.index'));
        $response->assertSessionHas('doorVariant.id', $doorVariant->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $doorVariant = DoorVariant::factory()->create();

        $response = $this->get(route('door-variant.show', $doorVariant));

        $response->assertOk();
        $response->assertViewIs('doorVariant.show');
        $response->assertViewHas('doorVariant');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $doorVariant = DoorVariant::factory()->create();

        $response = $this->get(route('door-variant.edit', $doorVariant));

        $response->assertOk();
        $response->assertViewIs('doorVariant.edit');
        $response->assertViewHas('doorVariant');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DoorVariantController::class,
            'update',
            \App\Http\Requests\DoorVariantUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $doorVariant = DoorVariant::factory()->create();
        $price = $this->faker->randomFloat(/** double_attributes **/);

        $response = $this->put(route('door-variant.update', $doorVariant), [
            'price' => $price,
        ]);

        $doorVariant->refresh();

        $response->assertRedirect(route('door-variant.index'));
        $response->assertSessionHas('doorVariant.id', $doorVariant->id);

        $this->assertEquals($price, $doorVariant->price);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $doorVariant = DoorVariant::factory()->create();

        $response = $this->delete(route('door-variant.destroy', $doorVariant));

        $response->assertRedirect(route('door-variant.index'));

        $this->assertModelMissing($doorVariant);
    }
}
