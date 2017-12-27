jQuery(document).ready(function($) {
   //################ Start for datepicker ################//
   //$('.date_picker').datepicker({
       //dateFormat : 'mm/dd/yy'
   //});
   
   //there are mainly 2 types of validation conditions which are,
   //Start date should not greater than end date.
   //End date should not less then start date.
   
   jQuery(".startdate.date_picker").datepicker({
      numberOfMonths: 1,
      //dateFormat : 'yy-mm-dd',
      dateFormat : 'mm-dd-yy',
      onSelect: function(selected) {
         jQuery(".enddate.date_picker").datepicker("option","minDate", selected);
      }
   });
   
   jQuery(".enddate.date_picker").datepicker({ 
      numberOfMonths: 1,
      dateFormat : 'mm-dd-yy',
      //defaultDate: null,
      onSelect: function(selected) {
         jQuery(".startdate.date_picker").datepicker("option","maxDate", selected);
      }
   });
   //################ End for datepicker ################//
   
   
   
   
   //########## J O B   A P P L Y    S T A R T  ########/

      jQuery(".job_apply").on("click",function(){
         //jQuery(".click_butn").hide();
         jQuery(".click_butn").css("display","none");
         jQuery(".click_butn").text("");
         var job_id = jQuery(this).attr("id");   
         var a_url = jQuery("#ajax_url").val();
         jQuery.ajax({
            type: "POST",
            url: a_url,
            data: { job_id:job_id , action:'apply_jobs_ajax' },
            success: function(data){
           // alert(data);
            if(data == 1)
            {               
             
               //jQuery(".aply_"+job_id).show();
               jQuery(".aply_"+job_id).css("display","block");
               jQuery(".aply_"+job_id).text("You have successfully applied!");
            }
            if(data == 2)
            {               
               //alert("You have already applied for this job!");
               //jQuery(".click_butn").show("slow");
                //jQuery(".aply_"+job_id).show();
                 jQuery(".aply_"+job_id).css("display","block");
               jQuery(".aply_"+job_id).text("You have already applied for this job!");
            }
            }
         });
         
         
         
      });

   //########## J O B   A P P L Y    E N D  ########/
   
   
   
   //########### D E L E T E   J O B   F R O M    L I S T    S T A R T #############//
   jQuery(".aply_edit .delete_job").click(function(){
      if(confirm("Are you sure to remove this job from Joblist?")){
         var job_id = jQuery(this).attr('id');
         var ajx_url = jQuery("#ajax_url").val();         
         jQuery.ajax({
            type: "POST",
            url: ajx_url,
            data: { id:job_id , action:'delete_job_ajax' },
            success: function(data){
               //alert(data);
               if(data == 1)
               {
                  window.location.reload();
               }
            }
         });
      }
      return false;
   });
   //########### D E L E T E   J O B   F R O M    L I S T    E N D #############//
   
   //########### Start For Job Apply #############//
   /* $('.apply_job_item').click(function() {
      var clickonItemid = this.id;
      var itemId = parseInt(clickonItemid.split('_').pop(), 10);
      alert(itemId);
      $(".apply_job_item .item-dtls").hide('slow');
      $("#apply_job_item_"+itemId+" .item-dtls").show();
      $(".apply_job_item").removeClass("active");
      $("#apply_job_item_"+itemId).addClass("active");
    });
    */
   /*
    $('.apply_job_item').click(function() {
      var clickonItemid = this.id;
      var itemId_array = clickonItemid.split('_');
      itemId = itemId_array[3];
      var is_active = $("#apply_job_item_"+itemId).hasClass("active");
      if (is_active == true) {       
         $("#apply_job_item_"+itemId+" .item-dtls").hide('slow');
          $("#apply_job_item_"+itemId).removeClass("active");
      }
      else{         
         $(".apply_job_item .item-dtls").hide('slow');
         $(".apply_job_item").removeClass("active");
         $("#apply_job_item_"+itemId+" .item-dtls").show();
         $("#apply_job_item_"+itemId).addClass("active");
      }
    });
   */
   //########### Start For Job Apply #############//
   
   
   
   
   /*
   <span class="asgn_div">
          <a href="javascript:void(0)" class="cancel_asign" id="cancel_58"> x</a>
          <a href="users.php?s=58" class="asgn_usr_name">ashconsen</a>
        </span>
   */
   
   
   
   /************Dropdown Assign To START**********/
   jQuery('.job_assignd_to').change(function() {
         var ajax_asign_to = jQuery(".ajax_asign_to").val();
         //Use $option (with the "$") to see that the variable is a jQuery object
         var $option = $(this).find('option:selected');
         //Added with the EDIT
         var asgn_id = $option.val();//to get content of "value" attrib
         var asgn_text = $option.text();//to get <option>Text</option> content
         //alert(asgn_id);
         //alert(asgn_text);
         if (asgn_id) {
            var asgn_to_hidn = jQuery(".asgn_to_hidn").val();
            if (asgn_to_hidn) {
               //code
               var asgn_to_hidn = asgn_to_hidn+','+asgn_id;
            }else{
               var asgn_to_hidn = asgn_id;
            }
            //jQuery(".asign_to_wrap").append("<span class='asgn_div'><a href='javascript:void(0)' class='cancel_asign' id='cancel_"+asgn_id+"'>close</a> "+asgn_text+"</span>");
            
            
            
            jQuery(".asign_to_wrap").append("<span class='asgn_div'><a href='javascript:void(0)' class='cancel_asign_demo' id='canceldemo_"+asgn_id+"'> x</a><a href='users.php?s="+asgn_id+"' class='asgn_usr_name'>"+asgn_text+"</a></span>");
            
            
            // jQuery(".asign_to_wrap").append("<span class='asgn_div'>"+asgn_text+"</span>");
            jQuery(".asgn_to_hidn").val(asgn_to_hidn);
            jQuery("#job_assignd_to").prop("disabled", true);
            //jQuery(".mdp-demo").css("display","block");
            $option.remove();
         }
         
         /*
                 
         jQuery.ajax({
            type: "POST",
            url: ajax_asign_to,
            data: { id:j_id , action:'job_asign_to_ajax' },
            success: function(data){
               //alert(data);
               if(data == 1)
               {
                  window.location.reload();
               }
            }
         });
         */
         
         
         
         
   });
   /***********Dropdown Assign To END**********/
   
   
   
   
   /**********Dropdown Assign Delete Demo Start*****/
   
   
   
   
   /**********Dropdown Assign Delete Demo End*****/
   
   jQuery(".cancel_asign_demo").live("click",function(){
      if(confirm("Are you sure to remove ?")){
         asgn_usr_name = jQuery(".asgn_usr_name").text();
         cancel_asign_demo_id = jQuery(".cancel_asign_demo").attr("id");
         
         var cancel_user_demo_array = cancel_asign_demo_id.split("_");
         var cancel_user_demo_id = cancel_user_demo_array[1];
         
         
         jQuery('#job_assignd_to').append('<option class="none" value="'+cancel_user_demo_id+'">'+asgn_usr_name+'</option>');
         
         jQuery(".asign_to_wrap").empty();
         jQuery(".asgn_to_hidn").val("");
          jQuery("#job_assignd_to").prop("disabled", false);
      }
      return false;
   });
   
   
   
   /**********Dropdown Assign Delete Start*****/
   
   jQuery(".cancel_asign").on("click",function(){
      if(confirm("Are you sure to remove ?")){
         var cancel_user = jQuery(this).attr("id");
         var cancel_user_array = cancel_user.split("_");
         var cancel_user_id = cancel_user_array[1];
         var curnt_post_id = jQuery(".curnt_post_id").val();
         //alert(curnt_post_id);
         var ajax_asign_delt = jQuery(".ajax_asign_to").val();
         
         
         jQuery.ajax({
            type: "POST",
            url: ajax_asign_delt,
            data: { curnt_post_id:curnt_post_id , cancel_usr_id:cancel_user_id , action:'delete_asgn_to_ajax' },
            success: function(data){
              // alert(data);
               
               if(data == 1)
               {
                  jQuery(".date_list").val("");
                  window.location.reload();
                  //jQuery(this).closest('span.asgn_div').remove();
               }               
            }
         }); 
      }
      return false;
   });
   
   /**********Dropdown Assign Delete End*****/
   

   /*********Assign Job to a user on date(s) start********/
   if (jQuery('.date_list').val()) {
     var dates = jQuery('.date_list').val().split(',');
   }
   
   
   //alert(dates);
   if (dates) {
      var dates_list = dates;
   }
   else{
      var dates_list = '';
   }
   
   if (dates_list != '') {
      //alert(dates_list);    
      
      jQuery('.mdp-demo').multiDatesPicker({
         dateFormat : 'mm-dd-yy',
         //addDates: ['12/14/2017, '02/19/'+y, '01/14/'+y, '11/16/'+y],
         //addDates: ['12-01-17', '12-02-17', '12-14-17', '12-16-17'],
         
         addDates: dates_list,
         //altField: '.date_list'
         
         //beforeShowDay: jQuery.datepicker.noWeekends
         
         onSelect: function(selected) {
            var selected_dates_list = jQuery('.mdp-demo').multiDatesPicker('getDates');
            //alert(selected_dates_list);
            jQuery(".date_list").val(selected_dates_list);
         
         }
      });
   
   }
   else{
      //alert("HI");
      jQuery('.mdp-demo').multiDatesPicker({
         dateFormat : 'mm-dd-yy',
         
         //beforeShowDay: jQuery.datepicker.noWeekends
         
         onSelect: function(selected) {
            var selected_dates_list = jQuery('.mdp-demo').multiDatesPicker('getDates');
            //alert(selected_dates_list);
            jQuery(".date_list").val(selected_dates_list);
         
         }
      });
   }
   
   /*********Assign Job to a user on date(s) end********/
   
   
     
     
     
     /************Job Billing By Date Start********/
     jQuery("#search_start_end_button").on("click",function(){
      
            var jobs_billing_startdate = jQuery("#jobs_billing_startdate").val();
            //alert(jobs_billing_startdate);
            if(jobs_billing_startdate){
               var j_b_start = '&billing_startdate='+jobs_billing_startdate;
            }else{
               var j_b_start = '';
            }
            
            
            var jobs_billing_enddate = jQuery("#jobs_billing_enddate").val();
            //alert(jobs_billing_enddate);
            if(jobs_billing_enddate){
               var j_b_end = '&billing_enddate='+jobs_billing_enddate;
            }else{
               var j_b_end = '';
            }
            var url = 'https://redrockdentalstaffing.com/wp-admin/edit.php?post_type=cptjobsmanager&page=jobs-billing-report';
            
            //url += '&u_search_zip='+u_search_zip+'&u_search_city='+u_search_city+'&u_search_state='+u_search_state+'&u_search_practice_type='+u_search_practice_type+'&u_search_available[]='+allAvailable;
            
            url += j_b_start+j_b_end;
            //alert(url);
            document.location.href=url;
      });
     
     /************Job Billing By Date END********/
     
     
     
     /**********Remove 'Show More Details' from CSV and XLS Start************/  
   jQuery('.cptjobsmanager_page_jobs-billing-report tr').each(function() {
      jQuery(this).find("td.column-primary .toggle-row").remove();
      

   });
   /**********Remove 'Show More Details' from CSV and XLS End************/
   
   
   
   /**********Xport XLS and CSV START**************/
    jQuery( ".cptjobsmanager_page_jobs-billing-report" ).table_download({
        format: "xls",
        separator: ",",
        filename: "download",
        linkname: "Click here for XLS",
        quotes: "\""
    });
    
     jQuery( ".cptjobsmanager_page_jobs-billing-report" ).table_download({
        format: "csv",
        separator: ",",
        filename: "download",
        linkname: "Export CSV",
        quotes: "\""
    });
     /**********Xport XLS and CSV END**************/
     
     
     
      jQuery( "#cptjobsmanager_category-all #cptjobsmanager_categorychecklist li" ).each(function() {
         if(jQuery(this).attr("id") == 'cptjobsmanager_category-0'){            
            jQuery(this).remove();
         }
      });
      
     
      jQuery("input[type=radio]").on('change', function(){
         if(jQuery(this).val() == 9){
            jQuery(".mdp-demo").css("display","none");
         }
         if(jQuery(this).val() == 10){
            jQuery(".mdp-demo").css("display","block");
         }
      });
   
});