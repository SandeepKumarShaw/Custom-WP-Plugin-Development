<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/Brand.php'; ?>
<?php include '../classes/Category.php'; ?>
<?php include '../classes/Product.php'; ?>
<?php include_once '../helpers/Format.php'; ?>
<?php

$pd = new Product();
$fm = new Format();
?>
<?php 
if (isset($_GET['delpro'])) {
	$id = $_GET['delpro'];
	$delProduct = $pd->delProductById($id);
}
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Product List</h2>
                <?php 
                 if (isset($delProduct)) {
                 	echo $delProduct;
                 }
                ?>
        <div class="block">  
            <table class="data display datatable" id="example">
			<thead>
			<tr>
			    <th width="5%">NO.</th>
				<th width="15%">Product Name</th>
				<th width="10%">Category</th>
				<th width="10%">Brand</th>
				<th width="20%">Description</th>
				<th width="10%">Price</th>
                <th width="10%">Image</th>
                <th width="10%">Type</th>
				<th width="10%">Action</th>
			</tr>
				
			</thead>
			<tbody>
			<?php
			$getProduct = $pd->getAllProduct();
			if ($getProduct) {$i=0;
				while ($result = $getProduct->fetch_assoc()) {
					$i++
				

			?>
				<tr class="odd gradeX">
					<td><?php echo $i; ?></td>
					<td><?php echo $result['productName']; ?></td>
					<td><?php echo $result['catName']; ?></td>
					<td><?php echo $result['brandName']; ?></td>
					<td><?php echo $fm->textShorten($result['body'], 50); ?></td>
					<td>$<?php echo $result['price']; ?></td>
					<td><img src="<?php echo $result['image']; ?>" height="40px" width="50px"></td>
					<td><?php 
					       if ($result['type'] == 0) {
					       	echo "Featured";
					       } else {
					       	echo "General";
					       }
					       
					    ?>					    	
					</td>
					<td><a href="productedit.php?proid=<?php echo $result['productId']; ?>">Edit</a> || 
					<a onclick=" return confirm('Are you sure to delete it!'); " href="?delpro=<?php echo $result['productId']; ?>">Delete</a></td>
				</tr>
            <?php
                }
			}
            ?>
			</tbody>
		</table>

       </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();
        $('.datatable').dataTable();
		setSidebarHeight();
    });
</script>
<?php include 'inc/footer.php';?>
