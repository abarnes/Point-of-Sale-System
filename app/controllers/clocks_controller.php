<?php
/*------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
-------------------------------------------------------------------------------*/
class ClocksController extends AppController {
 
	var $name = 'Clocks';
        //var $layout = 'default';
	var $helpers = array('Html', 'Form', 'Time', 'javascript');
	var $uses = array('Clock','Ticket','User','Seat','Payment');
	var $components = array('Auth','Session');
        
        function beforeFilter() {
            //$this->Auth->allow('login','add','view','loading','setup');
        }
	
	function index($all=null) {
		$userInfo = $this->Auth->user();
		if ($userInfo['User']['level']!='1') {
			$this->Session->setFlash('This Action Is Restricted To Administrators. Please Authenticate As An Administrator And Try Again.');
			$this->redirect(array('controller'=>'users','action'=>'login'));
		}
		
		//$clocks = $this->Clock->find('all',array('conditions'=>array('Clock.created >'=>date('Y-m-d', strtotime("-1 day")))));
		if ($all=='all'){
			$conditions = array('Clock.created >'=>date('Y-m-d', strtotime("-1 day")));
			$this->set('all','1');
		} else {
			$conditions = array('Clock.complete'=>'0','Clock.created >'=>date('Y-m-d', strtotime("-1 day")));
			$this->set('all','0');
		}
		$this->paginate = array('limit' => 18,'conditions'=>$conditions);
		$clocks = $this->paginate('Clock');
	
		$i = 0;
		$tc = 0;
		$secs = 0;
		foreach ($clocks as $a) {
			if ($a['Clock']['complete']=='1') {
				//$['time']=$this->_timeBetween(strtotime($a['Clock']['in']),strtotime($a['Clock']['out']));
				//$this->virtualFields['cst']=$a['Clock']['cost'];
				$clocks[$i]['Clock']['time']=$this->_timeBetween(strtotime($a['Clock']['in']),strtotime($a['Clock']['out']));
				$clocks[$i]['Clock']['cst']=$a['Clock']['cost'];
				$tc = $tc+$a['Clock']['cost'];
				$r = strtotime($a['Clock']['out'])-strtotime($a['Clock']['in']);
				$secs = $secs+$r;
			} else {
				$clocks[$i]['Clock']['time']=$this->_timeBetween(strtotime($a['Clock']['in']),time());
				$diff = time()-strtotime($a['Clock']['in']);
				$time = $diff/3600;
				$cost = round($time*$a['Clock']['rate'],'2');
				$sp = explode('.',$cost);
				if (isset($sp[1])) {
					if (strlen($sp[1])==1) {
						$cost = $cost.'0';
					}
				} else {
					$cost = $cost.'.00';
				}
				$clocks[$i]['Clock']['cst']=$cost;
				$tc = $tc+$cost;
				$secs = $secs+$diff;
			}
			$i++;
		}
		$this->set('clocks',$clocks);
		$sp = explode('.',$tc);
		if (isset($sp[1])) {
			if (strlen($sp[1])==1) {
				$tc = $tc.'0';
			}
		} else {
			$tc = $tc.'.00';
		}
		$this->set('tc',$tc);
		$secs = $secs/3600;
		$this->set('tt',round($secs,'2'));
		
		//$this->Ticket->recursive = 2;
		$tic = $this->Ticket->find('all',array('conditions'=>array('Ticket.created >'=>date('Y-m-d', strtotime("-1 day")))));
		//die(print_r($tic));
		$ts = 0;
		$co = 0;
		foreach ($tic as $t) {
			foreach ($t['Seat'] as $s) {
				$ts = $ts+$s['total'];
				$co++;
			}
		}
		//die($ts);
		$this->set('ts',$ts);
		$this->set('co',$co);
		$this->set('ti',count($tic));
	}
	
