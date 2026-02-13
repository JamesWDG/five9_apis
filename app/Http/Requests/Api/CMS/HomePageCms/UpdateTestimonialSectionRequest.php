<?php

namespace App\Http\Requests\Api\CMS\HomePageCms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateTestimonialSectionRequest extends FormRequest
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
            'title' => 'required|array',
            'title.*' => 'required|string',
            'para' => 'required|array',
            'para.*' => 'required|string',
            'client_name' => 'required|array',
            'client_name.*' => 'required|string',
            'client_designation' => 'nullable|array',
            'client_designation.*' => 'nullable|string',
            'client_company_name' => 'nullable|array',
            'client_company_name.*' => 'nullable|string',
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
        foreach ($this->input('title') as $key => $value) {
            $data[] = [
                '#title' => trim($value),
                'para' => trim($this->input('para')[$key]),
                'client_name' => $this->input('client_name')[$key],
                'client_designation' => trim($this->input('client_designation')[$key]),
                'client_company_name' => trim($this->input('client_company_name')[$key]),
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
                'meta_key' => 'crud',
                'meta_value' => 'cards',
            ]
        ];
    }
}
