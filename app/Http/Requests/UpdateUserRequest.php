<?php
namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'firstname' => ['required', 'string', 'max:150'],
            'name'      => ['required', 'string', 'max:25'],
            'username'  => [
                'required',
                'string',
                'lowercase',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id)->whereNull('deleted_at'),
            ],
            'cin'       => [
                'required',
                'string',
                'min:16',
                'max:17',
                Rule::unique(User::class)->ignore($this->route('user')?->id ?? null)->whereNull('deleted_at'),
            ],
            'image'     => ['image', 'max:255', 'nullable', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'telephone' => ['required', 'string', 'max:9', 'min:9'],
            'adresse'   => ['required', 'string', 'max:255'],
            'password'  => ['string', 'max:255', 'nullable'],
            'roles.*'   => ['string', 'max:255', 'nullable', 'max:255'],
        ];
    }

}