	function shift() {
		$userInfo = $this->Auth->user();
		$id = $userInfo['User']['id'];
		if ($userInfo['User']['level']!='1' && $id!=$userInfo['User']['id']) {
			$this->Session->setFlash('This Action Is Restricted To Administrators. Please Authenticate As An Administrator And Try Again.');
			$this->redirect(array('controller'=>'users','action'=>'login'));
		}
		$this->set('user',$this->User->findById($id));
			
			$a = $this->Clock->find('first',array('conditions'=>array('Clock.user_id'=>$id,'Clock.complete'=>'0'),'order'=>'Clock.in DESC'));
			
			$seats = $this->Ticket->find('all',array('conditions'=>array('Ticket.user_id'=>$id,'Ticket.created >'=>date('Y-m-d H:i:s',strtotime($a['Clock']['in'])))));
			$ids = $this->Ticket->find('list',array('fields'=>array('Ticket.id'),'conditions'=>array('Ticket.user_id'=>$id,'Ticket.created >'=>date('Y-m-d H:i:s',strtotime($a['Clock']['in'])))));
			$p = $this->Payment->find('all',array('conditions'=>array('Payment.ticket_id'=>$ids)));
			
			$cctips = 0;
			foreach ($p as $p) {
				$cctips = $cctips+$p['Payment']['tip'];
			}
			$sp = explode('.',$cctips);
			if (isset($sp[1])) {
				if (strlen($sp[1])==1) {
					$cctips = $cctips.'0';
				}
			} else {
				$cctips = $cctips.'.00';
			}
			
			//add data for shift
			$a['Clock']['cctips'] = $cctips;
			$a['Clock']['time']=$this->_timeBetween(strtotime($a['Clock']['in']),time());
			$diff = time()-strtotime($a['Clock']['in']);
			$hours = $a['Clock']['time']/3600;
			if ($userInfo['User']['rate1']==$a['Clock']['rate']) {
				$a['Clock']['rt'] = 'Rate 1';
			} elseif ($userInfo['User']['rate2']==$a['Clock']['rate']) {
				$a['Clock']['rt'] = 'Rate 2';
			} elseif ($userInfo['User']['rate3']==$a['Clock']['rate']) {
				$a['Clock']['rt'] = 'Rate 3';
			} else {
				$a['Clock']['rt'] = 'Other';
			}
		
		//calculate sales statistics, etc.
		$total = 0;
		$tickets = 0;
		$customers = 0;
		foreach ($seats as $t) {
			foreach ($t['Seat'] as $s) {
				$total=$total+$s['total'];
				$customers++;
			}
			$tickets++;
		}
		$this->set('ticket_count',$tickets);
		$this->set('cust_count',$customers);
		$this->set('total_sales',$total);
	
		if ($diff!=0) {
			$new = $total/$diff;
		} else {
			$new = 0;
		}
		$new = $new*3600;
		$this->set('ratio',round($new,'2'));
		$this->set('clocks',$a);
	}
	
