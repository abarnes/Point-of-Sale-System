<div class="home">
        <div class="toolbar"><h1>Quick Key In</h1></div>
        <div style="width:100%; text-align:center;margin-top:4px;">
                <h5><?php echo $session->flash('auth'); ?></h5>
                <h5><?php echo $session->flash(); ?></h5>
        </div>
        <br/>
        <div class="label">
                <?php echo $form->create('User', array('action' => 'quick_in')); ?>
                <?php //echo $form->input('Ticket.seats', array( 'label' => 'Number of Seats')); ?>
                <input name="data[User][quick]" maxlength="250" id="UserQuick" type="tel" style="width:100%;font-size:1.8em;" autofocus="autofocus"/>
                <br/><br/>
                <?php //echo $form->end('Submit'); ?>
                <a class="grayButton" rel="external" onclick="document.forms['UserQuickInForm'].submit()"/>Submit</a>
                
                <br/><br/>
                <a class="grayButton" rel="external" onclick="parent.location='/users/login'"/>Clock In</a>
        </div>
</div>