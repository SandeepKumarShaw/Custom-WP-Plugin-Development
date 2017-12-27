<?php  
/* 
Template Name:searchlisting
*/

get_header();
?>
<!--Search forms -->

  <div class="res_table">	  
	  <a href=""><strong style="color: #0224bc;">To view offender details click the offenders's name.</strong></a>
    <table class="table table-bordered table-condensed">
 <thead>
 <tr>
 <th>Last Name</th>
 <th>First Name</th>
 <th>Date of Birth</th>
 <th>County</th>
 <th>Bonding Company</th>
 <th>Bonding Company Phone No.</th>
 </tr>
 </thead>
 
 <tbody>
	
 
<?php
       
   
global $wpdb;
$lname = $_POST['lname'];
$fname = $_POST['fname'];
$dob   = $_POST['dob']; 

$table_name = $wpdb->prefix . "bond";
	    //$row = $wpdb->get_results("SELECT * FROM $table_name WHERE lname='$lname'");	
	   //$row = $wpdb->get_results("SELECT * FROM $table_name WHERE lname='$lname' and fname='$fname'");	
	   
	   if(!empty($lname)){
		   
		   if(!empty($fname)){
			   
			  $row = $wpdb->get_results("SELECT * FROM $table_name WHERE lname='$lname' and fname='$fname'"); 
			  if($row){
				foreach ($row as $rows){
					
					//echo $rows->user_id;
					echo "<tr>";
                    echo "<td><a href=' http://bondjumpers.com/searchlisting-page?page=searchlisting-page&uname=$rows->user_id'>" . $rows->lname . "</a></td>";
                    echo "<td><a href=' http://bondjumpers.com/searchlisting-page?page=searchlisting-page&uname=$rows->user_id'>" . $rows->fname . "</a></td>";
                    echo "<td>" . $rows->dob . "</td>";
                    echo "<td>" . $rows->country . "</td>";
                    echo "<td>" . $rows->company . "</td>";
					echo "<td>" . $rows->phone . "</td>";
                    echo "</tr>";
			  
				  }
				}
				else{
				    echo "<tr>";
				  	echo "<td colspan=\"5\"><p style=\"color:#CF1D01 !important;text-align:center !important;\"><b>No Persons found with the information provided</b></p></td>";
                    echo "</tr>";
					
									  	
					
				}
				
				
			   
			   
			   }else{
				   
				   if(!empty($dob)){
					   
					    $row = $wpdb->get_results("SELECT * FROM $table_name WHERE lname='$lname' and dob='$dob'"); 
			           if($row){
				foreach ($row as $rows){
					
					//echo $rows->user_id;
					echo "<tr>";
                    echo "<td><a href=' http://bondjumpers.com/searchlisting-page?page=searchlisting-page&uname=$rows->user_id'>" . $rows->lname . "</a></td>";
                    echo "<td><a href=' http://bondjumpers.com/searchlisting-page?page=searchlisting-page&uname=$rows->user_id'>" . $rows->fname . "</a></td>";
                    echo "<td>" . $rows->dob . "</td>";
                    echo "<td>" . $rows->country . "</td>";
                    echo "<td>" . $rows->company . "</td>";
					echo "<td>" . $rows->phone . "</td>";
                    echo "</tr>";
			  
				  }
				}
				else{
				   echo "<tr>";
				  	echo "<td colspan=\"5\"><p style=\"color:#CF1D01 !important;text-align:center !important;\"><b>No Persons found with the information provided</b></p></td>";
                    echo "</tr>";
				}
				   }
				   else{
					   $row = $wpdb->get_results("SELECT * FROM $table_name WHERE lname='$lname'");
				      if($row){
				foreach ($row as $rows){
					
					//echo $rows->user_id;
					echo "<tr>";
                    echo "<td><a href=' http://bondjumpers.com/searchlisting-page?page=searchlisting-page&uname=$rows->user_id'>" . $rows->lname . "</a></td>";
                    echo "<td><a href=' http://bondjumpers.com/searchlisting-page?page=searchlisting-page&uname=$rows->user_id'>" . $rows->fname . "</a></td>";
                    echo "<td>" . $rows->dob . "</td>";
                    echo "<td>" . $rows->country . "</td>";
                    echo "<td>" . $rows->company . "</td>";
					echo "<td>" . $rows->phone . "</td>";
                    echo "</tr>";
			  
				  }
				}
				else{
				     echo "<tr>";
				  	echo "<td colspan=\"5\"><p style=\"color:#CF1D01 !important;text-align:center !important;\"><b>No Persons found with the information provided</b></p></td>";
                    echo "</tr>";
				}
				    
				}
			   
				   
				   
				   
				   }
				   
                       // echo  $wpdb->last_error;
                        //echo $wpdb->last_query ; 
      
		   }
		   
		   
		 
	   
	   
	   			
		
		
		
           
			  
		 
                   
    
    
	
?>
</tbody>
 </table>
 </div>
<?php //print_r($_POST);?>	

  
<?php get_footer(); ?>
