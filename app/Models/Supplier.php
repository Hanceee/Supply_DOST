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

    public function category()
    {
        return $this->hasOne(Category::class);
    }
}
