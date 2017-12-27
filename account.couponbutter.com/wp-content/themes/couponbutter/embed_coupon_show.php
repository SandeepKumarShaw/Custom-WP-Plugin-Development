<?php 

/*
Template Name: Embed Coupon Show
*/

?>
<?php get_header();
?>

<body>
<section class="get_coupon">
     
            
        
        <div class="centers_get_coupon">
        <div class="container">

        <?php
         base64_decode($_GET['coupon_id']);
        $row6 = $wpdb->get_results("SELECT customer_id  FROM wp_customer_details where customer_cuppon_id ='".base64_decode($_GET['coupon_id'])."'");
        foreach ($row6 as $row66) {
            
         $cust_id=$row66->customer_id;
        }

        $row9=$wpdb->get_results("SELECT business_name , business_address , business_website FROM wp_user_account WHERE user_id='".base64_decode($_GET['user_id'])."'");

        foreach ($row9 as $row99) {
           $bus_name=$row99->business_name;
           $bus_address=$row99->business_address;
           $bus_website=$row99->business_website;

        }
$row7 = $wpdb->get_results("SELECT user_email FROM wp_users where ID ='".base64_decode($_GET['user_id'])."'");
        foreach ($row7 as $row77) {
            
        $user_send_mail=$row77->user_email;
        }

          

