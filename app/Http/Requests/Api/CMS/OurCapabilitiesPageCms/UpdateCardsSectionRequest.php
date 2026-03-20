<?php

namespace App\Http\Requests\Api\CMS\OurCapabilitiesPageCms;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCardsSectionRequest extends FormRequest
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
            'box_heading' => 'required|array',
            'box_heading.*' => 'required|string',
            'box_para' => 'required|array',
            'box_para.*' => 'required|string',
            'box_button_text' => 'required|array',
            'box_button_text.*' => 'required|string',
            'box_button_url' => 'required|array',
            'box_button_url.*' => 'nullable|string',
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
                $destinationPath = public_path('images/our-capabilities/capabilities/cards');
                $file->move($destinationPath, $filename);

                // Full public URL
                $publicUrl = asset('images/our-capabilities/capabilities/cards/' . $filename);
            }
            $data[] = [
                '#box_heading' => trim($value),
                'box_para' => trim($this->input('box_para')[$key]),
                'box_button_text' => trim($this->input('box_button_text')[$key]),
                'box_button_url' => trim($this->input('box_button_url')[$key]),
                'box_image' => $publicUrl,
            ];
        }
        return $data;
    }

    function sanitizedMeta(): array
    {
        return [
            [
                'meta_key' => 'crud',
                'meta_value' => 'cards',
            ]
        ];
    }
}
