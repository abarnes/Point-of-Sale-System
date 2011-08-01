<?php
/*------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
-------------------------------------------------------------------------------*/

class User extends AppModel {
    var $name = 'User';
    var $hasMany = array('Clock','Ticket','Payment');
    var $virtualFields = array('full_name' => 'CONCAT(User.last_name, ", ", User.first_name)');
    var $validate = array(
        'username' => array(
            'rule' => 'isUnique',
            'message' => 'This username has already been taken.',
            'required'=>true,
            'allowEmpty'=>false
        ),
        'shortcut' => array(
            'rule' => 'isUnique',
            'message' => 'This shortcut has already been taken.',
            'required'=>true,
            'allowEmpty'=>false
        ),
        'first_name' => array(
            'rule' => 'notEmpty',
            'message' => 'Please supply the first name.',
            'required'=>false,
            'allowEmpty'=>false
        ),
        'last_name' => array(
            'rule' => 'notEmpty',
            'message' => 'Please supply the last name.',
            'required'=>false,
            'allowEmpty'=>false
        ),
         'rate1' => array(
            'rule' => 'numeric',
            'message' => 'Please supply a numeric value for rates.',
            'required'=>true,
            'allowEmpty'=>true
        ),
        'rate2' => array(
            'rule' => 'numeric',
            'message' => 'Please supply a numeric value for rates.',
            'required'=>false,
            'allowEmpty'=>true
        ),
        'rate3' => array(
            'rule' => 'numeric',
            'message' => 'Please supply a numeric value for rates.',
            'required'=>false,
            'allowEmpty'=>true
        )
    );
    
}
?>