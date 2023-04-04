<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'transaction_type' => 'required',
            'transaction_date' => 'required|date',
            'transaction_amount' => 'required',
            'category_id' => 'required',
            'method_id' => 'required',
            'bank_id' => 'required',
        ];
    }
}
