<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;
use App\Models\Method;
use App\Models\Bank;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'transaction_code',
        'invoice_no',
        'invoice_date',
        'transaction_date',
        'category_id',
        'bank_id',
        'method_id',
        'transaction_amount',
        'cheque_no',
        'cheque_date',
        'transaction_type',
        'detail',
        'description',
        'transaction_doc_name',
        'created_by'
    ];

    public function method(){
        return $this->belongsTo(Method::class);
    }

    public function bank(){
        return $this->belongsTo(Bank::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    function transaction_log(){
        return $this->hasMany(Transaction_log::class);
    }

}
