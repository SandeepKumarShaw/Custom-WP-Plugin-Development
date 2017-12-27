        <?php

if(!isset($_SESSION['user_id'])){
   //header("Location: http://localhost/coupon.demostage.net/");
        //exit();
  wp_redirect("http://account.couponbutter.com/");
     exit();
}    
else{?>     
            <div class="col-md-5 navigat">
            <div class="menu_sedction">
            <ul>
            
            <li><a href="http://account.couponbutter.com/manage-coupon/"><i class="fa fa-pencil pans" aria-hidden="true"></i><br>Manage Coupons   </a></li>
<li><a href="http://account.couponbutter.com/my-list/"><i class="fa fa-list sz" aria-hidden="true"></i><br>My Lists </a></li>
<li>
          
          <a href="http://account.couponbutter.com/changepassword/"><i class="fa fa-user mens" aria-hidden="true"></i><br>My Account </a></li>
            <li><a href="http://account.couponbutter.com/support/"><i class="fa fa-phone callss" aria-hidden="true"></i><br>Support </a></li>
            </ul>
            </div>
            </div>
            <div class="col-md-2 comp_name">
            <div class="main_comp">
            
            
          <div class="dropdown">
          <?php 
global $wpdb;
$sql="SELECT wp_fullstripe_subscribers.name FROM wp_fullstripe_subscribers LEFT JOIN wp_users ON wp_fullstripe_subscribers.email=wp_users.user_email  WHERE user_email='".$_SESSION['username']."'";
//echo $sql;
//echo $_SESSION['user_id'];

$qry=$wpdb->get_results($sql);
foreach ($qry as $rez) { 
  
  $userlogin=$rez->name;
}

          ?>

    <button class="btn btn-primary dropdown-toggle" id="menu1" type="button" data-toggle="dropdown"><?php echo $userlogin;?>
    <span class="caret"></span></button>
   <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
   
      <li role="presentation"><a role="menuitem" tabindex="-1" href="http://account.couponbutter.com/log-out/">Logout</a></li>
   <?php //} ?>   
      
      
    </ul>
  </div>
            </div>
            
            </div>
                
         </div></div>
        </div><!--menu header end-->  
        <?php } ?>