<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../classes/Password.php');
?>

<?php 
$pass = new Password();
?>
<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username  = Session::get("adminUser");
    $changePass = $pass->changePasswordAdmin($_POST, $username);

} 
?>                    
<div class="grid_10">
    <div class="box round first grid">
        <h2>Change Password</h2>
        <?php
         if (isset($changePass)) {
             echo $changePass;
         }
        ?>
        <div class="block">               
                <form action="" method="post">
                    <table class="form">                    
                        <tr>
                            <td>
                                <label>Old Password</label>
                            </td>
                            <td>
                                <input type="password" placeholder="Enter Old Password..."  name="opassword" class="medium" />
                            </td>
                        </tr>
                         <tr>
                            <td>
                                <label>New Password</label>
                            </td>
                            <td>
                                <input type="password" placeholder="Enter New Password..." name="password" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Confirm Password</label>
                            </td>
                            <td>
                                <input type="password" placeholder="Enter New Password..." name="cpassword" class="medium" />
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
    </div>
</div>
<?php include 'inc/footer.php';?>