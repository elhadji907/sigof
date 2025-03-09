<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartStoreRequest extends FormRequest
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
            "date_depart"     => ["required", "date", "date_format:Y-m-d"],
            "date_corres"     => ["required", "date", "date_format:Y-m-d"],

            "numero_courrier" => [
                "required", "string", "min:4", "max:6",
                Rule::unique('courriers', 'numero_courrier')->whereNull('deleted_at'),
            ],

            "numero_depart"   => [
                "required", "string", "min:4", "max:6",
                Rule::unique('departs', 'numero_depart')->whereNull('deleted_at'),
            ],

            "annee"           => ["required", "integer", "min:1900", "max:" . date('Y')],
            "objet"           => ["required", "string", "max:255"],
            "destinataire"    => ["required", "string", "max:255"],

            "numero_reponse"  => [
                "nullable", "string", "min:4", "max:6",
                Rule::unique('courriers', 'numero_reponse')->whereNull('deleted_at'),
            ],

            "date_reponse"    => ["nullable", "date", "date_format:Y-m-d"],
        ];
    }

}
