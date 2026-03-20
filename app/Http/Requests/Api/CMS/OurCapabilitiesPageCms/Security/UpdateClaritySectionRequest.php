<?php

namespace App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\Security;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateClaritySectionRequest extends FormRequest
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
            'sub_heading' => 'required',
            'para' => 'required',
            'button_text' => 'required',
            'button_url' => 'nullable|url',
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
                'meta_key' => 'sub_heading',
                'meta_value' => $this->input('sub_heading'),
            ],
            [
                'meta_key' => 'para',
                'meta_value' => $this->input('para'),
            ],
            [
                'meta_key' => 'button_text',
                'meta_value' => $this->input('button_text'),
            ],
            [
                'meta_key' => 'button_url',
                'meta_value' => $this->input('button_url'),
            ],

        ];
    }
}
