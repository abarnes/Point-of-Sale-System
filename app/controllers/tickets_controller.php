<?php
/*------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
-------------------------------------------------------------------------------*/
class TicketsController extends AppController {
 
	var $name = 'Tickets';
        //var $layout = 'default';
	var $uses = array('Ticket','Seat','Item','Modifier','Payment','Clock','Discount','User');
	var $helpers = array('Html', 'Form', 'Time', 'javascript');
	var $components = array('Auth','Session');
        
        function beforeFilter() {
            $this->Auth->allow('menu');
        }
        
	
	function index ($all=null) {
		//$this->layout = 'default_timeout';
		$userInfo = $this->Auth->user();
		if ($all=='all'){
			$conditions = array();
			$this->set('all','1');
		} else {
			$conditions = array('Ticket.user_id'=>$userInfo['User']['id'],'Ticket.status <'=>'2');
			$this->set('all','0');
		}
		$this->paginate = array('limit' => 18,'conditions'=>$conditions);
			$tickets = $this->paginate('Ticket');
			if (count($tickets)==0){
				$this->Session->setFlash('You don\'t have any open tickets in the system.');
			}
		$this->set(compact('tickets'));
		include("Mobile_Detect.php");
		$detect = new Mobile_Detect();
		if ($detect->isMobile()) {
			$this->layout = 'ios';
			$this->render('m.index');
		}
	}
	
	function menu() {
                $this->layout = 'default_timeout';
                $userInfo = $this->Auth->user();
                if (isset($userInfo['User'])) {
                    $this->set('login','0');
                    $this->set('id',$userInfo['User']['id']);
                } else {
                    $this->set('login','1');
                }
            
		include("Mobile_Detect.php");
		$detect = new Mobile_Detect();
		if ($detect->isMobile()) {
			$this->layout = 'ios';
			$this->render('m.menu');
		}
	}
	
