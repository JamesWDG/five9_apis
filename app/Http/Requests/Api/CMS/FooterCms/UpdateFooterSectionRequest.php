<?php

namespace App\Http\Requests\Api\CMS\FooterCms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateFooterSectionRequest extends FormRequest
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
            'logo_img' => 'nullable|image',
            'para' => 'required|string',
            // 'para.*' => 'required|string',
            'info_1' => 'required|array',
            'info_1.*' => 'required|string',
            'info_2' => 'nullable|array',
            'info_2.*' => 'nullable|string',
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
                'info_1' => trim($this->input('info_1')[$key]),
                'info_2' => $this->input('info_2')[$key],
            ];
        }
        return $data;
    }

    function sanitizedMeta(): array
    {
        $ImgUrl = null;
        if ($this->hasFile('logo_img')) {
            $file = $this->file('logo_img');
            // Create a unique filename
            $filename = time() . '.' . $file->getClientOriginalExtension();
            // Move file to public/images/services/cards
            $destinationPath = public_path('images/footer/logo');
            $file->move($destinationPath, $filename);
            // Full public URL
            $ImgUrl = asset('images/footer/logo/' . $filename);
        }
        return [
            [
                'meta_key' => 'logo_img',
                'meta_value' => $ImgUrl,
            ],
            [
                'meta_key' => 'para',
                'meta_value' => trim($this->input('para')),
            ],
            [
                'meta_key' => 'crud',
                'meta_value' => 'cards',
            ]
        ];
    }
}
