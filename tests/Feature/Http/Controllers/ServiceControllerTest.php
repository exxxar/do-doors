<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ServiceController
 */
final class ServiceControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $services = Service::factory()->count(3)->create();

        $response = $this->get(route('service.index'));

        $response->assertOk();
        $response->assertViewIs('service.index');
        $response->assertViewHas('services');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('service.create'));

        $response->assertOk();
        $response->assertViewIs('service.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ServiceController::class,
            'store',
            \App\Http\Requests\ServiceStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $order_position = $this->faker->numberBetween(-10000, 10000);
        $is_active = $this->faker->boolean();
        $price = $this->faker->;

        $response = $this->post(route('service.store'), [
            'order_position' => $order_position,
            'is_active' => $is_active,
            'price' => $price,
        ]);

        $services = Service::query()
            ->where('order_position', $order_position)
            ->where('is_active', $is_active)
            ->where('price', $price)
            ->get();
        $this->assertCount(1, $services);
        $service = $services->first();

        $response->assertRedirect(route('service.index'));
        $response->assertSessionHas('service.id', $service->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $service = Service::factory()->create();

        $response = $this->get(route('service.show', $service));

        $response->assertOk();
        $response->assertViewIs('service.show');
        $response->assertViewHas('service');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $service = Service::factory()->create();

        $response = $this->get(route('service.edit', $service));

        $response->assertOk();
        $response->assertViewIs('service.edit');
        $response->assertViewHas('service');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ServiceController::class,
            'update',
            \App\Http\Requests\ServiceUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $service = Service::factory()->create();
        $order_position = $this->faker->numberBetween(-10000, 10000);
        $is_active = $this->faker->boolean();
        $price = $this->faker->;

        $response = $this->put(route('service.update', $service), [
            'order_position' => $order_position,
            'is_active' => $is_active,
            'price' => $price,
        ]);

        $service->refresh();

        $response->assertRedirect(route('service.index'));
        $response->assertSessionHas('service.id', $service->id);

        $this->assertEquals($order_position, $service->order_position);
        $this->assertEquals($is_active, $service->is_active);
        $this->assertEquals($price, $service->price);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $service = Service::factory()->create();

        $response = $this->delete(route('service.destroy', $service));

        $response->assertRedirect(route('service.index'));

        $this->assertModelMissing($service);
    }
}
