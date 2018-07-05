function simplevotemeaddvote(event, postId, tipo, userID, votes) {
    console.log("processing");
        jQuery.ajax({
            type: 'POST',
            url: gtsimplevotemeajax.ajaxurl,
            data: {
                action: 'simplevoteme_addvote',
                tipo: tipo,
                postid: postId,
                userid: userID,
                votes: votes
            },
         /*   beforeSend: function(){
                event.preventDefault();
                jQuery('#simplevoteme-' + postId + ' a').css({
                    'pointer-events': 'none',
                    '-webkit-touch-callout': 'none',
                    'cursor': 'default',
                });
                jQuery('#simplevoteme-' + postId + ' a i').addClass('pulse2');
            },*/
            success: function (data, textStatus, XMLHttpRequest) {
                console.log(data);
                var linkid = '#simplevoteme-' + postId;
                jQuery(linkid).html('');
                jQuery(linkid).append(data);

                jQuery('#simplevoteme-' + postId + ' a').css({
                    'pointer-events': 'auto',
                    '-webkit-touch-callout': 'auto',
                    'cursor': 'pointer',
                });
                
                jQuery('#simplevoteme-' + postId + ' a i').removeClass('pulse2');
            },
            error: function (MLHttpRequest, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
}
