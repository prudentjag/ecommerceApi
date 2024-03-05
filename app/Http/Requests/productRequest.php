<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class productRequest extends FormRequest
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
            'products'=>'required|string',
            'Rating'=>'required|string',
            'description'=>'required|min:10',
            'catergory' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'products.required' => 'You must add a product',
            'rating.required' => 'The rating field is required.',
            'description.required' => 'The description field is required.',
            'description.min' => 'The description must contain atleast 10 characters.',
            'catergory.required' => 'The category field is required.',
        ];
    }
}
