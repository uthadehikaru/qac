<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EcourseRequest extends FormRequest
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
            'title' => 'required|max:255',
            'slug' => 'nullable',
            'description' => 'nullable',
            'thumbnail' => 'nullable|image',
            'course_id' => 'required',
            'is_only_active_batch' => 'nullable',
        ];
    }
}
