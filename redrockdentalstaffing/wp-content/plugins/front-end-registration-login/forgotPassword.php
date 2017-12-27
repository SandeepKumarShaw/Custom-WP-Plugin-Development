<?php
// used for tracking error messages
function forgot_paswrd_log_errors(){
    static $wp_error; // Will hold global variable safely
    return isset($wp_error) ? $wp_error : ($wp_error = new WP_Error(null, null, null));
}

// displays error messages from form submissions
function forgot_paswrd_error_messages() {
	if($codes = forgot_paswrd_log_errors()->get_error_codes()) {
		echo '<div class="job_log_errors">';
		    // Loop error codes and display errors
		   foreach($codes as $code){
		        $message = forgot_paswrd_log_errors()->get_error_message($code);
		        echo '<span class="error"><strong>' . __('Error') . '</strong>: ' . $message . '</span><br/>';
		    }
		echo '</div>';
	}	
}


/*************Forgot Password Form Section Start************/
function custom_forgot_password_func(){
    //session_start();
    ob_start(); 
    /*************Forgot Password Form Submit Start************/
    if (isset( $_POST["custom_forgt_pass_submit"] ) && isset($_POST['custom_forgt_pass_submit_nonce']) && wp_verify_nonce($_POST['custom_forgt_pass_submit_nonce'], 'custom_forgt_pass-submit-nonce'))
    {
        //print_r($_REQUEST);
        
         //////////////ERROR CHECKING START////////////////
        
        if(!isset($_POST['custom_forgt_paswd_email']) || $_POST['custom_forgt_paswd_email'] == '') {
            // if no job title was entered
	    forgot_paswrd_log_errors()->add('empty_forgot_mail', __('Please enter a mail id'));
        }
        
        
        
        if($_POST['custom_forgt_paswd_email']){
            //echo "Hello";
            $u_mail = $_POST['custom_forgt_paswd_email'];
            $prevUser = get_user_by('email', $u_mail);
            //print_r($prevUser);
            if($prevUser > 0){
                //generat unique string
                $uniqidStr = md5(uniqid(mt_rand()));
                //print_r($uniqidStr);
                $u_id = $prevUser->ID;
            
                $update_status = update_user_meta( $u_id, 'forget_paswd_unique_id', $uniqidStr );
                if($update_status){
                    $resetPassLink = get_permalink(get_page_by_path('reset-password')).'?fp_code='.$uniqidStr;
                    //echo $resetPassLink;
                    $u_mail = $prevUser->data->user_email;
                    $admin_email = get_option( 'admin_email' );
                    
                    //send reset password email
                    $to = $u_mail;
                    $subject = "Password Update Request";
                    $mailContent = 'Dear '.$prevUser->data->user_nicename.', 
                    <br/>Recently a request was submitted to reset a password for your account. If this was a mistake, just ignore this email and nothing will happen.
                    <br/>To reset your password, visit the following link: <a href="'.$resetPassLink.'">'.$resetPassLink.'</a>
                    <br/><br/>Regards,
                    <br/>Staffing Agency';
                    //set content-type header for sending HTML email
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    //additional headers
                    $headers .= 'From: StaffingAgency<'.$admin_email.'>' . "\r\n";
                    //send email
                    mail($to,$subject,$mailContent,$headers);
                
                    $sessData['status']['type'] = 'success_msg';
                    $sessData['status']['msg'] = 'Please check your e-mail, we have sent a password reset link to your registered email.';
                
                }
                else{
                    $sessData['status']['type'] = 'error_msg';
                    $sessData['status']['msg'] = 'Some problem occurred, please try again.';
                }
            }
            else{
                $sessData['status']['type'] = 'error_msg';
                $sessData['status']['msg'] = 'Given email is not associated with any account.'; 
            }
            
        }
        else{
            $sessData['status']['type'] = 'error_msg';
            $sessData['status']['msg'] = 'Enter email to create a new password for your account.'; 
        }
        
        //store reset password status into the session
        $_SESSION['sessData'] = $sessData;        
    }     
    
    /*************Forgot Password Form Submit End************/
    
    ?>
    <?php
    //print_r($_SESSION);
     $sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';
    if(!empty($sessData['status']['msg'])){
        $statusMsg = $sessData['status']['msg'];
        $statusMsgType = $sessData['status']['type'];
        if($statusMsg && $statusMsgType){
            unset($_SESSION['sessData']['status']);
        }
        
    }
    ?>
    <?php echo !empty($statusMsg)?'<span class="'.$statusMsgType.'">'.$statusMsg.'</span>':''; ?> 
        <div class="forgot_psswrd">
            <h4>Enter the Email of Your Account to Reset New Password</h4>                
            <?php 
                // show any error messages after form submission
                forgot_paswrd_error_messages();
            ?>
            <form class="custom_forgt_pass_form" action="" method="post">
                <fieldset class="fp-flds custom_reg_log_form">
                    <div class="fp-label"><label for="custom_forgt_paswd_email">EMAIL</label></div>
                    <div class="fp-input-txt"><input name="custom_forgt_paswd_email" id="custom_forgt_paswd_email" class="required" type="email" required/></div>
                    <div class="fp-input-submit"><input type="hidden" name="custom_forgt_pass_submit_nonce" value="<?php echo wp_create_nonce('custom_forgt_pass-submit-nonce'); ?>"/><input type="submit" id="custom_forgt_pass_submit" name="custom_forgt_pass_submit" value="CONTINUE"></div>
                </fieldset>
            </form>
        </div>
        
        
    <?php
    return ob_get_clean();
}

add_shortcode('forgot_password', 'custom_forgot_password_func');
/*************Forgot Password Form Section End************/







