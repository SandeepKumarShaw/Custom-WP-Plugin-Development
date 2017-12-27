
<!DOCTYPE html>
<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../classes/Password.php');
?>

<?php 
$pass = new Password();
?>
<head>
<meta charset="utf-8">
<title>Forgot Password</title>
    <link rel="stylesheet" type="text/css" href="css/stylelogin.css" media="screen" />
</head>
<body>
<div class="container">
	<section id="content">
	<?php
     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $forgotPass = $pass->forgotPasswordAdmin($_POST);
 
     		
     	
     }
     
	?>
		<form action="" method="post">
			<h1>Forgot Password</h1>
               <?php
                if (isset($forgotPass)) {
                       echo $forgotPass;
                   }   
               ?>
			<div>
				<input type="text" placeholder="Enter Valid Email.." required="" name="email"/>
			</div>
			
			<div>
				<input type="submit" name="submit" value="Send" />
			</div>
		</form><!-- form -->
          <div class="button">
               <a href="login.php">Login</a>
          </div><!-- button -->
		<!-- <div class="button">
			<a href="#">Training with live project</a>
		</div> button -->
	</section><!-- content -->
</div><!-- container -->
</body>
</html>