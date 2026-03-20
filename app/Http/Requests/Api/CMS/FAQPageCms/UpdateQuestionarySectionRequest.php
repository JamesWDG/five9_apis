<?php

namespace App\Http\Requests\Api\CMS\FAQPageCms;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateQuestionarySectionRequest extends FormRequest
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
            'heading' => 'required|array',
            'heading.*' => 'required|string',

            'question' => 'required|array',
            'question.*' => 'required|array',
            'question.*.*' => 'required|string',

            'answer' => 'required|array',
            'answer.*' => 'required|array',
            'answer.*.*' => 'required|string',
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
        foreach ($this->input('heading', []) as $index => $heading) {
            $data[] = [
                'meta_key' => "heading",
                'meta_value' => trim($heading),
                'question-answers' => array_map(function ($qIndex) use ($index) {
                    return [
                        'question' => trim($this->input("question.$index.$qIndex") ?? ''),
                        'answer' => trim($this->input("answer.$index.$qIndex") ?? ''),
                    ];
                }, array_keys($this->input("question.$index", []))),
            ];
        }

        return $data ?? [];
    }

    public function sanitizedQuestionsAnswers(): array
    {
        $data = [];

        foreach ($this->input('heading', []) as $sectionIndex => $heading) {

            $questions = $this->input("question.$sectionIndex", []);

            foreach ($questions as $qIndex => $question) {

                $data[] = [
                    'section' => $sectionIndex,
                    'heading' => trim($heading),
                    'question' => trim($question),
                    'answer' => trim($this->input("answer.$sectionIndex.$qIndex") ?? ''),
                ];
            }
        }

        return $data;
    }

    // public function sanitizedQuestionsAnswers(): array
    // {
    //     $data = [];

    //     foreach ($this->input('question', []) as $sectionIndex => $questions) {

    //         foreach ($questions as $qIndex => $question) {

    //             $data[] = [
    //                 '#question' => trim($question),
    //                 'answer' => trim($this->input("answer.$sectionIndex.$qIndex") ?? ''),
    //             ];
    //         }
    //     }

    //     return $data;
    // }
}
