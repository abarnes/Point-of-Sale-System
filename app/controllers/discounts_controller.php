<?php
/*------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
-------------------------------------------------------------------------------*/
class DiscountsController extends AppController {
 
	var $name = 'Discounts';
        //var $layout = 'default';
	var $helpers = array('Html', 'Form', 'Time', 'javascript');
	//var $uses = array('Choice','Race','Driver','Year','DriversYear','User','Record','Place');
	var $components = array('Auth','Session');
        
        function beforeFilter() {
            //$this->Auth->allow('view');
        }
	
	function index () {
		$this->Discount->recursive = 1;
		$this->paginate = array('limit' => 20);
			$discounts = $this->paginate('Discount');
			if (count($discounts)==0){
				$this->Session->setFlash('No discounts currently in system.  Click "Add Discount" to create one.');
			}
		$this->set(compact('discounts'));
	}
	
	function add($id) {
		$userinfo = $this->Auth->user();
		if ($userinfo['User']['level']!='1') {
			$this->redirect(array('controller'=>'pages','action' => 'home'));
			$this->Session->setFlash('You Do Not Have Permission To Access This Page');
		}
		
		$item = $this->Discount->Item->findById($id);
		if (!isset($item['Item'])) {
			$this->Session->setFlash('Error: Item not found (discounts, add)');
			$this->redirect(array('controller'=>'items','action' => 'index'));
		}
		
		if (!empty($this->data)) {
			//check validity
			$disc = $this->Discount->find('all',array('conditions'=>array('Discount.item_id'=>$id)));
			if (count($disc)!=0) {
				$mins = $this->data['Discount']['start_time']['min'];
				if ($this->data['Discount']['start_time']['meridian']=='pm') {
					if ($this->data['Discount']['start_time']['hour']=='12') {
						$hours = 12;
					} else {
						$hours = $this->data['Discount']['start_time']['hour']+12;
					}
				} else {
					if ($this->data['Discount']['start_time']['hour']=='12') {
						$hours = 0;
					} else {
						$hours = $this->data['Discount']['start_time']['hour'];
					}
				}
				$start_time = mktime($hours,$mins,0);
				$mine = $this->data['Discount']['end_time']['min'];
				if ($this->data['Discount']['end_time']['meridian']=='pm') {
					if ($this->data['Discount']['end_time']['hour']=='12') {
						$houre = 12;
					} else {
						$houre = $this->data['Discount']['end_time']['hour']+12;
					}
				} else {
					if ($this->data['Discount']['end_time']['hour']=='12') {
						$houre = 0;
					} else {
						$houre = $this->data['Discount']['end_time']['hour'];
					}
				}
				$end_time = mktime($houre,$mine,0);
				
				$ret = array();
				foreach ($disc as $d) {
					if ($this->data['Discount']['monday']=='1' && $d['Discount']['monday']=='1') {
						if ($start_time<strtotime($d['Discount']['end_time'])) {
							if ($end_time>strtotime($d['Discount']['start_time'])) {
								//overlap with other discount
								$ret[]='Monday';
							}
						}
					}
					
					if ($this->data['Discount']['tuesday']=='1' && $d['Discount']['tuesday']=='1') {
						if ($start_time<strtotime($d['Discount']['end_time'])) {
							if ($end_time>strtotime($d['Discount']['start_time'])) {
								//overlap with other discount
								$ret[]='Tuesday';
							}
						}
					}
					
					if ($this->data['Discount']['wednesday']=='1' && $d['Discount']['wednesday']=='1') {
						if ($start_time<strtotime($d['Discount']['end_time'])) {
							if ($end_time>strtotime($d['Discount']['start_time'])) {
								//overlap with other discount
								$ret[]='Wednesday';	
							}
						}
					}
					
					if ($this->data['Discount']['thursday']=='1' && $d['Discount']['thursday']=='1') {
						if ($start_time<strtotime($d['Discount']['end_time'])) {
							if ($end_time>strtotime($d['Discount']['start_time'])) {
								//overlap with other discount
								$ret[]='Thursday';
							}
						}
					}
					
					if ($this->data['Discount']['friday']=='1' && $d['Discount']['friday']=='1') {
						if ($start_time<strtotime($d['Discount']['end_time'])) {
							if ($end_time>strtotime($d['Discount']['start_time'])) {
								//overlap with other discount
								$ret[]='Friday';
							}
						}
					}
					
					if ($this->data['Discount']['saturday']=='1' && $d['Discount']['saturday']=='1') {
						if ($start_time<strtotime($d['Discount']['end_time'])) {
							if ($end_time>strtotime($d['Discount']['start_time'])) {
								//overlap with other discount
								$ret[]='Saturday';
							}
						}
					}
					
					if ($this->data['Discount']['sunday']=='1' && $d['Discount']['sunday']=='1') {
						if ($start_time<strtotime($d['Discount']['end_time'])) {
							if ($end_time>strtotime($d['Discount']['start_time'])) {
								//overlap with other discount
								$ret[]='Sunday';
							}
						}
					}
				}
				
				if (!empty($ret)) {
					$ret = array_unique($ret);
					$f = implode(", ",$ret);
					$this->Session->setFlash('This Discount overlaps with another discount for this item.  Please check the days and times and try again. (Overlaps on '.$f.')');
					$this->redirect(array('controller'=>'discounts','action' => 'add/'.$id));
				}
			}
			
			$this->data['Discount']['item_id']=$id;
			if ($this->Discount->save($this->data)) {
				$this->Session->setFlash('Discount Successfully Added.');
				$this->redirect(array('controller'=>'items','action' => 'index'));
			} else {
				$this->Session->setFlash('Error: Failed to Save Discount (discounts, add)');
			}
		}
		$this->set('item',$item);
	}
	
