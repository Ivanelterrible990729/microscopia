<?php

namespace Tests\Feature\CnnModel;

use App\Concerns\Tests\CustomMethods;
use App\Enums\Permissions\CnnModelPermission;
use App\Enums\RoleEnum;
use App\Models\CnnModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteCnnModelTest extends TestCase
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

    public function test_permisos_para_ver_boton_eliminar_modelo()
    {
        $this->actingAs($this->desarrollador);

        // Renderizado con permisos
        $response = $this->get(route('cnn-model.show', $this->cnnModel));
        $response->assertStatus(200)
            ->assertSee(__('Are you sure to delete the selected model?'));

        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, CnnModelPermission::Delete);

        // Renderizado sin permisos
        $response = $this->get(route('cnn-model.show', $this->cnnModel));
        $response->assertStatus(200)
            ->assertDontSee(__('Are you sure to delete the selected model?'));
    }

    public function test_permisos_para_eliminar_un_modelo()
    {
        // Valida que no se puede crear el rol sin los permisos
        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, CnnModelPermission::Delete);
        $this->actingAs($this->desarrollador);

        $response = $this->delete(route('cnn-model.destroy', $this->cnnModel));
        $response->assertForbidden();
    }

    public function test_funcionamiento_al_eliminar_un_modelo()
    {
        $this->actingAs($this->desarrollador);
        $modelName = $this->cnnModel->name;

        $response = $this->delete(route('cnn-model.destroy', $this->cnnModel));
        $response->assertRedirect(route('cnn-model.index'));

        // Valida existencia del registro en BD.
        $this->assertDatabaseCount('cnn_model_label', 3);
        $this->assertDatabaseMissing('cnn_models', [
            'name' => $modelName
        ]);
        $this->assertDatabaseMissing('media', [
            'name' => 'MobileNetV2.h5'
        ]);

        // Valida session del mensaje.
        $response->assertSessionHas([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The model has been successfully removed.')
            ]
        ]);
    }
}