	function report($id,$redirect=null,$index=null) {
		//change database to records
		$this->Ticket->setDataSource('alternate');
		$this->Seat->setDataSource('alternate');
		$this->Payment->setDataSource('alternate');
		$this->Clock->setDataSource('alternate');
		
		$userInfo = $this->Auth->user();
		if ($userInfo['User']['level']!='1' && $id!=$userInfo['User']['id']) {
			$this->Session->setFlash('This Action Is Restricted To Administrators. Please Authenticate As An Administrator And Try Again.');
			$this->redirect(array('controller'=>'users','action'=>'login'));
		}
		$this->set('user',$this->User->findById($id));
		
		if ($redirect==null || $redirect=='0') {
			$this->set('red','0');
		} else {
			if ($index=='2') {
				$this->set('red','1');
			} else {
				$this->set('red','2');
			}
		}
		if (!empty($this->data)) {
			//die(print_r($this->data));
			$conditions = array('Clock.complete'=>'1','Clock.user_id'=>$id);
			
			if (strlen($this->data['Clock']['startdate'])<9 || strlen($this->data['Clock']['enddate'])<9) {
				$this->Session->setFlash('Invalid data parameters given.');
				$this->redirect(array('controller'=>'clocks','action'=>'report_all'));
			}
			
			if(strtotime($this->data['Clock']['startdate'])<=strtotime($this->data['Clock']['enddate'])) {
				$shiftc = array('Clock.complete'=>'1');
				if ($this->data['Clock']['startdate']==$this->data['Clock']['enddate']) {
					$conditions['Clock.created BETWEEN ? AND ?']=array(date('Y-m-d',strtotime($this->data['Clock']['startdate'])),date('Y-m-d',strtotime($this->data['Clock']['startdate'])+86400));
					$seats = $this->Ticket->find('all',array('conditions'=>array('Ticket.status >'=>'1','Ticket.user_id'=>$id,'Ticket.created BETWEEN ? AND ?'=>array(date('Y-m-d',strtotime($this->data['Clock']['startdate'])),date('Y-m-d',strtotime($this->data['Clock']['startdate'])+86400)))));
				} else {
					$conditions['Clock.created BETWEEN ? AND ?']=array(date('Y-m-d',strtotime($this->data['Clock']['startdate'])),date('Y-m-d',strtotime($this->data['Clock']['enddate'])));
					$seats = $this->Ticket->find('all',array('conditions'=>array('Ticket.status >'=>'1','Ticket.user_id'=>$id,'Ticket.created BETWEEN ? AND ?'=>array(date('Y-m-d',strtotime($this->data['Clock']['startdate'])),date('Y-m-d',strtotime($this->data['Clock']['enddate']))))));
				}
			} else {
				//end date before start date
				$this->Session->setFlash('Invalid date parameters given.');
				$this->redirect(array('controller'=>'clocks','action'=>'report_all'));
			}
			
			$this->paginate = array('limit' => 20,'conditions'=>$conditions);
			$clocks = $this->paginate('Clock');
			
			//add data for shifts, hours
			$i=0;
			$total_time=0;
			$total_cost = 0;
			foreach ($clocks as $a) {
				$diff = strtotime($a['Clock']['out'])-strtotime($a['Clock']['in']);
				$total_time = $total_time+$diff;
				
				$clocks[$i]['Clock']['time']=$this->_timeBetween(strtotime($a['Clock']['in']),strtotime($a['Clock']['out']));
				$clocks[$i]['Clock']['cst']=$a['Clock']['cost'];
				$total_cost = $total_cost+$a['Clock']['cost'];
				$i++;
			}
			
			$this->set('start',$this->data['Clock']['startdate']);
			$this->set('end',$this->data['Clock']['enddate']);
		} else {
			$conditions = array('Clock.complete'=>'1','Clock.user_id'=>$id,'Clock.created >'=>date('Y-m-d', strtotime("-2 weeks")));
			$this->paginate = array('limit' => 20,'conditions'=>$conditions);
			$clocks = $this->paginate('Clock');
			
			$seats = $this->Ticket->find('all',array('conditions'=>array('Ticket.user_id'=>$id,'Ticket.status >'=>'1','Ticket.created BETWEEN ? AND ?'=>array(date('Y-m-d',strtotime('-2 weeks')),date('Y-m-d',time())))));
			
			//add data for shifts, hours
			$i=0;
			$total_time=0;
			$total_cost = 0;
			foreach ($clocks as $a) {
				$diff = strtotime($a['Clock']['out'])-strtotime($a['Clock']['in']);
				$total_time = $total_time+$diff;
				
				$clocks[$i]['Clock']['time']=$this->_timeBetween(strtotime($a['Clock']['in']),strtotime($a['Clock']['out']));
				$clocks[$i]['Clock']['cst']=$a['Clock']['cost'];
				$total_cost = $total_cost+$a['Clock']['cost'];
				$i++;
			}
			
			$this->set('start',date('m/d/Y',strtotime('-2 weeks')));
			$this->set('end',date('m/d/Y',time()));
		}
		
		//calculate sales statistics, etc.
		$total = 0;
		$tickets = 0;
		$customers = 0;
		//die(print($seats));
		foreach ($seats as $t) {
			foreach ($t['Seat'] as $s) {
				$total=$total+$s['total'];
				
				$customers++;
			}
			$tickets++;
		}
		$this->set('ticket_count',$tickets);
		$this->set('cust_count',$customers);
		$this->set('total_sales',$total);
		if ($total_time!=0) {
			$new = $total/$total_time;
		} else {
			$new = 0;
		}
		$new = $new*3600;
		$this->set('ratio',round($new,'2'));
		
		//total time worked
		$hours = $total_time/3600;
		$hours = floor($hours);
		$secs = $total_time%3600;
		$mins = round($secs/60);
		if ($mins<10) {
			$mins = '0'.$mins;
		}
		$this->set('total_time',$hours.':'.$mins);
		$total_cost = round($total_cost,'2');
		$sp = explode('.',$total_cost);
		if (isset($sp[1])) {
			if (strlen($sp[1])==1) {
				$total_cost = $total_cost.'0';
			}
		}
		$this->set('total_cost',$total_cost);
		
		$this->set('clocks',$clocks);
		
		//change it back
		$this->Ticket->setDataSource('default');
		$this->Seat->setDataSource('default');
		$this->Payment->setDataSource('default');
		$this->Clock->setDataSource('default');
	}
	
