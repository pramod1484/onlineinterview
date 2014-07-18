// FORMS JS 
function messagePosition() {
            var leftPosition = $(window).width()/2 - $('.wait-message').outerWidth(true)/2;
            var topPosition = $(window).height()/2 -  $('.wait-message').outerHeight(true)/2;        
            //alert('window width: '+ $(window).width()+"window height:"+ $(window).height()+"message width: "+$('.wait-message').outerWidth(true)+"message height: "+ $('.wait-message').outerHeight(true));
            $('.wait-message').css({'top': topPosition+'px',left: leftPosition+'px'});    
}
        
function showMessage(overlayMessage) {
            $('.wait-message').html(overlayMessage);
            messagePosition();    
}        
        
$(document).ready( function() {
    $(window).resize(function() {
        messagePosition();
    });
});
        
//Refresh captcha 
function refreshCaptcha(img,captchaName) {            
    var imgSource = $(img).attr('src');
    img.attr('src',imgSource.substring(0,imgSource.lastIndexOf("?"))+"?rand="+Math.random()*1000+"&captchaname="+captchaName);
}

//Captcha bind the function for refresh captcha
$(document).on('click','.refresh-captcha-link',function(e){ 
    e.preventDefault();
    var img = $(this).parents('.captcha-wrapper').find('.captcha-image');
    var captchaName = $(this).parents('.captcha-wrapper').find('.captcha-name').val();
    refreshCaptcha(img,captchaName);                
});

//Clear error message on focus field
$(document).on("focus",".form-error", function(event){ 
    $(this).removeClass('form-error');    
    $(this).val('');
});       

/*function goToPage(idname)
{
     window.location.href = 'portfolio.html#' + idname;
}*/

/***************** language change function *********************/







$(document).ready(function(){
  $(".langSelector").click(function(){
    $(".selectLang").toggle();
  });
});

/***************** request quote *********************/
function requestQuote(obj)
{
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var emailReg = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
    var phoneReg = /^[0-9-+]+$/;
    var charcheck = /^[a-z A-Z0-9]+$/;
    var noValidationErrors = true;
    
    //Base URL and Application root
    if(typeof applicationRoot==='undefined') {                
        applicationRoot = '';                
    }
    
    var baseUrl;
    if(applicationRoot!='') {
        baseUrl = location.protocol + "//" + location.hostname +applicationRoot;
    } else {
        baseUrl = '';    
    }
    
    /** Reset the values of all the fields with previous errors as we are showing 
    the error messages in the input fields itself **/
    $('.form-error').each(function(){            
        $(this).val('');   
    });
    
    //Form validations
    if ($.trim($('#name').val()).length == 0) {
        $('#name').addClass('form-error');
        $('#name').val('Please enter the Name');
        noValidationErrors = false;      
    } else if (!charcheck.test($('#name').val())) {         
        $('#name').addClass('form-error');
        $('#name').val('Please enter valid Name');  
        noValidationErrors = false;	 
    } 
    if ($.trim($('#company').val()).length == 0) {
        $('#company').addClass('form-error');
        $('#company').val('Please enter the Company Name');
        noValidationErrors = false;
    } else if (!charcheck.test($('#company').val())) {         
        $('#company').addClass('form-error');
        $('#company').val('Please enter valid Name');  
        noValidationErrors = false;	 
    } 
    if($.trim($('#email').val()).length == 0) {
        $('#email').addClass('form-error');
        $('#email').val('Please enter the Email');
        noValidationErrors = false;       
    } else if( !emailReg.test( $('#email').val() ) ) {              
        $('#email').addClass('form-error');
        $('#email').val('Please enter valid email id.');
        noValidationErrors = false;	     
    } if ($.trim($('#phone').val()).length == 0) {   
        $('#phone').addClass('form-error');
        $('#phone').val('Please enter phone number');
        noValidationErrors = false;	      
    }
    if (!phoneReg.test( $('#phone').val() ) ) {
        $('#phone').addClass('form-error');
        $('#phone').val('Please enter valid phone number');
        noValidationErrors = false;	      
    }    
      
    if ($('#quote-captcha').val().length == 0) {          
        //captcha validation and verification
        var form = $(obj).find('.captcha-name').val();
        var img = $(obj).find('.captcha-image');   
        $('#quote-captcha').addClass('form-error');
        $('#quote-captcha').val('Please enter code');
        noValidationErrors = false; 
        return false;     
    } else {
        if(noValidationErrors == true ) {
                  //form submission with popup messages 
                  $.ajax({
                      type: "POST",
                      url: baseUrl + 'send-mail.php',
                      data: $('#requestQuoteForm').serialize(),
                      beforeSend: function() {
                          parent.isSubmitting = true;
                          $('.requestSend').attr('disabled','disabled');
                      },
                      success: function(data) {
                          parent.isSubmitting = false;
                          if (data == 'failure') {
                            $('#quote-captcha').addClass('form-error');
                            $('#quote-captcha').val('Incorrect code');
                            $('.requestSend').removeAttr('disabled');
                            noValidationErrors = false; 
                            return false;
                          } else if (data == 'adminError') {
	                      $('.requestInner').html('<div style="float: none; width: 16px; margin: 200px auto;">Message not sent to Admin</div>'); 
		          } else if (data == 'userError') {
	                      $('.requestInner').html('<div style="float: none; width: 16px; margin: 200px auto;" class="wait-message-inner">Message not sent to User</div>');
		          } else {     
                              /*$('#ContactPopUp').html('');
                              $('#ContactPopUp').css('display','none');
                              $('#ContactPopUp').show();
                              $('#ContactPopUp').load(baseUrl + "request-quote-thank-you.php"); */ 
                              var site = $('#site').val();
                              if (site != '') {
                                  baseUrl = baseUrl + "/" + site;
                              }
                              
                              window.location.href = baseUrl + "/request-quote-thank-you.php";                                             
                          } 
                      }   
                  });   
              }  
    } 
}

