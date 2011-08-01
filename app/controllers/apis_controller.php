<?php
/*------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
-------------------------------------------------------------------------------*/
class ApisController extends AppController {
 
	var $name = 'Apis';
	var $helpers = array('Html', 'Form', 'Time', 'javascript');
	var $uses = array('Api','Ticket','Item','Seat');
	var $components = array('Auth','Session');
	
	/*------------------------------------------------------------------------------------------------------------------------------------------------
	 This is the controller for all the API functions.  All data is passed to the server through the POST method.
	 
	 Each function contains a description of its purpose and the variables you need to pass to utilize it.
	 -------------------------------------------------------------------------------------------------------------------------------------------------*/
        
	//Don't touch this one.  It allows you to run the functions
        function beforeFilter() {
            $this->Auth->allow('*');
        }
	
	//This is used for testing the POST method.  Pass a key named 'data' and then go to /apis/recorded to view results
	function test_str() {
		$this->layout = 'blank';
		$data = $_POST['data'];
		$this->data = array();
		$this->data['Api']['results'] = $_POST['data'];
		if ($this->Api->save($this->data)) {
			$this->set('resp','Data Successfully Saved');
			echo 'success';
			exit;
		} else {
			$this->set('resp','Error: Data Failed to Save');
			echo 'error: failed to save';
			exit;
		}
	}
	
	//This displays results of the test method above
	function recorded() {
		$this->set('apis',$this->Api->find('all',array('order'=>'Api.created DESC')));
	}
	
	//Submit a new ticket
	function submit_ticket() {
		/*------------------------------------------------------------------------------------------------------------------------------------------------
		Pass the following key/value pairs to use the function:
		Key		|	Example Value
		'table'		|	'20' (this is just the number of the table, does not correspond to data in the DB)
		'user_id'	|	'4'  (this will come from the database's Users table, associates a ticket with a user)
		'type_id'	|	'2'  (also from database, matches id field of types, and correspond to names such as dine-in, carry-out, etc.)
		'seats'		|	'2(1:2)|1(3:4),3(4)'   (this stores all the order info, example below)
		
		The seats key will need to contain a value of IDs, which correspond to the database.  Each seat will be separated by a vertical bar |, and the format of each individual seat is "Item(modifier1:modifier2:etc....),Item(modifier1:etc...)"

		Example: 
		
		Items:
		1= Single Burger
		2=Frisco Melt
		3=Salad
		
		Modifiers:
		1=Mayonaise
		2=Mustard
		3=Swiss Cheese
		4=Ranch
		
		Seat 1 ordered a Frisco Melt with mayonaise and mustard, and seat 2 ordered a Single Burger with Swiss cheese and ranch and a salad with ranch,  This is what you'd send:
		'2(1:2)|1(3:4),3(4)'
		
		Do not include spaces in the string.
		------------------------------------------------------------------------------------------------------------------------------------------------*/
		$data = $_POST;
		//die(print_r($data));
		if (isset($data['table'])&&isset($data['seats'])) {
			$this->data = array();
			$sts = explode('|',$data['seats']);
			$c = 0;
			foreach ($sts as $s) {
				$this->data['Seat'][$c]['items'] = $s;
				$this->data['Seat'][$c]['seat'] = $c+1;
				$c++;
			}
			
			$this->data['Ticket']['table'] = $data['table'];
			if ($this->Ticket->find('count')!=0) {
				$last = $this->Ticket->find('first',array('order'=>'Ticket.created DESC'));
				$dayid = $last['Ticket']['dailyid']+1;
			} else {
				$dayid = 1;
			}
			$this->data['Ticket']['dailyid'] = $dayid;
			$this->data['Ticket']['user_id'] = $data['user_id'];
			$this->data['Ticket']['status'] = 0;
			$this->data['Ticket']['type_id'] = $data['type_id'];
			$this->Ticket->create();
			if ($this->Ticket->saveAll($this->data)) {
				echo 'Ticket Created';
				exit;
			} else {
				echo 'Ticket failed to Save';
				exit;
			}
		} else {
			echo 'Missing Required Info: Missing either table number or first seat';
			exit;
		}
	}
	
	//function to combine tickets
	function combine() {
		/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		Send the following values through post:
		Key		|	Example Value
		'ids'		|	'1,2,3,4'  (send a string of IDs separated by commas for each ticket you want to combine)
		'user_id'	|	'7'	(this is the ID of the user you want the combined ticket to belong to.  Leave blank to default to first ticket's user)
		
		**note that all tickets submitted must have a status of 0 or 1 (submitted or prepared).  Otherwise they will be rejected (paid/void/etc. tickets cannot be combined)
		-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
		
		$sent = $_POST;
		$arr = explode(',',$sent['ids']);
		
		//make sure there is more than one ticket selected, not too many
		if (count($arr)<2) {
			die(print('You must submit more than one ticket to combine.'));
			exit;
		}
		
		if (count($arr)>99) {
			die(print('You may not combine more than 99 tickets.'));
			exit;
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
		
		if (count($errors)!=0) {
			die(print('The following tickets have already been paid or are otherwise void: '.implode(', ',$errors)));
			exit;
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
		if ($sent['user_id']=='') {
			$newdata['Ticket']['user_id'] = $tic[0]['Ticket']['user_id'];
		} else {
			$newdata['Ticket']['user_id'] = $sent['user_id'];
		}
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
				$frac = 1/100;
				if (in_array($s['Seat']['seat'],$already)) {
					$new = $s['Seat']['seat'];
					while (in_array($new,$already)) {
						$new = $s['Seat']['seat']+$frac; 
					}
					$already[] = $new;
				} else {
					$already[] = $s['Seat']['seat'];
					$new = $s['Seat']['seat'];
				}
				
				$this->Ticket->Seat->id = $s['Seat']['id'];
				$saveseat['Seat']['ticket_id'] = $ticketid;
				$saveseat['Seat']['seat'] = $new;
				$this->Ticket->Seat->save($saveseat);
				$this->Ticket->Seat->id = false;
			}
			
			//delete old tickets
			foreach ($arr as $a) {
				$this->Ticket->delete($a);
			}
			
			//redirect
			die(print('Tickets successfully combined.  New ID: #'.$tic[0]['Ticket']['dailyid']));
			exit;
		} else {
			die(print('Error: Ticket failed to save.'));
			exit;
		}
	}
	
	//Split a given ticket into separate tickets for each seat
	function split_indiv() {
		/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		Send the following value through post (it only takes one, this is a simple split):
		Key		|	Example Value
		'id'		|	'5'  (send the ID of the ticket you want to split, from the DB)
		
		**note that the ticket submitted must have a status of 0 or 1 (submitted or prepared).  Otherwise id will be rejected (paid/void/etc. tickets cannot be split)
		-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
		
		$sent = $_POST;
		$ticket = $this->Ticket->findById($send['id']);
		
		//check status
		if ($ticket['Ticket']['status']>1) {
			die(print('Error: This ticket has been paid or is otherwise void.'));
			exit;
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
			$last = $this->Ticket->find('first',array('order'=>'Ticket.created DESC'));
			$dayid = $last['Ticket']['dailyid']+1;
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
		}
		
		if ($this->Ticket->delete($id)) {
			die(print('Ticket successfully split. New IDs: #'.implode(', ',$tics)));
			exit;
		} else {
			die(print('Error: Ticket failed to save.'));
			exit;
		}
	}
        
}
?>