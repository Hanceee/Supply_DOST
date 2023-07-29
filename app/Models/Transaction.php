<?php

namespace App\Models;

use App\Models\Supplier;
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
        'remarks',
    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::saved(function ($transaction) {
    //         $averageRating = ($transaction->quality_rating + $transaction->completeness_rating + $transaction->conformity_rating) / 3;
    //         $transaction->transaction_average_rating = round($averageRating, 1);
    //         $transaction->save();
    //     });
    // }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

}
