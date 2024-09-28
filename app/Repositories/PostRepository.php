<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
/**
 * Class UserService
 * @package App\Services
 */
class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    protected $model;

    public function __construct(
        Post $model
    ){
        $this->model = $model;
    }

    

    public function getPostById(int $id = 0, $language_id = 0){
        return $this->model->select([
                'posts.id',
                'posts.type',
                'posts.post_catalogue_id',
                'posts.image',
                'posts.icon',
                'posts.album',
                'posts.publish',
                'posts.follow',
                'posts.video',
                'tb2.name',
                'tb2.description',
                'tb2.content',
                'tb2.meta_title',
                'tb2.meta_keyword',
                'tb2.meta_description',
                'tb2.canonical',
            ]
        )
        ->join('post_language as tb2', 'tb2.post_id', '=','posts.id')
        ->with('post_catalogues')
        ->with(['tag_post' => function ($query) {
            $query->select('tag_id','name','canonical'); 
        }])
        ->where('tb2.language_id', '=', $language_id)
        ->find($id);
    }

    public function getPostByCanonical($canonical = '', $language_id = 0){
        return $this->model->select([
                'posts.id',
                'posts.type',
                'posts.post_catalogue_id',
                'posts.image',
                'posts.icon',
                'posts.album',
                'posts.publish',
                'posts.follow',
                'posts.video',
                'tb2.name',
                'tb2.description',
                'tb2.content',
                'tb2.meta_title',
                'tb2.meta_keyword',
                'tb2.meta_description',
                'tb2.canonical',
            ]
        )
        ->join('post_language as tb2', 'tb2.post_id', '=','posts.id')
        ->with('post_catalogues')
        ->where('tb2.language_id', '=', $language_id)
        ->where('tb2.canonical', '=', $canonical)
        ->first();
    }

    public function getNotification(){
        return $this->model->select([
                'posts.id',
                'posts.image',
                'tb2.name',
                'tb2.description',
                'tb2.canonical',
                'tb3.created_at',
            ]
        )
        ->join('post_language as tb2', 'tb2.post_id', '=','posts.id')
        ->join('notifications as tb3', 'tb3.post_id', '=','posts.id')
        ->orderBy('tb3.created_at','desc')
        ->get();
    }

    public function getTotalNotification($customer_id = 0){
        return $this->model->select([
                DB::raw('COUNT(tb4.is_read) as total_is_read')
            ]
        )
        ->join('notifications as tb3', 'tb3.post_id', '=','posts.id')
        ->join('notification_customer as tb4', function($join) use ($customer_id) {
            $join->on('tb4.notification_id', '=', 'tb3.id')
                 ->where('tb4.customer_id', '=', $customer_id);
        })
        ->get();
    }

    public function findNewsNotification($time){
        return $this->model->select([
            'posts.id',
            'posts.image',
            'posts.created_at',
            'tb2.name',
            'tb2.canonical'
        ]
    )
    ->join('post_language as tb2', 'tb2.post_id', '=','posts.id')
    ->join('notifications as tb3', 'tb3.post_id', '=','posts.id')
    ->where('posts.created_at', '>', $time)
    ->get();
    }

}
