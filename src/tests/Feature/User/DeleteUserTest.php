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

class DeleteUserTest extends TestCase
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
    }

    public function test_permisos_para_ver_modal_eliminar_usuario()
    {
        $this->actingAs($this->desarrollador);

        // Renderizado con permisos
        $response = $this->get(route('user.show', $this->usuarioPrueba));
        $response->assertStatus(200)
            ->assertSee(__('Are you sure to delete the selected user?'));

        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, UserPermission::Delete);

        // Renderizado sin permisos
        $response = $this->get(route('user.show', $this->usuarioPrueba));
        $response->assertStatus(200)
            ->assertDontSee(__('Are you sure to delete the selected user?'));
    }

    public function test_no_se_puede_eliminar_un_usuario_ya_eliminado()
    {
        (new UserRepository)->delete($this->usuarioPrueba);
        $this->actingAs($this->desarrollador);

        // Renderizado al mismo usuario
        $response = $this->get(route('user.show', $this->usuarioPrueba));
        $response->assertStatus(200)
            ->assertDontSee(__('Delete'));
    }

    public function test_permisos_para_eliminar_un_usuario()
    {
        // Valida que no se puede eliminar a un usuario sin los permisos
        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, UserPermission::Delete);
        $this->actingAs($this->desarrollador);

        $response = $this->delete(route('user.destroy', $this->usuarioPrueba));
        $response->assertForbidden();

        // Valida que no se puede eliminar a su propio usuario
        $this->giveRolePermissionTo(RoleEnum::Desarrollador->value, UserPermission::Delete);
        $this->actingAs($this->desarrollador);

        $response = $this->delete(route('user.destroy', $this->desarrollador));
        $response->assertForbidden();

        // Valida que un usuario que no sea desarrollador elimine a un desarrollador
        $this->giveRolePermissionTo(RoleEnum::TecnicoUnidad->value, UserPermission::Delete);
        $this->actingAs($this->usuarioPrueba);

        $response = $this->delete(route('user.destroy', $this->desarrollador));
        $response->assertForbidden();
    }

    public function test_funcionamiento_al_eliminar_un_usuario()
    {
        $this->actingAs($this->desarrollador);
        $userName = $this->usuarioPrueba->name;

        $response = $this->delete(route('user.destroy', $this->usuarioPrueba));
        $response->assertRedirect(route('user.show', $this->usuarioPrueba));

        // Valida existencia del registro en BD.
        $this->assertDatabaseMissing('users', [
            'name' => $userName,
            'deleted_at' => null,
        ]);

        // Valida session del mensaje.
        $response->assertSessionHas([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The user has been successfully removed.')
            ]
        ]);
    }
}
