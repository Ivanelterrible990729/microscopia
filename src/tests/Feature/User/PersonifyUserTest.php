<?php

namespace Tests\Feature\User;

use App\Concerns\Tests\CustomMethods;
use App\Enums\Permissions\UserPermission;
use App\Enums\RoleEnum;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PersonifyUserTest extends TestCase
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

    public function test_permisos_para_ver_boton_personificar()
    {
        $this->actingAs($this->desarrollador);

        // Renderizado con permisos
        $response = $this->get(route('user.show', $this->usuarioPrueba));
        $response->assertStatus(200)
            ->assertSee(__('Personify'));

        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, UserPermission::Personify);

        // Renderizado sin permisos
        $response = $this->get(route('user.show', $this->usuarioPrueba));
        $response->assertStatus(200)
            ->assertDontSee(__('Personify'));
    }

    public function test_evita_personificacion_al_mismo_usuario()
    {
        $this->actingAs($this->desarrollador);

        // Renderizado al mismo usuario
        $response = $this->get(route('user.show', $this->desarrollador));
        $response->assertStatus(200)
            ->assertDontSee(__('Personify'));
    }

    public function test_evita_personificacion_a_un_usuario_eliminado()
    {
        (new UserRepository)->delete($this->usuarioPrueba);
        $this->actingAs($this->desarrollador);

        // Renderizado al mismo usuario
        $response = $this->get(route('user.show', $this->usuarioPrueba));
        $response->assertStatus(200)
            ->assertDontSee(__('Personify'));
    }

    public function test_valida_permisos_para_realizar_personificacion()
    {
        // Se valida que si no se tiene el permiso no se puede personificar
        $this->actingAs($this->desarrollador);
        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, UserPermission::Personify);

        $this->get(route('user.personification.start', [
            'user' => $this->usuarioPrueba,
        ]))->assertForbidden();

        // Valida que no se puede persnoficiar a su propio usuario
        $this->giveRolePermissionTo(RoleEnum::Desarrollador->value, UserPermission::Personify);
        $this->actingAs($this->desarrollador);

        $response = $this->get(route('user.personification.start', [
            'user' => $this->desarrollador
        ]));
        $response->assertForbidden();

        // Valida que un usuario que no sea desarrollador persnoficiar a un desarrollador
        $this->giveRolePermissionTo(RoleEnum::TecnicoUnidad->value, UserPermission::Personify);
        $this->actingAs($this->usuarioPrueba);

        $response = $this->get(route('user.personification.start', [
            'user' => $this->desarrollador
        ]));
        $response->assertForbidden();
    }

    public function test_inicio_de_personificacion()
    {
        $this->actingAs($this->desarrollador);

        $response = $this->get(route('user.personification.start', [
            'user' => $this->usuarioPrueba,
        ]));

        $this->assertAuthenticatedAs($this->usuarioPrueba, 'web');
        $response->assertRedirect(route('dashboard'))
            ->assertSessionHas([
            'personified_by' => $this->desarrollador->id,
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('Successful impersonation.')
            ]
        ]);
    }

    public function test_fin_de_personificacion()
    {
        // Inicia la personificación
        $this->actingAs($this->desarrollador);
        $this->get(route('user.personification.start', [
            'user' => $this->usuarioPrueba,
        ]));

        // Finaliza la personificacion
        $response = $this->get(route('user.personification.stop'));

        $this->assertAuthenticatedAs($this->desarrollador, 'web');
        $response->assertRedirect(route('user.show', $this->usuarioPrueba))
            ->assertSessionHas([
                'alert' => [
                    'variant' => 'soft-primary',
                    'icon' => 'check-circle',
                    'message' => __('The impersonation was stopped.')
                ]
            ])
            ->assertSessionMissing('personified_by');
        }
}
