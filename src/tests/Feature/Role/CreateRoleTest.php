<?php

namespace Tests\Feature\Role;

use App\Concerns\Tests\CustomMethods;
use App\Enums\Permissions\RolePermission;
use App\Enums\RoleEnum;
use App\Livewire\Role\CreateRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CreateRoleTest extends TestCase
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

    public function test_permisos_para_ver_boton_crear_rol()
    {
        $this->actingAs($this->desarrollador);

        // Renderizado con permisos
        $response = $this->get(route('role.index'));
        $response->assertStatus(200)
            ->assertSee(__('Create role'))
            ->assertSeeLivewire(CreateRole::class);

        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, RolePermission::Create);

        // Renderizado sin permisos
        $response = $this->get(route('role.index'));
        $response->assertStatus(200)
            ->assertDontSee(__('Create role'))
            ->assertDontSeeLivewire(CreateRole::class);
    }

    public function test_validaciones_al_crear_un_rol()
    {
        $this->actingAs($this->desarrollador);

        // Valida nombres unicos
        $componente = Livewire::test(CreateRole::class)
            ->set('form.name', Role::inRandomOrder()->first()->name)
            ->call('storeRole')
            ->assertHasErrors([
                'form.name' => 'unique'
            ]);

        // Valida que nombres no excedan los 250 caracteres
        $name = str_repeat($this->faker->words(50, true) . ' ', 5);
        $name = substr($name, 0, 256);
        $componente->set('form.name', $name)
            ->call('storeRole')
            ->assertHasErrors([
                'form.name' => 'max'
            ]);

        // Valida campos requeridos
        $componente->set('form.name', '')
            ->set('form.guard_name', '')
            ->call('storeRole')
            ->assertHasErrors([
                'form.name' => 'required',
                'form.guard_name' => 'required'
            ]);
    }

    public function test_permisos_para_crear_un_rol()
    {
        // Valida que no se puede crear el rol sin los permisos
        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, RolePermission::Create);
        $this->actingAs($this->desarrollador);
        $roleName =  $this->faker->word();

        Livewire::test(CreateRole::class)
            ->set('form.name', $roleName)
            ->call('storeRole')
            ->assertForbidden();
    }

    public function test_funcionamiento_al_crear_un_rol()
    {
        $this->actingAs($this->desarrollador);
        $response = $this->get(route('role.index'));
        $roleName = $this->faker->word();

        // Valida que no haya errores y redireccionamiento.
        Livewire::test(CreateRole::class)
            ->set('form.name', $roleName)
            ->call('storeRole')
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
                'message' => __('The role has been successfully stored.')
            ]
        ]);
    }
}
