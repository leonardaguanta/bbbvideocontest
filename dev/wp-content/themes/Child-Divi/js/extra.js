(function ( $ ) {

	'use strict';

	var extra = {

		init: function () {
			this.autoAdjustHeight();
			this.redirectCreatedNewUser();
			this.emailValidation();
			this.adminDeleteUser();
			this.deleteUserGroupPrompt();
			this.adminDeletePending();
			this.adminDeleteAccepted();
			 this.viewStat();
                        this.deleteVideoPrompt();
                        this.rejectVideoPrompt();
                        this.approvedVideoPrompt();
			$( '#mainRegistrationForm' ).removeAttr( 'style' ).find('.signup-preload' ).remove(); //remove style
                        this.settingAdmin();
                        this.verifyUploadSize();
                        //this.videoValidation();
		},
                videoValidation : function(){
                   var gFooter = $('#gform_5 .gform_footer');
                    //gFooter.find('#gform_submit_button_5').prop('disabled',true);
                     console.log('hello');


                   var isValidForm = false;
                    
                    $('#gform_5').on('submit',function(e){

                        e.preventDefault();
       
                        if(isValidForm === true){
                           isValidForm = false;
                           return;  
                        }
                        extra.errorClear();
                        console.log(isValidForm);
                        var vidTitle = $(this).find('#input_5_3').val();
                        var vidDescription = $(this).find('#input_5_10').val();
                        var mp4Video = $(this).find('#input_5_7').val();

                        if(vidTitle === ''){
                            isValidForm = false;
                            extra.errorVideoTitle();
                         }

                         if(vidDescription === ''){
                            isValidForm = false;
                            extra.errorVideoDescription();
                         }

                         if(mp4Video === ''){
                            isValidForm = false;
                            extra.errorVideoInput();
                         }

                         console.log(isValidForm);
                         isValidForm = true;
                         $(this).trigger('submit');

                    });  
                },

                errorVideoTitle : function(){
                    var gHeading = $('#gform_5 .gform_heading');
                    var gBody  = $('#gform_5 .gform_body');
                    var gFooter = $('#gform_5 .gform_footer');
                    var vidTitle =  gBody.find('#field_5_3');
                    //gFooter.find('#gform_submit_button_5').prop('disabled',true);
                    gHeading.after('<div class="validation_error">Video title is required.</div>');
                    vidTitle.addClass('gfield_error');
                    vidTitle.find('.gfield_description').after('<div class="gfield_description validation_message">This field is required.</div>');
                },
                errorVideoDescription : function(){
                    var gHeading = $('#gform_5 .gform_heading');
                    var gBody  = $('#gform_5 .gform_body');
                    var gFooter = $('#gform_5 .gform_footer');
                    var vidDescription =  gBody.find('#field_5_10');
                    //gFooter.find('#gform_submit_button_5').prop('disabled',true);
                    gHeading.after('<div class="validation_error">Video description is required.</div>');
                    vidDescription.addClass('gfield_error');
                    vidDescription.find('.gfield_description').after('<div class="gfield_description validation_message">This field is required.</div>');


                },
                errorVideoInput : function(){
                    var gHeading = $('#gform_5 .gform_heading');
                    var gBody  = $('#gform_5 .gform_body');
                    var gFooter = $('#gform_5 .gform_footer');
                    var mp4Video =  gBody.find('#field_5_7');
                    //gFooter.find('#gform_submit_button_5').prop('disabled',true);
                    gHeading.after('<div class="validation_error">File size must not exceed 50MB.</div>');
                    mp4Video.addClass('gfield_error');
                    mp4Video.find('.gfield_description').after('<div class="gfield_description validation_message">This field is required.</div>');

                },
                errorClear : function(){
                         var gHeading = $('#gform_5 .gform_heading');
                         var gBody  = $('#gform_5 .gform_body');
                         var gFooter = $('#gform_5 .gform_footer');
                         gHeading.next('.validation_error').remove();
                         gBody.find('.gfield').removeClass('gfield_error');
                         gBody.find('.gfield .validation_message').remove();
                         gFooter.find('#gform_submit_button_5').prop('disabled',false);

                },
                verifyUploadSize : function(){
 
                    $('#gform_fields_5').find('#input_5_7').on('change',function(){
                         var fileMB = (this.files[0].size / 1000) / 1000;
                         extra.errorClear();
		         if(fileMB > 50){
                           extra.errorVideoInput();                          
                         }
                    });
                },
	        settingAdmin : function( ){
                  $('#activity-log-message').on( 'click', function(){
                    var href = $(this).closest('#activity-messge').next().find( '#fep-menu a[href$="fepaction=settings"]' ).attr('href');
                    window.location.assign(href);
                  });
		},
                approvedVideoPrompt : function(){
                   $('form.approve-video-prompt').on('submit',function(e){
                      console.log(e.originalEvent);
                      e.preventDefault();
                      var el = $(this);
                      var data = el.serialize();
                      var container = el.parents('.main-container2');
                       var lenContainer = $('.pending-vid-container').find('.main-container2').length;
                       console.log(lenContainer);

var x = confirm('Do you want to approve this video?');
if(x){
  container.remove();
if(lenContainer <= 1){
                             $('.pending-vid-container').append('<div class="vid-upload-btn"><h2>No pending video entries yet</h2></div>');
                           }
                            console.log(ajax_object.ajax_url +'?' + data + '&action=approve_video_ajax');
                           $.post(ajax_object.ajax_url + '?' + data + '&action=approve_video_ajax',function(e){
                              console.log(e);
                           });

                         
}else{

}
/*                 window.confirm('Do you want to approve this video?',function(){
                         if(lenContainer <= 1){
                             $('.pending-vid-container').append('<div class="vid-upload-btn"><h2>No pending video entries yet</h2></div>');
                           }
                            console.log(ajax_object.ajax_url +'?' + data + '&action=approve_video_ajax');
                           $.post(ajax_object.ajax_url + '?' + data + '&action=approve_video_ajax',function(e){
                              console.log(e);
                           });

                         container.remove();
                      });
*/





                   });
                },
                rejectVideoPrompt : function(){
                     $('.reject-video-prompt').on('click',function(e){
                       e.preventDefault();
                       var href = $(this).attr('href');
                       var container = $(this).parents('.main-container2');
                       var lenContainer = $('.pending-vid-container').find('.main-container2').length;
                       window.confirm('Do you want to reject this video?',function(){ 
                         $.get(href);
                         container.remove();
                         if(lenContainer <= 1){
                             $('.pending-vid-container').append('<div class="vid-upload-btn"><h2>No pending video entries yet</h2></div>');
                         }
                       });
                        
                    });

                },
                deleteVideoPrompt : function(){

                    $('.delete-video-prompt').on('click',function(e){
                       e.preventDefault();
                       var href = $(this).attr('href');
                       var container = $(this).parents('.main-container2');
                       window.confirm('Are you sure you want to delete this video?',function(){ 
                         $.get(href);
                         container.remove();
                       });
                        
                    });
                },
		deleteUserGroupPrompt : function(){
		$('.delete-usergroup-student').on('click',function(e){
		    e.preventDefault();
		    var href = $(this).attr('href');
		   
		    window.confirm('Are you sure you want to delete this group?',function(){
			window.location.assign(href);
		    });
		});
		

		},
		emailValidation: function () {
			var timerInterval = 10;
			var funcTimer;
			var $userEmail = $( '#user_email' );

			$userEmail.on( 'keyup', function(){
				clearTimeout( funcTimer );
				funcTimer = setTimeout( function(){
					$.ajax( {
						type: "POST",
						dataType: 'json',
						url: et_custom.ajaxurl,
						data: {
							action: 'dbbb_custom_validation',
							email : $userEmail.val()
						},
						success: function ( serverResponse ) {
							console.log( serverResponse );
							var errID = $( '#custom_emailErr' );
							if ( serverResponse.val == "true" ) {
								email = false;
								errID.html( serverResponse.message );
								errID.show();
								$( "#submit" ).attr( 'disabled', true );
							} else {
								errID.html( '' );
								$( "#submit" ).attr( 'disabled', false );
								errID.hide();
							}
						},
						error: function ( e ) {
							console.log( e );
						}
					} );
				}, timerInterval );
			} );

			$userEmail.on( 'keydown', function(){
				clearTimeout( funcTimer );
			} );
		},
		adminDeletePending : function(){

			$('.toReject a').on('click',function(e){
				e.preventDefault();
			        var current_el = $(this);
				var href = $(this).attr('href');
		
				var x = confirm('Are you sure you want to reject this video?');
if(x){
	console.log('yes');		
	      location.href = href;

}	
			});	

		},
		viewStat: function(){
		
						$('.studentVid-stats').on('click',function(e){
			//	e.preventDefault();
			 //       var current_el = $(this);
				var id = $(this).attr('data-target');
				//			$('#modal-'+id ).modal('show');

				$('#modal-'+id ).modal('show');	
	 $.ajax({
type: 'POST',
        url: ajax_object.ajax_url,
        data: {
            'id':id,
            'action': 'viewstat' //this is the name of the AJAX method called in WordPress
        }, success: function (result) {
			$('#modal-'+id+' .loading-stat').remove();
			$('#modal-'+id+' .likes').html(result['votes']);
			
			$('#modal-'+id+' .dataview').html(result['dataView']);
			$('#modal-'+id+' .average-duration.').html(result['avgDuration']);
          // console.log(result);
        },
        error: function () {
            alert("error");
        }	
				  });													
			});	
		},
		adminDeleteAccepted : function(){

			$('.approved-pending').on('click',function(e){
				e.preventDefault();
			        var current_el = $(this).find('a');
				console.log(current_el.attr('data-target'))
				var id = current_el.attr('data-target');
				var nonce = current_el.attr('data-nonce');
		
				var x = confirm('Are you sure you want to deactivate this video?');
if(x){
	console.log( id);		
	 $.ajax({
type: 'POST',
        url: ajax_object.ajax_url,
        data: {
            'id':id,
            'action': 'admin_deactivate_video' //this is the name of the AJAX method called in WordPress
        }, success: function (result) {

           console.log(result);
        },
        error: function () {
            alert("error");
        }	
				  });
					location.reload();
				//$('#confirm.admin-confirm-delete-user').remove();
}	
			});	

		},
		adminDeleteUser : function(){

			$('.bbbAdminDeleteUser').on('click',function(e){
				e.preventDefault();
			        var current_el = $(this);
		
				var x = confirm('Are you sure you want to delete this user?');
if(x){
				  $.ajax({
				    url: ajax_object.ajax_url,
				    type : 'GET',
				    dataType : 'json',
				    data : {
					action : 'admin_delete_user',
					nonce :current_el.attr('data-nonce'),
				        id : current_el.attr('data-id')
 				    },
				    beforeSend : function(){
					current_el.addClass('ajax-preloader');
				    },
				    success :function(respond){
						console.log(respond);
				      if (respond.result){
					current_el.closest('.student-basic-info').remove();
				      }	
				    },
				    error : function(e){
					console.log(e);
				    },
				    complete : function(){
				      current_el.removeClass('ajax-preloader');
				   }	
				  });
				$('#confirm.admin-confirm-delete-user').remove();
                         
}else{

}
				
				
				
				
			

				
			});	
			$('body').on('click','.admin-confirm-delete-user .no', function(){
			  $('.modal-close').trigger('click');
		          $('#confirm.admin-confirm-delete-user').remove();
			});
		},
		// auto adjust the height of
		autoAdjustHeight : function () {
				$( '#textarea-con' ).on( 'change keyup keydown paste cut', 'textarea', function () {
					$( this ).height( 0 ).height( this.scrollHeight );
				} ).find( 'textarea' ).change();

			}

			,
			redirectCreatedNewUser : function () {
				var modal_new_user = $( '#modal-created-user-account' );
				if ( modal_new_user.length != 0 ) {
					setTimeout( function () {
						modal_new_user.fadeOut(300).queue(function(next){
						   $(this).remove();
		 				   next();
						});
					}, 7000 );
				}
			}
		};

	extra.init();

})( jQuery );
