<?php

namespace Tests\Feature\User;

use App\Concerns\Tests\CustomMethods;
use App\Enums\Permissions\UserPermission;
use App\Enums\RoleEnum;
use App\Livewire\User\CreateUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CreateUserTest extends TestCase
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

    public function test_permisos_para_ver_boton_crear_usuario()
    {
        $this->actingAs($this->desarrollador);

        // Renderizado con permisos
        $response = $this->get(route('user.index'));
        $response->assertStatus(200)
            ->assertSeeLivewire(CreateUser::class);

        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, UserPermission::Create);

        // Renderizado sin permisos
        $response = $this->get(route('user.index'));
        $response->assertStatus(200)
            ->assertDontSeeLivewire(CreateUser::class);
    }

    public function test_validaciones_al_crear_un_usuario()
    {
        $this->actingAs($this->desarrollador);

        // Valida nombre, correo y contraseñas requeridos
        $componente = Livewire::test(CreateUser::class)
            ->set('name', null)
            ->set('email', null)
            ->set('password', null)
            ->call('storeUser')
            ->assertHasErrors([
                'name' => 'required',
                'email' => 'required',
                'password' => 'required',
            ]);

        // Valida caracteres maximos y correo único
        $cargo = str_repeat($this->faker->words(50, true) . ' ', 5);
        $cargo = substr($cargo, 0, 256);

        $componente->set('prefijo', null)
            ->set('email', User::inRandomOrder()->first()->email)
            ->set('cargo', $cargo)
            ->call('storeUser')
            ->assertHasErrors([
                'email' => 'unique',
                'cargo' => 'max',
            ]);
    }

    public function test_permisos_para_crear_un_usuario()
    {
        // Valida que no se puede crear el usuario sin los permisos
        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, UserPermission::Create);
        $this->actingAs($this->desarrollador);
        $input = User::factory()->raw();

        Livewire::test(CreateUser::class)
            ->set('name', $input['name'])
            ->set('email', $input['email'])
            ->set('cargo', $input['cargo'])
            ->set('password', $input['password'])
            ->set('password_confirmation', $input['password'])
            ->call('storeUser')
            ->assertForbidden();
    }

    public function test_funcionamiento_al_crear_un_usuario()
    {
        $this->actingAs($this->desarrollador);
        $response = $this->get(route('user.index'));
        $input = User::factory()->raw();

        $component = Livewire::test(CreateUser::class)
            ->set('prefijo', $input['prefijo'])
            ->set('name', $input['name'])
            ->set('email', $input['email'])
            ->set('cargo', $input['cargo'])
            ->set('password', $input['password'])
            ->set('password_confirmation', $input['password'])
            ->call('storeUser')
            ->assertHasNoErrors();

        $user = User::whereEmail($input['email'])->first();
        $component->assertRedirect(route('user.show', $user));

        // Valida existencia del registro en BD.
        $this->assertDatabaseHas('users', [
            'name' => $input['name'],
            'cargo' => $input['cargo'],
            'email' => $input['email'],
            'prefijo' => $input['prefijo'],
        ]);

        // Valida session del mensaje.
        $response->assertSessionHas([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The user has been successfully stored.')
            ]
        ]);
    }
}