	function report_all() {
		//change database to records
		$this->Ticket->setDataSource('alternate');
		$this->Seat->setDataSource('alternate');
		$this->Payment->setDataSource('alternate');
		$this->Clock->setDataSource('alternate');
		
		$userInfo = $this->Auth->user();
		if ($userInfo['User']['level']!='1') {
			$this->Session->setFlash('This Action Is Restricted To Administrators. Please Authenticate As An Administrator And Try Again.');
			$this->redirect(array('controller'=>'users','action'=>'login'));
		}
		
		if (!empty($this->data)) {
			//die(print_r($this->data));

			$conditions = array('User.enable'=>'1');
			
			if ($this->data['Clock']['admins']=='0') {
				$conditions['User.level !='] = '1';
			}
			
			if (strlen($this->data['Clock']['startdate'])<9 || strlen($this->data['Clock']['enddate'])<9) {
				$this->Session->setFlash('Invalid data parameters given.');
				$this->redirect(array('controller'=>'clocks','action'=>'report_all'));
			}
			
			if (!empty($this->data['Clock']['emps'])) {
				$conditions['User.id'] = $this->data['Clock']['emps'];
			}
			
			if(strtotime($this->data['Clock']['startdate'])<=strtotime($this->data['Clock']['enddate'])) {
				$shiftc = array('Clock.complete'=>'1');
				if ($this->data['Clock']['startdate']==$this->data['Clock']['enddate']) {
					$shiftc['Clock.created BETWEEN ? AND ?']=array(date('Y-m-d',strtotime($this->data['Clock']['startdate'])),date('Y-m-d',strtotime($this->data['Clock']['startdate'])+86400));	
				} else {
					$shiftc['Clock.created BETWEEN ? AND ?']=array(date('Y-m-d',strtotime($this->data['Clock']['startdate'])),date('Y-m-d',strtotime($this->data['Clock']['enddate'])));
				}
			} else {
				//end date before start date
				$this->Session->setFlash('Invalid date parameters given.');
				$this->redirect(array('controller'=>'clocks','action'=>'report_all'));
			}
			
			$this->paginate = array('limit' => 20,'conditions'=>$conditions);
			$clocks = $this->paginate('User');
			
			//add data for shifts, hours
			$i = 0;
			foreach ($clocks as $a) {
				$shiftc['Clock.user_id']=$a['User']['id'];
				$shifts = $this->Clock->find('all',array('conditions'=>$shiftc));
				$clocks[$i]['User']['shifts']=count($shifts);
				
				$time=0;
				foreach ($shifts as $s) {
					$diff = strtotime($s['Clock']['out'])-strtotime($s['Clock']['in']);
					$time = $time+$diff;
				}
				//calculate hours, minutes
				$hours = $time/3600;
				$hours = floor($hours);
				$secs = $time%3600;
				$mins = round($secs/60);
				if ($mins<10) {
					$mins = '0'.$mins;
				}
				
				$clocks[$i]['User']['time']=$hours.':'.$mins;
				$i++;
			}
			$this->set('start',$this->data['Clock']['startdate']);
			$this->set('end',$this->data['Clock']['enddate']);
			$this->set('adm',$this->data['Clock']['admins']);
		} else {
			$conditions = array('User.enable'=>'1');
			
			$this->paginate = array('limit' => 20,'conditions'=>$conditions);
			$clocks = $this->paginate('User');
			
			//add data for shifts, hours
			$i = 0;
			foreach ($clocks as $a) {
				$shifts = $this->Clock->find('all',array('conditions'=>array('Clock.user_id'=>$a['User']['id'],'Clock.complete'=>'1','Clock.created >'=>date('Y-m-d',strtotime('-2 weeks')),'Clock.created <'=>date('Y-m-d',time()))));
				$clocks[$i]['User']['shifts']=count($shifts);
				
				$time=0;
				foreach ($shifts as $s) {
					$diff = strtotime($s['Clock']['out'])-strtotime($s['Clock']['in']);
					$time = $time+$diff;
				}
				//calculate hours, minutes
				$hours = $time/3600;
				$hours = floor($hours);
				$secs = $time%3600;
				$mins = round($secs/60);
				if ($mins<10) {
					$mins = '0'.$mins;
				}
				
				$clocks[$i]['User']['time']=$hours.':'.$mins;
				$i++;
			}
			
			$this->set('start',date('m/d/Y',strtotime('-2 weeks')));
			$this->set('end',date('m/d/Y',time()));
			$this->set('adm','1');
		}
		
		$this->set('options',$this->User->find('list',array('fields'=>array('User.full_name'))));
		$this->set('clock',$clocks);
		
		//change it back
		$this->Ticket->setDataSource('default');
		$this->Seat->setDataSource('default');
		$this->Payment->setDataSource('default');
		$this->Clock->setDataSource('default');
	}
        
