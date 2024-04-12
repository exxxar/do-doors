<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Color;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ColorController
 */
final class ColorControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $colors = Color::factory()->count(3)->create();

        $response = $this->get(route('color.index'));

        $response->assertOk();
        $response->assertViewIs('color.index');
        $response->assertViewHas('colors');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('color.create'));

        $response->assertOk();
        $response->assertViewIs('color.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ColorController::class,
            'store',
            \App\Http\Requests\ColorStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $price = $this->faker->randomFloat(/** double_attributes **/);

        $response = $this->post(route('color.store'), [
            'price' => $price,
        ]);

        $colors = Color::query()
            ->where('price', $price)
            ->get();
        $this->assertCount(1, $colors);
        $color = $colors->first();

        $response->assertRedirect(route('color.index'));
        $response->assertSessionHas('color.id', $color->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $color = Color::factory()->create();

        $response = $this->get(route('color.show', $color));

        $response->assertOk();
        $response->assertViewIs('color.show');
        $response->assertViewHas('color');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $color = Color::factory()->create();

        $response = $this->get(route('color.edit', $color));

        $response->assertOk();
        $response->assertViewIs('color.edit');
        $response->assertViewHas('color');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ColorController::class,
            'update',
            \App\Http\Requests\ColorUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $color = Color::factory()->create();
        $price = $this->faker->randomFloat(/** double_attributes **/);

        $response = $this->put(route('color.update', $color), [
            'price' => $price,
        ]);

        $color->refresh();

        $response->assertRedirect(route('color.index'));
        $response->assertSessionHas('color.id', $color->id);

        $this->assertEquals($price, $color->price);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $color = Color::factory()->create();

        $response = $this->delete(route('color.destroy', $color));

        $response->assertRedirect(route('color.index'));

        $this->assertModelMissing($color);
    }
}
