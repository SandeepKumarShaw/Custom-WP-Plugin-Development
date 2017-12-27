jQuery(document).ready(function($) {
    // Start for advance search //
    /*
    $(".advance_search").hide();
    $(".advance_search_btn").click(function(){
        $(".advance_search").toggle();
        $('.advance_search_btn').html($('.advance_search_btn').text() == 'Hide Advance Filter' ? 'Show Advance Filter' : 'Hide Advance Filter');
    });
    */
    // End for advance search //
    
    $(".view_user_details").click(function(){
        var parent_box = $(this).closest('.get_user_details');
        parent_box.siblings().find('.user_details').hide();
        parent_box.find('.user_details').toggle();
    });

    
    jQuery( "tr.user-profile-picture" ).remove();
    //jQuery( "tr.user-profile-picture" ).parents("table:first").remove();
    
    
    /*******Mail To Admin When "Hire Now" is clicked*********/
    jQuery(".contact_url a").on("click",function(){        
        var hire_member_id_string = jQuery(this).attr("id");
        var hire_ajax_url = jQuery(".hire_a_url").val();
        var hire_array = hire_member_id_string.split("_");
        var hire_member_id = hire_array[1];
        var hire_member_name = jQuery("#uname_"+hire_member_id).text();
    
        //return false;
        jQuery.ajax({
           type: "POST",
           url: hire_ajax_url,
           data: { hire_member_id:hire_member_id , action:'hire_seeker_mail_ajax' },
           success: function(data){
              //alert(data);
                if(data == 1)
                {
                    alert("Thank You for your interest in "+hire_member_name+". We will contact "+hire_member_name+" and pass along your details shortly.");
                }
                if(data == 2)
                {
                   alert("You have already applied for this candidate!");
                }
           }
        });
         
    });
    
    
    //Start to open close div of user login details at navigation menu
    /*
    $(".signin_details").click(function(){
        $(".user_other_infos").toggle();
    });
    */
    $(".signin_details").hover(function () {
        if ( $(".user_other_infos").is(":visible")===true) {
	        $(".user_other_infos").hide();
        } else {
	        $(".user_other_infos").show();
        }        
    });    
    //End to open close div of user login details at navigation menu
    
    
    jQuery("#search_seeker_button").on("click",function(){
	var u_search_zip = jQuery("#u_search_zip").val();
	if(u_search_zip){
	    var u_s_zip = '&u_search_zip='+u_search_zip;
	 }else{
	    var u_s_zip = '';
	 }
	 
	 
	var u_search_city = jQuery("#u_search_city").val();
	if (u_search_city) {
	    var u_s_city = '&u_search_city='+u_search_city;
	}else{
	    var u_s_city = '';
	}
	
	
	var u_search_state = jQuery("#u_search_state").val();
	if (u_search_state) {
	    var u_s_state = '&u_search_state='+u_search_state;
	}else{
	    var u_s_state = '';
	}
	
	
	
	var u_search_experience = jQuery("#u_search_experience").val();
	if (u_search_experience) {
	    var u_s_exp = '&u_search_experi='+u_search_experience;
	}else{
	    var u_s_exp = '';
	}
	
	
	
	var u_search_star = jQuery(".candi_star").val();
	if (u_search_star) {
	    var u_s_rating = '&u_search_rating='+u_search_star;
	}else{
	    var u_s_rating = '';
	}
	
	
	
	var u_search_years = jQuery(".custom_reg_log_user_exp_years").val();
	if (u_search_years) {
	    var u_s_years = '&u_search_years='+u_search_years;
	}else{
	    var u_s_years = '';
	}
	
	
	
	var u_search_months = jQuery(".custom_reg_log_user_exp_months").val();
	if (u_search_months) {
	    var u_s_months = '&u_search_months='+u_search_months;
	}else{
	    var u_s_months = '';
	}
	
	
	
	var u_search_practice_type = jQuery("input[name='u_search_practice_type']:checked").val()
	if (u_search_practice_type) {
	    var u_s_practice_type = '&u_search_practice_type='+u_search_practice_type;
	}else{
	    var u_s_practice_type = '';
	}
	
	
	
	var allAvailable = [];
	jQuery('#u_s_available :checked').each(function() {
	    allAvailable.push(jQuery(this).val());
	});
	if (allAvailable) {
	    var u_s_available = '&u_search_available[]='+allAvailable;
	}
	else{
	    var u_s_available = '';
	}
	
	
	var url = 'https://redrockdentalstaffing.com/wp-admin/users.php?page=user-access-list&user_role=job_seeker';
	
	//url += '&u_search_zip='+u_search_zip+'&u_search_city='+u_search_city+'&u_search_state='+u_search_state+'&u_search_practice_type='+u_search_practice_type+'&u_search_available[]='+allAvailable;
	
	url += u_s_zip+u_s_city+u_s_state+u_s_exp+u_s_rating+u_s_years+u_s_months+u_s_practice_type+u_s_available;
	//alert(url);
	document.location.href=url;
    });
 /*
    jQuery('input[type=radio][name=custom_reg_log_xray_used]').change(function() {
	//alert(this.value);
	if (this.value == 'yes') {
	    jQuery("#custom_reg_log_xray_type").show();	
	}
	else if (this.value == 'no') {
	    jQuery("#custom_reg_log_xray_type").hide();
	}
    });
    
     jQuery('input[type=radio][name=x_ray_used]').change(function() {
	//alert(this.value);	
	if (this.value == 'yes') {
	    jQuery("#x_ray_type").show();	
	}
	else if (this.value == 'no') {
	    jQuery("#x_ray_type").hide();
	}
	
    });
     */
});








 ///////////////////////document height
equalheight = function(container){
var currentTallest = 0,
     currentRowStart = 0,
     rowDivs = new Array(),
     jQueryel,
     topPosition = 0;
jQuery(container).each(function() {
   jQueryel =jQuery(this);
   jQuery(jQueryel).height('auto')
   topPostion = jQueryel.position().top;
   if (currentRowStart != topPostion) {
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
     rowDivs.length = 0; // empty the array
     currentRowStart = topPostion;
     currentTallest = jQueryel.height();
     rowDivs.push(jQueryel);
   } else {
     rowDivs.push(jQueryel);
     currentTallest = (currentTallest < jQueryel.height()) ? (jQueryel.height()) : (currentTallest);
  }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
     rowDivs[currentDiv].height(currentTallest);
   }
 });
}

jQuery(window).load(function() {
  equalheight('.all-items .get_user_details ul li.p_img');
});
jQuery(window).scroll(function() {
  equalheight('.all-items .get_user_details ul li.p_img');
});
jQuery(window).resize(function(){
  equalheight('.all-items .get_user_details ul li.p_img');
});
jQuery(document).ajaxSuccess(function(){
  equalheight('.all-items .get_user_details ul li.p_img');
});