	function in($user_id) {
		$userInfo = $this->Auth->user();
		if ($userInfo['User']['level']!='1') {
			$this->Session->setFlash('This Action Is Restricted To Administrators. Please Authenticate As An Administrator And Try Again.');
			$this->redirect(array('controller'=>'users','action'=>'login'));
		}
		
		$user = $this->Clock->User->findById($user_id);
		$this->set('user',$user);
		
		//rate info
		$opts = array();
		$opts[$user['User']['rate1']]='Rate 1 - $'.$user['User']['rate1'];
		if ($user['User']['rate2']!='0.00' && $user['User']['rate2']!='') {
			$opts[$user['User']['rate2']]='Rate 2 - $'.$user['User']['rate2'];
		}
		if ($user['User']['rate3']!='0.00' && $user['User']['rate3']!='') {
			$opts[$user['User']['rate3']]='Rate 3 - $'.$user['User']['rate3'];
		}
		$this->set('opts',$opts);
		
		if (!empty($this->data)) {
			$this->data['Clock']['user_id']=$user_id;
			$this->data['Clock']['in']=date('Y-m-d H:i:s',time());
			if ($this->Clock->save($this->data)) {
				$this->Session->setFlash('User Clocked In.');
				$this->redirect(array('controller'=>'users','action' => 'index'));
			} else {
				$this->Session->setFlash('Error: failed to clock in (clocks,in)');
				$this->redirect(array('controller'=>'tickets','action' => 'index'));
			}
		}
	}
	
	function out($id,$h=null) {
		$userInfo = $this->Auth->user();
		if ($userInfo['User']['level']!='1') {
			$this->Session->setFlash('This Action Is Restricted To Administrators. Please Authenticate As An Administrator And Try Again.');
			$this->redirect(array('controller'=>'users','action'=>'login'));
		}
		
		$user = $this->Clock->User->findById($id);
		$this->set('user',$user);
		
		$f = $this->Clock->find('first',array('conditions'=>array('Clock.user_id'=>$id,'Clock.complete'=>'0')));
		//make sure it's set
		if (empty($f)) {
			$this->Session->setFlash('This user is not clocked in.');
			$this->redirect(array('controller'=>'clocks','action' => 'index'));
		}
		
		//save data
		if (!empty($this->data)) {
			if ($this->data['Clock']['out']['meridian']=='pm') {
				if ($this->data['Clock']['out']['hour']=='12') {
					$hour = 12;
				} else {
					$hour = $this->data['Clock']['out']['hour']+12;
				}
			} else {
				if ($this->data['Clock']['out']['hour']=='12') {
					$hour = 0;
				} else {
					$hour = $this->data['Clock']['out']['hour'];
				}
			}
			$out = mktime($hour,$this->data['Clock']['out']['min'],0,$this->data['Clock']['out']['month'],$this->data['Clock']['out']['day'],$this->data['Clock']['out']['year']);
			$in = strtotime($f['Clock']['in']);
			$sec = $out-$in;
			$time = $sec/3600;
			$cost = $time*$f['Clock']['rate'];
			if ($cost<0) {
				$cost = 0;
			}
			
			$this->Clock->id = $f['Clock']['id'];
			$this->data['Clock']['complete']='1';
			$this->data['Clock']['cost']=$cost;
			if ($this->Clock->save($this->data)) {
				if ($h=='') {
				//saved
					$this->Session->setFlash('User Clocked Out');
					$this->redirect(array('controller'=>'users','action' => 'index'));
				} else {
					$this->Session->setFlash('User Clocked Out');
					$this->redirect(array('controller'=>'clocks','action' => 'index'));
				}
			} else {
				//didn't save
				$this->Session->setFlash('Error: failed to clock out (clocks,out)');
				$this->redirect(array('controller'=>'tickets','action' => 'index'));
			}
		}
	}
	
