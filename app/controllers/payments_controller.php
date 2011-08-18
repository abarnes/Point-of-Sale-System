<?php
/*------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
-------------------------------------------------------------------------------*/
class PaymentsController extends AppController {
 
	var $name = 'Payments';
        //var $layout = 'default';
	var $uses = array('Payment','Ticket','Setting','Seat','Item','Modifier','Type','Discount');
	var $helpers = array('Html', 'Form', 'Time', 'javascript','Qrcode');
	var $components = array('Auth','Session');
        
        function beforeFilter() {
            //$this->Auth->allow('setup');
        }
        
	
	function index () {
		$this->Ticket->setDataSource('alternate');
		$this->Payment->setDataSource('alternate');
		
		$userInfo = $this->Auth->user();
		if ($userInfo['User']['level']!='1') {
			$this->Session->setFlash('This Action Is Restricted To Administrators. Please Authenticate As An Administrator And Try Again.');
			$this->redirect(array('controller'=>'users','action'=>'login'));
		}
		
		if (!empty($this->data)) {
			//die(print_r($this->data));
			$conditions = array();
			
			if (strlen($this->data['Payment']['startdate'])<9 || strlen($this->data['Payment']['enddate'])<9) {
				$this->Session->setFlash('Invalid data parameters given.');
				$this->redirect(array('controller'=>'payments','action'=>'index'));
			}
			
			if(strtotime($this->data['Payment']['startdate'])<=strtotime($this->data['Payment']['enddate'])) {
				if ($this->data['Payment']['startdate']==$this->data['Payment']['enddate']) {
					$conditions['Ticket.created BETWEEN ? AND ?']=array(date('Y-m-d',strtotime($this->data['Payment']['startdate'])),date('Y-m-d',strtotime($this->data['Payment']['startdate'])+86400));
				} else {
					$conditions['Ticket.created BETWEEN ? AND ?']=array(date('Y-m-d',strtotime($this->data['Payment']['startdate'])),date('Y-m-d',strtotime($this->data['Payment']['enddate'])));
				}
			} else {
				//end date before start date
				$this->Session->setFlash('Invalid date parameters given.');
				$this->redirect(array('controller'=>'payments','action'=>'index'));
			}
			
			if ($this->data['Payment']['ticket_type']!=0) {
				$conditions['Ticket.type_id']=$this->data['Payment']['ticket_type'];
				$this->set('ttype',$this->data['Payment']['ticket_type']);
			} else {
				$this->set('ttype','0');
			}
			
			if ($this->data['Payment']['method']!='any') {
				$conditions['Payment.type']=$this->data['Payment']['method'];
				$this->set('mthd',$this->data['Payment']['method']);
			} else {
				$this->set('mthd','any');
			}
			
			$this->paginate = array('limit' => 20,'conditions'=>$conditions,'order'=>'Ticket.created ASC');
			$payments = $this->paginate('Payment');
			
			$this->set('start',$this->data['Payment']['startdate']);
			$this->set('end',$this->data['Payment']['enddate']);
		} else {
			$conditions = array('Ticket.created >'=>date('Y-m-d', strtotime("-2 weeks")));
			$this->paginate = array('limit' => 20,'conditions'=>$conditions,'order'=>'Ticket.created ASC');
			$payments = $this->paginate('Payment');
			
			$this->set('mthd','any');
			$this->set('ttype','0');
			$this->set('start',date('m/d/Y',strtotime('-2 weeks')));
			$this->set('end',date('m/d/Y',time()));
		}
		
		//process payment information once retrieved
		$cash = 0;
		$check = 0;
		$credit = 0;
		foreach ($payments as $p) {
			switch ($p['Payment']['type']) {
				case 'cash':
					$cash = $cash+$p['Payment']['amount'];
					break;
				case 'credit':
					$credit = $credit+$p['Payment']['amount'];
					break;
				case 'check':
					$check = $check+$p['Payment']['amount'];
					break;
				default:
					$cash = $cash+$p['Payment']['amount'];
					break;
			}
			
		}
		
		//check decimal places
		$data = array('cash'=>$cash,'check'=>$check,'credit'=>$credit,'total'=>$check+$credit+$cash);
		foreach ($data as $key => $d) {
			$new = round($d,'2');
			$sp = explode('.',$new);
			if (isset($sp[1])) {
				if (strlen($sp[1])==1) {
					$data[$key] = $d.'0';
				}
			} else {
				$data[$key] = $d.'.00';
			}
		}
		$this->set('data',$data);
		$this->set('payments',$payments);
		$types = $this->Type->find('list',array('fields'=>array('Type.name'),'conditions'=>array('Type.enable'=>'1')));
		$types[0] = 'any';
		$this->set('types',$types);
	}
	
