<?php

namespace Tests\Feature\User;

use App\Concerns\Tests\CustomMethods;
use App\Enums\Permissions\UserPermission;
use App\Enums\RoleEnum;
use App\Livewire\User\CreateUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
            ->assertSee(__('Create user'))
            ->assertSeeLivewire(CreateUser::class);

        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, UserPermission::Create);

        // Renderizado sin permisos
        $response = $this->get(route('user.index'));
        $response->assertStatus(200)
            ->assertDontSee(__('Create user'))
            ->assertDontSeeLivewire(CreateUser::class);
    }

    public function test_validaciones_al_crear_un_usuario()
    {
    }

    public function test_permisos_para_crear_un_usuario()
    {
    }

    public function test_funcionamiento_al_crear_un_usuario()
    {
    }
}
