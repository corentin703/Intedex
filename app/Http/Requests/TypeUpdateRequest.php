<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TypeUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can("update_type");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {

        $type = $this->type;

        return [
            'name' => ['nullable', 'unique:types,name,' . $type->id, 'string', 'max:255'],
            'picture_link' => ['nullable', 'string', 'max:255'],
            'color' => ['nullable', 'string', 'max:7'],
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
            //
        ];
    }
}
