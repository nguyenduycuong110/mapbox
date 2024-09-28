<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\ColorServiceInterface  as ColorService;
use App\Repositories\Interfaces\ColorRepositoryInterface as ColorRepository;
use App\Http\Requests\Color\StoreColorRequest;
use App\Http\Requests\Color\UpdateColorRequest;

class ColorController extends Controller
{
    protected $colorService;
    protected $colorRepository;

    public function __construct(
        ColorService $colorService,
        ColorRepository $colorRepository,
    ){
        $this->colorService = $colorService;
        $this->colorRepository = $colorRepository;
    }

    public function index(Request $request){
        $this->authorize('modules', 'color.index');
        $colors = $this->colorService->paginate($request);
        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/library/color.js',
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'color'
        ];
        $config['seo'] = __('messages.color');
        $template = 'backend.color.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'colors'
        ));
    }

    public function create(){
        $this->authorize('modules', 'color.create');
        $config = $this->config();
        $config['seo'] = __('messages.color');
        $config['method'] = 'create';
        $template = 'backend.color.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
        ));
    }

    public function store(StoreColorRequest $request){
        if($this->colorService->create($request, $this->language)){
            return redirect()->route('color.index')->with('success','Thêm mới bản ghi thành công');
        }
        return redirect()->route('color.index')->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id){
        $this->authorize('modules', 'color.edit');
        $color = $this->colorRepository->findById($id);
        $config = $this->config();
        $config['seo'] = __('messages.color');
        $config['method'] = 'edit';
        $template = 'backend.color.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'color',
        ));
    }

    public function update($id, UpdateColorRequest $request){
        if($this->colorService->update($id, $request, $this->language)){
            return redirect()->route('color.index')->with('success','Cập nhật bản ghi thành công');
        }
        return redirect()->route('color.index')->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        $this->authorize('modules', 'color.destroy');
        $config['seo'] = __('messages.color');
        $color = $this->colorRepository->findById($id);
        $template = 'backend.color.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'color',
            'config',
        ));
    }

    public function destroy($id){
        if($this->colorService->destroy($id)){
            return redirect()->route('color.index')->with('success','Xóa bản ghi thành công');
        }
        return redirect()->route('color.index')->with('error','Xóa bản ghi không thành công. Hãy thử lại');
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
