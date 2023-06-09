<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Transaction;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_name',
        'parent_id',
        'trans_type',
        'status',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function childrens(){
        return $this->hasMany('App\Models\Category', 'parent_id', 'id');
    }

    public function childrenRecursive(){
        return $this->childrens()->with('childrenRecursive');
    }

    function transaction(){
        return $this->hasMany(Transaction::class);
    }
}