	function enter() {
		if (!empty($this->data)) {
			$find = $this->Ticket->find('first',array('conditions'=>array('Ticket.dailyid'=>$this->data['Payment']['dayid'])));
			if (isset($find['Ticket'])) {
				if ($find['Ticket']['status']=='2') {
					$this->Session->setFlash('Ticket already paid.');
					$this->redirect(array('controller'=>'payments','action' => 'enter'));
				} else {
					$this->redirect(array('controller'=>'payments','action' => 'pay/'.$find['Ticket']['id']));	
				}
			} else {
				$this->Session->setFlash('Ticket ID not found in system.');
				$this->redirect(array('controller'=>'payments','action' => 'enter'));
			}
		}
	}
	
	function pay($id) {
		$userInfo = $this->Auth->user();
		
		//set the settings
		$find = $this->Setting->find('first',array('order'=>'Setting.created ASC'));
		$this->set('s',$find['Setting']);
		
		//find ticket info
		$this->Ticket->recursive = 2;
		$ticket = $this->Ticket->findById($id);
		$this->set('ticket',$ticket);
		
		$items = $this->Item->find('list',array('fields'=>array('Item.name')));
			$price = $this->Item->find('list',array('fields'=>array('Item.price')));
			$mods = $this->Modifier->find('list',array('fields'=>array('Modifier.name')));
			$mprice = $this->Modifier->find('list',array('fields'=>array('Modifier.price')));
			
			//set up discount check
			$disc = $this->Discount->find('all',array('conditions'=>array('Discount.enable'=>'1')));
			$dis_id = array();
			foreach ($disc as $d) {
				$dis_id[] = $d['Discount']['item_id'];
			}
			
			$sts = $this->Seat->find('all',array('conditions'=>array('Seat.ticket_id'=>$id),'order'=>'Seat.seat ASC'));
			//pull data on individual orders and build array
			$total = 0;
			foreach($sts as $t) {
				$se = $t['Seat']['seat'];
				$or = $t['Seat']['orig_seat'];
				$pr = $t['Seat']['total'];
				$seats[$se]['seat'] = $se;
				$seats[$se]['orig_seat'] = $or;
				$sp = explode('.',$t['Seat']['total']);
				if (isset($sp[1])) {
					if (strlen($sp[1])==1) {
						$pr = $pr.'0';
					}
				} else {
					$pr = $pr.'.00';
				}
				$seats[$se]['total'] = $pr;
				
				$newt = rtrim($t['Seat']['items'],',');
				$new = explode(',',$newt);
				foreach ($new as $n) {
					//find item
					$first = strpos($n,'(');
					$th = substr($n,0,$first);
					
					if ($th=='' || $th==0) {
						//empty seat
						$seats[$se]['item']=array();
					} else {
						//find mods for an item
						$mfirst = strpos($n,'(')+1;
						$m = substr($n,$mfirst,-1);
						$newm = explode(':',$m);
						$cou = 0;
						$test = array();
						$modextras = 0;
						foreach ($newm as $nm) {
							if ($nm!='' && substr($nm,0,1)!='|') {
								$test[] = $mods[$nm];
								//die(print_r($mprice[$nm]));
								if ($mprice[$nm]!=0.00) {
									$modextras += $mprice[$nm];
								}
							} elseif (substr($nm,0,1)=='|') {
								$test[] = substr($nm,1);
							}
						}
						//check for discounts
						$p = 0;
						if (in_array($th,$dis_id)) {
							$dis = $this->Discount->find('all',array('conditions'=>array('Discount.item_id'=>$th)));
							$today = strtolower(date('l'));
							
							foreach ($dis as $di) {
								if ($di['Discount'][$today]=='1') {
									$time = mktime(date('h'),date('i'),0);
									if ($time>=strtotime($di['Discount']['start_time']) && $time<=strtotime($di['Discount']['end_time'])) {
										$p = $di['Discount']['price']+$modextras;
									}
								}
							}
						} 
						
						if ($p==0) {
							$p = $price[$th]+$modextras;
						}
						
						$sp = explode('.',$p);
						if (isset($sp[1])) {
							if (strlen($sp[1])==1) {
								$p = $p.'0';
							}
						} else {
							$p = $p.'.00';
						}
						//put array together
						$append=array($items[$th]=>array('mods'=>$test,'price'=>$p));
						$seats[$se]['item'][]=$append;
						$total += $p;
					}
				}
			}
			//format the total
			$sp = explode('.',$total);
			if (isset($sp[1])) {
				if (strlen($sp[1])==1) {
					$total = $total.'0';
				}
			} else {
				$total = $total.'.00';
			}
			
			$rate = $find['Setting']['tax']/100;
			$rate = $rate+1;
			$taxed = $total*$rate;
			$taxed = round($taxed,'2');
			
			$this->set('total',$total);
			$this->set('seats',$seats);
		
		if (!empty($this->data)) {
			//make sure full amount is paid
			$co = 1;
			$am = 0;
			while ($co<6) {
				if ($this->data['Payment']['enable'.$co]=='1') {
					$am = $am+$this->data['Payment']['amount'.$co];
				}
				$co++;
			}
			if ($am==$taxed) {
				if ($find['Setting']['cc_process']=='1') {
					require_once 'authnet/AuthorizeNet.php';
					
					define("AUTHORIZENET_API_LOGIN_ID", $find['Setting']['authorizenet_api_login_id']);
					define("AUTHORIZENET_TRANSACTION_KEY", $find['Setting']['authorizenet_transaction_key']);
					define("AUTHORIZENET_MD5_SETTING", "");
					
					//process payment by CC if necessary
					$co = 1;
					$ids = array();
					$errors = array();
					while ($co<6) {
						if ($this->data['Payment']['enable'.$co]=='1') {
							if ($this->data['Payment']['type'.$co]=='credit') {
								$sale = new AuthorizeNetCP;
								 $sale->setFields(
										array(
										'amount' => $this->data['Payment']['amount'.$co],
										'device_type' => '4'
										)
									    );
								//$sale->setCustomField("location", "test");
								$sale->setTrack1Data('%B4111111111111111^CARDUSER/JOHN^1803101000000000020000831000000?');
								
								 // Authorize Only:
								$response  = $sale->authorizeOnly();
								//die(print_r($response));
								
								//make sure each is valid, save id as error or to process later  
								if ($response->approved) {
									$auth_code = $response->transaction_id;
									$ids[] = $auth_code;
									    
									// Now capture:
									//$capture = new AuthorizeNetCP;
									//$capture_response = $capture->priorAuthCapture($auth_code);
									    
									// Now void:
									//$void = new AuthorizeNetAIM;
									//$void_response = $void->void($capture_response->transaction_id);
								} else {
									$auth_code = $response->transaction_id;
									//$errors[] = $auth_code;
									$errors[] = $response->response_reason_text;
								}
							}
						}
						$co++;
					}
					
					//see if we need to correct errors, or go ahead and process
					if (count($errors)!=0) {
						//errors present, not processing
						$this->Session->setFlash('Errors in credit card authorization: '.implode(',',$errors));
						$this->redirect(array('controller'=>'payments','action' => 'pay/'.$id));
						exit();
					} else {
						if (count($ids)>0) {
							foreach ($ids as $auth_code) {
								// Now capture:
								$capture = new AuthorizeNetCP;
								$capture_response = $capture->priorAuthCapture($auth_code);
							}
						}
					}
				}
				
				
				$co = 1;
				while ($co<6) {
					if ($this->data['Payment']['enable'.$co]=='1') {
						$data = array();
						$this->Payment->create();
						$data['Payment']['ticket_id'] = $id;
						$data['Payment']['user_id'] = $userInfo['User']['id'];
						$data['Payment']['amount'] = $this->data['Payment']['amount'.$co];
						$data['Payment']['type'] = $this->data['Payment']['type'.$co];
						$data['Payment']['tip'] = $this->data['Payment']['tip'.$co];
						$this->Payment->save($data);
						$this->Payment->id = false;
					}
					$co++;
				}
				
				//update ticket status
				$this->Ticket->id = $id;
				$this->Ticket->saveField('status', '2');
					
				$this->Session->setFlash('Ticket '.$ticket['Ticket']['dailyid'].' Paid');
				$this->redirect(array('controller'=>'tickets','action' => 'index'));
			} else {
				$dif = $taxed-$am;
				$this->Session->setFlash('The full amount was not been entered. (Short by $'.$dif.')');
				$this->redirect(array('controller'=>'payments','action' => 'pay/'.$id));
			}
		}
	}
	
