<?php  
/* 
Template Name:editsuc page
*/

get_header();
?>
<?php 
if(isset($_GET['uid'])){ 
global $wpdb;
 $id=$_GET['uid'];
 $x=$_GET['uname'];
$table_name = $wpdb->prefix . "bond";
if($_FILES["uphoto"]["size"]>0)
{
	 $icon_img=$_FILES["uphoto"]["name"];
     $path_array = wp_upload_dir();
     $path = str_replace('\\', '/', $path_array['path']);
     move_uploaded_file($_FILES["uphoto"]["tmp_name"],$path. "/" . $icon_img);
     $upload_path=$path_array['url']."/";
     $icon_img_path=$upload_path.$icon_img;
	 
	 $dob11=$_POST['month11'] . "-" . $_POST['day11'] . "-" .$_POST['year11'];
	 //echo $dob11;
     $dateofbond11=$_POST['month22'] . "-" . $_POST['day22'] . "-" .$_POST['year22'];
	 $dateofcharge11=$_POST['month33'] . "-" . $_POST['day33'] . "-" .$_POST['year33'];
	//echo $dateofbond11;
	//exit;
	 //print_r($_POST);
     $sql="UPDATE $table_name SET lname='".$_POST['lname1']."',company='".$_POST['company1']."',phone='".$_POST['phone1']."',fname='".$_POST['fname1']."',gender='".$_POST['gender1']."',dob='".$dob11."',race='".$_POST['race1']."',height='".$_POST['height1']."',weight='".$_POST['weight1']."',country='".$_POST['country1']."',charge='".$_POST['charge1']."',dateofcharge='".$dateofcharge11."',dateofbond='".$dateofbond11."',uphoto='$icon_img_path'where user_id='".$id."'";
     $rez = $wpdb->query($sql);
	 if ($rez>0){
	 echo '<script type="text/javascript">';        
     echo 'window.location= "http://bondjumpers.com/view?page=View&uname='.$x.'"';
     echo '</script>'; 
		  
		  
		}
        else{
		  echo "not";
				
        }
     


	 
}
else{
	 
	  $dob11=$_POST['month11'] . "-" . $_POST['day11'] . "-" .$_POST['year11'];
	 //echo $dob11;
	 
	  $dateofbond11=$_POST['month22'] . "-" . $_POST['day22'] . "-" .$_POST['year22'];
	//echo $dateofbond11;
	 $dateofcharge11=$_POST['month33'] . "-" . $_POST['day33'] . "-" .$_POST['year33'];
	 $sql="UPDATE $table_name SET lname='".$_POST['lname1']."',company='".$_POST['company1']."',phone='".$_POST['phone1']."',fname='".$_POST['fname1']."',gender='".$_POST['gender1']."',dob='".$dob11."',race='".$_POST['race1']."',height='".$_POST['height1']."',weight='".$_POST['weight1']."',country='".$_POST['country1']."',charge='".$_POST['charge1']."',dateofcharge='".$dateofcharge11."',dateofbond='".$dateofbond11."' where user_id='".$id."'";
     $rez = $wpdb->query($sql);
	 if ($rez>0){
	 echo '<script type="text/javascript">';        
     echo 'window.location= "http://bondjumpers.com/view?page=View&uname='.$x.'"';
     echo '</script>'; 
		  
		  
		}
		else{
		  
		  echo '<script type="text/javascript">';        
     echo 'window.location= "http://bondjumpers.com/view?page=View&uname='.$x.'"';
     echo '</script>'; 
		}
        
     


}


			
	
	   
}
?>
<?php //print_r($_POST);?>	
<?php get_footer(); ?>

