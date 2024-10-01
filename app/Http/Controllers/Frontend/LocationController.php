<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\HomeStayRepositoryInterface as HomeStayRepository;
use App\Repositories\Interfaces\CityRepositoryInterface as CityRepository;

class LocationController extends FrontendController
{
    protected $language;
    protected $system;
    protected $homeStayRepository;
    protected $cityRepository;
    
    public function __construct(
        HomeStayRepository $homeStayRepository,
        CityRepository $cityRepository,
    ){
        $this->homeStayRepository = $homeStayRepository;
        $this->cityRepository = $cityRepository;
        parent::__construct(); 
    }


    public function index($city){

        $city_id = $city->id;

        $city = $this->cityRepository->findById($city_id);

        $list_city = $this->cityRepository->all()->toArray();

        $homeStay = $this->homeStayRepository->getAllHomeStay($city_id)->toArray();

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
            'homeStay'
        ));
        
    }




}
