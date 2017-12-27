<?php  
/* 
Template Name:deletesuc page
*/
get_header();
?>                      		


<?php
if(isset($_GET['uid'])){ 
global $wpdb;
 $id=$_GET['uid'];
 $x=$_GET['uname'];
$table_name = $wpdb->prefix . "bond";
    
          $row = $wpdb->get_results("DELETE FROM $table_name WHERE user_id=$id");
          if($row>0){
           echo '<script type="text/javascript">';        
      echo 'window.location= "http://bondjumpers.com/view?page=View&uname='.$x.'"';
      echo '</script>'; 
		}
        else{
		  echo "not";
				
        }

	
			
	
	   
}
			 ?>
    
     <style>
     
     .login,.signup,.or{display:none;}
     
     .logout{display:block;}
     
     
     </style>     




<?php get_footer(); ?>
