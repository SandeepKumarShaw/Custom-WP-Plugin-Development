
jQuery.noConflict();
// Code that uses other library's $ can follow here.


jQuery( document ).ready( function () {
      jQuery( "#AccountForm" ).validate( {
        rules: {
          
          bname: {
            required: true,
            minlength: 2
          },
          baddress: {
            required: true,
            minlength: 5
          },
          // bsite: {
          //   required: false,
          //   url: false
            
          // },
          
        },
        messages: {
          
          bname: {
            required: "Please enter a businessname",
            minlength: "Your businessname must consist of at least 2 characters"
          },
          baddress: {
            required: "Please provide a businessaddress",
            minlength: "Your businessaddress must be at least 5 characters long"
          },
          // bsite: {
          //   required: "Please provide a businesswebsite",
          //   url: "Please provide your valid businesswebsite url"
           
          // },
          
        },
        errorElement: "em",
        errorPlacement: function ( error, element ) {
          // Add the `help-block` class to the error element
          error.addClass( "help-block" );

          if ( element.prop( "type" ) === "text" ) {
            error.insertAfter( element );
          } 
        },
        highlight: function ( element, errorClass, validClass ) {
          jQuery( element ).parents( ".col-md-9" ).addClass( "has-error" ).removeClass( "has-success" );
        },
        unhighlight: function (element, errorClass, validClass) {
          jQuery( element ).parents( ".col-md-9" ).addClass( "has-success" ).removeClass( "has-error" );
        }
      } );
 } );


jQuery( document ).ready( function () {

      jQuery( "#createcouponForm" ).validate( {
        rules: {
          
          couponname: {
            required: true,
            minlength: 2
          },
          
          /*coupondiscount: {
            required: true,
            number: true,
            maxlength: 2
          },*/
          sdate: {
            required: true
          },
          edate: {
            required: true
            
          },
          
          /*desclaimer: {
            required: true,
            minlength: 50
          },*/
          uphoto: {
            required: true
           
          },
         
          
        },
        messages: {
          
          couponname: {
            required: "Please enter a coupon name",
            minlength: "Your coupon-name must consist of at least 2 characters"
          },
          
          /*coupondiscount: {
            required: "Please enter a coupon discount",
            number: "Please enter a valid number",
            maxlength: "Your coupon discount must consist of at less than 3 characters"
          },*/
          sdate: {
            required: "Please Choose Coupon Start Date"
          },
          edate: {
            required: "Please Choose Coupon End Date"
          },
          // couponphone: {
          //   required: "Please enter a coupon phone No.",
          //   number: "Please enter a valid  Phone N0.",
          //   minlength: "Please enter a valid  Phone N0."
            
         // },
          /*desclaimer: {
            required: "Please enter a desclaimer",
            minlength: "Your coupon-name must consist of at least 50 characters"
          },*/
          uphoto: {
            required: "Please Choose a Logo for Coupon"
          },
          
          
        },
        errorElement: "em",
        errorPlacement: function ( error, element ) {
          // Add the `help-block` class to the error element
          error.addClass( "help-block" );

          if ( element.prop( "type" ) === "text" ) {
            error.insertAfter( element );
          }
          else{
          	error.insertAfter( element.parent( "label" ) );
          } 
        },
        highlight: function ( element, errorClass, validClass ) {
          jQuery( element ).parents( ".col-sm-4" ).addClass( "has-error" ).removeClass( "has-success" );
        },
        unhighlight: function (element, errorClass, validClass) {
          jQuery( element ).parents( ".col-sm-4" ).addClass( "has-success" ).removeClass( "has-error" );
        }
      } );


      
    } );
