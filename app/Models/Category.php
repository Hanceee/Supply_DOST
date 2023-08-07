<?php

namespace App\Models;

use App\Models\Supplier;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = ['name', 'hidden'];


    public function supplier()
    {
        return $this->hasMany(Supplier::class);


    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }



}
