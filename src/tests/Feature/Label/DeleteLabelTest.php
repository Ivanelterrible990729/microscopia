<?php

namespace Tests\Feature\Label;

use App\Concerns\Tests\CustomMethods;
use App\Enums\Permissions\LabelPermission;
use App\Enums\RoleEnum;
use App\Livewire\Image\ManageLabelsImage;
use App\Livewire\Label\DeleteLabel;
use App\Livewire\Tables\ImagesTable;
use App\Models\Label;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteLabelTest extends TestCase
{
    use RefreshDatabase, WithFaker, CustomMethods;

    protected User $jefeUnidad;

    /**
     * Prepara entorno para realizar el testing
     */
    public function setUp() : void
    {
        parent::setUp();

        $this->jefeUnidad = $this->getUser(RoleEnum::JefeUnidad);
    }

    /**
     * Permisos para ver el botón
     */
    public function test_el_usuario_puede_ver_el_boton_para_eliminar_etiquetas(): void
    {
        $this->actingAs($this->jefeUnidad);

        $response = $this->get(route('image.index'));
        $response->assertOk()
            ->assertSee(__('Delete label'))
            ->assertSeeLivewire(DeleteLabel::class);

        $this->revokeRolePermissionTo(RoleEnum::JefeUnidad->value, LabelPermission::Delete);

        // Renderizado sin permisos
        $response = $this->get(route('image.index'));
        $response->assertOk()
            ->assertDontSee(__('Delete label'))
            ->assertDontSeeLivewire(DeleteLabel::class);
    }

    /**
     * Comprueba mecanismo para abrir el modal.
     */
    public function test_mecanismo_para_abrir_modal_al_eliminar_etiqueta()
    {
        $this->actingAs($this->jefeUnidad);

        $existingLabel = Label::inRandomOrder()->first();

        Livewire::test(DeleteLabel::class)
            ->dispatch('delete-label', $existingLabel->id)
            ->assertSet('label.id', $existingLabel->id)
            ->assertSet('numImagesAffected', $existingLabel->images()->count())
            ->assertSet('numModelsAffected', $existingLabel->models()->count())
            ->assertDispatched('toggle-modal', [
                'id' => 'modal-delete-label',
                'action' => 'show',
            ]);
    }

    /**
     * Valida permisos para eliminar una etiqueta
     */
    public function test_permisos_para_eliminar_una_etiqueta()
    {
        $this->actingAs($this->jefeUnidad);
        $this->revokeRolePermissionTo(RoleEnum::JefeUnidad->value, LabelPermission::Delete);

        $label = Label::inRandomOrder()->first();

        Livewire::test(DeleteLabel::class, ['label' => $label])
            ->call('deleteLabel')
            ->assertForbidden();
    }

    /**
     * Comprueba el funcionamiento de eliminanción.
     */
    public function test_comprueba_funcionamiento_al_eliminar_etiqueta()
    {
        $this->actingAs($this->jefeUnidad);

        $existingLabel = Label::inRandomOrder()->first();

        $component = Livewire::test(DeleteLabel::class, ['label' => $existingLabel])
            ->call('deleteLabel');

        $component->assertSet('label', null)
            ->assertDispatched('label-deleted')
            ->assertDispatched('toggle-modal', [
                'id' => 'modal-delete-label',
                'action' => 'hide',
            ]);

        $this->assertDatabaseMissing('labels', $existingLabel->getAttributes());
    }

    /**
     * El listado de imagenes refleja los cambios al eliminar una etiqueta.
     */
    public function test_el_listado_de_imagenes_se_actualiza_al_eliminar_etiquetas()
    {
        $this->actingAs($this->jefeUnidad);

        $existingLabel = Label::inRandomOrder()->first();

        Livewire::test(DeleteLabel::class, ['label' => $existingLabel])
            ->call('deleteLabel');

        Livewire::test(ImagesTable::class)
            ->dispatch('label-deleted',  __('The label has been successfully deleted.'))
            ->assertDispatched('toastify-js', [
                'id' => 'success-notification',
                'message' => __('The label has been successfully deleted.'),
                'title' => __('Success'),
            ]);
    }
}