/***************** request quote tablet*********************/
function requestQuoteTablet(obj)
{
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var emailReg = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
    var phoneReg = /^[0-9-+]+$/;
    var charcheck = /^[a-z A-Z0-9]+$/;
    var noValidationErrors = true;
    
    //Base URL and Application root
    if(typeof applicationRoot==='undefined') {                
        applicationRoot = '';                
    }      
    var baseUrl;
    if(applicationRoot!='') {
        baseUrl = location.protocol + "//" + location.hostname +applicationRoot;
    } else {
        baseUrl = '';    
    }
    
    /** Reset the values of all the fields with previous errors as we are showing 
    the error messages in the input fields itself **/
    $('.form-error').each(function() {            
        $(this).val('');   
    });
    
    //Form validations
    if ($.trim($('#nameRequestQuoteTablet').val()).length == 0) {
        $('#nameRequestQuoteTablet').addClass('form-error');
        $('#nameRequestQuoteTablet').val('Please enter the Name');
        noValidationErrors = false;      
    } else if (!charcheck.test($('#nameRequestQuoteTablet').val())) {         
        $('#nameRequestQuoteTablet').addClass('form-error');
        $('#nameRequestQuoteTablet').val('Please enter valid Name');  
        noValidationErrors = false;	 
    }
     
    if ($.trim($('#companyRequestQuoteTablet').val()).length == 0) {
        $('#companyRequestQuoteTablet').addClass('form-error');
        $('#companyRequestQuoteTablet').val('Please enter the Company Name');
        noValidationErrors = false;
    } else if (!charcheck.test($('#companyRequestQuoteTablet').val())) {         
        $('#companyRequestQuoteTablet').addClass('form-error');
        $('#companyRequestQuoteTablet').val('Please enter valid Name');  
        noValidationErrors = false;	 
    } 
     
    if($.trim($('#emailRequestQuoteTablet').val()).length == 0) {
        $('#emailRequestQuoteTablet').addClass('form-error');
        $('#emailRequestQuoteTablet').val('Please enter the Email');
        noValidationErrors = false;       
    } else if( !emailReg.test( $('#emailRequestQuoteTablet').val() ) ) {              
        $('#emailRequestQuoteTablet').addClass('form-error');
        $('#emailRequestQuoteTablet').val('Please enter valid email id.');
        noValidationErrors = false;	     
    } 
     
    if ($.trim($('#phoneRequestQuoteTablet').val()).length == 0) {   
        $('#phoneRequestQuoteTablet').addClass('form-error');
        $('#phoneRequestQuoteTablet').val('Please enter phone number');
        noValidationErrors = false;	      
    }            
    if (!phoneReg.test( $('#phoneRequestQuoteTablet').val() ) ) {
         $('#phoneRequestQuoteTablet').addClass('form-error');
         $('#phoneRequestQuoteTablet').val('Please enter valid phone number');
         noValidationErrors = false;	      
    }  
                            
    var img = $(obj).find('.captcha-image'); 
      
    if ($('#quoteTablet-captcha').val().length == 0) {          
        //captcha validation and verification
        var form = $(obj).find('.captcha-name').val();             
        $('#quoteTablet-captcha').addClass('form-error');
        $('#quoteTablet-captcha').val('Please enter code');
        noValidationErrors = false; 
        return false;
    } else {
            if(noValidationErrors == true ) {
                  //form submission with popup messages 
                  $.ajax({
                      type: "POST",
                      url: baseUrl + 'send-mail.php',
                      data: $('#requestQuoteFormTablet').serialize(),
                      beforeSend: function() {
                          $('.submit-overlay').show();
                          showMessage('<img src="' +applicationRoot +'images/ajax-loader.gif">');                         
		      },
                      success: function(data) {
                          if (data == 'failure') {
                            $('#quoteTablet-captcha').addClass('form-error');
                            $('#quoteTablet-captcha').val('Incorrect code');
                             setTimeout(function(){$('.submit-overlay').hide(); }, 'fast');
                            noValidationErrors = false; 
                            return false;
                          } else if (data == 'adminError') {                              	                       
                              showMessage('<div class="wait-message-inner">Message not sent to Admin</div>');
                              //refreshCaptcha(img,form);
		          } else if (data == 'userError') {
                              //refreshCaptcha(img,form);	                      
                              showMessage('<div class="wait-message-inner">Message not sent to User</div>');
		          } else {     
                              window.location.href = baseUrl + "request-quote-thank-you.php";                                                 
                          }   
                               
                          //close the pop up
                          setTimeout(function(){$('.submit-overlay').hide(); },3000);
	                  //$('#requestQuoteFormTablet')[0].reset();
                      }   
                   
                  });   
              }  
    } 
}

