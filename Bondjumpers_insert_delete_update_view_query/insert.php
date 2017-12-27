<?php  
/* 
Template Name:insert page
*/

get_header();
?>
<?php 
if ( isset( $_POST['insert'] )){	 
global $wpdb;
$x=$_GET['uname'];
 //$id=$_GET['uid'];
$table_name = $wpdb->prefix . "bond";

     
$icon_img=$_FILES["uphoto"]["name"];
$path_array = wp_upload_dir();
$path = str_replace('\\', '/', $path_array['path']);
move_uploaded_file($_FILES["uphoto"]["tmp_name"],$path. "/" . $icon_img);

$upload_path=$path_array['url']."/";

$icon_img_path=$upload_path.$icon_img;
//print_r($_POST);

$dob1=$_POST['month1'] . "-" . $_POST['day1'] . "-" .$_POST['year1'];
$dateofbond1=$_POST['month2'] . "-" . $_POST['day2'] . "-" .$_POST['year2'];
$dateofcharge1=$_POST['month3'] . "-" . $_POST['day3'] . "-" .$_POST['year3'];
//$dob1=$_POST['year'] . "/" . $_POST['month'] . "/" . $_POST['day'];
$sql="INSERT INTO $table_name SET  uname='".$_POST['uname']."', lname='".$_POST['lname1']."',fname='".$_POST['fname1']."',gender='".$_POST['gender1']."',dob='".$dob1."',race='".$_POST['race1']."',height='".$_POST['height1']."',weight='".$_POST['weight1']."',company='".$_POST['company1']."',phone='".$_POST['phone1']."',country='".$_POST['country1']."',charge='".$_POST['charge1']."',dateofcharge='".$dateofcharge1."',dateofbond='".$dateofbond1."',uphoto='".$icon_img_path."'";
$rez = $wpdb->query($sql);
//print_r($rez);
if ($rez>0){ 
		?>					        
     <form action="http://bondjumpers.com/insert?page=insert&uname=<?php echo $x;  ?>" method="post" enctype="multipart/form-data"> 
  
    
    <div class="listing_list">
	<h4 style="font-size: 21px !important;margin:30px 0;">Hello: <?php echo $x; ?></h4>
<div class="lis_51" style="text-align:right;">
    	<img id="image_upload_preview" width="220" height="170" src="<?php echo get_template_directory_uri(); ?>/testcode/unnamed-edited.jpg" alt="your image"/>
    
    </div>
	
    
    
        <div class="lis_52">
        	
            <div class="min_list" >
            	<div class="lis_50_left">Last Name</div>
            	<div class="lis_50_right"><input id="lname" name="lname1" class="input" type="text"></div>
            <div class="clear"></div>
            </div>
            
            <div class="min_list" >
                <div class="lis_50_left">First Name</div>
                <div class="lis_50_right"><input id="fname" name="fname1" class="input" type="text"></div>
            <div class="clear"></div>
            </div>
			
			            <div class="min_list" >
            	 <div class="lis_50_right"><input type="hidden" id="uname" class="input" name="uname" value="<?php echo $_POST['uname']; ?>"></div>
            <div class="clear"></div>
            </div>
			
            <!--<div class="min_list" >
                <div class="lis_50_left">Email</div>
                <div class="lis_50_right"><input id="email" name="email1" class="input" type="email"></div>
            <div class="clear"></div>
            </div>-->
            <div class="min_list" >
            
                <div class="lis_50_left">Gender</div>
                <div class="lis_50_right">
                	<input type="radio" required="required" name="gender1"   value="M">Male 
                	<br/> 
                	<input type="radio" required="required" name="gender1"    value="F">Female</td>
                </div>
                
            	<div class="clear"></div>
           	</div>
            
            
             
            
           <div class="min_list" >
                <div class="lis_50_left">Date of Birth</div>
                <div class="lis_50_right">
					<input id="p1" name="month1"  maxlength="2"  class="input input_new01_01" placeholder="MM" type="text" style=" ">
				    <input id="p6" name="day1"    maxlength="2"  class="input input_new01_02" placeholder="DD" type="text" style=" ">
					<input id="p6" name="year1"   maxlength="4"  class="input input_new01_03" placeholder="YYYY" type="text" style=" ">
				</div>
				
				<!--<input id="p6" name="day1" size="3" maxlength="2"  class="input" type="text">
				<input id="p7" name="year1" size="5" maxlength="4"  class="input" type="text"> -->
           <div class="clear"></div>
            </div>
		   
		   
            
            
            <!---<div class="min_list" >
                <div class="lis_50_left">Age</div>
                <div class="lis_50_right"><input id="age" name="age1" class="input"  type="text"></div>
              <div class="clear"></div>
            </div> -->     
              <div class="min_list" >
                <div class="lis_50_left">Race</div>
                <div class="lis_50_right"><input id="race" name="race1" class="input"  type="text"></div>
             <div class="clear"></div>
            </div>
             
             
             <div class="min_list" >
                <div class="lis_50_left">Height</div>
                <div class="lis_50_right"><input id="height" name="height1" class="input"  type="text"></div>
             <div class="clear"></div>
            </div>
             <div class="min_list" >
                <div class="lis_50_left">Weight</div>
                <div class="lis_50_right"><input id="weight" name="weight1" class="input"  type="text"></div>
            <div class="clear"></div>
            </div>
            <div class="min_list" >
                <div class="lis_50_left">Bonding Company</div>
                <div class="lis_50_right"><input id="company" name="company1" class="input"  type="text" ></div>
           <div class="clear"></div>
            </div>
			<div class="min_list" >
                <div class="lis_50_left">Bonding Company Phone No.</div>
                <div class="lis_50_right"><input id="phone" name="phone1" class="input"  type="text" ></div>
           <div class="clear"></div>
            </div>
             <div class="min_list" >
                <div class="lis_50_left">County</div>
                <div class="lis_50_right"><input id="country" name="country1" class="input"  type="text"></div>
            <div class="clear"></div>
            </div>
            <div class="min_list" >
                <div class="lis_50_left">Charge</div>
                <div class="lis_50_right"><input id="charge" name="charge1" class="input"  type="text"></div>
            <div class="clear"></div>
            </div>
			 <div class="min_list" >
                <div class="lis_50_left">Date Of Charge</div>
                 <div class="lis_50_right">
				    <input id="p17" name="month3"  maxlength="2"  class="input input_new01_01" placeholder="MM" type="text" style=" ">
				    <input id="p18" name="day3"    maxlength="2"  class="input input_new01_02" placeholder="DD" type="text" style=" ">
					<input id="p19" name="year3"   maxlength="4"  class="input input_new01_03" placeholder="YYYY" type="text" style=" "></div>
            <div class="clear"></div>
            </div>
            <div class="min_list" >
                <div class="lis_50_left">Date Of Bond</div>
                 <div class="lis_50_right">
				    <input id="p2" name="month2"  maxlength="2"  class="input input_new01_01" placeholder="MM" type="text" style=" ">
				    <input id="p8" name="day2"    maxlength="2"  class="input input_new01_02" placeholder="DD" type="text" style=" ">
					<input id="p9" name="year2"   maxlength="4"  class="input input_new01_03" placeholder="YYYY" type="text" style=" "></div>
            <div class="clear"></div>
            </div>
            <div class="min_list" >
                <div class="lis_50_left">Upload Photo</div>
                <div class="lis_50_right"><input id="inputFile" name="uphoto" type="file" class="input"></div>
            <div class="clear"></div>
            </div>
            <div class="min_list" >
            	<div class="lis_50_left">&nbsp;</div>
                <div class="lis_50_right">
                	<a class="button" href="http://bondjumpers.com/view?page=View&uname=<?php echo $x; ?>">View All Forfeitures</a>
                	<input type="submit" name="insert" style="text-align:right;">
                </div>
            <div class="clear"></div>
            </div>
            
        <div class="clear"></div>
        </div>
        
        
    
    
    
    <div class="clear"></div>
    </div>
    
        
     </form>
	 <div></div>
	 
     <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
      <script language="javascript" type="text/javascript">
          function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image_upload_preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#inputFile").change(function () {
        readURL(this);
    });
      </script>  
                
     <style>
     
     .login,.signup,.or{display:none;}
     
     .logout{display:block;}
     
     
     </style>           
                
              
		<?php   
		}
        else{
		  echo "not";
				
        }

	
			
	
	   
}
?>
<?php //print_r($_POST);?>
<style>
			.input_new01_01 { width:50px !important; float: left;}
			.input_new01_02 { width:50px!important; float: left; margin-left: 8px; margin-right: 6px;}
			.input_new01_03 { width:68px!important; float: left;}
			
		   </style>
<?php get_footer(); ?>

