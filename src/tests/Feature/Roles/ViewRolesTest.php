<?php

namespace Tests\Feature\Roles;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewRolesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $desarrollador;
    protected User $directivo;

    /**
     * Prepara entorno para realizar el testing
     */
    public function setUp() : void
    {
        parent::setUp();

        $this->desarrollador = User::whereHas('roles', function ($query) {
            return $query->where('name', RoleEnum::Desarrollador);
        })->first();

        $this->directivo = User::whereHas('roles', function ($query) {
            return $query->where('name', RoleEnum::Directivo);
        })->first();
    }

    /**
     *
     */
    public function test_permisos_para_acceder_al_listado_de_roles(): void
    {
        $this->actingAs($this->desarrollador);
        $response = $this->get(route('roles.index'));
        $response->assertStatus(200);

        $this->actingAs($this->directivo);
        $response = $this->get(route('roles.index'));
        $response->assertForbidden();
    }
}
