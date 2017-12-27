<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
/**
* Contact Class
*/
class Contact{
	private $db;
	private $fm;

	public function __construct(){
		$this->db = new Database();
		$this->fm = new Format();
	}
	public function sendMail($data){
		        $fname = $this->fm->validation($_POST['firstname']);
     	        $lname = $this->fm->validation($_POST['lastname']);
     	        $email = $this->fm->validation($_POST['email']);
     	        $body  = $this->fm->validation($_POST['body']);    	
     	        
     		    $fname =mysqli_real_escape_string($this->db->link, $fname);
     		    $lname =mysqli_real_escape_string($this->db->link, $lname);
     		    $email =mysqli_real_escape_string($this->db->link, $email);
     		    $body  =mysqli_real_escape_string($this->db->link, $body);
     		    $error = "";
     		    if (empty($fname)) {
     		    	$error = "First Name Must NOT Be Empty";
     		    	return $error;
     		    }elseif (empty($lname)) {
     		    	$error = "Last Name Must NOT Be Empty";
     		    	return $error;
     		    }elseif (empty($email)) {
     		    	$error = "Email Must NOT Be Empty";
     		    	return $error;
     		    }elseif ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
     		    	$error = "Inalid Email Address !";
     		    	return $error;
     		    }elseif (empty($body)) {
     		    	$error = "Message Field Must NOT Be Empty";
     		    	return $error;
     		    } else {
     		    	$chkquery = "SELECT * FROM tbl_contact WHERE email = '$email'";
     		    	$chkresult = $this->db->select($chkquery);
     		    	if ($chkresult) {
     		    		$error = "You have Already Sent Message!";
     		    	    return $error;
     		    	} else {
     		    		$query = "INSERT INTO tbl_contact(firstname, lastname, email, body) VALUES('$fname', '$lname', '$email', '$body')";
     		    	$Inserted_rows = $this->db->insert($query);
     		    	if ($Inserted_rows) {
     		    		
     		    		 $to = "sandeepshaw35@gmail.com";
                         $from = "$email";                         
                         $headers  = "From: $from\n";
                         $headers .= 'MIME-Version: 1.0';
                         $headers .= 'Content-type: text/html; charset=iso-8859-1';
                         $subject = "Forgot Password Mail";
                         $message = "Name:".$fname. ' ' .$lname."<br/>Email:".$email."<br/>Message:".$body;
                         $sendmail = mail($to, $subject, $message, $headers);
		                 if ($sendmail) {
		                     $error = "<span style='color:red;font-size:18px;'>Email Sent Successfully!!!</span>";
		                     return $error;
		                 } else {
		                      $error = "<span style='color:red;font-size:18px;'>Email Not Sent Successfully!!!</span>";
		                      return $error;
		                 }
     		    	} else {
     		    		$error = "Message Not Sent Successfully!!!";
     		    		return $error;
     		    	} 
     		    	}
     		    	
     		    	

     		    }	

	}
}
?>