	function add($step=null,$type=null,$table=null) {
		$userInfo = $this->Auth->user();
		if ($step==null) {
			$this->set('types', $this->Ticket->Type->find('all',array('order'=>'Type.name ASC','conditions'=>array('Type.enable'=>'1'))));
			include("Mobile_Detect.php");
			$detect = new Mobile_Detect();
			if ($detect->isMobile()) {
				$this->layout = 'ios';
				$this->render('m.add');
			}
		} elseif ($step=='1') {
			$t = $this->Ticket->Type->findById($type);
			//check if it needs seats or table
			if ($t['Type']['use_seats']=='0' && $t['Type']['use_tables']=='0') {
				//save now
				if ($this->Ticket->find('count')!=0) {
					$last = $this->Ticket->find('first',array('order'=>'Ticket.created DESC'));
					$dayid = $last['Ticket']['dailyid']+1;
				} else {
					$dayid = 1;
				}
				$this->data['Ticket']['type_id']=$type;
				$this->data['Ticket']['dailyid'] = $dayid;
				$this->data['Ticket']['user_id'] = $userInfo['User']['id'];
				if ($this->Ticket->save($this->data)) {
					$this->Session->setFlash('Ticket Saved.');
					$num = $this->Ticket->find('first',array('order'=>'Ticket.created DESC','conditions'=>array('Ticket.dailyid'=>$dayid)));
					$id = $num['Ticket']['id'];
					$this->redirect(array('controller'=>'seats','action' => 'add/'.$id.'/1'));
				} else {
					$this->Session->setFlash('Error: Failed to Save Ticket (tickets,add,1)');
				}
			} elseif ($t['Type']['use_seats']=='1' && $t['Type']['use_tables']=='0') {
				$this->set('step','3');	
				$this->set('type',$type);
				$this->set('table',null);
				include("Mobile_Detect.php");
				$detect = new Mobile_Detect();
				if ($detect->isMobile()) {
					$this->layout = 'ios';
					$this->render('m.add');
				}
			} else {
				$this->set('step','2');	
				$this->set('type',$type);
				include("Mobile_Detect.php");
				$detect = new Mobile_Detect();
				if ($detect->isMobile()) {
					$this->layout = 'ios';
					$this->render('m.add');
				}
			}
		} elseif ($step=='2') {
			//table is set
			$t = $this->Ticket->Type->findById($type);
			if ($t['Type']['use_seats']=='0') {
				if (!empty($this->data)) {
					if ($this->Ticket->find('count')!=0) {
						$last = $this->Ticket->find('first',array('order'=>'Ticket.created DESC'));
						$dayid = $last['Ticket']['dailyid']+1;
					} else {
						$dayid = 1;
					}
					$this->data['Ticket']['type_id']=$type;
					$this->data['Ticket']['dailyid'] = $dayid;
					$this->data['Ticket']['user_id'] = $userInfo['User']['id'];
					if ($this->Ticket->save($this->data)) {
						$this->Session->setFlash('Ticket Saved.');
						$num = $this->Ticket->find('first',array('order'=>'Ticket.created DESC','conditions'=>array('Ticket.dailyid'=>$dayid)));
						$id = $num['Ticket']['id'];
						$this->redirect(array('controller'=>'seats','action' => 'add/'.$id.'/1'));
					} else {
						$this->Session->setFlash('Error: Failed to Save Ticket (tickets,add,2)');
					}
				}
			} else {
				$this->set('step','3');	
				$this->set('type',$type);
				$this->set('table',$this->data['Ticket']['table']);
				include("Mobile_Detect.php");
				$detect = new Mobile_Detect();
				if ($detect->isMobile()) {
					$this->layout = 'ios';
					$this->render('m.add');
				}
			}	
		} elseif ($step=='3') {
			if (!empty($this->data)) {
				if ($this->Ticket->find('count')!=0) {
					$last = $this->Ticket->find('first',array('order'=>'Ticket.created DESC'));
					$dayid = $last['Ticket']['dailyid']+1;
				} else {
					$dayid = 1;
				}
				$this->data['Ticket']['type_id'] = $type;
				$this->data['Ticket']['table'] = $table;
				$this->data['Ticket']['dailyid'] = $dayid;
				$this->data['Ticket']['user_id'] = $userInfo['User']['id'];
				if ($this->Ticket->save($this->data)) {
					$this->Session->setFlash('Ticket Saved.');
					$num = $this->Ticket->find('first',array('order'=>'Ticket.created DESC','conditions'=>array('Ticket.dailyid'=>$dayid)));
					$id = $num['Ticket']['id'];
					$this->redirect(array('controller'=>'seats','action' => 'add/'.$id.'/'.$this->data['Ticket']['seats']));
				} else {
					$this->Session->setFlash('Error: Failed to Save Ticket (tickets,add,3)');
				}
			}	
		}
	}
	
