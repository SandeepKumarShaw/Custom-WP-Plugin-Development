
<?php 

/*
Template Name: copun
*/

?>
<?php get_header();
?>




        </head>

        <body>
        <?php
        //if ( isset( $_SESSION['user_id'])){ 

        if(!isset($_SESSION['user_id'])):
        //header("Location: http://localhost/coupon.demostage.net/");
        //exit();
        wp_redirect('http://coupon.demostage.net/');
        exit();
        endif;    

        
        ?>
<section class="my_account">
    <div class="container">
                   <div class="row strt" id="frsts_sc">
           <div class="col-md-12 sc_logo">
             <div class="sc_logos_in">
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/coupon-butter-logo.png" class="img-responsive"/>
        </div>
        </div>
        </div></div>

<div class="menu_header">
             <div class="container">
             <div class="row strt">
             
             <div class="col-md-5">
             <div class="header_tx">
                  <p>Coupon</p>
             </div>
             </div>
 

        <?php include( get_template_directory() . '/menu_header.php'); ?>

                      
              
        <div class="centers_get_coupon">
        <div class="container">
        <div class="my_account_main">

        <?php if($_GET['coupon_id'])  

        {
        $_SESSION['coupon_id']=$_GET['coupon_id'];
        //echo $_SESSION['coupon_id'];
        ?>
       <form method="post" action="">
        <div class="coupon_access">
        <div class="row">
        <div class="col-md-9">
        <div class="name_coupon_1">

        <?php $sql5="SELECT * FROM `wp_coupon_create` WHERE coupon_id='$_GET[coupon_id]'";
        // echo $sql5; 
        $row5 = $wpdb->get_results($sql5);
        //print_r($row5);

        foreach ($row5 as $row6){ 
            $_SESSION['coupon_logo'] = $row6->coupon_logo;
            //echo $_SESSION['coupon_logo'];
            //$coupon_id=$row6->coupon_id;
            $_SESSION['coupon_pdf_path']= $row6->coupon_pdf_path;
                        $_SESSION['coupon_name']= $row6->coupon_name;

            $file = $row6->coupon_pdf_path;
        $name=$row6->coupon_name;?>
        <p><?php echo $row6->coupon_name; ?></p>
        <p>Expires:<?php echo $row6->coupon_end_date;?><p>
        <p>Discount Amount:<?php echo "$".$row6->coupon_discount;?></p>
        
        <?php }?>
        
        </div>
        
        
        </div>
        <div class="col-md-3">
         
        <div class="name_coupon_2">
        <div class="drp_dwn">
  <!--<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Assign emails to List
  <span class="caret"></span></button>-->
  <?php 
    $sat=$wpdb->get_results("SELECT * FROM wp_customer_details");
    foreach ($sat as $sats) {
        
        if($sats->customer_cuppon_id == $_GET['coupon_id'])
    {
      $cou_pon_id=  $sats->customer_cuppon_id;
    }else
    {
    //exit;
    }
   }
      
      if($cou_pon_id)
      {
       $san=$wpdb->get_results("SELECT customer_id , customer_name FROM wp_customer_details WHERE customer_cuppon_id='". $cou_pon_id."'");
       foreach ($san as $sans) { ?>
        <select class="form-control sel2" id="sel2" name="number" data-cid="" data-cname="">
<option value="<?php echo $sans->customer_id;?>"> <?php echo $sans->customer_name; ?></option>
</select>
<?php } }  else { ?>
<?php
    $i==0;
   $sql9="SELECT * FROM wp_customer_details WHERE parent_id = 0 AND customer_cuppon_id = 0";
   $row9=$wpdb->get_results($sql9);
   ?>
   
      <select class="form-control" id="sel1" name="number" data-cid="<?php echo $_SESSION['coupon_id']; ?>" data-cname="<?php echo $name; ?>">
       <option value="0"> Assign Emails To List </option>
      <?php foreach ($row9 as $row10){ $i++;
   ?>
        <option id="<?php echo $row10->customer_id;?>" data-cid="<?php echo $_SESSION['coupon_id']; ?>" <?php if($i==0){?> selected="selected" <?php }else{?><?php } ?> value="<?php echo $row10->customer_id;?>" > <?php 
        $_SESSION['customer_id'] = $row10->customer_id;
        echo $row10->customer_name; ?> </option>

        <?php  }?>        
      </select>
        <?php  }?>        

      
     
      
     
</div>

        </div>
        
        </div>
        
        </div>
        
        
        <div class="button_section">
        <div class="row row_button">
        <div class="col-md-3 bt1">
        <a><div class="one_btn" id="delete-button">
        <p><span><i class="fa fa-trash-o" aria-hidden="true"></i></span>delete coupon</p>
        </div></a>
        </div>
        
        <?php include( get_template_directory() . '/get_coupon_link.php'); ?>
        <?php include( get_template_directory() . '/embed_coupon.php'); ?>
       <!--  <div class="col-md-3 bt1">
        <a href="#"><button type="button" class="one_btn" data-toggle="modal" data-target="#myModal">
        <p><span><i class="fa fa-chevron-left" aria-hidden="true"></i><i class="fa fa-chevron-right" aria-hidden="true"></i></span>embed coupon</p>
        </button></a>

 
        </div> -->
         <!-- Modal -->
  
        
        
        <!-- <div class="col-md-3 bt1">
        <a href=""><div class="one_btn hovers facebook-btn" id="share_button">
        <p><span><i class="fa fa-facebook" aria-hidden="true"></i></span>post to facebook</p>
        </div></a>
        </div> -->
       <?php include( get_template_directory() . '/banner.php'); ?>
         
        </div>
        
        </div>
        </div>
        </form>
       <?php  if ( isset( $_POST['number'] ) ) {
    //is submitted
    echo $variable = $_POST['number'];
    $_SESSION['customer_ma']=$variable;
   // wp_redirect("http://coupon.demostage.net/get-coupon/");
} ?>



<!--<div class="Redemmed">
       <p>Coupons Redemmed<p>
         </div>-->
        
        <div class="boosterap_table" id="abc"></div>
        <div id="loadingmessage" style="display:none">
              <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/loading-circle.gif" />
        </div>
        </div>
        </div>
        
        </div>
        
   


        <?php } else {?>
        <div class="row">
        <div class="col-md-9">
        <div class="name_coupon_1">
        <p>
          

 <form class="form-horizontal" id="createcouponForm" method="post" action="" enctype="multipart/form-data">
                
                <div class="form-group">
                    <label for="CouponName" class="col-sm-3 control-label">Coupon Name</label>
                    <div class="col-sm-4">
                        <input type="text" name="couponname" id="coupon-name" placeholder="Enter Coupon Name" class="form-control" autofocus>
                        
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="CouponDiscount" class="col-sm-3 control-label">Enter Offer</label>
                    <div class="col-sm-4">
                        <input type="text" name="coupondiscount" id="cdiscount-name" placeholder="Enter Coupon Discount Amount" class="form-control" autofocus>
                        
                    </div>
                    </div>               
                
              
                  <div class="form-group">
                  <label for="CouponStartDate" class="col-sm-3 control-label">Coupon Start Date</label>
                  <div id="datetimepicker3" class="col-sm-4 input-append">
                    <input data-format="MM/dd/yyyy" type="text" name="sdate" placeholder="MM/dd/yyyy" id="datetimepicker3"></input>
                    <span class="add-on">
                      <i data-time-icon="icon-time" data-date-icon="glyphicon glyphicon-calendar">
                      </i>
                    </span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="CouponEndDate" class="col-sm-3 control-label">Coupon End Date</label>
                  <div id="datetimepicker4" class="col-sm-4 input-append">
                    <input data-format="MM/dd/yyyy" type="text" name="edate" placeholder="MM/dd/yyyy"></input>
                    <span class="add-on">
                      <i data-time-icon="icon-time" data-date-icon="glyphicon glyphicon-calendar">
                      </i>
                    </span>
                  </div>
                </div>                     
                
                 
               <div class="form-group">
                    <label for="PhoneNo" class="col-sm-3 control-label">Phone No.</label>
                    <div class="col-sm-4">
                        <input type="text" name="couponphone" id="coupon-phone" placeholder="Enter Business Phone No" class="form-control" autofocus>
                        
                    </div>
                </div>       
               <div class="form-group">
                    <label for="PhoneNo" class="col-sm-3 control-label">Disclaimer</label>
                    <div class="col-sm-4">
                        <textarea name="desclaimer" id="desclaimer" placeholder="Enter Business Disclaimer" class="form-control" autofocus></textarea>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label for="PhoneNo" class="col-sm-3 control-label">Business Logo</label>
                    <div class="col-sm-4">
                        <input type="file" name="uphoto" id="uphoto" placeholder="Enter Business Logo" class="form-control" autofocus>
                        
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-3 col-sm-offset-3">
                        <!-- <button type="submit" name="sub" class="btn btn-primary btn-block">Add Coupon</button> -->
                        <input type="submit" id='insert' name="submit" value="ADD COUPON" class="btn btn-primary btn-block">
                    </div>
                </div>
                <p id='result'></p>
            </form> 
            <!-- /form --> 

        <?php

        $err = ''; 
        $success = '';
        if(isset($_POST['submit']))
        {
        $name=$_POST['couponname'];
        
        $discount_amount=$_POST['coupondiscount'];
        $sdate=$_POST['sdate'];
        $edate=$_POST['edate'];
        $sdate = new datetime($sdate);
        $edate = new datetime($edate);
        $date1 = date_format($sdate,"Y/m/d");
        $date2 = date_format($edate,"Y/m/d");
        $phone=$_POST['couponphone'];
        $desclaimer=$_POST['desclaimer'];
        $c_code = rand();
        $date = date('Y/m/d');
         if($date2 < $date) { 

            $cstatus="Expired";
         }else
         {
            $cstatus="Active";

         }


        $icon_img=$_FILES["uphoto"]["name"];
        $path_array = wp_upload_dir();
        $path = str_replace('\\', '/', $path_array['path']);
        move_uploaded_file($_FILES["uphoto"]["tmp_name"],$path. "/" . $icon_img);

        $upload_path=$path_array['url']."/";

        $icon_img_path=$upload_path.$icon_img;
        ?>
        

        
        <?php
        $subscriber=$_SESSION['user_id'];
        if( $name == "" || $date1 == "" || $date2 == "") {
        $err = 'Please don\'t leave the required field.';
        } 

        elseif($date1>=$date2)
        {
        $err = 'Please provide later at end date date';
        }else{ 


        include( get_template_directory() . '/mpdf60/mpdf.php');
        $html .= "
        <!doctype html>
        <html>
        <head>
        <meta charset='utf-8'>
        <title></title>
        </head>

        <body>
        <h2 style='text-align:center'>Your Buttery Coupon has Arrived<br><span style='font-size:14px;'>THIS COUPON ENTITLES YOU TO</span>
        </h2>
        <div style='width:625px; height:694px; background:url(".get_template_directory()."/images/coupon-edited.jpg) no-repeat; background-size: 100% 100%; margin:auto;'>

        <div style='width:100%;float:left;margin-left:55px;text-align:center;'>
        <h1 style=' font-size:90px; padding-top:56px; text-align:center; margin:0;'>$".$discount_amount." OFF</h1>
        <h1 style='text-align:center; font-size:18px; font-weight:bold; margin:0;'></h1>
        <p style='text-align:center; font-size:14px; font-weight:bold;'>EXPIRES ".$date2."</p>
        </div>

        <div style='width:100%;float:left;margin-left:55px;text-align:center;'><img src='".$icon_img_path."' style='width:110px;'/></div>

        <div style='width:100%;float:left;margin-left:55px;text-align:center;'><h2 style=' font-size:18px; font-weight:bold;margin-bottom:0;'>".$_SESSION['business_name']."<br><span style=' font-size:16px;'>".$_SESSION['business_address']."</span><br>".$phone."<br><span style=' font-size:16px;'>".$_SESSION['business_website']."</span></h2>
        </div>

        <div style='width:100%;float:left;margin-left:55px;text-align:center;padding:0 50px'><p style='font-size:12px;'>".$desclaimer."</p></div>

        <div style=' width:100%;float:left;margin-left:55px;text-align:center;'><barcode code='".$c_code."' type='QR' error='M' class='barcode' /></div>

        <div style=' width:100%;margin-left:55px;float:left; text-align:center;'><h2 style=' font-size:12px; font-weight:bold;'>COUPON #: ########<br><span style=' font-size:13px;'>RESTAURANT OWNERS SCAN HERE TO REDEEM</span></h2>
        </div>
        </div>
        <div style='width:625px;float:left;margin-top:30px;'>
        <img src='".get_template_directory()."/images/coupon-butter-logo.png' style='margin-left:172px;'/>
        </div>
        <div style='width:783px;float:left;text-align:center; margin-left:112px; margin:auto; margin-bottom:40px;'><p style=' font-size:10px;'>
        <h3 style='padding:0; margin:0 ;'>www.couponbutter.com</h3>

        <p>Restaurant Disclaimer goes here. Restaurant Disclaimer goes here. Restaurant
        Disclaimer goes here. Restaurant Disclaimer goes here. Restaurant Disclaimer
        goes here. Restaurant Disclaimer goes here. Restaurant Disclaimer goes here</p></div>
        </body>
        </html>
        ";

        error_reporting(E_ALL); 
        ini_set('display_errors', 1);

        $mpdf=new mPDF();
        $mpdf->WriteHTML($html);
        $mpdf->SetDisplayMode('fullpage');   
        $p_path=$mpdf->Output('pdf/'.$c_code.'-coupon.pdf','F');
        $save_path=$mpdf->Output('pdf/'.$c_code.'-coupon-image.jpg','F');
        //$p_path=$mpdf->Output($p_full,'F');
        $p_full=get_bloginfo('url').'/pdf/'.$c_code.'-coupon.pdf';
        
        $savepath=get_bloginfo('url').'/pdf/'.$c_code.'-coupon-image.jpg';
        
        //$img = new imagick($p_full.'[0]');
//set new format
//$img->setImageFormat('jpg');
 
//save image file
//$img->writeImage($savepath);

global $wpdb;
$table_name=$wpdb->prefix . "coupon_create";
$sql="INSERT INTO $table_name SET  coupon_id='".$c_code."',coupon_name='".$name."', coupon_status='".$cstatus."',coupon_discount='".$discount_amount."',coupon_start_date='".$date1."',coupon_end_date='".$date2."',coupon_phone='".$phone."',coupon_disclaimer='".$desclaimer."',coupon_logo='$icon_img_path',coupon_pdf_path='".$p_full."', coupon_image_path
='".$savepath."',cuppon_subscriber_id='".$subscriber."',time_stamp='".time()."'"; 
        //  echo $sql;
        // die;    
        $result = $wpdb->query($sql);
        


        if ($result){
        $err = 'Coupon successfully added.';  
        //echo "<a href='".$p_full."'>download </a>";
        $sat="SELECT time_stamp FROM wp_coupon_create";
        $san=$wpdb->get_results($sat);
        $dhrm=0;
        foreach ($san as $raj ) {
            
            $ash=$raj->time_stamp;
            if($ash>$dhrm)
            {
                $dhrm=$ash;

            }
        }

        $sant="SELECT coupon_id FROM wp_coupon_create WHERE time_stamp=$dhrm";
        $santa=$wpdb->get_results($sant);
        foreach ($santa as $santan )
        {
          echo $coupon_id123=$santan->coupon_id;

        }

        wp_redirect("http://". $_SERVER['SERVER_NAME']."/view-coupon/?coupon_id=$coupon_id123");

         //wp_redirect("http://". $_SERVER['SERVER_NAME']."/manage-cupon/");

        }
        }



        }
        ?>
        <p>
        <?php 
        if( !empty($err) )
        echo $err;        

        ?></p>

        </p>
        </div>
        
        
        </div>
        
        
 <!--        <div class="col-md-3">
         <div class="name_coupon_2">
         <div class="drp_dwn">
   <!--<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Assign emails to List
//   <span class="caret"></span></button>
  
   
     
       <select class="form-control" id="sel1" disabled>
        <option>Assign emails to List</option>
         <option>2</option>
         <option>3</option>
         <option>4</option>      </select> </div>

        </div>
        
        
        
        </div>-->
        
        </div>
        
        
       <!--  <div class="button_section">
        <div class="row row_button">
        <div class="col-md-3 bt1">
        <div class="one_btn trash" id="<?php //echo $key->customer_id; ?>">
       <!-- <p><span><i class="fa fa-trash-o-right" aria-hidden="true"></i></span>delete coupon</p>
        </div>
        </div>
        
        
        <div class="col-md-3 bt1">
        <div class="one_btn">
        <p><span><i class="fa fa-hand-o-right" aria-hidden="true"></i></span>get coupon link</p>
        </div>
        </div>
        
        <div class="col-md-3 bt1">
        <div class="one_btn">
        <p><span><i class="fa fa-chevron-left" aria-hidden="true"></i><i class="fa fa-chevron-right" aria-hidden="true"></i></span>embed coupon</p>
        </div>
        </div>
        
        
        <div class="col-md-3 bt1">
        <div class="one_btn hovers facebook-btn">
        <p><span><i class="fa fa-facebook" aria-hidden="true"></i></span>post to facebook</p>
        </div>
        </div>
        </div>
        
        </div>-->
        <?php } ?>
        
        
</section>
<?php get_footer();?>