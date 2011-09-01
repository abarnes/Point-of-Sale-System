<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Barnes Point of Sale System</title>
    <?php echo $html->css('gimmecustom'); ?>
    <?php echo $html->css('customstyle'); ?>
    <?php echo $html->script('jquery'); ?>
    <?php echo $html->script('jquery.min'); ?>
  </head>
  <body>
      <?php echo $html->image('mylogo2.png',array('style'=>'float:left;position:absolute;top:16px;')); ?>
      
      <div id="main" class="shadow">
        <?php echo $content_for_layout; ?>
      </div>  
  </body>
</html>