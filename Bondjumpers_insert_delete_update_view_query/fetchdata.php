<?php  
/* 
Template Name:search page
*/

get_header();
?>
<!--Search forms -->

  
    <form action="http://bondjumper.demostage.net/?page_id=101" method="post" enctype="multipart/form-data">
	<table align="center">
	<tr>
		<td>Last Name</td>
		<td><input id="lname" name="lname" type="text" required="required" ></td>
      	<td>First Name</td>
		<td><input id="fname" name="fname" type="text"></td>
    	<td>Date of Birth</td>
		<td><input id="dob" name="dob" type="text"></td>
		<td><input type="submit" name="search"value="search" /></td>
	</tr>	
	</table>
    </form>
   
<?php //print_r($_POST);?>	

  
<?php get_footer(); ?>
