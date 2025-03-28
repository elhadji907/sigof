<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreArriveOperateurRequest extends FormRequest
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
            'date_arrivee'        => ["required", "date", "size:10", "date_format:Y-m-d"],
            'date_correspondance' => ["required", "date", "size:10", "date_format:Y-m-d"],
            'numero_arrive'       => [
                "required",
                "string",
                "min:4",
                "max:6",
                Rule::unique('arrives', 'numero')->whereNull('deleted_at'),
            ],
            'annee'               => ['required', 'numeric', 'min:2022'],
            'expediteur'          => ['required', 'string', 'max:200'],
            'objet'               => ['required', 'string', 'max:200'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            /* 'legende' => $this->input('legende') ?: Str::substr($this->input('titre'), 0, 25), */
        ]);
    }
}
