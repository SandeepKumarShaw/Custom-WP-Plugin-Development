<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
/**
* Cart Class
*/
class Cart{
	private $db;
	private $fm;

	public function __construct(){
		$this->db = new Database();
		$this->fm = new Format();
	}
	public function addToCart($quantity, $id){
		$quantity  = $this->fm->validation($quantity);
		$quantity  = mysqli_real_escape_string($this->db->link, $quantity);
		$productId = mysqli_real_escape_string($this->db->link, $id);
		$sId       = session_id();

		$squery    = "SELECT * FROM tbl_product WHERE productId = '$productId'";
		$result    = $this->db->select($squery)->fetch_assoc();

		$productName = $result['productName'];
		$price       = $result['price'];
		$image       = $result['image'];

		$chkquery = "SELECT * FROM tbl_cart WHERE productId = '$productId' AND sId = '$sId'";
		$chkresult = $this->db->select($chkquery);
        if ($chkresult) {
        	$msg = "You Have Already Added this Product! ";
        	return $msg;
        } else {
        	        
		$query = "INSERT INTO tbl_cart(sId, productId, productName, price, quantity, image) Values('$sId', '$productId', '$productName', '$price', '$quantity','$image')";
		$Insert_row = $this->db->insert($query);
			if($Insert_row){
				header("Location:cart.php");
			}
			 else {
				header("Location:404.php");
			}	
		}	

	}
	public function getCartProduct(){
		$sId       = session_id();
		$query     = "SELECT * FROM tbl_cart WHERE sId ='$sId'";
		$result    = $this->db->select($query);
		return $result;
	}
	public function updateCartQuantity($cartId, $quantity){
		$quantity  = $this->fm->validation($quantity);
		$quantity  = mysqli_real_escape_string($this->db->link, $quantity);
		$cartId    = $this->fm->validation($cartId);
		$cartId    = mysqli_real_escape_string($this->db->link, $cartId);

		$query = "UPDATE tbl_cart SET quantity = '$quantity' WHERE cartId = '$cartId'";
		$result = $this->db->update($query);
		if ($result) {
			header("Location:cart.php");
		} else {
			$msg = "<span class='error'>Quantity Not Updated Successfully!</span>";
        	return $msg;
		}
		

	}
	public function delProductByCart($delId){
		$delId  = $this->fm->validation($delId);
		$delId  = mysqli_real_escape_string($this->db->link, $delId);
		$query = "DELETE FROM tbl_cart WHERE cartId = '$delId'";
		$result = $this->db->delete($query);
		if ($result) {
			header("Location:cart.php");
			
		} else {
			$msg = "<span class='error'>Product Not Deleted Successfully From Cart!</span>";
        	return $msg;
		}
	}
	public function checkCartTable(){
		$sId       = session_id();
		$query     = "SELECT * FROM tbl_cart WHERE sId ='$sId'";
		$result = $this->db->select($query);
		return $result;
	}
	public function delCustomerCart(){

        $sId       = session_id();
		$query     = "DELETE FROM tbl_cart WHERE sId = '$sId'";
		$result    = $this->db->delete($query);
	}
	public function orderProduct($cmrId){
		$sId        = session_id();
		$query      = "SELECT * FROM tbl_cart WHERE sId ='$sId'";
		$getPro     = $this->db->select($query);
		if ($getPro) {
			while ($result = $getPro->fetch_assoc()) {
				$productId   = $result['productId'];
				$productName = $result['productName'];
				$price       = $result['price'];
				$quantity    = $result['quantity'];
				$image       = $result['image'];
				$query = "INSERT INTO tbl_order(cmrId, productId, productName, price, quantity, image) Values('$cmrId', '$productId', '$productName', '$price', '$quantity','$image')";
		        $Insert_row = $this->db->insert($query);
				
			}
		}
	}
	public function payableAmount($cmrId){
		$query      = "SELECT price FROM tbl_order WHERE cmrId ='$cmrId' AND date = now()";
		$result     = $this->db->select($query);
		return $result;

	}
	public function getOrderProduct($cmrId){
		$query      = "SELECT * FROM tbl_order WHERE cmrId ='$cmrId' ORDER BY productId DESC";
		$result     = $this->db->select($query);
		return $result;
	}
	public function checkOrder($cmrId){
		$query     = "SELECT * FROM tbl_order WHERE cmrId ='$cmrId'";
		$result = $this->db->select($query);
		return $result;
	}
	public function getAllOrderProduct(){
		$query      = "SELECT * FROM tbl_order ORDER BY date DESC";
		$result     = $this->db->select($query);
		return $result;

	}
	public function productShifted($id, $price, $time){
		$id    = mysqli_real_escape_string($this->db->link, $id);		
		$time  = mysqli_real_escape_string($this->db->link, $time);
		$price = mysqli_real_escape_string($this->db->link, $price);
		
		$query   = "UPDATE tbl_order 
		            SET status = '1' 
		            WHERE cmrId = '$id' 
		            AND date = '$time' 
		            AND price = '$price'";
		
		$result  = $this->db->update($query);
		if ($result) {
			$msg = "<span class ='success'>Updated Successfully!</span>";			
			return $msg;
		} else {
			$msg = "<span class ='error'>Not Updated Successfully!</span>";			
			return $msg;
		}

	}
	public function delproductShifted($id, $price, $time){
		$id    = mysqli_real_escape_string($this->db->link, $id);		
		$time  = mysqli_real_escape_string($this->db->link, $time);
		$price = mysqli_real_escape_string($this->db->link, $price);
		$query = "DELETE FROM tbl_order WHERE cmrId = '$id' AND date = '$time' AND price = '$price'";
		$result= $this->db->delete($query);
		if ($result) {
			$msg = "<span class ='success'>Deleted Successfully!</span>";			
			return $msg;
		} else {
			$msg = "<span class ='error'>Not Deleted Successfully!</span>";			
			return $msg;
		}

	}
	public function productShiftedConfirm($id, $price, $time){
		$id    = mysqli_real_escape_string($this->db->link, $id);		
		$time  = mysqli_real_escape_string($this->db->link, $time);
		$price = mysqli_real_escape_string($this->db->link, $price);
		
		$query   = "UPDATE tbl_order SET status = '2' WHERE cmrId = '$id' AND date = '$time' AND price = '$price'";
		
		$result  = $this->db->update($query);
		if ($result) {
			$msg = "<span class ='success'>Updated Successfully!</span>";			
			return $msg;
		} else {
			$msg = "<span class ='error'>Not Updated Successfully!</span>";			
			return $msg;
		}

	}
	

}

?>