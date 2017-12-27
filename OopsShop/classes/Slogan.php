<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
/**
* Copyright Class
*/
class Slogan{
	private $db;
	private $fm;
	public function __construct(){
		$this->db = new Database();
		$this->fm = new Format();
	}
	public function updateSlogan($data, $file){
		$title   = $data['title'];
		$title   = $this->fm->validation($title);
		$title   = mysqli_real_escape_string($this->db->link, $title);
		$slogan     = $data['slogan'];
		$slogan   = $this->fm->validation($slogan);
		$slogan     = mysqli_real_escape_string($this->db->link, $slogan);

		$permited  = array('png');
		$file_name = $_FILES['logo']['name'];
		$file_size = $_FILES['logo']['size'];
		$file_temp = $_FILES['logo']['tmp_name'];

		$div = explode('.', $file_name);
		$file_ext = strtolower(end($div));
		$same_image = 'logo'.'.'.$file_ext;
		$uploaded_image = "upload/".$same_image;

		if ( $title == "" || $slogan == "" ){
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
				    } else{
				        move_uploaded_file($file_temp, $uploaded_image);
				        $query = "UPDATE title_slogon SET  title = '$title', slogon = '$slogan', logo = '$uploaded_image' WHERE id = '1'";
				        $updated_rows = $this->db->update($query);
				    if ($updated_rows) {
				       $msg ="<span class='success'>Data Updated Successfully.</span>";
                       return $msg;
				    }else {
				       $msg ="<span class='error'>Data Not Updated !</span>";
                       return $msg;
				    }
				    }
				}
				else {

				    $query = "UPDATE title_slogon SET  title = '$title', slogon = '$slogan' WHERE id = '1'";
				    $updated_rows = $this->db->update($query);
				if ($updated_rows) {
				    $msg ="<span class='success'>Data Updated Successfully.</span>";
                       return $msg;
				}else {
				    $msg ="<span class='error'>Data Not Updated !</span>";
                       return $msg;
				}

				}
        }     
    }      


	public function getSlogan(){
		$query = "SELECT * FROM title_slogon WHERE id = '1'";
		$result = $this->db->select($query);
		return $result;
	}

}
?>