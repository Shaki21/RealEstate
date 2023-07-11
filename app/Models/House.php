<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'bedroom',
        'bathroom',
        'quadrature',
        'floors',
        'garden_quadrature',
        'address',
        'property_type',
        'property_status',
        'description',
        'cityName',
        'countryName'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    public function city()
    {
        return $this->belongsTo(City::class, 'cityName', 'name');
    }
}
