<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction_log extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'user_id',
        'old_amount',
        'new_amount',
        'log_date',
        'log_type'
    ];

    public function transaction(){
        return $this->belongsTo(Transaction::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