//echo $_SESSION['coupon_id'];
         global $wpdb;
         $table_name = $wpdb->prefix . "coupon_create";
         $sql="SELECT * FROM $table_name where coupon_id ='".base64_decode($_GET['coupon_id'])."'";

         $row = $wpdb->get_results($sql);
         
         foreach ($row as $rows){
         $file = $rows->coupon_pdf_path;
         $cpn_name = $rows->coupon_name;
        $cpn_discount = $rows->coupon_discount;
         $cpn_end_date = $rows->coupon_end_date;
         $cpn_phone = $rows->coupon_phone;
          $desclaimer = $rows->coupon_disclaimer;
          $cpn_id = $rows->coupon_id;
          $cpn_logo = $rows->coupon_logo;
          $cpn_pdf = $rows->coupon_pdf_path;
          $rst_name = $rows->resturant_name;
          $rst_web =  $rows->resturant_website;
          $rst_add = $rows->resturant_address;
        }
        ?>
        <div class="catch_img containwers_topp">
        <img src="<?php //echo $rows->coupon_logo; ?>" class="img-responsive center-block"/>
        </div>
        
        <div class="dollors_tx">
        <h2><!--$<?php //echo $rows->coupon_discount; ?> off <?php //echo $rows->coupon_purchase_amount; ?></h2>
        <p class="expired"><!--EXPIRES:--> <?php //echo $rows->coupon_end_date; ?></p>
       
        <br>
        <p class="provid"></p>
        </div>
        <div class="submit_login-bx">
      
        <div class="submit_login-bx_in">
			<?php 
             //$_SESSION['imgsrc'] = $_POST['select'];

             //echo $_SESSION['imgsrc'];
            //echo $_SESSION['user_email'];
			if (isset($_POST['submit'])){ 
                //echo"hello";
            $row8_1="SELECT customer_email  FROM wp_customer_details WHERE parent_id ='".$cust_id."' OR customer_id='".$cust_id."' AND customer_getcoupon_id = '".base64_decode($_GET['coupon_id'])."' OR customer_cuppon_id = '".base64_decode($_GET['coupon_id'])."'";
//echo $row8_1;
    //die;            
$row8 = $wpdb->get_results($row8_1);
                //print_r($row8);
        foreach ($row8 as $row88) {
            //echo $row88->customer_email;

            
         if(empty($_POST['cus_email']) || $row88->customer_email != $_POST['cus_email'])
         {
            //echo $_POST['cus_email'];
             $cust_email=$_POST['cus_email'];
           //die;
           //

         }else if($row88->customer_email===$_POST['cus_email'])
         {
            ?><div class="suc-msg"><?php echo "This Email Has Already Been Used"; ?></div>
            <?php
             exit;
          //die();
         }
        }
            }   

                if($cust_email)
                {



$qrcode=rand(100000,999999);


$width = $height = 100;
//$url   = urlencode($qrcode);

$xyz   = "http://account.couponbutter.com/scan-redeem/?scpnid=".$cpn_id."&scqrc=".$qrcode."";
$url   = urlencode($xyz);

//$error = "H"; // handle up to 30% data loss, or "L" (7%), "M" (15%), "Q" (25%)
$error = "L"; // handle up to 30% data loss, or "L" (7%), "M" (15%), "Q" (25%)
$abcd ="<img src=\"http://chart.googleapis.com/chart?".
     "chs={$width}x{$height}&cht=qr&chld=$error&chl=$url\" />";

include( get_template_directory() . '/mpdf60/mpdf.php');
        $html .= "
        <!doctype html>
        <html>
        <head>
        <meta charset='utf-8'>
        <title></title>
        </head>

        <body>
        <h2 style='text-align:center;font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;font-weight: bold;color: #696565;'>Your Buttery Coupon has Arrived<br><span style='font-size:14px;'>THIS COUPON ENTITLES YOU TO</span>
        </h2>
        <div style='width:625px; height:auto; background:url(".get_template_directory()."/images/coupon-edited.jpg) no-repeat;background-size: 100% 100%; margin:0 auto 25px;'>
		<div style='display: inline-block;padding: 0 35px 30px 85px;width: 625px;text-align: center;'>	
        <div style=' width:100%; margin:0 auto 15px;'>
        <h1 style='font-size: 42px;padding: 56px 15px 0; text-align:center; margin:18px 0; font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;'>".$cpn_discount."</h1>
        <p style='text-align:center; font-size:14px; font-weight:bold;font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;'>EXPIRES ".$cpn_end_date."</p>
        </div>

        <div style='margin: 0 auto;text-align: center;'><img src='".$cpn_logo."' style='width:110px;'/></div>

        <div style='width:100%; margin:auto; text-align:center;'><h2 style='font-size:24px;margin-top: 15px;margin-bottom:0;text-transform: capitalize;font-weight: bold;font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;'>".$rst_name."<br><span style=' font-size:17px;font-weight: normal;'>".$rst_add."</span><br><span style=' font-size:20px;font-weight: normal;'>".$cpn_phone."</span><br><span style=' font-size:16px;text-transform: lowercase;font-weight: normal;'>".$rst_web."</span></h2>
        </div>

        <div style='width:100%;'><p style='font-size:12px;text-align: center;margin-bottom: 15px;padding: 0 15px;font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;font-weight:'>".$desclaimer."</p></div>

        <div style=' width:100%;text-align:center;font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;'>".$abcd."</div>

        <div style=' width:100%;text-align:center;'><h2 style='font-size:14px;margin: 9px 0;font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;font-weight: normal;'><span style=' font-size:10px;margin-bottom: 3px;display: inline-block;'>RESTAURANT OWNERS SCAN HERE TO REDEEM</span><br><span style='font-weight:bold;'>QR CODE:</span> ".$qrcode."<br><span style='font-weight:bold;'>COUPON NO:</span> ".$cpn_id."</h2>
        </div>
        <div style='width:100%;float:left;text-align:center;font-size: 11px;margin-bottom: 30px;font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;'> OR ENTER COUPON NO AT : http://account.couponbutter.com/redeem/</div>
        </div>
        </div>
        <div style='width:625px;margin: auto;text-align: center;padding-bottom: 15px;padding-left: 31px;'>
        <img src='".get_template_directory()."/images/coupon-butter-logo.png' />
        </div>
        <div style='width:783px; margin-left:112px; margin:auto; margin-bottom:40px;text-align: center;'><p style=' font-size:10px;'>
        <h3 style='padding:0; margin:0 ;font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;'>www.couponbutter.com</h3>

        <p style='text-align:center;font-size: 10px;font-weight: bold;font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;color: #696565;'>Coupons may be used only once and may not be duplicated or photocopied.Further, in the event that coupons are electronically distributed,Coupons may be printed or scanned only once. Coupons are strictly prohibited from being posted electronically. No cash value, credit or change eill be given.The coupon holder is responsible for any applicable sales tax. Coupons nay not be combined with any other coupon or employee discount. Coupons not redeemed by any expiration date hereon. Failure to use a coupon by any expiration date hereon shall result in the forfeiture of such coupon. Proprietor may refuse coupon for any reason.</p></div>
        </body>
        </html>
        ";
        // error_reporting(E_ALL); 
        // ini_set('display_errors', 1);

        $mpdf = new mPDF();
        $mpdf->WriteHTML($html);
        $mpdf->SetDisplayMode('fullpage');   
        $ppath=$mpdf->Output('pdf/'.$qrcode.'-coupon.pdf','F');
        //$save_path=$mpdf->Output('pdf/'.$c_code.'-coupon-image.jpg','F');
        //$p_path=$mpdf->Output($p_full,'F');
        $pfull=get_bloginfo('url').'/pdf/'.$qrcode.'-coupon.pdf';
        





                $net=$wpdb->query("INSERT INTO wp_customer_details SET customer_name='".$_POST['cus_name']."', customer_email='".$cust_email."',subscriber_id='".base64_decode($_GET['user_id'])."',customer_getcoupon_id='".$cpn_id."',customer_qr_code='".$qrcode."',parent_id='".$cust_id."'");
                    

                                 if($net)
                {

//include( get_template_directory() . '/mpdf60/mpdf.php');
      
$message = "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <meta name='viewport' content='width=device-width'>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='format-detection' content='telephone=no'>
    <style type='text/css'>body {
      width: 100% !important;
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
      margin: 0;
      padding: 0;
      mso-line-height-rule: exactly;
      }
      table td {
        border-collapse: collapse;
      }
      table td {
        border-collapse: collapse;
      }
      img {
        outline: none;
        text-decoration: none;
        -ms-interpolation-mode: bicubic;
      }
      a img {
        border: none;
      }
      @media only screen and (max-device-width: 480px) {
        table[id='outercontainer_div'] {
          max-width: 480px !important;
        }
        table[id='nzInnerTable'],    table[class='nzpImageHolder'],    table[class='imageGroupHolder'] {
          width: 100% !important;
          min-width: 320px !important;
        }
        table[class='nzpImageHolder'] td, td[class='table_seperator'], td[class='table_column']    {
          display: block !important;
          width: 100% !important;
        }
        table[class='nzpImageHolder'] img   {
          width: 100% !important;
        }
        table[class='nzpButt'] {
          display: block !important;
          width: auto !important;
        }
        #nzInnerTable td, #outercontainer_div td {
          padding: 0px !important;
          margin: 0px !important;
        }
      }
    </style>
  </head>
  <body style='padding: 0; margin: 0; -webkit-font-smoothing:antialiased; -webkit-text-size-adjust:none; background: #EEEEEE;'>
    <table width='100%'  cellpadding='30' id='outercontainer_div'>
      <tr>
        <td align='center'>
          <table width='400' bgColor='#FFFFFF' cellpadding='15' cellspacing='0' id='nzInnerTable' border='0' 
            <tr>
              <td>
                <div id='innerContent'>
                
                <table width='100%' cellspacing='0' cellpadding='0' style='padding: 0px 0 35px; padding-top: 0px;background: url(http://account.couponbutter.com/wp-content/themes/couponbutter/images/coupon-edited3.png) no-repeat;'>
                  <table width='100%' cellspacing='0' cellpadding='0' style='padding: 0px; padding-top: 0px;'>
                    <tr>
                      <td>
                        <table width='100%' cellpadding='0' cellspacing='0' style=''>
                          <tr>
                            <td>
                              <div id='txtHolder-2' class='txtEditorClass' style='color: #000000; font-size: 20px; font-family: Tahoma, Verdana, Segoe, sans-serif; text-align: Center;display: inline-block;margin-top: 49px;font-weight: bold;padding: 0 78px;'>".$cpn_discount." \r\n";
                              
                              $message .="</div>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                  
                  
                  <table width='100%' cellspacing='0' cellpadding='0' style='padding: 0px; padding-top: 0px;'>
                    <tr>
                      <td>
                        <table width='100%' cellpadding='0' cellspacing='0' style=''>
                          <tr>
                            <td>
                              <div id='txtHolder-3' class='txtEditorClass' style='color: #020202; font-size: 14px; font-family: Tahoma, Verdana, Segoe, sans-serif; text-align: Center'>
                                <div style='font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: medium; width: 325px; margin:0 auto;'>
                                  <p style='text-align: center;margin-bottom: 0;display: inline-block; font-size: 14px; font-weight: bold; font-family: arial;margin-top: 5px;'>EXPIRES ". $cpn_end_date."\r\n";
                                 $message .="</p>
                                  
                                </div>
                              </div>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                  
                  
                  <table width='100%' cellspacing='0' cellpadding='0' class='nzpImageHolder'>
                    <tr>
                      <td align='center'>
                        <div style='display: inline-block;margin: -7px 0 0;'>
                          <a href='http://' target='_blank'>
                            <img src='".$cpn_logo."' class='bigImg editableImg' id='img-4' width='95px' border='0' alt='' title=''>
                          </a>
                        </div>
                      </td>
                    </tr>
                  </table>
                  
                  
                  <table width='100%' cellspacing='0' cellpadding='0' style='padding: 0px; padding-top: 0px;'>
                    <tr>
                      <td>
                        <table width='100%' cellpadding='0' cellspacing='0' style=''>
                          <tr>
                            <td>
                              <div id='txtHolder-5' class='txtEditorClass' style='color: #000000; font-size: 18px;font-weight: 700;margin: 6px 0;width: 100%;display: inline-block; font-family: Tahoma, Verdana, Segoe, sans-serif; text-align: Center;text-transform: capitalize;'>".$rst_name."\r\n";
                                 
                              $message .="</div>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                  
                  
                  <table width='100%' cellspacing='0' cellpadding='0' style='padding: 0px; padding-top: 0px;'>
                    <tr>
                      <td>
                        <table width='100%' cellpadding='0' cellspacing='0' style=''>
                          <tr>
                            <td>
                              <div id='txtHolder-6' class='txtEditorClass' style='color: #000000; font-size: 16px; font-family: Tahoma, Verdana, Segoe, sans-serif; text-align: Center;text-transform: capitalize;'>".$rst_add."\r\n";
                                $message .="<div>&nbsp;".$cpn_phone."\r\n";
                                $message .="</div>
                              </div>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                  
                  
                  <table width='100%' cellspacing='0' cellpadding='0' style='padding: 0px; padding-top: 0px;'>
                    <tr>
                      <td>
                        <table width='100%' cellpadding='0' cellspacing='0' style=''>
                          <tr>
                            <td>
                              <div id='txtHolder-7' class='txtEditorClass' style='color: #000000;display: inline-block;width: 100%;margin: 7px 0; font-size: 14px; font-family: Tahoma, Verdana, Segoe, sans-serif; text-align: Center'>
                                <a href='".$rst_web."'>".$rst_web."\r\n";
                              $message .="</a>
                              </div>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                  
                  
                  <table width='100%' height='32' cellspacing='0' cellpadding='0' style='padding: 0px; padding-top: 0px; padding-bottom: 5px;'>
                    <tr>
                      <td>
                        <table width='100%' height='auto' cellpadding='0' cellspacing='0' style='padding: 0 30px 0 74px;'>
                          <tr>
                            <td>
         
                              <div id='txtHolder-8' class='txtEditorClass' style='color: #000000; font-size: 14px; font-family: Tahoma, Verdana, Segoe, sans-serif; text-align: Center; padding: 0 25px 0 0px;max-height: 32px;overflow: hidden;'>".$desclaimer."\r\n";
                              $message .="</div>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                  
                  
                  <table width='100%' cellspacing='0' cellpadding='0' class='nzpImageHolder'>
                    <tr>
                      <td align='center'>
                        <div style='padding: 0px;'>
                          ".$abcd."
                        </div>
                        <br>
						<div id='txtHolder-11' class='txtEditorClass' style='color: #000000; font-size: 10px; font-family:Tahoma, Verdana, Segoe, sans-serif; text-align: Center'>RESTAURANT OWNERS SCAN HERE TO REDEEM
                              </div>
							  
                        <span style='color: #000000; font-size: 15px; font-family: Tahoma, Verdana, Segoe, sans-serif; text-align: Center'>QR CODE: ".$qrcode."<span>
                      </td>
                    </tr>
                  </table>
                  
                  
                  <table width='100%' cellspacing='0' cellpadding='0' style='padding: 0px; padding-top: 0px; padding-bottom: 5px;'>
                    <tr>
                      <td>
                        <table width='100%' cellpadding='0' cellspacing='0' style=''>
                          <tr>
                            <td bgColor=''>
                              <div id='txtHolder-10' class='txtEditorClass' style='color: #000000; font-size: 15px; font-family: Tahoma, Verdana, Segoe, sans-serif; text-align: Center'>COUPON NO: ".$cpn_id."\r\n";                              
                          $message .="</div>
                          <div style='width: 100%;text-align: center;display: inline-block;margin: 12px 0;font-size:10px;'>OR ENTER COUPON NO AT :<br> <a style='padding: 7px 8px;text-decoration: none;' href='http://account.couponbutter.com/redeem/' target='_blank'>http://account.couponbutter.com/redeem/</a></div>
                          </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                  
                  
                  
                  <table width='100%' cellspacing='0' cellpadding='0' style='padding: 0px; padding-top: 0px; padding-bottom: 15px;'>
                    <tr>
                      <td>
                        <table width='100%' cellpadding='0' cellspacing='0' style=''>
                          <tr>
                            <td>
                          
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                   </table>
                  
                  <div style='margin-bottom: 15px;'>
                  </div>
                  
                  <table width='100%' cellspacing='0' cellpadding='0' style='margin-bottom: 15px;' class='nzpImageHolder'>
                    <tr>
                      <td align='center'>
                        <div style='padding: 0px;margin-top:0;'>
                          <a href='www.couponbutter.com' target='_blank'>
                            <img src='http://freeemaileditor.com/users/78392//300915.png' class='bigImg editableImg' id='img-13' width='245' border='0' alt='' title=''>
                          </a>
                        </div>
                      </td>
                    </tr>
                  </table>
                  
                  
                  <table width='100%' cellspacing='0' cellpadding='0' style='padding-bottom: 15px;'>
                    <tr>
                      <td>
                        <table cellpadding='0' cellspacing='0' width='100%'>
                          <tr>
                            <td>
                              <table cellpadding='10' cellspacing='0' align='Center' style='' id='nzpButt'>
                                <tr>
                                  <td bgColor='#FFFFFF' style=' color: #000000; text-align: center; font-size: 26pxpx; font-family: Tahoma, Verdana, Segoe, sans-serif; font-weight: bold; cursor: pointer; text-decoration: none;'>
                                    <a href='http://www.couponbutter.com' target='_blank' style=' color: #000000; text-align: center; font-size: 26px; font-family: Comic Sans MS; font-weight: bold; cursor: pointer; text-decoration: none;'>
                                      <span style='font-size: 26px'>www.couponbutter.com
                                      </span>

                                    </a>
                                     <p style='text-align:center;font-size: 10px;font-weight: bold;'>Coupons may be used only once and may not be duplicated or photocopied.Further, in the event that coupons are electronically distributed,Coupons may be printed or scanned only once. Coupons are strictly prohibited from being posted electronically. No cash value, credit or change eill be given.The coupon holder is responsible for any applicable sales tax. Coupons nay not be combined with any other coupon or employee discount. Coupons not redeemed by any expiration date hereon. Failure to use a coupon by any expiration date hereon shall result in the forfeiture of such coupon. Proprietor may refuse coupon for any reason.</p>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                 
                  
                                  
                  <table width='100%' cellspacing='0' cellpadding='0' style='padding: 0; padding-top: 0px; padding-bottom:15px;'>
                    <tr>
                      <td>
                        <table width='100%' cellpadding='0' cellspacing='0'>
                          <tr>
                            <td valign='top' width='50%' class='table_column'>
                              <table cellpadding='10' cellspacing='0' align='Center' style='' id='nzpButt'>
                                <tr>
                                  <td bgColor='#ef4923' style=' color: #ffffff; text-align: center; font-size: 14pxpx; font-family:Tahoma, Verdana, Segoe, sans-serif: bold; cursor: pointer; text-decoration: none;'>
                                    <a href='".$pfull."' target='_blank' style=' color: #ffffff; text-align: center; font-size: 14pxpx; font-family: Tahoma, Verdana, Segoe, sans-serif; font-weight: bold; cursor: pointer; text-decoration: none;'>
                                      <span style='font-size: 14px;'>Download pdf
                                      </span>
                                    </a>
                                  </td>
                                </tr>
                              </table>
                            </td>
                            </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                  
                  
                </div>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>

";
$to = $_POST['cus_email']; 
$subject = $cpn_name;
$from = "coupons@couponbutter.com"; //$user_send_mail;
$headers = "From: " . strip_tags($from) . "\r\n";
  $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
  $headers .= "CC: coupons@couponbutter.com\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$success = mail($to,$subject,$message,$headers);
			if (!$success) {
			echo "Mail to " . $to . " failed .";
			 }else { ?>
            <div class="suc-msg">
            <?php echo "Your Coupon has been emailed to you at " . $to ;?></div>
            <?php
            }






          /*          
			$to = $_POST['cus_email']; 
            $subject = $cpn_name;
			$from = "coupons@couponbutter.com"; //$user_send_mail;
			$headers = "From: $from\r\n";
			$headers .= "MIME-Version: 1.0\r\n"
			."Content-Type: multipart/mixed; boundary=\"1a2a3a\"";

			$message .= "If you can see this MIME than your client doesn't accept MIME types!\r\n"
			."--1a2a3a\r\n";

			$message .= "Content-Type: text/html; charset=\"iso-8859-1\"\r\n"
			."Content-Transfer-Encoding: 7bit\r\n\r\n"
			."Hey <b>".$_POST['cus_name']."</b> here is a Invoice of Your Coupon"
			."<p>Please find the attachment below: </p> \r\n"
			."--1a2a3a\r\n";
			$filename = $rows->coupon_pdf_path;
			$file = file_get_contents($filename);
			$attach_pdf_multipart = chunk_split( base64_encode($file));


			$message .= "Content-Type: application/octet-stream; name=\"attachment.pdf\"\r\n";
			$message .= "Content-Transfer-Encoding: base64\r\n";
			$message .= "Content-Disposition: attachment\r\n";
			$message .= $attach_pdf_multipart . "\r\n";

			$message .= "Content-Type: text/html; charset=\"iso-8859-1\"\r\n";
			$message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
			$message .= "<p>This is text message from shohag</p>\r\n\r\n";*/



			/*$success = mail($to,$subject,$message,$headers);
			if (!$success) {
			echo "Mail to " . $to . " failed .";
			}else {
			echo "Your Coupon has been emailed to you at " . $to ;
			}*/

		}
       }
			?>
			<form class="form-horizontal" role="form" method="post" action="">
            <div class="form-group gapss">    
            <input type="text" class="form-control abc" value="" name="cus_name" id="email"  placeholder="Your Name (Required)" Required>
            </div>
			<div class="form-group gapss">    
			<input type="email" class="form-control abc" value="" name="cus_email"id="email" placeholder="Your Email (Required)" Required>
			</div>
			<div class="form-group">
			<input type="submit" name="submit" class="btn btn-default submitss" value="Get Coupon">
			<!-- <a href="#"><button type="submit" class="btn btn-default submitss">SEND</button></a> -->
			</div>
			</form>
    </div>
  
        
        
        
        </p>
       </div>
        </div>
        </div>
       

</section>
<?php get_footer();?>