/****************** Feedback form  *************/		
function feedbackForm(obj)
{
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var charcheck =  /^[a-z A-Z0-9]+$/;
    var noValidationErrors = true;
    
    //Base URL and Application root
    if(typeof applicationRoot==='undefined') {                
        applicationRoot = '';                
    }
    
    var baseUrl;
    if(applicationRoot!='') {
        baseUrl = location.protocol + "//" + location.hostname +applicationRoot;
    } else {
        baseUrl = '';    
    }
    
    /** Reset the values of all the fields with previous errors as we are showing 
    the error messages in the input fields itself **/
    $('.form-error').each(function(){            
        $(this).val('');   
    });
            
    if ($.trim($('#feedbackName').val()).length === 0) {
        $('#feedbackName').addClass('form-error');
        $('#feedbackName').val('Please enter the Name');
        noValidationErrors = false;        
    } else if (!charcheck.test($('#feedbackName').val())) {
        $('#feedbackName').addClass('form-error');
        $('#feedbackName').val('Please enter valid Name.');
        noValidationErrors = false;        
    };
    if ($.trim($('#feedbackEmail').val()).length === 0) {
        $('#feedbackEmail').addClass('form-error');
        $('#feedbackEmail').val('Please enter the email.');
        noValidationErrors = false;        
    } else if( !emailReg.test( $('#feedbackEmail').val() ) ) {
        $('#feedbackEmail').addClass('form-error');
        $('#feedbackEmail').val('Please enter valid email id.');
        noValidationErrors = false;                
    } 
        
    if ($.trim($('#feedbackSubject').val()).length === 0) {            
        $('#feedbackSubject').addClass('form-error');
        $('#feedbackSubject').val('Please enter the subject.');
        noValidationErrors = false;
    }            
    if ($.trim($('#feedbackMessage').val()).length === 0) {            
        $('#feedbackMessage').addClass('form-error');
        $('#feedbackMessage').val('Please enter the Message.');
        noValidationErrors = false;
    }  
        
    var form = $(obj).find('.captcha-name').val();
    var img = $(obj).find('.captcha-image');
        
    if($('#feedback-captcha').val().length == 0) {
        $('#feedback-captcha').addClass('form-error');
        $('#feedback-captcha').val('Please enter code.');
        noValidationErrors = false;                            
    } else { 
            if(noValidationErrors == true ) {
                       //form submission with popup messages 
                       $.ajax({
                           type: "POST",
                           url: baseUrl + 'send-mail2.php',
                           data: $('#contactForm').serialize(),
                           beforeSend: function() {
                               parent.isSubmitting = true;
                               $('.requestSend').attr('disabled','disabled');
                           },
                           success: function(data) {
                               if (data == 'failure') {
                                    $('#feedback-captcha').addClass('form-error');
                                    $('#feedback-captcha').val('Incorrect code');
                                    $('.requestSend').removeAttr('disabled');
                                    noValidationErrors = false;
                                    return false;
                               } else if (data == 'adminError') {
	                           $('#response').html('<div class="wait-message-inner">Message not sent to Admin</div>'); 
	                       } else if (data == 'userError') {
	                           $('#responce').html('<div class="wait-message-inner">Message not sent to User</div>'); 
	                       } else {
                                 /*  $('#ContactPopUp').html('');
                                   $('#ContactPopUp').css('display','none');
                                   $('#ContactPopUp').show();
                                   $('#ContactPopUp').load(baseUrl + "contact-us-thank-you.php");
                                   $('#response').html(data);*/
                                   var site = $('#site').val();
                                    if (site != '') {
                                        baseUrl = baseUrl + "/" + site;
                                    }
                                   window.location.href = baseUrl + "/contact-us-thank-you.php";
								   //$('#response').html(data);
                               }                          	                   
                           }  
                       });  
                   }                 
               
    }   
}

