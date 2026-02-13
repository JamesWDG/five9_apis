<?php

namespace App\Http\Requests\Api\CMS\HomePageCms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateServiceSectionRequest extends FormRequest
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
            'sub_heading' => 'nullable|string',
            'background_image' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,svg',
            'title' => 'required|array',
            'title.*' => 'required|string',
            'para' => 'required|array',
            'para.*' => 'required|string',
            'button_text' => 'required|array',
            'button_text.*' => 'required|string',
            'button_url' => 'nullable|array',
            'button_url.*' => 'nullable|string',
            'title_bg_image' => 'nullable|array',
            'title_bg_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
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
            'heading.string' => 'The heading must be a string.',
            'sub_heading.string' => 'The sub heading must be a string.',
            'background_image.image' => 'The background image must be an image file.',
            'background_image.mimes' => 'The background image must be a JPEG, PNG, JPG, GIF, or SVG file.',

            'title.required' => 'The title field is required.',
            'title.array' => 'The title must be an array.',
            'title.*.required' => 'Each title entry is required.',
            'title.*.string' => 'Each title entry must be a string.',
            'para.required' => 'The para field is required.',
            'para.array' => 'The para must be an array.',
            'para.*.required' => 'Each para entry is required.',
            'para.*.string' => 'Each para entry must be a string.',
            'button_text.*.required' => 'Each button text entry is required.',
            'button_text.*.string' => 'Each button text entry must be a string.',
            'button_url.*.required' => 'Each button URL entry is required.',
            'button_url.*.string' => 'Each button URL entry must be a string.',
            'title_bg_image.*.required' => 'Each title background image is required.',
            'title_bg_image.*.image' => 'Each title background image must be an image file.',
            'title_bg_image.*.mimes' => 'Each title background image must be a JPEG, PNG, JPG, GIF, or SVG file.',
        ];
    }

    function sanitizedCards(): array
    {
        $data = [];
        foreach ($this->input('title') as $key => $value) {
            $publicUrl = null;
            if ($this->hasFile('title_bg_image.' . $key)) {
                $file = $this->file('title_bg_image.' . $key);

                // Create a unique filename
                $filename = time() . '.' . $file->getClientOriginalExtension();

                // Move file to public/images/services/cards
                $destinationPath = public_path('images/services/cards');
                $file->move($destinationPath, $filename);

                // Full public URL
                $publicUrl = asset('images/services/cards/' . $filename);
            }
            $data[] = [
                '#title' => trim($value),
                'para' => trim($this->input('para')[$key]),
                'button_text' => trim($this->input('button_text')[$key]),
                'button_url' => trim($this->input('button_url')[$key]),
                'title_bg_image' => $publicUrl,
            ];
        }
        return $data;
    }

    function sanitizedMeta(): array
    {
        $bgImgUrl = null;

        if ($this->hasFile('background_image')) {

            $file = $this->file('background_image');

            // Create a unique filename
            $filename = time() . '.' . $file->getClientOriginalExtension();

            // Move file to public/images/services/cards
            $destinationPath = public_path('images/services/background');
            $file->move($destinationPath, $filename);

            // Full public URL
            $bgImgUrl = asset('images/services/background/' . $filename);
        }
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
                'meta_key' => 'background_image',
                'meta_value' => $bgImgUrl,
            ],
            [
                'meta_key' => 'crud',
                'meta_value' => 'cards',
            ]
        ];
    }
}
