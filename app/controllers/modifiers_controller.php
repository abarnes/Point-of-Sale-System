<?php
/*------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
-------------------------------------------------------------------------------*/

class ModifiersController extends AppController {
 
	var $name = 'Modifiers';
        //var $layout = 'default';
	var $helpers = array('Html', 'Form', 'Time', 'javascript');
	//var $uses = array('Choice','Race','Driver','Year','DriversYear','User','Record','Place');
	var $components = array('Auth','Session');
        
        function beforeFilter() {
            $this->Auth->allow('view');
        }
        
	
	function index () {
		$this->set('items', $this->Modifier->Item->find('list',array('order'=>'Item.name ASC')));
		$this->paginate = array('limit' => 18);
			$modifiers = $this->paginate('Modifier');
			if (count($modifiers)==0){
				$this->Session->setFlash('No modifiers currently in system.  Click "Add Modifier" to create one.');
			}
		$this->set(compact('modifiers'));
	}
	
	function add() {
		$userinfo = $this->Auth->user();
		if ($userinfo['User']['level']!='1') {
			$this->redirect(array('controller'=>'pages','action' => 'home'));
			$this->Session->setFlash('You Do Not Have Permission To Access This Page');
		}
		$this->set('items', $this->Modifier->Item->find('list',array('order'=>'Item.name ASC')));
		if (!empty($this->data)) {
			if ($this->Modifier->save($this->data)) {
				$this->Session->setFlash('"'.$this->data['Modifier']['name'] . '" Modifier Successfully Added.');
				$this->redirect(array('controller'=>'modifiers','action' => 'index'));
			} else {
				$this->Session->setFlash('Error: Failed to Save Modifier');
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
		$this->set('items', $this->Modifier->Item->find('list',array('order'=>'Item.name ASC')));
		if (empty($this->data)) {
			$this->data = $this->Modifier->read();
		} else {
			if ($this->Modifier->save($this->data)) {
				$this->Session->setFlash('Modifier Has Been Updated.');
				if ($setup=='1') {
					$this->redirect(array('action'=>'setup'));
				} else {
					$this->redirect(array('action'=>'index'));
				}
			} else {
				$this->Session->setFlash('Error: Failed to Save');
			}
		}
	}
    
	function delete($id,$setup=null) {
		$userinfo = $this->Auth->user();
		if ($userinfo['User']['level']!='1') {
			$this->redirect(array('controller'=>'pages','action' => 'home'));
			$this->Session->setFlash('You Do Not Have Permission To Access This Page');
		}
		$this->Modifier->delete($id);
		$this->Session->setFlash('Modifier Successfully Deleted.');
		if ($setup=='1') {
			$this->redirect(array('action'=>'setup'));
		} else {
			$this->redirect(array('action'=>'index'));
		}
	}
	
	function setup() {
		$this->paginate = array('limit' => 18);
			$modifiers = $this->paginate('Modifier');
		
		$this->set('items', $this->Modifier->Item->find('list',array('order'=>'Item.name ASC')));
		//render table or first item form
		if (count($modifiers)==0) {
			$this->set('check',true);
		} else {
			$this->set('check',false);
			$this->set(compact('modifiers'));
		}
		//save data from new item
		if (!empty($this->data)) {
			if ($this->Modifier->save($this->data)) {
				$this->Session->setFlash($this->data['Modifier']['name'].' Added.');
				$this->redirect(array('action'=>'setup'));
			} else {
				$this->Session->setFlash('Failed to Save Option');
			}
				
		}
	}
    
}

?>