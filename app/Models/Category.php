<?php

namespace App\Models;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = ['name', 'hidden'];


    // protected static function boot()
    // {
    //     parent::boot();

    //     static::created(function ($category) {
    //         $count = $category->suppliers()->count();
    //         $category->supplier_count = $count;
    //         $category->save();
    //     });

    //     static::deleted(function ($category) {
    //         $category->suppliers()->update(['category_id' => null]);
    //     });
    // }


    public function supplier()
    {
        return $this->hasMany(Supplier::class);
        // return $this->belongsToMany(Supplier::class);


    }




}
