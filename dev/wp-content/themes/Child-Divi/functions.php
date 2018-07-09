<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}

 add_shortcode( 'shortcodeschool', 'display_custom_post_type' );

    function display_custom_post_type(){

        $args = array( 'post_type' => 'student_schools',  'post_status' => 'publish','order'=>'ASC' );
$loop = new WP_Query( $args );
 if ( $loop->have_posts() && !(is_admin()) ) :
        while ( $loop->have_posts() ) : $loop->the_post(); ?>
            <div class="pindex">
                            <div class="plogo">
                  <?php if( get_field('school_logo') ): ?>

	<img src="<?php the_field('school_logo'); ?>" />

<?php endif; ?>
                </div>
                                <div class="ptitle">
                    <h2><?php echo get_the_title(); ?></h2>
                </div>
                <?php if ( has_post_thumbnail() ) { ?>
                    <div class="pimage">
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                    </div>
                <?php } ?>

                <div class="pexcerpt">
                    <p><?php echo the_excerpt(); ?></p>
                </div>
                    <div class="readamore">
                    <a href="<?php echo get_post_permalink(); ?>">Show more</a>

                </div>
            </div>
        <?php endwhile;

    endif;
    wp_reset_postdata();



    }
?>