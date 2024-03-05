<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'user_id' => "required | exists:users,id",
            "product_id" => "required | exists:products,id",
            'comment' => "required"
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'The user is required.',
            'product_id.required' => 'The product is required.',
            'user_id.exists' => 'Please enter a valid user.',
            'product_id.exists' => 'Please enter a valid product.',
            'comment.required' => 'The comment is required.',
        ];
    }
}
