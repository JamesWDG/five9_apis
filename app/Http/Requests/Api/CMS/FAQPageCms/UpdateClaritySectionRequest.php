<?php

namespace App\Http\Requests\Api\CMS\FAQPageCms;

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
            'para_1' => 'required',
            'para_2' => 'required',
            'button_text' => 'required',
            'button_url' => 'nullable|url',
            'email' => 'sometimes|email',
            'phone' => 'sometimes|string',
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
                'meta_key' => 'para_1',
                'meta_value' => $this->input('para_1'),
            ],
            [
                'meta_key' => 'para_2',
                'meta_value' => $this->input('para_2'),
            ],
            [
                'meta_key' => 'email',
                'meta_value' => $this->input('email'),
            ],
            [
                'meta_key' => 'phone',
                'meta_value' => $this->input('phone'),
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
