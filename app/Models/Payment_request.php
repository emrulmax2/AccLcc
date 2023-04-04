<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_request extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id', 
        'request_date', 
        'amount', 
        'description', 
        'upload', 
        'request_by', 
        'payment_date', 
        'method_id', 
        'bank_id', 
        'status', 
        'approved_by'
    ];
}
