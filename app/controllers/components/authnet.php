<?php
class AuthnetComponent extends Object {
	// Test 
	var $loginId			= '6g3b6fTU5'; 
	var $transactionKey		= '6652rQ6EA3ary6c4'; 
	
	//var $loginId			= '24vhX82ncQM';
	//var $transactionKey		= '2UM2864qc4XnKP9z';
	
	// URLs
	//var $url				= 'https://cardpresent.authorize.net/gateway/transact.dll'; // Live URL - be sure to disable x_test_request below.
	var $url 				= 'https://test.authorize.net/gateway/transact.dll'; // Test Account - be sure to enable x_test_request below.
	//var $url				= 'https://developer.authorize.net/param_dump.asp'; // var dump
	
	var $request 			= array(
		'x_login'				=> '24vhX82ncQM',
		'x_tran_key'			=> '2UM2864qc4XnKP9z',
		//'x_test_request'		=> 'TRUE',
		
		'x_version'				=> '3.1',
		'x_delim_data'			=> 'TRUE',
		'x_delim_char'			=> '|',
		'x_relay_response'		=> 'FALSE',
		
		'x_type'				=> 'AUTH_CAPTURE',
		'x_method'				=> 'CC',
		'x_card_num'			=> '',
		'x_exp_date'			=> '',
		'x_card_code'			=> '',
		
		'x_amount'				=> '',
		'x_description'			=> '',
		
		'x_first_name'			=> '',
		'x_last_name'			=> '',
		'x_address'				=> '',
		'x_city'				=> '',
		'x_state'				=> '',
		'x_zip'					=> ''
	);
	
	var $recurring			= array(
		'interval_length'		=> '1',
		'interval_unit'			=> 'months',
		'total_occurrences'		=> '9999',
		'trial_occurrences'		=> '0',
		'trial_amount'			=> '0',
		'subscription_id'		=> ''
	);

	var $response = array();
	var $responseCode = array();
	var $responseReason = array();
	var $component; 

	function startup(&$component) {
		$this->component = $component;
	}

	function makeRequest() {
		$fields = '';
		foreach($this->request as $key => $value) {
			$fields .= "$key=" . urlencode($value) . "&";
		}
		
		$ch = curl_init($this->url);

		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim($fields, "& "));

		//uncomment this line if you get no gateway response.
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
		
		$resp = curl_exec($ch);
		curl_close($ch);

