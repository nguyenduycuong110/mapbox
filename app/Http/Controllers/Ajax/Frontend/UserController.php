<?php

namespace App\Http\Controllers\Ajax\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendConfirmMail; 
use Illuminate\Support\Facades\Cookie;
Use App\Repositories\Interfaces\HomeStayRepositoryInterface as HomeStayRepository;

class UserController extends Controller
{
    protected $homeStayRepository;

    public function __construct(
        HomeStayRepository $homeStayRepository
    ){
        $this->homeStayRepository = $homeStayRepository;
    }

    public function changeStatus(Request $request){
        $payload = [
            'color_id' => $request->input('color_id')
        ];

        $homestay_id = $request->input('homestay_id');

        $city_id = $request->input('city_id');

        $this->homeStayRepository->update($homestay_id, $payload);

        $temp = $this->homeStayRepository->getHomeStay($homestay_id)->toArray();

        $homestay = $this->homeStayRepository->getAllHomeStay($city_id)->toArray();

        return response()->json(
            [
                'homestay' => $homestay,
                'temp' => $temp
            ]
        );
        
    }

    public function changePrice(Request $request){
        $payload = [
            'price' => $request->input('price')
        ];

        $homestay_id = $request->input('homestay_id');

        $city_id = $request->input('city_id');

        $this->homeStayRepository->update($homestay_id, $payload);

        $temp = $this->homeStayRepository->getHomeStay($homestay_id)->toArray();

        $homestay = $this->homeStayRepository->getAllHomeStay($city_id)->toArray();

        return response()->json(
            [
                'homestay' => $homestay,
                'temp' => $temp
            ]
        );
        
    }

    public function changeGuest(Request $request){
        $payload = [
            'current_guests' => $request->input('current_guests')
        ];

        $homestay_id = $request->input('homestay_id');

        $city_id = $request->input('city_id');

        $this->homeStayRepository->update($homestay_id, $payload);

        $temp = $this->homeStayRepository->getHomeStay($homestay_id)->toArray();

        $homestay = $this->homeStayRepository->getAllHomeStay($city_id)->toArray();

        return response()->json(
            [
                'homestay' => $homestay,
                'temp' => $temp
            ]
        );
        
    }
     

}
