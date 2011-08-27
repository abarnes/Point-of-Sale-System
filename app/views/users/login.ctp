<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<script>
		$(function(){
			$('#UserUsername').keyboard({
                                stayOpen:false,
                                autoAccept:true
                            });
		});
                $(function(){
			$('#UserPassword').keyboard({
                                stayOpen:false,
                                autoAccept:true
                            });
		});
    $(window).keypress(function(e) {
        if(e.keyCode == 13) {
            alert('You pressed enter!');
        }
    });
</script>

<h3>Clock In</h3>

<div class="label" style="width:50%;">
<?php
    echo $form->create('User', array('action' => 'login'));
    echo $form->input('username', array( 'label' => 'User: '));
    echo $form->input('password', array('label'=>'Password: '));
    echo $form->end('Login');
?>
</div>

<br/><br/>
<p style="color:white;">Demo Version<br/><br/>

You can login with the username "demo" and the password "demo". <br/><br/>

Version 1.4 beta<br/>
<div class="link">
<a style="font-size:80%;" href="http://barnespos.com/pages/demo" target="_blank">Version info available on Barnespos.com</a>
</div><br/>
</p>

<p style="vertical-align:bottom;">All pages Copyright 2011 Barnes Point of Sale Systems</p>