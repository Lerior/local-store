<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'max:100'],
            'price' => ['sometimes', 'decimal:0,2', 'min:0'],
            'description' => ['sometimes', 'string'],
            'stock' => ['sometimes', 'integer', 'min:0'],
            'images' => ['sometimes','array', 'min:1', 'max:3'],
            'images.*' => [
                'image',
                'mimes:png,jpg,jpeg,webp',
                'max:5120',
            ]
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $images = $this->file('images', []);

            foreach (array_keys($images) as $sortOrder) {
                if (!in_array((int) $sortOrder, [1, 2, 3], true)) {
                    $validator->errors()->add(
                        'images',
                        'Las posiciones de imagen permitidas son 1, 2 y 3.'
                    );
                }
            }
        });
    }
}