	function login_check() {
		$userInfo = $this->Auth->user();
		$id = $userInfo['User']['id'];
		
		$f = $this->Clock->find('first',array('conditions'=>array('Clock.user_id'=>$id,'Clock.complete'=>'0')));
		//make sure it's not set
		if (!empty($f)) {
			$this->Session->setFlash("You're already clocked in.");
			$this->redirect(array('controller'=>'tickets','action' => 'index'));
		} else {
			$data = array();
			$data['Clock']['user_id']=$id;
			$data['Clock']['complete']='0';
			$data['Clock']['in']=date('Y-m-d H:i:s',time());
			$data['Clock']['rate']=$userInfo['User']['rate1'];
			if ($this->Clock->save($data)) {
				$this->Session->setFlash($userInfo['User']['username'].' clocked in on rate 1.');
				$this->redirect(array('controller'=>'tickets','action' => 'menu'));
			} else {
				//failed to save clock in
				$this->Session->setFlash('Error: Could not clock in. (clocks,login_check)');
				$this->redirect(array('controller'=>'tickets','action' => 'index'));
			}
		}
	}
	
	function logout_check() {
		$userInfo = $this->Auth->user();
		$id = $userInfo['User']['id'];
		
		$f = $this->Clock->find('first',array('conditions'=>array('Clock.user_id'=>$id,'Clock.complete'=>'0')));
		//make sure it's not set
		if (!empty($f)) {
			$out = time();
			$in = strtotime($f['Clock']['in']);
			$sec = $out-$in;
			$time = $sec/3600;
			$cost = $time*$f['Clock']['rate'];
			if ($cost<0) {
				$cost = 0;
			}
			
			$data = array();
			$this->Clock->id = $f['Clock']['id'];
			$data['Clock']['complete']='1';
			$data['Clock']['cost']=$cost;
			$data['Clock']['out']=date('Y-m-d H:i:s',time());
			if ($this->Clock->save($data)) {
				$this->Session->setFlash($userInfo['User']['username'].' clocked out.');
				$this->redirect('/clocks/over/'.$f['Clock']['id']);
				//$this->redirect($this->Auth->logout());
			} else {
				//failed to save clock in
				$this->Session->setFlash('Error: Could not clock out. (clocks,logout_check)');
				$this->redirect('/pages/menu');
			}
		} else {
			$this->redirect($this->Auth->logout());
		}
	}
	
	function over($id) {
		$this->layout = 'noheader_timeout';
		$f = $this->Clock->findById($id);
		
		//calculate credit card tips
		$tick = $this->Ticket->find('list',array('fields'=>array('Ticket.id'),'conditions'=>array('Ticket.created >='=>date('Y-m-d H:i:s',strtotime($f['Clock']['in'])),'Ticket.user_id'=>$f['Clock']['user_id'])));
		$p = $this->Payment->find('all',array('conditions'=>array('Payment.ticket_id'=>$tick)));
		$ctips = 0;
		foreach ($p as $a) {
			$ctips = $ctips+$a['Payment']['tip']; 
		}
		//format the total
		$sp = explode('.',$ctips);
		if (isset($sp[1])) {
			if (strlen($sp[1])==1) {
				$ctips = $ctips.'0';
			}
		} else {
			$ctips = $ctips.'.00';
		}
		
		if (!empty($this->data)) {
			$tips = $this->data['Clock']['tips']+$ctips;
			$this->Clock->id = $id;
			if ($this->Clock->saveField('tips',$tips)) {
				$this->Session->setFlash($f['User']['full_name'].' Clocked Out.');
				$this->redirect($this->Auth->logout());
			} else {
				$this->Session->setFlash('Error: Could not save tips. (clocks,over)');
			}
		} else {
			$f['Clock']['time']=$this->_timeBetween(strtotime($f['Clock']['in']),strtotime($f['Clock']['out']));
			$user = $this->User->findById($f['Clock']['user_id']);
			if ($user['User']['rate1']==$f['Clock']['rate']) {
				$f['Clock']['rt'] = 'Rate 1';
			} elseif ($user['User']['rate2']==$f['Clock']['rate']) {
				$f['Clock']['rt'] = 'Rate 2';
			} elseif ($user['User']['rate3']==$f['Clock']['rate']) {
				$f['Clock']['rt'] = 'Rate 3';
			} else {
				$f['Clock']['rt'] = 'Other';
			}
			$f['Clock']['ctips'] = $ctips;
			$this->set('u',$f);
			$this->set('id',$id);
		}
	}
	