/**********RESET PASSWORD SECTION SECTION START********/
// used for tracking error messages
function reset_paswrd_log_errors(){
    static $wp_error; // Will hold global variable safely
    return isset($wp_error) ? $wp_error : ($wp_error = new WP_Error(null, null, null));
}

// displays error messages from form submissions
function reset_paswrd_error_messages() {
	if($codes = reset_paswrd_log_errors()->get_error_codes()) {
		echo '<div class="job_log_errors">';
		    // Loop error codes and display errors
		   foreach($codes as $code){
		        $message = reset_paswrd_log_errors()->get_error_message($code);
		        echo '<span class="error"><strong>' . __('Error') . '</strong>: ' . $message . '</span><br/>';
		    }
		echo '</div>';
	}	
}


function custom_reset_password_func(){
    
    /********RESET PASSWORD Submit Function Start*******/
    $c = 0;
    if(isset($_POST['resetSubmit'])){
        
    $fp_code = '';
    if(!empty($_POST['password']) && !empty($_POST['confirm_password']) && !empty($_POST['fp_code'])){
        $fp_code = $_POST['fp_code'];
        //password and confirm password comparison
        if(preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $_POST['password']) === 0){
	    $sessData['status']['type'] = 'error_msg';
            $sessData['status']['msg'] = 'Password must be at least 8 characters and must contain at least one lower case letter, one upper case letter and one digit';	    
            // Password must be strong
	    //reset_paswrd_log_errors()->add('password_empty', __('Password must be at least 8 characters and must contain at least one lower case letter, one upper case letter and one digit'));
	    
        }elseif($_POST['password'] !== $_POST['confirm_password']){
	    $sessData['status']['type'] = 'error_msg';
            $sessData['status']['msg'] = 'Confirm password must match with the Password.';
	    //reset_paswrd_log_errors()->add('password_mismatch', __('Passwords do not match'));   
	    
	    
	}else{ //check whether identity code exists in the database
            $args = array(					
                'meta_query' => array(
                        //'relation' => 'OR', //**** Use AND or OR as per your required Where Clause
                        array(
                            'key' => 'forget_paswd_unique_id',
                            'value' => $fp_code,
                            'compare' => '=',
                        )		
                )					
	    ); 
	    $prevUser = get_users($args);
            //print_r($prevUser);
            if($prevUser){
                $user_id = $prevUser[0]->ID;
                //$new_pass = md5($_POST['password']);
                $new_pass = $_POST['password'];
                wp_set_password( $new_pass, $user_id );
                
                $sessData['status']['type'] = 'success_msg';
                $sessData['status']['msg'] = 'Your account password has been reset successfully. Please <a href="'.get_permalink(get_page_by_path('login-now')).'">login</a> with your new password.';
                delete_user_meta( $user_id, 'forget_paswd_unique_id'); //09.11.2017
                $c = 1;
            }        
        }
    }else{
        $sessData['status']['type'] = 'error_msg';
        $sessData['status']['msg'] = 'All fields are mandatory, please fill all the fields.'; 
    }
    //store reset password status into the session
    $_SESSION['sessData'] = $sessData;
    /*
     *$redirectURL = ($sessData['status']['type'] == 'success')?'index.php':'resetPassword.php?fp_code='.$fp_code;
    //redirect to the login/reset pasword page
    header("Location:".$redirectURL);
    */
} 
    
    
    
    
    /********RESET PASSWORD Submit Function End*******/
    
    
    
    
    
    
    
    //print_r($_SESSION);
        
        if($_REQUEST['fp_code']){
            $args = array(					
                'meta_query' => array(
                        //'relation' => 'OR', //**** Use AND or OR as per your required Where Clause
                        array(
                            'key' => 'forget_paswd_unique_id',
                            'value' => $_REQUEST['fp_code'],
                            'compare' => '=',
                        )		
                )					
	    ); 
	    $checkUser = get_users($args);
            if(!$checkUser){
                $counter = 2;
            }
            else{
                $counter = 1;
            }
        }
        else{
            $counter = 2;
        }
        ?>
        <?php if($counter == 1 || ($counter == 2 && $c == 1)){ ?>
        <?php
        $sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';
        if(!empty($sessData['status']['msg'])){
            $statusMsg = $sessData['status']['msg'];
            $statusMsgType = $sessData['status']['type'];
            unset($_SESSION['sessData']['status']);
        }
        ?>
            <?php echo !empty($statusMsg)?'<span class="'.$statusMsgType.'">'.$statusMsg.'</span>':''; ?>
            <div class="forgot_psswrd">
                <div class="container">
                    <div class="regisFrm  custom_reg_log_form">
			<?php reset_paswrd_error_messages();?>
                      <form action="" method="post" name="set_new_password">
						<div class="newpass">
							<label for="newpassword">New Password</label>
							<input type="password" name="password" id="newpassword" placeholder="PASSWORD">
						</div>
						
						<div class="confnewpass">
							<label for="confirm_password">Confirm Password</label>
							<input type="password" name="confirm_password" id="confirm_password" placeholder="CONFIRM PASSWORD">
						</div>
                        
                        <div class="send-button">
                            <input type="hidden" name="fp_code" value="<?php echo $_REQUEST['fp_code']; ?>"/>
                            <input type="submit" name="resetSubmit" value="RESET PASSWORD">
                        </div>
                      </form>
                    </div>
                </div>
            </div>
        <?php }else{
            echo "<div class='job-listing-hld'>You are not authorised to see this form anymore</div>";
            } ?>
<?php
}

add_shortcode('reset_password', 'custom_reset_password_func');

/*********RESET PASSWORD SECTION SECTION END********/