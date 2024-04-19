<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\OrderController
 */
final class OrderControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $orders = Order::factory()->count(3)->create();

        $response = $this->get(route('order.index'));

        $response->assertOk();
        $response->assertViewIs('order.index');
        $response->assertViewHas('orders');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('order.create'));

        $response->assertOk();
        $response->assertViewIs('order.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OrderController::class,
            'store',
            \App\Http\Requests\OrderStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $status = $this->faker->numberBetween(-10000, 10000);
        $contract_amount = $this->faker->randomFloat(/** double_attributes **/);
        $paid = $this->faker->randomFloat(/** double_attributes **/);
        $debt = $this->faker->randomFloat(/** double_attributes **/);
        $profit = $this->faker->randomFloat(/** double_attributes **/);

        $response = $this->post(route('order.store'), [
            'status' => $status,
            'contract_amount' => $contract_amount,
            'paid' => $paid,
            'debt' => $debt,
            'profit' => $profit,
        ]);

        $orders = Order::query()
            ->where('status', $status)
            ->where('contract_amount', $contract_amount)
            ->where('paid', $paid)
            ->where('debt', $debt)
            ->where('profit', $profit)
            ->get();
        $this->assertCount(1, $orders);
        $order = $orders->first();

        $response->assertRedirect(route('order.index'));
        $response->assertSessionHas('order.id', $order->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $order = Order::factory()->create();

        $response = $this->get(route('order.show', $order));

        $response->assertOk();
        $response->assertViewIs('order.show');
        $response->assertViewHas('order');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $order = Order::factory()->create();

        $response = $this->get(route('order.edit', $order));

        $response->assertOk();
        $response->assertViewIs('order.edit');
        $response->assertViewHas('order');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OrderController::class,
            'update',
            \App\Http\Requests\OrderUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $order = Order::factory()->create();
        $status = $this->faker->numberBetween(-10000, 10000);
        $contract_amount = $this->faker->randomFloat(/** double_attributes **/);
        $paid = $this->faker->randomFloat(/** double_attributes **/);
        $debt = $this->faker->randomFloat(/** double_attributes **/);
        $profit = $this->faker->randomFloat(/** double_attributes **/);

        $response = $this->put(route('order.update', $order), [
            'status' => $status,
            'contract_amount' => $contract_amount,
            'paid' => $paid,
            'debt' => $debt,
            'profit' => $profit,
        ]);

        $order->refresh();

        $response->assertRedirect(route('order.index'));
        $response->assertSessionHas('order.id', $order->id);

        $this->assertEquals($status, $order->status);
        $this->assertEquals($contract_amount, $order->contract_amount);
        $this->assertEquals($paid, $order->paid);
        $this->assertEquals($debt, $order->debt);
        $this->assertEquals($profit, $order->profit);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $order = Order::factory()->create();

        $response = $this->delete(route('order.destroy', $order));

        $response->assertRedirect(route('order.index'));

        $this->assertModelMissing($order);
    }
}
