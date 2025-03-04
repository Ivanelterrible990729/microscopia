<?php

namespace Tests\Feature\Image;

use App\Concerns\Tests\CustomMethods;
use App\Enums\Permissions\ImagePermission;
use App\Enums\RoleEnum;
use App\Models\Image;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ImagesWizardTest extends TestCase
{
    use RefreshDatabase, WithFaker, CustomMethods;

    protected User $tecnicoUnidad;

    /**
     * Prepara entorno para realizar el testing
     */
    public function setUp() : void
    {
        parent::setUp();

        $this->tecnicoUnidad = $this->getUser(RoleEnum::TecnicoUnidad);

        Image::factory(3)->create();
    }

    /**
     * Valida el presencia y formato de el parámetro ids.
     */
    public function test_validacion_del_parametro_ids()
    {
        $this->actingAs($this->tecnicoUnidad);

        // Valida que el formato sea el correcto
        $response = $this->get(route('image.labeling', ['ids' => 'wasaaaap... tenía que divertirme']));
        $response->assertRedirectToRoute('image.index')
            ->assertStatus(302)
            ->assertSessionHas([
                'alert' => [
                    'variant' => 'soft-danger',
                    'icon' => 'x',
                    'message' => __('Invalid image IDs provided.')
                ]
            ]);

        // Valida que exista el parámetro.
        $response = $this->get(route('image.labeling'));
        $response->assertRedirectToRoute('image.index')
            ->assertStatus(302)
            ->assertSessionHas([
                'alert' => [
                    'variant' => 'soft-danger',
                    'icon' => 'x',
                    'message' => __('Invalid image IDs provided.')
                ]
            ]);
    }

    /**
     * Regresa a la ruta anterior cuando no se proporcionan imágenes existentes
     */
    public function test_validacion_cuando_no_hay_imagenes()
    {
        $this->actingAs($this->tecnicoUnidad);

        $response = $this->get(route('image.labeling', ['ids' => '99']));
        $response->assertRedirectToRoute('image.index')
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'ids' => __('No valid image was found for labeling.')
            ])
            ->assertSessionHas([
                'alert' => [
                    'variant' => 'soft-danger',
                    'icon' => 'x',
                    'message' => __('No valid image was found for labeling.')
                ]
            ]);
    }

    /**
     * Redirige al image.edit cuando hay una imagen en el Request.
     */
    public function test_redireccion_cuando_hay_una_imagen()
    {
        $this->actingAs($this->tecnicoUnidad);

        $response = $this->get(route('image.labeling', ['ids' => '1']));
        $response->assertRedirectToRoute('image.edit', 1);
    }

    /**
     * Redirige a image.labeling cuando hay más imágenes en el Request.
     */
    public function test_sin_redireccion_cuando_hay_varias_imagenes()
    {
        $this->actingAs($this->tecnicoUnidad);

        $response = $this->get(route('image.labeling', ['ids' => '1,2,3']));
        $response->assertOk();
    }

    /**
     * Valida que no se supere la cantidad de 10 imágenes.
     */
    public function test_valida_maximo_de_12_imagenes_en_la_peticion()
    {
        // Crea 8 imágenes más
        Image::factory(10)->create();

        $this->actingAs($this->tecnicoUnidad);

        $response = $this->get(route('image.labeling', ['ids' => '1,2,3,4,5,6,7,8,9,10,11,12,13']));
        $response->assertRedirectToRoute('image.index')
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'ids' => __('You must select a maximum of 12 images to access the labeling wizard.')
            ])
            ->assertSessionHas([
                'alert' => [
                    'variant' => 'soft-danger',
                    'icon' => 'x',
                    'message' => __('You must select a maximum of 12 images to access the labeling wizard.')
                ]
            ]);
    }

    /**
     * Valida que el usuario tenga permisos para acceder al wizard.
     */
    public function test_valida_permisos_para_acceder_al_wizard()
    {
        $this->revokeRolePermissionTo(RoleEnum::TecnicoUnidad->value, ImagePermission::Update);
        $this->actingAs($this->tecnicoUnidad);

        $response = $this->get(route('image.labeling', ['ids' => '1,2,3']));
        $response->assertForbidden();
    }

    /**
     * Test navegación del wizard.
     */
    public function test_permite_avanzar_el_wizard_cuando_no_hay_errores()
    {

    }

    /**
     *
     */
    public function test_comprueba_permisos_para_almacenar_los_cambios()
    {

    }

    /**
     * Comprueba el alacenaiento al almacenar los cambios.
     */
    public function test_comprueba_funcionamiento_para_almacenar_los_cambios()
    {

    }
}
