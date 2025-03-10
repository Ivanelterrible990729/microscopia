<?php

namespace Tests\Feature\Image;

use App\Concerns\Tests\CustomMethods;
use App\Enums\Permissions\ImagePermission;
use App\Enums\RoleEnum;
use App\Livewire\Image\ManageImageDeletion;
use App\Livewire\Tables\ImagesTable;
use App\Models\Image;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ManageImageDeletionTest extends TestCase
{
    use RefreshDatabase, WithFaker, CustomMethods;

    protected User $jefeUnidad;
    protected Image $image;
    protected Image $deletedImage;

    /**
     * Prepara entorno para realizar el testing
     */
    public function setUp() : void
    {
        parent::setUp();

        $this->jefeUnidad = $this->getUser(RoleEnum::JefeUnidad);

        Image::factory(3)->create();
        Image::factory(3)->create()->each->delete();

        $this->image = Image::inRandomOrder()->first();
        $this->deletedImage = Image::onlyTrashed()->first();
    }

    /**
     * Eliminar desde vista image.show
     */
    public function test_el_usuario_puede_ver_el_boton_eliminar_o_restaurar_una_imagen_desde_vista_show(): void
    {
        $this->actingAs($this->jefeUnidad);

        $this->get(route('image.show', $this->image))
            ->assertSee(__('Delete'));

        $this->revokeRolePermissionTo(RoleEnum::JefeUnidad->value, ImagePermission::Delete);

        $this->get(route('image.show', $this->image))
            ->assertDontSee(__('Delete'));

        // Ver el botón restaurar

        $this->get(route('image.show', $this->deletedImage))
            ->assertSee(__('Restore'));

        $this->revokeRolePermissionTo(RoleEnum::JefeUnidad->value, ImagePermission::Restore);

        $this->get(route('image.show', $this->deletedImage))
            ->assertDontSee(__('Restore'));
    }

    public function test_el_usuario_puede_ver_el_boton_eliminar_o_restaurar_una_imagen_desde_el_listado(): void
    {
        $this->actingAs($this->jefeUnidad);

        // Ver el botón eliminar

        Livewire::test(ImagesTable::class)
            ->assertSee(__('Delete image'));

        $this->revokeRolePermissionTo(RoleEnum::JefeUnidad->value, ImagePermission::Delete);

        Livewire::test(ImagesTable::class)
            ->assertDontSee(__('Delete image'));

        // Ver el botón restaurar

        Livewire::test(ImagesTable::class)
            ->call("setFilterImages", 'trashed')
            ->assertSee(__('Restore image'));

        $this->revokeRolePermissionTo(RoleEnum::JefeUnidad->value, ImagePermission::Restore);

        Livewire::test(ImagesTable::class)
            ->assertDontSee(__('Restore image'));
    }

    public function test_el_usuario_puede_ver_el_boton_eliminar_o_restaurar_imagenes_por_lote_desde_el_listado(): void
    {
        $this->actingAs($this->jefeUnidad);

        // Ver el botón eliminar

        Livewire::test(ImagesTable::class, ['selectedImages' => Image::all()->pluck('id')->toArray()])
            ->call("setFilterImages", 'active')
            ->assertSee(__('Delete images'));

        $this->revokeRolePermissionTo(RoleEnum::JefeUnidad->value, ImagePermission::Delete);
        $this->revokeRolePermissionTo(RoleEnum::JefeUnidad->value, ImagePermission::Restore);

        Livewire::test(ImagesTable::class)
            ->call("setFilterImages", 'active')
            ->assertDontSee(__('Delete images'));

        // Ver el botón restaurar

        Livewire::test(ImagesTable::class, ['selectedImages' => Image::onlyTrashed()->pluck('id')->toArray()])
            ->call("setFilterImages", 'trashed')
            ->assertDontSee(__('Restore images'));

        $this->giveRolePermissionTo(RoleEnum::JefeUnidad->value, ImagePermission::Restore);

        Livewire::test(ImagesTable::class)
            ->call("setFilterImages", 'trashed')
            ->assertSee(__('Restore images'));
    }

    /**
     * Valida apertura de modales tanto para eliminar como para restaurar
     */
    public function test_valida_apertura_de_modal_para_eliminar_y_restaurar_imagenes(): void
    {
        $this->actingAs($this->jefeUnidad);

        // Para eliminar
        Livewire::test(ManageImageDeletion::class)
            ->dispatch('delete-images', $this->image->id)
            ->assertSet('mode', 'images-deleted')
            ->assertDispatched('toggle-modal', [
                'id' => 'modal-manage-image-deletion',
                'action' => 'show',
            ])
            ->assertSee(__('Image deletion'))
            ->assertSee(__('Images that are deleted will be sent to the image garbage can.'))
            ->assertSee(__('Delete'));

        // Para restaurar
        Livewire::test(ManageImageDeletion::class)
            ->dispatch('restore-images', $this->image->id)
            ->assertSet('mode', 'images-restored')
            ->assertDispatched('toggle-modal', [
                'id' => 'modal-manage-image-deletion',
                'action' => 'show',
            ])
            ->assertSee(__('Image restore'))
            ->assertSee(__('Restored images will be displayed again by default.'))
            ->assertSee(__('Restore'));
    }

    /**
     * Valida permisos para realizar la eliminación o restauración de imágenes.
     */
    public function test_permisos_para_eliminar_o_restaurar_una_imagen(): void
    {
        $this->actingAs($this->jefeUnidad);

        // Permisos para eliminar
        $this->revokeRolePermissionTo(RoleEnum::JefeUnidad->value, ImagePermission::Delete);

        Livewire::test(ManageImageDeletion::class)
            ->set('mode', 'images-deleted')
            ->set('imageIds', [$this->image->id])
            ->call('performAction')
            ->assertForbidden();

        // Permisos para restaurar
        $this->revokeRolePermissionTo(RoleEnum::JefeUnidad->value, ImagePermission::Restore);

        Livewire::test(ManageImageDeletion::class)
            ->set('mode', 'images-restored')
            ->set('imageIds', [$this->deletedImage->id])
            ->call('performAction')
            ->assertForbidden();
    }

    public function test_comprueba_funcionamiento_para_eliminar_una_imagen(): void
    {
        $this->actingAs($this->jefeUnidad);

        // Eliminar 1 imagen
        Livewire::test(ManageImageDeletion::class)
            ->set('mode', 'images-deleted')
            ->set('imageIds', [$this->image->id])
            ->call('performAction')
            ->assertDispatched('images-deleted')
            ->assertDispatched('toggle-modal', [
                'id' => 'modal-manage-image-deletion',
                'action' => 'hide',
            ]);

        $this->image->refresh();
        $this->assertTrue(isset($this->image->deleted_at));
    }

    public function test_comprueba_funcionamiento_para_restaurar_una_imagen(): void
    {
        $this->actingAs($this->jefeUnidad);

        // Restaurar 1 imagen
        Livewire::test(ManageImageDeletion::class)
            ->set('mode', 'images-restored')
            ->set('imageIds', [$this->deletedImage->id])
            ->call('performAction')
            ->assertDispatched('images-restored')
            ->assertDispatched('toggle-modal', [
                'id' => 'modal-manage-image-deletion',
                'action' => 'hide',
            ]);

        $this->deletedImage->refresh();
        $this->assertTrue(is_null($this->deletedImage->deleted_at));
    }
}
