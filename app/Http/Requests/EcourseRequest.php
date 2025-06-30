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
            'slug' => 'nullable|max:255',
            'description' => 'nullable|max:255',
            'thumbnail' => 'nullable|image',
            'course_id' => 'nullable|required_if:is_only_active_batch,1|exists:courses,id',
            'is_only_active_batch' => 'nullable',
            'category_id' => 'nullable|exists:categories,id',
            'level' => 'nullable|numeric',
            'recomendation' => 'nullable|numeric',
        ];
    }
}
