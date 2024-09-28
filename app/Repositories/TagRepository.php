<?php

namespace App\Repositories;
use App\Models\Tag;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Repositories\BaseRepository;

/**
 * Class TagService
 * @package App\Services
 */
class TagRepository extends BaseRepository implements TagRepositoryInterface
{
    protected $model;

    public function __construct(
        Tag $model
    ){
        $this->model = $model;
    }
    
    public function tagPagination(
        array $column = ['*'], 
        array $condition = [], 
        int $perPage = 1,
        array $extend = [],
        array $orderBy = ['id', 'DESC'],
        array $join = [],
        array $relations = [],
    ){

        $query = $this->model->select($column)->where(function($query) use ($condition){
            if(isset($condition['keyword']) && !empty($condition['keyword'])){
                $query->where('name', 'LIKE', '%'.$condition['keyword'].'%');
            }
            if(isset($condition['publish']) && $condition['publish'] != 0){
                $query->where('publish', '=', $condition['publish']);
            }
            return $query;
        });
        if(!empty($join)){
            $query->join(...$join);
        }
        return $query->paginate($perPage)
            ->withQueryString()->withPath(env('APP_URL').$extend['path']);
    }

    public function getPostByTag($tag_id = 0, $language_id = 0){
        return $this->model->select([
                'tb4.id',
                'tb4.image',
                'tb3.canonical',
                'tb3.name'
            ]
        )
        ->join('tag_post as tb2', 'tb2.tag_id','=','tags.id')
        ->join('post_language as tb3', 'tb3.post_id', '=', 'tb2.post_id')
        ->join('posts as tb4', 'tb4.id', '=', 'tb3.post_id')
        ->where('tb2.tag_id','=', $tag_id)
        ->where('tb3.language_id','=', $language_id)
        ->get();
    }

}
