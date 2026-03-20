<?php

namespace App\Http\Requests\Api\CMS\SocialLinksCms;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateSocialLinksRequest extends FormRequest
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
            'linkedin' => 'nullable|string',
            'twitter' => 'nullable|string',
            'facebook' => 'nullable|string',
            'google' => 'nullable|string',
            'instagram' => 'nullable|string',
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
                'meta_key' => 'linkedin',
                'meta_value' => $this->input('linkedin'),
            ],
            [
                'meta_key' => 'twitter',
                'meta_value' => $this->input('twitter'),
            ],
            [
                'meta_key' => 'facebook',
                'meta_value' => $this->input('facebook'),
            ],
            [
                'meta_key' => 'google',
                'meta_value' => $this->input('google'),
            ],
            [
                'meta_key' => 'instagram',
                'meta_value' => $this->input('instagram'),
            ],

        ];
    }
}
