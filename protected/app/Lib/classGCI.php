<?php 

namespace App\Lib;

class classGCI{
	protected static $_instance;

	private $_session;

	private $uri;
	// Staging
	// private $baseUri 	= 'http://staging-distribution-api.gift.id/';
	
	// Production
	private $baseUri 	= 'https://api.gift.id/';

	private $testingURI;
	private $method;
	private $auth;
	private $error;

	private $maxTried = 5;
	private $sleepTime = 3;

	// Staging 1
	// private $apiKey 	= 'vdHoBwp8kEvW3Bvk0x5h9Ebad';
	// private $apiSecret 	= 'IC6QNyvgzHOB93bwzu4QyrvzTk7rALFSxY4yKqYk';
	
	// Staging 2
	// private $apiKey 	= 'PoGBJiQ16ic0XBdUDEHxz9uSG';
	// private $apiSecret 	= 'SamSbKan8wG0XKF1PdNGJ1ndn1HjYZMXFRymcpf22vRxbFZBzO';
	
	// Production
	private $apiKey 	= 'LYvOZi1xhYt1qyZE5FEvx7iqy';
	private $apiSecret 	= 'heRqRARWfBzbdaqmYTy1kDQ7EckQMtBIPYmVhII6OWZkFNA1aa';
	
/* CONSTRUCTOR */

	public function __construct() {
		// $this->_session 	= new Session;

		// $this->_session->delete('apiError');
	}

	public static function instance () {
		if (self::$_instance === NULL)
			self::$_instance	= new self();

		return self::$_instance;
	}

	public function setCardNumber($cardnumber) {
		if(empty($cardnumber))
			return FALSE;

		$this->_session->set('cardnumber', $cardnumber);
	}

	public function register($name, $email, $phone, $sex, $birthday, $password, $occupation, $city, $cardNo = null) {
		if(empty($name) && empty($email) && empty($phone) && empty($sex) && empty($birthday) && empty($occupation) && empty($city) && empty($password))
			return "unknown parameters";

		$params 	= array('name'					=> $name,
							'email'					=> $email,
							'phone'					=> $phone,
							'sex'					=> $sex,
							'birthday'				=> $birthday,
							'occupation'			=> $occupation,
							'city'					=> $city,
							'cardNo'				=> $cardNo,
							'password'				=> $password,
							'passwordConfirmation'	=> $password);

		if(empty($cardNo)) {
			unset($params['cardNo']);
			$result 	= $this->send('user_register_without_card', $params);
		} else {
			$result 	= $this->send('user_register_with_card', $params);
		}

		if($result !== FALSE) {
			if(isset($result->error)){
				$result 		= json_decode(json_encode($result), true);
			} else {
				$result 		= json_decode($result, true);
			}
			return $result;
		
		}

		return $result;
	}

	public function confirmation($email, $confirmationToken) {
		if(empty($email) && empty($confirmationToken))
			return FALSE;

		$params 	= array('email'					=> $email,
							'confirmationToken'		=> $confirmationToken);

		$result 	= $this->send('confirmation', $params);

		if($result !== FALSE) {
			if(isset($result->error)){
				$result 		= json_decode(json_encode($result), true);
			} else {
				$result 		= json_decode($result, true);
			}

			return $result;
		}

		return FALSE;
	}

	public function resetConfirmation($email) {
		if(empty($email))
			return FALSE;

		$params 	= array('email'					=> $email);

		$result 	= $this->send('reset_confirmation', $params);

		if($result !== FALSE) {
			$result 	= json_decode($result);

			$status 		= isset($result->active) ? $result->active : '';

			return $status;
		}

		return FALSE;
	}

	public function forgotPassword($email) {
		if(empty($email))
			return FALSE;

		$params 	= array('email'					=> $email);

		$result 	= $this->send('forgot_password', $params);

		if($result !== FALSE) {
			if(isset($result->error)){
				$result 		= json_decode(json_encode($result), true);
			} else {
				$result 		= json_decode($result, true);
			}

			return $result;
		}

		return FALSE;
	}

	public function resetPassword($email, $resetPasswordToken, $newPassword) {
		// if($this->_session->get('user_id', '') == '')
		// 	return FALSE;

		if(empty($currentPassword) && empty($newPassword))
			return FALSE;

		$params 	= array('email'						=> $email,
							'resetPasswordToken'		=> $resetPasswordToken,
							'newPassword'				=> $newPassword,
							'newPasswordConfirmation'	=> $newPassword);

		$result 	= $this->send('reset_password', $params);

		if($result !== FALSE) {
			if(isset($result->error)){
				$result 		= json_decode(json_encode($result), true);
			} else {
				$result 		= json_decode($result, true);
			}
			return $result;		
		}

		return FALSE;
	}