		$this->response = explode('|',$resp);
		$this->responseCode = $this->response[0]; // 1 - Approved / 2 - Declined / 3 - Error / 4 - Held for Review
		$this->responseReason = $this->response[3];
		return $this->response;
	}

	/**
	 * Function to send XML request via CURL
	 *
	 * @param  array   $content  You know, the string of sensitive information that we pray won't be intercepted during transit.
	 * @return array   $response  Call us when you get there...
	 * @access private
	 * @author Authorize.net
	 */
	function send_subscription_request($content){
		$posturl = "https://api.authorize.net/xml/v1/request.api"; // Test API? needs to change!!!!!!!!!!!!!!!!!!!
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $posturl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		$response = curl_exec($ch);
		return $response;
	}
	
	function createSubscription() {
		$content =
		        '<?xml version=\'1.0\' encoding=\'utf-8\'?>' .
		        '<ARBCreateSubscriptionRequest xmlns=\'AnetApi/xml/v1/schema/AnetApiSchema.xsd\'>' .
		        '<merchantAuthentication>'.
		        '<name>' . $this->loginId . '</name>'.
		        '<transactionKey>' . $this->transactionKey . '</transactionKey>'.
		        '</merchantAuthentication>'.
				'<refId>' . $this->request['x_cust_id'] . '</refId>'.
		        '<subscription>'.
		        '<name>' . $this->request['x_description'] . '</name>'.
		        '<paymentSchedule>'.
		        '<interval>'.
		        '<length>'. $this->recurring['interval_length'] .'</length>'.
		        '<unit>'. $this->recurring['interval_unit'] .'</unit>'.
		        '</interval>'.
		        '<startDate>' . date('Y-m-d',strtotime('+30 days')) . '</startDate>'.
		        '<totalOccurrences>'. $this->recurring['total_occurrences'] . '</totalOccurrences>'.
		        '<trialOccurrences>'. $this->recurring['trial_occurrences'] . '</trialOccurrences>'.
		        '</paymentSchedule>'.
		        '<amount>'. $this->request['x_amount'] .'</amount>'.
		        '<trialAmount>' . $this->recurring['trial_amount'] . '</trialAmount>'.
		        '<payment>'.
		        '<creditCard>'.
		        '<cardNumber>' . $this->request['x_card_num'] . '</cardNumber>'.
		        '<expirationDate>' . $this->request['x_exp_date'] . '</expirationDate>'.
				'<cardCode>'. $this->request['x_card_code'] . '</cardCode>'.
		        '</creditCard>'.
		        '</payment>'.
		        '<billTo>'.
		        '<firstName>'. $this->request['x_first_name'] . '</firstName>'.
		        '<lastName>' . $this->request['x_last_name'] . '</lastName>'.
		        '</billTo>'.
		        '</subscription>'.
		        '</ARBCreateSubscriptionRequest>';
		$response = $this->send_subscription_request($content);
		$resp = $this->parse_return($response);
		return $resp;
	}
	
	function updateSubscription() {
		$content =
		        '<?xml version=\'1.0\' encoding=\'utf-8\'?>' .
		        '<ARBUpdateSubscriptionRequest xmlns=\'AnetApi/xml/v1/schema/AnetApiSchema.xsd\'>' .
		        '<merchantAuthentication>'.
		        '<name>' . $this->loginId . '</name>'.
		        '<transactionKey>' . $this->transactionKey . '</transactionKey>'.
		        '</merchantAuthentication>'.
				'<subscriptionId>' . $this->recurring['subscription_id'] . '</subscriptionId>'.
		        '<subscription>';
		if($this->request['x_amount']!=''){ $content .= '<amount>'. $this->request['x_amount'] .'</amount>'; }
		if($this->request['x_card_num']!=''||$this->request['x_exp_date']!=''||$this->request['x_card_code']!=''){
			$content .= '<payment><creditCard>';
			if($this->request['x_card_num']!=''){ $content .= '<cardNumber>' . $this->request['x_card_num'] . '</cardNumber>'; }
			if($this->request['x_exp_date']!=''){ $content .= '<expirationDate>' . $this->request['x_exp_date'] . '</expirationDate>'; }
			if($this->request['x_card_code']!=''){ $content .= '<cardCode>'. $this->request['x_card_code'] . '</cardCode>'; }
			$content .= '</creditCard></payment>';
		}
		if($this->request['x_first_name']!=''||$this->request['x_last_name']!=''){
			$content .= '<billTo>';
			if($this->request['x_first_name']!=''){ $content .= '<firstName>'. $this->request['x_first_name'] . '</firstName>'; }
			if($this->request['x_last_name']!=''){ $content .= '<lastName>' . $this->request['x_last_name'] . '</lastName>'; }
			$content .= '</billTo>';
		}
		$content .= '</subscription></ARBUpdateSubscriptionRequest>';
		$response = $this->send_subscription_request($content);
		$resp = $this->parse_return($response);
		return $resp;
	}
	
	function cancelSubscription() {
		$content =
			'<?xml version=\'1.0\' encoding=\'utf-8\'?>'.
			'<ARBCancelSubscriptionRequest xmlns=\'AnetApi/xml/v1/schema/AnetApiSchema.xsd\'>'.
			'<merchantAuthentication>'.
			'<name>' . $this->loginId . '</name>'.
			'<transactionKey>' . $this->transactionKey . '</transactionKey>'.
			'</merchantAuthentication>'.
			'<subscriptionId>' . $this->recurring['subscription_id'] . '</subscriptionId>'.
			'</ARBCancelSubscriptionRequest>';
		$response = $this->send_subscription_request($content);
		$resp = $this->parse_return($response);
		return $resp;
	}
	
	//function to parse Authorize.net response
	function parse_return($content)
	{
		$refId = $this->substring_between($content,'<refId>','</refId>');
		$resultCode = $this->substring_between($content,'<resultCode>','</resultCode>');
		$code = $this->substring_between($content,'<code>','</code>');
		$text = $this->substring_between($content,'<text>','</text>');
		$subscriptionId = $this->substring_between($content,'<subscriptionId>','</subscriptionId>');
		return array ($refId, $resultCode, $code, $text, $subscriptionId);
	}

	//helper function for parsing response
	function substring_between($haystack,$start,$end) 
	{
		if (strpos($haystack,$start) === false || strpos($haystack,$end) === false) 
		{
			return false;
		} 
		else 
		{
			$start_position = strpos($haystack,$start)+strlen($start);
			$end_position = strpos($haystack,$end);
			return substr($haystack,$start_position,$end_position-$start_position);
		}
	}
}
?>