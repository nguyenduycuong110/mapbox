<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\TagServiceInterface  as TagService;
use App\Repositories\Interfaces\TagRepositoryInterface as TagRepository;
use App\Http\Requests\Tag\StoreTagRequest;
use App\Http\Requests\Tag\UpdateTagRequest;

class TagController extends Controller
{
    protected $tagService;
    protected $tagRepository;

    public function __construct(
        TagService $tagService,
        TagRepository $tagRepository,
    ){
        $this->tagService = $tagService;
        $this->tagRepository = $tagRepository;
    }

    public function index(Request $request){
        $this->authorize('modules', 'tag.index');
        $tags = $this->tagService->paginate($request);
        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/library/tag.js',
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'tag'
        ];
        $config['seo'] = __('messages.tag');
        $template = 'backend.tag.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'tags'
        ));
    }

    public function create(){
        $this->authorize('modules', 'tag.create');
        $config = $this->config();
        $config['seo'] = __('messages.tag');
        $config['method'] = 'create';
        $template = 'backend.tag.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
        ));
    }

    public function store(StoreTagRequest $request){
        if($this->tagService->create($request, $this->language)){
            return redirect()->route('tag.index')->with('success','Thêm mới bản ghi thành công');
        }
        return redirect()->route('tag.index')->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id){
        $this->authorize('modules', 'tag.edit');
        $tag = $this->tagRepository->findById($id);
        $config = $this->config();
        $config['seo'] = __('messages.tag');
        $config['method'] = 'edit';
        $template = 'backend.tag.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'tag',
        ));
    }

    public function update($id, UpdateTagRequest $request){
        if($this->tagService->update($id, $request, $this->language)){
            return redirect()->route('tag.index')->with('success','Cập nhật bản ghi thành công');
        }
        return redirect()->route('tag.index')->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        $this->authorize('modules', 'tag.destroy');
        $config['seo'] = __('messages.tag');
        $tag = $this->tagRepository->findById($id);
        $template = 'backend.tag.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'tag',
            'config',
        ));
    }

    public function destroy($id){
        if($this->tagService->destroy($id)){
            return redirect()->route('tag.index')->with('success','Xóa bản ghi thành công');
        }
        return redirect()->route('tag.index')->with('error','Xóa bản ghi không thành công. Hãy thử lại');
    }

    private function config(){
        return [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/plugins/ckfinder_2/ckfinder.js',
                'backend/library/seo.js',
            ]
        ];
    }
}
