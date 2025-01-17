<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateArriveRequest extends FormRequest
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
            "date_arrivee"        => ["required", "date", "min:10", "max:10", "date_format:Y-m-d"],
            "date_correspondance" => ["required", "date", "min:10", "max:10", "date_format:Y-m-d"],
            "numero"              => ["nullable", "string", "min:4", "max:6", Rule::unique('courriers')->ignore($this->route()->parameter('arrives'))],
            "numero_arrive"       => ["required", "string", "min:4", "max:6", Rule::unique('arrives')->ignore($this->route()->parameter('arrives'))],
            "annee"               => ["required", "string"],
            "expediteur"          => ["required", "string"],
            "objet"               => ["required", "string"],
            "numero_reponse"      => ["string", "min:6", "max:9", "nullable", Rule::unique('courriers')->ignore($this->route()->parameter('arrives'))],
            "date_reponse"        => ["nullable", "date"],
            "observation"         => ["nullable", "string"],
            "file"                => ['sometimes', 'file', 'mimes:jpeg,png,jpg,gif,svg,pdf', 'max:2048'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            /* 'legende' => $this->input('legende') ?: Str::substr($this->input('titre'), 0, 25), */
        ]);
    }
}
