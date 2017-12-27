<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/Slogan.php'; ?>

<?php 
$slogan = new Slogan();
?>
<style type="text/css">
    .leftside{float: left;width: 70%;}
    .rightside{float: left;width: 20%;}
    .rightside img{height: 160px; width: 170px;}
</style>
<div class="grid_10">
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$updateslogan = $slogan->updateSlogan($_POST, $_FILES);
}    
?>
    <div class="box round first grid">
        <h2>Update Site Title and Description</h2>
        <?php
        if (isset($updateslogan)) {
            echo $updateslogan;
        }
        ?>
        <div class="block sloginblock">
        <?php
        $getdata = $slogan->getSlogan();
        if ($getdata) {
             while ($result = $getdata->fetch_assoc()) {
        ?>
        <div class="leftside">               
         <form action="" method="post" enctype="multipart/form-data">
            <table class="form">					
                <tr>
                    <td>
                        <label>Website Title</label>
                    </td>
                    <td>
                        <input type="text" value="<?php echo $result['title']; ?>"  name="title" class="medium" />
                    </td>
                </tr>
				 <tr>
                    <td>
                        <label>Website Slogan</label>
                    </td>
                    <td>
                        <input type="text" value="<?php echo $result['slogon']; ?>" name="slogan" class="medium" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Upload Logo</label>
                    </td>
                    <td>
                        <input type="file" name="logo" class="medium" />
                    </td>
                </tr> 				 
				<tr>
                    <td>
                    </td>
                    <td>
                        <input type="submit" name="submit" Value="Update" />
                    </td>
                </tr>
            </table>
            </form>
            </div>
            <div class="rightside">
                        <img src="<?php echo $result['logo']; ?>" alt="logo"/>
                    </div>
            <?php } } ?>
        </div>
    </div>
</div>
<?php include 'inc/footer.php';?>