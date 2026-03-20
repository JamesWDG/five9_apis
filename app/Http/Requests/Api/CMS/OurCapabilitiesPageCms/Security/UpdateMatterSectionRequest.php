<?php

namespace App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\Security;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateMatterSectionRequest extends FormRequest
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
            'para_1' => 'required|string',
            // 'para_2' => 'required|string',
            'file_1' => 'nullable',
            // 'file_2' => 'nullable',
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
        $file1 = null;

        // $file2 = null;
        if ($this->hasFile('file_1')) {
            $file = $this->file('file_1');

            // Create a unique filename
            $filename = time() . '.' . $file->getClientOriginalExtension();

            // Move file to public/images/services/cards
            $destinationPath = public_path('images/our-services/digital-services/matter-section');
            $file->move($destinationPath, $filename);

            // Full public URL
            $file1 = asset('images/our-services/digital-services/matter-section/' . $filename);
        }
        // if ($this->hasFile('file_2')) {
        //     $file = $this->file('file_2');

        //     // Create a unique filename
        //     $filename = time() . '.' . $file->getClientOriginalExtension();

        //     // Move file to public/images/services/cards
        //     $destinationPath = public_path('images/our-services/digital-services/matter-section');
        //     $file->move($destinationPath, $filename);

        //     // Full public URL
        //     $file2 = asset('images/our-services/digital-services/matter-section/' . $filename);
        // }

        return [
            [
                'meta_key' => 'heading',
                'meta_value' => $this->input('heading'),
            ],
            [
                'meta_key' => 'para_1',
                'meta_value' => $this->input('para_1'),
            ],
            // [
            //     'meta_key' => 'para_2',
            //     'meta_value' => $this->input('para_2'),
            // ],
            [
                'meta_key' => 'file_1',
                'meta_value' => $file1,
            ],
            // [
            //     'meta_key' => 'file_2',
            //     'meta_value' => $file2,
            // ],
        ];
    }
}
