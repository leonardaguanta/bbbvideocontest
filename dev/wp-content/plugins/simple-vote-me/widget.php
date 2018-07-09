<?php

/** Snippet [simple-vote]**/
    function gt_shortcode_simplevoteme($atributos){
        $atts = shortcode_atts( array(
                    'type' => 'h',
                ), $atributos);

        //$login = get_option('gt_simplevoteme_only_login');

        //if( $login && !is_user_logged_in() )
        //    return('');
     //     $vote_2 = get_post_meta($post_ID, '_simplevotemevotes_2', true) != "" ? get_post_meta($post_ID, '_simplevotemevotes_2', true) : 0;
        if($atributos['postid']) {
                $voteme = gt_simplevoteme_getvotelink(0, $atts["type"], $atributos['postid']);
        } else {
                $voteme = gt_simplevoteme_getvotelink(0, $atts["type"]);
        }
        ob_start();
            echo $voteme;
        return ob_get_clean();

    }
    add_shortcode ('simplevoteme', 'gt_shortcode_simplevoteme');

    function gt_shortcode_simplevoteme_votes($atributos) {
        
        if($atributos['postid']) {
            $post_ID = $atributos['postid'];
        } else {
            $post_ID = get_the_ID();
        }
        if(!$post_ID) {
            $html = "0";
        } else {
/*            $votes = get_post_meta($post_ID, '_simplevotemevotes', true) != "" ? get_post_meta($post_ID, '_simplevotemevotes', true) : array('positives' => array());
            $vote_2 = get_post_meta($post_ID, '_simplevotemevotes_2', true) != "" ? get_post_meta($post_ID, '_simplevotemevotes_2', true) : array(
                'positives' => array() , //id users array
            );
            $vote_3 = get_post_meta($post_ID, '_simplevotemevotes_3', true) != "" ? get_post_meta($post_ID, '_simplevotemevotes_3', true) : array(
                'positives' => array() , //id users array
            );
            $votemePositive = count($votes['positives']) + count($vote_2['positives']) + count($vote_3['positives']);
            if ( ! add_post_meta( $post_ID, '_vid_liked', $votemePositive, true ) ) {
                update_post_meta( $post_ID, '_vid_liked', $votemePositive );
            }
            $html = $votemePositive; */
global $wpdb;

            $votemePositive = get_post_meta($post_ID, 'len_simplevotemevotes', true);
          //  $results = $wpdb->get_results("SELECT count(vote_id) as votes from $wpdb->pl_votes_new where post_id = $post_ID");
           //$results = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->pl_votes_new" );
  //$results = $wpdb->get_results("SELECT COUNT(*) FROM $wpdb->pl_votes_new");
   //         $results= $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->pl_votes_new where post_id = $post_ID");

 // print_r($results); 

//$results = $wpdb->get_results("SELECT post_id FROM $wpdb->pl_votes_new WHERE vote_id = 1");
//print_r(array_values($results)); 
//$array = array("size" => "XL", "color" => "gold");
//print_r(array_values($array));


/*

$result = $wpdb->get_results ( "
    SELECT * 
    FROM  $wpdb->pl_votes_new
        where post_id = $post_ID
" );

foreach ( $result as $page )
{
   print_r ($page->ip_address);
   }

*/

$votes = 0;
foreach( $wpdb->get_results("SELECT * FROM pl_votes_new WHERE post_id = $post_ID;") as $key => $row) {
    // each column in your row will be accessible like this
   //print_r ($row->ip_address);
   $votes++;
}
//print_r ($votes);

  

             $html = $votemePositive+$votes;
 if ( ! add_post_meta( $post_ID, '_vid_liked', $votemePositive+$votes, true ) ) {
                update_post_meta( $post_ID, '_vid_liked', $votemePositive+$votes );
            }

}
        return $votemePositive+$votes;
    }

    add_shortcode ('simplevoteme_votes', 'gt_shortcode_simplevoteme_votes');

    //Order by total votes
    function gt_simplevoteme_get_highest_voted_posts($numberofpost){
        $output = '';
        $the_query = new WP_Query( 'meta_key=_simplevotemetotal&amp;orderby=meta_value_num&amp;order=DESC&amp;posts_per_page='.$numberofpost );
        // The Loop
        while ( $the_query->have_posts() ) : $the_query->the_post();
        $output .= '<li>';
        $output .= '<a href="'.get_permalink(). '" rel="bookmark">'.get_the_title().'('.get_post_meta(get_the_ID(), '_simplevotemetotal', true).')'.'</a> ';
        $output .= '</li>';
        endwhile;
        wp_reset_postdata();
        return $output;
    }


    //widget Ranking
    class GTSimpleVoteMeTopVotedWidget extends WP_Widget {

        function GTSimpleVoteMeTopVotedWidget() {
            // widget actual processes
            $widget_ops = array('classname' => 'GTSimpleVoteMeTopVotedWidget', 'name' =>'Ranking Simple Vote me', 'description' => 'Widget for top voted Posts.' );
            $this->WP_Widget('GTSimpleVoteMeTopVotedWidget','GTSimpleVoteMeTopVotedWidget', $widget_ops);
        }
        function form($instance) {
            // outputs the options form on admin
            $defaults = array( 'title' => 'Top Voted Posts', 'numberofposts' => '5' );
            $instance = wp_parse_args( (array) $instance, $defaults );

            ?>
            <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo 'Title:'; ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
            </p>
            <p>
            <label for="<?php echo $this->get_field_id( 'numberofposts' ); ?>"><?php echo 'Number of Posts'; ?></label>
            <input id="<?php echo $this->get_field_id( 'numberofposts' ); ?>" name="<?php echo $this->get_field_name( 'numberofposts' ); ?>" value="<?php echo $instance['numberofposts']; ?>" class="widefat" />
            </p>

            <?php

        }

        function update($new_instance, $old_instance) {
            // processes widget options to be saved

            $instance = $old_instance;
            $instance['title'] = strip_tags( $new_instance['title'] );
            $instance['numberofposts'] = $new_instance['numberofposts'];
            return $instance;
        }

        function widget($args, $instance) {
            // outputs the content of the widget
            extract( $args );
            $title = apply_filters('widget_title', $instance['title'] );
            echo $before_widget;
            if ( $title )
            echo $before_title . $title . $after_title;

            echo '<ul>';
            echo gt_simplevoteme_get_highest_voted_posts($instance['numberofposts']);
            echo '</ul>';
            echo $after_widget;
        }

}

    function gt_simplevoteme_ranking_widget_init() {

        // Check for the required API functions
        if ( !function_exists('register_widget') )
        return;

        register_widget('GTSimpleVoteMeTopVotedWidget');
    }

    add_action('widgets_init', 'gt_simplevoteme_ranking_widget_init');



    //widget Vote
    class GTSimpleVoteMeWidget extends WP_Widget {

        function GTSimpleVoteMeWidget() {
            // widget actual processes
            $widget_ops = array('classname' => 'GTSimpleVoteMeWidget', 'name' =>'Simple Vote me Widget', 'description' => 'Widget for vote Posts.' );
            $this->WP_Widget('GTSimpleVoteMedWidget','GTSimpleVoteMeWidget', $widget_ops);
        }
        function form($instance) {
            // outputs the options form on admin
            $defaults = array( 'title' => 'Vote me!', 'type' => 'v' );
            $instance = wp_parse_args( (array) $instance, $defaults );

            ?>
            <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo 'Title:'; ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
            </p>
            <p>
            <label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php echo __('Type of Widget'); ?></label>
            <select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" class="widefat" >
            <option value="v" <?php if ($instance['type'] == "v") echo "selected"; ?>><?php echo __('Vertical'); ?></option>
            <option value="h" <?php if ($instance['type'] == "h") echo "selected"; ?>><?php echo __('Horizontal'); ?></option>
            </select>
            </p>

            <?php

        }

        function update($new_instance, $old_instance) {
            // processes widget options to be saved

            $instance = $old_instance;
            $instance['title'] = strip_tags( $new_instance['title'] );
            $instance['type'] = $new_instance['type'];
            return $instance;
        }

        function widget($args, $instance) {
            // outputs the content of the widget
            extract( $args );
            $title = apply_filters('widget_title', $instance['title'] );
            echo $before_widget;
            if ( $title )
            echo $before_title . $title . $after_title;

            echo do_shortcode('[simplevoteme type="'. $instance['type'] .'"]');

            echo $after_widget;
        }

}

    function gt_simplevoteme_widget_init() {

        // Check for the required API functions
        if ( !function_exists('register_widget') )
        return;

        register_widget('GTSimpleVoteMeWidget');
    }

    add_action('widgets_init', 'gt_simplevoteme_widget_init');

