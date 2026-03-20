<?php

namespace App\Http\Requests\Api\CMS\AboutUsPageCms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAdvisorySectionRequest extends FormRequest
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
            'heading' => 'required|string',
            'para' => 'required|string',
            'point' => 'required|array',
            'point.*' => 'required|string',
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

    function sanitizedCards(): array
    {
        $data = [];

        foreach ($this->input('point') as $value) {
            $data[] = [
                '#point' => trim($value),
            ];
        }
        return $data;
    }

    function sanitizedMeta(): array
    {
        return [
            [
                'meta_key' => 'heading',
                'meta_value' => $this->input('heading'),
            ],
            [
                'meta_key' => 'para',
                'meta_value' => $this->input('para'),
            ],
            [
                'meta_key' => 'crud',
                'meta_value' => 'bullets',
            ]
        ];
    }
}
