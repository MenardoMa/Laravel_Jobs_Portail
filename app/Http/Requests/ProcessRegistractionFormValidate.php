<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ProcessRegistractionFormValidate extends FormRequest
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
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->id)],
            'password' => ['required', 'min:5', 'same:confirm_password'],
            'confirm_password' => ['required']
        ];
    }

    /**
     * 
     * Return erreurs
     * 
     * @param Validator $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return never
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 200)
        );
    }

    /**
     * 
     * Return erreurs message
     * 
     * @return array{confirm_password.required: string, email.email: string, email.required: string, email.unique: string, name.required: string, password.min: string, password.required: string, password.same: string}
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est obligatoire.',

            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.unique' => 'Cet email est déjà utilisé par un autre user.',

            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 5 caractères.',
            'password.same' => 'Les mots de passe ne correspondent pas.',

            'confirm_password.required' => 'Veuillez confirmer le mot de passe.',
        ];
    }
}
