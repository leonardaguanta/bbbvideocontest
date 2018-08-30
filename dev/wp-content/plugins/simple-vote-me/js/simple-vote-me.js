/*function simplevotemeaddvote(postId, tipo, userID){
    jQuery.ajax({
    type: 'POST',
    url: gtsimplevotemeajax.ajaxurl,
    data: {
    action: 'simplevoteme_addvote',
    tipo: tipo,
    postid: postId,
    userid: userID
},
 
success:function(data, textStatus, XMLHttpRequest){
 
    var linkid = '#simplevoteme-' + postId;
    jQuery(linkid).html('');
    jQuery(linkid).append(data);
    },
    error: function(MLHttpRequest, textStatus, errorThrown){
        console.log(errorThrown);
        }
    });
}
*/
// CHECK VIDEOS INSIDE PAGE AND REFER TO COOKIES ============================
function checkVotedVids() {
    jQuery('.simplevotemeWrapper').each(function(index){
        console.log('checking...');
        console.log(jQuery(this).data('id'));
        if( canVote( jQuery(this).data('id') ) )
            jQuery('#simplevoteme-' + jQuery(this).data('id') + ' a').css({'pointer-events':'auto', 'opacity':'1'});
        else
            jQuery('#simplevoteme-' + jQuery(this).data('id') + ' a').css({'pointer-events':'none', 'opacity':'0.3'});
    });
}

jQuery(window).load(function(){
    checkVotedVids();
});

jQuery(document).ajaxSuccess(function(event, xhr, settings){
    setTimeout(function(){ checkVotedVids(); }, 1000);
});
//@end CHECK VIDEOS INSIDE PAGE AND REFER TO COOKIES ============================

function simplevotemeaddvote( postId, tipo, userID, votes) {

    console.log("processing.." + postId);

    if( canVote(postId) ){
        __setCookie(postId);
        console.log( 'cookie have been set' );

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
            success: function (data, textStatus, XMLHttpRequest) {
                jQuery('.simplevotemeWrapper#simplevoteme-' + postId).find('span.result .value').html( parseInt( jQuery('.simplevotemeWrapper#simplevoteme-' + postId).find('span.result .value').html() ) + 1 );
                jQuery('#simplevoteme-' + postId + ' a').css({'pointer-events':'none', 'opacity':'0.3'});
            },
            error: function (MLHttpRequest, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

    }else{
        console.log( 'please wait N minutes to vote again' );
        jQuery('#simplevoteme-' + postId + ' a').css({'pointer-events':'none', 'opacity':'0.3'});

    }

}

function canVote(postId) {
    var vote = getCookie("vote_" + postId);
    if (vote != "") { // restrict
        return false;
    } else { // voting open
        return true;
    }
}

function __setCookie(postId) {
    var now = new Date();
    var time = now.getTime();
    time += 3600 * 1000;
    now.setTime(time);
    document.cookie = "vote_"+ postId +"='true'; expires=" + now.toUTCString() + "; path=/";
 }

 function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