	function gimme_test($id) {
		$resp = $this->_gimme($id);
		//codes for errors:
		// b - 403 error, authentication with gimme failed     c - other error (apache response over 399)
		if ($resp == 'b') {
			//echo 'Request Denied.  Your subscription may have expired, or Gimme\'s servers may be down.';
		} elseif (substr($resp,0,1) == 'c') {
			//echo 'Gimme\'s server returned an error ('.substr($resp,'1').'); check your Gimme settings.';
		} else {
			//echo $resp;
			$this->set('url',$resp);
		}
	}
	
	function _gimme($id) {
		//generate signature-----------------------------------------------------------------------------------
		$settings = $this->Setting->find('first',array('order'=>'Setting.created ASC'));
		//$loc = $settings['Setting']['locationid'];
		$loc = '2';
		
		//pull ticket data
		$this->Ticket->recursive = 2;
		$ticket = $this->Ticket->findById($id);
		if (empty($ticket['Payment'])) {
			return false;
		}
		
		$signature = null;
		$toSign = "http://173.246.103.0:9000/pos/api/location/".$loc."/receiptjson?sequence=2200012&signature=";
		// Read the private key from the file.
		$fp = fopen("/Users/austin 1/Sites/barnespossystem/app/webroot/files/key.pem", "r");
		$priv_key = fread($fp, 8192);
		fclose($fp);
		$pkeyid = openssl_get_privatekey($priv_key);
		// Compute the signature using OPENSSL_ALGO_SHA1 // by default.
		openssl_sign($toSign, $signature, $pkeyid);
		// Free the key.
		openssl_free_key($pkeyid);
		// At this point, you've got $signature which
		// contains the digital signature as a series of bytes. // If you need to include the signature on a URL // for a request to be sent to a REST API, use // PHP's bin2hex() function.
		$hex = bin2hex( $signature );
		//$toSign .= "/" . $hex;
		$toSign .= $hex;
		//die(print($toSign));
	
		//json encoded receipt details ----------------------------------------------------------------------------	
		$item = $this->Item->find('list',array('fields'=>array('Item.short_name')));
		$pr = $this->Item->find('list',array('fields'=>array('Item.price')));
		
		//set up discount check
		$disc = $this->Discount->find('all',array('conditions'=>array('Discount.enable'=>'1')));
		$dis_id = array();
		foreach ($disc as $d) {
			$dis_id[] = $d['Discount']['item_id'];
		}
		
		$open = date("Y-m-d'6'h:i:s",strtotime($ticket['Ticket']['created']));
		$open = str_replace("'6'","T",$open);
		$close = date("Y-m-d'6'h:i:s",strtotime($ticket['Payment'][0]['created']));
		$close = str_replace("'6'","T",$close);
		$data = array('locationid'=>$loc,'openingtime'=>$open,'closingtime'=>$close,'totalamt'=>$ticket['Payment'][0]['amount'],'paymentmethod'=>$ticket['Payment'][0]['type']);
		$its = array();
		foreach ($ticket['Seat'] as $sts) {
			$newt = rtrim($sts['items'],',');
			$new = explode(',',$newt);
			foreach ($new as $n) {
				//find item
				$first = strpos($n,'(');
				$th = substr($n,0,$first);
				if ($th!='' && $th!='0') {
					$its[] = intval($th);
				}
			}
		}
		
		$its2 = array_unique($its);
		foreach ($its2 as $i) {
			$name = $item[$i];
			$q = array_count_values($its);
			$quantity = $q[$i];
			
			//check for discounts
			$price = 100000000;
			if (in_array($th,$dis_id)) {
				$dis = $this->Discount->find('all',array('conditions'=>array('Discount.item_id'=>$th)));
				$today = strtolower(date('l'));
							
				foreach ($dis as $di) {
					if ($di['Discount'][$today]=='1') {
						$time = mktime(date('h',strtotime($ticket['Ticket']['created'])),date('i',strtotime($ticket['Ticket']['created'])),0);
						if ($time>=strtotime($di['Discount']['start_time']) && $time<=strtotime($di['Discount']['end_time'])) {
							$price = $di['Discount']['price'];
						}
					}
				}
			} 
						
			if ($price==100000000) {
				$price = $pr[$th];
			}
			//add to data array
			$data['order']['items'][] = array('item'=>$name,'quantity'=>$quantity,'price'=>$price);
		}
		$json = json_encode($data);
	
		//-----set up cURL to send data--------------------------------------------------------
		$options = array(
			CURLOPT_URL=>$toSign,
			CURLOPT_POST=>1,
			CURLOPT_POSTFIELDS => array('rcpt'=>$json),
			CURLOPT_RETURNTRANSFER => true
		);
		
		$ch = curl_init();
		curl_setopt_array($ch, $options);
		if( ! $result = curl_exec($ch)) 
		{ 
		    trigger_error(curl_error($ch)); 
		}
		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch); 
		
