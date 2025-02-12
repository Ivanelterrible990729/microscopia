<?php

namespace Tests\Feature\CnnModel;

use App\Concerns\Tests\CustomMethods;
use App\Enums\CnnModel\AvailableModelsEnum;
use App\Enums\Permissions\CnnModelPermission;
use App\Enums\RoleEnum;
use App\Livewire\CnnModel\CreateCnnModel;
use App\Models\CnnModel;
use App\Models\Label;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class CreateCnnModelTest extends TestCase
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

    public function test_permisos_para_ver_boton_crear_modelo()
    {
        $this->actingAs($this->desarrollador);

        // Renderizado con permisos
        $response = $this->get(route('cnn-model.index'));
        $response->assertStatus(200)
            ->assertSee(__('Create CNN model'))
            ->assertSeeLivewire(CreateCnnModel::class);

        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, CnnModelPermission::Create);

        // Renderizado sin permisos
        $response = $this->get(route('cnn-model.index'));
        $response->assertStatus(200)
            ->assertDontSee(__('Create CNN model'))
            ->assertDontSeeLivewire(CreateCnnModel::class);
    }

    public function test_validaciones_al_crear_un_modelo()
    {
        $this->actingAs($this->desarrollador);

        // Valida nombres unicos
        $componente = Livewire::test(CreateCnnModel::class)
            ->set('form.name', CnnModel::inRandomOrder()->first()->name)
            ->call('createModel')
            ->assertHasErrors([
                'form.name' => 'unique'
            ]);

        // Valida etiquetas existentes en BD y mime de archivo
        $componente->set('form.name', pathinfo(AvailableModelsEnum::VGG16->value, PATHINFO_FILENAME))
            ->set('form.labelIds', [51, 52, 53]) // Etiquetas inexistentes
            ->set('form.file', UploadedFile::fake()->create('model.asd', 1024 * 5))
            ->call('createModel')
            ->assertHasErrors([
                'form.labelIds.*',
                'form.file' => __('The file must have extension .h5'),
            ]);

        // Valida campos requeridos
        $componente->set('form.name', '')
            ->set('form.labelIds', [])
            ->call('createModel')
            ->assertHasErrors([
                'form.name' => 'required',
                'form.labelIds' => 'required'
            ]);
    }

    public function test_permisos_para_crear_un_modelo()
    {
        // Valida que no se puede crear el rol sin los permisos
        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, CnnModelPermission::Create);
        $this->actingAs($this->desarrollador);

        Livewire::test(CreateCnnModel::class)
            ->set('form.name', pathinfo(AvailableModelsEnum::VGG16->value, PATHINFO_FILENAME))
            ->set('form.labelIds', Label::inRandomOrder()->limit(3)->pluck('id')->toArray())
            ->call('createModel')
            ->assertForbidden();
    }

    public function test_funcionamiento_al_crear_un_modelo()
    {
        $this->actingAs($this->desarrollador);
        $response = $this->get(route('cnn-model.index'));
        $response->assertOk();

        $modelName = pathinfo(AvailableModelsEnum::VGG16->value, PATHINFO_FILENAME);
        $modelFile = UploadedFile::fake()->create('model.h5', 1024 * 5);
        Storage::fake(config('filesystems.default'));

        // Valida que no haya errores y redireccionamiento.
        Livewire::test(CreateCnnModel::class)
            ->set('form.name', $modelName)
            ->set('form.labelIds', Label::inRandomOrder()->limit(3)->get()->pluck('id')->toArray())
            ->set('form.file', $modelFile)
            ->call('createModel')
            ->assertHasNoErrors()
            ->assertRedirect(route('cnn-model.show', CnnModel::whereName($modelName)->first()));

        // Valida existencia del registro en BD.
        $this->assertDatabaseCount('cnn_model_label', 6);
        $this->assertDatabaseHas('cnn_models', [
            'name' => $modelName
        ]);
        $this->assertDatabaseHas('media', [
            'name' => 'model.h5'
        ]);

        // Valida session del mensaje.
        $response->assertSessionHas([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The model has been successfully stored.')
            ]
        ]);
    }
}