	public function login($username = null, $password = null) {
		if(is_null($username) || is_null($password)){
			$result = array(
						'status' => 'fail'
					);
			return json_encode($result);
		}
		$params 	= array('grant_type'	=> 'password',
							'scope'			=> 'offline_access',
							'username'		=> $username,
							'password'		=> $password);

		$result 	= $this->send('user_login', $params);

		if($result != FALSE) {
			if(isset($result->error)){
				$result 		= json_decode(json_encode($result), true);
			} else {
				$result 		= json_decode($result, true);
			}
			
			
			$access_token 	= isset($result->access_token) ? $result->access_token : '';
			$token_type 	= isset($result->token_type) ? $result->token_type : '';
			$expires_in 	= isset($result->expires_in) ? $result->expires_in : '';

			$result = array(
						'status' => 'success',
						'message' => $result
					);		
		}
		else {
			$result = array(
						'status' => 'fail'
					);
		}
		return json_encode($result);
	}

	public function loginInfo() {
		$result 	= $this->send('user_profile');

		if($result !== FALSE) {
			$result 	= json_decode($result);

			$user_id 			= isset($result->id) ? $result->id : '';
			$name 				= isset($result->name) ? $result->name : '';
			$email 				= isset($result->email) ? $result->email : '';
			$active 			= isset($result->active) ? $result->active : FALSE;

			if($active == TRUE) {
				$this->_session->set('user_id', $user_id);
				$this->_session->set('name', $name);
				$this->_session->set('email', $email);
			}

			return $active;
		}

		return FALSE;
	}

	public function userProfile($access_token) {
		// if($this->_session->get('user_id', '') == '')
		// 	return FALSE;

		$result = $this->send('user_profile', null, null, $access_token);

		if($result !== FALSE) {
			if(isset($result->error)){
				$result 		= json_decode(json_encode($result), true);
			} else {
				$result 		= json_decode($result, true);
			}

			return $result;
		}

		return FALSE;
	}

	public function editProfile($name, $occupation, $city, $access_token) {
		// if($this->_session->get('user_id', '') == '')
		// 	return FALSE;

		if(empty($name) && empty($occupation) && empty($city))
			return FALSE;

		$params 	= array('name'			=> $name,
							'occupation'	=> $occupation,
							'city'			=> $city);

		$result 	= $this->send('edit_profile', $params, null, $access_token);

		if($result !== FALSE){
			if(isset($result->error)){
				$result 		= json_decode(json_encode($result), true);
			} else {
				$result 		= json_decode($result, true);
			}
			return $result;
		}
		
		return FALSE;
	}

	public function changePassword($currentPassword, $newPassword, $access_token) {
		// if($this->_session->get('user_id', '') == '')
		// 	return FALSE;

		if(empty($currentPassword) && empty($newPassword) && empty($access_token))
			return FALSE;

		$params 	= array('currentPassword'			=> $currentPassword,
							'newPassword'				=> $newPassword,
							'newPasswordConfirmation'	=> $newPassword);

		$result 	= $this->send('change_password', $params, null, $access_token );

		if($result !== FALSE) {
			if(isset($result->error)){
				$active 		= json_decode(json_encode($result), true);
			} else {
				$active 		= json_decode($result, true);
			}

			return $active;		
		}

		return FALSE;
	}

	public function cardList($access_token) {
		// if($this->_session->get('user_id', '') == '')
		// 	return FALSE;

		$result 	= $this->send('card_list', null, null, $access_token);

		if($result !== FALSE) {
			if(isset($result->error)){
				$result 		= json_decode(json_encode($result), true);
			} else {
				$result 		= json_decode($result, true);
			}
			return $result;
		}

		return FALSE;
	}

	public function cardDetail($cardnumber, $access_token) {
		$result 	= $this->send('card_detail', NULL, $cardnumber, $access_token);

		if($result !== FALSE) {
			$result 		= json_decode($result);

			return $result;
		}

		return FALSE;
	}
	
