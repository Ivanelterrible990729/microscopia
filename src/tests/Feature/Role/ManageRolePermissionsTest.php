<?php

namespace Tests\Feature\Role;

use App\Concerns\Tests\CustomMethods;
use App\Enums\Permissions\RolePermission;
use App\Enums\RoleEnum;
use App\Livewire\Role\ManageRolePermissions;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ManageRolePermissionsTest extends TestCase
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
        $this->role = Role::inRandomOrder()->first();
    }

    public function test_permisos_para_ver_boton_relacionar_permisos()
    {
        $this->actingAs($this->desarrollador);

        // Renderizado con permisos
        $response = $this->get(route('role.show', $this->role));
        $response->assertStatus(200)
            ->assertSee(__('Permissions'))
            ->assertSeeLivewire(ManageRolePermissions::class);

        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, RolePermission::ManagePermissions);

        // Renderizado sin permisos
        $response = $this->get(route('role.show', $this->role));
        $response->assertStatus(200)
            ->assertDontSee(__('Permissions'))
            ->assertDontSeeLivewire(ManageRolePermissions::class);
    }

    public function test_permisos_para_relacionar_permisos()
    {
        // Valida que no se pueden relacionar permisos sin el permiso adecuado
        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, RolePermission::ManagePermissions);
        $this->actingAs($this->desarrollador);

        Livewire::test(ManageRolePermissions::class, ['role' => $this->role])
            ->set('form.selectedPermissions', Permission::inRandomOrder()->limit(3)->pluck('name')->toArray())
            ->call('storePermissions')
            ->assertNoRedirect();
    }

    public function test_funcionamiento_al_relacionar_permisos()
    {
        $this->actingAs($this->desarrollador);
        $response = $this->get(route('role.show', $this->role));
        $permissions = Permission::inRandomOrder()->limit(3)->get();

        // Valida que no haya errores y redireccionamiento.
        Livewire::test(ManageRolePermissions::class, ['role' => $this->role])
            ->set('form.selectedPermissions', $permissions->pluck('name')->toArray())
            ->call('storePermissions')
            ->assertHasNoErrors()
            ->assertRedirect(route('role.show', $this->role));

        // Valida existencia del registro en BD.
        foreach ($permissions as $permission) {
            $this->assertDatabaseHas('role_has_permissions', [
                'role_id' => $this->role->id,
                'permission_id' => $permission->id,
            ]);
        }

        // Valida que no haya otros permisos relacionados al rol
        $this->assertEquals(3, $this->role->permissions()->count());

        // Valida session del mensaje.
        $response->assertSessionHas([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The permissions have been successfully related.')
            ]
        ]);
    }
}
