<?php
namespace App\Lib;

use App\Http\Requests;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Http\Models\Fitur;
use App\Http\Models\LogAktivitas;
use Image;
class MyHelper{

  public static function checkGet($data){
    if($data && !empty($data)) return ['status' => 'success', 'result' => $data];
    else if(empty($data)) ['status' => 'fail', 'messages' => ['empty']];
    else return ['status' => 'fail', 'messages' => ['failed to retrieve data']];
  }

  // $messages = false ---> return cuma id
  // $messages = true ---> return seluruh data
  public static function checkCreate($data, $returnAll = false){
    if($data){
      if(!$returnAll) return ['status' => 'success', 'messages' => ['id' => $data->id]];
      else return ['status' => 'success', 'result' => $data];
    }
    else return ['status' => 'fail', 'result' => 'failed to insert data.'];
  }

  public static function checkUpdate($status){
    if($status) return ['status' => 'success'];
    else return ['status' => 'fail','messages' => ['failed to update data']];
  }

  public static function checkDelete($status){
    if($status) return ['status' => 'success'];
    else return ['status' => 'fail', 'messages' => ['failed to delete data']];
  }

  public static function convertDate($date){
    $date = explode('/', $date);
    $date = $date[2].'-'.$date[1].'-'.$date[0];
    $date = date('Y-m-d', strtotime($date));
    return $date;
  }
  
  public static function custom_number_format($n) {

    //return number_format($n);

    // first strip any formatting;
    $n = (0+str_replace(",","",$n));

    // is this a number?
    if(!is_numeric($n)) return false;

    // now filter it;
    if($n>1000000000000) return round(($n/1000000000000),1).' T';
    else if($n>1000000000) return round(($n/1000000000),1).' M';
    else if($n>1000000) return round(($n/1000000),1).' Jt';
    else if($n>1000) return round(($n/1000),1).' Rb';

    return number_format($n);
  }

	public static function hasAccess($akses){
		$fitur = explode(",", Session::get('fitur'));
		$akses = explode(",", $akses);
		$listfitur = array();
		foreach($fitur as $row){
			foreach($akses as $aksese){
				if($row == $aksese)
					return true;
			}
		}
		return false;
	}
	
	public static function LogAktivitas($modul, $action, $request, $id_ref = null){
		$ipAddress = $_SERVER['REMOTE_ADDR'];
		if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
			$ipAddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
		}
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		
		$data 				= array();
		if(Session::has('id_user'))
		$data['id_user'] 	= Session::get('id_user');
		$data['modul'] 		= $modul;
		$data['action'] 	= $action;
		$data['request'] 	= json_encode($request);
		if($id_ref != null)
		$data['id_referensi'] = $id_ref;
		$data['ip_address'] = $_SERVER['REMOTE_ADDR'];
		$data['useragent']	= $_SERVER['HTTP_USER_AGENT'];
		
