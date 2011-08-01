<?php
/*------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
-------------------------------------------------------------------------------*/
class SettingsController extends AppController {
 
	var $name = 'Settings';
        //var $layout = 'default';
	//var $helpers = array('Html', 'Form', 'Time', 'javascript');
	var $components = array('Auth','Session');
        
        function beforeFilter() {
            //$this->Auth->allow('setup');
        }
        
	
	function edit() {
		$s = $this->Setting->find('first',array('order'=>'Setting.created ASC'));
		$this->Setting->id = $s['Setting']['id'];
		
		if (empty($this->data)) {
			$this->data = $this->Setting->read();
		} else {
			//save new settings
			if ($this->Setting->save($this->data)) {
				$this->Session->setFlash('Settings Updated');
				$this->redirect(array('controller'=>'settings','action' => 'edit'));
			} else {
				$this->Session->setFlash('Error: Failed to Save Settings (settings,edit)');
				$this->redirect(array('controller'=>'settings','action' => 'edit'));
			}
		}
	}
	
	function advanced() {
		$s = $this->Setting->find('first',array('order'=>'Setting.created ASC'));
		$this->Setting->id = $s['Setting']['id'];
		
		if (empty($this->data)) {
			$this->data = $this->Setting->read();
		} else {
			//save new settings
			if ($this->Setting->save($this->data)) {
				$this->Session->setFlash('Settings Updated');
				$this->redirect(array('controller'=>'settings','action' => 'advanced'));
			} else {
				$this->Session->setFlash('Error: Failed to Save Settings (settings,edit)');
				$this->redirect(array('controller'=>'settings','action' => 'advanced'));
			}
		}
	}
	
	function setup() {
		$s = $this->Setting->find('first',array('order'=>'Setting.created ASC'));
		$this->Setting->id = $s['Setting']['id'];
		
		if (empty($this->data)) {
			$this->data = $this->Setting->read();
		} else {
			//save new settings
			if ($this->Setting->save($this->data)) {
				$this->Session->setFlash('Settings Saved');
				$this->redirect(array('controller'=>'settings','action' => 'advanced_setup'));
			} else {
				$this->Session->setFlash('Error: Failed to Save Settings (settings,setup)');
				$this->redirect(array('controller'=>'settings','action' => 'setup'));
			}
		}
	}
	
	function advanced_setup() {
		$s = $this->Setting->find('first',array('order'=>'Setting.created ASC'));
		$this->Setting->id = $s['Setting']['id'];
		
		if (empty($this->data)) {
			$this->data = $this->Setting->read();
		} else {
			//save new settings
			if ($this->Setting->save($this->data)) {
				$this->Session->setFlash('Settings Saved');
				$this->redirect(array('controller'=>'types','action' => 'setup'));
			} else {
				$this->Session->setFlash('Error: Failed to Save Settings (settings,advanced_setup)');
				$this->redirect(array('controller'=>'settings','action' => 'advanced_setup'));
			}
		}
	}
	
	function update() {
		
	}
    
}

?>