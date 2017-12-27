<?php 

/*
Template Name: Logout
*/

?>
<?php get_header();?>
<?php 
 
 
 unset($_SESSION['user_id']);
 
 session_destroy();
 //header("Location: http://account.couponbutter.com/");
        //exit();
 wp_redirect('http://account.couponbutter.com/');
     exit();

 
 

?>

<?php get_footer();?>
