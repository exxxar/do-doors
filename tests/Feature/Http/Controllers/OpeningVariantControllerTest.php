<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\OpenVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\OpeningVariantController
 */
final class OpeningVariantControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $openingVariants = OpenVariant::factory()->count(3)->create();

        $response = $this->get(route('opening-variant.index'));

        $response->assertOk();
        $response->assertViewIs('openingVariant.index');
        $response->assertViewHas('openingVariants');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('opening-variant.create'));

        $response->assertOk();
        $response->assertViewIs('openingVariant.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OpeningVariantController::class,
            'store',
            \App\Http\Requests\OpeningVariantStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $order_position = $this->faker->numberBetween(-10000, 10000);
        $price = $this->faker->randomFloat(/** double_attributes **/);
        $depth = $this->faker->randomFloat(/** double_attributes **/);

        $response = $this->post(route('opening-variant.store'), [
            'order_position' => $order_position,
            'price' => $price,
            'depth' => $depth,
        ]);

        $openingVariants = OpenVariant::query()
            ->where('order_position', $order_position)
            ->where('price', $price)
            ->where('depth', $depth)
            ->get();
        $this->assertCount(1, $openingVariants);
        $openingVariant = $openingVariants->first();

        $response->assertRedirect(route('opening-variant.index'));
        $response->assertSessionHas('openingVariant.id', $openingVariant->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $openingVariant = OpenVariant::factory()->create();

        $response = $this->get(route('opening-variant.show', $openingVariant));

        $response->assertOk();
        $response->assertViewIs('openingVariant.show');
        $response->assertViewHas('openingVariant');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $openingVariant = OpenVariant::factory()->create();

        $response = $this->get(route('opening-variant.edit', $openingVariant));

        $response->assertOk();
        $response->assertViewIs('openingVariant.edit');
        $response->assertViewHas('openingVariant');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OpeningVariantController::class,
            'update',
            \App\Http\Requests\OpeningVariantUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $openingVariant = OpenVariant::factory()->create();
        $order_position = $this->faker->numberBetween(-10000, 10000);
        $price = $this->faker->randomFloat(/** double_attributes **/);
        $depth = $this->faker->randomFloat(/** double_attributes **/);

        $response = $this->put(route('opening-variant.update', $openingVariant), [
            'order_position' => $order_position,
            'price' => $price,
            'depth' => $depth,
        ]);

        $openingVariant->refresh();

        $response->assertRedirect(route('opening-variant.index'));
        $response->assertSessionHas('openingVariant.id', $openingVariant->id);

        $this->assertEquals($order_position, $openingVariant->order_position);
        $this->assertEquals($price, $openingVariant->price);
        $this->assertEquals($depth, $openingVariant->depth);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $openingVariant = OpenVariant::factory()->create();

        $response = $this->delete(route('opening-variant.destroy', $openingVariant));

        $response->assertRedirect(route('opening-variant.index'));

        $this->assertModelMissing($openingVariant);
    }
}
