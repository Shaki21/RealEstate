<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'house_id',
        'image_path'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function house()
    {
        return $this->belongsTo(House::class, 'house_id');
    }
}

