<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Transaction;

class Method extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'method_name',
        'status'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    function transaction(){
        return $this->hasMany(Transaction::class);
    }
}
