<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockRequest extends FormRequest
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
            'name'              => 'required|string|max:255',
            'category_id'       => 'required|exists:categories,id',
            'description'       => 'nullable|string',
            'vendor'            => 'nullable|string|max:255',
            'purchase_date'     => 'nullable|date|before_or_equal:today',
            'total_quantity'    => 'required|integer|min:1',
            'available_quantity'=> 'required|integer|min:1|lte:total_quantity',
            'unit_price'        => 'required|numeric|min:0',
            'condition'         => 'required|in:new,good,needs_repair,damaged',
            'qr_required'       => 'boolean',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
