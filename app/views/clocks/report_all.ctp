<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<script type="text/javascript">  
                                function openadd() {
				    $('#filter').dialog('open');
				}
</script>
<script type="text/javascript">
                        $(function(){
                                        // Dialog
                                            $('#filter').dialog({
                                                    autoOpen: false,
                                                    width: 600,
                                                    buttons: {
                                                            "Submit": function() { 
                                                                    document.forms["ClockReportAllForm"].submit(); 
                                                            }
                                                    }
                                            });
                                        });
</script>

<?php echo $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<h3>Shifts</h3>
<p>View completed shifts and manage labor.  Click "Filter" for additional options.</p><br/>

<div class="link">
<?php echo $html->link('<< Admin Panel',array('controller'=>'pages','action'=>'admin')); ?><br/><br/>
</div>

<a style="float:left;margin-bottom:8px;margin-right:5px;" href="#" onclick="openadd()"><input type="button" class="submits" value="Filter"></a>

<div id="filter" title="Filter Records">
    <script>
	$(function() {
		$( "#ClockStartdate" ).datepicker();
		$( "#ClockEnddate" ).datepicker();
	});
    </script>
    <?php echo $form->create('Clock', array('action' => 'report_all')); ?>
    <?php echo $form->input('admins', array('label' => 'Include Admins','checked'=>true,'type'=>'checkbox')); ?>
    <?php echo $form->input('startdate', array( 'label' => 'Start Date: ','value'=>$start)); ?>
    <?php echo $form->input('enddate', array( 'label' => 'End Date: ','value'=>$end)); ?>
    <?php echo $form->input('emps', array( 'label' => 'Employees: <em style="font-size:70%;">Checking no one searches all employees</em>','options'=>$options,'multiple'=>'checkbox')); ?>
</div>

<p>Filter results by using the "Filter" button.</p>

<table>
    <tr>
	<th>
	    <?php echo $this->Paginator->sort('Employee', 'User.full_name'); ?>
	</th>
        <th>
            Shifts
        </th>
        <th>
            Total Time
        </th>
        <th>
            Action
        </th>
    </tr>
    <?php foreach ($clock as $u) { ?>
    <tr>
	<td>
	    <?php echo $html->link($u['User']['full_name'],array('action'=>'report/'.$u['User']['id'])); ?>
	</td>
        <td>
            <?php echo $u['User']['shifts']; ?>
        </td>
	<td>
            <?php echo $u['User']['time']; ?>
        </td>
        <td>
	    <?php echo '<input style="width:170px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="View Employee Report" onclick="parent.location=\'/clocks/report/'.$u['User']['id'].'\'">'; ?>
            <?php //echo $html->link('View Employee Report',array('action'=>'report/'.$u['User']['id'])); ?>
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