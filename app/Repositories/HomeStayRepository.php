<?php

namespace App\Repositories;
use App\Models\HomeStay;
use App\Repositories\Interfaces\HomeStayRepositoryInterface;
use App\Repositories\BaseRepository;

/**
 * Class HomeStayService
 * @package App\Services
 */
class HomeStayRepository extends BaseRepository implements HomeStayRepositoryInterface
{
    protected $model;

    public function __construct(
        HomeStay $model
    ){
        $this->model = $model;
    }
    
    public function homeStayPagination(
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
                $query->where('name', 'LIKE', '%'.$condition['keyword'].'%')
                ->orWhere('address', 'LIKE', '%'.$condition['keyword'].'%');
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

    public function getAllHomeStay($city_id = 0){
        return $this->model->select([
            'homestays.*',
            'tb2.code',
            'tb2.description'
        ])
        ->join('colors as tb2','tb2.id','=','homestays.color_id')
        ->where('city_id', $city_id)
        ->get();
    }

}