	function edit($id,$add=null) {
		$userInfo = $this->Auth->user();
		
		if (!empty($this->data)) {
                    if ($add==null) {
                        $action = 'edit/'.$id;
                    } else {
                        $action = 'add/'.$id.'/'.$this->data['Ticket']['seats'];
                    }
			
			//change number of seats, if necessary
			$co = $this->Ticket->Seat->find('count',array('conditions'=>array('Seat.ticket_id'=>$id)));
			if ($this->data['Ticket']['seats']!=$co) {
				if ($this->data['Ticket']['seats']<$co) {
					$this->Session->setFlash('You may not reduce the number of seats in this form.');
					$this->redirect(array('controller'=>'seats','action' => $action));
				} else {
					$diff = $this->data['Ticket']['seats']-$co;
					$i = 0;
					while($i!=$diff) {
						$data = array();
						$data['Seat']['ticket_id']=$id;
						$data['Seat']['seat']=$i+$co+1;
						$this->Ticket->Seat->create();
						$this->Ticket->Seat->save($data);
						$i++;
						unset($data);
					}
				}
			}
			
			//make sure that type supports seats
			$type = $this->Ticket->Type->findById($this->data['Ticket']['type_id']);
			if ($type['Type']['use_seats']!='1' && $this->data['Ticket']['seats']>1) {
				$this->Session->setFlash('You may not change the ticket to a type that does not support seats when you have more than 1 seat.');
				$this->redirect(array('controller'=>'seats','action' => $action));
			}
			
			//save data
			$this->Ticket->id = $id;
			if ($this->Ticket->save($this->data)) {
				$this->Session->setFlash('Ticket Updated.');
				//$num = $this->Ticket->find('first',array('order'=>'Ticket.created DESC','conditions'=>array('Ticket.dailyid'=>$dayid)));
				//$id = $num['Ticket']['id'];
				$this->redirect(array('controller'=>'seats','action' => $action));
			} else {
				$this->Session->setFlash('Error: Failed to Save Ticket (tickets,edit)');
				$this->redirect(array('controller'=>'seats','action' => $action));
			}
		} else {
			$this->data = $this->Ticket->read();
			//function shouldn't be accessed directly, no view
			$this->Session->setFlash('Error: This function cannot be accessed directly. (tickets,edit)');
			$this->redirect(array('controller'=>'tickets','action' => 'index'));
		}
	}
	
	function view($id) {
		$ticket = $this->Ticket->findById($id);
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
		
		$seats = array();
		$sts = $this->Seat->find('all',array('conditions'=>array('Seat.ticket_id'=>$ticket['Ticket']['id']),'order'=>'Seat.seat ASC'));
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

		$this->set('total',$total);
		$this->set('ticket',$ticket);
		$this->set('seats',$seats);
		
		include("Mobile_Detect.php");
		$detect = new Mobile_Detect();
		if ($detect->isMobile()) {
			$this->layout = 'ios';
			$this->render('m.view');
		}
	}
        
        function inc_delete($id) {
            if ($this->Ticket->delete($id)) {
                $this->Session->setFlash('Ticket Successfully Deleted.');
		$this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash('Error Deleting Ticket (tickets,inc_delete');
		$this->redirect(array('action'=>'index'));
            }
        }
    
	function delete($id,$redirect=null) {
		$userinfo = $this->Auth->user();
		if ($userinfo['User']['level']!='1') {
			$this->redirect(array('controller'=>'pages','action' => 'home'));
			$this->Session->setFlash('You Do Not Have Permission To Access This Page');
		}
		$this->Ticket->delete($id);
		
		//delete those seats
		$seats = $this->Ticket->Seat->find('all',array('conditions'=>array('Seat.ticket_id'=>$id)));
		$payments = $this->Payment->find('all',array('conditions'=>array('Payment.ticket_id'=>$id)));
		foreach ($payments as $p) {
			$this->Payment->delete($p['Payment']['id']);
		}
		foreach ($seats as $s) {
			$this->Ticket->Seat->delete($s['Seat']['id']);
		}
		
		$this->Session->setFlash('Ticket Successfully Deleted.');
		if ($redirect==null || $redirect=='0') {
			$this->redirect(array('action'=>'index'));	
		} else {
			$this->redirect(array('action'=>'index/all'));
		}
	}
	
	//records functions
	function record_index () {
		$this->Ticket->setDataSource('alternate');
		$this->Seat->setDataSource('alternate');
		$this->Payment->setDataSource('alternate');
		
		if (empty($this->data)) {
			$this->paginate = array('limit' => 25);
			$tickets = $this->paginate('Ticket');
			if (count($tickets)==0){
				$this->Session->setFlash('No Results');
			}
			$this->set(compact('tickets'));
		} else {
			$conditions = array();
			//die(print(strtotime($this->data['Ticket']['date'])));
			
			if($this->data['Ticket']['server']!='') {
				$u = $this->User->findByUsername($this->data['Ticket']['server']);
				$conditions['Ticket.user_id']=$u['User']['id'];
			}
			
			if($this->data['Ticket']['date']!='') {
				$conditions['Ticket.created BETWEEN ? AND ?']=array(date('Y-m-d',strtotime($this->data['Ticket']['date'])),date('Y-m-d',strtotime($this->data['Ticket']['date'])+86400));
			}
			
			if ($this->data['Ticket']['table']!=''){
				$conditions['Ticket.table']=$this->data['Ticket']['table'];
			}
			
			if ($this->data['Ticket']['dailyid']!=''){
				$conditions['Ticket.dailyid']=$this->data['Ticket']['dailyid'];
			}
			//die(print_r($conditions));
			$this->paginate = array('limit' => 25,'conditions'=>$conditions);
			$tickets = $this->paginate('Ticket');
			if (count($tickets)==0){
				$this->Session->setFlash('No Results');
			}
			$this->set(compact('tickets'));
		}
	}
	
