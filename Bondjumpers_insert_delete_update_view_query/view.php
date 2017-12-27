<?php  
/* 
Template Name:view 
*/

get_header();
?>
<div class="res_table">
 <table class="table table-bordered table-condensed">
 <thead>
 <tr>
 <th width="10%">Last Name</th>
 <th width="10%">First Name</th>
 <th width="15%">Date of Birth</th>
 <th width="10%">County</th>
 <th width="17%">Bonding Company</th>
 <th width="25%">Bonding Company Phone No.</th>
 <th width="8%">Update</th>
 <th width="5%">Delete</th>
 </tr>
 </thead>
 
 <tbody>
 <?php
 if ( isset( $_GET['uname'] )){	 

 $x=$_GET['uname'];
 //echo $x;
 //print_r($post);
$table_name = $wpdb->prefix . "bond";
	    $row = $wpdb->get_results("SELECT * FROM $table_name where uname='".$x."'");
		 //print_r($post);
  if($row){
foreach ($row as $rows){
					
					
					echo "<tr>";
                    echo "<td>" . $rows->lname . "</td>";
                    echo "<td>" . $rows->fname . "</td>";
                    echo "<td>" . $rows->dob . "</td>";
					echo "<td>" . $rows->country . "</td>";
					echo "<td>" . $rows->company . "</td>";
                    echo "<td>" . $rows->phone . "</td>";
                   
					echo "<td><a href='http://bondjumpers.com/edit?page=edit&uid=$rows->user_id'>Edit</a></td>";
					echo "<td><a href='http://bondjumpers.com/delete?page=delete&uid=".$rows->user_id."&uname=".$x."'>X</a></td>";
                    
                    echo "</tr>";
			  
				}
				//print_r($post);
  }
  else{
   
  
				    echo "<tr>";
				  	echo "<td colspan=\"5\"><p style=\"color:#CF1D01 !important;text-align:center !important;\"><b>No Persons found with the information provided</b></p></td>";
                    echo "</tr>";
					
  }
}				
   ?> 
  
     <style>
     
     .login,.signup,.or{display:none;}
     
     .logout{display:block;}
     
     
     </style>           
                
</tbody>
 </table>		
 </div>
<?php //print_r($_POST);?>	
<?php get_footer(); ?>

