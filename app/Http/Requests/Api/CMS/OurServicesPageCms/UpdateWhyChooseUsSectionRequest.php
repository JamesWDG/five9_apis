<?php

namespace App\Http\Requests\Api\Cms\OurServicesPageCms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateWhyChooseUsSectionRequest extends FormRequest
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
            'points' => 'required'
            // 'title' => 'required|array',
            // 'title.*' => 'required|string',
            // 'para' => 'required|array',
            // 'para.*' => 'required|string',
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

    // function sanitizedCards(): array
    // {
    //     $data = [];
    //     foreach ($this->input('title') as $key => $value) {
    //         $data[] = [
    //             '#title' => trim($value),
    //             'para' => trim($this->input('para')[$key]),
    //         ];
    //     }
    //     return $data;
    // }

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
