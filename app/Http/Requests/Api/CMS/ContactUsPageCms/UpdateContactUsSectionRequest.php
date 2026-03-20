<?php

namespace App\Http\Requests\Api\CMS\ContactUsPageCms;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateContactUsSectionRequest extends FormRequest
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
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
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
                'meta_key' => 'phone',
                'meta_value' => $this->input('phone'),
            ],
            [
                'meta_key' => 'email',
                'meta_value' => $this->input('email'),
            ],
            [
                'meta_key' => 'address',
                'meta_value' => $this->input('address'),
            ],
        ];
    }
}
