<?php

namespace Tests\Feature\Role;

use App\Concerns\Tests\CustomMethods;
use App\Enums\Permissions\RolePermission;
use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DeleteRoleTest extends TestCase
{
    use RefreshDatabase, WithFaker, CustomMethods;

    protected User $desarrollador;
    protected Role $role;

    /**
     * Prepara entorno para realizar el testing
     */
    public function setUp() : void
    {
        parent::setUp();

        $this->desarrollador = $this->getUser(RoleEnum::Desarrollador);
        $this->role = Role::where('name', '!=', RoleEnum::Desarrollador)->first();
    }

    public function test_permisos_para_ver_boton_eliminar_rol()
    {
        $this->actingAs($this->desarrollador);

        // Renderizado con permisos
        $response = $this->get(route('role.show', $this->role));
        $response->assertStatus(200)
            ->assertSee(__('Delete'))
            ->assertSee(__('Are you sure to delete the selected role?'));

        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, RolePermission::Delete);

        // Renderizado sin permisos
        $response = $this->get(route('role.show', $this->role));
        $response->assertStatus(200)
            ->assertDontSee(__('Delete'))
            ->assertDontSee(__('Are you sure to delete the selected role?'));
    }

    public function test_permisos_para_eliminar_un_rol()
    {
        // Valida que no se puede crear el rol sin los permisos
        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, RolePermission::Delete);
        $this->actingAs($this->desarrollador);

        $response = $this->delete(route('role.destroy', $this->role));
        $response->assertForbidden();
    }

    public function test_funcionamiento_al_eliminar_un_rol()
    {
        $this->actingAs($this->desarrollador);
        $roleName = $this->role->name;

        $response = $this->delete(route('role.destroy', $this->role));
        $response->assertRedirect(route('role.index'));

        // Valida existencia del registro en BD.
        $this->assertDatabaseMissing('roles', [
            'name' => $roleName
        ]);

        // Valida session del mensaje.
        $response->assertSessionHas([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The role has been successfully removed.')
            ]
        ]);
    }
}
