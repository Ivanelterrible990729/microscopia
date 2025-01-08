<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConfigureUserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_permisos_para_configurar_roles(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     */
    public function test_roles_disponibles_para_asignar_por_usuario(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     */
    public function test_funcionamiento_al_configurar_roles(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
