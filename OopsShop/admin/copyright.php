<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php 
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../classes/Copyright.php');

$copy = new Copyright();
?>
<div class="grid_10">
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) { 
    $copyright  = $_POST['copyright'];
    $updateCopy = $copy->updateCopyright($copyright);
}
?>    
    <div class="box round first grid">
        <h2>Update Copyright Text</h2>
        <?php
           if (isset($updateCopy)) {
               echo $updateCopy;
           }
        ?>
        <div class="block copyblock"> 
        <?php 
        $getdata = $copy->getCopyright();
        if ($getdata) {
            while ( $result = $getdata->fetch_assoc()) {
               
        ?>
         <form action="" method="post">
            <table class="form">					
                <tr>
                    <td>
                        <input type="text" value="<?php echo $result['note']; ?>" name="copyright" class="large" />
                    </td>
                </tr>
				
				 <tr> 
                    <td>
                        <input type="submit" name="submit" Value="Update" />
                    </td>
                </tr>
            </table>
            </form>
        <?php } } ?>    
        </div>
    </div>
</div>
<?php include 'inc/footer.php';?>