<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeStay extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'lat',
        'long',
        'image',
        'album',
        'price',
        'address',
        'open_hours',
        'total_rooms',
        'current_guests',
        'color_id',
        'city_id',
        'publish'
    ];

    protected $table = 'homestays';

    public function cities(){
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function colors(){
        return $this->belongsTo(Color::class, 'color_id', 'id');
    }

}
