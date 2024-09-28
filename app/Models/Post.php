<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use App\Traits\QueryScopes;

class Post extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;

    protected $fillable = [
        'image',
        'type',
        'album',
        'publish',
        'follow',
        'order',
        'user_id',
        'post_catalogue_id',
        'video',
    ];

    protected $table = 'posts';

    public function languages(){
        return $this->belongsToMany(Language::class, 'post_language' , 'post_id', 'language_id')
        ->withPivot(
            'name',
            'canonical',
            'meta_title',
            'meta_keyword',
            'meta_description',
            'description',
            'content'
        )->withTimestamps();
    }

    public function post_catalogues(){
        return $this->belongsToMany(PostCatalogue::class, 'post_catalogue_post' , 'post_id', 'post_catalogue_id');
    }

    public function tag_post(){
        return $this->belongsToMany(Tag::class,'tag_post','post_id','tag_id');
    }  

    public function notification_post(){
        return $this->hasOne(Notification::class, 'post_id');
    }
    
}
