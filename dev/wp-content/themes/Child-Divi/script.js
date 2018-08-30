jQuery(document).ready(function($) {
	
	/*-------- List Field Placeholder --------*/
	$('#field_7_11 .gfield_list_group').each((i, el) => {
		$(el).find('.gfield_list_cell').each((x, element) => {
			let $this = $(element),
			$tr = $('tr', $this.parent().parent().prev());
			$('input', $this).attr('placeholder', $('th:eq(' + x + ')', $tr).text());
		});
	});

	/*-------- Admin Videos Load on Click ---------*/

	//$('.studentVid-stats').attr('data-target', '#modal--' + $('.approved-videoData').attr('video-id'));
	$('.studentVid-stats').attr('data-target', $('.approved-videoData').attr('video-id'));
	$('.approved-videoData').click(function () {
		//	$('.studentVid-stats').attr('data-target', '#modal-' + $(this).attr('video-id'));
			$('.studentVid-stats').attr('data-target', $(this).attr('video-id'));

		var videoClickID = $(this).attr('video-id');
		
		//$( ".action-buttons" ).prepend('<span class="toApprove"><a href="">Approve</a></span>' );
		$('#approved-heroVid').attr('src', $(this).attr('video-url'))[0].load();
		$('.submitted-videoTitle').text($(this).attr('video-title'));
		$('.submitted-videoAuthor').text($(this).attr('video-author'));		
	//	$('.view-stats > a').attr('href', '#TB_inline?height=680&width=650&inlineId=ApprovedVideoStatPopup_' +videoClickID);
 
		if($('.approved-remove a').length){
			$('.approved-remove a').attr('href', $(this).attr('video-delete'));
		}
		if($('.approved-pending a').length){
			$('.approved-pending a').attr('href', $(this).attr('video-pending'));
			$('.approved-pending a').attr('data-target', $(this).attr('video-pending'));
		}
		if($('.toReject a').length){
			$('.toReject a').attr('href', $(this).first().attr('video-delete'));
		}
		if($('.toMessage a').length){
			$('.toMessage a').attr('data-target', $(this).first().attr('video-send-message'));
		}
		if($('.toApprove').length){
		//	$('.toApprove').replaceWith(jQuery('.approved-videoData').first().attr('video-approved-html'));
		}
		$('.approve-video-prompt').replaceWith($(this).first().attr('video-approved-html'));
	      jQuery( ".approve" ).on("click",function(){ // When btn is pressed.
			   console.log('text2');
      jQuery("form.approve-video-prompt").submit();
    });
	  jQuery('form.approve-video-prompt').on('submit',function(e){
          console.log(e.originalEvent);
          e.preventDefault();
          var el = jQuery(this);
          var data = el.serialize();
          var container = el.parents('.main-container2');
          var lenContainer = jQuery('.pending-vid-container').find('.main-container2').length;
  console.log(ajax_object.ajax_url +'?' + data + '&action=approve_video_ajax');
          if (window.confirm("Do you want to approve this video?")) { 

            console.log(ajax_object.ajax_url +'?' + data + '&action=approve_video_ajax');
            jQuery.post(ajax_object.ajax_url + '?' + data + '&action=approve_video_ajax',function(e){
              console.log(e);
          });

            container.remove();
                         if(lenContainer <= 1){
                jQuery('.pending-vid-container').append('<div class="vid-upload-btn"><h2>No pending video entries yet</h2></div>');
            }
            location.reload();
        }
        
        
    }); 
	});

	var videoID = $('.approved-videoData').first().attr('video-id');

	if($('#approved-heroVid').length){
		$('#approved-heroVid').attr('src', $('.approved-videoData').first().attr('video-url'))[0].load();

	}
	$('.submitted-videoTitle').text($('.approved-videoData').first().attr('video-title'));
	$('.submitted-videoAuthor').text($('.approved-videoData').first().attr('video-author'));
	//$('.view-stats > a').attr('href', '#TB_inline?height=680&width=650&inlineId=ApprovedVideoStatPopup_'+videoID );
	//$('.approved-remove').text($('.approved-videoData').first().attr('video-delete'));
	$('.approved-remove a').attr('href', $('.approved-videoData').first().attr('video-delete'));
	$('.toReject a').attr('href', $('.approved-videoData').first().attr('video-delete'));
	$('.toMessage a').attr('data-target', $('.approved-videoData').first().attr('video-send-message'));
	$('.approved-pending a').attr('data-target', $('.approved-videoData').first().attr('video-pending'));
	$('.approved-pending a').attr('data-nonce', $('.approved-videoData').first().attr('data-nonce'));
	//$('.approve-video-prompt').replaceWith($('.approved-videoData').first().attr('video-approved-html'));
        $('.toApprove').replaceWith($('.approved-videoData').first().attr('video-approved-html'));

	$('.approvedvideopop').each(function (index, value){
		$(this).appendTo('#pops');
	});

	
	$('.video-paginationCol > .et_pb_text_inner').slick({
		infinite: true,
		slidesToShow: 3,
		slidesToScroll: 3,
		arrows: false,
		dots: true,
		customPaging: function (slider, i) {
			return '<a>'+(i+1)+'</a>';
		}
	});
      jQuery( ".approve" ).on("click",function(){ // When btn is pressed.
        console.log('text1');
		         jQuery("form.approve-video-prompt").submit();

    });
	  jQuery('form.approve-video-prompt').on('submit',function(e){
          console.log(e.originalEvent);
          e.preventDefault();
          var el = jQuery(this);
          var data = el.serialize();
          var container = el.parents('.main-container2');
          var lenContainer = jQuery('.pending-vid-container').find('.main-container2').length;
  console.log(ajax_object.ajax_url +'?' + data + '&action=approve_video_ajax');
          if (window.confirm("Do you want to approve this video?")) { 

            console.log(ajax_object.ajax_url +'?' + data + '&action=approve_video_ajax');
            jQuery.post(ajax_object.ajax_url + '?' + data + '&action=approve_video_ajax',function(e){
              console.log(e);
          });

            container.remove();
                         if(lenContainer <= 1){
                jQuery('.pending-vid-container').append('<div class="vid-upload-btn"><h2>No pending video entries yet</h2></div>');
            }
            location.reload();
        }
        
        
    });  
	var pageNumber = 1;
	$(".videos-module,.videos-page").on('click','.videos-home,.video-feed',function () {
		var timer = new Timer();

		var $this = this;
		var $url = $(this).attr('data-href');
		var $videoname =$(this).attr('data-video-name');
		var $secondsplayed;
		$url = $url.split("/");
		$url = $url[4] + "/" + $url[5];
		var videoId = $(this).attr('data-id');
		if( $url ){
			window.history.pushState("popup_url", "", "/dev/" + $url);
		}
		$.fancybox.open([{ href: $($this).attr('data-url') }], 
		{ 
			
			modal: false,
			nextEffect: 'none',
			prevEffect: 'none',
			padding: [50,0,0,0],
			type : 'iframe',
			tpl : {
			
			},
			scrolling: 'no',
			preload   : true,
			autoCenter : true,
				// maxWidth : 800,
				maxHeight : 600,
				fitToView : true,
				width : '80%',
				height : '80%',
				autoSize : false,
				closeClick : false,
				openEffect : 'none',
				closeEffect	: 'none',
				beforeShow : function(){
					
				},
				afterLoad: function(current, previous) {
					// $(document).ready(function(){ $('.fp-ui').trigger('click'); });
					//loadVideoDetails(videoId);
					// $.fancybox.update();
					timer.start();
					
					timer.addEventListener('secondsUpdated', function (e) {
						$secondsplayed = (timer.getTotalTimeValues().seconds.toString());
					});
					
					ga(function(tracker) {
						var clientId = tracker.get('clientId');
					});
					var clientId = ga.getAll()[0].get('clientId');
					ga('create', 'UA-68402304-1', {
						'clientId': clientId
					});
					

				},
				afterClose : function(){
					window.history.back();
					console.log('closed');
					timer.stop();
					console.log($videoname);
					console.log($secondsplayed);
					
					ga('send', 'event', {
   'eventCategory': 'Video Played', //required
   'eventAction': 'mp4', //required
   'eventLabel': $videoname ,
   'eventValue':   $secondsplayed,
   'hitCallback': function() {
   	console.log('Sent!!');
      //callback function
  },
  'hitCallbackFail' : function () {
  	console.log("Unable to send Google Analytics data");
      //callback function
  }
});	
					
					
					
				}
			});

		return false; 
		});//end
	
	function loadVideoDetails(id){
		var videoId = id;
		var data = [];
		for (var i = 0; i < 100000; i++) {
			var tmp = [];
			for (var i = 0; i < 100000; i++) {
				tmp[i] = 'hue';
			}
			data[i] = tmp;
		};
		
		$.ajax({
			xhr: function () {
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener("progress", function (evt) {
					if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;
							// console.log(percentComplete);
							$('.progress').css({
								width: percentComplete * 100 + '%'
							});
							if (percentComplete === 1) {
								// $('.progress').addClass('hide');
							}
						}
					}, false);
				xhr.addEventListener("progress", function (evt) {
					if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;
							// console.log(percentComplete);
							$('.progress').css({
								width: percentComplete * 100 + '%'
							});
						}
					}, false);
				return xhr;
			},
			type: "POST",
			dataType: "html",
			url: ajax_object.ajax_url,
			data: {
				videoId: videoId,
				action: 'get_video_details'
			},
			beforeSend: function(){
				
			},
			success: function(data){
				$('.progress').addClass('hide');
				$('#video-details').append(data).hide().fadeIn();
				return true;
			},
			error : function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
			}

		});
		return false;
		}//end
		

		
		function filterVideos(usage, val){
			var sort = $('#student-video-sort').val();
			if( usage === "sort" ){
				sort = val; 
			}
			pageNumber = 1;
			var $schools = new Array();
			$('input.school-sort:checked').each(function(){
				$schools.push(this.value);
			});
			$.ajax({
				
				
				type: "GET",
				dataType: "html",
				url: '//bbbvideocontest.platypustest.info/dev/show-more-dont-delete/',
				data: {
					action: 'get_student_videos',
					pageNumber: 1,
					ppp: 6,
					sort: sort,
					schools: $schools.toString(),
				},
				beforeSend: function(){
					$( "#ajax-posts" ).fadeOut('fast').html("");
					$('.movie-loader').show();
				},
				success: function(data){
					$( "#ajax-posts" ).fadeIn('fast');
					$('.movie-loader').hide();
					var $data = $(data);
					if( $data.length ){
						$( "#ajax-posts" ).append($data);
						$( ".loadmore" ).attr("disabled",false);
					} else {
						$( ".loadmore" ).attr("disabled",true);
					}
					$( '.loadmore' ).show();

					if( $('#ajax-posts').attr('data-page') == pageNumber ){
						$('.loadmore').fadeOut();
					}
					if( parseInt($.trim(data)) < 1 ){
						$('.loadmore').fadeOut();
					}
					if($('#video_max_page').val() == 1 || $('#video_max_page').val() == 0){
						$('.loadmore').hide();
					}
				},
				
				error : function(jqXHR, textStatus, errorThrown) {
					console.log(jqXHR);
					if(jqXHR.status == "404"){
						$('.loadmore').hide();
						$('.movie-loader').hide();
					}
				}
				
				
				
			});
			return false;
		}
		
		
		function loadMoreVideos(){
			console.log("PN"+pageNumber);
			pageNumber++;
			var sort = $('#load-more').attr('data-sort');
			$.ajax({
				type: "GET",
				dataType: "html",
				url: '//bbbvideocontest.platypustest.info/dev/show-more-dont-delete/',
				data: {
					
					pageNumber: pageNumber,
					sort: sort,
					action: 'load_more_videos',
					security: '<?php echo wp_create_nonce("load_more_posts");?>'

				},
				beforeSend: function(){
					$('.movie-loader').show();
				},
				success: function(data){
					$('.movie-loader').hide();
					var $data = $(data);
					if( $data.length ){
						$( "#ajax-posts" ).append($data);
						$( ".load-more" ).attr("disabled",false);
					} else {
						$( ".load-more" ).attr("disabled",true);
					}
					
					if(data.trim() == "0"){
						$('.load-more').hide();
					}
					if( $('#ajax-posts').attr('data-page') == pageNumber ){
						$('.load-more').fadeOut();
					}
					//studentVideoPageResize();
				},
				error : function(jqXHR, textStatus, errorThrown) {
					console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
				},
				complete : function(){

					if( $('#ajax-posts').attr('data-page') == pageNumber ){
						$('.loadmore').fadeOut();
											//console.log( $('#ajax-posts').attr('data-page'));
										}
										if($('#video_max_page').val() == 1 || $('#video_max_page').val() == 0){
											$('.loadmore').hide();
										}
									}
								});
			
			console.log("PN"+pageNumber);
			
		}
		$('.school-sort').on('change', function(){
			$('#video-filter').attr("disabled", false);
		});		
		$('#video-filter').on("click",function(){
			filterVideos('filter', '');
		});
		$('#student-video-sort').on("change",function(){
			var sortVal = $(this).val();
			filterVideos('sort', sortVal);
		});
		
			$( ".loadmore" ).on("click",function(){ // When btn is pressed.
			$( ".loadmore" ).attr("disabled",true); // Disable the button, temp.
			loadMoreVideos();
		});
		});
