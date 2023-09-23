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
        'image_path',
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

    public function images()
    {
        return $this->hasMany(Image::class, 'house_id', 'id');
    }

    public function getImagePathsAttribute()
    {
        return $this->images->pluck('image_path')->toArray();
    }
}
