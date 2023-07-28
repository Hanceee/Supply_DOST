<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'date',
        'article_description',
        'price',
        'supplier_id',
        'quality_rating',
        'completeness_rating',
        'conformity_rating',
        'transaction_average_rating',
        'remarks',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

}
