<?php

namespace App\Http\Resources\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreResources extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|integer|exists:categories,id',
        ];
    }
}
