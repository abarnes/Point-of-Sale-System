<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<?php echo $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<script type="text/javascript">  
				function opend(id) {
				    $('#dialog'+id).dialog('open');
				}
</script>
<h3>Manage Discounts</h3>

<div class="link">
<p>Manage your scheduled discounts here.  To add a discount, click the "View Items" link and the "add discount" link next to the item you choose.</p>
<br/>
<?php echo $html->link('<< Admin Panel',array('controller'=>'pages','action'=>'admin')); ?>
<a href="/items" style="margin-left:25px;">View Items</a>
<br/><br/>
</div>

<table>
    <tr>
        <th>
            <?php echo $this->Paginator->sort('Item', 'Item.name'); ?>
        </th>
        <th>
            <?php echo $this->Paginator->sort('Enabled', 'Discount.enable'); ?>
        </th>
        <th>
            <?php echo $this->Paginator->sort('Discount Price', 'Discount.price'); ?>
        </th>
	<th>
            Actions
        </th>
    </tr>
    <?php foreach ($discounts as $u) { ?>
    <tr>
        <td>
            <?php echo $u['Item']['name']; ?>
        </td>
        <td>
            <?php
            switch ($u['Discount']['enable']) {
                case 1:
                    $en = 'yes';
                    break;
                case 0:
                    $en = 'no';
                    break;
                default:
                    $en = 'no';
                    break;
            }
            echo $en; ?>
        </td>
        <td>
            <?php if ($u['Discount']['price']>0) { ?>
		$<?php echo $u['Discount']['price']; ?>		
	    <?php } else { ?>
		free
	    <?php } ?>
        </td>
	<td>
            <script type="text/javascript">
		$(function(){
                                // Dialog
				
				    $('#dialog<?php echo $u['Discount']['id']; ?>').dialog({
					    autoOpen: false,
					    width: 600,
					    buttons: {
						    "Close": function() { 
							    $(this).dialog("close"); 
						    }
					    }
				    });
				});
	    </script>
	    
	    <?php echo '<input style="width:70px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="View" onclick="opend('.$u['Discount']['id'].')">'; ?>
	    <!--this div is what comes up when you click "view"-->
		<div id="dialog<?php echo $u['Discount']['id']; ?>" title="<?php echo $u['Item']['name']; ?> Discount">
		<br/>
		    <table>
			<tr>
			    <td><b>Discount Price</b></td>
			    <td>$<?php echo $u['Discount']['price']; ?></td>
			</tr>
			<tr>
			    <td><b>Normal Price</b></td>
			    <td>$<?php echo $u['Item']['price']; ?></td>
			</tr>
			<tr>
			    <td><b>Days</b></td>
			    <?php
			    $str = '';
			    $co = 0;
			    if ($u['Discount']['monday']=='1') {
				$str = $str.'Monday, ';
				$co++;
			    }
			    if ($u['Discount']['tuesday']=='1') {
				$str = $str.'Tuesday, ';
				$co++;
			    }
			    if ($u['Discount']['wednesday']=='1') {
				$str = $str.'Wednesday, ';
				$co++;
			    }
			    if ($u['Discount']['thursday']=='1') {
				$str = $str.'Thursday, ';
				$co++;
			    }
			    if ($u['Discount']['friday']=='1') {
				$str = $str.'Friday, ';
				$co++;
			    }
			    if ($u['Discount']['saturday']=='1') {
				$str = $str.'Saturday, ';
				$co++;
			    }
			    if ($u['Discount']['sunday']=='1') {
				$str = $str.'Sunday, ';
				$co++;
			    }
			    if ($co!=7) {
				$str = substr($str,0,-2);
			    } else {
				$str = 'Every Day';
			    }
			    
			    ?>
			    <td><?php echo $str; ?></td>
			</tr>
			<tr>
			    <td><b>Time</b></td>
			    <td><?php echo date('h:i a',strtotime($u['Discount']['start_time'])).' - '.date('h:i a',strtotime($u['Discount']['end_time'])); ?></td>
			</tr>
		    </table>
		</div>
		<SCRIPT type="text/javascript">
				function decision(url){
				    if(confirm('Are you sure you want to delete this discount?')) location.href = url;
				}
				</SCRIPT>
		<?php
		echo '<input style="width:70px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="Edit" onclick="parent.location=\'/discounts/edit/'.$u['Discount']['id'].'\'">';
		echo '<input style="width:70px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="Delete" onclick="decision(\'/discounts/delete/'.$u['Discount']['id'].'\')">';
		?>
            <?php //echo $html->link('Edit',array('action'=>'edit/'.$u['Discount']['id'])); ?>
            <?php /*echo $html->link(
				'Delete', 
				array('controller'=>'discounts','action'=>'delete/'.$u['Discount']['id']), 
				null, 
				'Are You Sure You Want To Delete This Discount?'
			);*/ ?>
        </td>
    </tr>
    <?php } ?>
</table>
<div class="link" style="text-align:center;width:100%;">
    <!-- Shows the page numbers -->
    <?php echo $this->Paginator->prev('<< Previous', null, null, array('class' => 'disabled')); ?>
    <?php echo $this->Paginator->numbers(); ?>
    <?php echo $this->Paginator->next('Next >>', null, null, array('class' => 'disabled')); ?>
    <br/>
    <!-- prints X of Y, where X is current page and Y is number of pages -->
    <?php echo $this->Paginator->counter(); ?>
</div>