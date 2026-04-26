<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateUserInfoForm extends FormRequest
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
            'name' => ['required', 'string'],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->user()->id),
            ],
            'designation' => ['nullable', 'string', 'min:4'],
            'mobile' => ['nullable', 'string', 'regex:/^\+?[0-9\s\-]{6,20}$/']
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
     * Messages de retour
     * 
     * @return array{email.email: string, email.required: string, email.unique: string, name.required: string, name.string: string}
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est obligatoire.',
            'name.string' => 'Le nom doit être une chaîne de caractères valide.',

            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',

            'designation.string' => 'La désignation est invalide.',
            'designation.min' => 'La désignation doit contenir au moins :min caractères.',

            'mobile.string' => 'Le numéro de mobile est invalide.',
            'mobile.regex' => 'Le numéro de téléphone doit contenir uniquement des chiffres, espaces, tirets et peut commencer par +.',
        ];
    }
}
