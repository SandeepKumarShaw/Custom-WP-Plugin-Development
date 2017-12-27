<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');

/**
* Brand Class
*/

class Brand{
	private $db;
	private $fm;

	public function __construct(){
		$this->db = new Database();
		$this->fm = new Format();
	}
	public function brandInsert($brandName){
		$brandName = $this->fm->validation($brandName);
		$brandName = mysqli_real_escape_string($this->db->link, $brandName);
		if( empty($brandName) ) {
			$msg = "<span class ='error'>Brand Name must not be empty!</span>";
			return $msg;
		} else {
			$query = "INSERT INTO tbl_brand(brandName) VALUES('$brandName')";
			$brandInserted = $this->db->insert($query);
			if($brandInserted){
				$msg = "<span class ='success'>Brand Inserted Successfully!</span>";			
			    return $msg;
			} else {
				$msg = "<span class ='error'>Brand Not Inserted Successfully!</span>";			
			    return $msg;
			}		
		}
	}
	public function getAllBrand(){
		$query  = "SELECT * FROM tbl_brand ORDER BY brandId";
		$result = $this->db->select($query);
		return $result;
	}
	public function getBrandById($id){
		$query  = "SELECT * FROM tbl_brand WHERE brandId = '$id'";
		$result = $this->db->select($query);
		return $result;
	}
	public function brandUpdate($brandName, $id){
		$brandName = $this->fm->validation($brandName);
		$brandName = mysqli_real_escape_string($this->db->link, $brandName);
		if( empty($brandName) ) {
			$msg = "<span class ='error'>Brand Name must not be empty!</span>";
			return $msg;
		} else {
			$query = "UPDATE tbl_brand SET brandName = '$brandName' WHERE brandId = '$id'";
			$brandUpdated = $this->db->update($query);
			if($brandUpdated){
				$msg = "<span class ='success'>Brand Updated Successfully!</span>";			
			    return $msg;
			} else {
				$msg = "<span class ='error'>Brand Not Updated Successfully!</span>";			
			    return $msg;
			}		
		}

	}
	public function delBrandById($id){
		$query = "DELETE FROM tbl_brand WHERE brandId = '$id'";
		$brandDeleted = $this->db->delete($query);
			if($brandDeleted){
				$msg = "<span class ='success'>Brand Deleted Successfully!</span>";			
			    return $msg;
			} else {
				$msg = "<span class ='error'>Brand Not Deleted Successfully!</span>";			
			    return $msg;
			}	
	}

	
}
?>