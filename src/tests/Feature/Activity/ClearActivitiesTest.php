<?php

namespace Tests\Feature\Activity;

use App\Concerns\Tests\CustomMethods;
use App\Enums\Permissions\ActivitylogPermission;
use App\Enums\RoleEnum;
use App\Livewire\Activity\ClearActivities;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ClearActivitiesTest extends TestCase
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

    /**
     * Valida los permisos para limpiar los logs de acceso.
     */
    public function test_permisos_para_limpiar_registros_de_actividad()
    {
        $this->actingAs($this->desarrollador);

        // Renderizado con permisos
        $response = $this->get(route('activitylog.index'));
        $response->assertOk();
        $response->assertSee(__('Clear activity log'));
        $response->assertSeeLivewire(ClearActivities::class);

        // Valida inicialización del componente.
        Livewire::test(ClearActivities::class)
            ->assertSet('logName', '')
            ->assertSet('numDays', config('activitylog.delete_records_older_than_days'));

        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, ActivitylogPermission::Clear);

        // Renderizado sin permisos
        $response = $this->get(route('activitylog.index'));
        $response->assertOk();
        $response->assertDontSee(__('Clear activity log'));
        $response->assertDontSeeLivewire(ClearActivities::class);
    }

    /**
     * Valida los permisos para realizar la eliminación
     */
    public function test_permisos_para_realizar_proceso_de_limpieza_de_actividad()
    {
        $this->actingAs($this->desarrollador);
        $this->revokeRolePermissionTo(RoleEnum::Desarrollador->value, ActivitylogPermission::Clear);

        Livewire::test(ClearActivities::class)
            ->call('clearActivities')
            ->assertForbidden();
    }

    /**
     * Valida log_name existente al momento de limpiar los logs.
     */
    public function test_valida_log_name_para_limpiar_registros_de_actividad()
    {
        $this->actingAs($this->desarrollador);

        // Activity a limpiar
        $activity = activity('custom_log_name')
            ->withProperties([
                'property_1' => 1,
            ])
            ->log('log test');

        // Valida mensaje de error al no encontrar el log-name.s
        Livewire::test(ClearActivities::class)
            ->set('logName', 'fake_log_name')
            ->call('clearActivities')
            ->assertDispatched('toastify-js', [
                'id' => 'error-notification',
                'message' => __("The specified module doesn't exists."),
                'title' => __('Error'),
            ]);

        // Valida existencia de la actividad en BD.
        $this->assertDatabaseHas(config('activitylog.table_name'), [
            'id' => $activity->id,
            'description' => $activity->description,
            'properties' => json_encode($activity->properties),
        ]);
    }

    /**
     * Valida que solo se eliminen los logs del log_name especificado.
     */
    public function test_eliminacion_de_registros_de_actividad_por_log_name()
    {
        $this->actingAs($this->desarrollador);

        // Define actividades a eliminar y a preservar
        $activity = activity('log_name_to_preserve')
            ->createdAt(now()->subYears(2))
            ->withProperties([
                'property_1' => 1,
            ])
            ->log('log test 1');
        $activityToDelete = activity('log_name_to_delete')
            ->createdAt(now()->subYears(2))
            ->withProperties([
                'property_1' => 1,
            ])
            ->log('log test 2');

        Livewire::test(ClearActivities::class)
            ->set('logName', 'log_name_to_delete')
            ->call('clearActivities')
            ->assertDispatched('activities-cleared');

        // Valida inexistencia de la actividad borrada
        $this->assertDatabaseMissing(config('activitylog.table_name'), [
            'id' => $activityToDelete->id,
            'description' => $activityToDelete->description,
            'properties' => json_encode($activityToDelete->properties),
        ]);

        // Valida existencia de la actividad a preservar.
        $this->assertDatabaseHas(config('activitylog.table_name'), [
            'id' => $activity->id,
            'description' => $activity->description,
            'properties' => json_encode($activity->properties),
        ]);
    }

    /**
     * Valida que solo se eliminen logs por numero de días especificados.
     */
    public function test_eliminacion_de_registros_de_actividad_por_dias()
    {
        $this->actingAs($this->desarrollador);

        // Define actividades a eliminar y a preservar
        $activity = activity()
            ->withProperties([
                'property_1' => 1,
            ])
            ->log('log test 1');
        $activityToDelete = activity()
            ->createdAt(now()->subDays(15))
            ->withProperties([
                'property_1' => 1,
            ])
            ->log('log test 2');

        Livewire::test(ClearActivities::class)
            ->set('numDays', '14')
            ->call('clearActivities')
            ->assertDispatched('activities-cleared');

        // Valida inexistencia de la actividad borrada
        $this->assertDatabaseMissing(config('activitylog.table_name'), [
            'id' => $activityToDelete->id,
            'description' => $activityToDelete->description,
            'properties' => json_encode($activityToDelete->properties),
        ]);

        // Valida existencia de la actividad a preservar.
        $this->assertDatabaseHas(config('activitylog.table_name'), [
            'id' => $activity->id,
            'description' => $activity->description,
            'properties' => json_encode($activity->properties),
        ]);
    }
}
