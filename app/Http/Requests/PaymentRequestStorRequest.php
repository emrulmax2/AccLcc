<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequestStorRequest extends FormRequest
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
            'request_doc' => 'required|mimes:jpg,png,jpeg,gif,pdf,docx,doc,xl,xls,xlsx|max:2048',
            'request_amount' => 'required',
            'request_reason' => 'required',
            'user_code' => 'required',
        ];
    }
}
