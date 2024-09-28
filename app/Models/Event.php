<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'description',
        'startDate',
        'endDate'
    ];

    public function customer_event(){
        return $this->belongsToMany(Customer::class,'customer_event','event_id', 'customer_id')->
        withPivot('id','send_status');
    }

}
