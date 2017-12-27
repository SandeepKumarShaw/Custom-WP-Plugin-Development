<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/Brand.php'; ?>
<?php 
if (!isset($_GET['brandid']) || $_GET['brandid'] == NULL) {
    echo "<script>window.location = 'brandlist.php'</script>";
} else {
    $id = $_GET['brandid'];
}

$brand = new Brand();
if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $brandName  = $_POST['brandName'];
    $updateBrand = $brand->brandUpdate($brandName, $id);

}

?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Update Brand</h2>
               
            <?php 
            if (isset($updateBrand)) {
                echo $updateBrand;

            }
            ?>
            <?php 

            $getBrand = $brand->getBrandById($id);
            if ($getBrand) {
                while ($result = $getBrand->fetch_assoc()) {
                   
               

            ?>
         
               <div class="block copyblock"> 
                 <form action="" method="post">
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text" name="brandName" value="<?php echo $result['brandName']; ?>" class="medium" />
                            </td>
                        </tr>
						<tr> 
                            <td>
                                <input type="submit" name="submit" Value="Update Brand" />
                            </td>
                        </tr>
                    </table>
                    </form>
                </div>
                <?php 
                  }
                }
                ?>
            </div>
        </div>
<?php include 'inc/footer.php';?>