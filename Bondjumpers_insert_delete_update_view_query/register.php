<?php  
/* 
Template Name:register page
*/

get_header();
?>

<!--Signup forms -->

  <div class="login_page_coding gform_wrapper  padding650 wid50">
 	<form action="" method="post" enctype="multipart/form-data"> 
 	<h1>SIGN UP</h1>
                
                <p>
                    <span>Email</span>
                    <td><input id="email" name="email" type="email" required="required" > 
                </p>
                 <p>
                    <span>UserName</span>
                   <input id="uname" name="uname" type="text" required="required" > 
                </p>
                 <p>
                    <span>Password</span>
                     <input id="password" name="password" type="password" required="required" > 
                </p>
                
				
				
                <p>
                     <input type="submit" name="sign" class="fontt"> 
                </p>	
               
                </form>
     </div>
    
    



<?php //print_r($_POST);?>	
<?php
global $wpdb;
$table_name = $wpdb->prefix . "bondsignup";

if ( isset( $_POST['sign'] )){	
			
		 $q="SELECT * FROM $table_name WHERE email='".$_POST['email']."' or uname='".$_POST['uname']."'";
		 $wpdb->get_results( $q );
         $count= $wpdb->num_rows;
         if($count>0){
	        echo "Duplicate Field";
	     }else{ 
		    $row= $wpdb->insert( $table_name, array(
		                                        	                                        
		                                        'email'      => $_POST['email'],
		                                        'uname'      => $_POST['uname'],
		                                        'password'   => $_POST['password'],
												
		                                        
												),
		                                   array( '%s', 
										          '%s', 
												  '%s', 
												 
												  
												 ) 
		                    );
		      if($row){
				                //echo "suc";
							    echo '<script type="text/javascript">';        
                                echo 'window.location= "http://bondjumpers.com/login?page=login"';
                                echo '</script>'; 
							   
							   } 
						else{
							  echo "not";
							}	                  

       
		   
		   
		   
		    }
   
   
   
   
   
}   
?>	
<?php get_footer(); ?>
