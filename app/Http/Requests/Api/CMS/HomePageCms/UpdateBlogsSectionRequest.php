<?php

namespace App\Http\Requests\Api\CMS\HomePageCms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateBlogsSectionRequest extends FormRequest
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
            'button_text' => 'required|string',
            'button_url' => 'nullable|string',
            'para' => 'nullable|string',
            'box_heading' => 'required|array',
            'box_heading.*' => 'required|string',
            'box_para' => 'required|array',
            'box_para.*' => 'required|string',
            'box_image' => 'nullable|array',
            'box_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'box_button_text' => 'required|array',
            'box_button_text.*' => 'required|string',
            'box_button_url' => 'nullable|array',
            'box_button_url.*' => 'nullable|string',
            'box_date' => 'required|array',
            'box_date.*' => 'required|string',
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
        foreach ($this->input('box_heading') as $key => $value) {
            $publicUrl = null;
            if ($this->hasFile('box_image.' . $key)) {
                $file = $this->file('box_image.' . $key);

                // Create a unique filename
                $filename = time() . '.' . $file->getClientOriginalExtension();

                // Move file to public/images/services/cards
                $destinationPath = public_path('images/blogs/cards');
                $file->move($destinationPath, $filename);

                // Full public URL
                $publicUrl = asset('images/blogs/cards/' . $filename);
            }
            $data[] = [
                '#box_heading' => trim($value),
                'box_para' => trim($this->input('box_para')[$key]),
                'box_image' => $publicUrl,
                'box_date' => $this->input('box_date')[$key],
                'box_button_text' => trim($this->input('box_button_text')[$key]),
                'box_button_url' => trim($this->input('box_button_url')[$key]),
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
                'meta_key' => 'button_text',
                'meta_value' => $this->input('button_text'),
            ],
            [
                'meta_key' => 'button_url',
                'meta_value' => $this->input('button_url'),
            ],
            [
                'meta_key' => 'para',
                'meta_value' => $this->input('para') ?? '',
            ],
            [
                'meta_key' => 'crud',
                'meta_value' => 'cards',
            ]
        ];
    }
}
