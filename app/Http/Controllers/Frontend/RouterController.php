<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterRepository;
use App\Repositories\Interfaces\TagRepositoryInterface as TagRepository;
use App\Models\Event;

class RouterController extends FrontendController
{
    protected $language;
    protected $routerRepository;
    protected $tagRepository;
    protected $router;

    public function __construct(
        RouterRepository $routerRepository,
        TagRepository $tagRepository,
    ){
        $this->routerRepository = $routerRepository;
        $this->tagRepository = $tagRepository;
        parent::__construct(); 
    }


    public function index(string $canonical = '', Request $request){
        $this->getRouter($canonical);
        if(!is_null($this->router) && !empty($this->router)){
            $method = 'index';
            echo app($this->router->controllers)->{$method}($this->router->module_id, $request);
        }else{
            abort(404);
        }
    }

    public function page(string $canonical = '', $page = 1, Request $request){

        $this->getRouter($canonical);

        $page = (!isset($page)) ? 1 : $page;

        if(!is_null($this->router) && !empty($this->router)){
            $method = 'index';
            echo app($this->router->controllers)->{$method}($this->router->module_id, $request, $page);
        }else{
            abort(404);
        }
    }

    public function tag(string $canonical = ''){

        $tag = $this->tagRepository->findByCondition([
            ['canonical','=', $canonical]
        ]);

        $tag_id = $tag->id;

        $language_id = $this->language;

        $posts = $this->tagRepository->getPostByTag($tag_id, $language_id);

        if(!is_null($posts) && !empty($posts)){

            return app(PostController::class)->tag($posts);

        }else{

            abort(404);

        }
        
        
    }

    public function event($id = 0){
        
        $detailEvent = Event::where('id', $id)->get();

        if(!is_null($detailEvent) && !empty($detailEvent)){

            return app(PostController::class)->event($detailEvent);

        }else{

            abort(404);

        }
    }

    public function getRouter($canonical){
        $this->router = $this->routerRepository->findByCondition(
            [
                ['canonical', '=', $canonical],
                ['language_id', '=', $this->language]
            ]
        );
    }
  


}
