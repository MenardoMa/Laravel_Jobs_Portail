<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserPassword extends FormRequest
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
            'current_password' => ['required'],
            'new_password' => ['required', 'min:6', 'confirmed'],
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
     * 
     * Messages de retour
     * 
     * @return array{current_password.required: string, new_password.confirmed: string, new_password.min: string, new_password.required: string}
     */
    public function messages(): array
    {
        return [
            'current_password.required' => 'Le mot de passe actuel est obligatoire.',
            'new_password.required' => 'Le nouveau mot de passe est obligatoire.',
            'new_password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
            'new_password.confirmed' => 'Les mots de passe ne correspondent pas.',
        ];
    }

}
