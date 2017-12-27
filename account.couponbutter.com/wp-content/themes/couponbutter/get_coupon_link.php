 

<div class="col-md-3 bt1">
        <a href="#"><button type="button" id="demo" class="one_btn demo" data-toggle="modal" data-target="#myModal-get">
        <p><span><i class="fa fa-hand-o-right" aria-hidden="true"></i></span>Get Coupon Link</p>
        </button></a>
        </div>


<div class="modal fade" id="myModal-get" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Get Coupon Link</h4>
        </div>
      
        <div class="modal-body">       
<h6 onclick='this.focus();this.select()' style='width:100%;height:100%'>
http://account.couponbutter.com/get-coupon/?coupon_id=<?php echo base64_encode($_SESSION['coupon_id']); ?>&user_id=<?php echo base64_encode($_SESSION['user_id']); ?>
<?php //echo $file; ?></h6>
 

        </div>
       
      </div>
      
    </div>
  </div>