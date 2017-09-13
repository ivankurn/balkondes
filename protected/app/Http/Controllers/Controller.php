<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
    public $occupations = array('Pelajar','Mahasiswa','Karyawan','Wiraswasta','Pegawai Negeri','Tenaga Medis','TNI / Polri','Mengurus rumah tangga','Lainnya');
    public $api;
	
	public function __construct()
   	{
      	$this->middleware('auth');
      	$this->api = "App\Http\Controllers\API\C_API_All";
    }
    
    function safe_b64encode($string) {
		$data = base64_encode($string);
		$data = str_replace(array('+','/','='),array('-','_',''),$data);
		return $data;
	}

	function safe_b64decode($string) 
	{
		$data = str_replace(array('-','_'),array('+','/'),$string);
		$mod4 = strlen($data) % 4;
		if ($mod4) {
			$data .= substr('====', $mod4);
		}
		return base64_decode($data);
	}

	function encryptkhusus($value) {
		if(!$value){return false;}
		$skey = $this->getkey();
		$depan = substr($skey, 0, 1);
		$belakang = substr($skey, -1, 1);
		$text = serialize($value);
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $skey, $text, MCRYPT_MODE_ECB, $iv);
		return trim($depan . $this->safe_b64encode($crypttext) . $belakang); 
	}
	
	function encryptkhususpassword($value, $skey) {
		if(!$value){return false;}
		$text = serialize($value);
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $skey, $text, MCRYPT_MODE_ECB, $iv);
		return trim($this->safe_b64encode($crypttext)); 
	}
	
	function decryptkhusus($value) {
		if(!$value){return false;}
		$skey = $this->parsekey($value);
		$jumlah = strlen($value);
		$value = substr($value, 1, $jumlah-2);
		$crypttext = $this->safe_b64decode($value); 
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $skey, $crypttext, MCRYPT_MODE_ECB, $iv);
		return unserialize(trim($decrypttext));
	}
	
	function decryptkhususpassword($value, $skey) 
	{
		if(!$value){return false;}
		$crypttext = $this->safe_b64decode($value); 
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $skey, $crypttext, MCRYPT_MODE_ECB, $iv);
		return unserialize(trim($decrypttext));
	}
	
	
	function createRandomPIN($digit, $mode = null) 
	{
		if($mode != null)
		{
			if($mode == "angka")
			{
				$chars = "1234567890";
			} 
			elseif($mode == "huruf")
			{
				$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			}
		} else {
			$chars = "346789ABCDEFGHJKMNPQRSTUVWXY";
		}
		
		srand((double)microtime()*1000000);
		$i = 0;
		$pin = '';

		while ($i < $digit) {
			$num = rand() % strlen($chars);
			$tmp = substr($chars, $num, 1);
			$pin = $pin . $tmp;
			$i++;
		}
		return $pin;
	}
	
	function getIPAddress()
	{
		$ipAddress = $_SERVER['REMOTE_ADDR'];
		if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
			$ipAddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
		}
		
		return $ipAddress;
	}
	
	function getUserAgent()
	{
		return $_SERVER['HTTP_USER_AGENT'];
	}
	
	function createrandom($digit) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		srand((double)microtime()*1000000);
		$i = 0;
		$pin = '';

		while ($i < $digit) {
			$num = rand() % strlen($chars);
			$tmp = substr($chars, $num, 1);
			$pin = $pin . $tmp;
			$i++;
			// supaya char yg sudah tergenerate tidak akan dipakai lagi
			$chars = str_replace($tmp, "", $chars);
		}

		return $pin;
	}
	
	function getkey() {
		$depan = $this->createrandom(1);
		$belakang = $this->createrandom(1);
		$skey = $depan . "9gjru84jb86c9l" . $belakang;
		return $skey;
	}
	
	function parsekey($value) {
		$depan = substr($value, 0, 1);
		$belakang = substr($value, -1, 1);
		$skey = $depan . "9gjru84jb86c9l" . $belakang;
		return $skey;
	}
	
	function validasitoken($token){
		$value = $this->encryptkhusus($token);
		$arrayvalue = explode("|",$value);
		if(empty($arrayvalue)){
			return "Invalid Token";
		} else {
			$data = array();
			$data['email'] 		= $arrayvalue['0'];
			$data['nohp']		= $arrayvalue['1'];
			$data['admin'] 		= $arrayvalue['2'];
			$data['created'] 	= $arrayvalue['3'];
			return $data;
		}
	}
}