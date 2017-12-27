<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
/**
* Copyright Class
*/
class Social{
	private $db;
	private $fm;
	public function __construct(){
		$this->db = new Database();
		$this->fm = new Format();
	}
	public function updateSocialData($data){
		$facebook   = $this->fm->validation($data['facebook']);
		$twitter    = $this->fm->validation($data['twitter']);
		$linkedin   = $this->fm->validation($data['linkedin']);
		$googleplus = $this->fm->validation($data['googleplus']);
        $facebook   = mysqli_real_escape_string($this->db->link, $facebook);
        $twitter    = mysqli_real_escape_string($this->db->link, $twitter);
        $linkedin   = mysqli_real_escape_string($this->db->link, $linkedin);
        $googleplus = mysqli_real_escape_string($this->db->link, $googleplus);
        if (empty($facebook) || empty($twitter) || empty($linkedin) || empty($googleplus)) {
        	$msg = "<span class ='error'>Field Must Not Be Empty!!!</span>";			
			return $msg;
            
        }else{
            $query = "UPDATE tbl_social SET fb = '$facebook', tw = '$twitter', ln = '$linkedin', gp = '$googleplus' WHERE id = '1'";
            $catUpdate= $this->db->update($query);
            if ($catUpdate) {
            	$msg = "<span class ='success'>Social Updated Successfully!!!</span>";			
			    return $msg;
            } else {
            	$msg = "<span class ='error'>Social Updated Not Successfully!!!</span>";			
			    return $msg;                
            }
                        
             
        }

	}
	public function getSocialData(){
		$query = "SELECT * FROM tbl_social WHERE id = '1'";
		$result = $this->db->select($query);
		return $result;
	}

}
?>