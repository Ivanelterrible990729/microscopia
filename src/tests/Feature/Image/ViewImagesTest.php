<?php

namespace Tests\Feature\Image;

use App\Concerns\Tests\CustomMethods;
use App\Enums\Permissions\ImagePermission;
use App\Enums\RoleEnum;
use App\Livewire\Tables\ImagesTable;
use App\Models\Image;
use App\Models\Label;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
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

        Image::factory(5)->create();
    }

    /**
     * Permisos para acceder al listado.
     */
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
        $response->assertSeeLivewire(ImagesTable::class);

        // Se visualizan las 5 imágenes creadas.
        $response->assertSeeHtmlInOrder(Image::orderBy('deleted_at', 'desc')->pluck('name')->toArray());
    }

    /**
     * Permisos para acceder a una imagen en específico.
     */
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

    /**
     * Se prueba el listado aplicando el filtrado de etiquetas.
     */
    public function test_comprueba_filtrado_por_etiqueta(): void
    {
        $this->actingAs($this->tecnico);
        $label = Label::whereHas('images')->first();

        $component = Livewire::test(ImagesTable::class)
            ->call("setFilterLabels", $label->id);

        $component->assertSeeHtmlInOrder(Image::whereHas('labels', function ($query) use ($label) {
                $query->where('image_label.label_id', $label->id);
            })
            ->orderBy('created_at', 'desc')
            ->pluck('name')
            ->toArray()
        );
    }

    /**
     * Se prueba el listado aplicando el filtrado de imagenes eliminadas.
     */
    public function test_comprueba_filtrado_por_papelera(): void
    {
        $this->actingAs($this->tecnico);

        $image = Image::inRandomOrder()->first();
        $image->delete();

        $component = Livewire::test(ImagesTable::class)
            ->call("setFilterImages", 'trashed');

        $component->assertSee($image->name);
    }
}
