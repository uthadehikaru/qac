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
            'price' => 'numeric|min:0',
            'price_sell' => 'numeric|min:0',
            'thumbnail' => 'nullable|image',
        ];
    }
}
