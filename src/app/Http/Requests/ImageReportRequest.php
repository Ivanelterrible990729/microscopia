<?php

namespace App\Http\Requests;

use App\Models\Image;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class ImageReportRequest extends FormRequest
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
            'imageIds' => ['required', 'array', 'min:1'],
            'imageIds.*' => ['numeric', 'exists:images,id'],
            'predictions' => ['required', 'array', 'min:1'],
            'predictions.*' => ['regex:/^\d+\s*\|\s*\d{2}\.\d{2}$/'],
            'modelId' => ['required', 'numeric', 'exists:cnn_models,id']
        ];
    }

    /**
     * Obtiene los ids de las imagenes en formato esperado.
     */
    public function getImageIds(): array
    {
        return $this->imageIds ?? [];
    }

    /**
     * Obtiene los ids de las imagenes en formato esperado.
     */
    public function getPredictions(): array
    {
        return $this->predictions ?? [];
    }

    /**
     * Obtiene el ID del modelo utilizado para las predicciones.
     */
    public function getModelId(): string
    {
        return $this->modelId ?? '';
    }

    /**
     * Autoriza automáticamente cada imagen antes de pasar al controlador.
     */
    protected function passedValidation(): void
    {
        if (count($this->getImageIds()) != count($this->getPredictions())) {
            $this->redirectBack(__('There must be same quantity for image ids and predictions to perform the inform.'));
        }

        $images = Image::whereIn('id', $this->getImageIds())->get();
        $images->each(fn($image) => Gate::authorize('report', $image));
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
            'imageIds' => $message,
        ])->redirectTo(route('image.index'));
    }
}
