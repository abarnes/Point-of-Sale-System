<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<div id="home">
    <?php echo $this->Paginator->options(array('url' => $this->passedArgs)); ?>
    
    <div class="toolbar"><a class="back" href="/tickets/menu" rel="external">Menu</a><h1><?php if ($all=='0') { ?>Your<?php }else{ ?>All<?php } ?> Tickets</h1><a class="button slideup" href="#options">Options</a></div>
    
    <ul class="metal">
	<?php foreach ($tickets as $u) { ?>
	    <?php if ($u['Type']['use_tables']=='1') { ?>
	    <li class="arrow">
		<a href="/tickets/view/<?php echo $u['Ticket']['id']; ?>" rel="external">
		<small>#<?php echo $u['Ticket']['dailyid']; ?></small>
		Table <?php echo $u['Ticket']['table']; ?>
		<em><?php echo $u['Type']['name']; ?></em>
		</a>
	    </li>
	    <?php } else { ?>
	    <li class="arrow">
		<a href="/tickets/view/<?php echo $u['Ticket']['id']; ?>" rel="external">
		<small>#<?php echo $u['Ticket']['dailyid']; ?></small>
		Order
		<em><?php echo $u['Type']['name']; ?></em>
		</a>
	    </li>
	    <?php } ?>
	<?php } ?>
    </ul>
    
    <?php //echo $form->end('Combine Tickets'); ?>
    <br/>
    <div class="link" style="text-align:center;width:100%;">
	<!-- Shows the page numbers -->
	<h3><?php echo $this->Paginator->prev('<< Previous',array('rel'=>'external'), null, array('class' => 'disabled','rel'=>'external')); ?>
	<?php //echo $this->Paginator->numbers(); ?>
	<?php echo $this->Paginator->next('Next >>',array('rel'=>'external'), null, array('class' => 'disabled')); ?>
	<br/>
	<!-- prints X of Y, where X is current page and Y is number of pages -->
	<?php echo $this->Paginator->counter(); ?></h3>
    </div>
    <br/>
</div>

<div id="options">
    <script type="text/javascript">
    function opened(){
        var jQT = new $.jQTouch();
	jQT.goTo('#home');
    }
    </script>
    <div class="toolbar"><a class="other" href="#" rel="external" onclick="opened()">Back</a><h1>Options</h1></div>
    
    <h1 style="color:white;">Sort By</h1>
    <ul class="rounded">
	<li><?php echo $this->Paginator->sort('ID', 'Ticket.dailyid',array('rel'=>'external')); ?></li>
	<li><?php echo $this->Paginator->sort('Table', 'Ticket.table',array('rel'=>'external')); ?></li>
	<li><?php echo $this->Paginator->sort('Type', 'Type.name',array('rel'=>'external')); ?></li>
    </ul>
    <h1 style="color:white;">Tickets Shown</h1>
    <ul class="rounded">
	<?php
	if ($all=='0') { ?>
	    <li><a href="/tickets/index/all" rel="external">View All Tickets</a></li>
	<?php } else { ?>
	    <li><a href="/tickets/index" rel="external">Only My Tickets</a></li>
	<?php } ?>
    </ul>
</div>