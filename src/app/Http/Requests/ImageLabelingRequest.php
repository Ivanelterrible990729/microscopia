<?php

namespace App\Http\Requests;

use App\Models\Image;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class ImageLabelingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ids' => ['required', 'string', 'regex:/^[0-9,]+$/'],
        ];
    }

    /**
     * Prepara la información antes de la validación
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'imageIds' => array_filter(explode(',', $this->ids)),
        ]);
    }
    /**
     * Obtiene los ids de las imagenes en formato esperado.
     */
    public function imageIds(): array
    {
        return $this->imageIds ?? [];
    }

    /**
     * Autoriza automáticamente cada imagen antes de pasar al controlador.
     */
    protected function passedValidation(): void
    {
        $images = Image::whereIn('id', $this->imageIds())->get();

        if ($images->isEmpty()) {
            $this->redirectBack(__('No valid image was found for labeling.'));
        }

        if ($images->count() > 12) {
            $this->redirectBack(__('You must select a maximum of 12 images to access the labeling wizard.'));
        }

        $images->each(fn($image) => Gate::authorize('update', $image));
    }

    /**
     * Sobrescribe la validación fallida para redirigir con alerta.
     */
    protected function failedValidation(Validator $validator)
    {
        $this->redirectBack(__('Invalid image IDs provided.'));
    }

    /**
     * Realiza la redirección con su mensaje en Session.
     */
    private function redirectBack(string $message): void
    {
        Session::flash('alert', [
            'variant' => 'soft-danger',
            'icon' => 'x',
            'message' => $message
        ]);

        throw ValidationException::withMessages([
            'ids' => $message,
        ])->redirectTo(route('image.index'));
    }
}
