<?php
/*------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
-------------------------------------------------------------------------------*/

class UsersController extends AppController {
 
	var $name = 'Users';
        //var $layout = 'default';
	var $helpers = array('Html', 'Form', 'Time', 'javascript');
	//var $uses = array('Choice','Race','Driver','Year','DriversYear','User','Record','Place');
	var $components = array('Auth','Session');
        
        function beforeFilter() {
		$this->Auth->allow('login','add','loading','setup','quick_in');
        }
        
	function loading() {		
		@apache_setenv('no-gzip', 1);
		@ini_set('zlib.output_compression', 0);
		$this->layout = 'test';
		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		flush();
		
		//echo '<script type="text/javascript" src="/js/prototype.js"></script>';
		$f = file_get_contents('loadlayout.ctp');
		echo $f;
		
		sleep(1);
		while(1) {
			$users = $this->User->find('all');
			$str = '';
			foreach ($users as $u){
				$str = $str.$u['User']['username'].' ';
			}
			 echo '<script type="text/javascript">';
			 echo 'comet.printServerTime("'.$str.'");';
			 //echo 'comet.test('.time().');';
			 echo '</script>';
			 unset($users);
			 flush(); // used to send the echoed data to the client
			 //ob_flush();
			 sleep(9); // a little break to unload the server CPU
			 //die(print('dfsd'));
		}
	}
	
        function login() {
		include("Mobile_Detect.php");
		$detect = new Mobile_Detect();
		if ($detect->isMobile()) {
			$this->layout = 'ios';
			$this->render('m.login');
		} else {
			$this->layout = 'noheader_timeout';
		}
		
		//$this->set('options',$this->User->find('list',array('fields'=>array('User.username','User.username'),'order'=>'User.username ASC')));
		$this->Auth->redirect(array('controller' => 'clocks', 'action' => 'login_check'));
	}
	
	function logout() {
		$this->redirect(array('controller' => 'clocks', 'action' => 'logout_check'));
		//$this->redirect($this->Auth->logout());
	}
	
	function quick_in() {
		include("Mobile_Detect.php");
		$detect = new Mobile_Detect();
		if ($detect->isMobile()) {
			$this->layout = 'ios';
			$this->render('m.quick_in');
		} else {
			$this->layout = 'noheader';
		}
		if (!empty($this->data)) {
			$user = $this->User->find('first',array('conditions'=>array('User.shortcut'=>$this->data['User']['quick'])));
			if (isset($user['User'])) {
				$f = $this->User->Clock->find('first',array('conditions'=>array('Clock.user_id'=>$user['User']['id'],'Clock.complete'=>'0')));
				//make sure it's not set
				if (!empty($f)) {
					$this->Auth->login(array('username'=>$user['User']['username'],'password'=>$user['User']['password']));
					$this->redirect(array('controller' => 'tickets', 'action' => 'menu'));
				} else {
					$this->Session->setFlash('You are not clocked in.  Please clock in first.');
					$this->redirect(array('controller' => 'users', 'action' => 'login'));
				}
			} else {
				//couldn't find it
				$this->Session->setFlash('Invalid Quick Key Entered.');
			}
		}
	}
	
	function index ($all=null) {
		if ($all=='all'){
			$conditions = array();
			$this->set('all','1');
		} else {
			$conditions = array('User.enable'=>'1');
			$this->set('all','0');
		}
		$this->paginate = array('limit' => 18,'conditions'=>$conditions);
			$users = $this->paginate('User');
			if (count($users)==0){
				$this->Session->setFlash('No employees currently in system.  Click "Add User" to create one.');
			}
		$i = 0;
		foreach ($users as $u) {
			$f = $this->User->Clock->find('count',array('conditions'=>array('Clock.user_id'=>$u['User']['id'],'Clock.complete'=>'0')));
			if ($f>0) {
				$users[$i]['User']['in']='1';
			} else {
				$users[$i]['User']['in']='0';
			}
			$i++;
		}
		//die(print_r($users));
		$this->set(compact('users'));
	}
	