		$query = LogAktivitas::create($data);
		if($query)
			return true;
		else
			return false;
		
	}
	
	public static function inArrayR($needle, $haystack, $strict = false) {
		foreach ($haystack as $item) {
			if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
				return true;
			}
		}
		return false;
	}
	
	public static function listFitur() {
		$fitur = explode(",", Session::get('fitur'));
		$fiturnya = Fitur::get()->toArray();
		$x = 0;
		foreach($fiturnya as $row){
			foreach($fitur as $aaa){
				$fiturnya[$x]['setting'] = '0';
				if($row['id_fitur'] == $aaa){
					$fiturnya[$x]['setting'] = '1';
					break;
				}
			}
			$x++;
		}
		return $fiturnya;
	}
	
	public static function listToko(){
		if(empty(Session::get('toko')))
			return false;
		
		$a = explode(',',Session::get('toko'));
		$list = array();
		foreach($a as $row){
			$b = explode('|',$row);
			array_push($list, array('id_toko' => $b['0'], 'nama_toko' => $b['1'], 'kota_toko' => $b['2']));
		}
		return $list;
	}
	
	public static function checkExtensionImageBase64($imgdata){
		$f = finfo_open();
		$imagetype = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);

		if(empty($imagetype)) return '.jpg';
		switch($imagetype)
		{
          case 'image/bmp': return '.bmp';
          case 'image/cis-cod': return '.cod';
          case 'image/gif': return '.gif';
          case 'image/ief': return '.ief';
          case 'image/jpeg': return '.jpg';
          case 'image/pipeg': return '.jfif';
          case 'image/tiff': return '.tif';
          case 'image/x-cmu-raster': return '.ras';
          case 'image/x-cmx': return '.cmx';
          case 'image/x-icon': return '.ico';
          case 'image/x-portable-anymap': return '.pnm';
          case 'image/x-portable-bitmap': return '.pbm';
          case 'image/x-portable-graymap': return '.pgm';
          case 'image/x-portable-pixmap': return '.ppm';
          case 'image/x-rgb': return '.rgb';
          case 'image/x-xbitmap': return '.xbm';
          case 'image/x-xpixmap': return '.xpm';
          case 'image/x-xwindowdump': return '.xwd';
          case 'image/png': return '.png';
          case 'image/x-jps': return '.jps';
          case 'image/x-freehand': return '.fh';
          default: return false;
		}
	}
	public static function encodeImage($image){
		$encoded = base64_encode(fread(fopen($image, "r"), filesize($image)));
		return $encoded;
	}
  
	public static function uploadPhotoStrict($foto, $path, $width=1000, $height=1000, $name=null) {
	// kalo ada foto1
    $decoded = base64_decode($foto);

    // cek extension
    $ext = MyHelper::checkExtensionImageBase64($decoded);

    // set picture name
	if($name != null)
		$pictName = $name.$ext;
	else
		$pictName = mt_rand(0, 1000).''.time().''.$ext;
	
    // path
    $upload = $path.$pictName;

    $img = Image::make($decoded);

    $imgwidth = $img->width();
    $imgheight = $img->height();

    /* if($width > 1000){
        $img->resize(1000, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
    } */
	
	if($imgwidth < $imgheight){
		//potrait
		if($imgwidth < $width){
			$img->resize($width, null, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			});
		}
		
		if($imgwidth > $width){
			$img->resize($width, null, function ($constraint) {
				$constraint->aspectRatio();
			});
		}
	} else {
		//landscape
		if($imgheight < $height){
			$img->resize(null, $height, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			});
		}
		if($imgheight > $height){
			$img->resize(null, $height, function ($constraint) {
				$constraint->aspectRatio();
			});
		}
		
	}
	/* if($imgwidth < $width){
		$img->resize($width, null, function ($constraint) {
			$constraint->aspectRatio();
			$constraint->upsize();
		});
		$imgwidth = $img->width();
		$imgheight = $img->height();
	}

	if($imgwidth > $width){
		$img->resize($width, null, function ($constraint) {
			$constraint->aspectRatio();
		});
		$imgwidth = $img->width();
		$imgheight = $img->height();
	}

	if($imgheight < $height){
		$img->resize(null, $height, function ($constraint) {
			$constraint->aspectRatio();
			$constraint->upsize();
		});
	} */
	
    $img->crop($width, $height);
	
	

    if ($img->save($upload)) {
        $result = [
          'status' => 'success',
          'filename'  => $pictName,
          'path'  => $upload
        ];
    }
    else {
      $result = [
        'status' => 'fail'
      ];
    }  

    return $result;
  }
  
	public static function listKota(){
		return array(
        'Aceh' => array(
                'Kabupaten Aceh Barat',
                'Kabupaten Aceh Barat Daya',
                'Kabupaten Aceh Besar',
                'Kabupaten Aceh Jaya',
                'Kabupaten Aceh Selatan',
                'Kabupaten Aceh Singkil',
                'Kabupaten Aceh Tamiang',
                'Kabupaten Aceh Tengah',
                'Kabupaten Aceh Tenggara',
                'Kabupaten Aceh Timur',
                'Kabupaten Aceh Utara',
                'Kabupaten Bener Meriah',
                'Kabupaten Bireuen',
                'Kabupaten Gayo Lues',
                'Kabupaten Nagan Raya',
                'Kabupaten Pidie',
                'Kabupaten Pidie Jaya',
                'Kabupaten Simeulue',
                'Kota Banda Aceh',
                'Kota Langsa',
                'Kota Lhokseumawe',
                'Kota Sabang',
                'Kota Subulussalam',
                ),
        'Bali' => array(
                'Kabupaten Badung',
                'Kabupaten Bangil',
                'Kabupaten Buleleng',
                'Kabupaten Gianyar',
                'Kabupaten Jembrana',
                'Kabupaten Karangasem',
                'Kabupaten Klungkung',
                'Kabupaten Tabanan',
                'Kota Denpasar',
                ),
        'Banten' => array(
                'Kabupaten Lebak',
                'Kabupaten Pandeglang',
                'Kabupaten Serang',
                'Kabupaten Tangerang',
                'Kota Cilegon',
                'Kota Serang',
                'Kota Tangerang',
                'Kota Tangerang selatan',
                ),
        'Bengkulu' => array(
                'Kabupaten Bengkulu Selatan',
                'Kabupaten Bemgkulu Tengah',
                'Kabupaten Bengkulu Utara',
                'Kabupaten Kaur',
                'Kabupaten kapahiang',
                'Kabupaten Lebong',
                'Kabupaten Mukomuko',
                'Kabupaten Rejang Lebong',
                'Kabupaten seluma',
                'Kota Bengkulu',
                ),
        'D.I Yogyakarta' => array(
                'Kabupaten Bantul',
                'Kabupaten Gunung kildul',
                'Kabupaten Kulon Progo',
                'Kabupaten Sleman',
                'Kota Yogyakarta',
                ),
        'D.K.I Jakarta' => array(
                'Kabupaten Kepulauan Seribu',
                'Kota Jakarta Barat',
                'Kota Jakarta Pusat',
                'Kota Jakarta Selatan',
                'Kota Jakarta Timur',
                'Kota Jakarta Utara',
                ),
        'Gorontalo' => array(
                'Kabupaten Boalemo',
                'Kabupaten Bone Bolango',
                'Kabupaten Gorontalo',
                'Kabupaten gorontalo Utara',
                'Kabupaten Pahuwato',
                'Kota Gorontalo',
                ),
        'Jambi' => array(
                'Kabupaten Batanghari',
                'Kabupaten Bungo',
                'Kabupaten Kerinci',
                'Kabupaten Merangin',
                'Kabupaten Muaro Jambi',
                'Kabupaten Sarolangun',
                'Kabupaten Tanjung Jabung Barat',
                'Kabupaten Tanjung Jabung Timur',
                'Kabupaten Tebo',
                'Kota Jambi',
                'Kota Sungai Penuh',
                ),
        'Jawa Barat' => array(
                'Kabupaten Bandung',
                'Kabupaten Bandung Barat',
                'Kabupaten Bekasi',
                'Kabupaten Bogor',
                'Kabupaten Ciamis',
                'Kabupaten Cianjur',
                'Kabupaten Cirebon',
                'Kabupaten Garut',
                'Kabupaten Indramayu',
                'Kabupaten Karawang',
                'Kabupaten Kuningan',
                'Kabupaten Majalengka',
                'Kabupaten Pangandaran',
                'Kabupaten Purwakarta',
                'Kabupaten Subang',
                'Kabupaten Sukabumi',
                'Kabupaten Sumedang',
                'Kabupaten Tasikmalaya',
                'Kota Bandung',
                'Kota Banjar',
                'Kota Bekasi',
                'Kota Bogor',
                'Kota Cimahi',
                'Kota Cirebon',
                'Kota Depok',
                'Kota Sukabumi',
                'Kota Tasikmalaya',
                ),
        'Jawa Tengah' => array(
                'Kabupaten Banjarnegara',
                'Kabupaten Banyumas',
                'Kabupaten Batang',
                'Kabupaten Blora',
                'Kabupaten Boyolali',
                'Kabupaten Brebes',
                'Kabupaten Cilacap',
                'Kabupaten Demak',
                'Kabupaten Grobogan',
                'Kabupaten Jepara',
                'Kabupaten Karanganyar',
                'Kabupaten Kebumen',
                'Kabupaten Kendal',
                'Kabupaten Klaten',
                'Kabupaten Kudus',
                'Kabupaten Magelang',
                'Kabupaten Pati',
                'Kabupaten Pekalongan',
                'Kabupaten Pemalang',
                'Kabupaten Purbalingga',
                'Kabupaten Purworejo',
                'Kabupaten Rembang',
                'Kabupaten Semarang',
                'Kabupaten Sragen',
                'Kabupaten Sukoharjo',
                'Kabupaten Tegal',
                'Kabupaten Temanggung',
                'Kabupaten Wonogiri',
                'Kabupaten Wonosobo',
                'Kota Magelang',
                'Kota Pekalongan',
                'Kota Salatiga',
                'Kota Semarang',
                'Kota Surakarta',
                'Kota Tegal',
                ),
        'Jawa Timur' => array(
                'Kabupaten Bangkalan',
                'Kabupaten Banyuwangi',
                'Kabupaten Blitar',
                'Kabupaten Bojonegoro',
                'Kabupaten Bondowoso',
                'Kabupaten Gresik',
                'Kabupaten Jember',
                'Kabupaten Jombang',
                'Kabupaten Kediri',
                'Kabupaten Lamongan',
                'Kabupaten Lumajang',
                'Kabupaten Madiun',
                'Kabupaten Magetan',
                'Kabupaten Malang',
                'Kabupaten Mojokerto',
                'Kabupaten Nganjuk',
                'Kabupaten Ngawi',
                'Kabupaten Pacitan',
                'Kabupaten Pamekasan',
                'Kabupaten Pasuruan',
                'Kabupaten Ponorogo',
                'Kabupaten Probolinggo',
                'Kabupaten Sampang',
                'Kabupaten Sidoarjo',
                'Kabupaten Situbondo',
                'Kabupaten Sumenep',
                'Kabupaten Trenggalek',
                'Kabupaten Tuban',
                'Kabupaten Tulungagung',
                'Kota Batu',
                'Kota Blitar',
                'Kota Kediri',
                'Kota Madiun',
                'Kota Malang',
                'Kota Mojokerto',
                'Kota Pasuruan',
                'Kota Probolinggo',
                'Kota Surabaya',
                ),
        'Kalimantan Barat' => array(
                'Kabupaten Bengkayang',
                'Kabupaten Kapuas Hulu',
                'Kabupaten Kayong Utara',
                'Kabupaten Ketapang',
                'Kabupaten Kubu Raya',
                'Kabupaten Landak',
                'Kabupaten Melawi',
                'Kabupaten Pontianak',
                'Kabupaten Sambas',
                'Kabupaten Sanggau',
                'Kabupaten Sekadau',
                'Kabupaten Sintang',
                'Kota Pontianak',
                'Kota Singkawang',
                ),
        'Kalimantan Selatan' => array(
                'Kabupaten Balangan',
                'Kabupaten Banjar',
                'Kabupaten Barito Kuala',
                'Kabupaten Hulu Sungai Selatan',
                'Kabupaten Hulu Sungai Tengah',
                'Kabupaten Hulu Sungai Utara',
                'Kabupaten Kotabaru',
                'Kabupaten Tabalong',
                'Kabupaten Tanah Bumbu',
                'Kabupaten Tanah Laut',
                'Kabupaten Tapin',
                'Kota Banjarbaru',
                'Kota Banjarmasin',
                ),
        'Kalimantan Tengah' => array(
                'Kabupaten Barito Selatan',
                'Kabupaten Barito Timur',
                'Kabupaten Barito Utara',
                'Kabupaten Gunung Mas',
                'Kabupaten Kapuas',
                'Kabupaten Katingan',
                'Kabupaten Kotawaringin Barat',
                'Kabupaten Kotawaringin Timur',
                'Kabupaten Lamandau',
                'Kabupaten Murung Raya',
                'Kabupaten Pulang Pisau',
                'Kabupaten Sukamara',
                'Kabupaten Seruyan',
                'Kota Palangka Raya',
                ),
        'Kalimantan Timur' => array(
                'Kabupaten Berau',
                'Kabupaten Kutai Barat',
                'Kabupaten Kutai Kartanegara',
                'Kabupaten Kutai Timur',
                'Kabupaten Paser',
                'Kabupaten Penajam Paser Utara',
                'Kabupaten Mahakam Ulu',
                'Kota Balikpapan',
                'Kota Bontang',
                'Kota Samarinda',
                ),
        'Kalimantan Utara' => array(
                'Kabupaten Bulungan',
                'Kabupaten Malinau',
                'Kabupaten Nunukan',
                'Kabupaten Tana Tidung',
                'Kota Tarakan',
                ),
        'Kepulauan Bangka Belitung' => array(
                'Kabupaten Bangka',
                'Kabupaten Bangka Barat',
                'Kabupaten Bangka Selatan',
                'Kabupaten Bangka Tengah',
                'Kabupaten Belitung',
                'Kabupaten Belitung Timur',
                'Kota Pangkal Pinang',
                ),
        'Kepulauan Riau' => array(
                'Kabupaten Bintan',
                'Kabupaten Karimun',
                'Kabupaten Kepulauan Anambas',
                'Kabupaten Lingga',
                'Kabupaten Natuna',
                'Kota Batam',
                'Kota Tanjung Pinang',
                ),
        'Lampung' => array(
                'Kabupaten Lampung Barat',
                'Kabupaten Lampung Selatan',
                'Kabupaten Lampung Tengah',
                'Kabupaten Lampung Timur',
                'Kabupaten Lampung Utara',
                'Kabupaten Mesuji',
                'Kabupaten Pesawaran',
                'Kabupaten Pringsewu',
                'Kabupaten Tanggamus',
                'Kabupaten Tulang Bawang',
                'Kabupaten Tulang Bawang Barat',
                'Kabupaten Way Kanan',
                'Kabupaten Pesisir Barat',
                'Kota Bandar Lampung',
                'Kota Kotabumi',
                'Kota Liwa',
                'Kota Metro',
                ),
        'Maluku' => array(
                'Kabupaten Buru',
                'Kabupaten Buru Selatan',
                'Kabupaten Kepulauan Aru',
                'Kabupaten Maluku Barat Daya',
                'Kabupaten Maluku Tengah',
                'Kabupaten Maluku Tenggara',
                'Kabupaten Maluku Tenggara Barat',
                'Kabupaten Seram Bagian Barat',
                'Kabupaten Seram Bagian Timur',
                'Kota Ambon',
                'Kota Tual',
                ),
        'Maluku Utara' => array(
                'Kabupaten Halmahera Barat',
                'Kabupaten Halmahera Tengah',
                'Kabupaten Halmahera Utara',
                'Kabupaten Halmahera Selatan',
                'Kabupaten Halmahera Timur',
                'Kabupaten Kepulauan Sula',
                'Kabupaten Pulau Morotai',
                'Kabupaten Pulau Taliabu',
                'Kota Ternate',
                'Kota Tidore Kepulauan',
                ),
        'Nusa Tenggara Barat' => array(
                'Kabupaten Bima',
                'Kabupaten Dompu',
                'Kabupaten Lombok Barat',
                'Kabupaten Lombok Tengah',
                'Kabupaten Lombok Timur',
                'Kabupaten Lombok Utara',
                'Kabupaten Sumbawa',
                'Kabupaten Sumbawa Barat',
                'Kota Bima',
                'Kota Mataram',
                ),
        'Nusa Tenggara Timur' => array(
                'Kabupaten Alor',
                'Kabupaten Belu',
                'Kabupaten Ende',
                'Kabupaten Flores Timur',
                'Kabupaten Kupang',
                'Kabupaten Lembata',
                'Kabupaten Manggarai',
                'Kabupaten Manggarai Barat',
                'Kabupaten Manggarai Timur',
                'Kabupaten Ngada',
                'Kabupaten Nagekeo',
                'Kabupaten Rote Ndao',
                'Kabupaten Sabu Raijua',
                'Kabupaten Sikka',
                'Kabupaten Sumba Barat',
                'Kabupaten Sumba Barat Daya',
                'Kabupaten Sumba Tengah',
                'Kabupaten Sumba Timur',
                'Kabupaten Timor Tengah Selatan',
                'Kabupaten Timor Tengah Utara',
                'Kota Kupang',
                ),
        'Papua' => array(
                'Kabupaten Asmat',
                'Kabupaten Biak Numfor',
                'Kabupaten Boven Digoel',
                'Kabupaten Deiyai',
                'Kabupaten Dogiyai',
                'Kabupaten Intan Jaya',
                'Kabupaten Jayapura',
                'Kabupaten Jayawijaya',
                'Kabupaten Keerom',
                'Kabupaten Kepulauan Yapen',
                'Kabupaten Lanny Jaya',
                'Kabupaten Mamberamo Raya',
                'Kabupaten Mamberamo Tengah',
                'Kabupaten Mappi',
                'Kabupaten Merauke',
                'Kabupaten Mimika',
                'Kabupaten Nabire',
                'Kabupaten Nduga',
                'Kabupaten Paniai',
                'Kabupaten Pegunungan Bintang',
                'Kabupaten Puncak',
                'Kabupaten Puncak Jaya',
                'Kabupaten Sarmi',
                'Kabupaten Supiori',
                'Kabupaten Tolikara',
                'Kabupaten Waropen',
                'Kabupaten Yahukimo',
                'Kabupaten Yalimo',
                'Kota Jayapura',
                ),
        'Papua Barat' => array(
                'Kabupaten Fakfak',
                'Kabupaten Kaimana',
                'Kabupaten Manokwari',
                'Kabupaten Manokwari Selatan',
                'Kabupaten Maybrat',
                'Kabupaten Pegunungan Arfak',
                'Kabupaten Raja Ampat',
                'Kabupaten Sorong',
                'Kabupaten Sorong Selatan',
                'Kabupaten Tambrauw',
                'Kabupaten Teluk Bintuni',
                'Kabupaten Teluk Wondama',
                'Kota Sorong',
                ),
        'Riau' => array(
                'Kabupaten Bengkalis',
                'Kabupaten Indragiri Hilir',
                'Kabupaten Indragiri Hulu',
                'Kabupaten Kampar',
                'Kabupaten Kuantan Singingi',
                'Kabupaten Pelalawan',
                'Kabupaten Rokan Hilir',
                'Kabupaten Rokan Hulu',
                'Kabupaten Siak',
                'Kabupaten Kepulauan Meranti',
                'Kota Dumai',
                'Kota Pekanbaru',
                ),
        'Sulawesi Barat' => array(
                'Kabupaten Majene',
                'Kabupaten Mamasa',
                'Kabupaten Mamuju',
                'Kabupaten Mamuju Utara',
                'Kabupaten Polewali Mandar',
                'Kabupaten Mamuju Tengah',
                ),
        'Sulawesi Selatan' => array(
                'Kabupaten Bantaeng',
                'Kabupaten Barru',
                'Kabupaten Bone	Watampone',
                'Kabupaten Bulukumba',
                'Kabupaten Enrekang',
                'Kabupaten Gowa',
                'Kabupaten Jeneponto',
                'Kabupaten Kepulauan Selayar',
                'Kabupaten Luwu',
                'Kabupaten Luwu Timur',
                'Kabupaten Luwu Utara',
                'Kabupaten Maros',
                'Kabupaten Pangkajene dan Kepulauan',
                'Kabupaten Pinrang',
                'Kabupaten Sidenreng Rappang',
                'Kabupaten Sinjai',
                'Kabupaten Soppeng',
                'Kabupaten Takalar',
                'Kabupaten Tana Toraja',
                'Kabupaten Toraja Utara',
                'Kabupaten Wajo',
                'Kota Makassar',
                'Kota Palopo',
                'Kota Parepare',
                ),
        'Sulawesi Tengah' => array(
                'Kabupaten Banggai',
                'Kabupaten Banggai Kepulauan',
                'Kabupaten Banggai Laut',
                'Kabupaten Buol',
                'Kabupaten Donggala',
                'Kabupaten Morowali',
                'Kabupaten Parigi Moutong',
                'Kabupaten Poso',
                'Kabupaten Sigi',
                'Kabupaten Tojo Una-Una',
                'Kabupaten Tolitoli',
                'Kota Palu',
                ),
        'Sulawesi Tenggara' => array(
                'Kabupaten Bombana',
                'Kabupaten Buton',
                'Kabupaten Buton Utara',
                'Kabupaten Kolaka',
                'Kabupaten Kolaka Timur',
                'Kabupaten Kolaka Utara',
                'Kabupaten Konawe',
                'Kabupaten Konawe Selatan',
                'Kabupaten Konawe Utara',
                'Kabupaten Konawe Kepulauan',
                'Kabupaten Muna',
                'Kabupaten Wakatobi',
                'Kota Bau-Bau',
                'Kota Kendari',
                ),
        'Sulawesi Utara' => array(
                'Kabupaten Bolaang Mongondow',
                'Kabupaten Bolaang Mongondow Selatan',
                'Kabupaten Bolaang Mongondow Timur',
                'Kabupaten Bolaang Mongondow Utara',
                'Kabupaten Kepulauan Sangihe',
                'Kabupaten Kepulauan Siau Tagulandang Biaro',
                'Kabupaten Kepulauan Talaud',
                'Kabupaten Minahasa',
                'Kabupaten Minahasa Selatan',
                'Kabupaten Minahasa Tenggara',
                'Kabupaten Minahasa Utara',
                'Kota Bitung',
                'Kota Kotamobagu',
                'Kota Manado',
                'Kota Tomohon',
                ),
        'Sumatera Barat' => array(
                'Kabupaten Agam',
                'Kabupaten Dharmasraya',
                'Kabupaten Kepulauan Mentawai',
                'Kabupaten Lima Puluh Kota',
                'Kabupaten Padang Pariaman',
                'Kabupaten Pasaman',
                'Kabupaten Pasaman Barat',
                'Kabupaten Pesisir Selatan',
                'Kabupaten Sijunjung',
                'Kabupaten Solok',
                'Kabupaten Solok Selatan',
                'Kabupaten Tanah Datar',
                'Kota Bukittinggi',
                'Kota Padang',
                'Kota Padangpanjang',
                'Kota Pariaman',
                'Kota Payakumbuh',
                'Kota Sawahlunto',
                'Kota Solok',
                ),
        'Sumatera Selatan' => array(
                'Kabupaten Banyuasin',
                'Kabupaten Empat Lawang',
                'Kabupaten Lahat',
                'Kabupaten Muara Enim',
                'Kabupaten Musi Banyuasin',
                'Kabupaten Musi Rawas',
                'Kabupaten Ogan Ilir',
                'Kabupaten Ogan Komering Ilir',
                'Kabupaten Ogan Komering Ulu',
                'Kabupaten Ogan Komering Ulu Selatan',
                'Kabupaten Penukal Abab Lematang Ilir',
                'Kabupaten Ogan Komering Ulu Timur',
                'Kota Lubuklinggau',
                'Kota Pagar Alam',
                'Kota Palembang',
                'Kota Prabumulih',
                ),
        'Sumatera Utara' => array(
                'Kabupaten Asahan',
                'Kabupaten Batubara',
                'Kabupaten Dairi',
                'Kabupaten Deli Serdang',
                'Kabupaten Humbang Hasundutan',
                'Kabupaten Karo	Kabanjahe',
                'Kabupaten Labuhanbatu',
                'Kabupaten Labuhanbatu Selatan',
                'Kabupaten Labuhanbatu Utara',
                'Kabupaten Langkat',
                'Kabupaten Mandailing Natal',
                'Kabupaten Nias',
                'Kabupaten Nias Barat',
                'Kabupaten Nias Selatan',
                'Kabupaten Nias Utara',
                'Kabupaten Padang Lawas',
                'Kabupaten Padang Lawas Utara',
                'Kabupaten Pakpak Bharat',
                'Kabupaten Samosir',
                'Kabupaten Serdang Bedagai',
                'Kabupaten Simalungun',
                'Kabupaten Tapanuli Selatan',
                'Kabupaten Tapanuli Tengah',
                'Kabupaten Tapanuli Utara',
                'Kabupaten Toba Samosir',
                'Kota Binjai',
                'Kota Gunungsitoli',
                'Kota Medan',
                'Kota Padangsidempuan',
                'Kota Pematangsiantar',
                'Kota Sibolga',
                'Kota Tanjungbalai',
                'Kota Tebing Tinggi',
                ),
        );
	} 
}

 ?>