	public function transferBalance($source, $destination, $access_token) {
		
		$params 	= array('sourceDistributionId'		=> $source,
							'destinationDistributionId'	=> $destination
							);

		$result 	= $this->send('transfer_balance', $params, null, $access_token);

		if($result !== FALSE) {
			if(isset($result->error)){
				$result 		= json_decode(json_encode($result), true);
			} else {
				$result 		= json_decode($result, true);
			}

			return $result;
		}

		return FALSE;
	}
	
	
	

	public function cardDetailByID($cardID, $access_token) {
		$result 	= $this->send('card_detail_by_id', NULL, $cardID, $access_token);
		
		if($result !== FALSE) {
			
			if(isset($result->error)){
				$result 		= json_decode(json_encode($result), true);
			} else {
				$result 		= json_decode($result, true);
			}

			return json_encode($result);
		}

		return FALSE;
	}

	public function addNewCard($cardnumber, $access_token) {
		if(empty($cardnumber))
			return FALSE;

		$params 	= array(//'customerId'		=> $this->_session->get('user_id', ''),
							'distributionId'	=> $cardnumber);

		$result = $this->send('add_card', $params, null, $access_token);

		if($result !== FALSE) {
			if(isset($result->error)){
				$result 		= json_decode(json_encode($result), true);
			} else {
				$result 		= json_decode($result, true);
			}

			return json_encode($result);
		}
		return json_encode($result);
	}

	public function changeCardPIN($cardnumber, $currentPin, $newPin, $access_token) {
		if(empty($cardnumber) && empty($currentPin) && empty($newPin))
			return FALSE;

		$params 	= array('cardNumber'			=> $cardnumber,
							'currentPin'			=> $currentPin,
							'newPin'				=> $newPin,
							'newPinConfirmation'	=> $newPin);

		$result 	= $this->send('change_card_pin', $params, $cardnumber, $access_token);

		if($result !== FALSE) {
			$result 		= json_decode($result);

			return $result;
		}

		return FALSE;
	}

	public function topupCard($email, $cardnumber, $amount) {
		if(empty($email) && empty($cardnumber) && empty($amount))
			return FALSE;

		$params 	= array('email'					=> $email,
							'cardNumber'			=> $cardnumber,
							'amount'				=> $amount);

		$result 	= $this->send('topup', $params);

		if($result !== FALSE) {
			$result 		= json_decode($result);

			$trxStatus 			= isset($result->trxStatus) ? $result->trxStatus : FALSE;

			if($trxStatus == 'accepted')
				return TRUE;
		}

		return FALSE;
	}

	public function transactionListing($periodStart, $periodEnd, $cardnumber, $access_token) {
		// if($this->_session->get('cardnumber', '') == '')
		// 	return FALSE;

		if(empty($periodStart) && empty($periodEnd) && empty($cardnumber))
			return FALSE;

		$params 	= array('periodStart'		=> $periodStart,
							'periodEnd'			=> $periodEnd,
							'distributionId'	=> $cardnumber);

		$result 	= $this->send('transaction_listing', $params, $cardnumber, $access_token);

		if($result !== FALSE) {
			if(isset($result->error)){
				$result 		= json_decode(json_encode($result), true);
			} else {
				$result 		= json_decode($result, true);
			}

			return $result;
		}

		return FALSE;
	}

