jQuery(document).ready(function($) {

  // Admin slider
  var w = $('.dcsnt-container .postbox-container').width();
  var slides = $('#dcsnt-slider .metabox-holder');
  var n = slides.length + 1;
  
  slides.wrapAll('<div id="dcsnt-slide-wrap"></div>').css({'float' : 'left','width' : w});
  $('#dcsnt-slide-wrap').css({width: (w*n)});
  
	$('.dcsnt-container .nav-tab').click(function(e){
		$('#message').slideUp();
		$('.dcsnt-container .nav-tab').removeClass('nav-tab-active');
		var i = $(this).index('.dcsnt-container .nav-tab');
		$(this).addClass('nav-tab-active');
		$('#dcsnt-slide-wrap').stop().animate({'marginLeft' : -w*i+'px'});
		var h = $('#dcsnt-slider .metabox-holder:eq('+i+')').outerHeight();
		$('#dcsnt-slider').animate({height: h+'px'},400);
		e.preventDefault();
	});
	$('.dcsnt-container #message.fade').hide();

	defaulttextFunction();
	
	$('.button-primary').click(function(){
		$(".defaultText").each(function() {
			if ($(this).val() == $(this).attr('title')) {
				$(this).val('');
			}
		});
	});
	$('#network-tab-container .network-tab').hide();
		
	$('.dcsnt-plugin .dcsnt-sortable-li a').click(function(e){
		var a = $(this).parent();
		var rel = a.attr('rel');
		$('#network-tab-container .network-tab').hide();
		$('#network-tab-container .network-tab[rel="'+rel+'"]').fadeIn();
		$('.dcsnt-sortable-li').removeClass('active');
		$('.dcsnt-sortable-li[rel="'+rel+'"]').addClass('active');
		e.preventDefault();
	});

	$('.network-header .dcsnt-switch-link a').click(function(e){
		var p = $(this).parent().parent();
		var c = p.parent();
		if($(this).hasClass('link-true')){
			$('.text-input-id',p).fadeOut();
			$('.dcsnt-options-edit',p).fadeOut();
			$('.icon-bg, h4',c).animate({opacity: 0.6},300);
		} else {
			$('.text-input-id',p).fadeIn();
			$('.dcsnt-options-edit',p).fadeIn();
			$('.icon-bg, h4',c).animate({opacity: 1},300);
		}
		e.preventDefault();
	});
	$('.dcsnt-help').click(function(e){
		var i = $(this).index('.dcsnt-help');
		var h = $('#dcsnt-slider .metabox-holder:eq('+i+')').outerHeight();
		if($(this).hasClass('active')){
			$(this).removeClass('active');
			$('.dcsnt-help-text').slideUp();
		} else {
			$('.dcsnt-help').removeClass('active');
			$('.dcsnt-help-text').slideUp();
			$(this).addClass('active').fadeOut();
			$('.dcsnt-help-text:eq('+i+')').slideToggle(300,function(){
				var help = $(this).outerHeight(true);
				var hnew = h+help;
				$('#dcsnt-slider').animate({height: hnew+'px'},400);
			});
		}
		e.preventDefault();
	});
	$('.dcsnt-close').click(function(e){
		var i = $(this).index('.dcsnt-close');
		$('.dcsnt-help-text:eq('+i+')').slideToggle();
		$('.dcsnt-help:eq('+i+')').removeClass('active').fadeIn();
		$('#dcsnt-slider').animate({height: h+'px'},400);
		e.preventDefault();
	});
	
	// Image swap
	$(".img-swap").hover(
          function(){this.src = this.src.replace("_off","_on");},
          function(){this.src = this.src.replace("_on","_off");
     });
	$('ul.dcwp-rss li:last').addClass('last');
	$('.dcsnt-update').click(function(e){
		var rel = $(this).attr('rel');
				var nonce = $('#stats-nonce').val();		
				var icon = $('img',this);
				$('#dcsnt-row-'+rel+' td').addClass('hash');
				icon.attr('src',icon.attr('src').replace("refresh_off.png","loading.gif"));
				var data = {
					action: 'dcsnt_ajax_update',
					id: rel,
					security: nonce
				};
				
				$.post(ajaxurl, data, function(response) {
				$('#dcsnt-row-'+rel).animate({opacity: 0.5},400,function(){
					$('#dcsnt-row-'+rel).after(response).slideUp();
				});
				icon.attr('src',icon.attr('src').replace("loading.gif","refresh_off.png"));
				});
				return false;
			});
	$('.dcsnt-switch-link a').live('click',function(){
		var $tag = $(this).parent();
		$('a',$tag).toggleClass('active');
		var rel = $('a.active',$tag).attr('rel');
		$tag.next('.dc-switch-value').val(rel);
		if($tag.hasClass('dcsnt-types-link')){
			var typeList = [];
			$('.dcsnt-types-link').each(function(){
				if($(this).next('.dc-switch-value').val() == 'true'){
					var rel = $(this).next('.dc-switch-value').attr('rel');
					typeList.push(rel);
				}
			});
			$('#dcsnt_types').val(typeList);
		} else if ($tag.hasClass('dcsnt-network-widget')){
			var networkList = [];
			$('.dcsnt-network-widget').each(function(){
				if($(this).next('.dc-switch-value').val() == 'true'){
					var rel = $(this).next('.dc-switch-value').attr('rel');
					networkList.push(rel);
				}
			});
			$('#dcsnt_types').val(typeList);
			$('dcsnt-network-list').val(networkList);
		}
		return false;
	});
	$('#dcsnt-sortable li.dcsnt-sortable-li:odd').addClass('odd');
			$('.dcsnt-select-stats').change(function(){
				//alert('ok');
				var $form = $(this).parent('form');
				$('.dcsnt-loading',$form).show();
				var url = $form.attr('action');
				$.post(url, $form.serialize() ,function(data){
					$('.dcwp-response',$form).html(data);
					$('.dcsnt-loading',$form).fadeOut(100,function(){
						var url=document.URL.split('&')[0];
						if(url != ''){
							window.location = url;
						} else {
							location.reload();
						}
					});
				});
			});

	// Widgets
	var v = $('.dcsnt-widget-select').val();
	$('.dcsnt-hide.'+v).show();
	$('.dcsnt-widget-select').change(function(){
		v = $(this).val();
		$('.dcsnt-hide').slideUp();
			$('.dcsnt-hide.'+v).slideDown();
	});
});
jQuery(window).load(function() {
	jQuery('.dcsnt-plugin .dcsnt-sortable-li:first a').trigger('click');
});
function defaulttextFunction(){
	jQuery(".defaultText").focus(function(srcc) {
		if (jQuery(this).val() == jQuery(this)[0].title) {
			jQuery(this).removeClass("defaultTextActive").val("");
		}
	});
	jQuery(".defaultText").blur(function(){
		if (jQuery(this).val() == "") {
			jQuery(this).addClass("defaultTextActive").val(jQuery(this)[0].title);
		}
	});
	jQuery(".defaultText").each(function() {
		if (jQuery(this).val() != jQuery(this)[0].title) {
			jQuery(this).removeClass("defaultTextActive");
		}
		if (jQuery(this).val() == "") {
			jQuery(this).val(jQuery(this)[0].title).addClass("defaultTextActive");
		}
	});
}