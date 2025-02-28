<?php

namespace Tests\Feature\Label;

use App\Concerns\Tests\CustomMethods;
use App\Enums\Permissions\LabelPermission;
use App\Enums\RoleEnum;
use App\Livewire\Image\EditLabelsImage;
use App\Livewire\Label\EditLabel;
use App\Livewire\Tables\ImagesTable;
use App\Models\Label;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class EditLabelTest extends TestCase
{
    use RefreshDatabase, WithFaker, CustomMethods;

    protected User $desarrollador;

    /**
     * Prepara entorno para realizar el testing
     */
    public function setUp() : void
    {
        parent::setUp();

        $this->desarrollador = $this->getUser(RoleEnum::Desarrollador);
    }

    /**
     * Permisos para ver el botón
     */
    public function test_el_usuario_puede_ver_el_boton_para_editar_etiquetas(): void
    {
        $this->actingAs($this->desarrollador);

        $response = $this->get(route('image.index'));
        $response->assertOk()
            ->assertSee(__('Edit label'))
            ->assertSeeLivewire(EditLabel::class);

        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, LabelPermission::Update);

        // Renderizado sin permisos
        $response = $this->get(route('image.index'));
        $response->assertOk()
            ->assertDontSee(__('Edit label'))
            ->assertDontSeeLivewire(EditLabel::class);
    }

    /**
     * Comprueba mecanismo para abrir el modal.
     */
    public function test_mecanismo_para_abrir_modal_para_editar_etiqueta()
    {
        $this->actingAs($this->desarrollador);

        $existingLabel = Label::inRandomOrder()->first();

        Livewire::test(EditLabel::class)
            ->dispatch('edit-label', $existingLabel->id)
            ->assertSet('label.id', $existingLabel->id)
            ->assertSet('form.id', $existingLabel->id)
            ->assertSet('form.name', $existingLabel->name)
            ->assertSet('form.description', $existingLabel->description)
            ->assertSet('form.color', $existingLabel->color)
            ->assertDispatched('toggle-modal', [
                'id' => 'modal-edit-label',
                'action' => 'show',
            ]);
    }

    /**
     * Valida permisos para editar una etiqueta
     */
    public function test_permisos_para_editar_una_etiqueta()
    {
        $this->actingAs($this->desarrollador);
        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, LabelPermission::Update);

        $label = Label::inRandomOrder()->first();
        $newContent = Label::factory()->raw();

        Livewire::test(EditLabel::class, ['label' => $label])
            ->set('form', $newContent)
            ->call('updateLabel')
            ->assertForbidden();
    }

    /**
     * Se validan los campos de formulario
     */
    public function test_validaciones_para_editar_una_etiqueta()
    {
        $this->actingAs($this->desarrollador);

        $input = Label::inRandomOrder()->first()->getAttributes();
        $existingLabel = Label::where('id', '!=', $input['id'])->first();

        $component = Livewire::test(EditLabel::class, ['label' => $existingLabel]);

        // Valida nombre y colores únicos.
        $component->set('form.name', $input['name'])
            ->set('form.color', $input['color'])
            ->call('updateLabel')
            ->assertHasErrors([
                'form.name' => 'unique',
                'form.color' => 'unique',
            ]);
    }

    /**
     * Comprueba el funcionamiento de edición.
     */
    public function test_comprueba_funcionamiento_al_editar_etiqueta()
    {
        $this->actingAs($this->desarrollador);

        $existingLabel = Label::inRandomOrder()->first();
        $labelContent = Label::factory()->raw();

        $component = Livewire::test(EditLabel::class, ['label' => $existingLabel])
            ->set('form', $labelContent)
            ->call('updateLabel');

        $component->assertHasNoErrors()
        ->assertSet('form.name', '')
        ->assertSet('form.description', null)
        ->assertSet('form.color', '#FFFFFF')
        ->assertSet('label', null)
        ->assertDispatched('label-updated')
        ->assertDispatched('toggle-modal', [
            'id' => 'modal-edit-label',
            'action' => 'hide',
        ]);

        $this->assertDatabaseHas('labels', $labelContent);
    }

    /**
     * El listado de imagenes refleja los cambios al editar una etiqueta.
     */
    public function test_el_listado_de_imagenes_se_actualiza_al_editar_etiquetas()
    {
        $this->actingAs($this->desarrollador);

        $existingLabel = Label::inRandomOrder()->first();
        $labelContent = Label::factory()->raw();

        Livewire::test(EditLabel::class, ['label' => $existingLabel])
            ->set('form', $labelContent)
            ->call('updateLabel');

        Livewire::test(ImagesTable::class)
            ->dispatch('label-updated',  __('The label has been successfully updated.'))
            ->assertDispatched('toastify-js', [
                'id' => 'success-notification',
                'message' => __('The label has been successfully updated.'),
                'title' => __('Success'),
            ]);
    }

    /**
     * El componente de editar etiquetas se actualiza al editar una etiqueta.
     */
    public function test_el_componente_de_edicion_de_etiquetas_de_imagenes_al_editar_etiqueta(): void
    {
        $this->actingAs($this->desarrollador);

        $existingLabel = Label::inRandomOrder()->first();
        $labelContent = Label::factory()->raw();

        Livewire::test(EditLabel::class, ['label' => $existingLabel])
            ->set('form', $labelContent)
            ->call('updateLabel');

        Livewire::test(EditLabelsImage::class)
            ->dispatch('label-updated')
            ->assertSet('availableLabels',  Label::query()
            ->orderBy('name')
            ->get()
            ->map(function($label) {
                return [
                    'id' => $label->id,
                    'name' => $label->name,
                    'color' => $label->color,
                ];
            })->toArray());
    }
}

