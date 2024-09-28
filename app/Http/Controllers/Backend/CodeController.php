<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\CodeServiceInterface  as CodeService;
use App\Repositories\Interfaces\CodeRepositoryInterface as CodeRepository;
use App\Http\Requests\Code\StoreCodeRequest;
use App\Http\Requests\Code\UpdateCodeRequest;

class CodeController extends Controller
{
    protected $codeService;
    protected $codeRepository;

    public function __construct(
        CodeService $codeService,
        CodeRepository $codeRepository,
    ){
        $this->codeService = $codeService;
        $this->codeRepository = $codeRepository;
    }

    public function index(Request $request){
        $this->authorize('modules', 'code.index');
        $codes = $this->codeService->paginate($request);
      
        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/library/code.js',
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'code'
        ];
        $config['seo'] = __('messages.code');
        $template = 'backend.code.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'codes'
        ));
    }

    public function create(){
        $this->authorize('modules', 'code.create');
        $config = $this->config();
        $config['seo'] = __('messages.code');
        $config['method'] = 'create';
        $template = 'backend.code.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
        ));
    }

    public function store(StoreCodeRequest $request){
        if($this->codeService->create($request, $this->language)){
            return redirect()->route('code.index')->with('success','Thêm mới bản ghi thành công');
        }
        return redirect()->route('code.index')->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id){
        $this->authorize('modules', 'code.edit');
        $code = $this->codeRepository->findById($id);
        $config = $this->config();
        $config['seo'] = __('messages.code');
        $config['method'] = 'edit';
        $template = 'backend.code.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'code',
        ));
    }

    public function update($id, UpdatecodeRequest $request){
        if($this->codeService->update($id, $request, $this->language)){
            return redirect()->route('code.index')->with('success','Cập nhật bản ghi thành công');
        }
        return redirect()->route('code.index')->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        $this->authorize('modules', 'code.destroy');
        $config['seo'] = __('messages.code');
        $code = $this->codeRepository->findById($id);
        $template = 'backend.code.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'code',
            'config',
        ));
    }

    public function destroy($id){
        if($this->codeService->destroy($id)){
            return redirect()->route('code.index')->with('success','Xóa bản ghi thành công');
        }
        return redirect()->route('code.index')->with('error','Xóa bản ghi không thành công. Hãy thử lại');
    }

    private function config(){
        return [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/plugins/ckfinder_2/ckfinder.js',
                'backend/library/code.js',
                
            ]
        ];
    }
}
