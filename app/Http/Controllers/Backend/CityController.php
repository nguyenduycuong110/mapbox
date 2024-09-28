<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\CityServiceInterface  as CityService;
use App\Repositories\Interfaces\CityRepositoryInterface as CityRepository;
use App\Http\Requests\City\StoreCityRequest;
use App\Http\Requests\City\UpdateCityRequest;

class CityController extends Controller
{
    protected $cityService;
    protected $cityRepository;

    public function __construct(
        CityService $cityService,
        CityRepository $cityRepository,
    ){
        $this->cityService = $cityService;
        $this->cityRepository = $cityRepository;
    }

    public function index(Request $request){
        $this->authorize('modules', 'city.index');
        $cities = $this->cityService->paginate($request);
        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/library/city.js',
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'city'
        ];
        $config['seo'] = __('messages.city');
        $template = 'backend.city.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'cities'
        ));
    }

    public function create(){
        $this->authorize('modules', 'city.create');
        $config = $this->config();
        $config['seo'] = __('messages.city');
        $config['method'] = 'create';
        $template = 'backend.city.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
        ));
    }

    public function store(StoreCityRequest $request){
        if($this->cityService->create($request, $this->language)){
            return redirect()->route('city.index')->with('success','Thêm mới bản ghi thành công');
        }
        return redirect()->route('city.index')->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id){
        $this->authorize('modules', 'city.edit');
        $city = $this->cityRepository->findById($id);
        $config = $this->config();
        $config['seo'] = __('messages.city');
        $config['method'] = 'edit';
        $template = 'backend.city.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'city',
        ));
    }

    public function update($id, UpdateCityRequest $request){
        if($this->cityService->update($id, $request, $this->language)){
            return redirect()->route('city.index')->with('success','Cập nhật bản ghi thành công');
        }
        return redirect()->route('city.index')->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        $this->authorize('modules', 'city.destroy');
        $config['seo'] = __('messages.city');
        $city = $this->cityRepository->findById($id);
        $template = 'backend.city.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'city',
            'config',
        ));
    }

    public function destroy($id){
        if($this->cityService->destroy($id)){
            return redirect()->route('city.index')->with('success','Xóa bản ghi thành công');
        }
        return redirect()->route('city.index')->with('error','Xóa bản ghi không thành công. Hãy thử lại');
    }

    private function config(){
        return [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/plugins/ckfinder_2/ckfinder.js',
            ]
        ];
    }
}
