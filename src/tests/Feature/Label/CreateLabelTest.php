<?php

namespace Tests\Feature\Label;

use App\Concerns\Tests\CustomMethods;
use App\Enums\Permissions\LabelPermission;
use App\Enums\RoleEnum;
use App\Livewire\Image\EditLabelsImage;
use App\Livewire\Label\CreateLabel;
use App\Livewire\Tables\ImagesTable;
use App\Models\Label;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CreateLabelTest extends TestCase
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
     * Se validan permisos para ver el botón de nueva etiqueta.
     */
    public function test_el_usuario_puede_ver_el_boton_de_crear_etiqueta(): void
    {
        $this->actingAs($this->desarrollador);

        $response = $this->get(route('image.index'));
        $response->assertOk()
            ->assertSee(__('New label'))
            ->assertSeeLivewire(CreateLabel::class);

        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, LabelPermission::Create);

        // Renderizado sin permisos
        $response = $this->get(route('image.index'));
        $response->assertOk()
            ->assertDontSee(__('New label'))
            ->assertDontSeeLivewire(CreateLabel::class);
    }

    /**
     * Se validan permisos para la acción de crear etiqueta.
     */
    public function test_permisos_para_crear_una_etiqueta(): void
    {
        $this->actingAs($this->desarrollador);
        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, LabelPermission::Create);

        $labelContent = Label::factory()->raw();

        Livewire::test(CreateLabel::class)
            ->set('form', $labelContent)
            ->call('storeLabel')
            ->assertForbidden();
    }

    /**
     * Se validan los campos del formulario.
     */
    public function test_validaciones_para_crear_etiqueta(): void
    {
        $this->actingAs($this->desarrollador);

        $component = Livewire::test(CreateLabel::class);

        // Valida nombre y colores únicos.
        $input = Label::inRandomOrder()->first()->getAttributes();
        $component->set('form.name', $input['name'])
            ->set('form.color', $input['color'])
            ->call('storeLabel')
            ->assertHasErrors([
                'form.name' => 'unique',
                'form.color' => 'unique',
            ]);

        // Valida limite de 255 caracteres para nombre y 7 caracteres para color.
        $component->set('form.name', str_repeat($this->faker->words(50, true) . ' ', 5))
            ->set('form.color', 'this is not a color')
            ->call('storeLabel')
            ->assertHasErrors([
                'form.name' => 'max',
                'form.color' => 'max',
            ]);
    }

    /**
     * Se comprueba el funcionamiento (caso exitoso)
     */
    public function test_comprueba_funcionamiento_al_crear_etiqueta(): void
    {
        $this->actingAs($this->desarrollador);

        $labelContent = Label::factory()->raw();

        $component = Livewire::test(CreateLabel::class)
            ->set('form', $labelContent)
            ->call('storeLabel');

        $component->assertHasNoErrors()
        ->assertSet('form.name', '')
        ->assertSet('form.description', null)
        ->assertSet('form.color', '#FFFFFF')
        ->assertDispatched('label-created')
        ->assertDispatched('toggle-modal', [
            'id' => 'modal-create-label',
            'action' => 'hide',
        ]);

        $this->assertDatabaseHas('labels', $labelContent);
    }

    /**
     * El listado refleja los cambios con la etiqueta creada
     */
    public function test_el_listado_de_imagenes_se_actualiza_al_crear_etiqueta(): void
    {
        $this->actingAs($this->desarrollador);

        $labelContent = Label::factory()->raw();

        Livewire::test(CreateLabel::class)
            ->set('form', $labelContent)
            ->call('storeLabel');

        Livewire::test(ImagesTable::class)
            ->dispatch('label-created',  __('The label has been successfully stored.'))
            ->assertDispatched('toastify-js', [
                'id' => 'success-notification',
                'message' => __('The label has been successfully stored.'),
                'title' => __('Success'),
            ]);
    }

    /**
     * El componente de editar etiquetas se actualiza al crear una etiqueta.
     */
    public function test_el_componente_de_edicion_de_etiquetas_de_imagenes_al_crear_etiqueta(): void
    {
        $this->actingAs($this->desarrollador);

        $labelContent = Label::factory()->raw();

        Livewire::test(CreateLabel::class)
            ->set('form', $labelContent)
            ->call('storeLabel');

        Livewire::test(EditLabelsImage::class)
            ->dispatch('label-created')
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