	function record_view($id,$red=null) {
		$this->Ticket->setDataSource('alternate');
		$this->Seat->setDataSource('alternate');
		$this->Payment->setDataSource('alternate');
		
		if ($red!=null) {
			$this->set('red','payments');
		} else {
			$this->set('red','records');
		}
		
		$ticket = $this->Ticket->findById($id);
		$items = $this->Item->find('list',array('fields'=>array('Item.name')));
		$price = $this->Item->find('list',array('fields'=>array('Item.price')));
		$mods = $this->Modifier->find('list',array('fields'=>array('Modifier.name')));
		$mprice = $this->Modifier->find('list',array('fields'=>array('Modifier.price')));
		$seats = array();
		$sts = $this->Seat->find('all',array('conditions'=>array('Seat.ticket_id'=>$ticket['Ticket']['id']),'order'=>'Seat.seat ASC'));
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
						if ($nm!='') {
							$test[] = $mods[$nm];
							//die(print_r($mprice[$nm]));
							if ($mprice[$nm]!=0.00) {
								$modextras += $mprice[$nm];
							}
						}
					}
					$p = $price[$th]+$modextras;
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

		$this->set('total',$total);
		$this->set('ticket',$ticket);
		$this->set('seats',$seats);
		
	}
    
	function record_delete($id) {
		$this->Ticket->setDataSource('alternate');
		$this->Seat->setDataSource('alternate');
		$this->Payment->setDataSource('alternate');
		
		$userinfo = $this->Auth->user();
		if ($userinfo['User']['level']!='1') {
			$this->redirect(array('controller'=>'pages','action' => 'home'));
			$this->Session->setFlash('You Do Not Have Permission To Access This Page');
		}
		$this->Ticket->delete($id);
		
		//delete those seats
		$seats = $this->Ticket->Seat->find('all',array('conditions'=>array('Seat.ticket_id'=>$id)));
		$payments = $this->Payment->find('all',array('conditions'=>array('Payment.ticket_id'=>$id)));
		foreach ($payments as $p) {
			$this->Payment->delete($p['Payment']['id']);
		}
		foreach ($seats as $s) {
			$this->Ticket->Seat->delete($s['Seat']['id']);
		}
		
		$this->Session->setFlash('Ticket Successfully Deleted.');
		$this->redirect(array('action'=>'record_index'));
	}
	//end records functions
	
	//combines tickets
	function combine() {
		//build an array of each selected ticket
		$arr = array();
		foreach ($this->data['Ticket'] as $row=>$data) {
			if ($data == 1) {
				$arr[]=$row;
			}
		}
		
		//make sure there is more than one ticket selected, not too many
		if (count($arr)<2) {
			$this->Session->setFlash('Error: You must select more than one ticket to combine');
			$this->redirect(array('controller'=>'tickets','action' => 'index'));
		}
		
		if (count($arr)>99) {
			$this->Session->setFlash('Error: You may not select over 99 tickets to combine');
			$this->redirect(array('controller'=>'tickets','action' => 'index'));
		}
		
		//make sure they're either submitted or prepared
		$errors = array();
		$stats = array();
		$table = array();
		$total = 0;
		foreach ($arr as $a) {
			$search = $this->Ticket->findById($a);
			if ($search['Ticket']['status']>1) {
				$errors[]=$search['Ticket']['dailyid'];
			}
			//check for unprepared tickets
			if ($search['Ticket']['status']==0) {
				$stats[]=$search['Ticket']['dailyid'];
			}
			//generate list of tables
			$table[] = $search['Ticket']['table'];
			//total the amounts
			$total = $total+$search['Ticket']['amount'];
		}
		$tables = array_unique($table);
		
		//die(print_r($errors));
		if (count($errors)!=0) {
			$this->Session->setFlash('Error: The following ticket(s) are paid or otherwise void: '.implode(', ',$errors));
			$this->redirect(array('controller'=>'tickets','action' => 'index'));
		}
		
		//pull data on each ticket
		$num=0;
		$newdata = array();
		$ticket = array();
		foreach ($arr as $a) {
			$tic[$num] = $this->Ticket->findById($a);
			$num++;
		}
		
		//set new data
		$newdata['Ticket']['dailyid'] = $tic[0]['Ticket']['dailyid'];
		$newdata['Ticket']['user_id'] = $tic[0]['Ticket']['user_id'];
		$newdata['Ticket']['type_id'] = $tic[0]['Ticket']['type_id'];
		$newdata['Ticket']['pay_method'] = '';
		$newdata['Ticket']['amount'] = $total;
		$newdata['Ticket']['table'] = implode('+',$tables);
		if (count($stats)!=0) {
			$newdata['Ticket']['status'] = '0';
		} else {
			$newdata['Ticket']['status'] = '1';
		}
		
		//save the data as a new ticket
		if ($this->Ticket->save($newdata)) {
			//find new ticket's ID
			$ti = $this->Ticket->find('first',array('order'=>'Ticket.created DESC','conditions'=>array('Ticket.dailyid'=>$tic[0]['Ticket']['dailyid'])));
			$ticketid = $ti['Ticket']['id'];
			
			//change all the seats
			$already = array();
			$seats = $this->Ticket->Seat->find('all',array('conditions'=>array('Seat.ticket_id'=>$arr),'order'=>'Seat.ticket_id ASC'));
			foreach ($seats as $s) {
				if (in_array($s['Seat']['seat'],$already)) {
					$new = $s['Seat']['seat'];
					$orig = $new;
					while (in_array($new,$already)) {
						$new++; 
					}
					$already[] = $new;
				} else {
					$already[] = $s['Seat']['seat'];
					$new = $s['Seat']['seat'];
					$orig = $new;
				}
				
				$this->Ticket->Seat->id = $s['Seat']['id'];
				$saveseat['Seat']['ticket_id'] = $ticketid;
				$saveseat['Seat']['seat'] = $new;
				$saveseat['Seat']['orig_seat'] = $orig;
				$this->Ticket->Seat->save($saveseat);
				$this->Ticket->Seat->id = false;
			}
			
			//delete old tickets
			foreach ($arr as $a) {
				$this->Ticket->delete($a);
			}
			
			//redirect
			$this->Session->setFlash('Tickets combined with ID #'.$tic[0]['Ticket']['dailyid']);
			$this->redirect(array('controller'=>'tickets','action' => 'index'));
		} else {
			$this->Session->setFlash('Error: Could not save new ticket.');
			$this->redirect(array('controller'=>'tickets','action' => 'index'));
		}
	}
	
	//split ticket into individual seats
	function split_indiv($id) {
		$ticket = $this->Ticket->findById($id);
		//check status
		if ($ticket['Ticket']['status']>1) {
			$this->Session->setFlash('Error: This ticket has already been paid of is otherwise void.');
			$this->redirect(array('controller'=>'tickets','action' => 'index'));
		}
		
		//set new variables
		$orig_id = $ticket['Ticket']['id'];
		$orig_daily = $ticket['Ticket']['dailyid'];
		$user_id = $ticket['Ticket']['user_id'];
		$status = $ticket['Ticket']['status'];
		$table = $ticket['Ticket']['table'];
		$type = $ticket['Ticket']['type_id'];
		
		//cycle through seats and create new tickets
		$tics = array();
		$last = $this->Ticket->find('first',array('order'=>'Ticket.created DESC'));
		$dayid = $last['Ticket']['dailyid']+1;
		foreach ($ticket['Seat'] as $s) {
			$newdata = array();
			//create new ticket
			$this->Ticket->create();
			$newdata['Ticket']['original_id'] = $orig_id;
			$newdata['Ticket']['original_daily_id'] = $orig_daily;
			$newdata['Ticket']['user_id'] = $user_id;
			$newdata['Ticket']['status'] = $status;
			$newdata['Ticket']['table'] = $table;
			$newdata['Ticket']['type_id'] = $type;
			$newdata['Ticket']['dailyid'] = $dayid;
			$this->Ticket->save($newdata);
			$this->Ticket->id = false;
			
			$get = $this->Ticket->find('first',array('order'=>'Ticket.created DESC','conditions'=>array('Ticket.original_id'=>$orig_id,'Ticket.original_daily_id'=>$orig_daily,'Ticket.user_id'=>$user_id)));;
			$newticket = $get['Ticket']['id'];
			$tics[] = $get['Ticket']['dailyid'];
			
			//update seat
			$newseat = array();
			$this->Ticket->Seat->id = $s['id'];
			$newseat['Seat']['ticket_id'] = $newticket;
			$this->Ticket->Seat->save($newseat);
			$this->Ticket->Seat->id = false;
			
			unset($get);
			unset($newseat);
			unset($newdata);
			unset($last);
			$dayid++;
		}
		
		if ($this->Ticket->delete($id)) {
			$this->Session->setFlash('Ticket Successfully Split.  New IDs: '.implode(', ',$tics));
			$this->redirect(array('controller'=>'tickets','action' => 'index'));
		} else {
			$this->Session->setFlash('Error: Could not delete original ticket.');
			$this->redirect(array('controller'=>'tickets','action' => 'index'));
		}
	}
	
	//split ticket into groups
	function split($id) {
		$this->set('id',$id);
		$this->set('seatnum',$this->Ticket->Seat->find('count',array('conditions'=>array('Seat.ticket_id'=>$id))));
		
		$ticket = $this->Ticket->findById($id);
		$oid = $ticket['Ticket']['dailyid'];
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
		
		$seats = array();
		$sts = $this->Seat->find('all',array('conditions'=>array('Seat.ticket_id'=>$ticket['Ticket']['id']),'order'=>'Seat.seat ASC'));
		//pull data on individual orders and build array
		$total = 0;
		foreach($sts as $t) {
			$se = $t['Seat']['seat'];
			$or = $t['Seat']['orig_seat'];
			$pr = $t['Seat']['total'];
			$seats[$se]['seat'] = $se;
			$seats[$se]['orig_seat'] = $or;
			$sp = explode('.',$t['Seat']['total']);
			if (strlen($sp[1])==1) {
				$pr = $pr.'0';
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
					
					$sp = explode('.',$p);
					if (strlen($sp[1])==1) {
						$p = $p.'0';
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
		if (strlen($sp[1])==1) {
			$total = $total.'0';
		}

		$this->set('total',$total);
		$this->set('ticket',$ticket);
		$this->set('seats',$seats);
		
		if (!empty($this->data)) {
			/*foreach($this->data['Ticket'] as $t) {
				echo $t.'<br/>';
			}
			die(print_r($this->data));*/
			$tics = array();
			foreach($this->data['Ticket'] as $t) {
				if ($t!='') {
					$sts = explode(',',substr($t,0,-1));
					
					//set new variables
					$orig_id = $ticket['Ticket']['id'];
					$orig_daily = $ticket['Ticket']['dailyid'];
					$user_id = $ticket['Ticket']['user_id'];
					$status = $ticket['Ticket']['status'];
					$table = $ticket['Ticket']['table'];
					$type = $ticket['Ticket']['type_id'];
					
					//cycle through seats and create new tickets
					$last = $this->Ticket->find('first',array('order'=>'Ticket.created DESC'));
					$dayid = $last['Ticket']['dailyid']+1;
					
					$newdata = array();
					//create new ticket
					$this->Ticket->create();
					$newdata['Ticket']['original_id'] = $orig_id;
					$newdata['Ticket']['original_daily_id'] = $orig_daily;
					$newdata['Ticket']['user_id'] = $user_id;
					$newdata['Ticket']['status'] = $status;
					$newdata['Ticket']['table'] = $table;
					$newdata['Ticket']['type_id'] = $type;
					$newdata['Ticket']['dailyid'] = $dayid;
					$this->Ticket->save($newdata);
					$this->Ticket->id = false;
					$sid = $this->Ticket->getLastInsertID();
					//die(print($sid));

					$tics[] = $dayid;
					
					foreach ($sts as $s) {
						$get = $this->Seat->find('first',array('conditions'=>array('Seat.ticket_id'=>$id,'Seat.seat'=>$s),'order'=>'Seat.created DESC'));
						
						//update seat
						$newseat = array();
						$this->Ticket->Seat->id = $get['Seat']['id'];
						$newseat['Seat']['ticket_id'] = $sid;
						$this->Ticket->Seat->save($newseat);
						$this->Ticket->Seat->id = false;
						
						unset($newseat);
					}
					unset($last);
					unset($newdata);
					unset($sid);
					unset($newticket);
					unset($sts);
					$dayid++;
				}
			}
			if ($this->Ticket->delete($id)) {
				$this->Session->setFlash('Ticket Successfully Split.  New IDs: '.implode(', ',$tics));
				$this->redirect(array('controller'=>'tickets','action' => 'index'));
			} else {
				$this->Session->setFlash('Error: Could not delete original ticket.');
				$this->redirect(array('controller'=>'tickets','action' => 'index'));
			}
		}
		
	}
	
	function backup() {
		$conditions = array('Ticket.status >'=>'1','Ticket.created <'=>date('Y-m-d',time()));
		$all = $this->Ticket->find('all',array('conditions'=>$conditions));
		$conditions = array('Clock.complete'=>'1','Clock.in <'=>date('Y-m-d',time()));
		$clocks = $this->Clock->find('all',array('conditions'=>$conditions));
		
		//change database to records
		$this->Ticket->setDataSource('alternate');
		$this->Seat->setDataSource('alternate');
		$this->Payment->setDataSource('alternate');
		$this->Clock->setDataSource('alternate');
		
		//save in new database
		foreach($all as $a) {
			$this->Ticket->create();
			$this->Ticket->saveAll($a);
		}
		
		foreach($clocks as $c) {
			$this->Clock->create();
			$this->Clock->save($c);
		}
		
		//change it back
		$this->Ticket->setDataSource('default');
		$this->Seat->setDataSource('default');
		$this->Payment->setDataSource('default');
		$this->Clock->setDataSource('default');
		
		//delete old records
		foreach ($clocks as $c) {
			$this->Clock->delete($c['Clock']['id']);
		}
		foreach ($all as $a) {
			$this->Ticket->delete($a['Ticket']['id'],true);
		}
	}
	
	/*
	function printticket($id,$PRN=null) {
		$STR = file_get_contents('/var/www/app/webroot/printer/kitchen_'.$id.'.txt');
		if ($STR!='') {
			$prn=(isset($PRN) && strlen($PRN))?"$PRN":C_DEFAULTPRN ;
			$CMDLINE="lpr -P $prn ";
			$pipe=popen("$CMDLINE" , 'w' );
			if (!$pipe) {print "pipe failed."; return ""; }
			fputs($pipe,$STR);
			pclose($pipe);
		}
	}*/
    
}

?>