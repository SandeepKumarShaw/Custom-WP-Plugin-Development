<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
/**
* Password Class
*/
class Password{
	private $db;
	private $fm;
	public function __construct(){
		$this->db = new Database();
		$this->fm = new Format();
	}
	public function changePasswordAdmin($data, $username){
		$opassword  = $data['opassword'];
        $password   = $data['password'];                   
        $cpassword  = $data['cpassword'];  
        $opassword  = $this->fm->validation(md5($opassword));   
        $password   = $this->fm->validation(md5($password));
        $cpassword  = $this->fm->validation(md5($cpassword));
        $opassword  = mysqli_real_escape_string($this->db->link, $opassword);
        $password   = mysqli_real_escape_string($this->db->link, $password);
        $cpassword  = mysqli_real_escape_string($this->db->link, $cpassword);
        if ($opassword == "" || $password == "" || $cpassword == "" ) {
        	$msg = "<span class ='error'>Field Must Not Be Empty!!!</span>";			
			return $msg;                      
        } else {
        	if ($password != $cpassword) {
                $msg = "<span class ='error'>Enter New Password not Matched with Confirm password!!!</span>";
                return $msg;
            }
            else {
	             $oldquery    = "SELECT * FROM tbl_admin WHERE adminUser='$username' and adminPass='$opassword'";
                 $oldresult   = $this->db->select($oldquery);
                if ($oldresult) {
                	$query    = "UPDATE tbl_admin SET adminPass='$password' where adminUser='$username'";
                    $result   = $this->db->update($query);
                    if ($result) {
                    	$changequery    = "SELECT * FROM tbl_admin WHERE adminUser='$username' and adminPass='$opassword'";
                        $changeresult   = $this->db->select($changequery);
	                        if ($changeresult != false) {                       
	                        $value = $changeresult->fetch_assoc();
							Session::set("adminlogin", true);
							Session::set("adminId", $value['adminId']);
							Session::set("adminUser", $value['adminUser']);
							Session::set("adminName", $value['adminName']);	
							$msg = "<span class ='error'>Password Updated!!</span>";
                    	    return $msg;                        
	                        }
                    } else {
                    	$msg = "<span class ='error'>Password Not Updated!!</span>";
                    	return $msg;
                    }
                    
                } else {
                	$msg = "<span class ='error'>Enter Old Password Not Matched!!!</span>";
                   return $msg;
                }
            }
        } 	
    }
    public function forgotPasswordAdmin($data){
    	$email = $this->fm->validation($data['email']);   	
     	$email =mysqli_real_escape_string($this->db->link, $email);
        if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
            $msg = "<span style='color:red;font-size:18px;'>Inalid Email Address !</span>";
            return $msg;
        }else{

            $mailquery   = "SELECT * FROM tbl_admin WHERE adminEmail = '$email' limit 1";
            $mailchechk   = $this->db->select($mailquery);
            if ( $mailchechk != false ) {
                 while ( $result = $mailchechk->fetch_assoc() ) {
                     $userid = $result['adminId'];
                     $username = $result['adminUser'];
                 }
                 $text     = substr($email, 0, 3);
                 $rand     = rand(10000, 99999);
                 $newpass  = "$text$rand";
                 $password = md5($newpass);
                 $updatequery = "UPDATE tbl_admin SET adminPass = '$password' WHERE adminId = '$userid'";
                 $updated_row = $this->db->update($updatequery);
                 $to = "$email";
                 $from = "sandeepshaw35@gmail.com";                         
                 $headers  = "From: $from\n";
                 $headers .= 'MIME-Version: 1.0';
                 $headers .= 'Content-type: text/html; charset=iso-8859-1';
                 $subject = "Forgot Password Mail";
                 $message = "Your UserName is".$username."Your Password is".$newpass."Please Viste Website to Login";
                 $sendmail = mail($to, $subject, $message, $headers);
	                 if ($sendmail) {
	                     $msg = "<span style='color:red;font-size:18px;'>Email Sent Successfully!!!</span>";
	                     return $msg;
	                 } else {
	                      $msg = "<span style='color:red;font-size:18px;'>Email Not Sent Successfully!!!</span>";
	                      return $msg;
	                 }
            }else{
                 $msg = "<span style='color:red;font-size:18px;'>Email Not Exists!!!</span>";
                 return $msg;
            }
        }	

    }
	
}
?>