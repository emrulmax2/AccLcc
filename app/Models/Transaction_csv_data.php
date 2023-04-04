<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction_csv_data extends Model
{
    use HasFactory;

    protected $fillable =[
        'file_name', 'trans_date', 'description', 'amount', 'transaction_type', 'bank_id'
    ];
}
