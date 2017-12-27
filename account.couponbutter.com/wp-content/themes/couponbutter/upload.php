
<?php  
/* 
Template Name:upload
*/
get_header();
?>
<?php
global $wpdb;
if ( isset( $_POST['submit'] )){
$table_name = $wpdb->prefix . "user_account";
$icon_img=$_FILES["uphoto"]["name"];
$path_array = wp_upload_dir();
$path = str_replace('\\', '/', $path_array['path']);
move_uploaded_file($_FILES["uphoto"]["tmp_name"],$path. "/" . $icon_img);

$upload_path=$path_array['url']."/";

$icon_img_path=$upload_path.$icon_img;
//print_r($_POST);


$sql="UPDATE $table_name SET  business_logo='".$icon_img_path."'";
$rez = $wpdb->query($sql);

?>
<?php get_footer();?>