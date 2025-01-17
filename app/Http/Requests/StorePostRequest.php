<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StorePostRequest extends FormRequest
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
            'name'     => ['required', 'string'],
            'legende'  => ['sometimes', 'string'],
            'image'    => ['image', 'required', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'users_id' => ['nullable'],

        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'legende' => $this->input('legende') ?: Str::substr($this->input('name'), 0, 25),
        ]);
    }
}
