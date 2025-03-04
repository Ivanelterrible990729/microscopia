<?php

namespace Tests\Feature\Image;

use App\Concerns\Tests\CustomMethods;
use App\Enums\Permissions\ImagePermission;
use App\Enums\RoleEnum;
use App\Livewire\Image\ManageLabelsImage;
use App\Livewire\Tables\ImagesTable;
use App\Models\Image;
use App\Models\Label;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ManageLabelsImageTest extends TestCase
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
        $this->image = Image::factory(2)->create()->first();
    }

    /**
     * Permisos para ver el botón en la vista show.
     */
    public function test_el_usuario_puede_ver_el_boton_de_gestionar_etiquetas_en_la_vista_show(): void
    {
        $this->actingAs($this->tecnicoUnidad);

        $this->get(route('image.show', $this->image))
            ->assertSee(__('Manage labels'));

        $this->revokeRolePermissionTo(RoleEnum::TecnicoUnidad->value, ImagePermission::ManageLabels);

        $this->get(route('image.show', $this->image))
            ->assertDontSee(__('Manage labels'));
    }

    public function test_el_usuario_no_puede_ver_el_boton_de_gestionar_etiquetas_en_una_imagen_eliminada(): void
    {
        $this->actingAs($this->tecnicoUnidad);
        $this->image->delete();

        $this->get(route('image.show', $this->image))
            ->assertDontSee(__('Manage labels'));
    }

    public function test_valida_apertura_de_modal_para_gestionar_etiquetas(): void
    {
        $this->actingAs($this->tecnicoUnidad);

        Livewire::test(ManageLabelsImage::class)
            ->dispatch('manage-labels-image', $this->image->id)
            ->assertSet('image.id', $this->image->id)
            ->assertSet('form.labelIds', $this->image->labels()->pluck('labels.id')->toArray())
            ->assertDispatched('toggle-modal', [
                'id' => 'modal-manage-labels-image',
                'action' => 'show',
            ]);
    }

    public function test_permisos_para_gestionar_etiquetas(): void
    {
        $this->actingAs($this->tecnicoUnidad);

        $this->revokeRolePermissionTo(RoleEnum::TecnicoUnidad->value, ImagePermission::ManageLabels);

        Livewire::test(ManageLabelsImage::class)
            ->set('image', $this->image)
            ->set('form.labelIds', Label::inRandomOrder()->limit(2)->get()->pluck('id')->toArray())
            ->call('editLabels')
            ->assertForbidden();
    }

    public function test_comprueba_funcionamiento_para_gestionar_etiquetas(): void
    {
        $this->actingAs($this->tecnicoUnidad);
        $response = $this->get(route('image.show', $this->image));

        $newLabels = Label::inRandomOrder()->limit(2)->get()->pluck('id')->toArray();

        Livewire::test(ManageLabelsImage::class, ['image' => $this->image])
            ->set('image', $this->image)
            ->set('form.labelIds', $newLabels)
            ->call('editLabels')
            ->assertRedirectToRoute('image.show', $this->image);

        $response->assertSessionHas([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The image labels were successfully updated.')
            ]
        ]);

        $this->assertDatabaseHas('image_label', [
            'image_id' => $this->image->id,
            'label_id' => $newLabels[0],
        ]);

        $this->assertDatabaseHas('image_label', [
            'image_id' => $this->image->id,
            'label_id' => $newLabels[1],
        ]);
    }
}
