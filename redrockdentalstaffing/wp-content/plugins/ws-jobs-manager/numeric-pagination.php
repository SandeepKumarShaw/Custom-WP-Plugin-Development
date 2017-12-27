<?php
// ========== Start to custom numeric pagination ========== //
// numbered pagination
function pagination($pages = '', $range = 4) {  
	$showitems = ($range * 2)+1;  

	global $paged;
	if(empty($paged)) $paged = 1;

	if($pages == '')
	{
	 global $wp_query;
	 $pages = $wp_query->max_num_pages;
	 if(!$pages)
	 {
	     $pages = 1;
	 }
	}   

	if(1 != $pages)
	{
	 echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
	 if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
	 if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";

	 for ($i=1; $i <= $pages; $i++)
	 {
	     if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
	     {
	         echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
	     }
	 }

	 if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";  
	 if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
	 echo "</div>\n";
	}
?>
 <style>
 /* Pagination */
	.pagination {
	    clear:both;
	    position:relative;
	    font-size:11px; /* Pagination text size */
	    line-height:13px;
	    float:right; /* Pagination float direction */
	}
	 
	.pagination span, .pagination a {
	    display:block;
	    float:left;
	    margin: 2px 2px 2px 0;
	    padding:6px 9px 5px 9px;
	    text-decoration:none;
	    width:auto;
	    color:#fff; /* Pagination text color */
	    background: #555; /* Pagination non-active background color */
	    -webkit-transition: background .15s ease-in-out;
	    -moz-transition: background .15s ease-in-out;
	    -ms-transition: background .15s ease-in-out;
	    -o-transition: background .15s ease-in-out;
	    transition: background .15s ease-in-out;
	}
	 
	.pagination a:hover{
	    color:#fff;
	    background: #6AAC70; /* Pagination background on hover */
	}
	 
	.pagination .current{
	    padding:6px 9px 5px 9px;
	    background: #6AAC70; /* Current page background */
	    color:#fff;
	}
	</style>
<?php
}
// ========== Start to custom numeric pagination ========== //
?>