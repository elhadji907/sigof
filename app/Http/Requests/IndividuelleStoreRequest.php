<?php
namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndividuelleStoreRequest extends FormRequest
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
            'departement'            => ['required', 'string', 'max:255'],
            'module'                 => ['required', 'string', 'max:255'],
            'niveau_etude'           => ['required', 'string', 'max:255'],
            'diplome_academique'     => ['required', 'string', 'max:255'],
            'diplome_professionnel'  => ['required', 'string', 'max:255'],
            'projet_poste_formation' => ['required', 'string', 'max:255'],
            'qualification'          => ['nullable', 'string', 'max:200'],

            /* 'date_depot'                => ["required", "date", "date_format:Y-m-d"],
            'numero_dossier'            => ["required", "string", "max:50", Rule::unique('dossiers', 'numero_dossier')],

            'civilite'                  => ["required", "string", "max:10"],
            'cin'                       => ["required", "string", "min:13", "max:15", Rule::unique('users', 'cin')],
            'firstname'                 => ['required', 'string', 'max:50'],
            'name'                      => ['required', 'string', 'max:25'],

            'telephone'                 => ['required', 'string', 'regex:/^(77|78|76|70|75)\d{7}$/', Rule::unique('users', 'telephone')],
            'telephone_secondaire'      => ['nullable', 'string', 'regex:/^(77|78|76|70|75)\d{7}$/'],

            'date_naissance'            => ['required', 'date', 'date_format:Y-m-d'],
            'lieu_naissance'            => ['required', 'string', 'max:100'],

            'email'                     => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')],
            'adresse'                   => ['required', 'string', 'max:255'],

            'departement'               => ['required', 'string', 'max:255'],
            'module'                    => ['required', 'string', 'max:255'],

            'situation_professionnelle' => ['required', 'string', 'max:255'],
            'situation_familiale'       => ['required', 'string', 'max:255'],

            'niveau_etude'              => ['required', 'string', 'max:255'],
            'diplome_academique'        => ['required', 'string', 'max:255'],
            'diplome_professionnel'     => ['nullable', 'string', 'max:255'],
            'projet_poste_formation'    => ['required', 'string', 'max:255'], */
        ];
    }
}
