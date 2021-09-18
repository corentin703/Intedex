<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DownloadQrCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can("download_qr_code");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'size' => ['required', 'numeric', 'gte:200'],
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
            'size.gte' => "La taille doit-être de 200px minimum",
        ];
    }
}
