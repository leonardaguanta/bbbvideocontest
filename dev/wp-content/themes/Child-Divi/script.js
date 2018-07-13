jQuery(document).ready(function($) {

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
	
});