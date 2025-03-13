<?php

namespace Tests\Feature\CnnModel;

use App\Concerns\Tests\CustomMethods;
use App\Enums\CnnModel\AvailableBaseModelsEnum;
use App\Enums\Permissions\CnnModelPermission;
use App\Enums\RoleEnum;
use App\Livewire\CnnModel\EditCnnModel;
use App\Models\CnnModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class EditCnnModelTest extends TestCase
{
    use RefreshDatabase, WithFaker, CustomMethods;

    protected User $desarrollador;
    protected CnnModel $cnnModel;

    /**
     * Prepara entorno para realizar el testing
     */
    public function setUp() : void
    {
        parent::setUp();

        $this->desarrollador = $this->getUser(RoleEnum::Desarrollador);
        $this->cnnModel = CnnModel::factory()->create();
    }

    public function test_permisos_para_ver_boton_editar_modelo()
    {
        $this->actingAs($this->desarrollador);

        // Renderizado con permisos
        $response = $this->get(route('cnn-model.show', $this->cnnModel));
        $response->assertStatus(200);
        $response->assertSeeLivewire(EditCnnModel::class);

        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, CnnModelPermission::Update);

        // Renderizado sin permisos
        $response = $this->get(route('cnn-model.show', $this->cnnModel));
        $response->assertStatus(200);
        $response->assertDontSeeLivewire(EditCnnModel::class);
    }

    public function test_validaciones_al_editar_un_modelo()
    {
        $this->actingAs($this->desarrollador);

        // Valida nombres unicos
        $otherModel = CnnModel::where('id', '!=', $this->cnnModel->id)->first();
        $componente = Livewire::test(EditCnnModel::class, ['cnnModel' => $this->cnnModel])
            ->set('form.name', $otherModel->name)
            ->call('updateModel')
            ->assertHasErrors([
                'form.name' => 'unique'
            ]);

        // // Valida etiquetas existentes en BD y mime de archivo
        $componente->set('form.name', pathinfo(AvailableBaseModelsEnum::MobileNetV2->value, PATHINFO_FILENAME))
            ->set('form.labelIds', [51, 52, 53]) // Etiquetas inexistentes
            ->set('form.file', UploadedFile::fake()->create('model.asd', 1024 * 5))
            ->call('updateModel')
            ->assertHasErrors([
                'form.labelIds.*',
                'form.file' => __('The file must have extension .keras'),
            ]);

        // // Valida campos requeridos
        $componente->set('form.name', '')
            ->set('form.labelIds', [])
            ->call('updateModel')
            ->assertHasErrors([
                'form.name' => 'required',
                'form.labelIds' => 'required'
            ]);
    }

    public function test_permisos_para_editar_un_modelo()
    {
        // Valida que no se puede crear el rol sin los permisos
        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, CnnModelPermission::Update);
        $this->actingAs($this->desarrollador);

        Livewire::test(EditCnnModel::class, ['cnnModel' => $this->cnnModel])
            ->set('form.name', 'new name')
            ->call('updateModel')
            ->assertForbidden();
    }

    public function test_funcionamiento_al_editar_un_modelo()
    {
        $this->actingAs($this->desarrollador);
        $response = $this->get(route('cnn-model.show', $this->cnnModel));
        $response->assertOk();

        $modelFile = UploadedFile::fake()->create('new-model.keras', 1024 * 5);
        Storage::fake(config('filesystems.default'));

        // Valida que no haya errores y redireccionamiento.
        Livewire::test(EditCnnModel::class, ['cnnModel' => $this->cnnModel])
            ->set('form.name', 'new name')
            ->set('form.file', $modelFile)
            ->call('updateModel')
            ->assertHasNoErrors()
            ->assertRedirect(route('cnn-model.show', $this->cnnModel));

        // Valida existencia del registro en BD.
        $this->assertDatabaseCount('cnn_model_label', 6);
        $this->assertDatabaseHas('cnn_models', [
            'name' => 'new name'
        ]);
        $this->assertDatabaseHas('media', [
            'name' => 'new-model.keras'
        ]);

        // Valida session del mensaje.
        $response->assertSessionHas([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The model has been successfully updated.')
            ]
        ]);
    }
}
