<?php  
/* 
Template Name:searchlisting page
*/

get_header();
?>


<div class="listing_list">

	
    
    
       <!-- <div class="lis_50 lis_501">
        	
            <div class="min_list" >
            	<div class="lis_50_left">Name :</div>
            	<div class="lis_50_right"> <strong>rahul singh</strong> </div>
            <div class="clear"></div>
            </div>
            <div class="min_list" >
            	<div class="lis_50_left">Gender :</div>
            	<div class="lis_50_right"> <strong>M</strong> </div>
            <div class="clear"></div>
            </div>
            <div class="min_list" >
            	<div class="lis_50_left">Date of Birth :</div>
            	<div class="lis_50_right"> <strong>rahul singh</strong> </div>
            <div class="clear"></div>
            </div>
            <div class="min_list" >
            	<div class="lis_50_left">Age :</div>
            	<div class="lis_50_right"> <strong>27</strong> </div>
            <div class="clear"></div>
            </div>
            
            <div class="min_list" >
            	<div class="lis_50_left">Race :</div>
            	<div class="lis_50_right"> <strong>a</strong> </div>
            <div class="clear"></div>
            </div>
            <div class="min_list" >
            	<div class="lis_50_left">Height :</div>
            	<div class="lis_50_right"> <strong>a</strong> </div>
            <div class="clear"></div>
            </div>
            
		</div>-->



<?php


  if(isset($_GET['uname'])){    
    
          global $wpdb;
          $id=$_GET['uname'];  
          $table_name = $wpdb->prefix . "bond";
          $row        = $wpdb->get_results("SELECT * FROM $table_name WHERE user_id=$id");
          
          //print_r($row);
          
          
			  foreach ($row as $rows){
				  
				  ?>
				  <div class="top_h1">Offender Name: <strong><?php echo $rows->fname; ?> <?php echo $rows->lname; ?></strong></div>
				  
				  <div class="lis_51" style="text-align:right;">
    	<img width="220" height="170" src="<?php echo $rows->uphoto;?>">
    </div>
    
				  <div class="lis_52 lis_501"> 
				  <div class="min_list" >
            	<div class="lis_50_left">Last Name:</div>
            	<div class="lis_50_right"> <strong><?php echo $rows->lname; ?></strong> </div>
            <div class="clear"></div>
            </div>
            <div class="min_list" >
            	<div class="lis_50_left">First Name:</div>
            	<div class="lis_50_right"> <strong><?php echo $rows->fname; ?></strong> </div>
            <div class="clear"></div>
            </div>
            <div class="min_list" >
            	<div class="lis_50_left">Date of Birth:</div>
            	<div class="lis_50_right"> <strong><?php echo $rows->dob; ?></strong> </div>
            <div class="clear"></div>
            </div>
            <div class="min_list" >
            	<div class="lis_50_left">Bonding Company:</div>
            	<div class="lis_50_right"> <strong><?php echo $rows->company; ?></strong> </div>
            <div class="clear"></div>
            </div>            
            <div class="min_list" >
            	<div class="lis_50_left">Bonding Company Phone No.:</div>
            	<div class="lis_50_right"> <strong><?php echo $rows->phone; ?></strong> </div>
            <div class="clear"></div>
            </div>
            
            <div class="min_list" >
            	<div class="lis_50_left">County:</div>
            	<div class="lis_50_right"> <strong><?php echo $rows->country; ?></strong> </div>
            <div class="clear"></div>
            </div>
            <div class="min_list" >
            	<div class="lis_50_left">Charge:</div>
            	<div class="lis_50_right"> <strong><?php echo $rows->charge; ?></strong> </div>
            <div class="clear"></div>
            </div>
            <div class="min_list" >
            	<div class="lis_50_left">Date of Charge:</div>
            	<div class="lis_50_right"> <strong><?php echo $rows->dateofcharge; ?></strong> </div>
            <div class="clear"></div>
            </div>
				</div>  
				 
				
				
		<?php		
				
            
		    }
            
             
            
 }                         
                        // echo  $wpdb->last_error;
                       // echo $wpdb->last_query ; 


?>	
<?php //print_r($_POST);?>	

<div class="clear"></div>
</div>        

<div class="clear"></div>

  
<?php get_footer(); ?>