/****************** Feedback form tablet*************/		
function feedbackFormTablet(obj)
{
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var charcheck =  /^[a-z A-Z0-9]+$/;
    var noValidationErrors = true;
    
    //Base URL and Application root
    if(typeof applicationRoot==='undefined') {                
                    applicationRoot = '';                
    }      
    var baseUrl;
    if(applicationRoot!='') {
        baseUrl = location.protocol + "//" + location.hostname +applicationRoot;
    } else {
        baseUrl = '';    
    }
    
    /** Reset the values of all the fields with previous errors as we are showing 
    the error messages in the input fields itself **/
    $('.form-error').each(function(){            
         $(this).val('');   
    });
            
    if ($.trim($('#feedbackNameTablet').val()).length === 0) {
        $('#feedbackNameTablet').addClass('form-error');
        $('#feedbackNameTablet').val('Please enter the Name');
        noValidationErrors = false;        
    } else if (!charcheck.test($('#feedbackNameTablet').val())) {
        $('#feedbackNameTablet').addClass('form-error');
        $('#feedbackNameTablet').val('Please enter valid Name.');
        noValidationErrors = false;        
    };
    if ($.trim($('#feedbackEmailTablet').val()).length === 0) {
        $('#feedbackEmailTablet').addClass('form-error');
        $('#feedbackEmailTablet').val('Please enter the email.');
        noValidationErrors = false;        
    } else if( !emailReg.test( $('#feedbackEmailTablet').val() ) ) {
        $('#feedbackEmailTablet').addClass('form-error');
        $('#feedbackEmailTablet').val('Please enter valid email id.');
        noValidationErrors = false;                
    } 
        
    if ($.trim($('#feedbackSubjectTablet').val()).length === 0) {            
        $('#feedbackSubjectTablet').addClass('form-error');
        $('#feedbackSubjectTablet').val('Please enter the subject.');
        noValidationErrors = false;
    }            
    if ($.trim($('#feedbackMessageTablet').val()).length === 0) {            
        $('#feedbackMessageTablet').addClass('form-error');
        $('#feedbackMessageTablet').val('Please enter the Message.');
        noValidationErrors = false;
    }  
        
    //captcha verification
    var form = $(obj).find('.captcha-name').val();
    var img = $(obj).find('.captcha-image');
        
    if($('#feedback-captcha-tablet').val().length == 0) {
        $('#feedback-captcha-tablet').addClass('form-error');
        $('#feedback-captcha-tablet').val('Please enter code.');
        noValidationErrors = false;                            
    } else {
            //form submission with popup messages 
            if(noValidationErrors == true ) {
                  $.ajax({
                      type: "POST",
                      url: baseUrl + 'send-mail2.php',
                      data: $('#contactFormTablet').serialize(),
                      beforeSend: function() {
                          $('.submit-overlay').show();
                          showMessage('<img src="' +applicationRoot +'images/ajax-loader.gif">');               
                      },
                      success: function(data){	
                          if (data == 'failure') {
                                    $('#feedback-captcha-tablet').addClass('form-error');
                                    $('#feedback-captcha-tablet').val('Incorrect code');
                                    setTimeout(function(){$('.submit-overlay').hide(); }, 'fast');
                                    noValidationErrors = false;
                                    return false;
                          } else if (data == 'adminError') {
	                      showMessage('<div class="wait-message-inner">Message not sent to Admin</div>');
                              refreshCaptcha(img,form); 
	                  } else if (data == 'userError') {
	                      showMessage('<div class="wait-message-inner">Message not sent to User</div>');
                             refreshCaptcha(img,form);
	                  } else {
                              window.location.href = baseUrl + "contact-us-thank-you.php";
                          }                           	                   
	                    
                          //close the pop up
                          setTimeout(function(){$('.submit-overlay').hide(); },3000);
	                  $('#contactFormTablet')[0].reset();
	              }  
                  });      
              }             
          
    }   
}

