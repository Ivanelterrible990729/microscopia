<?php

namespace Tests\Feature\Role;

use App\Concerns\Tests\CustomMethods;
use App\Enums\Permissions\RolePermission;
use App\Enums\RoleEnum;
use App\Livewire\Role\EditRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class EditRoleTest extends TestCase
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

    public function test_permisos_para_ver_boton_editar_rol()
    {
        $this->actingAs($this->desarrollador);

        // Renderizado con permisos
        $response = $this->get(route('role.show', $this->role));
        $response->assertStatus(200)
            ->assertSee(__('Edit role'))
            ->assertSeeLivewire(EditRole::class);

        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, RolePermission::Update);

        // Renderizado sin permisos
        $response = $this->get(route('role.show', $this->role));
        $response->assertStatus(200)
            ->assertDontSee(__('Edit role'))
            ->assertDontSeeLivewire(EditRole::class);
    }

    public function test_validaciones_al_editar_un_rol()
    {
        $this->actingAs($this->desarrollador);

        // Valida nombres únicos
        $componente = Livewire::test(EditRole::class, ['role' => $this->role])
            ->set('form.name', Role::where('name', '!=', $this->role->name)->first()->name)
            ->call('updateRole')
            ->assertHasErrors([
                'form.name' => 'unique'
            ]);

        // Valida nombres unicos exceptuando el que se está editando
        $componente->set('form.name', $this->role->name)
            ->call('updateRole')
            ->assertHasNoErrors();
    }

    public function test_permisos_para_editar_un_rol()
    {
        // Valida que no se puede crear el rol sin los permisos
        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, RolePermission::Update);
        $this->actingAs($this->desarrollador);
        $roleName =  $this->faker->word();

        Livewire::test(EditRole::class, ['role' => $this->role])
            ->set('form.name', $roleName)
            ->call('updateRole')
            ->assertForbidden();
    }

    public function test_funcionamiento_al_editar_un_rol()
    {
        $this->actingAs($this->desarrollador);
        $response = $this->get(route('role.show', $this->role));
        $roleName =  $this->faker->word();

        // Valida que no haya errores y redireccionamiento.
        Livewire::test(EditRole::class, ['role' => $this->role])
            ->set('form.name', $roleName)
            ->call('updateRole')
            ->assertHasNoErrors()
            ->assertRedirect(route('role.show', Role::findByName($roleName, 'web')));

        // Valida existencia del registro en BD.
        $this->assertDatabaseHas('roles', [
            'name' => $roleName
        ]);

        // Valida session del mensaje.
        $response->assertSessionHas([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The role has been successfully updated.')
            ]
        ]);
    }
}
