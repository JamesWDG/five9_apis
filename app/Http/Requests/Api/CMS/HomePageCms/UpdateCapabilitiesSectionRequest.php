<?php

namespace App\Http\Requests\Api\CMS\HomePageCms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCapabilitiesSectionRequest extends FormRequest
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
            'heading_1' => 'required|string',
            'heading_2' => 'required|string',
            'heading_3' => 'required|string',
            'sub_heading' => 'nullable|string',
            'para' => 'nullable|string',
            'box_heading' => 'required|array',
            'box_heading.*' => 'required|string',
            'box_para' => 'required|array',
            'box_para.*' => 'required|string',
            'box_image' => 'nullable|array',
            'box_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
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
                $destinationPath = public_path('images/capabilities/cards');
                $file->move($destinationPath, $filename);

                // Full public URL
                $publicUrl = asset('images/capabilities/cards/' . $filename);
            }
            $data[] = [
                '#box_heading' => trim($value),
                'box_para' => trim($this->input('box_para')[$key]),
                'box_image' => $publicUrl,
            ];
        }
        return $data;
    }

    function sanitizedMeta(): array
    {
        return [
            [
                'meta_key' => 'heading_1',
                'meta_value' => $this->input('heading_1'),
            ],
            [
                'meta_key' => 'heading_2',
                'meta_value' => $this->input('heading_2'),
            ],
            [
                'meta_key' => 'heading_3',
                'meta_value' => $this->input('heading_3'),
            ],
            [
                'meta_key' => 'sub_heading',
                'meta_value' => $this->input('sub_heading') ?? '',
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
