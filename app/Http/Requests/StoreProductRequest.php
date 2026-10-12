<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
   public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Product name is required.',
            'name.string' => 'Product name must be text.',
            'name.max' => 'Product name cannot exceed 255 characters.',

            'price.required' => 'Product price is required.',
            'price.numeric' => 'Product price must be a number.',
            'price.min' => 'Product price cannot be negative.',

            'description.string' => 'Product description must be text.',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
