<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
/**
* Copyright Class
*/
class Copyright{
	private $db;
	private $fm;
	public function __construct(){
		$this->db = new Database();
		$this->fm = new Format();
	}
	public function updateCopyright($copyright){
		$name = $this->fm->validation($copyright);
        $name = mysqli_real_escape_string($this->db->link, $name);
        if (empty($name)) {
        	$msg = "<span class ='error'>Field Must Not Be Empty!!!</span>";			
			return $msg;
            
        }else{
            $query = "UPDATE tbl_footer SET note = '$name' WHERE id = '1'";
            $catUpdate= $this->db->update($query);
            if ($catUpdate) {
            	$msg = "<span class ='success'>Copyright Updated Successfully!!!</span>";			
			    return $msg;
            } else {
            	$msg = "<span class ='error'>Copyright Updated Not Successfully!!!</span>";			
			    return $msg;                
            }
                        
             
        }

	}
	public function getCopyright(){
		$query = "SELECT * FROM tbl_footer WHERE id = '1'";
		$result = $this->db->select($query);
		return $result;
	}

}
?>