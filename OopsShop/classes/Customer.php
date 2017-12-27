<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
/**
* Customer Class
*/
class Customer{
	private $db;
	private $fm;

	public function __construct(){
		$this->db = new Database();
		$this->fm = new Format();
	}
	public function customerRegistration($data){
		$name           = $this->fm->validation($data['name']);
		$address        = $this->fm->validation($data['address']);
		$city           = $this->fm->validation($data['city']);
		$country        = $this->fm->validation($data['country']);
		$zip            = $this->fm->validation($data['zip']);
		$phone          = $this->fm->validation($data['phone']);
		$email          = $this->fm->validation($data['email']);
		$password       = $this->fm->validation(md5($data['password']));

		$name           = mysqli_real_escape_string($this->db->link, $name);
		$address        = mysqli_real_escape_string($this->db->link, $address);
		$city           = mysqli_real_escape_string($this->db->link, $city);
		$country        = mysqli_real_escape_string($this->db->link, $country);
		$zip            = mysqli_real_escape_string($this->db->link, $zip);
		$phone          = mysqli_real_escape_string($this->db->link, $phone);
		$email          = mysqli_real_escape_string($this->db->link, $email);
		$password       = mysqli_real_escape_string($this->db->link, $password);

		if ( $name == "" || $address == "" || $city == "" || $country == "" || $zip == "" || $phone == "" || $email == "" || $password == "") {
           $msg ="<span class='error'>Field Must Not Be Empty!!!</span>";
           return $msg;
        }elseif ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {     		    	
     		    	$msg ="<span class='error'>Inalid Email Address !.</span>";
                    return $msg;
        } else{

        $mailquery = "SELECT * FROM tbl_customer WHERE email = '$email' LIMIT 1";
        $mailcheck = $this->db->select($mailquery);
        if ($mailcheck != false) {
        	$msg ="<span class='error'>Email Already exists!!!</span>";
           return $msg;
        } else{
        	$query = "INSERT INTO tbl_customer(name, address, city, country, zip, phone, email, pass) VALUES('$name', '$address', '$city', '$country', '$zip', '$phone', '$email', '$password')";
        	$InsertCustomer = $this->db->insert($query);
            if ($InsertCustomer) {
                $msg ="<span class='success'>Customer Registration  Successfully!.</span>";
                return $msg;
            }else {
               $msg ="<span class='error'>Customer Not Registration  Successfully!.</span>";
               return $msg;
            }

        }
       }
    }
    public function customerLogin($data){
	    $email          = $this->fm->validation($data['email']);
		$email          = mysqli_real_escape_string($this->db->link, $email);
		$password       = $this->fm->validation(md5($data['password']));
		$password       = mysqli_real_escape_string($this->db->link, $password);
		if (empty($email) || empty($password )) {
			$msg ="<span class='error'>Field Must not be Empty!.</span>";
            return $msg;
		} else {
			$query = "SELECT * FROM tbl_customer WHERE email = '$email' AND pass = '$password'";
			$result = $this->db->select($query);
			if ($result != false) {
				$value = $result->fetch_assoc();
				Session::set("custlogin", true);
				Session::set("cmrId", $value['id']);
				Session::set("cmrName", $value['name']);
				header("Location: cart.php");
			} else {
				$msg ="<span class='error'>Email Or Password not Matched!.</span>";
               return $msg;
			}
			
		}	

    }
    public function getCustomerData($id){
    	$query = "SELECT * FROM tbl_customer WHERE id = '$id'";
    	$result = $this->db->select($query);
    	return $result;
    }
    public function customerUpdate($data, $cmrId){
    	$name           = $this->fm->validation($data['name']);
		$address        = $this->fm->validation($data['address']);
		$city           = $this->fm->validation($data['city']);
		$country        = $this->fm->validation($data['country']);
		$zip            = $this->fm->validation($data['zip']);
		$phone          = $this->fm->validation($data['phone']);
		$email          = $this->fm->validation($data['email']);
		
		$name           = mysqli_real_escape_string($this->db->link, $name);
		$address        = mysqli_real_escape_string($this->db->link, $address);
		$city           = mysqli_real_escape_string($this->db->link, $city);
		$country        = mysqli_real_escape_string($this->db->link, $country);
		$zip            = mysqli_real_escape_string($this->db->link, $zip);
		$phone          = mysqli_real_escape_string($this->db->link, $phone);
		$email          = mysqli_real_escape_string($this->db->link, $email);

		if ( $name == "" || $address == "" || $city == "" || $country == "" || $zip == "" || $phone == "" || $email == "" ) {
            $msg ="<span class='error'>Field Must Not Be Empty!!!</span>";
            return $msg;
        }elseif ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {     		    	
		    $msg ="<span class='error'>Inalid Email Address !.</span>";
            return $msg;
        } else{
        	$query = "UPDATE tbl_customer SET name = '$name', address = '$address', city = '$city', country = '$country', zip = '$zip', phone= '$phone', email = '$email' WHERE id = '$cmrId'";
        	$UpdateCustomer = $this->db->update($query);
            if ($UpdateCustomer) {
                $msg ="<span class='success'>Customer Details Update  Successfully!.</span>";
                return $msg;
            }else {
               $msg ="<span class='error'>Customer Details Not Update  Successfully!.</span>";
               return $msg;
            }
        }
    }
    

}
?>