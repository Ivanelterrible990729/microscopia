<?php

namespace Tests\Feature\User;

use App\Concerns\Tests\CustomMethods;
use App\Enums\Permissions\UserPermission;
use App\Enums\RoleEnum;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RestoreUserTest extends TestCase
{
    use RefreshDatabase, WithFaker, CustomMethods;

    protected User $desarrollador;
    protected User $usuarioPrueba;

    /**
     * Prepara entorno para realizar el testing
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->desarrollador = $this->getUser(RoleEnum::Desarrollador);
        $this->usuarioPrueba = $this->getUser(RoleEnum::TecnicoUnidad);

        (new UserRepository())->delete($this->usuarioPrueba);
    }

    /**
     * Valida viualización de botón para restaurar usuario
     */
    public function test_permisos_para_ver_modal_restaurar_usuario()
    {
        $this->actingAs($this->desarrollador);

        // Renderizado con permisos
        $response = $this->get(route('user.show', $this->usuarioPrueba));
        $response->assertStatus(200);
        $response->assertSee(__('Are you sure to restore the selected user?'));
        $response->assertSee(__('This user is not active. Please restore the user to make effective any action of this user.'));

        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, UserPermission::Restore);

        // Renderizado sin permisos
        $response = $this->get(route('user.show', $this->usuarioPrueba));
        $response->assertStatus(200);
        $response->assertDontSee(__('Are you sure to restore the selected user?'));
        $response->assertSee(__('This user is not active. Please restore the user to make effective any action of this user.'));
    }

    /**
     * Permisos para restaurar un usuario
     */
    public function test_permisos_para_restaurar_un_usuario()
    {
        // Valida que no se puede restaurar a un usuario sin los permisos
        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, UserPermission::Restore);
        $this->actingAs($this->desarrollador);

        $response = $this->post(route('user.restore', $this->usuarioPrueba));
        $response->assertForbidden();
    }

    public function test_no_se_puede_restaurar_un_usuario_activo()
    {
        (new UserRepository)->restore($this->usuarioPrueba);
        $this->actingAs($this->desarrollador);

        // Renderizado al mismo usuario
        $response = $this->get(route('user.show', $this->usuarioPrueba));
        $response->assertStatus(200)
            ->assertDontSee(__('Restore'));
    }

    /**
     *  Valida funcionamiento para restaurar un usuario
     */
    public function test_funcionamiento_al_eliminar_un_usuario()
    {
        $this->actingAs($this->desarrollador);
        $userName = $this->usuarioPrueba->name;
        $deletedAt = $this->usuarioPrueba->deleted_at;

        $response = $this->post(route('user.restore', $this->usuarioPrueba));
        $response->assertRedirect(route('user.show', $this->usuarioPrueba));

        // Valida existencia del registro en BD.
        $this->assertDatabaseMissing('users', [
            'name' => $userName,
            'deleted_at' => $deletedAt,
        ]);

        // Valida session del mensaje.
        $response->assertSessionHas([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The user has been successfully restored.')
            ]
        ]);
    }
}
