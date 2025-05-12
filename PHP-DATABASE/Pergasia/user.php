<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Άσκηση 06</title>
  <link rel="stylesheet" type="text/css" href="mycss.css"/>
</head>
<body>

  <div id="container">
<?php require('is_logged_in.php'); ?>
  
<?php require('header.php'); ?>

<?php require('leftsidebar.php'); ?>

     <div id="main">
      <p>Αυτή είναι η Περιορισμένης Πρόσβασης Σελίδα Χρήστη</p>
		<?php 
		echo_msg(); 
		echo '<p>Hello '.$_SESSION['username'].'!</p>';
		?>
		
    </div> 


<?php require('footer.php'); ?>  


  
  </div>

</body>
</html>
