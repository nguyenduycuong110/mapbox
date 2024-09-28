<?php

namespace App\Services;

use App\Services\Interfaces\ColorServiceInterface;
use App\Repositories\Interfaces\ColorRepositoryInterface as ColorRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


/**
 * Class ColorService
 * @package App\Services
 */
class ColorService extends BaseService implements ColorServiceInterface 
{
    protected $colorRepository;
    

    public function __construct(
        ColorRepository $colorRepository
    ){
        $this->colorRepository = $colorRepository;
    }

    public function paginate($request){
        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->integer('publish');
        $perPage = $request->integer('perpage');
        $color = $this->colorRepository->colorPagination(
            $this->paginateSelect(), 
            $condition, 
            $perPage,
            ['path' => 'color/index'], 
        );
        
        return $color;
    }
 

    public function create($request){
        DB::beginTransaction();
        try{
            $payload = $request->except(['_token','send']);
            $this->colorRepository->create($payload);
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
            $this->colorRepository->update($id, $payload);
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
            $payload = $this->colorRepository->delete($id);
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
            'code',
            'description',
            'publish',
        ];
    }


}
