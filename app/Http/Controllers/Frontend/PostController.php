<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;
use App\Services\Interfaces\PostCatalogueServiceInterface as PostCatalogueService;
use App\Services\Interfaces\PostServiceInterface as PostService;
use App\Repositories\Interfaces\PostRepositoryInterface as PostRepository;
use App\Models\System;

class postController extends FrontendController
{
    protected $language;
    protected $system;
    protected $postCatalogueRepository;
    protected $postCatalogueService;
    protected $postService;
    protected $postRepository;

    public function __construct(
        PostCatalogueRepository $postCatalogueRepository,
        PostCatalogueService $postCatalogueService,
        PostService $postService,
        PostRepository $postRepository,
    ){
        $this->postCatalogueRepository = $postCatalogueRepository;
        $this->postCatalogueService = $postCatalogueService;
        $this->postService = $postService;
        $this->postRepository = $postRepository;
        parent::__construct(); 
    }


    public function index($id, $request){

        $language = $this->language;

        $post = $this->postRepository->getPostById($id, $this->language, config('apps.general.defaultPublish'));

        $tag_post = null;

        if(is_null($tag_post)){
            $tag_post = $post->tag_post;
        }

        if(is_null($post)){
            abort(404);
        }

        $postCatalogue = $this->postCatalogueRepository->getPostCatalogueById($post->post_catalogue_id, $this->language);

        $breadcrumb = $this->postCatalogueRepository->breadcrumb($postCatalogue, $this->language);

        $asidePost = $this->postService->paginate(
            $request, 
            $this->language, 
            $postCatalogue, 
            1,
            ['path' => $postCatalogue->canonical],
        );

        /* ------------------- */

        $config = $this->config();

        $system = $this->system;

        $seo = seo($post);

        if($post->type == 2){

            $template = 'frontend.post.post.indexPremium';

        }else{

            $template = 'frontend.post.post.index';
            
        }

        return view($template , compact(
            'config',
            'seo',
            'system',
            'breadcrumb',
            'postCatalogue',
            'post',
            'asidePost',
            'tag_post'
        ));
        
    }

    public function tag($posts){

        $listPost = $posts;

        $system = $this->system;

        $template = 'frontend.tag.index';

        $config = $this->config();

        $seo = [
            'meta_title' => '',
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => '',
        ];

        return view($template , compact(
            'config',
            'system',
            'seo',
            'listPost'
        ));
    }

    public function event($detailEvent){

        $event = $detailEvent;

        $system = $this->system;

        $template = 'frontend.event.index';

        $config = $this->config();

        $seo = [
            'meta_title' => '',
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => '',
        ];

        return view($template , compact(
            'config',
            'system',
            'seo',
            'event'
        ));
    }
    
    

    private function config(){
        return [
            'language' => $this->language,
        ];
    }

}
