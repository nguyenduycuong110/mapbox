<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use Illuminate\Support\Str;
use App\Repositories\Interfaces\CustomerRepositoryInterface  as CustomerRepository;
use Intervention\Image\Colors\Rgb\Channels\Red;
use App\Models\NotificationCustomer;
use App\Models\CustomerEvent;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerPostCatalogue;


class DashboardController extends Controller
{

    protected $language;
    protected $customerRepository;

    public function __construct(
       CustomerRepository $customerRepository
    ){
        $this->customerRepository = $customerRepository;
        $this->middleware(function($request, $next){
            $locale = app()->getLocale(); // vn en cn
            $language = Language::where('canonical', $locale)->first();
            $this->language = $language->id;
            return $next($request);
        });
    }

    public function changeStatus(Request $request){
        $post = $request->input();
        $serviceInterfaceNamespace = '\App\Services\\' . ucfirst($post['model']) . 'Service';
        if (class_exists($serviceInterfaceNamespace)) {
            $serviceInstance = app($serviceInterfaceNamespace);
        }
        $flag = $serviceInstance->updateStatus($post);

        return response()->json(['flag' => $flag]); 
        
    }

    public function changeStatusAll(Request $request){
        $post = $request->input();
        $serviceInterfaceNamespace = '\App\Services\\' . ucfirst($post['model']) . 'Service';
        if (class_exists($serviceInterfaceNamespace)) {
            $serviceInstance = app($serviceInterfaceNamespace);
        }
        $flag = $serviceInstance->updateStatusAll($post);
        return response()->json(['flag' => $flag]); 

    }

    public function getMenu(Request $request){
        $model = $request->input('model');
        $page = ($request->input('page')) ?? 1;
        $keyword = ($request->string('keyword')) ?? null;

        $serviceInterfaceNamespace = '\App\Repositories\\' . ucfirst($model) . 'Repository';
        if (class_exists($serviceInterfaceNamespace)) {
            $serviceInstance = app($serviceInterfaceNamespace);
        }
        
        $agruments = $this->paginationAgrument($model, $keyword);
        $object = $serviceInstance->pagination(...array_values($agruments));
        
        return response()->json($object); 
    }

    private function paginationAgrument(string $model = '', string $keyword): array{
        $model = Str::snake($model);
        $join = [
            [$model.'_language as tb2', 'tb2.'.$model.'_id', '=', $model.'s.id'],
        ];
        if(strpos($model, '_catalogue') === false){
            $join[] = [''.$model.'_catalogue_'.$model.' as tb3', ''.$model.'s.id', '=', 'tb3.'.$model.'_id'];
        }

        $condition = [
            'where' => [
                ['tb2.language_id', '=', $this->language],
            ],
        ];
        if(!is_null($keyword)){
            $condition['keyword'] = addslashes($keyword);
        }
        return [
            'column' => ['id','name','canonical'],
            'condition' => $condition,
            'perpage' => 20,
            'extend' => [
                'path' => $model.'.index', 
                'groupBy' => ['id','name']
            ],
            'orderBy' => [$model.'s.id', 'DESC'],
            'join' => $join,
            'relations' => [],
        ];
    }

    public function findModelObject(Request $request){
        $get = $request->input();
        $alias = Str::snake($get['model']).'_language';
        $class = loadClass($get['model']);
        $object = $class->findWidgetItem([
            ['name','LIKE', '%'.$get['keyword'].'%'],
        ], $this->language, $alias);
        return response()->json($object); 
    }

    public function findPromotionObject(Request $request){
        $get = $request->input();
        $model = $get['option']['model'];
        $keyword = $get['search'];
        $alias = Str::snake($model).'_language';
        $class = loadClass($model);
        $object = $class->findWidgetItem([
            ['name','LIKE', '%'.$keyword.'%'],
        ], $this->language, $alias);

        $temp = [];
        if(count($object)){
            foreach($object as $key => $val){
                $temp[] = [
                    'id' => $val->id,
                    'text' => $val->languages->first()->pivot->name,
                ];
            }
        }

        return response()->json(array('items' => $temp)); 
    }


