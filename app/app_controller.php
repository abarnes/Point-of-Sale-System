<?php
/*------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
-------------------------------------------------------------------------------*/
class AppController extends Controller {
	
	var $components = array('Auth');
	
	function beforeRender() {
		if($this->Auth->user()) {
			$aut = true;
			$this->set('aut',true);
			$userInfo = $this->Auth->user();
			if ($userInfo['User']['level']==1) {
				$this->set('admin',true);				
			} else {
				$this->set('admin',false);
			}
			$this->set('name',$userInfo['User']['first_name']);
		} else {
			$aut = false;
			$this->set('aut',false);
		}
	}
	
	function beforeFilter() {
		$this->Auth->loginAction = array('controller' => 'users', 'action' =>'login');
		$this->Auth->loginRedirect = array('controller' => 'users', 'action' =>'login');
	}
	
}
