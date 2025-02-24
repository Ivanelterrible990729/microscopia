<?php

namespace Tests\Feature\User;

use App\Concerns\Tests\CustomMethods;
use App\Enums\Permissions\UserPermission;
use App\Enums\RoleEnum;
use App\Livewire\User\ConfigureUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

use function PHPUnit\Framework\assertTrue;

class ConfigureUserTest extends TestCase
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

    public function test_permisos_para_ver_boton_configurar_usuario()
    {
        $this->actingAs($this->desarrollador);

        // Renderizado con permisos
        $response = $this->get(route('user.show', $this->usuarioPrueba));
        $response->assertStatus(200)
            ->assertSee(__('Save'));

        Livewire::test(ConfigureUser::class, ['user' => $this->usuarioPrueba])
            ->assertSet('user.id', $this->usuarioPrueba->id)
            ->assertSee(__('Save'));

        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, UserPermission::AssignRoles);

        // Renderizado sin permisos
        $response = $this->get(route('user.show', $this->usuarioPrueba));
        $response->assertStatus(200)
            ->assertDontSee(__('Save'));

        Livewire::test(ConfigureUser::class, ['user' => $this->usuarioPrueba])
            ->assertSet('user.id', $this->usuarioPrueba->id)
            ->assertDontSee(__('Save'));
    }

    public function test_roles_disponibles_para_asignar_por_usuario(): void
    {
        $this->actingAs($this->desarrollador);

        // Un desarrollador puede asignar desarrolladores
        Livewire::test(ConfigureUser::class, ['user' => $this->usuarioPrueba])
            ->assertSee(RoleEnum::Desarrollador->value);

        // Un administrador no puede asignar desarrolladores
        $this->actingAs($this->getUser(RoleEnum::Administrador, create: true));

        Livewire::test(ConfigureUser::class, ['user' => $this->usuarioPrueba])
            ->assertDontSee(RoleEnum::Desarrollador->value);
    }

    public function test_permisos_para_asignar_roles_a_un_usuario()
    {
        // Valida que no se puede asignar roles sin permisos
        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, UserPermission::AssignRoles);
        $this->actingAs($this->desarrollador);

        Livewire::test(ConfigureUser::class, ['user' => $this->usuarioPrueba])
            ->call('save')
            ->assertForbidden();

        // Valida que un usuario que no sea desarrollador asigne permisos a un desarrollador
        $this->giveRolePermissionTo(RoleEnum::TecnicoUnidad->value, UserPermission::AssignRoles);
        $this->actingAs($this->usuarioPrueba);

        Livewire::test(ConfigureUser::class, ['user' => $this->desarrollador])
            ->call('save')
            ->assertForbidden();
    }

    public function test_funcionamiento_al_asignar_roles()
    {
        $this->actingAs($this->desarrollador);
        $response = $this->get(route('user.show', $this->usuarioPrueba));
        $roles = Role::where('name', [RoleEnum::Administrador])->pluck('name')->toArray();

        Livewire::test(ConfigureUser::class, ['user' => $this->usuarioPrueba])
            ->set('roles', $roles)
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('user.show', $this->usuarioPrueba));

        $response->assertSessionHas([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('Saved user settings')
            ]
        ]);

        $this->usuarioPrueba->load('roles');
        assertTrue($this->usuarioPrueba->hasRole(RoleEnum::Administrador));
    }
}
