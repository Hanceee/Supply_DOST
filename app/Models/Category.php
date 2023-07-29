<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = ['name', 'supplier_count', 'hidden'];

    public function suppliers()
    {
        return $this->belongsTo(Supplier::class);

    }




}
