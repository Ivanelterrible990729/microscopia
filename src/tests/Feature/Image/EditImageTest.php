<?php

namespace Tests\Feature\Image;

use App\Concerns\Tests\CustomMethods;
use App\Enums\Permissions\ImagePermission;
use App\Enums\RoleEnum;
use App\Livewire\Image\EditImage;
use App\Livewire\Tables\ImagesTable;
use App\Models\Image;
use App\Models\Label;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class EditImageTest extends TestCase
{
    use RefreshDatabase, WithFaker, CustomMethods;

    protected User $tecnicoUnidad;
    protected Image $image;

    /**
     * Prepara entorno para realizar el testing
     */
    public function setUp() : void
    {
        parent::setUp();

        $this->tecnicoUnidad = $this->getUser(RoleEnum::TecnicoUnidad);
        $this->image = Image::factory(3)->create()->first();
    }

    /**
     * Valida permisos para ver el botón de editar
     */
    public function test_permisos_para_ver_el_boton_de_editar_en_el_detalle_de_la_imagen()
    {
        $jefeUnidad = $this->getUser(RoleEnum::JefeUnidad);
        $this->actingAs($jefeUnidad);

        $this->get(route('image.show', $this->image))
            ->assertSee(route('image.edit', $this->image), false);

        $this->revokeRolePermissionTo(RoleEnum::JefeUnidad->value, ImagePermission::Update);

        $this->get(route('image.show', $this->image))
            ->assertDontSee(route('image.edit', $this->image), false);
    }

    /**
     * Valida permisos para NO ver el botón editar cuando la imagen está eliminada.
     */
    public function test_el_usuario_no_puede_ver_los_botones_de_editar_cuando_la_imagen_esta_eliminada()
    {
        Image::factory()->create()->delete();
        $deletedImage = Image::onlyTrashed()->first();

        $jefeUnidad = $this->getUser(RoleEnum::JefeUnidad);
        $this->actingAs($jefeUnidad);

        $this->get(route('image.show', $deletedImage))
            ->assertDontSee(route('image.edit', $deletedImage), false);
    }

    /**
     * Valida permimsos para ver el botón de editar imagen en el listado de imágenes.
     */
    public function test_permisos_para_ver_el_boton_de_editar_en_el_listado_de_imagenes()
    {
        $jefeUnidad = $this->getUser(RoleEnum::JefeUnidad);
        $this->actingAs($jefeUnidad);

        Livewire::test(ImagesTable::class)
            ->assertSee(__('Edit image'));

        $this->revokeRolePermissionTo(RoleEnum::JefeUnidad->value, ImagePermission::Update);

        Livewire::test(ImagesTable::class)
            ->assertDontSee(__('Edit image'));
    }

    /**
     * Valida acceso a la ruta image.edit.
     */
    public function test_permisos_para_acceder_al_formulario_de_edicion(): void
    {
        $this->actingAs($this->tecnicoUnidad);

        // Renderizado con permisos
        $response = $this->get(route('image.edit', $this->image));
        $response->assertOk()
            ->assertSee(__('Edit image'))
            ->assertSeeLivewire(EditImage::class);

        $this->revokeRolePermissionTo(RoleEnum::TecnicoUnidad->value, ImagePermission::Update);

        // Renderizado sin permisos
        $response = $this->get(route('image.edit', $this->image));
        $response->assertForbidden();
    }

    /**
     * Valida campos del formulario.
     */
    public function test_valida_campos_para_realizar_la_edicion_de_imagen(): void
    {
        $this->actingAs($this->tecnicoUnidad);

        // Valida nombre y labelIds.
        $component = Livewire::test(EditImage::class, ['image' => $this->image])
            ->assertSet('form.id', $this->image->id)
            ->set('form.name', '')
            ->set('form.labelIds', [99, 23])
            ->call('updateImage');

        $component->assertHasErrors([
            'form.name' => 'required',
            'form.labelIds.0' => 'exists',
            'form.labelIds.1' => 'exists',
        ]);
    }

    /**
     * Valida permisos para editar una imagen.
     */
    public function test_permisos_para_realizar_la_edicion_de_imagen(): void
    {
        $this->actingAs($this->tecnicoUnidad);
        $this->revokeRolePermissionTo(RoleEnum::TecnicoUnidad->value, ImagePermission::Update);

        $imageInput = Image::factory()->raw();
        $imageLabels = Label::inRandomOrder()
                ->limit(1)
                ->get()
                ->pluck('id')
                ->toArray();

        Livewire::test(EditImage::class, ['image' => $this->image])
            ->assertSet('form.id', $this->image->id)
            ->set('form.name', $imageInput['name'])
            ->set('form.labelIds', $imageLabels)
            ->call('updateImage')
            ->assertForbidden();
    }

    /**
     * Comprueba funcionamiento del formulario.
     */
    public function test_comprueba_funcionamiento_del_formulario_para_editar_la_imagen(): void
    {
        $this->actingAs($this->tecnicoUnidad);
        $response = $this->get(route('image.edit', $this->image));

        $imageInput = Image::factory()->raw();
        $imageLabels = Label::inRandomOrder()
                ->limit(1)
                ->get()
                ->pluck('id')
                ->toArray();

        Livewire::test(EditImage::class, ['image' => $this->image])
            ->assertSet('form.id', $this->image->id)
            ->set('form.name', $imageInput['name'])
            ->set('form.labelIds', $imageLabels)
            ->call('updateImage')
            ->assertHasNoErrors()
            ->assertRedirect(route('image.show', $this->image->id));

        // Valida existencia del registro en BD.
        $this->assertDatabaseHas('images', [
            'id' => $this->image->id,
            'name' => $imageInput['name'],
        ]);

        $this->assertDatabaseHas('image_label', [
            'image_id' => $this->image->id,
            'label_id' => $imageLabels[0],
        ]);

        // Valida session del mensaje.
        $response->assertSessionHas([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The image has been successfully updated.')
            ]
        ]);
    }
}
