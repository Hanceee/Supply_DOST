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

    // public function getTransactionAverageRatingAttribute()
    // {
    //     return round(($this->quality_rating + $this->completeness_rating + $this->conformity_rating) / 3, 1);
    // }



    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Define an accessor to calculate the average rating attribute.
    public function getRatingAttribute()
    {
        return round(($this->quality_rating + $this->completeness_rating + $this->conformity_rating) / 3);
    }

    // Define an Eloquent event to set the rating attribute before creating or updating the model.
    protected static function booted()
    {
        static::creating(function ($transaction) {
            $transaction->rating = $transaction->averageRating();
        });

        static::updating(function ($transaction) {
            $transaction->rating = $transaction->averageRating();
        });
    }

    // Calculate the average rating of the three rating fields.
    protected function averageRating()
    {
        return round(($this->quality_rating + $this->completeness_rating + $this->conformity_rating) / 3);
    }

}
