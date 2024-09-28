<?php

namespace App\Services;

use App\Services\Interfaces\CodeServiceInterface;
use App\Repositories\Interfaces\CodeRepositoryInterface as CodeRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


/**
 * Class CodeService
 * @package App\Services
 */
class CodeService extends BaseService implements CodeServiceInterface 
{
    protected $codeRepository;
    

    public function __construct(
        CodeRepository $codeRepository
    ){
        $this->codeRepository = $codeRepository;
    }

    public function paginate($request){
        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->integer('publish');
        $perPage = $request->integer('perpage');
        $codes = $this->codeRepository->codePagination(
            $this->paginateSelect(), 
            $condition, 
            $perPage,
            ['path' => 'code/index'], 
        );
        
        return $codes;
    }
 

    public function create($request){
        DB::beginTransaction();
        try{
            $payload = $request->except(['_token','send']);
            $codes = $this->generateUniqueCode($payload);
            $this->codeRepository->updateOrInsert($codes);
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
            $code = $this->codeRepository->delete($id);
            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }
    }

    private function generateUniqueCode($payload, $existingCodes = [], $length = 10){

        $temp = [];

        $generateCode = function () use ($existingCodes , $length){

            $min = pow(10, $length - 1); 

            $max = pow(10, $length) - 1; 

            $code = random_int($min, $max); 

            if (in_array($code, $existingCodes)) {
                return $generateCode();
            }

            return str_pad($code, $length, '0', STR_PAD_LEFT); 

        };

        for ($i = 0; $i < $payload['quantity']; $i++) {

            $temp[] = ['code' => $generateCode()];

        }

        return $temp;

    }
    
    private function paginateSelect(){
        return [
            'id',
            'code', 
            'publish',
        ];
    }


}
