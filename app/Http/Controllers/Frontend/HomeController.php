<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\SlideRepositoryInterface  as SlideRepository;
use App\Repositories\Interfaces\SystemRepositoryInterface  as SystemRepository;
use App\Repositories\Interfaces\PostRepositoryInterface  as PostRepository;
use App\Services\Interfaces\WidgetServiceInterface  as WidgetService;
use App\Services\Interfaces\SlideServiceInterface  as SlideService;
use App\Enums\SlideEnum;

class HomeController extends FrontendController
{
    protected $language;
    protected $slideRepository;
    protected $postRepository;
    protected $systemRepository;
    protected $widgetService;
    protected $slideService;
    protected $system;

    public function __construct(
        PostRepository $postRepository,
        SlideRepository $slideRepository,
        WidgetService $widgetService,
        SlideService $slideService,
        SystemRepository $systemRepository,
    ){
        $this->postRepository = $postRepository;
        $this->slideRepository = $slideRepository;
        $this->widgetService = $widgetService;
        $this->slideService = $slideService;
        $this->systemRepository = $systemRepository;

        parent::__construct(
           $systemRepository,
        ); 
    }


    public function index(){

        $config = $this->config();

        $widgets = $this->widgetService->getWidget([
            
        ], $this->language);

        $slides = $this->slideService->getSlide(
            [SlideEnum::BANNER, SlideEnum::MAIN, SlideEnum::CUSTOMER, SlideEnum::PARTNER ,  'banner'], $this->language);

        $system = $this->system;
        
        $seo = [
            'meta_title' => $this->system['seo_meta_title'],
            'meta_keyword' => $this->system['seo_meta_keyword'],
            'meta_description' => $this->system['seo_meta_description'],
            'meta_image' => $this->system['seo_meta_images'],
            'canonical' => config('app.url'),
        ];

        $language = $this->language;

        return view('frontend.homepage.home.index', compact(
            'config',
            'slides',
            'widgets',
            'seo',
            'system',
            'language',
        ));
    }

    public function ckfinder(){
        return view('frontend.homepage.home.ckfinder');
    }

  

    private function config(){
        return [
            'language' => $this->language,
            'css' => [
                'frontend/resources/plugins/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css',
                'frontend/resources/plugins/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css'
            ],
            'js' => [
                'frontend/resources/plugins/OwlCarousel2-2.3.4/dist/owl.carousel.min.js',
                'https://getuikit.com/v2/src/js/components/sticky.js',
            ]
        ];
    }

}
