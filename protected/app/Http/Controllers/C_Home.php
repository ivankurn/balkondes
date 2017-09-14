<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Models\Transaction;
use App\Http\Models\Tourist;
use App\Http\Models\DriverSchedule;
use App\Http\Models\Driver;

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

class C_Home extends Controller{

    public function __construct(){
    	$this->controller = app('App\Http\Controllers\Controller');
		date_default_timezone_set('Asia/Jakarta');
    }
	
    public function pesananBaru(Request $request) {
		Session::set('data',[
			'title'             => 'Kasir',
			'menu_active'       => 'baru'
		]);

		$id_user = Session::set('username', 'Kasir');
		
		$data = Transaction::where('assigned','N')->orderBy('id_transaction','desc')->get()->toArray();
		
		foreach($data as $key => $row){
			$data[$key]['tourist'] = Tourist::where('id_transaction',$row['id_transaction'])->get()->toArray();
			$data[$key]['schedule'] = DriverSchedule::select('driverschedules.*',
															'drivers.*',
															'balkondesdistances.*',
															'vehicletypes.*',
															'balkondes_from.name as balkondes_from_name',
															'balkondes_to.name as balkondes_to_name'
															)
										->leftJoin('vehicletypes','vehicletypes.id_vehicle_type','=','driverschedules.id_vehicle_type')
										->leftJoin('drivers','drivers.id_driver','=','driverschedules.id_driver')
										->leftJoin('balkondesdistances','balkondesdistances.id_balkondes_distance','=','DriverSchedules.id_balkondes_distance')
										->leftJoin('balkondes as balkondes_from','balkondes_from.id_balkondes','=','balkondesdistances.id_balkondes_from')
										->leftJoin('balkondes as balkondes_to','balkondes_to.id_balkondes','=','balkondesdistances.id_balkondes_to')
										->where('driverschedules.id_transaction',$row['id_transaction'])
										->get()
										->toArray();
		}
		$andong = Driver::leftJoin('vehicles','vehicles.id_vehicle','=','drivers.id_vehicle')
						->where('vehicles.id_vehicle_type','1')
						->get()
						->toArray();
		$vw = Driver::leftJoin('vehicles','vehicles.id_vehicle','=','drivers.id_vehicle')
						->where('vehicles.id_vehicle_type','2')
						->get()
						->toArray();
		return view('pesanan-baru', compact('data','andong','vw'));
	}
	
	public function pesananBaruPost(Request $request) {
		$post = $request->except('token');
		$selectQuery = DriverSchedule::where('id_transaction','=',$post['id_transaction'])->get()->toArray();
		foreach($post['id_driver'] as $key => $driver){
			$updateDriver = DriverSchedule::where('id_driver_schedule','=',$selectQuery[$key]['id_driver_schedule'])->update(['id_driver' => $driver]);
		}
		$updateTransaction = Transaction::where('id_transaction','=',$post['id_transaction'])->update(['assigned' => 'Y']);
		
		return redirect('pesanan/selesai');
	}
	
	public function updatePengantaranOnProcess($id_driver_schedule) {
		$updateTransaction = DriverSchedule::where('id_driver_schedule','=',$id_driver_schedule)->update(['status_pengantaran' => 'On Process']);
		return back();
	}
	
	public function updatePengantaranFinished($id_driver_schedule) {
		$updateTransaction = DriverSchedule::where('id_driver_schedule','=',$id_driver_schedule)->update(['status_pengantaran' => 'Finished']);
		return back();
	}
	
	public function pesananHapus($id_transaction) {
		$updateTransaction = Transaction::where('id_transaction','=',$id_transaction)->delete();
		return back();
	}
	
