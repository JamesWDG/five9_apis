<?php

namespace App\Http\Requests\Api\CMS\AboutUsPageCms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateContentSectionRequest extends FormRequest
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
            'para' => 'required|string',
            'image' => 'nullable|image'
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

    function sanitiazedImage(): string|null
    {
        $publicUrl = null;
        if ($this->hasFile('image')) {
            $file = $this->file('image');

            // Create a unique filename
            $filename = time() . '.' . $file->getClientOriginalExtension();

            // Move file to public/images/services/cards
            $destinationPath = public_path('images/about-us/content');
            $file->move($destinationPath, $filename);

            // Full public URL
            $publicUrl = asset('images/about-us/content/' . $filename);
        }
        return $publicUrl;
    }
}
