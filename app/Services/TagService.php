<?php

namespace App\Services;

use App\Services\Interfaces\TagServiceInterface;
use App\Repositories\Interfaces\TagRepositoryInterface as TagRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


/**
 * Class TagService
 * @package App\Services
 */
class TagService extends BaseService implements TagServiceInterface 
{
    protected $tagRepository;
    

    public function __construct(
        TagRepository $tagRepository
    ){
        $this->tagRepository = $tagRepository;
    }

    public function paginate($request){

        $condition['keyword'] = addslashes($request->input('keyword'));

        $condition['publish'] = $request->integer('publish');

        $perPage = $request->integer('perpage');

        $tags = $this->tagRepository->tagPagination(

            $this->paginateSelect(), 

            $condition, 

            $perPage,

            ['path' => 'tag/index'], 

        );
        
        return $tags;
    }
 

    public function create($request){
        DB::beginTransaction();

        try{

            $payload = $request->except(['_token','send']);

            $tags = $this->tagRepository->create($payload);

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

            $tags = $this->tagRepository->update($id, $payload);

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

            $tag = $this->tagRepository->delete($id);

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
            'canonical',
            'publish',
            'created_at'
        ];
    }


}
