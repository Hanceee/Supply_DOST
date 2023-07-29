<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Supplier extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'representative_name',
        'supplier_name',
        'position_designation',
        'company_address',
        'office_contact',
        'email',
        'business_permit_number',
        'tin',
        'philgeps_registration_number',
        'category_id',
    ];




    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // // Define an Eloquent event to update the transaction_avg_rating attribute before creating or updating the model.
    // protected static function booted()
    // {
    //     static::creating(function ($supplier) {
    //         $supplier->transaction_avg_rating = $supplier->calculateAverageRating();
    //     });

    //     static::updating(function ($supplier) {
    //         $supplier->transaction_avg_rating = $supplier->calculateAverageRating();
    //     });
    // }

    // // Calculate the average rating of all transactions for the supplier.
    // protected function calculateAverageRating()
    // {
    //     $transactions = $this->transaction;

    //     if ($transactions->isEmpty()) {
    //         return 0;
    //     }

    //     $totalRating = 0;
    //     foreach ($transactions as $transaction) {
    //         $totalRating += $transaction->average;
    //     }

    //     return round($totalRating / $transactions->count());
    // }

    // protected static function booted()
    // {
    //     static::created(function ($supplier) {
    //         $supplier->updateAverageRating();
    //     });

    //     static::updated(function ($supplier) {
    //         $supplier->updateAverageRating();
    //     });
    // }

    // // Update the supplier's average rating based on the transactions.
    // protected function updateAverageRating()
    // {
    //     $avgRating = $this->transactions()->avg('rating');
    //     $this->transaction_avg_rating = round($avgRating);
    //     $this->save();
    // }
}
