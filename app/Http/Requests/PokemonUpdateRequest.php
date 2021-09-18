<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PokemonUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can("update_pokemon");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $data = $this->toArray();

        $pokemon = $this->pokemon;

        return [
            'name' => ['required', Rule::unique('pokemons')->where(function ($query) use($data) {
                return $query->where('name', $data['name'])->where('sex', $data['sex']);
            })->ignore($pokemon->id)],
            'sex' => ['nullable', 'string', 'max:1'],
            'rareness' => ['nullable', 'string'],
            'desc' =>  ['nullable', 'string'],
            'strengths' =>  ['nullable', 'string'],
            'weaknesses' => ['nullable', 'string'],
            'types' => 'required',
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
            'name.unique' => "Un intémon du même nom et du même sexe existe déjà.",
        ];
    }
}
