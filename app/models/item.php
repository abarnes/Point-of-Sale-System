<?php
/*------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
-------------------------------------------------------------------------------*/
class Item extends AppModel {
    var $name = 'Item';
    var $belongsTo = 'Category';
    var $hasMany = array('Discount');
    var $hasAndBelongsToMany = array(
        'Modifier' =>
            array(
                'className'              => 'Modifier',
                'joinTable'              => 'items_modifiers',
                'foreignKey'             => 'item_id',
                'associationForeignKey'  => 'modifier_id',
                'unique'                 => true,
                'conditions'             => '',
                'fields'                 => '',
                'order'                  => '',
                'limit'                  => '',
                'offset'                 => '',
                'finderQuery'            => '',
                'deleteQuery'            => '',
                'insertQuery'            => ''
            )
    );
    var $validate = array(
        'name' => array(
            'rule' => '/^[a-z0-9A-Z\s]{1,}$/i',
            'message' => 'Only letters and numbers allowed.'
        )
    );
}
?>