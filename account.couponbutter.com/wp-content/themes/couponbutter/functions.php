<?php  

ob_start();
if ( !session_id() )

add_action( 'init', 'session_start' );








ob_clean();





?>