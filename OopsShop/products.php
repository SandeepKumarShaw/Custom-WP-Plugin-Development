<?php include 'inc/header.php'; ?>
<style type="text/css">
	.grid_1_of_4.images_1_of_4 {
    width: 19.8%;
}
</style>
 <div class="main">
    <div class="content">
    	<div class="content_top">
    		<div class="heading">
    		<h3>Latest from Iphone</h3>
    		</div>
    		<div class="clear"></div>
    	</div>
	      <div class="section group">
	      <?php
			$getProduct = $pd->getAllProduct();
			if ($getProduct) {
				while ($result = $getProduct->fetch_assoc()) {
			?>
				<div class="grid_1_of_4 images_1_of_4">
					 <a href="details.php?proid=<?php echo $result['productId']; ?>"><img src="admin/<?php echo $result['image']; ?>" alt="" /></a>
					 <h2><?php echo $result['productName']; ?> </h2>
					 <p><?php echo $fm->textShorten($result['body'], 60); ?></p>
					 <p><span class="price">$<?php echo $result['price']; ?></span></p>
				     <div class="button"><span><a href="details.php?proid=<?php echo $result['productId']; ?>" class="details">Details</a></span></div>
				</div>
			<?php
                }
			}
            ?>	
			</div>
			
    </div>
 </div>
</div>
<?php include 'inc/footer.php'; ?>


