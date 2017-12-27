<?php 

/*
Template Name: update copun
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
        wp_redirect('http://account.couponbutter.com/');
        exit();
        endif;    

        
        ?>
<section class="my_account">
<div class="mainsheader">
    <div class="container">
        <div class="row strt" id="frsts_sc">
            <div class="col-md-12 sc_logo">
                <div class="sc_logos_in">
                    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/coupon-butter-logo.png" class="img-responsive"/>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="menu_header">
             <div class="container">
             <div class="row strt">
             
             <div class="col-md-5">
             <div class="header_tx">
                  <p>Edit Coupon</p>
             </div>
             </div>

        <?php include( get_template_directory() . '/menu_header.php'); ?>
        <div class="centers_get_coupon">
        <div class="container">
        <div class="my_account_main">
        
        <div class="row">
        <div class="col-md-9">
        <div class="name_coupon_2" id="update-coupon">
        <p>
          
<?php if(isset($_GET['coupon_id']))

{   
    global $wpdb;
    $sql1="SELECT * FROM wp_coupon_create WHERE coupon_id='".$_GET['coupon_id']."'";
    $query5=$wpdb->get_results($sql1);
    foreach ($query5 as $rez) {

        $uname=$rez->coupon_name;
        $uoffer=$rez->coupon_discount;
        $usdate=$rez->coupon_start_date;
        $uedate=$rez->coupon_end_date;
        $uphone=$rez->coupon_phone;
        $udisc=$rez->coupon_disclaimer;
        $ulogo=$rez->coupon_logo;
        $rnname = $rez->resturant_name;
          $rnweb =  $rez->resturant_website;
          $rnadd = $rez->resturant_address;
    }
}
?>
<div class="coupon-feadd">UPDATE COUPON</div>
 <form class="form-horizontal" id="createcouponForm" method="post" action="" enctype="multipart/form-data">
                
    <div class="form-group">
        <label for="CouponName" class="col-sm-3 control-label">Coupon Name</label>
        <div class="col-sm-4">
            <input type="text" name="couponname" id="coupon-name" class="form-control" autofocus value="<?php echo $uname; ?>">
            
        </div>
    </div>
          
    <div class="form-group">
        <label for="CouponName" class="col-sm-3 control-label">Resturant Name</label>
        <div class="col-sm-4">
            <input type="text" name="restnm" id="coupon-name" class="form-control" autofocus value="<?php echo $rnname; ?>">
            
        </div>
    </div>
    <div class="form-group">
        <label for="CouponName" class="col-sm-3 control-label">Resturant Website</label>
        <div class="col-sm-4">
            <input type="text" name="restweb" id="coupon-name" class="form-control" autofocus value="<?php echo $rnweb; ?>">
            
        </div>
    </div>
    <div class="form-group">
        <label for="CouponName" class="col-sm-3 control-label">Resturant Address</label>
        <div class="col-sm-4">
            <input type="text" name="restadd" id="coupon-name" class="form-control" autofocus value="<?php echo $rnadd; ?>">
            
        </div>
    </div>            
    <div class="form-group">
        <label for="CouponDiscount" class="col-sm-3 control-label">Enter Offer</label>
        <div class="col-sm-4">
            <input type="text" name="coupondiscount" id="cdiscount-name" class="form-control" autofocus value="<?php echo $uoffer; ?>">
            
        </div>
    </div>               
                
              <?php $usdate = new datetime($usdate);
        $uedate = new datetime($uedate);
        $usdate = date_format($usdate,"m/d/Y");
        $uedate = date_format($uedate,"m/d/Y");?>
    <div class="form-group">
        <label for="CouponStartDate" class="col-sm-3 control-label">Coupon Start Date</label>
        <div id="datetimepicker3" class="col-sm-4 input-append">
            <input data-format="MM/dd/yyyy" type="text" name="sdate" id="datetimepicker3" value="<?php echo $usdate; ?>"></input>
            <span class="add-on">
                <i data-time-icon="icon-time" data-date-icon="glyphicon glyphicon-calendar"></i>
            </span>
        </div>
    </div>
    <div class="form-group">
        <label for="CouponEndDate" class="col-sm-3 control-label">Coupon End Date</label>
        <div id="datetimepicker4" class="col-sm-4 input-append">
            <input data-format="MM/dd/yyyy" type="text" class="ced" name="edate" value="<?php echo $uedate; ?>"></input>
            <span class="add-on">
                <i data-time-icon="icon-time" data-date-icon="glyphicon glyphicon-calendar"></i>
            </span>
        </div>
    </div>                     
    <div class="form-group">
        <label for="PhoneNo" class="col-sm-3 control-label">Phone No.</label>
        <div class="col-sm-4">
            <input type="text" name="couponphone" id="coupon-phone" placeholder="Enter Business Phone No" class="form-control" autofocus value="<?php echo $uphone; ?>">                     
        </div>
    </div>       
   <div class="form-group">
        <label for="PhoneNo" class="col-sm-3 control-label">Disclaimer</label>
        <div class="col-sm-4">
            <textarea name="desclaimer" id="desclaimer" placeholder="Enter Business Disclaimer" class="form-control" autofocus ><?php echo $udisc; ?></textarea>
            
        </div>
    </div>
    <div class="form-group">
        <label for="PhoneNo" class="col-sm-3 control-label">Business Logo</label>
        <div class="col-sm-4">
            <input type="file" name="uphoto1" id="uphoto" placeholder="Enter Business Logo" class="form-control" autofocus value="<?php echo $ulogo; ?>">
            
        </div>
    </div>                
                
    <div class="form-group">
        <div class="col-sm-3">                        
            <a href="http://account.couponbutter.com/manage-coupon/" class="btn btn-primary btn-block back-button" role="button">BACK</a>
        </div>
        <div class="col-sm-3">            
            <input type="submit" id='insert' name="submit" value="UPDATE COUPON" class="btn btn-primary btn-block">
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
        $rame = $_POST['restnm'];
          $rweb =  $_POST['restweb'];
          $radd = $_POST['restadd'];
        $discount_amount=$_POST['coupondiscount'];
        $sdate=$_POST['sdate'];
        $edate=$_POST['edate'];
        $sdate = new datetime($sdate);
        $edate = new datetime($edate);
        $date1 = date_format($sdate,"m/d/Y");
        $date2 = date_format($edate,"m/d/Y");
        $phone=$_POST['couponphone'];
        $desclaimer=$_POST['desclaimer'];
        $c_code = $_GET['coupon_id'];
        $date = date('m/d/Y');
         if($date2 < $date) { 

            $cstatus="Expired";
         }else
         {
            $cstatus="Active";

         }        
        ?>
        

        
        <?php
        $subscriber=$_SESSION['user_id'];
        if( $name == "" || $date1 == "" || $date2 == "") {
        $err = 'Please don\'t leave the required field.';
        } 

        /*elseif($date1>=$date2)
        {
        $err = 'Please provide later than end date';
        }*/
        else{ 
        if($_FILES["uphoto1"]["size"]>0){

        $icon_img=$_FILES["uphoto1"]["name"];
        $path_array = wp_upload_dir();
        $path = str_replace('\\', '/', $path_array['path']);
        move_uploaded_file($_FILES["uphoto1"]["tmp_name"],$path. "/" . $icon_img);
        $upload_path=$path_array['url']."/";
        $icon_img_path=$upload_path.$icon_img;

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
        <h1 style=' font-size:90px; padding-top:56px; text-align:center; margin:0;'>".$discount_amount."</h1>
        <h1 style='text-align:center; font-size:18px; font-weight:bold; margin:0;'></h1>
        <p style='text-align:center; font-size:14px; font-weight:bold;'>EXPIRES ".$date2."</p>
        </div>

        <div style='width:100%;float:left;margin-left:55px;text-align:center;'><img src='".$icon_img_path."' style='width:110px;'/></div>

        <div style='width:100%;float:left;margin-left:55px;text-align:center;'><h2 style=' font-size:18px; font-weight:bold;margin-bottom:0;'>".$_SESSION['business_name']."<br><span style=' font-size:16px;'>".$_SESSION['business_address']."</span><br>".$phone."<br><span style=' font-size:16px;'>".$_SESSION['business_website']."</span></h2>
        </div>

        <div style='width:100%;float:left;margin-left:55px;text-align:center;padding:0 50px'><p style='font-size:12px;'>".$desclaimer."</p></div>

        <div style=' width:100%;float:left;margin-left:55px;text-align:center;'><barcode code='".$c_code."' type='QR' error='M' class='barcode' /></div>

        <div style=' width:100%;margin-left:55px;float:left; text-align:center;'><h2 style=' font-size:12px; font-weight:bold;'>COUPON No.: ".$c_code."<br><span style=' font-size:13px;'>RESTAURANT OWNERS SCAN HERE TO REDEEM</span></h2>
        </div>
        </div>
        <div style='width:625px;float:left;margin-top:30px;'>
        <img src='".get_template_directory()."/images/coupon-butter-logo.png' style='margin-left:172px;'/>
        </div>
        <div style='width:783px;float:left;text-align:center; margin-left:112px; margin:auto; margin-bottom:40px;'><p style=' font-size:10px;'>
        <h3 style='padding:0; margin:0 ;'>www.couponbutter.com</h3></div>
        </body>
        </html>
        ";       

        $mpdf=new mPDF();
        $mpdf->WriteHTML($html);
        $mpdf->SetDisplayMode('fullpage');   
        $p_path=$mpdf->Output('pdf/'.$c_code.'-coupon.pdf','F');
        $save_path=$mpdf->Output('pdf/'.$c_code.'-coupon-image.jpg','F');
        //$p_path=$mpdf->Output($p_full,'F');
        $p_full=get_bloginfo('url').'/pdf/'.$c_code.'-coupon.pdf';
        
        $savepath=get_bloginfo('url').'/pdf/'.$c_code.'-coupon-image.jpg';      
        

        global $wpdb;
        $table_name=$wpdb->prefix . "coupon_create";
        $sql="UPDATE $table_name SET coupon_name='".$name."', resturant_name='".$rame."', resturant_address='".$radd."', resturant_website='".$rweb."', coupon_status='".$cstatus."',coupon_discount='".$discount_amount."',coupon_start_date='".$date1."',coupon_end_date='".$date2."',coupon_phone='".$phone."',coupon_disclaimer='".$desclaimer."',coupon_logo='$icon_img_path',coupon_pdf_path='".$p_full."', coupon_image_path
        ='".$savepath."',cuppon_subscriber_id='".$subscriber."',time_stamp='".time()."' WHERE coupon_id='".$_GET['coupon_id']."'";
        // echo $sql;
        // die;
        $result = $wpdb->query($sql);
        if ($result)
        {      
            wp_redirect("http://". $_SERVER['SERVER_NAME']."/manage-coupon/?c=1");
        }
        else
        {
            echo "Not";
        }
    }
    else{
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
        <h1 style=' font-size:90px; padding-top:56px; text-align:center; margin:0;'>".$discount_amount."</h1>
        <h1 style='text-align:center; font-size:18px; font-weight:bold; margin:0;'></h1>
        <p style='text-align:center; font-size:14px; font-weight:bold;'>EXPIRES ".$date2."</p>
        </div>

        <div style='width:100%;float:left;margin-left:55px;text-align:center;'><img src='".$ulogo."' style='width:110px;'/></div>

        <div style='width:100%;float:left;margin-left:55px;text-align:center;'><h2 style=' font-size:18px; font-weight:bold;margin-bottom:0;'>".$_SESSION['business_name']."<br><span style=' font-size:16px;'>".$_SESSION['business_address']."</span><br>".$phone."<br><span style=' font-size:16px;'>".$_SESSION['business_website']."</span></h2>
        </div>

        <div style='width:100%;float:left;margin-left:55px;text-align:center;padding:0 50px'><p style='font-size:12px;'>".$desclaimer."</p></div>

        <div style=' width:100%;float:left;margin-left:55px;text-align:center;'><barcode code='".$c_code."' type='QR' error='M' class='barcode' /></div>

        <div style=' width:100%;margin-left:55px;float:left; text-align:center;'><h2 style=' font-size:12px; font-weight:bold;'>COUPON No.: ".$c_code."<br><span style=' font-size:13px;'>RESTAURANT OWNERS SCAN HERE TO REDEEM</span></h2>
        </div>
        </div>
        <div style='width:625px;float:left;margin-top:30px;'>
        <img src='".get_template_directory()."/images/coupon-butter-logo.png' style='margin-left:172px;'/>
        </div>
        <div style='width:783px;float:left;text-align:center; margin-left:112px; margin:auto; margin-bottom:40px;'><p style=' font-size:10px;'>
        <h3 style='padding:0; margin:0 ;'>www.couponbutter.com</h3>
        </div>
        </body>
        </html>
        ";       

        $mpdf=new mPDF();
        $mpdf->WriteHTML($html);
        $mpdf->SetDisplayMode('fullpage');   
        $p_path=$mpdf->Output('pdf/'.$c_code.'-coupon.pdf','F');
        $save_path=$mpdf->Output('pdf/'.$c_code.'-coupon-image.jpg','F');
        //$p_path=$mpdf->Output($p_full,'F');
        $p_full=get_bloginfo('url').'/pdf/'.$c_code.'-coupon.pdf';
        
        $savepath=get_bloginfo('url').'/pdf/'.$c_code.'-coupon-image.jpg';      
        

        global $wpdb;
        $table_name=$wpdb->prefix . "coupon_create";
        $sql="UPDATE $table_name SET coupon_name='".$name."', coupon_status='".$cstatus."',coupon_discount='".$discount_amount."',coupon_start_date='".$date1."',coupon_end_date='".$date2."',coupon_phone='".$phone."',coupon_disclaimer='".$desclaimer."',coupon_pdf_path='".$p_full."', coupon_image_path
        ='".$savepath."',cuppon_subscriber_id='".$subscriber."',time_stamp='".time()."' WHERE coupon_id='".$_GET['coupon_id']."'";
        $result = $wpdb->query($sql);
        if ($result)
        {      
            wp_redirect("http://". $_SERVER['SERVER_NAME']."/manage-coupon/?c=1");
        }
        else
        {
            echo "Not";
        }



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
        </div>
    </div>
</div>     
</section>
<?php get_footer();?>
