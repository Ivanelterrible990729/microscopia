<?php

namespace Tests\Feature\Activity;

use App\Concerns\Tests\CustomMethods;
use App\Enums\RoleEnum;
use App\Livewire\Activity\ShowActivityDetail;
use App\Livewire\Tables\ActivitiesTable;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ViewActivitiesTest extends TestCase
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

    public function test_permisos_para_acceder_al_listado_de_actividades()
    {
        // Usuario sin permisos para acceder al listado.
        $this->actingAs($this->tecnico);
        $response = $this->get(route('activitylog.index'));
        $response->assertForbidden();

        // Usuario con permisos para acceder al listado.
        $this->actingAs($this->desarrollador);
        $response = $this->get(route('activitylog.index'));
        $response->assertStatus(200);
        $response->assertSee(__('Activity log'));
        $response->assertSeeLivewire(ActivitiesTable::class);
    }

    public function test_mecanismo_para_visualizar_una_actividad_en_especifico()
    {
        // Activity a consultar
        $activity = activity('default')
            ->withProperties([
                'property_1' => 1,
            ])
            ->log('log test');

        $this->actingAs($this->desarrollador);

        Livewire::test(ShowActivityDetail::class)
            ->dispatch('show-activity-details', $activity->id)
            ->assertSet('activity.id', $activity->id)
            ->assertSee($activity->properties->toArray());
    }
}
