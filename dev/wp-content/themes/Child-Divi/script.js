jQuery(document).ready(function($) {
var pageNumber = 1;
	  $(".videos-module,.videos-page").on('click','.videos-home,.video-feed',function () {
	  console.log("clicked");
		    var $this = this;
			var $url = $(this).attr('data-href');
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
					wrap : 
					'<div class="fancybox-wrap fancy-video-wrap" tabIndex="-1">' + 
						'<div class="fancybox-skin"> ' + 
							'<div class="fancybox-outer">' + 
								'<div class="fancybox-inner"></div>' + 
								'<div id="video-details" class="video-details row"><div class="progress"></div></div>' + 
							'</div>' + 
						'</div>' + 
					'</div>',
					image : '<img class="fancybox-image" src="{href}" alt="" />',
					iframe : '<iframe scrolling="0" id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0"' + ($.browser.msie ? ' allowtransparency="true"' : '') + '></iframe>',
					error : '<p class="fancybox-error">The requested content cannot be loaded.<br/>Please try again later.</p>',
					closeBtn : '<a title="Close" class="fancybox-item fancybox-close" href="javascript:;"></a>'
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
				},
				afterClose : function(){
					window.history.back();
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
		$.ajax({
			
			
							type: "GET",
				dataType: "html",
				url: '//bbbvideocontest.platypustest.info/dev/show-more-dont-delete/',
				data: {
					action: 'get_student_videos',
					pageNumber: 1,
					ppp: 6,
					sort: sort,
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
	
	
				$('#student-video-sort').on("change",function(){
			var sortVal = $(this).val();
			filterVideos('sort', sortVal);
		});
	
			$( ".loadmore" ).on("click",function(){ // When btn is pressed.
			$( ".loadmore" ).attr("disabled",true); // Disable the button, temp.
			loadMoreVideos();
		});
	
});