		if ($code>=400) {
			if ($code==403) {
				return 'b';
			} else {
				return 'c'.$code;
			}
		} else {
			$new = json_decode($result);
			return $new->uniquestring;
		}
	}
	
	
	
	
	
	function cc($id = null) {
		$s = $this->Setting->find('first',array('order'=>'Setting.created ASC'));
							switch($s['Setting']['cc_processor']){
								case 'authnet':
									if($s['Setting']['authnet_loginID']==''||strlen($ds['Setting']['authnet_transkey'])!=16){
										$this->Session->setFlash('<strong>Error:</strong> Invalid credentials.');
										//$this->redirect('/payments/error/');
									}
									$this->Authnet->request['x_login']		=	$s['Setting']['authnet_loginID'];
									$this->Authnet->request['x_tran_key']		=	$s['Setting']['authnet_transkey'];
									$this->Authnet->request['x_card_num']		=	trim($this->data['Billing']['cc_number']);
									$this->Authnet->request['x_exp_date']		=	str_pad($this->data['Billing']['exp_date']['month'], 2, '0', STR_PAD_LEFT).substr($this->data['Billing']['exp_date']['year'],2,2);
									$this->Authnet->request['x_card_code']		=	$this->data['Billing']['cvv2'];
									$this->Authnet->request['x_amount']			=	$amount;
									$this->Authnet->request['x_description']	=	'SelectCollect';//whatever needs to go here to distinguish
									$this->Authnet->request['x_first_name']		=	$this->data['Billing']['first_name'];
									$this->Authnet->request['x_last_name']		=	$this->data['Billing']['last_name'];
									$response = $this->Authnet->makeRequest();
									if($response[0]=='1'){
										$payment['Payment']['debt_id'] = $this->data['Billing']['debt_id'];
										$payment['Payment']['payment_amount'] = $this->data['Billing']['amount'];
										$payment['Payment']['datetime'] = date('Y-m-d H:i:s');
										$payment['Payment']['comment'] = $response[6].' (Authorize.Net)';
										$payment['Payment']['type'] = 'cc';
										$this->Payment->save($payment);
										$payd = $this->Payment->getLastInsertId();
										if(number_format(($outstanding-$amount),2)=="0.00"){
											$this->Debt->updateAll(array('Debt.status' => '"paid"'),array('Debt.id' => $debtId));
										}
										//notify client
										$f = $this->User->find('first',array('order'=>'User.created ASC','conditions'=>array('User.company_id'=>$debt['Debt']['company_id'])));
										$this->Email->to = $f['User']['email'];
										//$this->Email->cc = 'info@selectcollect.net';
										$this->Email->subject = 'Payment Received';
										$this->Email->replyTo = 'info@selectcollect.net';
										$this->Email->from = 'SelectCollect <info@selectcollect.net>';
										$this->Email->template = 'client_receives_payment';
										$this->set('cname',$companyInfo['Company']['name']);
										$this->Email->sendAs = 'both';
										$this->Email->send();
										//notify debtor
										$q = $this->EmailAddress->find('all',array('conditions'=>array('EmailAddress.debtor_id'=>$debt['Debt']['debtor_id'],'EmailAddress.active'=>'active')));
										$o = count($q);
										$email = null;
										if($o!='0') {
											foreach ($q as $d) {
												if ($d['EmailAddress']['primary']=='true') {
													$email = $d['EmailAddress']['email_address'];
												}
											}
											if ($email==null) {
												$z = $this->EmailAddress->find('first',array('conditions'=>array('EmailAddress.debtor_id'=>$debt['Debt']['debtor_id'],'EmailAddress.active'=>'active')));
												$email = $z['EmailAddress']['email_address'];
											}
										}
										if ($email!=null) {
											$this->Email->to = $email;
											$this->Email->cc = 'info@selectcollect.net';
											$this->Email->subject = 'Payment Placed';
											$this->Email->replyTo = $f['User']['email'];
											$this->Email->from = 'SelectCollect <info@selectcollect.net>';
											$this->set('amount',$amount);
											$this->set('debt',$debt);
											$this->set('auth',$response[4]);
											$this->set('reply',$f['User']['email']);
											$this->set('now',date('d/m/Y',strtotime('now')));
											$t = $this->Url->find('first',array('conditions'=>array('Url.debtor_id'=>$debt['Debt']['debtor_id'])));
											if ($t['Url']['token']=='') {
												$this->set('url','payments/pay/'.$data['Company']['name']);
											} else {
												$this->set('url','urls/view/'.$t['Url']['token']);
											}
											$this->Email->template = 'debtor_payment_made'; 
											$this->Email->sendAs = 'both';
											$this->Email->send();
										}
										
										$this->Session->setFlash('<strong>Success:</strong> You made a payment of <strong>$'.$this->data['Billing']['amount'].'</strong>','messages/success');
										if ($this->Auth->user('role')=='admin' || $this->Auth->user('role')=='collector') {
											$this->redirect(array('controller' => 'debts', 'action' => 'view/'.$debtId));
										} else {
											$this->redirect(array('controller' => 'payments', 'action' => 'confirm/'.$companyInfo['Company']['name'].'/'.$payd));
										}
									}
									else{
										//die(pr($response));
										$this->Session->setFlash('<strong>Error:</strong> Payment failed to process. Please try again later or contact selectcollect.net.('.$response[3].')','messages/failure');
										if ($this->Auth->user('role')=='admin' || $this->Auth->user('role')=='collector') {
											$this->redirect(array('controller' => 'debts', 'action' => 'view/'.$debtId));
										} else {
											$this->redirect('/payments/error/'.$companyName);
										}
									}
									break;
									
								case 'wpp':
								if($debt['Company']['CompanyProfile']['paypal_wpp_username']==''||$debt['Company']['CompanyProfile']['paypal_wpp_password']==''||$debt['Company']['CompanyProfile']['paypal_wpp_signature']==''){
									$this->Session->setFlash('<strong>Error:</strong> '.$debt['Company']['name'].' is using invalid credentials. Try again later.','messages/failure');
									if ($this->Auth->user('role')=='admin' || $this->Auth->user('role')=='collector') {
											$this->redirect(array('controller' => 'debts', 'action' => 'view/'.$debtId));
										} else {
											$this->redirect('/payments/error/'.$companyName);
										}
								}
								$nvpReq = array(
									'PAYMENTACTION'		=>	'Sale',
									'IPADDRESS'			=>	$_SERVER['REMOTE_ADDR'],
									'CREDITCARDTYPE'	=>	$this->data['Billing']['cc_type'],
									'ACCT'				=>	trim($this->data['Billing']['cc_number']),
									'EXPDATE'			=>	str_pad($this->data['Billing']['exp_date']['month'], 2, '0', STR_PAD_LEFT).$this->data['Billing']['exp_date']['year'],
									'CVV2'				=>	$this->data['Billing']['cvv2'],
									'AMT'				=>	$this->data['Billing']['amount']
								);
								$nvpCreds = array(
									'api_user'			=>	$debt['Company']['CompanyProfile']['paypal_wpp_username'],
									'api_pwd'			=>	$debt['Company']['CompanyProfile']['paypal_wpp_password'],
									'api_sig'			=>	$debt['Company']['CompanyProfile']['paypal_wpp_signature']
								);
								$resp = $this->Paypal->call("DoDirectPayment", $nvpReq, $nvpCreds);
								if($resp['ACK']=='Success'){
									$payment['Payment']['debt_id'] = $this->data['Billing']['debt_id'];
									$payment['Payment']['payment_amount'] = $resp['AMT'];
									$payment['Payment']['datetime'] = date('Y-m-d H:i:s',strtotime($resp['TIMESTAMP']));
									$payment['Payment']['comment'] = $resp['TRANSACTIONID'].' (PayPal Website Payments Pro)';
									$payment['Payment']['type'] = 'cc';
									$this->Payment->save($payment);
									$payd = $this->Payment->getLastInsertId();
									if(number_format(($outstanding-$amount),2)=="0.00"){
										$this->Debt->updateAll(array('Debt.status' => '"paid"'),array('Debt.id' => $debtId));	
									}
									//notify client
									$f = $this->User->find('first',array('order'=>'User.created ASC','conditions'=>array('User.company_id'=>$debt['Debt']['company_id'])));
										$this->Email->to = $f['User']['email'];
										//$this->Email->cc = 'info@selectcollect.net';										
										$this->Email->subject = 'Payment Received';
										$this->Email->replyTo = 'info@selectcollect.net';
										$this->Email->from = 'SelectCollect <info@selectcollect.net>';
										$this->Email->template = 'client_receives_payment';
										$this->set('cname',$companyInfo['Company']['name']);
										$this->Email->sendAs = 'both';
										$this->Email->send();
										//notify debtor
										$q = $this->EmailAddress->find('all',array('conditions'=>array('EmailAddress.debtor_id'=>$debt['Debt']['debtor_id'],'EmailAddress.active'=>'active')));
										$o = count($q);
										$email = null;
										if($o!='0') {
											foreach ($q as $d) {
												if ($d['EmailAddress']['primary']=='true') {
													$email = $d['EmailAddress']['email_address'];
												}
											}
											if ($email==null) {
												$z = $this->EmailAddress->find('first',array('conditions'=>array('EmailAddress.debtor_id'=>$debt['Debt']['debtor_id'],'EmailAddress.active'=>'active')));
												$email = $z['EmailAddress']['email_address'];
											}
										}
										if ($email!=null) {
											$this->Email->to = $email;
											$this->Email->cc = 'info@selectcollect.net';
											$this->Email->subject = 'Payment Placed';
											$this->Email->replyTo = $f['User']['email'];
											$this->Email->from = 'SelectCollect <info@selectcollect.net>';
											$this->set('amount',$amount);
											$this->set('auth','');
											$this->set('debt',$debt);
											$this->set('reply',$f['User']['email']);
											$this->set('now',date('d/m/Y',strtotime('now')));
											$t = $this->Url->find('first',array('conditions'=>array('Url.debtor_id'=>$debt['Debt']['debtor_id'])));
											if ($t['Url']['token']=='') {
												$this->set('url','payments/pay/'.$data['Company']['name']);
											} else {
												$this->set('url','urls/view/'.$t['Url']['token']);
											}
											$this->Email->template = 'debtor_payment_made'; 
											$this->Email->sendAs = 'both';
											$this->Email->send();
										}
									$this->Session->setFlash('<strong>Success:</strong> You made a payment of <strong>$'.$resp['AMT'].'</strong>','messages/success');
									if ($this->Auth->user('role')=='admin' || $this->Auth->user('role')=='collector') {
											$this->redirect(array('controller' => 'debts', 'action' => 'view/'.$debtId));
										} else {
											$this->redirect(array('controller' => 'payments', 'action' => 'confirm/'.$companyInfo['Company']['name'].'/'.$payd));
										}
								}
								else{
									$this->Session->setFlash('<strong>Error:</strong> Payment failed to process. ('.$resp['L_ERRORCODE0'].': '.$resp['L_LONGMESSAGE0'].')','messages/failure');
									if ($this->Auth->user('role')=='admin' || $this->Auth->user('role')=='collector') {
											$this->redirect(array('controller' => 'debts', 'action' => 'view/'.$debtId));
										} else {
											$this->redirect('/payments/error/'.$companyName);
										}
								}
									break;
													
								default:
									$this->Session->setFlash('<strong>Error:</strong> '.$debt['Company']['name'].' is not setup for online credit card payments.','messages/failure');
									if ($this->Auth->user('role')=='admin' || $this->Auth->user('role')=='collector') {
											$this->redirect(array('controller' => 'debts', 'action' => 'view/'.$debtId));
										} else {
											$this->redirect('/payments/error/'.$companyName);
										}
									break;
							}
		}
    
}

?>