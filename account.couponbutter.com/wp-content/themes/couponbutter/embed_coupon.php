 <div class="col-md-3 bt1">
        <a href="#"><button type="button" id="demo1" class="one_btn demo1" data-toggle="modal" data-target="#myModal">
        <p><span><i class="fa fa-chevron-left" aria-hidden="true"></i><i class="fa fa-chevron-right" aria-hidden="true"></i></span>embed coupon</p>
        </button></a>

 
        </div>


<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Embed coupon Code</h4>
        </div>
      
        <div class="modal-body">       
<textarea onclick='this.focus();this.select()' style='width:100%;height:100%'><iframe src='http://account.couponbutter.com/embed-coupon-show/?coupon_id=<?php echo base64_encode($_SESSION['coupon_id']); ?>&user_id=<?php echo base64_encode($_SESSION['user_id']); ?>' alt='coupon' width='480px' height='604px' border='0' /></iframe></textarea>
 

        </div>
       
      </div>
      
    </div>
  </div>