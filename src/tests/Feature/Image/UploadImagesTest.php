<?php

namespace Tests\Feature\Image;

use App\Concerns\Tests\CustomMethods;
use App\Enums\Permissions\ImagePermission;
use App\Enums\RoleEnum;
use App\Livewire\Image\UploadImages;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class UploadImagesTest extends TestCase
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
    }

    /**
     * Se validan permisos para ver el botón de subir imágenes.
     */
    public function test_el_usuario_puede_ver_el_boton_de_subir_imagenes(): void
    {
        $this->actingAs($this->tecnicoUnidad);

        $response = $this->get(route('image.index'));
        $response->assertOk()
            ->assertSee(__('Upload images'))
            ->assertSeeLivewire(UploadImages::class);

        $this->revokeRolePermissionTo(RoleEnum::TecnicoUnidad->value, ImagePermission::Upload);

        // Renderizado sin permisos
        $response = $this->get(route('image.index'));
        $response->assertOk()
            ->assertDontSee(__('Upload images'))
            ->assertDontSeeLivewire(UploadImages::class);
    }

    /**
     * Se validan permisos para subir imágenes.
     */
    public function test_permisos_para_subir_imagenes(): void
    {
        $this->revokeRolePermissionTo(RoleEnum::TecnicoUnidad->value, ImagePermission::Upload);
        $this->actingAs($this->tecnicoUnidad);

        Livewire::test(UploadImages::class)
            ->set('files', UploadedFile::fake()->image('test_image.jpg', 1920, 1080))
            ->call('uploadFiles')
            ->assertForbidden();
    }

    /**
     * Se validan que se suban máximo 10 imágenes.
     */
    public function test_valida_maximo_10_imagenes_para_subir_imagenes(): void
    {
        $this->actingAs($this->tecnicoUnidad);
        Storage::fake(config('filesystems.default'));

        // Se permite un máximo de 10 imágenes por subida.
        $images = [];
        for ($i = 0; $i < 11; $i++) {
            $images[] = UploadedFile::fake()->image("test_image_$i.jpg", 1920, 1080);
        }

        Livewire::test(UploadImages::class)
            ->set('files', $images)
            ->call('uploadFiles')
            ->assertHasErrors([
                'files' => 'max',
            ]);
    }

    /**
     * Se comprueba el funcionamiento de subir imágenes
     */
    public function test_comprueba_funcionamiento_al_subir_imagenes(): void
    {
        Storage::fake(config('filesystems.default'));

        $images = [
            UploadedFile::fake()->image('test_image_1.jpg', 800, 600),
            UploadedFile::fake()->image('test_image_2.jpg', 800, 600)
        ];

        Livewire::actingAs($this->tecnicoUnidad)
            ->test(UploadImages::class)
            ->set('files', $images)
            ->call('uploadFiles')
            ->assertRedirect(route('image.labeling', ['ids' => '1,2']))
            ->assertSessionHas('alert', [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('Images uploaded successfully.') . ' ' . __('Please follow the wizard instructions.')
            ]);

        $images = [
            UploadedFile::fake()->image('test_image_1.jpg', 800, 600),
        ];

        Livewire::actingAs($this->tecnicoUnidad)
            ->test(UploadImages::class)
            ->set('files', $images)
            ->call('uploadFiles')
            ->assertRedirect(route('image.labeling', ['ids' => '3']))
            ->assertSessionHas('alert', [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('Image uploaded successfully.') . ' ' . __('Please bring more info about this image.')
            ]);
    }
}
