<?php
/*
Template name: VideoFrame
*/
$videoId = isset($_GET['vid_id']) ? $_GET['vid_id'] : '';


        get_header();
        echo '<input value="1" id="popup-video-ni" type="hidden"/>';
        if($videoId){
            echo $videoId;
            echo do_shortcode('[flowplayer id="'. $videoId .'"]'); 
        }else{
            echo "<h5>No Video found.</h5>";
        }
        get_footer();

        // wp_footer();
//     echo '</body>';
// echo '</html>'
?>