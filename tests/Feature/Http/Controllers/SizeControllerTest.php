<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Material;
use App\Models\Size;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SizeController
 */
final class SizeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $sizes = Size::factory()->count(3)->create();

        $response = $this->get(route('size.index'));

        $response->assertOk();
        $response->assertViewIs('size.index');
        $response->assertViewHas('sizes');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('size.create'));

        $response->assertOk();
        $response->assertViewIs('size.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SizeController::class,
            'store',
            \App\Http\Requests\SizeStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $width = $this->faker->numberBetween(-10000, 10000);
        $height = $this->faker->numberBetween(-10000, 10000);
        $material = Material::factory()->create();
        $price = $this->faker->randomFloat(/** double_attributes **/);
        $price_koef = $this->faker->randomFloat(/** double_attributes **/);
        $loops_count = $this->faker->numberBetween(-10000, 10000);

        $response = $this->post(route('size.store'), [
            'width' => $width,
            'height' => $height,
            'material_id' => $material->id,
            'price' => $price,
            'price_koef' => $price_koef,
            'loops_count' => $loops_count,
        ]);

        $sizes = Size::query()
            ->where('width', $width)
            ->where('height', $height)
            ->where('material_id', $material->id)
            ->where('price', $price)
            ->where('price_koef', $price_koef)
            ->where('loops_count', $loops_count)
            ->get();
        $this->assertCount(1, $sizes);
        $size = $sizes->first();

        $response->assertRedirect(route('size.index'));
        $response->assertSessionHas('size.id', $size->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $size = Size::factory()->create();

        $response = $this->get(route('size.show', $size));

        $response->assertOk();
        $response->assertViewIs('size.show');
        $response->assertViewHas('size');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $size = Size::factory()->create();

        $response = $this->get(route('size.edit', $size));

        $response->assertOk();
        $response->assertViewIs('size.edit');
        $response->assertViewHas('size');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SizeController::class,
            'update',
            \App\Http\Requests\SizeUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $size = Size::factory()->create();
        $width = $this->faker->numberBetween(-10000, 10000);
        $height = $this->faker->numberBetween(-10000, 10000);
        $material = Material::factory()->create();
        $price = $this->faker->randomFloat(/** double_attributes **/);
        $price_koef = $this->faker->randomFloat(/** double_attributes **/);
        $loops_count = $this->faker->numberBetween(-10000, 10000);

        $response = $this->put(route('size.update', $size), [
            'width' => $width,
            'height' => $height,
            'material_id' => $material->id,
            'price' => $price,
            'price_koef' => $price_koef,
            'loops_count' => $loops_count,
        ]);

        $size->refresh();

        $response->assertRedirect(route('size.index'));
        $response->assertSessionHas('size.id', $size->id);

        $this->assertEquals($width, $size->width);
        $this->assertEquals($height, $size->height);
        $this->assertEquals($material->id, $size->material_id);
        $this->assertEquals($price, $size->price);
        $this->assertEquals($price_koef, $size->price_koef);
        $this->assertEquals($loops_count, $size->loops_count);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $size = Size::factory()->create();

        $response = $this->delete(route('size.destroy', $size));

        $response->assertRedirect(route('size.index'));

        $this->assertModelMissing($size);
    }
}
