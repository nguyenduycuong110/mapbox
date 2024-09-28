<?php

namespace App\Services;

use App\Services\Interfaces\HomeStayServiceInterface;
use App\Repositories\Interfaces\HomeStayRepositoryInterface as HomeStayRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


/**
 * Class HomeStayService
 * @package App\Services
 */
class HomeStayService extends BaseService implements HomeStayServiceInterface 
{
    protected $homeStayRepository;

    public function __construct(
        HomeStayRepository $homeStayRepository
    ){
        $this->homeStayRepository = $homeStayRepository;
    }

    public function paginate($request){
        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->integer('publish');
        $perPage = $request->integer('perpage');
        $homestays = $this->homeStayRepository->homeStayPagination(
            $this->paginateSelect(), 
            $condition, 
            $perPage,
            ['path' => 'homestay/index'], 
        );
        
        return $homestays;
    }
 

    public function create($request){
        DB::beginTransaction();
        try{
            $payload = $request->except(['_token','send']);
            $payload['price'] = convert_price($payload['price']);
            $payload['album'] =  $this->formatAlbum($request);
            $this->homeStayRepository->create($payload);
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
            $payload['price'] = convert_price($payload['price']);
            $payload['album'] =  $this->formatAlbum($request);
            $this->homeStayRepository->update($id, $payload);
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
            $payload = $this->homeStayRepository->delete($id);
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
            'price',
            'lat',
            'long',
            'open_hours',
            'total_rooms',
            'current_guests',
            'city_id',
            'color_id',
            'address',
            'publish',
        ];
    }


}
