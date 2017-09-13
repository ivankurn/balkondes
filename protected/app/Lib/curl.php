<?php 

namespace App\Lib;

class curl{

	public $client_id 		= 'f3d259ddd3ed8ff3843839b';
	public $client_secret	= '4c7f6f8fa93d59c45502c0ae8c4a95b';

	public function curl($url, $auth=NULL, $post=0, $post_type=0) {
		global $_GET;
		
		if($auth == "login"){
			$post['client_id'] 		= $this->client_id;
			$post['client_secret']	= $this->client_secret;
			$post['grant_type']		= 'password';

			$auth = null;
		}

		$url = 'http://crmsys.xyz/'.$url;

		$url = html_entity_decode($url);

		$ch = @curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		
		curl_setopt($ch, CURLOPT_USERAGENT, 'Opera/9.80 (Windows NT 6.1) Presto/2.12.388 Version/12.16');
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		/*switch ($method) {
			case 'post':
				curl_setopt ($ch, CURLOPT_POST, TRUE);
				break;

			case 'put':
				curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "PUT");
				break;

			case 'patch':
				curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
				break;
		}*/
		
		if ($post){
			

			if($post_type == 1){
				$data_string = json_encode($post);
				
				if($auth != null){
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string); 
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                              
		                    'Content-Type: application/json',
		                    'Authorization: '.$auth.'',                                                                                
		                    'Content-Length: ' . strlen($data_string))                                                                       
		                );
				}
				else{
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                              
		                    'Content-Type: application/json',
		                    'Content-Length: ' . strlen($data_string))                                                                       
		                );
				}	
			}
			else{
				if($auth != null){
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                              
		                    'Content-Type: application/json',
		                    'Authorization: '.$auth.''                                                                                
		                ));
				}
				else{
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
				}
			}
		}

		if($auth != null){
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		     'Content-Type: application/json',
		     'Authorization: '.$auth.'',
		    ));
		}

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60); 
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 60);
		
		$page = curl_exec( $ch);
		curl_close($ch);
		
		return $page;
	}
}