	function edit($did) {
		$this->Discount->id = $did;
		$userinfo = $this->Auth->user();
		if ($userinfo['User']['level']!='1') {
			$this->redirect(array('controller'=>'pages','action' => 'home'));
			$this->Session->setFlash('You Do Not Have Permission To Access This Page');
		}
		
		$disc = $this->Discount->findById($did);
		$id = $disc['Discount']['item_id'];
		$item = $this->Discount->Item->findById($id);
		if (!isset($item['Item'])) {
			$this->Session->setFlash('Error: Item not found (discounts, add)');
			$this->redirect(array('controller'=>'items','action' => 'index'));
		}
		
		if (!empty($this->data)) {
			//check validity
			$disc = $this->Discount->find('all',array('conditions'=>array('Discount.item_id'=>$id,'Discount.id !='=>$did)));
			if (count($disc)!=0) {
				$mins = $this->data['Discount']['start_time']['min'];
				if ($this->data['Discount']['start_time']['meridian']=='pm') {
					if ($this->data['Discount']['start_time']['hour']=='12') {
						$hours = 12;
					} else {
						$hours = $this->data['Discount']['start_time']['hour']+12;
					}
				} else {
					if ($this->data['Discount']['start_time']['hour']=='12') {
						$hours = 0;
					} else {
						$hours = $this->data['Discount']['start_time']['hour'];
					}
				}
				$start_time = mktime($hours,$mins,0);
				$mine = $this->data['Discount']['end_time']['min'];
				if ($this->data['Discount']['end_time']['meridian']=='pm') {
					if ($this->data['Discount']['end_time']['hour']=='12') {
						$houre = 12;
					} else {
						$houre = $this->data['Discount']['end_time']['hour']+12;
					}
				} else {
					if ($this->data['Discount']['end_time']['hour']=='12') {
						$houre = 0;
					} else {
						$houre = $this->data['Discount']['end_time']['hour'];
					}
				}
				$end_time = mktime($houre,$mine,0);
				
				$ret = array();
				foreach ($disc as $d) {
					if ($this->data['Discount']['monday']=='1' && $d['Discount']['monday']=='1') {
						if ($start_time<strtotime($d['Discount']['end_time'])) {
							if ($end_time>strtotime($d['Discount']['start_time'])) {
								//overlap with other discount
								$ret[]='Monday';
							}
						}
					}
					
					if ($this->data['Discount']['tuesday']=='1' && $d['Discount']['tuesday']=='1') {
						if ($start_time<strtotime($d['Discount']['end_time'])) {
							if ($end_time>strtotime($d['Discount']['start_time'])) {
								//overlap with other discount
								$ret[]='Tuesday';
							}
						}
					}
					
					if ($this->data['Discount']['wednesday']=='1' && $d['Discount']['wednesday']=='1') {
						if ($start_time<strtotime($d['Discount']['end_time'])) {
							if ($end_time>strtotime($d['Discount']['start_time'])) {
								//overlap with other discount
								$ret[]='Wednesday';
							}
						}
					}
					
					if ($this->data['Discount']['thursday']=='1' && $d['Discount']['thursday']=='1') {
						if ($start_time<strtotime($d['Discount']['end_time'])) {
							if ($end_time>strtotime($d['Discount']['start_time'])) {
								//overlap with other discount
								$ret[]='Thursday';
							}
						}
					}
					
					if ($this->data['Discount']['friday']=='1' && $d['Discount']['friday']=='1') {
						if ($start_time<strtotime($d['Discount']['end_time'])) {
							if ($end_time>strtotime($d['Discount']['start_time'])) {
								//overlap with other discount
								$ret[]='Friday';
							}
						}
					}
					
					if ($this->data['Discount']['saturday']=='1' && $d['Discount']['saturday']=='1') {
						if ($start_time<strtotime($d['Discount']['end_time'])) {
							if ($end_time>strtotime($d['Discount']['start_time'])) {
								//overlap with other discount
								$ret[]='Saturday';							
							}
						}
					}
					
					if ($this->data['Discount']['sunday']=='1' && $d['Discount']['sunday']=='1') {
						if ($start_time<strtotime($d['Discount']['end_time'])) {
							if ($end_time>strtotime($d['Discount']['start_time'])) {
								//overlap with other discount
								$ret[]='Sunday';
							}
						}
					}
				}
				
				if (!empty($ret)) {
					$ret = array_unique($ret);
					$f = implode(", ",$ret);
					$this->Session->setFlash('This Discount overlaps with another discount for this item.  Please check the days and times and try again. (Overlaps on '.$f.')');
					$this->redirect(array('controller'=>'discounts','action' => 'edit/'.$did));
				}
			}
			
			$this->Discount->id=$did;
			if ($this->Discount->save($this->data)) {
				$this->Session->setFlash('Discount Successfully Modified.');
				$this->redirect(array('controller'=>'discounts','action' => 'index'));
			} else {
				$this->Session->setFlash('Error: Failed to Save Discount (discounts, edit)');
			}
		} else {
			$this->data = $this->Discount->read();
		}
		$this->set('item',$item);
		$this->set('did',$did);
	}
    
	function delete($id,$setup=null) {
		$userinfo = $this->Auth->user();
		if ($userinfo['User']['level']!='1') {
			$this->redirect(array('controller'=>'pages','action' => 'home'));
			$this->Session->setFlash('You Do Not Have Permission To Access This Page');
		}
		$this->Discount->delete($id);
		$this->Session->setFlash('Discount Successfully Deleted.');
		if ($setup=='1') {
			$this->redirect(array('action'=>'setup'));
		} else {
			$this->redirect(array('action'=>'index'));
		}
	}
	
	/*function setup() {
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
	}*/
    
}

?>