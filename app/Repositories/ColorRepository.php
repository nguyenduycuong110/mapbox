<?php

namespace App\Repositories;
use App\Models\Color;
use App\Repositories\Interfaces\ColorRepositoryInterface;
use App\Repositories\BaseRepository;

/**
 * Class ColorService
 * @package App\Services
 */
class ColorRepository extends BaseRepository implements ColorRepositoryInterface
{
    protected $model;

    public function __construct(
        Color $model
    ){
        $this->model = $model;
    }
    
    public function colorPagination(
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
                $query->where('code', 'LIKE', '%'.$condition['keyword'].'%')
                ->orWhere('name', 'LIKE', '%'.$condition['keyword'].'%');
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

}
