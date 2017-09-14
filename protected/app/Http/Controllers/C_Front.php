<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Models\Users;
use App\Http\Models\Balkondes;
use App\Http\Models\VehicleType;
use App\Http\Models\BalkondesDistance;
use App\Http\Models\Transaction;
use App\Http\Models\Tourist;
use App\Http\Models\DriverSchedule;

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
use Carbon\Carbon;

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

		if(isset($routes['status'])) {
			if($routes['status'] == 'error') {
				$messages = implode('. ', $routes['messages']);
				$data = array(
					'messages' => $messages
				);

				return view('pesan', $data);
			}
		}
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
		$tourist_data = $request->input('tourist_data');
		$route_data   = $request->input('route_data');

		$arr_tourist = unserialize(base64_decode($tourist_data));
		$arr_route   = unserialize(base64_decode($route_data));

		// date('Ymd').sprintf('%04d', $id_brand).sprintf('%08d', $transaction['id'])]

		$tourist_count = count($arr_tourist);
		$grand_total   = $arr_route['price'];

		$transaction_data = array(
			'tourist_count' => $tourist_count,
			'grand_total' => $grand_total 
		);

		$transaction_insert = Transaction::create($transaction_data);

		if(!$transaction_insert) {
			$messages = 'Gagal memasukkan data transaksi.';
			$data = array(
				'messages' => $messages
			);

			return view('pesan', $data);

		}

		$transaction_id = $transaction_insert->id_transaction;

		// update receipt
		$receipt_number = 'C' . sprintf('%011d', $transaction_id);
		$transaction_update = array('receipt_number' => $receipt_number);

		$update = Transaction::where('id_transaction', $transaction_id)
							->update($transaction_update);

		if(!$update) {
			$messages = 'Gagal mengupdate transaksi.';
			$data = array(
				'messages' => $messages
			);

			return view('pesan', $data);
		}

		// insert tourist

		$tourists = array();

		foreach($arr_tourist as $tour) {
			$tmp = array();
				 
			$tmp['id_transaction'] = $transaction_id;
			$tmp['name']           = $tour['name'];
			$tmp['email']          = $tour['email'];
			$tmp['mobilephone']    = $tour['phone'];
			$tmp['created_at']     = Carbon::now();
			$tmp['updated_at']     = Carbon::now();

			array_push($tourists, $tmp);
		}

		$insert_tourist = Tourist::insert($tourists);

		if(!$insert_tourist) {
			$messages = 'Gagal memasukkan data turis.';
			$data = array(
				'messages' => $messages
			);

			return view('pesan', $data);
		}

		// insert driver schedule

		$driverSchedule = array();

		foreach($arr_route['details'] as $rute) {
			$temp = array();

			$temp['id_vehicle_type'] = $rute['id_vehicle_type'];
			$temp['id_transaction'] = $transaction_id;
			$temp['id_balkondes_distance'] = $rute['id_balkondes_distance'];
			$temp['created_at']     = Carbon::now();
			$temp['updated_at']     = Carbon::now();

			array_push($driverSchedule, $temp);
		}

		$insert_driver_schedule = DriverSchedule::insert($driverSchedule);

		if(!$insert_driver_schedule) {
			$messages = 'Gagal memasukkan data driver schedule.';
			$data = array(
				'messages' => $messages
			);

			return view('pesan', $data);
		}

		// $messages = 'Berhasil melakukan order.';
		// $data = array(
		// 	'messages' => $messages
		// );

		// return view('pesan', $data);
		return redirect( url('tour/' . $receipt_number) );

	}

	public function createRoute($start, $to, $last_by) {
		$max_index   = count($to) - 1; // get index for destination
		// print_r($to);

		// exit;
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
	
	public function tour(Request $request, $id=null) {
		if($id == null) {
			$messages = 'Halaman tidak valid';
			$data = array(
				'messages' => $messages
			);

			return view('pesan', $data);
		}

		$transaction = Transaction::where('receipt_number', $id)
							->first();

		if( !$transaction )  {
			$messages = 'Kami tidak dapat menemukan transaksi ini.';
			$data = array(
				'messages' => $messages
			);

			return view('pesan', $data);
		}

		$id_transaction = $transaction->id_transaction;
		$total_price = $transaction->grand_total;

		// tourist data
		$tourists = Tourist::where('id_transaction', $id_transaction)
								->get();

		// rute data
		$rute = DriverSchedule::select('balkondesdistances.id_balkondes_from', 'balkondesdistances.id_balkondes_to', 'vehicletypes.id_vehicle_type', 'drivers.name', 'drivers.phone')
							->join('balkondesdistances', 'balkondesdistances.id_balkondes_distance', '=', 'driverschedules.id_balkondes_distance')
							->join('vehicletypes', 'vehicletypes.id_vehicle_type', '=', 'driverschedules.id_vehicle_type')
							->leftJoin('drivers', 'drivers.id_driver', '=', 'driverschedules.id_driver')
							->where('driverschedules.id_transaction', $id_transaction)
							->orderBy('driverschedules.id_driver_schedule', 'asc')
							->get()->toArray();

		if(!$rute) {
			$messages = 'Kami tidak dapat menemukan rute yang dilalui transaksi ini.';
			$data = array(
				'messages' => $messages
			);

			return view('pesan', $data);
		}

		$max_index = count( $rute ) - 1;

		$start     = $rute[0]['id_balkondes_from'];
		$last_ride = $rute[$max_index]['id_vehicle_type'];
		$route = array();

		foreach($rute as $key => $r) {
			if($key < $max_index) {
				$tmp     = array();
				$tmp['to']    = $rute[$key]['id_balkondes_to'];
				$tmp['by']    = $rute[$key]['id_vehicle_type'];
				array_push($route, $tmp);
			}
		}

		$routenya = $this->createRoute($start, $route, $last_ride);

		if(isset($routenya['status'])) {
			if($routenya['status'] == 'error') {
				$messages = implode('. ', $routenya['messages']);
				$data = array(
					'messages' => $messages
				);

				return view('pesan', $data);
			}
		}


		foreach($rute as $key => $val) {
			$routenya['details'][$key]['name']  = $rute[$key]['name'];
			$routenya['details'][$key]['phone'] = $rute[$key]['phone'];
		} 

		$data = array(
			'id'       => $id,
			'tourists' => $tourists,
			'routes'   => $routenya
		);

		return view('order_details', $data);
	}
}

