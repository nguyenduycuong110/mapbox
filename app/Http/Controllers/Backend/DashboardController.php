<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\CustomerServiceInterface as CustomerService;

class DashboardController extends Controller
{
    protected $customerService;
    public function __construct(
        CustomerService $customerService,
    ){
        $this->customerService = $customerService;
    }

    public function index(){
        $customerStatistic = $this->customerService->statistic();
        $startDate = convertDateTime( now(), 'Y-m-d 00:00:00');
        $endDate = convertDateTime( now(), 'Y-m-d 23:59:59');
        $config = $this->config();
        $template = 'backend.dashboard.home.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'customerStatistic',
        ));
    }

    private function config(){
        return [
            'js' => [
                'backend/js/plugins/chartJs/Chart.min.js',
                'backend/library/dashboard.js',
            ]
        ];
    }

}
