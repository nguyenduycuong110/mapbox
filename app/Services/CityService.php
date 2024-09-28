<?php

namespace App\Services;

use App\Services\Interfaces\CityServiceInterface;
use App\Repositories\Interfaces\CityRepositoryInterface as CityRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


/**
 * Class CityService
 * @package App\Services
 */
class CityService extends BaseService implements CityServiceInterface 
{
    protected $cityRepository;
    

    public function __construct(
        CityRepository $cityRepository
    ){
        $this->cityRepository = $cityRepository;
    }

    public function paginate($request){
        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->integer('publish');
        $perPage = $request->integer('perpage');
        $cities = $this->cityRepository->cityPagination(
            $this->paginateSelect(), 
            $condition, 
            $perPage,
            ['path' => 'city/index'], 
        );
        
        return $cities;
    }
 

    public function create($request){
        DB::beginTransaction();
        try{
            $payload = $request->except(['_token','send']);
            $this->cityRepository->create($payload);
            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }

    public function update($id, $request){
        DB::beginTransaction();
        try{
            $payload = $request->except(['_token','send']);
            $this->cityRepository->update($id, $payload);
            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }

    public function destroy($id){
        DB::beginTransaction();
        try{
            $payload = $this->cityRepository->delete($id);
            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }
    }

    
    private function paginateSelect(){
        return [
            'id',
            'name',
            'lat',
            'long',
            'publish',
        ];
    }


}
