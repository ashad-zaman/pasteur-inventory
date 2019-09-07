<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Installed | Successfully</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<style type="text/css">
body {
	font-size: 12px;
}
.error {
	background: #ffd1d1;
	border: 1px solid #ff5858;
	padding: 4px;
}
</style>
</head>
<body style="background:linear-gradient(90deg, #f9f3f3 0%, #c8d0d6 100%);">
<div class="container" style="margin-top:25px ">
  <div class="row">
    <div class="col-md-6 col-md-offset-5" style="margin-bottom:15px;"> <img src="assets/logo_1548937080.png" /> </div>
    <div class="col-md-6 col-md-offset-3">
      <div class="panel panel-custom">
        <div class="panel-body">
          <div class="alert alert-success" role="alert"> Well done! You have successfully installed the Adapt Stock - Easy Inventory Management System. </div>
          <div class="well well-lg">
            <h4>Please keep bellow login details to login Adapt Stock.</h4>
            <hr/>
            <h6><strong>Default Admin panel Login Details</strong></h6>            
            <p><strong>Username: </strong>fionagrace</p>
            <p><strong>Password: </strong>fgrace$$##</p>
            <hr/> 
            <p><strong>Note:</strong> Set the base url in config.php file which is under application/config/config.php, find the "$config['base_url']" in config.php file, if still problem exist you may contact us at hrsalesoft@gmail.com, we will reply you as soon as possible.</p>
            <?php    
                     $redir = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
                     $redir .= "://".$_SERVER['HTTP_HOST'];
                     $redir .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
                     $redir = str_replace('install/','',$redir); 
                    ?>
            <a href="<?php echo $redir .'admin/' ?>" class="btn btn-success">Go to Login Page</a> </div>
          <p class="error"> For your own security. Please <strong>Delete</strong> or rename <strong>Install</strong> folder </p>
        </div>
        <div class="panel-footer"><?php echo date('Y');?> &copy Adapt Stock - Easy Inventory Management System </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>