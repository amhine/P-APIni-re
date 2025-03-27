<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class plantestore extends FormRequest
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
            'name' => 'required|string|max:255|unique:plantes,name',
            'description' => 'nullable|string',
            'images' => 'array|max:4',
            'images.*' => 'url',
            'prix' => 'required|numeric|min:0'
        ];
    }
}
