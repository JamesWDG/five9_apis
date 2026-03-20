<?php

namespace App\Http\Requests\Api\CMS\OurServicesPageCms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateHowWeWorkSectionRequest extends FormRequest
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

    function messages()
    {
        return [
            'heading.required' => 'The heading field is required.',
            'heading.string' => 'heading entry must be a string.',
            'points.required' => 'Points field is required.',
            // 'title.required' => 'The title field is required.',
            // 'title.array' => 'The title must be an array.',
            // 'title.*.required' => 'Each title entry is required.',
            // 'title.*.string' => 'Each title entry must be a string.',
            // 'para.required' => 'The para field is required.',
            // 'para.array' => 'The para must be an array.',
            // 'para.*.required' => 'Each para entry is required.',
            // 'para.*.string' => 'Each para entry must be a string.',
        ];
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