	private function setLink($function, $cardnumber = NULL) {
		switch ($function) {
			case 'user_login':
				// $this->testingURI	= url::site('sample').'/login.json';

				$this->uri 		= $this->baseUri.'customer/token';
				$this->method 	= 'post';
				$this->auth 	= 'basic';
				break;

			case 'user_register_with_card':
				// $this->testingURI	= url::site('sample').'/register.json';

				$this->uri 		= $this->baseUri.'customer/register';
				$this->method 	= 'post';
				$this->auth 	= 'basic';
				break;

			case 'user_register_without_card':
				// $this->testingURI	= url::site('sample').'/register_nocard.json';

				$this->uri 		= $this->baseUri.'customer/register_without_card';
				$this->method 	= 'post';
				$this->auth 	= 'basic';
				break;

			case 'confirmation':
				// $this->testingURI	= url::site('sample').'/confirmation.json';

				$this->uri 		= $this->baseUri.'customer/confirm';
				$this->method	= 'patch';
				$this->auth 	= 'basic';
				break;

			case 'reset_confirmation':
				// $this->testingURI	= url::site('sample').'/reset_confirmation.json';

				$this->uri 		= $this->baseUri.'customer/reset_confirmation_token';
				$this->method	= 'patch';
				$this->auth 	= 'basic';
				break;

			case 'forgot_password':
				// $this->testingURI	= url::site('sample').'/forgot_password.json';

				$this->uri 		= $this->baseUri.'customer/forgot_password';
				$this->method	= 'post';
				$this->auth 	= 'basic';
				break;

			case 'reset_password':
				// $this->testingURI	= url::site('sample').'/reset_password.json';

				$this->uri 		= $this->baseUri.'customer/reset_password';
				$this->method	= 'patch';
				$this->auth 	= 'basic';
				break;

			case 'login_info':
				// $this->testingURI	= url::site('sample').'/login_info.json';

				$this->uri 		= $this->baseUri.'v1/info';
				$this->method 	= 'get';
				$this->auth 	= 'bearer';
				break;

			case 'user_profile':
				// $this->testingURI	= url::site('sample').'/account_profile.json';

				$this->uri 		= $this->baseUri.'v1/customer/detail';
				// $this->uri 		= $this->baseUri.'v1/customers/'.$this->_session->get('user_id', '');
				$this->method 	= 'get';
				$this->auth 	= 'bearer';
				break;

			case 'edit_profile':
				// $this->testingURI	= url::site('sample').'/edit_profile.json';

				$this->uri 		= $this->baseUri.'v1/customer/update';
				// $this->uri 		= $this->baseUri.'v1/customers/'.$this->_session->get('user_id', '');
				$this->method 	= 'put';
				$this->auth 	= 'bearer';
				break;

			case 'change_password':
				// $this->testingURI	= url::site('sample').'/change_password.json';

				$this->uri 		= $this->baseUri.'v1/customer/password';
				// $this->uri 		= $this->baseUri.'v1/customers/'.$this->_session->get('user_id', '').'/password';
				$this->method 	= 'patch';
				$this->auth 	= 'bearer';
				break;

			case 'card_list':
				// $this->testingURI	= url::site('sample').'/card_list.json';

				$this->uri 		= $this->baseUri.'v1/customer/cards';
				// $this->uri 		= $this->baseUri.'v1/customer/card/'.$this->_session->get('user_id', '').'/cards';
				$this->method 	= 'get';
				$this->auth 	= 'bearer';
				break;

			case 'card_detail_by_id':
				// $this->testingURI	= url::site('sample').'/card_details_by_id.json';

				$this->uri 		= $this->baseUri.'v1/customer/card/'.$cardnumber;
				$this->method 	= 'get';
				$this->auth 	= 'bearer';
				break;

			case 'card_detail':
				// $this->testingURI	= url::site('sample').'/card_details.json';

				$this->uri 		= $this->baseUri.'v1/customer/card_by_no/'.$cardnumber;
				$this->method 	= 'get';
				$this->auth 	= 'bearer';
				break;

			case 'add_card':
				// $this->testingURI	= url::site('sample').'/add_card.json';

				$this->uri 		= $this->baseUri.'v1/customer/card/associate';
				$this->method 	= 'post';
				$this->auth 	= 'bearer';
				break;

			case 'change_card_pin':
				// $this->testingURI	= url::site('sample').'/change_pin.json';

				$this->uri 		= $this->baseUri.'v1/customer/card/change_pin';
				$this->method 	= 'patch';
				$this->auth 	= 'bearer';
				break;

			case 'transaction_listing':
				// $this->testingURI	= url::site('sample').'/transaction_details.json';

				$this->uri 		= $this->baseUri.'v1/reports/card_transactions';
				// $this->uri 		= $this->baseUri.'v1/giftcards/'.$cardnumber;
				$this->method 	= 'post';
				$this->auth 	= 'bearer';
				break;

			case 'topup':
				// $this->testingURI	= url::site('sample').'/topup.json';

				$this->uri 		= $this->baseUri.'customer/topup_point';
				$this->method 	= 'post';
				$this->auth 	= 'basic';
				break;
			
			case 'transfer_balance':
				$this->uri 		= $this->baseUri.'v1/customer/card/transfer';
				$this->method 	= 'post';
				$this->auth 	= 'bearer';
				break;
		}
	}
	
	// Testing Only
	// public function send($function, $params = NULL, $cardnumber = NULL) {
	// 	if($function == '')
	// 		return FALSE;

	// 	$this->setLink($function, $cardnumber);

