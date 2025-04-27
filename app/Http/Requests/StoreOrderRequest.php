<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'user_id'=>"required|exists:users,id",
            'discount'=>"nullable|numeric",
            'note'=>"nullable|string",
            'payment_method'=>"required|string",
            'payment_status'=>"required|string",
            'amount_paid'=>"required|numeric|min:0",
            'order_status'=>"required|string",
            'total'=>'required|numeric|min:0'
        ];
    }
}
