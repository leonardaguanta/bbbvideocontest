<div class="entry-content">
    <?php
$args     = array(
    'post_type' => 'flowplayer5',
    'post_status' => 'publish',
    'posts_per_page' => '6 ',
    'paged' => 1
);
$my_posts = new WP_Query($args);
if ($my_posts->have_posts()):
?>
       <div class="my-posts">
            <?php
    while ($my_posts->have_posts()):
        $my_posts->the_post();
?>
                   <div class="video-feed et_pb_column et_pb_column_1_3  et_pb_column_0 et_pb_css_mix_blend_mode_passthrough">                
                <div class="et_pb_module et_pb_image et_pb_image_0 et_always_center_on_mobile">
                <?php
        if (has_post_thumbnail()) {
?>
                   <span class="et_pb_image_wrap video-thumbnail"><img src="<?php
            the_field('fp5-splash-image');
?>" alt=""></span>
                <?php
        }
?>
               </div>
    
    <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_text_0">
                
                
                <div class="et_pb_text_inner">
					
                    <h3 class="video-title"><a href="<?php the_permalink(); ?>"><?php
        echo get_the_title();
?></a></h3><span class="video-author"><?php
        echo the_author_meta('display_name', $postData[0]->post_author);
?></span> | <span class="video-votes"> Votes
                </span></div>
            </div> <!-- .et_pb_text -->
    </div>
            <?php
    endwhile;
?>
       </div>
    <?php
endif;
?>
   <div class="loadmore">Load More...</div>
</div>

<script type="text/javascript">
var ajaxurl = "<?php
echo admin_url('admin-ajax.php');
?>";
var page = 2;
jQuery(function($) {
    $('body').on('click', '.loadmore', function() {
        var data = {
            'action': 'load_posts_by_ajax',
            'page': page,
            'security': '<?php
echo wp_create_nonce("load_more_posts");
?>'
        };

        $.post(ajaxurl, data, function(response) {
if(response != '') {
$('.my-posts').append(response);
page++;
} else {
$('.loadmore').hide();
}
        });
    });
});
</script>