$(function() {
    //Base URL and Application root
    if(typeof applicationRoot === 'undefined') {                
        applicationRoot = '';    
    }      
    var baseUrl;
    if(applicationRoot!='') {
        baseUrl = location.protocol + "//" + location.hostname +applicationRoot;
    } else {
        baseUrl = '';    
    }
     
    //baseUrl = baseUrl + "/eastern-apps"; //for local
    $('#rightform li a').click(function(){
	 	  $('#ContactPopUp').show();
      console.log(baseUrl + "/" + this.id + ".php");
      $('#ContactPopUp').load(baseUrl + "/" + this.id + ".php");
    })
    
 
});

// Subscription form.
function subscribeFrom() {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

    if ($('#subscribeEmail').val().length === 0) {
        alert('Please enter the email.');
        return false;
    } else {
        if (!emailReg.test($('#subscribeEmail').val())) {
            alert('Please enter valid email id.');
            return false;
        }
    }

    //form submission with popup messages 
    $.ajax({
        type: "POST",
        url: baseUrl + '/subscribe-mail.php',
        data: $('#subscribeForm').serialize(),
        beforeSend: function () {
            //show overlay with loading image
            $('.submit-overlay').show();
            if (typeof applicationRoot === 'undefined') {
                applicationRoot = '';
            }
           // showMessage('<img src="' + baseUrl + '/assets/images/ajax-loader.gif">');
			showMessage('<img src=' +applicationRoot +'/assets/images/ajax-loader.gif">');
        },
        success: function (data) {
            if (data == 'adminError') {
                showMessage('<div class="wait-message-inner">Message not sent to Admin</div>');
            } else if (data == 'userError') {
                showMessage('<div class="wait-message-inner">Message not sent to User</div>');
            } else {
                // showMessage('<div class="wait-message-inner">You have been subscribed.</div>');  
                window.location.href = baseUrl + "/subscribe-thank.php";
            }
            //close the pop up
            setTimeout(function () {
                $('.submit-overlay').hide();
            }, 3000);
            $('#subscribeForm')[0].reset();
        }
    });
}


/* Go to TOP */

(function($){
	$.fn.UItoTop = function(options) {

 		var defaults = {
			text: 'To Top',
			min: 200,
			inDelay:600,
			outDelay:400,
  			containerID: 'toTop',
			containerHoverID: 'toTopHover',
			scrollSpeed: 1200,
			easingType: 'linear'
 		};

 		var settings = $.extend(defaults, options);
		var containerIDhash = '#' + settings.containerID;
		var containerHoverIDHash = '#'+settings.containerHoverID;
		
		$('body').append('<a href="#" id="'+settings.containerID+'">'+settings.text+'</a>');
		$(containerIDhash).hide().click(function(){
			$('html, body').animate({scrollTop:0}, settings.scrollSpeed, settings.easingType);
			$('#'+settings.containerHoverID, this).stop().animate({'opacity': 0 }, settings.inDelay, settings.easingType);
			return false;
		})
		.prepend('<span id="'+settings.containerHoverID+'"></span>')
		.hover(function() {
				$(containerHoverIDHash, this).stop().animate({
					'opacity': 1
				}, 600, 'linear');
			}, function() { 
				$(containerHoverIDHash, this).stop().animate({
					'opacity': 0
				}, 700, 'linear');
			});
					
		$(window).scroll(function() {
			var sd = $(window).scrollTop();
			if(typeof document.body.style.maxHeight === "undefined") {
				$(containerIDhash).css({
					'position': 'absolute',
					'top': $(window).scrollTop() + $(window).height() - 50
				});
			}
			if ( sd > settings.min ) 
				$(containerIDhash).fadeIn(settings.inDelay);
			else 
				$(containerIDhash).fadeOut(settings.Outdelay);
		});

};
})(jQuery);
