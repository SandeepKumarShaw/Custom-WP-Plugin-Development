
<?php 

/*
Template Name: Customer Special
*/
 get_header();
?>

<?php 
    global $wpdb;
      

$sql="SELECT * FROM wp_customer_details";
//echo $sql;
$row=$wpdb->get_results($sql);
//print_r($row);
foreach ($row as $key) {
   
     ?>
    
      <tr>
       <td><a><?php echo $key->customer_name;?></a></td>
       
        <td><?php echo $key->customer_email;?></td>
         
      </tr>
      
      <?php
       } 
     ?>
<?php get_footer();?>