<?php
namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */

    public function rules(): array
    {
        return [
            'cin'                       => [
                'required',
                'string',
                'min:16',
                'max:17',
                Rule::unique(User::class)->ignore($this->route('user')?->id ?? null)->whereNull('deleted_at'),
            ],
            'username'                  => ['required', 'string'],
            'civilite'                  => ['required', 'string', 'max:8'],
            'firstname'                 => ['required', 'string', 'max:150'],
            'name'                      => ['required', 'string', 'max:25'],
            'date_naissance'            => ['nullable', 'date_format:d/m/Y'],
            'lieu_naissance'            => ['required', 'string'],
            'image'                     => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            /* 'email'                     => [
                'nullable',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->route('user')?->id ?? null)->whereNull('deleted_at'),
            ], */
            'telephone'                 => ['nullable', 'string', 'min:9', 'max:12'],
            'adresse'                   => ['required', 'string', 'max:255'],
            'situation_familiale'       => ['required', 'string', 'max:15'],
            'situation_professionnelle' => ['required', 'string', 'max:25'],
            'twitter'                   => ['nullable', 'string', 'max:255'],
            'facebook'                  => ['nullable', 'string', 'max:255'],
            'instagram'                 => ['nullable', 'string', 'max:255'],
            'linkedin'                  => ['nullable', 'string', 'max:255'],
            'web'                       => ['nullable', 'string', 'max:255'],
            'fixe'                      => ['nullable', 'string', 'max:255'],
        ];
    }

}