	public function pesananSelesai(Request $request) {
		Session::set('data',[
			'title'             => 'Kasir',
			'menu_active'       => 'selesai'
		]);

		$id_user = Session::set('username', 'Kasir');
		
		$data = Transaction::where('assigned','Y')->orderBy('id_transaction','desc')->get()->toArray();
		
		foreach($data as $key => $row){
			$data[$key]['tourist'] = Tourist::where('id_transaction',$row['id_transaction'])->get()->toArray();
			$data[$key]['schedule'] = DriverSchedule::select('driverschedules.*',
															'drivers.*',
															'balkondesdistances.*',
															'vehicletypes.*',
															'balkondes_from.name as balkondes_from_name',
															'balkondes_to.name as balkondes_to_name'
															)
										->leftJoin('vehicletypes','vehicletypes.id_vehicle_type','=','driverschedules.id_vehicle_type')
										->leftJoin('drivers','drivers.id_driver','=','driverschedules.id_driver')
										->leftJoin('balkondesdistances','balkondesdistances.id_balkondes_distance','=','DriverSchedules.id_balkondes_distance')
										->leftJoin('balkondes as balkondes_from','balkondes_from.id_balkondes','=','balkondesdistances.id_balkondes_from')
										->leftJoin('balkondes as balkondes_to','balkondes_to.id_balkondes','=','balkondesdistances.id_balkondes_to')
										->where('driverschedules.id_transaction',$row['id_transaction'])
										->get()
										->toArray();
		}
		$andong = Driver::leftJoin('vehicles','vehicles.id_vehicle','=','drivers.id_vehicle')
						->where('vehicles.id_vehicle_type','1')
						->get()
						->toArray();
		$vw = Driver::leftJoin('vehicles','vehicles.id_vehicle','=','drivers.id_vehicle')
						->where('vehicles.id_vehicle_type','2')
						->get()
						->toArray();
		// print_r($data);exit;
		return view('pesanan-selesai', compact('data','andong','vw'));
	}
	
	public function driverSchedule(Request $request,$nama) {
		Session::set('data',[
			'title'             => 'Driver '.$nama,
			'menu_active'       => 'baru'
		]);
		
		Session::put('name', $nama);
		
		$driver = Driver::where('name','=',$nama)->get()->toArray();
		if($driver){
			$schedule = DriverSchedule::select('driverschedules.*',
												'transactions.*',
												'drivers.*',
												'balkondesdistances.*',
												'vehicletypes.*',
												'balkondes_from.name as balkondes_from_name',
												'balkondes_to.name as balkondes_to_name'
												)
										->leftJoin('transactions','transactions.id_transaction','=','driverschedules.id_transaction')
										->leftJoin('vehicletypes','vehicletypes.id_vehicle_type','=','driverschedules.id_vehicle_type')
										->leftJoin('drivers','drivers.id_driver','=','driverschedules.id_driver')
										->leftJoin('balkondesdistances','balkondesdistances.id_balkondes_distance','=','DriverSchedules.id_balkondes_distance')
										->leftJoin('balkondes as balkondes_from','balkondes_from.id_balkondes','=','balkondesdistances.id_balkondes_from')
										->leftJoin('balkondes as balkondes_to','balkondes_to.id_balkondes','=','balkondesdistances.id_balkondes_to')
										->where('driverschedules.id_driver',$driver[0]['id_driver'])
										->where('driverschedules.status_pengantaran','!=','Finished')
										->get()
										->toArray();
			foreach($schedule as $key => $row){
				$schedule[$key]['tourist'] = Tourist::where('id_transaction',$row['id_transaction'])->get()->toArray();
			}
			$driver = $driver[0];
			return view('driver', compact('schedule','driver'));
		} else return redirect('/');
	}
	
	public function driverScheduleFinished(Request $request,$nama) {
		Session::set('data',[
			'title'             => 'Driver '.$nama,
			'menu_active'       => 'selesai'
		]);
		
		Session::put('name', $nama);
		
		$driver = Driver::where('name','=',$nama)->get()->toArray();
		if($driver){
			$schedule = DriverSchedule::select('driverschedules.*',
												'transactions.*',
												'drivers.*',
												'balkondesdistances.*',
												'vehicletypes.*',
												'balkondes_from.name as balkondes_from_name',
												'balkondes_to.name as balkondes_to_name'
												)
										->leftJoin('transactions','transactions.id_transaction','=','driverschedules.id_transaction')
										->leftJoin('vehicletypes','vehicletypes.id_vehicle_type','=','driverschedules.id_vehicle_type')
										->leftJoin('drivers','drivers.id_driver','=','driverschedules.id_driver')
										->leftJoin('balkondesdistances','balkondesdistances.id_balkondes_distance','=','DriverSchedules.id_balkondes_distance')
										->leftJoin('balkondes as balkondes_from','balkondes_from.id_balkondes','=','balkondesdistances.id_balkondes_from')
										->leftJoin('balkondes as balkondes_to','balkondes_to.id_balkondes','=','balkondesdistances.id_balkondes_to')
										->where('driverschedules.id_driver',$driver[0]['id_driver'])
										->where('driverschedules.status_pengantaran','=','Finished')
										->get()
										->toArray();
			foreach($schedule as $key => $row){
				$schedule[$key]['tourist'] = Tourist::where('id_transaction',$row['id_transaction'])->get()->toArray();
			}
			$driver = $driver[0];
			return view('driver-finished', compact('schedule','driver'));
		} else return redirect('/');
	}
}

