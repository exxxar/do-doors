<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\OrderDetail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\OrderDetailController
 */
final class OrderDetailControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $orderDetails = OrderDetail::factory()->count(3)->create();

        $response = $this->get(route('order-detail.index'));

        $response->assertOk();
        $response->assertViewIs('orderDetail.index');
        $response->assertViewHas('orderDetails');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('order-detail.create'));

        $response->assertOk();
        $response->assertViewIs('orderDetail.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OrderDetailController::class,
            'store',
            \App\Http\Requests\OrderDetailStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $count = $this->faker->numberBetween(-10000, 10000);
        $price = $this->faker->randomFloat(/** double_attributes **/);

        $response = $this->post(route('order-detail.store'), [
            'count' => $count,
            'price' => $price,
        ]);

        $orderDetails = OrderDetail::query()
            ->where('count', $count)
            ->where('price', $price)
            ->get();
        $this->assertCount(1, $orderDetails);
        $orderDetail = $orderDetails->first();

        $response->assertRedirect(route('order-detail.index'));
        $response->assertSessionHas('orderDetail.id', $orderDetail->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $orderDetail = OrderDetail::factory()->create();

        $response = $this->get(route('order-detail.show', $orderDetail));

        $response->assertOk();
        $response->assertViewIs('orderDetail.show');
        $response->assertViewHas('orderDetail');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $orderDetail = OrderDetail::factory()->create();

        $response = $this->get(route('order-detail.edit', $orderDetail));

        $response->assertOk();
        $response->assertViewIs('orderDetail.edit');
        $response->assertViewHas('orderDetail');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OrderDetailController::class,
            'update',
            \App\Http\Requests\OrderDetailUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $orderDetail = OrderDetail::factory()->create();
        $count = $this->faker->numberBetween(-10000, 10000);
        $price = $this->faker->randomFloat(/** double_attributes **/);

        $response = $this->put(route('order-detail.update', $orderDetail), [
            'count' => $count,
            'price' => $price,
        ]);

        $orderDetail->refresh();

        $response->assertRedirect(route('order-detail.index'));
        $response->assertSessionHas('orderDetail.id', $orderDetail->id);

        $this->assertEquals($count, $orderDetail->count);
        $this->assertEquals($price, $orderDetail->price);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $orderDetail = OrderDetail::factory()->create();

        $response = $this->delete(route('order-detail.destroy', $orderDetail));

        $response->assertRedirect(route('order-detail.index'));

        $this->assertModelMissing($orderDetail);
    }
}
