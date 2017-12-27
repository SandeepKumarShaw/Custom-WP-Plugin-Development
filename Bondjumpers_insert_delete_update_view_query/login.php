<?php  
/* 
Template Name:Signin page
*/

get_header();
?>
<!--Signin forms -->

	<div class="login_page_coding gform_wrapper  padding650 wid50">
        <h1>SIGN IN</h1>
        <form action="http://bondjumpers.com/listing?page=listing" method="post" >
        <p>
        <span>Username</span>
        <input id="uname" name="uname" type="text" required="required"><?php echo $Error;?></p>    
        <p>
        <span>Password</span>
        <input id="password" name="password" type="password" required="required"><?php echo $Error;?></p>    
        <p><input type="submit" name="submit" value="submit" class="fontt" /></p>
        </form>
    </div>
    
    

<?php //print_r($_POST);?>	
<?php get_footer(); ?>

