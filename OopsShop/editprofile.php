<?php include 'inc/header.php'; ?>
<?php
$login = Session::get("custlogin");
if ($login == false) {
  header("Location: login.php");
}
?>
<?php            
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {   
    $cmrId = Session::get("cmrId");
    $updateCmr    = $cmr->customerUpdate($_POST, $cmrId);
}
?>
<style type="text/css">
	.tblone{width: 550px;margin: 0 auto;border: 2px solid #ddd;}
	.tblone tr td {text-align: justify;}
</style>
 <div class="main">
 <?php
  if (isset($updateCmr)) {
      echo $updateCmr;
  }
 ?>
    <div class="content">
    	<div class="section group">
    	<?php 
    	 $id = Session::get("cmrId");
    	 $getdata = $cmr->getCustomerData($id);
    	 if ($getdata) {
    	 	while ( $result = $getdata->fetch_assoc()) {
    	?>
        <form action="" method="post">
    	   <table class="tblone">
            <tr>            
                <td colspan="2"><h2>Update Your Profile Details...</h2></td>
            </tr>
    	   	<tr>
    	   		<td width="20%">Name</td>    	   		
    	   		<td><input type="text" name="name" value="<?php echo $result['name']; ?>"></td>
    	   	</tr>
    	   	<tr>
    	   		<td>Phome</td>    	   		
    	   		<td><input type="text" name="phone" value="<?php echo $result['phone']; ?>"></td>
    	   	</tr>
    	   	<tr>
    	   		<td>Email</td>    	   		
    	   		<td><input type="text" name="email" value="<?php echo $result['email']; ?>"></td>
    	   	</tr>
    	   	<tr>
    	   		<td>Address</td>    	   		
    	   		<td><input type="text" name="address" value="<?php echo $result['address']; ?>"></td>
    	   	</tr>
    	   	<tr>
    	   		<td>City</td>    	   		
    	   		<td><input type="text" name="city" value="<?php echo $result['city']; ?>"></td>
    	   	</tr>
    	   	<tr>
    	   		<td>ZipCode</td>    	   		
    	   		<td><input type="text" name="zip" value="<?php echo $result['zip']; ?>"></td>
    	   	</tr>
    	   	<tr>
    	   		<td>Country</td>    	   		
    	   		<td><input type="text" name="country" value="<?php echo $result['country']; ?>"></td>
    	   	</tr>
    	   	<tr>
    	   		<td></td>    	   		
    	   		<td><input type="submit" name="submit" value="Save"></td>
    	   	</tr>
    	   </table>
        </form>   
    	<?php 
           }
        } 
    	?>	
    	</div>
 	</div>
	</div>
<?php include 'inc/footer.php'; ?>
  