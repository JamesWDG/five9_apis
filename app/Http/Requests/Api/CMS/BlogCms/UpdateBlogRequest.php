<?php

namespace App\Http\Requests\Api\CMS\BlogCms;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;

class UpdateBlogRequest extends FormRequest
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
            'title' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'short_description' => 'nullable|string',
            'description' => 'required|string',
            'file' => 'nullable|max:16384',
            'date' => 'required|date',
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

    function sanitized(): array
    {
        return [
            'slug' => Str::slug($this->input('title')) . '-' . time(),
            'title' => $this->input('title'),
            'featured_image' => $this->sanitizedFeaturedImage(),
            'short_description' => $this->input('short_description'),
            'description' => $this->input('description'),
            'file' => $this->sanitizedFile(),
            'date' => Carbon::parse($this->input('date'))->format('Y-m-d'),
        ];
    }

    function sanitizedFeaturedImage(): string|null
    {
        if ($this->hasFile('featured_image')) {
            $file = $this->file('featured_image');
            // Create a unique filename
            $filename = time() . '.' . $file->getClientOriginalExtension();
            // Move file to public/images/services/cards
            $destinationPath = public_path('images/blogs/featured');
            $file->move($destinationPath, $filename);

            // Full public URL
            return asset('images/blogs/featured/' . $filename);
        }
        return null;
    }
    function sanitizedFile(): string|null
    {
        if ($this->hasFile('file')) {
            $file = $this->file('file');
            // Create a unique filename
            $filename = time() . '_' . $file->getClientOriginalName();
            // Move file to public/files/blogs
            $destinationPath = public_path('files/blogs');
            $file->move($destinationPath, $filename);

            // Full public URL
            return asset('files/blogs/' . $filename);
        }
        return null;
    }
}
