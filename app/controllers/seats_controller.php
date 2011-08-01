<?php
/*------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
-------------------------------------------------------------------------------*/
class SeatsController extends AppController {
 
	var $name = 'Seats';
        //var $layout = 'default';
	var $helpers = array('Html', 'Form', 'Time', 'javascript');
	var $uses = array('Seat','Item','Ticket','Category','Modifier','Setting','Discount');
	var $components = array('Auth','Session');
        
        function beforeFilter() {
            $this->Auth->allow('add');
        }
        
	
	function index () {
		//$this->set('types',$this->Type->find('all',array('order'=>'Type.name ASC')));
	}
	
	function add($id,$seats=null) {
            $this->layout = 'noheader';
		if (!empty($this->data)) {
			$price = $this->Item->find('list',array('fields'=>array('Item.price')));
			$mprice = $this->Modifier->find('list',array('fields'=>array('Modifier.price')));
			
			//set up discount check
			$disc = $this->Discount->find('all',array('conditions'=>array('Discount.enable'=>'1')));
			$dis_id = array();
			foreach ($disc as $d) {
				$dis_id[] = $d['Discount']['item_id'];
			}
			
			$co = 0;
			while ($co!=$seats) {
				$this->data['Seat'][$co]['ticket_id'] = $id;
				$this->data['Seat'][$co]['seat'] = $co+1;
				
				//calculate total
				$newt = rtrim($this->data['Seat'][$co]['items'],',');
				$new = explode(',',$newt);
				$total = 0;
				foreach ($new as $n) {
					//find item
					$first = strpos($n,'(');
					$th = substr($n,0,$first);
						
					if ($th=='' || $th==0) {
						//empty seat
						$total = '0.00';
					} else {
						//find mods for an item
						$mfirst = strpos($n,'(')+1;
						$m = substr($n,$mfirst,-1);
						$newm = explode(':',$m);
						$modextras = 0;
						foreach ($newm as $nm) {
							if ($nm!='') {
								if ($mprice[$nm]!=0.00) {
									$modextras += $mprice[$nm];
								}
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
						$total += $p;
					}
				}
				//save total with seat
				$this->data['Seat'][$co]['total'] = $total;
				$co++;
			}
			if ($this->Seat->saveAll($this->data['Seat'])) {
				//$this->_printtokitchen($id);
				$this->Session->setFlash('Ticket Submitted.');
				$this->redirect(array('controller'=>'tickets','action' => 'index'));
			} else {
				$this->Session->setFlash('Error: Failed to Save Ticket. (seats,add)');
			}
		} else {
			$this->set('id',$id);
			$this->set('seats',$seats);
			$this->Category->recursive = 2;
			$this->set('categories',$this->Category->find('all',array('conditions'=>array('Category.enable'=>'1'))));
			$this->set('ticket',$this->Ticket->findById($id));
			$this->set('types', $this->Ticket->Type->find('list',array('order'=>'Type.name ASC','conditions'=>array('Type.enable'=>'1'))));
			
			include("Mobile_Detect.php");
			$detect = new Mobile_Detect();
			if ($detect->isMobile()) {
				$this->layout = 'ios';
				$this->render('m.add');
			}
		}
	}
    
	function edit($id) {
            $this->layout = 'noheader';
		$ticket = $this->Ticket->findById($id);
		$find = $this->Seat->find('all',array('conditions'=>array('Seat.ticket_id'=>$id),'order'=>'Seat.seat ASC'));
		$num = count($find);
		
		//set up discount check
		$disc = $this->Discount->find('all',array('conditions'=>array('Discount.enable'=>'1')));
		$dis_id = array();
		foreach ($disc as $d) {
			$dis_id[] = $d['Discount']['item_id'];
		}
		
		if (!empty($this->data)) {
			$price = $this->Item->find('list',array('fields'=>array('Item.price')));
			$mprice = $this->Modifier->find('list',array('fields'=>array('Modifier.price')));
			
			$diff = array();
			$co = 0;
			while ($co!=$num) {
				$dat = array();
				$this->Seat->id = $this->data['Seat'][$co]['id'];
				$dat['Seat']['items'] = $this->data['Seat'][$co]['items'];
				
				//pull original to know what's new
				$old_pull = $this->Seat->findById($this->data['Seat'][$co]['id']);
				$newt = rtrim($old_pull['Seat']['items'],',');
				$old = explode(',',$newt);
				
				//calculate total
				$newt = rtrim($this->data['Seat'][$co]['items'],',');
				$new = explode(',',$newt);
				$total = 0;
				foreach ($new as $n) {
					//find item
					$first = strpos($n,'(');
					$th = substr($n,0,$first);
						
					if ($th=='' || $th==0) {
						//empty seat
						$total = '0.00';
					} else {
						//find mods for an item
						$mfirst = strpos($n,'(')+1;
						$m = substr($n,$mfirst,-1);
						$newm = explode(':',$m);
						$modextras = 0;
						foreach ($newm as $nm) {
							if ($nm!='') {
								if ($mprice[$nm]!=0.00) {
									$modextras += $mprice[$nm];
								}
							}
						}
						
						//check for discounts
						$p = 0;
						if (in_array($th,$dis_id)) {
							$dis = $this->Discount->find('all',array('conditions'=>array('Discount.item_id'=>$th)));
							$today = strtolower(date('l'));
							
							foreach ($dis as $di) {
								if ($di['Discount'][$today]=='1') {
									$time = mktime(date('h',strtotime($ticket['Ticket']['created'])),date('i',strtotime($ticket['Ticket']['created'])),0);
									if ($time>=strtotime($di['Discount']['start_time']) && $time<=strtotime($di['Discount']['end_time'])) {
										$p = $di['Discount']['price']+$modextras;
									}
								}
							}
						} 
						
						if ($p==0) {
							$p = $price[$th]+$modextras;
						}
						$total += $p;
					}
				}
				//save total with seat
				$dat['Seat']['total'] = $total;
				
				$this->Seat->save($dat);
				$this->Seat->id = false;
				
				//print new stuff
				$diff[$old_pull['Seat']['seat']] = array_diff($new,$old);
				
				$co++;
			}
			//print new stuff
			$this->_printedit($diff,$id);
			//die(print_r($diff));
			
			$this->Session->setFlash('Ticket Updated.');
			$this->redirect(array('controller'=>'tickets','action' => 'index'));
		} else {
			$this->set('id',$id);
			$this->set('seats',$num);
			$this->set('types', $this->Ticket->Type->find('list',array('order'=>'Type.name ASC','conditions'=>array('Type.enable'=>'1'))));
			
			if ($num==0) {
				$this->Session->setFlash('This ticket does not exist in the system.');
				$this->redirect(array('controller'=>'tickets','action' => 'index'));
			}
			$this->Category->recursive = 2;
			$this->set('categories',$this->Category->find('all',array('conditions'=>array('Category.enable'=>'1'))));
			
			//sets data for hidden form
			$data = array();
			$i = 0;
			foreach ($find as $f) {
				$data['Seat'][$i]['items'] = $f['Seat']['items'];
				$data['Seat'][$i]['id'] = $f['Seat']['id'];
				$i++;
			}
			$this->set('data',$data);
			
			//sets data for column view
			$items = $this->Item->find('list',array('fields'=>array('Item.name')));
			$price = $this->Item->find('list',array('fields'=>array('Item.price')));
			$mods = $this->Modifier->find('list',array('fields'=>array('Modifier.name')));
			$mprice = $this->Modifier->find('list',array('fields'=>array('Modifier.price')));
			
			$seats = array();
			$total = 0;
			foreach($find as $t) {
				$se = $t['Seat']['seat'];
				$seats[$se]['seat'] = $se;
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
							if ($nm!='') {
								$test[] = $mods[$nm];
								//die(print_r($mprice[$nm]));
								if ($mprice[$nm]!=0.00) {
									$modextras += $mprice[$nm];
								}
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
						
						//put array together
						$append=array($items[$th]=>array('mods'=>$test,'price'=>$p,'id'=>$th,'mo'=>$m));
						$seats[$se]['item'][]=$append;
						$total += $p;
					}
				}
			}
			$this->set('sts',$seats);
			$this->set('total',$total);
			$this->set('ticket',$this->Ticket->findById($id));
			//die(print_r($seats));
                        
                        include("Mobile_Detect.php");
			$detect = new Mobile_Detect();
			if ($detect->isMobile()) {
				$this->layout = 'ios';
				$this->render('m.edit');
			}
		}
	}
    
	function delete($id) {
		$userinfo = $this->Auth->user();
		if ($userinfo['User']['level']!='1') {
			$this->redirect(array('controller'=>'pages','action' => 'home'));
			$this->Session->setFlash('You Do Not Have Permission To Access This Page');
		}
		$this->Type->delete($id);
		$this->Session->setFlash('Ticket Type Successfully Deleted.');
		$this->redirect(array('action'=>'index'));
	}
	
	function reprint_kitchen($id) {
		if ($this->_printtokitchen($id)==true) {
			$this->Session->setFlash('Ticket reprinted.');
			$this->redirect(array('controller'=>'tickets','action' => 'view/'.$id));
		} else {
			$this->Session->setFlash('Error: Ticket reprint failed (seats,reprint_kitchen).');
			$this->redirect(array('controller'=>'tickets','action' => 'view/'.$id));
		}
	}
	
	function _printedit($diff,$id) {
		$ticket = $this->Ticket->findById($id);
		$items = $this->Item->find('list',array('fields'=>array('Item.name')));
		$print = $this->Item->find('list',array('fields'=>array('Item.kitchen_print')));
		$mods = $this->Modifier->find('list',array('fields'=>array('Modifier.name')));
		$settings = $this->Setting->find('first',array('order'=>'Setting.created ASC'));
		$seats = array();
		
		//Ubuntu
		$myFile = '/var/www/app/webroot/printer/kitchen_edit_'.$id.'.txt';
		//OS X dev
		//$myFile = '/Users/austin/Sites/barnespossystem/app/webroot/printer/kitchen_edit_'.$id.'.txt';
		$fh = fopen($myFile, 'w') or die("can't open file");
		
		if ($ticket['Type']['use_tables']=='1') {
			$string = $ticket['Type']['name']."\nTable: ".$ticket['Ticket']['table']."\nID: ".$ticket['Ticket']['dailyid']."\n".$ticket['User']['full_name'];
		} else {
			$string = $ticket['Type']['name']."\nID: ".$ticket['Ticket']['dailyid']."\n".$ticket['User']['full_name'];
		}
		
		if ($ticket['Type']['use_seats']=='1') {
			foreach($diff as $key=>$l) {
				$t = $this->Seat->find('first',array('conditions'=>array('Seat.seat'=>$key,'Seat.ticket_id'=>$id)));
				$se = $t['Seat']['seat'];
				$or = $t['Seat']['orig_seat'];
				$string = $string."\n\nSeat ".$se;
				if ($or!='0') {
					$string = $string." (originally ".$or.")";
				}
				$string = $string."\n";
				
				//$seats[$se]['seat'] = $se;
				//$seats[$se]['orig_seat'] = $or;
				
				//$newt = rtrim($l,',');
				//$new = explode(',',$newt);
				foreach ($l as $n) {
					//find item
					$first = strpos($n,'(');
					$th = substr($n,0,$first);
					
					//catch those not meant to print to kitchen
					//add to our string
						if ($th=='' || $th==0) {
							//empty seat
						} else {
							if ($print[$th]=='1') {
								$string = $string."  ".$items[$th]."\n";
								
								//find mods for an item
								$mfirst = strpos($n,'(')+1;
								$m = substr($n,$mfirst,-1);
								if (strlen($m)>0) {
									$newm = explode(':',$m);
									$string = $string."      ";
									$co = 1;
									foreach ($newm as $nm) {
										if ($nm!='') {
											//$sn = $co+1;
											if ($co%3==0) {
												$string = $string."\n      ";
											}
											$string=$string.$mods[$nm].", ";
											$co++;
										}
									}
									$string = rtrim($string,', ');
									$string = $string."\n";
							}
						}
					}
				}
				//$string = $string."\n";
			}
		} else {
			//$newt = rtrim($ticket['Seat'][0]['items'],',');
			//$new = explode(',',$newt);
				foreach ($l as $n) {
					//find item
					$first = strpos($n,'(');
					$th = substr($n,0,$first);
					
					//catch those not meant to print
						//add to our string
						if ($th=='' || $th==0) {
							//empty seat
							$string = $string."  empty\n\n";
						} else {
							if ($print[$th]=='1') {
								$string = $string."  ".$items[$th]."\n";
								
								//find mods for an item
								$mfirst = strpos($n,'(')+1;
								$m = substr($n,$mfirst,-1);
								if (strlen($m)>0) {
									$newm = explode(':',$m);
									$string = $string."      ";
									$co = 1;
									foreach ($newm as $nm) {
										if ($nm!='') {
											//$sn = $co+1;
											if ($co%3==0) {
												$string = $string."\n      ";
											}
											$string=$string.$mods[$nm].", ";
											$co++;
										}
									}
									$string = rtrim($string,', ');
									$string = $string."\n";
								}
							}
						}
				}
		}
		//finish file
		fwrite($fh, $string);		
		fclose($fh);
		chmod($myFile,0777);
		
		//set up print
		$STR = file_get_contents($myFile);
		$PRN = $settings['Setting']['kitchen_printer'];
		if ($STR!='') {
			$prn=(isset($PRN) && strlen($PRN))?"$PRN":C_DEFAULTPRN ;
			$CMDLINE="lpr -P $prn ";
			$pipe=popen("$CMDLINE" , 'w' );
			if (!$pipe) {print "pipe failed."; return ""; }
			fputs($pipe,$STR);
			pclose($pipe);
			
			//remove file
			unlink($myFile);
			return true;
		} else {
			//failed to create file
			return false;
		}
		
	}
	
	function _printtokitchen($id) {
		$ticket = $this->Ticket->findById($id);
		$items = $this->Item->find('list',array('fields'=>array('Item.name')));
		$print = $this->Item->find('list',array('fields'=>array('Item.kitchen_print')));
		$mods = $this->Modifier->find('list',array('fields'=>array('Modifier.name')));
		$settings = $this->Setting->find('first',array('order'=>'Setting.created ASC'));
		$seats = array();
		$sts = $this->Seat->find('all',array('conditions'=>array('Seat.ticket_id'=>$id),'order'=>'Seat.seat ASC'));
		
		//initialize file
		
		//Ubuntu
		$myFile = '/var/www/app/webroot/printer/kitchen_'.$id.'.txt';
		//OS X dev
		//$myFile = '/Users/Schwamm/Sites/barnespossystem/app/webroot/printer/kitchen_'.$id.'.txt';
		$fh = fopen($myFile, 'w') or die("can't open file");
		
		if ($ticket['Type']['use_tables']=='1') {
			$string = $ticket['Type']['name']."\nTable: ".$ticket['Ticket']['table']."\nID: ".$ticket['Ticket']['dailyid']."\n".$ticket['User']['full_name'];
		} else {
			$string = $ticket['Type']['name']."\nID: ".$ticket['Ticket']['dailyid']."\n".$ticket['User']['full_name'];
		}
		
		if ($ticket['Type']['use_seats']=='1') {
			foreach($sts as $t) {
				$se = $t['Seat']['seat'];
				$or = $t['Seat']['orig_seat'];
				$string = $string."\n\nSeat ".$se;
				if ($or!='0') {
					$string = $string." (originally ".$or.")";
				}
				$string = $string."\n";
				
				//$seats[$se]['seat'] = $se;
				//$seats[$se]['orig_seat'] = $or;
				
				$newt = rtrim($t['Seat']['items'],',');
				$new = explode(',',$newt);
				foreach ($new as $n) {
					//find item
					$first = strpos($n,'(');
					$th = substr($n,0,$first);
					
					//catch those not meant to print to kitchen
					if ($print[$th]=='1') {
						//add to our string
						if ($th=='' || $th==0) {
							//empty seat
							$string = $string."  empty\n\n";
						} else {
							$string = $string."  ".$items[$th]."\n";
							
							//find mods for an item
							$mfirst = strpos($n,'(')+1;
							$m = substr($n,$mfirst,-1);
							if (strlen($m)>0) {
								$newm = explode(':',$m);
								$string = $string."      ";
								$co = 1;
								foreach ($newm as $nm) {
									if ($nm!='') {
										//$sn = $co+1;
										if ($co%3==0) {
											$string = $string."\n      ";
										}
										$string=$string.$mods[$nm].", ";
										$co++;
									}
								}
								$string = rtrim($string,', ');
								$string = $string."\n";
							}
						}
					}
				}
				//$string = $string."\n";
			}
		} else {
			$newt = rtrim($ticket['Seat'][0]['items'],',');
				$new = explode(',',$newt);
				foreach ($new as $n) {
					//find item
					$first = strpos($n,'(');
					$th = substr($n,0,$first);
					
					//catch those not meant to print
					if ($print[$th]=='1') {
						//add to our string
						if ($th=='' || $th==0) {
							//empty seat
							$string = $string."  empty\n\n";
						} else {
							$string = $string."  ".$items[$th]."\n";
							
							//find mods for an item
							$mfirst = strpos($n,'(')+1;
							$m = substr($n,$mfirst,-1);
							if (strlen($m)>0) {
								$newm = explode(':',$m);
								$string = $string."      ";
								$co = 1;
								foreach ($newm as $nm) {
									if ($nm!='') {
										//$sn = $co+1;
										if ($co%3==0) {
											$string = $string."\n      ";
										}
										$string=$string.$mods[$nm].", ";
										$co++;
									}
								}
								$string = rtrim($string,', ');
								$string = $string."\n";
							}
						}
					}
				}
		}
		//finish file
		fwrite($fh, $string);		
		fclose($fh);
		chmod($myFile,0777);
		
		//set up print
		$STR = file_get_contents($myFile);
		$PRN = $settings['Setting']['kitchen_printer'];
		if ($STR!='') {
			$prn=(isset($PRN) && strlen($PRN))?"$PRN":C_DEFAULTPRN ;
			$CMDLINE="lpr -P $prn ";
			$pipe=popen("$CMDLINE" , 'w' );
			if (!$pipe) {print "pipe failed."; return ""; }
			fputs($pipe,$STR);
			pclose($pipe);
			
			//remove file
			unlink($myFile);
			return true;
		} else {
			//failed to create file
			return false;
		}
	}
}

?>