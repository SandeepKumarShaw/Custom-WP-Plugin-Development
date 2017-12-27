<?php include 'inc/header.php'; ?>
<?php
$login = Session::get("custlogin");
if ($login == false) {
  header("Location: login.php");
}
?>
<style type="text/css">
    .Success{
        width: 500px;min-height: 
        200px;text-align: center;
        border: 1px solid #ddd;
        margin: 0 auto;
        padding: 50px;
    }
    .Success h2{
        border-bottom: 1px solid #ddd;
        margin-bottom: 20px;padding-bottom: 10px;
    }
    .Success p {
      font-size: 18px;
       line-height: 25px;
       text-align: left;
    }
   
</style>
 <div class="main">
    <div class="content">
    	<div class="section group">
           <div class="Success">
            <h2>Payment Success</h2>
            <?php
            $cmrId = Session::get("cmrId");
            $amount = $ct->payableAmount($cmrId); 
            if ($amount) {
              $sum=0;
              while ($result = $amount->fetch_assoc()) {
               $price = $result['price'];
               $sum   = $sum + $price;
              }
            }

            ?>
               <p>Total Payable Ammount(Including VAT):
                $ <?php 

                                  $vat = $sum*0.1;
                                  $gtotal = $sum + $vat;

                                echo $gtotal; ?> </p>               
               <p>Thanks for Your Purchase. Receive your order Successfully.We will contact you as soon as possible with delivery details.Here is your order details........<a href="order.php">Visit Here...</a> </p>
           </div>

           

        </div>
 	</div>
	</div>
<?php include 'inc/footer.php'; ?>
  