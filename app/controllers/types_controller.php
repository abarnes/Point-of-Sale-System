<?php
/*------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
-------------------------------------------------------------------------------*/
class TypesController extends AppController {
 
	var $name = 'Types';
        //var $layout = 'default';
	var $helpers = array('Html', 'Form', 'Time', 'javascript');
	var $components = array('Auth','Session');
        
        function beforeFilter() {
            //$this->Auth->allow('setup');
        }
        
	
	function index () {
		$this->paginate = array('limit' => 18);
			$types = $this->paginate('Type');
			if (count($types)==0){
				$this->Session->setFlash('No ticket types currently in system.  Click "Add Ticket Type" to create one.');
			}
		$this->set(compact('types'));
	}
	
	function add() {
		$userinfo = $this->Auth->user();
		if ($userinfo['User']['level']!='1') {
			$this->redirect(array('controller'=>'pages','action' => 'home'));
			$this->Session->setFlash('You Do Not Have Permission To Access This Page');
		}
		if (!empty($this->data)) {
			if ($this->Type->save($this->data)) {
				$this->Session->setFlash('Ticket Type Saved.');
				$this->redirect(array('controller'=>'types','action' => 'index'));
			} else {
				$this->Session->setFlash('Error: Failed to Save Ticket Type');
			}
		}
	}
    
	function edit($id,$setup=null) {
		if ($setup!=null) {
			$this->set('setup',$setup);
		} else {
			$this->set('setup',false);
		}
		$this->set('id',$id);
		$this->User->id = $id;
		$userinfo = $this->Auth->user();
		//die(print_r($userinfo));
		if ($userinfo['User']['level']!='1') {
			$this->redirect(array('controller'=>'pages','action' => 'home'));
			$this->Session->setFlash('You Do Not Have Permission To Access This Page');
		}
		if (empty($this->data)) {
			$this->data = $this->Type->read();
		} else {
			if ($this->Type->save($this->data)) {
				$this->Session->setFlash('Ticket Type Updated.');
				if ($setup=='1') {
					$this->redirect(array('action'=>'setup'));
				} else {
					$this->redirect(array('action'=>'index'));
				}
			} else {
				$this->Session->setFlash('Error: Failed to Save Ticket Type');
			}
		}
	}
    
	function delete($id,$setup=null) {
		$userinfo = $this->Auth->user();
		if ($userinfo['User']['level']!='1') {
			$this->redirect(array('controller'=>'pages','action' => 'home'));
			$this->Session->setFlash('You Do Not Have Permission To Access This Page');
		}
		$this->Type->delete($id);
		$this->Session->setFlash('Ticket Type Successfully Deleted.');
		if ($setup=='1') {
			$this->redirect(array('action'=>'setup'));
		} else {
			$this->redirect(array('action'=>'index'));
		}
	}
	
	function setup() {
		$this->layout = 'noheader';
		
		$this->paginate = array('limit' => 18);
			$types = $this->paginate('Type');
			/*if (count($types)==0){
				$this->Session->setFlash('No ticket types currently in system.  Click "Add Ticket Type" to create one.');
			}*/
		$this->set(compact('types'));
		//save data from new type
		if (!empty($this->data)) {
			if ($this->Type->save($this->data)) {
				$this->Session->setFlash($this->data['Type']['name'].' Added.');
				$this->redirect(array('action'=>'setup'));
			} else {
				$this->Session->setFlash('Failed to Save Type');
			}	
		}
	}
    
}

?>