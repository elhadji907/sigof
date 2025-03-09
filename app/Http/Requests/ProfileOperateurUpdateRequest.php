<?php
namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileOperateurUpdateRequest extends FormRequest
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
            'cin'                  => ['nullable', 'string', 'min:13', 'max:15', Rule::unique(User::class)->ignore($this->route('user')?->id ?? null)->whereNull('deleted_at')],
            'operateur'            => ['required', 'string', Rule::unique(User::class)->ignore($this->route('user')?->id ?? null)->whereNull('deleted_at')],
            'username'             => ['required', 'string'],
            'civilite'             => ['required', 'string', 'max:8'],
            'firstname'            => ['required', 'string', 'max:150'],
            'name'                 => ['required', 'string', 'max:25'],
            'categorie'            => ['required', 'string'],
            'rccm'                 => ['required', 'string'],
            'ninea'                => ['required', 'string', Rule::unique(User::class)->ignore($this->route('user')?->id ?? null)->whereNull('deleted_at')],
            'image'                => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'email'                => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->route('user')?->id ?? null)->whereNull('deleted_at')],
            'email_responsable'    => ['nullable', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->route('user')?->id ?? null)->whereNull('deleted_at')],
            'telephone'            => ['nullable', 'string', 'size:9'],
            'telephone_parent'     => ['nullable', 'string', 'size:9'],
            'adresse'              => ['required', 'string', 'max:255'],
            'fonction_responsable' => ['required', 'string', 'max:250'],
            'twitter'              => ['nullable', 'string', 'max:255'],
            'facebook'             => ['nullable', 'string', 'max:255'],
            'instagram'            => ['nullable', 'string', 'max:255'],
            'linkedin'             => ['nullable', 'string', 'max:255'],
            'web'                  => ['nullable', 'string', 'max:255'],
            'fixe'                 => ['nullable', 'string', 'max:255'],
            'statut'               => ['nullable', 'string', 'max:255'],
        ];
    }

}
