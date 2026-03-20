<?php

namespace App\Http\Requests\APi\CMS\FAQPageCms;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreQuestionarySectionRequest extends FormRequest
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
            'question' => 'required|array',
            'question.*' => 'required|string',
            'answer' => 'required|array',
            'answer.*' => 'required|string',
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

    public function sanitizedMeta(): array
    {
        return [
            [
                'meta_key' => 'heading',
                'meta_value' => $this->input('heading'),
            ],
        ];
    }

    public function sanitizedQuestionsAnswers(): array
    {
        $data = [];
        foreach ($this->input('question') as $key => $value) {

            $data[] = [
                '#question' => trim($value),
                'answer' => trim($this->input('answer')[$key]),
            ];
        }
        return $data;
    }
}
