<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Models\Users;
use App\Http\Models\Balkondes;
use App\Http\Models\VehicleType;
use App\Http\Models\BalkondesDistance;

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

	public function pilihRute(Request $request) {
		$tourists          = ($request->input('group-tourist')) ? $request->input('group-tourist') : array();
		$tourist_serialize = base64_encode(serialize($tourists));

		$balkondes = Balkondes::all();
		$vehicles  = VehicleType::all();
		$data = array(
			'balkondes'         => $balkondes,
			'vehicles'          => $vehicles,
			'tourists'          => $tourists,
			'tourist_serialize' => $tourist_serialize
		);
		return view('pilih_rute', $data);
	}

	public function pesan (Request $request) {
		$tourist_serialize = $request->input('tourist_data');
		$start             = $request->input('start');
		$route             = $request->input('group-route');
		$last_ride         = $request->input('last_ride');

		$routes           = $this->createRoute($start, $route, $last_ride);
		$tourist_array    = unserialize(base64_decode($tourist_serialize));
		$routes_serialize = base64_encode(serialize($routes));

		$data = array(
			'tourist_serialize' => $tourist_serialize,
			'tourist_array'     => $tourist_array,
			'routes'            => $routes,
			'routes_serialize'  => $routes_serialize

		);

		return view('confirmation_order', $data);
	}

	public function order(Request $request) {
		return $request->all();
	}

	public function createRoute($start, $to, $last_by) {
		$max_index   = count($to) - 1; // get index for destination
		
        $human_route = ""; // this to save route for human readable

        $total_km = 0; // total km
        $price    = 0; // total price

        $input_packages = array();
        // first iteration
        $firstRoute = BalkondesDistance::where('id_balkondes_from', $start)
                                    ->where('id_balkondes_to', $to[0]['to'])
									->first();

        if(!$firstRoute) {
            return array('status' => 'error', 'messages' => ['We can not find your route.'] );
        }

        $singlePrice = VehicleType::where('id_vehicle_type', $to[0]['by'])
                                ->first();

        if(!$singlePrice) {
            return array('status' => 'error', 'messages' => ['We can not find your vehicle.'] );
        }

        $the_start = Balkondes::where('id_balkondes', $start)
                                ->first();

        if(!$the_start) {
            return array('status' => 'error', 'messages' => ['We can not find your Balkondes.'] );
        }

        $human_route .= $the_start->name;

        $tmp = array(
                'id_balkondes_distance' => $firstRoute->id_balkondes_distance,
                'id_balkondes_from'     => $start,
                'id_balkondes_to'       => $to[0]['to'],
                'id_vehicle_type'       => $to[0]['by'],
                'distance'              => $firstRoute->distances,
                'price'                 => $firstRoute->distances * $singlePrice->price_km,
                'by'                    => $singlePrice->vehicle_type
            );

        $total_km += $firstRoute->distances;
        $price    += ($firstRoute->distances * $singlePrice->price_km);

        array_push($input_packages, $tmp);

        foreach ($to as $key => $value) {
            $tmp = array();
            if($key == $max_index) { // last iteration
                $route = BalkondesDistance::where('id_balkondes_from', $to[$key]['to'])
                                    ->where('id_balkondes_to', $start)
                                    ->first();

                if(!$route) {
                    return array('status' => 'error', 'messages' => ['We can not find your route.'] );
                }

                $singlePrice = VehicleType::where('id_vehicle_type', $last_by)
                                        ->first();

                if(!$singlePrice) {
                    return array('status' => 'error', 'messages' => ['We can not find your vehicle.'] );
                }

                $the_to = Balkondes::where('id_balkondes', $to[$key]['to'])
                                ->first();

                if(!$the_to) {
                    return array('status' => 'error', 'messages' => ['We can not find your Balkondes.'] );
                }

                $human_route .= ' - ' . $the_to->name;

                $tmp = array(
                        'id_balkondes_distance' => $route->id_balkondes_distance,
                        'id_balkondes_from'     => $to[$key]['to'],
                        'id_balkondes_to'       => $start,
                        'id_vehicle_type'       => $last_by,
                        'distance'              => $route->distances,
                        'price'                 => $route->distances * $singlePrice->price_km,
                        'by'                    => $singlePrice->vehicle_type
                    );

                $total_km += $route->distances;
                $price    += ($route->distances * $singlePrice->price_km);
            } else { // normal iteration
                $route = BalkondesDistance::where('id_balkondes_from', $to[$key]['to'])
                                    ->where('id_balkondes_to', $to[$key+1]['to'])
                                    ->first();

                if(!$route) {
                    return array('status' => 'error', 'messages' => ['We can not find your route.'] );
                }

                $singlePrice = VehicleType::where('id_vehicle_type', $to[$key+1]['by'])
                                        ->first();

                if(!$singlePrice) {
                    return array('status' => 'error', 'messages' => ['We can not find your vehicle.'] );
                }

                $the_to = Balkondes::where('id_balkondes', $to[$key]['to'])
                                ->first();

                if(!$the_to) {
                    return array('status' => 'error', 'messages' => ['We can not find your Balkondes.'] );
                }

                $human_route .= ' - ' . $the_to->name;

                $tmp = array(
                        'id_balkondes_distance' => $route->id_balkondes_distance,
                        'id_balkondes_from'     => $to[$key]['to'],
                        'id_balkondes_to'       => $to[$key+1]['to'],
                        'id_vehicle_type'       => $to[$key]['by'],
                        'distance'              => $route->distances,
                        'price'                 => $route->distances * $singlePrice->price_km,
                        'by'                    => $singlePrice->vehicle_type
                    );

                $total_km += $route->distances;
                $price    += ($route->distances * $singlePrice->price_km);
            }
            array_push($input_packages, $tmp);
        }

        $human_route .= ' - ' . $the_start->name;

        $exp_human = explode(' - ', $human_route);

        foreach ($input_packages as $key1 => $value1) {
            foreach ($exp_human as $key2 => $value2) {
                if( $key1 == $key2 ) {
                    $tmp_route = $exp_human[$key2] . ' - ' . $exp_human[$key2+1];
                    $input_packages[$key1]['route'] = $tmp_route;
                }
            }
        }

        return array(
                'route'    => $human_route,
                'total_km' => $total_km,
                'price'    => $price,
                'details'  => $input_packages,
            );

    }
}

