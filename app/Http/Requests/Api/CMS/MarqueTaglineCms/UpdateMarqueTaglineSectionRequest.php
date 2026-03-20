<?php

namespace App\Http\Requests\Api\CMS\MarqueTaglineCms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateMarqueTaglineSectionRequest extends FormRequest
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
            'heading_1' => 'required|string',
            'heading_2' => 'required|string',
            'heading_3' => 'required|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'show_errors_swal' => true,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422)
        );
    }

    function sanitized(): array
    {
        return [
            [
                'meta_key' => 'heading_1',
                'meta_value' => $this->input('heading_1'),
            ],
            [
                'meta_key' => 'heading_2',
                'meta_value' => $this->input('heading_2'),
            ],
            [
                'meta_key' => 'heading_3',
                'meta_value' => $this->input('heading_3'),
            ],
        ];
    }
}
