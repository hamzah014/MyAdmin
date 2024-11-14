<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Services\DropdownService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller{

    public function index(){

        $dropdownService = new DropdownService();
		$user = Auth::user();

        return view('dashboard.index',
        compact(
            'dropdownService'
        ));

    }



}
