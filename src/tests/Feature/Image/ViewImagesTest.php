<?php

namespace Tests\Feature\Image;

use App\Concerns\Tests\CustomMethods;
use App\Enums\Permissions\ImagePermission;
use App\Enums\RoleEnum;
use App\Livewire\Listados\ImageTable;
use App\Models\Image;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewImagesTest extends TestCase
{
    use RefreshDatabase, WithFaker, CustomMethods;

    protected User $jefe;
    protected User $tecnico;

    /**
     * Prepara entorno para realizar el testing
     */
    public function setUp() : void
    {
        parent::setUp();

        $this->jefe = $this->getUser(RoleEnum::JefeUnidad);
        $this->tecnico = $this->getUser(RoleEnum::TecnicoUnidad);

        Image::factory(5)->create([
            'user_id' => $this->tecnico->id,
        ]);
    }

    public function test_permisos_para_acceder_al_listado_de_gestion_de_imagenes(): void
    {
        // Usuario sin permisos para acceder al listado.
        $this->revokeRolePermissionTo(RoleEnum::TecnicoUnidad->value, ImagePermission::ViewAny);
        $this->actingAs($this->tecnico);
        $response = $this->get(route('image.index'));
        $response->assertForbidden();

        // Usuario con permisos para acceder al listado.
        $this->giveRolePermissionTo(RoleEnum::TecnicoUnidad->value, ImagePermission::ViewAny);
        $this->actingAs($this->tecnico);
        $response = $this->get(route('image.index'));
        $response->assertStatus(200);
        $response->assertSee(__('Image management'));
        $response->assertSeeLivewire(ImageTable::class);
    }

    public function test_permisos_para_ver_una_imagen_en_especifico(): void
    {
        $image = Image::inRandomOrder()->first();

        // Usuario sin permisos
        $this->revokeRolePermissionTo(RoleEnum::JefeUnidad->value, ImagePermission::View);
        $this->actingAs($this->jefe);
        $response = $this->get(route('image.show', $image));
        $response->assertForbidden();

        // Usuario con permisos
        $this->giveRolePermissionTo(RoleEnum::JefeUnidad->value, ImagePermission::View);
        $this->actingAs($this->jefe);
        $response = $this->get(route('image.show', $image));
        $response->assertStatus(200);
        $response->assertSee($image->name);
    }
}
