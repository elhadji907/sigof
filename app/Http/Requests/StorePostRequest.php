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
            'titre'    => ['required', 'string', 'max:25'],
            'name'     => ['required', 'string'],
            'legende'  => ['sometimes', 'string'],
            'image'    => ['image', 'sometimes', 'mimes:jpeg,png,jpg,gif,svg', 'max:1024'],
            'users_id' => ['nullable'],

        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'legende' => $this->input('legende') ?: Str::slug($this->input('titre')),
            /* 'legende' => $this->input('legende') ?: Str::substr($this->input('titre'), 0, 25), */
        ]);
    }
}
