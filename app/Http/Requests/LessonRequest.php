<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
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
            'subject' => 'required|max:255',
            'section_id' => 'required|exists:sections,id',
            'thumbnail' => 'nullable|image',
            'filename' => 'nullable|file',
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated();
        unset($data['filename']);
        return $data;
    }
}
