<?php

namespace App\Repositories;
use App\Models\Code;
use App\Repositories\Interfaces\CodeRepositoryInterface;
use App\Repositories\BaseRepository;

/**
 * Class CodeService
 * @package App\Services
 */
class CodeRepository extends BaseRepository implements CodeRepositoryInterface
{
    protected $model;

    public function __construct(
        Code $model
    ){
        $this->model = $model;
    }
    
    public function codePagination(
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
                $query->where('code', 'LIKE', '%'.$condition['keyword'].'%');
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
