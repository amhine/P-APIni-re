<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class passercommande extends FormRequest
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
                'user_id' => 'required|exists:users,id',  
                'plantes' => 'required|array',  
                'plantes.*.slug' => 'required|exists:plantes,slug', 
                'plantes.*.quantite' => 'required|integer|min:1',  
            
        ];
    }
}
