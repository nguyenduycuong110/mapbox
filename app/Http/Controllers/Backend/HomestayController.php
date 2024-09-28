<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\HomeStayServiceInterface  as HomeStayService;
use App\Repositories\Interfaces\HomeStayRepositoryInterface as HomeStayRepository;
use App\Repositories\Interfaces\ColorRepositoryInterface as ColorRepository;
use App\Repositories\Interfaces\CityRepositoryInterface as CityRepository;
use App\Http\Requests\HomeStay\StoreHomeStayRequest;
use App\Http\Requests\HomeStay\UpdateHomeStayRequest;

class HomeStayController extends Controller
{
    protected $homeStayService;
    protected $homeStayRepository;
    protected $colorRepository;
    protected $cityRepository;

    public function __construct(
        HomeStayService $homeStayService,
        HomeStayRepository $homeStayRepository,
        ColorRepository $colorRepository,
        CityRepository $cityRepository,
    ){
        $this->homeStayService = $homeStayService;
        $this->homeStayRepository = $homeStayRepository;
        $this->colorRepository = $colorRepository;
        $this->cityRepository = $cityRepository;
    }

    public function index(Request $request){
        $this->authorize('modules', 'homestay.index');
        $homeStays = $this->homeStayService->paginate($request);
        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'HomeStay'
        ];
        $config['seo'] = __('messages.homestay');
        $template = 'backend.homestay.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'homeStays'
        ));
    }

    public function create(){
        $this->authorize('modules', 'homestay.create');
        $colors = $this->colorRepository->all();
        $cities = $this->cityRepository->all();
        $config = $this->config();
        $config['seo'] = __('messages.homestay');
        $config['method'] = 'create';
        $template = 'backend.homestay.store';
        return view('backend.dashboard.layout', compact(
            'colors',
            'cities',
            'template',
            'config',
        ));
    }

    public function store(StoreHomeStayRequest $request){
        if($this->homeStayService->create($request, $this->language)){
            return redirect()->route('homestay.index')->with('success','Thêm mới bản ghi thành công');
        }
        return redirect()->route('homestay.index')->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id){
        $this->authorize('modules', 'homestay.edit');
        $colors = $this->colorRepository->all();
        $cities = $this->cityRepository->all();
        $homestay = $this->homeStayRepository->findById($id);
        $config = $this->config();
        $config['seo'] = __('messages.homestay');
        $config['method'] = 'edit';
        $template = 'backend.homestay.store';
        return view('backend.dashboard.layout', compact(
            'colors',
            'cities',
            'template',
            'config',
            'homestay',
        ));
    }

    public function update($id, UpdateHomeStayRequest $request){
        if($this->homeStayService->update($id, $request, $this->language)){
            return redirect()->route('homestay.index')->with('success','Cập nhật bản ghi thành công');
        }
        return redirect()->route('homestay.index')->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        $this->authorize('modules', 'homestay.destroy');
        $config['seo'] = __('messages.homestay');
        $homestay = $this->homeStayRepository->findById($id);
        $template = 'backend.homestay.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'homestay',
            'config',
        ));
    }

    public function destroy($id){
        if($this->homeStayService->destroy($id)){
            return redirect()->route('homestay.index')->with('success','Xóa bản ghi thành công');
        }
        return redirect()->route('homestay.index')->with('error','Xóa bản ghi không thành công. Hãy thử lại');
    }

    private function config(){
        return [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/plugins/ckfinder_2/ckfinder.js',
                'backend/library/finder.js',
            ]
        ];
    }
}
