<?php if ( 'on' == et_get_option( 'divi_back_to_top', 'false' ) ) : ?>

    <span class="et_pb_scroll_top et-pb-icon"></span>

<?php endif;

if ( ! is_page_template( 'page-template-blank.php' ) ) : ?>

<footer id="main-footer">
    <?php get_sidebar( 'footer' ); ?>


    <?php
    if ( has_nav_menu( 'footer-menu' ) ) : ?>

    <div id="et-footer-nav">
        <div class="container">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'footer-menu',
                'depth'          => '1',
                'menu_class'     => 'bottom-nav',
                'container'      => '',
                'fallback_cb'    => '',
                ) );
                ?>
            </div>
        </div> <!-- #et-footer-nav -->

    <?php endif; ?>

    <div id="footer-bottom">
        <div class="container clearfix">
            <?php
            if ( false !== et_get_option( 'show_footer_social_icons', true ) ) {
                get_template_part( 'includes/social_icons', 'footer' );
            }
            ?>

            <div>
                <?php
                if( current_user_can('administrator') ) {?>
                <p id="copyright"><a href="/privacy-policy">Privacy Policy</a>&nbsp;|&nbsp;<a href="<?php echo esc_url( home_url( '/bbb-admin-dashboard/' ) ); ?>">BBB Admin Dashboard</a></p>
                <?php
            }?>
            
            <?php
            if( current_user_can('editor') ) {?>
            <p id="copyright"><a href="/privacy-policy">Privacy Policy</a>&nbsp;|&nbsp;<a href="<?php echo esc_url( home_url( '/bbb-admin-dashboard/' ) ); ?>">BBB Admin Dashboard</a></p>
            <?php
        }?>
        <?php
        if( current_user_can('subscriber') ) {?>
        <p id="copyright"><a href="/privacy-policy">Privacy Policy</a>&nbsp;|&nbsp;<a href="<?php echo esc_url( home_url( '/student-home/' ) ); ?>">Dashboard</a></p>
        <?php
    }?>                         
    <?php
    if( !is_user_logged_in() ) {?>
    <p id="copyright"><a href="/privacy-policy">Privacy Policy</a>&nbsp;|&nbsp;<a href="#" class="lrm-login">BBB Admin</a></p>
    <?php
}?>





<p id="createdby">Website Created by  <a title="Platypus Media, Advertising &amp; Design" href="http://www.platypuslocal.com/">PLATYPUS  </a><img alt="Platypus Media, Advertising &amp; Design" src="http://media.platypuslocal.com/images/platypus/platypus_logo_footer.png"><p>
</div>

</div>  <!-- .container -->
</div>
</footer> <!-- #main-footer -->
</div> <!-- #et-main-area -->

<?php endif; // ! is_page_template( 'page-template-blank.php' ) ?>

</div> <!-- #page-container -->

<?php wp_footer(); ?>
<script>
    //Sorting Redirect
    function statsSorting(sortPeriod) {
        var url = window.location.href.split('?')[0];
        var sortedUrl = url + "?" + sortPeriod;
        window.location.href = sortedUrl;
        event.preventDefault();
    }   

    //Visitors Modules Active Button    
    jQuery(document).ready(function () {
        
        
        var upload = "<?php echo $_SESSION['uploadedVideosTimeframe'] ?>";
        var visitor = "<?php echo $_SESSION['visitorsTimeFrame'] ?>";
        
        if(upload.length > 1){
            selectedBtn = "<?php echo $_SESSION['uploadedVideosTimeframe'] ?>";
            //jQuery('#visitors'+selectedBtn).addClass('activeBtn');
            jQuery('#uploadedvideos'+selectedBtn).addClass('activeBtn');

        }
        if(visitor.length > 1){
            
            var selectedBtn = "<?php echo $_SESSION['visitorsTimeFrame'] ?>";
            jQuery('#visitors'+selectedBtn).addClass('activeBtn');
                        //jQuery('#uploadedvideos'+selectedBtn).addClass('activeBtn');


                    }
                });

    jQuery('#advertiserSelect').change( function() {
        window.location.href='?advertiser=' + jQuery(this).val();
    });

</script>

</body>
</html>

