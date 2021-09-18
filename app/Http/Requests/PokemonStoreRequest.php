<?php

namespace App\Http\Requests;

use http\Exception\InvalidArgumentException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PokemonStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return $this->user()->can("create_pokemon");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        $data = $this->toArray();

        return [
            'name' => ['required', Rule::unique('pokemons')->where(function ($query) use($data) {
                return $query->where('name', $data['name'])->where('sex', $data['sex']);
            })],
            'sex' => ['required', 'string', 'max:1'],
            'rareness' => ['required', 'string'],
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
    public function messages() : array
    {
        return [
            'name.unique' => "Un intémon du même nom et du même sexe existe déjà.",
        ];
    }
}
