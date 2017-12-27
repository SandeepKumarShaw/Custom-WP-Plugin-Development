<?php 

/*
Template Name: fetch email list
*/

?>
<?php get_header();
?>
 <?php  
// global $wpdb;
// $arr=array('smail', 'rdm');
// print_r($arr);
// $sq="SELECT wp_customer_details.customer_reedem,wp_my_email_list.my_customer_email FROM wp_my_email_list LEFT JOIN wp_customer_details ON wp_customer_details.customer_getcoupon_id=wp_my_email_list.my_coupon_id";

// echo $sq;
//$sql=$wpdb->get_results($sq);
// foreach ($sql as $sql11) {
  
//    $mailarr[]=$sql11->my_customer_email;
// }
// //print_r($mailarr);
// $row=$wpdb->get_results("SELECT customer_reedem FROM wp_customer_details  WHERE parent_id='".$_POST['customerid']."' and customer_getcoupon_id='".$_POST['couponid']."'");
// foreach ($row as $rows) {
  
//    $redarr[]=$rows->customer_reedem;
// }
//  //print_r($redarr);

// foreach ($mailarr as $mailarrs) {
// foreach ($redarr as $redarrs) {

// $upd="UPDATE wp_my_email_list SET my_email_reedemed_status='".$redarrs."' WHERE my_customer_email='".$mailarrs."'";
// //echo $upd;

// }
  
// }

if ( isset($_POST['couponid']) && isset($_POST['customerid']) ) {
    $data="<div class='Redemmed'>
        <p>Coupons Redemmed<p>
        </div>";
     
$data.="<table class='table table-bordered'>
    <thead>
      <tr>
        <th><input type='checkbox' id='selectall'/>Select All</th>
        <th>Customer Name</th>
        <th>email</th>
        <th>status</th>
        <th>redeemed date</th>
        
      </tr>
    </thead>
    <tbody>";

  
     
$sql7="SELECT wp_customer_details.customer_name, wp_customer_details.customer_email,wp_customer_details.customer_reedem,wp_customer_details.reedem_date,wp_customer_details.customer_id
    FROM wp_customer_details
      WHERE parent_id='".$_POST['customerid']."' and customer_getcoupon_id='".$_POST['couponid']."'";
     

      $row7 = $wpdb->get_results($sql7);
      
 foreach ($row7 as $key) {
   $data.="<tr id='".$key->customer_id."' data-eid='".$key->customer_email."'>
      <td> <input type='checkbox' name='sport' id='".$key->customer_id."' data-eid='".$key->customer_email."' value='".$key->customer_id."' class='case'></td>
      <td>".$key->customer_name."</td>
      <td>".$key->customer_email."</td>";
      if($key->customer_reedem == 1){
     $data.="<td>Redeemd</td>"; 
      
    }
    else{
      $data.="<td>Not Redeemd</td>"; 
    }
    
     $data.="<td>".$key->reedem_date."</td>"; 
      
    
      
     $data.="</tr>";
}
      echo $data.="</tbody>
  </table>";
}
else{
  return false;
}
/*echo $data.="<div class='col-md-3 bt1'>
        <div class='one_btn' id='send-button'>
        <p><span><i class='fa fa-paper-plane-o' aria-hidden='true'></i></span>SEND</p>
        </div></a>
        </div>";*/
//echo $data.="<div class='col-md-3 bt1'><button type='submit' name='submit' class='btn one_btn' id='send-button'>SEND</button></div>";

      ?>
     
     <!-- <div class="col-md-3 bt1"><button type="submit" name="submit" class="btn one_btn" id="send-button" data-id="<?php //echo $_POST['cou_id']; ?>">SEND</button></div>
     <div id="alert2"></div>  -->


<?php get_footer();?>