<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserPicture extends FormRequest
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
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg,svg,gif', 'max:2048']
        ];
    }

    /**
     * Au cas ou on a des erreurs.
     * 
     * @param Validator $validator
     * @throws HttpResponseException
     * @return never
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'type' => 'validation_error',
                'message' => 'Veuillez corriger les erreurs dans le formulaire.',
                'errors' => $validator->errors()
            ], 422)
        );
    }

    /**
     * Message de retour
     * 
     * @return array{image.image: string, image.mimes: string, image.required: string}
     */
    public function messages(): array
    {
        return [
            'image.required' => 'Veuillez choisir une image de profil.',
            'image.image' => 'Le fichier sélectionné n\'est pas une image valide.',
            'image.mimes' => 'Veuillez utiliser un format valide : PNG, JPG, JPEG, SVG ou GIF.',
            'image.max' => 'L\'image ne doit pas dépasser 2 Mo.',
        ];
    }
}
