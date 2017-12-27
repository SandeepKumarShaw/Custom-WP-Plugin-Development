<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
/**
* Product Class
*/
class Product{
	private $db;
	private $fm;

	public function __construct(){
		$this->db = new Database();
		$this->fm = new Format();
	}
	public function productInsert($data, $file){
		$productName = $this->fm->validation($data['productName']);
		$catId       = $this->fm->validation($data['catId']);
		$brandId     = $this->fm->validation($data['brandId']);
		$body        = $this->fm->validation($data['body']);
		$price       = $this->fm->validation($data['price']);
		$type        = $this->fm->validation($data['type']);

		$productName = mysqli_real_escape_string($this->db->link, $productName);
		$catId       = mysqli_real_escape_string($this->db->link, $catId);
		$brandId     = mysqli_real_escape_string($this->db->link, $brandId);
		$body        = mysqli_real_escape_string($this->db->link, $body);
		$price       = mysqli_real_escape_string($this->db->link, $price);
		$type        = mysqli_real_escape_string($this->db->link, $type);

		$permited    = array('jpg', 'jpeg', 'png', 'gif');
        $file_name   = $_FILES['image']['name'];
        $file_size   = $_FILES['image']['size'];
        $file_temp   = $_FILES['image']['tmp_name'];
        $div         = explode('.', $file_name);
        $file_ext    = strtolower(end($div));

       $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
       $uploaded_image = "upload/".$unique_image;

       if ( $productName == "" || $catId == "" || $brandId == "" || $body == "" || $price == "" || $type == "" || $file_name == "" ) {
           $msg ="<span class='error'>Field Must Not Be Empty!!!</span>";
           return $msg;
        }elseif ($file_size >1048567) {
            $msg ="<span class='error'>Image Size should be less then 1MB!</span>";
            return $msg;
        } elseif (in_array($file_ext, $permited) === false) {
            $msg ="<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";
            return $msg;
        } else{
            move_uploaded_file($file_temp, $uploaded_image);
            $query = "INSERT INTO tbl_product(productName, catId, brandId, body, price, image, type) VALUES('$productName', '$catId', '$brandId', '$body', '$price', '$uploaded_image', '$type')";
            $inserted_rows = $this->db->insert($query);
            if ($inserted_rows) {
                $msg ="<span class='success'>Product Inserted Successfully.</span>";
                return $msg;
            }else {
               $msg ="<span class='error'>Product Not Inserted !</span>";
               return $msg;
            }
        }

	}
  public function getAllProduct(){
     /*Inner join of three table using alias*/
     /* $query = "SELECT p.*, c.catName, b.brandName 
               FROM tbl_product as p, tbl_category as c, tbl_brand as b
               WHERE p.catId = c.catId AND p.brandId = b.brandId
               ORDER BY p.productId DESC";   */


    /*Inner join of three table*/
    $query = "SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName
              FROM tbl_product 
              INNER JOIN tbl_category
              ON tbl_product.catId = tbl_category.catId
              INNER JOIN tbl_brand
              ON tbl_product.brandId = tbl_brand.brandId
              ORDER BY tbl_product.productId DESC";
         

    $result = $this->db->select($query);
    return $result;
  }
  public function getProductById($id){
    $query = "SELECT * FROM tbl_product WHERE productId = '$id'";
    $result = $this->db->select($query);
    return $result;
  }
  public function productUpdate($data, $file, $id){
    $productName = $this->fm->validation($data['productName']);
    $catId       = $this->fm->validation($data['catId']);
    $brandId     = $this->fm->validation($data['brandId']);
    $body        = $this->fm->validation($data['body']);
    $price       = $this->fm->validation($data['price']);
    $type        = $this->fm->validation($data['type']);

    $productName = mysqli_real_escape_string($this->db->link, $productName);
    $catId       = mysqli_real_escape_string($this->db->link, $catId);
    $brandId     = mysqli_real_escape_string($this->db->link, $brandId);
    $body        = mysqli_real_escape_string($this->db->link, $body);
    $price       = mysqli_real_escape_string($this->db->link, $price);
    $type        = mysqli_real_escape_string($this->db->link, $type);

    $permited    = array('jpg', 'jpeg', 'png', 'gif');
    $file_name   = $_FILES['image']['name'];
    $file_size   = $_FILES['image']['size'];
    $file_temp   = $_FILES['image']['tmp_name'];
    $div         = explode('.', $file_name);
    $file_ext    = strtolower(end($div));

    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
    $uploaded_image = "upload/".$unique_image;

    if ( $productName == "" || $catId == "" || $brandId == "" || $body == "" || $price == "" || $type == "" ) {
       $msg ="<span class='error'>Field Must Not Be Empty!!!</span>";
       return $msg;
    }else{
          if(!empty($file_name)){
            if ($file_size >1048567) {
                $msg ="<span class='error'>Image Size should be less then 1MB!</span>";
                return $msg;
            } elseif (in_array($file_ext, $permited) === false) {
                $msg ="<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";
                return $msg;
            }else{
                move_uploaded_file($file_temp, $uploaded_image);
                $query = "UPDATE tbl_product SET productName = '$productName', catId = '$catId', brandId = '$brandId', body = '$body', price = '$price', image = '$uploaded_image', type = '$type' WHERE productId = '$id'";
                $updated_rows = $this->db->update($query);
                if ($updated_rows) {
                    $msg ="<span class='success'>Product Updated Successfully.</span>";
                    return $msg;
                }else {
                    $msg ="<span class='error'>Product Not Updated !</span>";
                    return $msg;
                }
              }
            }else{
                $query = "UPDATE tbl_product SET productName = '$productName', catId = '$catId', brandId = '$brandId', body = '$body', price = '$price', type = '$type' WHERE productId = '$id'";
                $updated_rows = $this->db->update($query);
                if ($updated_rows) {
                    $msg ="<span class='success'>Product Updated Successfully.</span>";
                    return $msg;
                }else {
                    $msg ="<span class='error'>Product Not Updated !</span>";
                    return $msg;
                }
            }
        }
  }
  public function delProductById($id){
    $fquery = "SELECT * FROM tbl_product WHERE productId = '$id' ";
    $getdata = $this->db->select($fquery);
    if ($getdata) {
        while ($delimage = $getdata->fetch_assoc()) {
        $dellink = $delimage['image'];
        unlink($dellink); 
      }
    }
    $query = "DELETE FROM tbl_product WHERE productId = '$id'";
    $result = $this->db->delete($query);
    if ($result) {
      $msg ="<span class='success'>Product Deleted Successfully.</span>";
      return $msg;
    } else {
      $msg ="<span class='error'>Product Not Deleted !</span>";
      return $msg;
    }
    
  }
  public function getFeaturedProduct(){
    $query = "SELECT * FROM tbl_product WHERE type = '0' ORDER BY productId DESC LIMIT 4";
    $result = $this->db->select($query);
    return $result;

  }
  public function getNewProduct(){
    $query = "SELECT * FROM tbl_product ORDER BY productId DESC LIMIT 4";
    $result = $this->db->select($query);
    return $result;
  }
  public function getSingleProduct($id){
    $query = "SELECT tbl_product.*, tbl_category.catName,tbl_brand.brandName
              FROM tbl_product
              INNER JOIN tbl_category
              ON tbl_product.catId = tbl_category.catId
              INNER JOIN tbl_brand
              ON tbl_product.brandId = tbl_brand.brandId
              WHERE productId ='$id'";
    $result = $this->db->select($query);
    return $result;          
  }
  public function latestFromIphone(){
    $query = "SELECT * FROM tbl_product WHERE brandId = '4' ORDER BY productId DESC LIMIT 1";
    $result = $this->db->select($query);
    return $result;
  }
  public function latestFromSamsung(){
    $query = "SELECT * FROM tbl_product WHERE brandId = '6' ORDER BY productId DESC LIMIT 1";
    $result = $this->db->select($query);
    return $result;    
  }
  public function latestFromAcer(){
    $query = "SELECT * FROM tbl_product WHERE brandId = '3' ORDER BY productId DESC LIMIT 1";
    $result = $this->db->select($query);
    return $result;    
  }
  public function latestFromCanon(){
    $query = "SELECT * FROM tbl_product WHERE brandId = '5' ORDER BY productId DESC LIMIT 1";
    $result = $this->db->select($query);
    return $result;    
  }
  public function productByCat($id){
    $id        = $this->fm->validation($id);
    $id        = mysqli_real_escape_string($this->db->link, $id);
    $query     = "SELECT * FROM tbl_product WHERE catId = '$id'";
    $result    = $this->db->select($query);
    return $result;
  }
  public function insertCompareData($cmrId, $productId){

     $cmrId         = mysqli_real_escape_string($this->db->link, $cmrId);
     $productId     = mysqli_real_escape_string($this->db->link, $productId);

     $cquery         = "SELECT * FROM tbl_compare WHERE cmrId ='$cmrId' AND productId ='$productId'";
     $check          = $this->db->select($cquery);
     if ($check) {
       $msg ="<span class='error'>Already Added to Compare.</span>";
        return $msg;
     } else{

     $query         = "SELECT * FROM tbl_product WHERE productId ='$productId'";
     $result        = $this->db->select($query)->fetch_assoc();
     if ($result) {
      $productId   = $result['productId'];
      $productName = $result['productName'];
      $price       = $result['price'];        
      $image       = $result['image'];
      $query = "INSERT INTO tbl_compare(`cmrId`, `productId`, `productName`, `price`, `image`) Values('$cmrId', '$productId', '$productName', '$price', '$image')";
      
      $Insert_row = $this->db->insert($query);
      if ($Insert_row) {
        $msg ="<span class='success'>Added to Compare.</span>";
        return $msg;
      } else {
        $msg ="<span class='error'>Not Added to Compare.</span>";
        return $msg;
      }
    }
   }
  }
  public function getCompareData($cmrId){
    $query           = "SELECT * FROM tbl_compare WHERE cmrId ='$cmrId' ORDER BY id DESC";
    $result          = $this->db->select($query);
    return $result;

  }
  public function delCompareCart($cmrId){
    $query = "DELETE FROM tbl_compare WHERE cmrId = '$cmrId'";
    $result = $this->db->delete($query);

  }
  public function saveWishListData($id, $cmrId){
     $cmrId         = mysqli_real_escape_string($this->db->link, $cmrId);
     $productId     = mysqli_real_escape_string($this->db->link, $id);

     $cquery         = "SELECT * FROM tbl_wlist WHERE cmrId ='$cmrId' AND productId ='$productId'";
     $check          = $this->db->select($cquery);
     if ($check) {
       $msg ="<span class='error'>Already Added to Wishlist.</span>";
        return $msg;
     } else{

     $query         = "SELECT * FROM tbl_product WHERE productId ='$productId'";
     $result        = $this->db->select($query)->fetch_assoc();
     if ($result) {
      $productId   = $result['productId'];
      $productName = $result['productName'];
      $price       = $result['price'];        
      $image       = $result['image'];
      $query = "INSERT INTO tbl_wlist(`cmrId`, `productId`, `productName`, `price`, `image`) Values('$cmrId', '$productId', '$productName', '$price', '$image')";
      
      $Insert_row = $this->db->insert($query);
      if ($Insert_row) {
        $msg ="<span class='success'>Added to Wishlist.</span>";
        return $msg;
      } else {
        $msg ="<span class='error'>Not Added to Wishlist.</span>";
        return $msg;
      }
    }
   }
  }
  public function checkWishListData($cmrId){
    $query           = "SELECT * FROM tbl_wlist WHERE cmrId ='$cmrId' ORDER BY id DESC";
    $result          = $this->db->select($query);
    return $result;

  }
  public function delWlistData($productId, $cmrId){
    $query = "DELETE FROM tbl_wlist WHERE cmrId = '$cmrId' AND productId = '$productId'";
    $result = $this->db->delete($query);
  }
  public function getAllProductByBrand($brandId){
    $query = "SELECT * FROM tbl_product WHERE brandId = '$brandId' ORDER BY brandId DESC LIMIT 4";
    $result = $this->db->select($query);
    return $result;
  }
}
?>