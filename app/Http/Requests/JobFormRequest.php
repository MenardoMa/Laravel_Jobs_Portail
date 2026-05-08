<?php

namespace App\Http\Requests;

use App\Enum\ExperienceLevel;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Enum;

class JobFormRequest extends FormRequest
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
            'title' => ['required', 'string', 'min:4'],
            'category' => ['required', 'integer', 'exists:categories,id'],
            'job_nature' => ['required', 'integer', 'exists:job_types,id'],
            'vacancy' => ['required', 'integer'],
            'salary' => ['nullable', 'numeric'],
            'location' => ['required', 'string', 'min:3'],
            'description' => ['required', 'string', 'max:2000'],
            'benefits' => ['nullable', 'string'],
            'responsibility' => ['nullable', 'string'],
            'experiences' => ['required', new Enum(ExperienceLevel::class)],
            'qualifications' => ['nullable', 'string'],
            'keywords' => ['nullable', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'min:3'],
            'company_location' => ['nullable', 'string'],
            'company_website' => ['nullable', 'url'],
        ];
    }

    /**
     * 
     * Erreurs de validations
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
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ])
        );
    }

    /**
     * 
     * Message
     * 
     * @return array{benefits.string: string, category.exists: string, category.integer: string, category.required: string, company_location.string: string, company_name.min: string, company_name.required: string, company_name.string: string, company_website.string: string, description.string: string, experiences.required: string, job_nature.exists: string, job_nature.integer: string, job_nature.required: string, keywords.string: string, location.min: string, location.required: string, location.string: string, qualifications.string: string, responsibility.string: string, salary.numeric: string, title.min: string, title.required: string, title.string: string, vacancy.integer: string, vacancy.required: string}
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Le titre est obligatoire.',
            'title.string' => 'Le titre doit être un texte.',
            'title.min' => 'Le titre doit contenir au moins 4 caractères.',

            'category.required' => 'La catégorie est obligatoire.',
            'category.integer' => 'La catégorie sélectionnée est invalide.',
            'category.exists' => 'La catégorie sélectionnée n’existe pas.',

            'job_nature.required' => 'La nature du travail est obligatoire.',
            'job_nature.integer' => 'La nature du travail sélectionnée est invalide.',
            'job_nature.exists' => 'La nature du travail sélectionnée n’existe pas.',

            'vacancy.required' => 'Le nombre de postes est obligatoire.',
            'vacancy.integer' => 'Le nombre de postes doit être un entier.',

            'salary.numeric' => 'Le salaire doit être un nombre valide.',

            'location.required' => 'Le lieu est obligatoire.',
            'location.string' => 'Le lieu doit être un texte.',
            'location.min' => 'Le lieu doit contenir au moins 3 caractères.',

            'description.required' => 'La description est obligatoire.',
            'description.string' => 'La description doit être un texte.',
            'description.max' => 'La description ne doit pas dépasser 2000 caractères.',

            'benefits.string' => 'Les avantages doivent être un texte.',

            'responsibility.string' => 'Les responsabilités doivent être un texte.',

            'experiences.required' => 'Le niveau d’expérience est obligatoire.',
            'experiences.enum' => 'Le niveau d’expérience sélectionné est invalide.',

            'qualifications.string' => 'Les qualifications doivent être un texte.',

            'keywords.string' => 'Les mots-clés doivent être un texte.',
            'keywords.max' => 'Les mots-clés ne doivent pas dépasser 255 caractères.',

            'company_name.required' => 'Le nom de l’entreprise est obligatoire.',
            'company_name.string' => 'Le nom de l’entreprise doit être un texte.',
            'company_name.min' => 'Le nom de l’entreprise doit contenir au moins 3 caractères.',

            'company_location.string' => 'L’emplacement de l’entreprise doit être un texte.',

            'company_website.url' => 'Le site web de l’entreprise doit être une URL valide.',
            'company_website.string' => 'Le site web de l’entreprise doit être un texte.',
        ];
    }
}
