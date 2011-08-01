<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<div id="home"> 
    <div class="toolbar"><h1>Login</h1></div>
    <div style="width:100%; text-align:center;margin-top:4px;">
        <h5><?php echo $session->flash('auth'); ?></h5>
        <h5><?php echo $session->flash(); ?></h5>
    </div>
    
    <div class="label">
    <?php echo $form->create('User', array('action' => 'login')); ?>
    <ul class="edit rounded">
        <li><span style="color:white;float:left;"><?php echo $form->input('username', array( 'label' => '','placeholder'=>'Username')); ?></span></li>
        <li><span style="color:white;float:left;"><?php echo $form->input('password', array('label'=>'','placeholder'=>'Password')); ?></span></li>
    </ul>
        <a class="grayButton" rel="external" onclick="document.forms['UserLoginForm'].submit()">Submit</a>
    </div>
    <br/><br/>
    <p style="color:white;">Demo Version<br/><br/>
    
    You can login with the username "demo" and the password "demo". <br/><br/>
    
    Version 1.4 beta<br/>
    <div class="link">
    <a style="font-size:80%;" href="http://barnespos.com/pages/demo" target="_blank" rel="external">Version info available on Barnespos.com</a>
    </div><br/>
    </p>

</div>