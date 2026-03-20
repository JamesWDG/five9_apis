<?php

namespace App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\Applications;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCaseStudySectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'heading' => 'required|string',
            'points' => 'required'
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


    function sanitizedMeta(): array
    {
        return [
            [
                'meta_key' => 'heading',
                'meta_value' => $this->input('heading'),
            ],
            [
                'meta_key' => 'points',
                'meta_value' => $this->input('points'),
            ]
        ];
    }
}
