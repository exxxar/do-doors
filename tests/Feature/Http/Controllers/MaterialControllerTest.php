<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Material;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MaterialController
 */
final class MaterialControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $materials = Material::factory()->count(3)->create();

        $response = $this->get(route('material.index'));

        $response->assertOk();
        $response->assertViewIs('material.index');
        $response->assertViewHas('materials');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('material.create'));

        $response->assertOk();
        $response->assertViewIs('material.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MaterialController::class,
            'store',
            \App\Http\Requests\MaterialStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $response = $this->post(route('material.store'));

        $response->assertRedirect(route('material.index'));
        $response->assertSessionHas('material.id', $material->id);

        $this->assertDatabaseHas(materials, [ /* ... */ ]);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $material = Material::factory()->create();

        $response = $this->get(route('material.show', $material));

        $response->assertOk();
        $response->assertViewIs('material.show');
        $response->assertViewHas('material');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $material = Material::factory()->create();

        $response = $this->get(route('material.edit', $material));

        $response->assertOk();
        $response->assertViewIs('material.edit');
        $response->assertViewHas('material');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MaterialController::class,
            'update',
            \App\Http\Requests\MaterialUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $material = Material::factory()->create();

        $response = $this->put(route('material.update', $material));

        $material->refresh();

        $response->assertRedirect(route('material.index'));
        $response->assertSessionHas('material.id', $material->id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $material = Material::factory()->create();

        $response = $this->delete(route('material.destroy', $material));

        $response->assertRedirect(route('material.index'));

        $this->assertModelMissing($material);
    }
}
