(function ($) {
    $(document).ready(function(){
        $('.audio-ctrl').click(function(){
            if( $(this).hasClass('button-unmute') ){
                $(this).removeClass('button-unmute').addClass('button-mute');
                $("video").prop('muted', false); //unmute
            }else{
                $(this).removeClass('button-mute').addClass('button-unmute');
                $("video").prop('muted', true); //mute
            }
        });
    });
}(jQuery));