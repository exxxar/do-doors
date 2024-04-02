<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Handle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\HandleController
 */
final class HandleControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $handles = Handle::factory()->count(3)->create();

        $response = $this->get(route('handle.index'));

        $response->assertOk();
        $response->assertViewIs('handle.index');
        $response->assertViewHas('handles');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('handle.create'));

        $response->assertOk();
        $response->assertViewIs('handle.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\HandleController::class,
            'store',
            \App\Http\Requests\HandleStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $price = $this->faker->randomFloat(/** double_attributes **/);
        $variants = $this->faker->;

        $response = $this->post(route('handle.store'), [
            'price' => $price,
            'variants' => $variants,
        ]);

        $handles = Handle::query()
            ->where('price', $price)
            ->where('variants', $variants)
            ->get();
        $this->assertCount(1, $handles);
        $handle = $handles->first();

        $response->assertRedirect(route('handle.index'));
        $response->assertSessionHas('handle.id', $handle->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $handle = Handle::factory()->create();

        $response = $this->get(route('handle.show', $handle));

        $response->assertOk();
        $response->assertViewIs('handle.show');
        $response->assertViewHas('handle');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $handle = Handle::factory()->create();

        $response = $this->get(route('handle.edit', $handle));

        $response->assertOk();
        $response->assertViewIs('handle.edit');
        $response->assertViewHas('handle');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\HandleController::class,
            'update',
            \App\Http\Requests\HandleUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $handle = Handle::factory()->create();
        $price = $this->faker->randomFloat(/** double_attributes **/);
        $variants = $this->faker->;

        $response = $this->put(route('handle.update', $handle), [
            'price' => $price,
            'variants' => $variants,
        ]);

        $handle->refresh();

        $response->assertRedirect(route('handle.index'));
        $response->assertSessionHas('handle.id', $handle->id);

        $this->assertEquals($price, $handle->price);
        $this->assertEquals($variants, $handle->variants);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $handle = Handle::factory()->create();

        $response = $this->delete(route('handle.destroy', $handle));

        $response->assertRedirect(route('handle.index'));

        $this->assertModelMissing($handle);
    }
}
