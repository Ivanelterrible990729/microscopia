<?php

namespace Tests\Feature\CnnModel;

use App\Concerns\Tests\CustomMethods;
use App\Enums\RoleEnum;
use App\Livewire\Tables\CnnModelsTable;
use App\Models\CnnModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewCnnModelsTest extends TestCase
{
    use RefreshDatabase, WithFaker, CustomMethods;

    protected User $desarrollador;
    protected User $tecnico;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Prepara entorno para realizar el testing
     */
    public function setUp() : void
    {
        parent::setUp();

        $this->desarrollador = $this->getUser(RoleEnum::Desarrollador);
        $this->tecnico = $this->getUser(RoleEnum::TecnicoUnidad);

        CnnModel::factory()->create();
    }

    public function test_permisos_para_acceder_al_listado_de_modelos(): void
    {
        // Usuario sin permisos para acceder al listado.
        $this->actingAs($this->tecnico);
        $response = $this->get(route('cnn-model.index'));
        $response->assertForbidden();

        // Usuario con permisos para acceder al listado.
        $this->actingAs($this->desarrollador);
        $response = $this->get(route('cnn-model.index'));
        $response->assertStatus(200);
        $response->assertSee(__('CNN Models'));
        $response->assertSeeLivewire(CnnModelsTable::class);
    }

    public function test_permisos_para_ver_un_modelo_en_especifico(): void
    {
        $cnnModel = CnnModel::inRandomOrder()->first();

        // Usuario sin permisos
        $this->actingAs($this->tecnico);
        $response = $this->get(route('cnn-model.show', $cnnModel));
        $response->assertForbidden();

        // Usuario con permisos
        $this->actingAs($this->desarrollador);
        $response = $this->get(route('cnn-model.show', $cnnModel));
        $response->assertStatus(200);
        $response->assertSee(__('CNN Model'));
        $response->assertSee($cnnModel->name);
    }
}