	// 	$auth 	= '';
	// 	if($this->auth == 'basic')
	// 		$auth 	= 'Basic Base64Encoded('.$this->apiKey.':'.$this->apiSecret.')';
	// 	elseif($this->auth == 'bearer')
	// 		$auth 	= 'Bearer '.$this->_session->get('access_token', '');


	// 	$ch = curl_init();

	// 	curl_setopt ($ch, CURLOPT_URL, // $this->testingURI);
		
	// 	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
	// 	curl_setopt ($ch, CURLOPT_HEADER, FALSE);

	// 	curl_setopt ($ch, CURLOPT_USERPWD, 'cofelle:m@5t3rk3y');
	// 	curl_setopt ($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

	// 	switch ($this->method) {
	// 		case 'post':
	// 			curl_setopt ($ch, CURLOPT_POST, TRUE);
	// 			break;
	// 	}

	// 	if(!empty($params)) {		
	// 		$postdata	= json_encode($params);

	// 		curl_setopt ($ch, CURLOPT_POSTFIELDS, urlencode($postdata));
	// 	}
		
	// 	$result		= curl_exec($ch);
	// 	$http_code	= curl_getinfo($ch, CURLINFO_HTTP_CODE);
	// 	curl_close ($ch);

	// 	if($http_code == 200)
	// 		return $result;
	// 	else {
	// 		$error 	= 'Error';
	// 		if(!empty($result)) {
	// 			$result = json_decode($result);
	// 			$error 	= isset($result->err) ? $result->err : 'Error';
	// 		}

	// 		$this->_session->set('apiError', $error);
	// 		return FALSE;
	// 	}
	// }
	
	public function send($function, $params = NULL, $cardnumber = NULL, $access_token = NULL) {
		if($function == '')
			return FALSE;

		$this->setLink($function, $cardnumber);

		$auth 	= '';
		if($this->auth == 'basic')
			$auth 	= 'Basic '.base64_encode($this->apiKey.':'.$this->apiSecret);
		elseif($this->auth == 'bearer')
			$auth 	= 'Bearer '.$access_token;
			
		$parse		= parse_url($this->uri);
		
		$is_https	= ($parse['scheme'] == 'https') ? true : false;

		$ch = curl_init();

		curl_setopt ($ch, CURLOPT_URL, $this->uri);
		
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt ($ch, CURLOPT_HEADER, FALSE);

		switch ($this->method) {
			case 'post':
				curl_setopt ($ch, CURLOPT_POST, TRUE);
				break;

			case 'put':
				curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "PUT");
				break;

			case 'patch':
				curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
				break;
		}

