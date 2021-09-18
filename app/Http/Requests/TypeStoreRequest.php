<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TypeStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can("create_type");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:types,name', 'string', 'max:255'],
            'picture_link' => ['required', 'string', 'max:255'],
            'color' => ['required', 'string', 'max:7'],
            'desc' => ['nullable', 'string'],
            'teaser' => ['nullable', 'string'],
        ];
    }

    /**
     * Get the messages associated to the validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'desc.required' => 'Le champ description est obligatoire.',
        ];
    }
}
