<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Models\Users;

use Validator;
use DB;
use Illuminate\Routing\UrlGenerator;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

use Lang;
use Image;
use Auth;

class C_Front extends Controller{

    public function __construct(){
    	$this->controller = app('App\Http\Controllers\Controller');
		date_default_timezone_set('Asia/Jakarta');
    }
	
    public function home(Request $request) {
		return view('front');
	}
}

