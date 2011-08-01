<?php
/*------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
-------------------------------------------------------------------------------*/
class ItemsController extends AppController {
 
	var $name = 'Items';
        //var $layout = 'default';
	var $helpers = array('Html', 'Form', 'Time', 'javascript');
	//var $uses = array('Choice','Race','Driver','Year','DriversYear','User','Record','Place');
	var $components = array('Auth','Session');
        
        function beforeFilter() {
            $this->Auth->allow('view');
        }
        
	
	function index () {
		$this->set('categories', $this->Item->Category->find('list',array('order'=>'Category.name ASC')));
		$this->paginate = array('limit' => 18);
			$items = $this->paginate('Item');
			if (count($items)==0){
				$this->Session->setFlash('No items currently in system.  Click "Add Item" to create one.');
			}
		$this->set(compact('items'));
	}
	
	function add() {
		$userinfo = $this->Auth->user();
		if ($userinfo['User']['level']!='1') {
			$this->redirect(array('controller'=>'pages','action' => 'home'));
			$this->Session->setFlash('You Do Not Have Permission To Access This Page');
		}
		$this->set('categories', $this->Item->Category->find('list',array('order'=>'Category.name ASC')));
		$this->set('modifiers', $this->Item->Modifier->find('list',array('order'=>'Modifier.name ASC')));
		if (!empty($this->data)) {
			//die(print_r($this->data));
			if ($this->Item->save($this->data)) {
				$this->Session->setFlash('Item "'.$this->data['Item']['name'] . '" Successfully Added.');
				$this->redirect(array('controller'=>'items','action' => 'index'));
			} else {
				$this->Session->setFlash('Error: Failed to Save Item');
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
		$this->set('categories', $this->Item->Category->find('list',array('order'=>'Category.name ASC')));
		$this->set('modifiers', $this->Item->Modifier->find('list',array('order'=>'Modifier.name ASC')));
		if (empty($this->data)) {
			$this->data = $this->Item->read();
		} else {
			if ($this->Item->save($this->data)) {
				$this->Session->setFlash('Item Has Been Updated.');
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
		$this->Item->delete($id);
		$this->Session->setFlash('Modifier Successfully Deleted.');
		if ($setup=='1') {
			$this->redirect(array('action'=>'setup'));
		} else {
			$this->redirect(array('action'=>'index'));
		}
	}
	
	function setup() {
		$this->paginate = array('limit' => 18);
		$items = $this->paginate('Item');
		
		$this->set('categories', $this->Item->Category->find('list',array('order'=>'Category.name ASC')));
		//render table or first item form
		if (count($items)==0) {
			$this->set('check',true);
		} else {
			$this->set('check',false);
			$this->set(compact('items'));
		}
		//save data from new item
		if (!empty($this->data)) {
			if ($this->Item->save($this->data)) {
				$this->Session->setFlash($this->data['Item']['name'].' Added.');
				$this->redirect(array('action'=>'setup'));
			} else {
				$this->Session->setFlash('Failed to Save Item');
			}
				
		}
	}
    
}

?>