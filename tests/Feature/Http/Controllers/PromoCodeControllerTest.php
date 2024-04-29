<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\PromoCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PromoCodeController
 */
final class PromoCodeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $promoCodes = PromoCode::factory()->count(3)->create();

        $response = $this->get(route('promo-code.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PromoCodeController::class,
            'store',
            \App\Http\Requests\PromoCodeStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $code = $this->faker->word();
        $discount = $this->faker->randomFloat(/** double_attributes **/);
        $is_active = $this->faker->boolean();

        $response = $this->post(route('promo-code.store'), [
            'code' => $code,
            'discount' => $discount,
            'is_active' => $is_active,
        ]);

        $promoCodes = PromoCode::query()
            ->where('code', $code)
            ->where('discount', $discount)
            ->where('is_active', $is_active)
            ->get();
        $this->assertCount(1, $promoCodes);
        $promoCode = $promoCodes->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $promoCode = PromoCode::factory()->create();

        $response = $this->get(route('promo-code.show', $promoCode));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PromoCodeController::class,
            'update',
            \App\Http\Requests\PromoCodeUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $promoCode = PromoCode::factory()->create();
        $code = $this->faker->word();
        $discount = $this->faker->randomFloat(/** double_attributes **/);
        $is_active = $this->faker->boolean();

        $response = $this->put(route('promo-code.update', $promoCode), [
            'code' => $code,
            'discount' => $discount,
            'is_active' => $is_active,
        ]);

        $promoCode->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($code, $promoCode->code);
        $this->assertEquals($discount, $promoCode->discount);
        $this->assertEquals($is_active, $promoCode->is_active);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $promoCode = PromoCode::factory()->create();

        $response = $this->delete(route('promo-code.destroy', $promoCode));

        $response->assertNoContent();

        $this->assertModelMissing($promoCode);
    }
}