		if(!empty($params)) {
			$postdata	= json_encode($params);

			curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata);
		}
		
		if($is_https) { 
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		}

		$header 	= array('Content-Type: application/json',
							'Authorization: '.$auth.'');
		
		curl_setopt ($ch, CURLOPT_HTTPHEADER, $header);
		
		$result		= curl_exec($ch);
		$http_code	= curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close ($ch);

		if($http_code == 200 || $http_code == 201)
			return $result;
		else {
			$error 	= 'Error';
			
			// echo Krdcms::debug($http_code);
			// echo Krdcms::debug($result);exit;

		
			if(!empty($result)) {
				$result = json_decode($result);
				$error 	= isset($result->message) ? $result->message : 'Error';
			}
			return $result;
		}
	}


	public function registrationEmail($email, $name = '', $confirmationToken) {
		if(empty($email) && empty($confirmationToken))
			return FALSE;

		$confirmationLink 	= url::site('confirmation/'.urlencode($email).'/'.urlencode($confirmationToken));

		$to      = array($email, $name);
		$from    = 'noreply@maxx-coffee.co.id';
		$subject = 'Verify Your Email [Maxx Coffee World]';
		$message = 'Hi, '.$name.'<br><br>					
					Thank you for join with us.<br>
					Please verify your email address by clicking this link.<br><br>
					<a href="'.$confirmationLink.'">'.$confirmationLink.'</a><br><br>
					If you cannot access this link, copy and paste the entire URL into your browser.';

		// $emailSent 	= email::send($to, $from, $subject, $message, TRUE);

		$tried = 0;
	    $loop = true;
		while ($loop && $tried < $this->maxTried) {
			try {
				$tried++;
				$loop = false;
				$emailSent 	= email::send($to, $from, $subject, $message, TRUE);
				Krdcms::log('error', 'SUCCESS SENDING REGISTRATION EMAIL: '.$email);
			} catch (Exception $e) {
				Krdcms::log('error', 'ERROR '.$tried.' SENDING REGISTRATION EMAIL: '.$email);
				sleep($this->sleepTime);
				$loop = true;
				$emailSent 	= FALSE;
			}
		}

		return $emailSent;
	}

	public function resetPasswordEmail($email, $name = '', $confirmationToken) {
		if(empty($email) && empty($confirmationToken))
			return FALSE;

		$confirmationLink 	= url::site('confirmation_password/'.urlencode($email).'/'.urlencode($confirmationToken));

		$to      = array($email, $name);
		$from    = 'noreply@maxx-coffee.co.id';
		$subject = 'Reset Password Confirmation [Maxx Coffee World]';
		$message = 'Hi, '.$name.'<br><br>					
					You are requesting to reset your password.<br>
					Please confirm your request by clicking this link.<br><br>
					<a href="'.$confirmationLink.'">'.$confirmationLink.'</a><br><br>
					If you cannot access this link, copy and paste the entire URL into your browser.<br><br>
					Please ignore if you did\'t want reset your password. ';

		// $emailSent 	= email::send($to, $from, $subject, $message, TRUE);
		
		$tried = 0;
	    $loop = true;
		while ($loop && $tried < $this->maxTried) {
			try {
				$tried++;
				$loop = false;
				$emailSent 	= email::send($to, $from, $subject, $message, TRUE);
				Krdcms::log('error', 'SUCCESS SENDING RESET PASSWORD EMAIL: '.$email);
			} catch (Exception $e) {
				Krdcms::log('error', 'ERROR '.$tried.' SENDING RESET PASSWORD EMAIL: '.$email);
				sleep($this->sleepTime);
				$loop = true;
				$emailSent 	= FALSE;
			}
		}

		return $emailSent;
	}

	public function welcomeEmail($email, $name = '') {
		if(empty($email))
			return FALSE;

		//$to      = array($email, $name);
		$from    = 'noreply@maxx-coffee.co.id';
		$subject = 'Welcome ['.Krdcms::config('site_config.site_name').']';
		$message = 'Dear Mr / Ms '.$name.',<br><br>
					Thanks for joining the Maxx Coffee World membership. As a member of Maxx Card (Maxx Coffee World Card), you will be benefited to many of our exclusive offers, such as:<br>
					<ol>
						<li>Free upsize for every purchase using Maxx Card in all Maxx Coffee outlets until the end of 2015,</li>
						<li>In the event of lost / stolen card, we will restore your card’s balance as soon as you report us the event, and</li>
						<li>Various promotional offers that will be held regularly.</li>
					</ol>
					<br>
					As a thank you note for your Maxx Card membership, you will receive 1 reward point that can be redeemed with 1 Hot/ Iced Cappucino or Caffe Latte in all Maxx Coffee outlets that is located within Jabodetabek area. This offer is valid within 7 days since the bonus point confirmation. Feel free to tell our store staff that you would like to redeem the bonus point with the drink of your choice.<br><br>
					By joining the Maxx Coffee World’s membership, you automatically agree to our <a href="'.url::site('terms').'" target="_blank">Terms & Condition</a> as stated in our website. Always be on the lookout for our exciting and exclusive offer for all Maxx Card members.<br><br>
					Sincerely,<br>
					Management Maxx Coffee';
					
		$swift 	= email::connect();
		
		$recipients = new Swift_RecipientList;
		$recipients->addTo($email, $name);
		// $recipients->addBcc('geoffry.samuel@maxx-coffee.com');
		//$recipients->addBcc('hardian@cofelletech.com');

		$message = new Swift_Message($subject, $message, "text/html");

		$tried = 0;
	    $loop = true;
		while ($loop && $tried < $this->maxTried) {
			try {
				$tried++;
				$loop = false;
				$emailSent 	= $swift->send($message, $recipients, $from);
				Krdcms::log('error', 'SUCCESS SENDING WELCOME EMAIL: '.$email);
			} catch (Exception $e) {
				Krdcms::log('error', 'ERROR '.$tried.' SENDING WELCOME EMAIL: '.$email);
				sleep($this->sleepTime);
				$loop = true;
				$emailSent 	= FALSE;
			}
		}
		 
		//$emailSent 	= email::send($to, $from, $subject, $message, TRUE);
		
		//$forwardEmail = email:send('geoffry.samuel@maxx-coffee.com', $from, $subject, $message, TRUE);


		return $emailSent;
	}

}