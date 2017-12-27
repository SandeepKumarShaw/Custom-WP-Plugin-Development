<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/Social.php'; ?>
<?php 
$social = new Social();
?>
<div class="grid_10">
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$updatesocial = $social->updateSocialData($_POST);
} 
?>
    <div class="box round first grid">
        <h2>Update Social Media</h2>
        <?php
          if (isset($updatesocial)) {
              echo $updatesocial;
          }
        ?>
        <div class="block"> 
        <?php
         $getData = $social->getSocialData();
         if ($getData) {
             while ($result = $getData->fetch_assoc()) {
        ?>              
         <form action="" method="post">
            <table class="form">					
                <tr>
                    <td>
                        <label>Facebook</label>
                    </td>
                    <td>
                        <input type="text" name="facebook" value="<?php echo $result['fb']; ?>" class="medium" />
                    </td>
                </tr>
				 <tr>
                    <td>
                        <label>Twitter</label>
                    </td>
                    <td>
                        <input type="text" name="twitter" value="<?php echo $result['tw']; ?>" class="medium" />
                    </td>
                </tr>
				
				 <tr>
                    <td>
                        <label>LinkedIn</label>
                    </td>
                    <td>
                        <input type="text" name="linkedin" value="<?php echo $result['ln']; ?>" class="medium" />
                    </td>
                </tr>
				
				 <tr>
                    <td>
                        <label>Google Plus</label>
                    </td>
                    <td>
                        <input type="text" name="googleplus" value="<?php echo $result['gp']; ?>" class="medium" />
                    </td>
                </tr>
				
				 <tr>
                    <td></td>
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