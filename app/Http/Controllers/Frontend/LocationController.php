<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\HomeStayRepositoryInterface as HomeStayRepository;
use App\Repositories\Interfaces\CityRepositoryInterface as CityRepository;
use App\Repositories\Interfaces\ColorRepositoryInterface as ColorRepository;

class LocationController extends FrontendController
{
    protected $language;
    protected $system;
    protected $homeStayRepository;
    protected $cityRepository;
    protected $colorRepository;
    
    public function __construct(
        HomeStayRepository $homeStayRepository,
        CityRepository $cityRepository,
        ColorRepository $colorRepository,
    ){
        $this->homeStayRepository = $homeStayRepository;
        $this->cityRepository = $cityRepository;
        $this->colorRepository = $colorRepository;
        parent::__construct(); 
    }


    public function index($city){

        $city_id = $city->id;

        $city = $this->cityRepository->findById($city_id);

        $list_city = $this->cityRepository->all()->toArray();

        $homeStay = $this->homeStayRepository->getAllHomeStay($city_id)->toArray();

        $colors = $this->colorRepository->all()->toArray();

        $system = $this->system;

        $seo = [
            'meta_title' => '',
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => '',
        ];

        $template = 'frontend.map.index';

        return view($template , compact(
            'seo',
            'system',
            'list_city',
            'city',
            'homeStay',
            'colors'
        ));
        
    }




}