	function delete($id,$redirect=null) {
		$userInfo = $this->Auth->user();
		if ($userInfo['User']['level']!='1') {
			$this->Session->setFlash('This Action Is Restricted To Administrators. Please Authenticate As An Administrator And Try Again.');
			$this->redirect(array('controller'=>'users','action'=>'login'));
		}
		if ($this->Clock->find('count',array('conditions'=>array('Clock.id'=>$id)))=='0') {
			$this->Session->setFlash('This shift could not be found in the system.');
			$this->redirect(array('controller'=>'clocks','action'=>'index'));
		}
		$this->Clock->id = $id;
		if ($this->Clock->delete($id)) {
			$this->Session->setFlash('Shift Deleted.');
			if ($redirect!=null) {
				$this->redirect(array('controller'=>'clocks','action'=>'report/'.$redirect));
			} else {
				$this->redirect(array('controller'=>'clocks','action'=>'index'));
			}
		} else {
			$this->Session->setFlash('Error: Could not delete shift. (clocks,delete)');
			if ($redirect!=null) {
				$this->redirect(array('controller'=>'clocks','action'=>'report/'.$redirect));
			} else {
				$this->redirect(array('controller'=>'clocks','action'=>'index'));
			}
		}
	}
	
	function record_delete($id,$redirect=null) {
		$this->Clock->setDataSource('alternate');
		$userInfo = $this->Auth->user();
		if ($userInfo['User']['level']!='1') {
			$this->Session->setFlash('This Action Is Restricted To Administrators. Please Authenticate As An Administrator And Try Again.');
			$this->redirect(array('controller'=>'users','action'=>'login'));
		}
		if ($this->Clock->find('count',array('conditions'=>array('Clock.id'=>$id)))=='0') {
			$this->Session->setFlash('This shift could not be found in the system.');
			$this->redirect(array('controller'=>'clocks','action'=>'index'));
		}
		$this->Clock->id = $id;
		if ($this->Clock->delete($id)) {
			$this->Session->setFlash('Shift Deleted.');
			if ($redirect!=null) {
				$this->redirect(array('controller'=>'clocks','action'=>'report/'.$redirect));
			} else {
				$this->redirect(array('controller'=>'clocks','action'=>'index'));
			}
		} else {
			$this->Session->setFlash('Error: Could not delete shift. (clocks,delete)');
			if ($redirect!=null) {
				$this->redirect(array('controller'=>'clocks','action'=>'report/'.$redirect));
			} else {
				$this->redirect(array('controller'=>'clocks','action'=>'index'));
			}
		}
	}
	
	function _timeBetween($start_date,$end_date)  {  
	    $diff = $end_date-$start_date;  
	    $seconds = 0;  
	    $hours   = 0;  
	    $minutes = 0;  
      
	    if($diff % 86400 <= 0){$days = $diff / 86400;}  // 86,400 seconds in a day  
	    if($diff % 86400 > 0)  
	    {  
		$rest = ($diff % 86400);  
		$days = ($diff - $rest) / 86400;  
		if($rest % 3600 > 0)  
		{  
		    $rest1 = ($rest % 3600);  
		    $hours = ($rest - $rest1) / 3600;  
		    if($rest1 % 60 > 0)  
		    {  
			$rest2 = ($rest1 % 60);  
		    $minutes = ($rest1 - $rest2) / 60;  
		    $seconds = $rest2;  
		    }  
		    else{$minutes = $rest1 / 60;}  
		}  
		else{$hours = $rest / 3600;}  
	    }  
      
	    if($days > 0) {
		$days = $days.' days, ';
	    } else {$days = false;}  
	    if($hours > 0) {
		$hours = $hours.':';
	    } else {
		$hours = '0:';
	    }  
	    if($minutes > 10){$minutes = $minutes.'';}  
	    elseif ($minutes<10 && $minutes!=0) {$minutes = '0'.$minutes;}
	    else{$minutes = '00';}
	    $seconds = $seconds.' seconds'; // always be at least one second  
      
	    return $days.''.$hours.''.$minutes/*.''.$seconds*/;  
	}
    
    
}

?>