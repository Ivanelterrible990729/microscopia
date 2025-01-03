<?php

namespace Tests\Feature\Role;

use App\Concerns\Tests\CustomMethods;
use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ViewRolesTest extends TestCase
{
    use RefreshDatabase, WithFaker, CustomMethods;

    protected User $desarrollador;
    protected User $tecnico;

    /**
     * Prepara entorno para realizar el testing
     */
    public function setUp() : void
    {
        parent::setUp();

        $this->desarrollador = $this->getUser(RoleEnum::Desarrollador);
        $this->tecnico = $this->getUser(RoleEnum::TecnicoUnidad);
    }

    public function test_permisos_para_acceder_al_listado_de_roles(): void
    {
        // Usuario sin permisos para acceder al listado.
        $this->actingAs($this->tecnico);
        $response = $this->get(route('role.index'));
        $response->assertForbidden();

        // Usuario con permisos para acceder al listado.
        $this->actingAs($this->desarrollador);
        $response = $this->get(route('role.index'));
        $response->assertStatus(200);
        $response->assertSee(__('Roles'));
    }

    public function test_permisos_para_ver_un_rol_en_especifico(): void
    {
        $rol = Role::inRandomOrder()->first();

        // Usuario sin permisos
        $this->actingAs($this->tecnico);
        $response = $this->get(route('role.show', $rol));
        $response->assertForbidden();

        // Usuario con permisos
        $this->actingAs($this->desarrollador);
        $response = $this->get(route('role.show', $rol));
        $response->assertStatus(200);
        $response->assertSee(__('Manage Role'));
    }
}