	function add() {
		    if (!empty($this->data)) {
			    $p2 = $this->data['User']['password2'];
			    if ($this->data['User']['password'] == /*$this->data['User']['password2']*/$this->Auth->password($p2)) {
				    if ($this->User->save($this->data)) {
					    //$rd = $this->User->find('first',array('conditions'=>array('User.username'=>$this->data['User']['username'])));
					    //$this->_sendNewUserMail($rd['User']['id']);
					    $this->Session->setFlash('"'.$this->data['User']['username'] . '" Successfully Added.');
					    if($this->Auth->user()) {
						$aut = '1';
	     				    } else {
						$aut = '0';
					    }
					    if ($aut=='0') {
						$this->Auth->login(array('username'=>$this->data['User']['username'],'password'=>$this->data['User']['password']));
					    }
					    $this->redirect(array('controller'=>'users','action' => 'index'));
				    } else {
					    $this->Session->setFlash('Failed to Save Employee');
				    }
			    } else {
				    $this->Session->setFlash('Passwords Did Not Match.  Please Try Again.');
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
	    if ($userinfo['User']['level']=='1') {
		    if (empty($this->data)) {
			    $this->data = $this->User->read();
		    } else {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash('User Information Has Been Updated.');
				if ($setup=='1') {
					$this->redirect(array('action'=>'setup'));
				} else {
					$this->redirect(array('action'=>'index'));
				}
			} else {
				$this->Session->setFlash('Error: User info could not be saved. (users,edit)');
				$this->redirect(array('controller'=>'users','action'=>'edit/'.$id));
			}
		    }
	    } else {
		    $this->Session->setFlash('This Action Is Restricted To Administrators. Please Authenticate As An Administrator And Try Again.');
		    $this->redirect(array('controller'=>'users','action'=>'login'));
	    }
	}
	
	function view($id) {
		
	}
	
	function passwordchange($id = null) {
		$this->User->id = $id;
		$userinfo = $this->Auth->User();
		if ($id == $userinfo['User']['id'] || $userinfo['User']['level']=='1') {
			if (empty($this->data)) {
				$this->set('user',$this->User->findById($id));
				$this->data = $this->User->read();
			} else {
				$p2 = $this->data['User']['password2'];
				if ($this->data['User']['password'] == $p2  && strlen($p2)>='6') {
					if ($this->User->saveField('password',$this->Auth->password($this->data['User']['password']))) {
						$this->Session->setFlash('Password Changed.');
						$this->redirect(array('controller'=>'users','action' => 'index'));
					}
				} else {
					$this->Session->setFlash('Passwords Did Not Match, Or Your New Password Is Less Than 6 Characters.');
				}
			}
		} else {
			$this->Session->setFlash('You Cannot Edit This User.');
		}	
	}
    
	function delete($id,$setup=null) {
	    $userinfo = $this->Auth->user();
	    if ($userinfo['User']['level']=='1') {
		    $this->User->delete($id);
		    $this->Session->setFlash('User Successfully Deleted.');
			if ($setup=='1') {
				$this->redirect(array('action'=>'setup'));
			} else {
				$this->redirect(array('action'=>'index'));
			}
	    } else {
		    $this->Session->setFlash('Only Administrators Can Delete Users. Please Authenticate As An Administrator And Try Again.');
		    $this->redirect(array('action'=>'login'));
	    }
	}
	
	function _sendNewUserMail($id) {
	   $User = $this->User->read(null,$id);
	   $this->Email->to = $User['User']['email'];
	   //$this->Email->bcc = array('secret@example.com');  
	   $this->Email->subject = 'Welcome to Fox Valley Racing';
	   $this->Email->replyTo = 'support@foxvalleyracing.com';
	   $this->Email->from = 'Fox Valley Racing <support@foxvalleyracing.com>';
	   $this->Email->template = 'welcome'; // note no '.ctp'
	   //Send as 'html', 'text' or 'both' (default is 'text')
	   $this->Email->sendAs = 'both'; // because we like to send pretty mail
	   //Set view variables as normal
	   $this->set('user', $User['User']['username']);
	   //Do not pass any args to send()
	   $this->Email->send();
	}
	
	function setup() {
		$this->paginate = array('limit' => 18);
		$users = $this->paginate('User');
		//render table or first admin form
		if (count($users)==0) {
			$this->set('check',true);
			$a = '1';
		} else {
			$this->set('check',false);
			$this->set('users',$users);
			$a = '0';
		}
		//save data from new user
		if (!empty($this->data)) {
			$p2 = $this->data['User']['password2'];
				if ($this->data['User']['password'] == $this->Auth->password($p2)) {
					if ($this->User->save($this->data)) {
						if ($a=='1') {
							$this->Auth->login(array('username'=>$this->data['User']['username'],'password'=>$this->data['User']['password']));
						}
						$this->Session->setFlash('User '.$this->data['User']['username'].' Added.');
						$this->redirect(array('action'=>'setup'));
					} else {
						$this->Session->setFlash('Failed to Save User');
					}
				} else {
					$this->Session->setFlash('Passwords Did Not Match.  Please Try Again.');
				}
				
		}
	}
    
    
}

?>