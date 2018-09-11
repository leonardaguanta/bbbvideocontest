jQuery( document ).ready( function($) {
    if ($('#mainNav a.nav-link').hasClass('active') || $('#collapseExamplePages a').hasClass('active') ) {
        $('#mainNav a.nav-link.nav-link-collapse').addClass('collapsed');
        $('#collapseComponents').removeClass('show');
    }

    if( $('#collapseExamplePages a').hasClass('active') ) {
        $('#collapseExamplePages').addClass('show');
    }

    
    $('.approve-video-prompt').hover(function(){
        $('.approve-video-prompt .c-btn').attr( 'src', '/dev/wp-content/uploads/2018/09/thumb-up-button-orange.png' );
    }, function(){
        $('.approve-video-prompt .c-btn').attr('src', '/dev/wp-content/uploads/2018/08/thumb-up-button-1.png');
    });

}); 