    public function getPromotionConditionValue(Request $request){
        try {
            $get = $request->input();
            switch ($get['value']) {
                case 'staff_take_care_customer':
                    $class = loadClass('User');
                    $object = $class->all()->toArray();
                    break;
                case 'customer_group':
                    $class = loadClass('CustomerCatalogue');
                    $object = $class->all()->toArray();
                    break;
                case 'customer_gender':
                    $object = __('module.gender');
                    break;
                case 'customer_birthday':
                    $object = __('module.day');
                    break;
            }
            $temp = [];
            if(!is_null($object) && count($object)){
                foreach($object as $key => $val){
                    $temp[] = [
                        'id' => $val['id'],
                        'text' => $val['name'],
                    ];
                }
            }
            return response()->json([
                'data' => $temp,
                'error' => false,
            ]);

        }catch(\Exception $e ){
            Log::error($e->getMessage());
            return response()->json([
                'error' => true,
                'messages' =>  $e->getMessage(),
            ]);
        }
        
    }

    public function findInformationObject(Request $request)
    {
        $get = $request->input();
        $class = loadClass($get['model']);
        $object = $class->searchInformation([
            ['name', 'LIKE', '%' . $get['keyword'] . '%'],
            ['phone', 'LIKE', '%' . $get['keyword'] . '%', 'orWhere'],
            ['code', 'LIKE', '%' . $get['keyword'] . '%', 'orWhere'],
        ]);
    
        return response()->json($object); 
    }

    public function changeAlert(Request $request){
        $alert = (int)($request->input('alert'));
        $customer_id = $request->input('customer_id');
        if($alert !== 0){
            $customer = $this->customerRepository->update($customer_id, ['alert' => 0]);
        }else{
            $customer = $this->customerRepository->update($customer_id, ['alert' => 1]);
        }
        return response()->json([
            'alert' => $customer->alert,
            'messages' => 'Cập nhật trạng thái thành công'
        ]);
    }

    public function totalNotificationNew(Request $request){

        $total = (int)($request->input('total_notification_new'));

        $customer_id = $request->input('customer_id');

        if($total !== 0){
            NotificationCustomer::where('customer_id', $customer_id)->forceDelete();
        }

        return response()->json(
            [
                'status' => 200
            ]
        );
        
    }

    public function registerEvent(Request $request){

        $status = $request->input('status');

        $customer_id = $request->input('customer_id');

        $event_id = $request->input('event_id');
        
        if($status == 0){

            CustomerEvent::create([
                'customer_id' => $customer_id,
                'event_id' => $event_id
            ]);

            return response()->json([
                'status' => 1
            ]);

        }else{
            DB::table('customer_event')
                ->where('customer_id', $customer_id)
                ->where('event_id', $event_id)
                ->delete();

            return response()->json([
                'status' => 0
            ]);
        }
    }

    public function registerNotification(Request $request){
        $customer_id = $request->input('customer_id');
        $post_catalogue_id = $request->input('post_catalogue_id');
        $record = CustomerPostCatalogue::where('customer_id', $customer_id)
                ->where('post_catalogue_id', $post_catalogue_id)
                ->first();
        $alert = null;
        if($record == null){
            $record = CustomerPostCatalogue::create([
                'customer_id' => $customer_id,
                'post_catalogue_id' => $post_catalogue_id,
            ]);
            $alert = 1;
        }else{
            $record = CustomerPostCatalogue::where('customer_id', $customer_id)
                ->where('post_catalogue_id', $post_catalogue_id)
                ->forceDelete();
            $alert = 0 ;
        }

        return response()->json([
            'alert' => $alert
        ]);
        
    }

}
