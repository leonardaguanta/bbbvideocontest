<?php
$output = '<div class="header-tab"><p>SCHOOLS</p><a class="dallas-btn thickbox" href="#TB_inline?height=680&amp;width=650&amp;inlineId=NewSchoolPopup" style="top:5px;">NEW</a></div>';


global $current_user;
get_currentuserinfo();
$args = array('post_type' => 'student_schools', 
  'posts_per_page' => -1, 
  'order' => 'DESC');


$myposts = get_posts( $args );
//var_dump($myposts);
$output .= '<div id="NewSchoolPopup" style="display: none;"><h2>New School</h2>';
$output .= '<div id="postbox">';
                       // $output .= do_shortcode('[gravityform id=14]');
$output .= '</div>';
$output .= '</div>';

if ($myposts) {
  $output .= '<div class="get-school"><ul>';

  foreach ( $myposts as $post ) {

/*    $titlecontent = apply_filters('the_content',$post->post_content);
    $theCategory = get_the_category( $post->ID );
    $titlecontent = wp_trim_words($titlecontent, 40);
    $output .= '<img class="s-logo" src="'.get_field('school_logo').'">';
    $output .= <div class="s-title"get_the_title();
    $output .= get_the_excerpt($post->ID);
    $output .= $titlecontent;
    $output .='<div class="file-btns2">';
    $output .= '<a class="thickbox sortStatsButton sample" href="#TB_inline?height=680&amp;width=650&amp;inlineId=NewVideoPopup'.$post->ID.'">Edit Content</a>';
    $output .= wp_delete_post_link('Delete',$post->ID);
    $output .=  wp_view_post_link('View', $post->ID);
    $output .='</div>';
    $output .='</li>';
    $output .= '<div id="NewVideoPopup'.$post->ID.'" style="display: none;">';
    $output .= '<div id="postbox">';
                                   // $output .= do_shortcode('[gravityform id=14 update="'.$post->ID.'"]');
    $output .= '</div>';
    $output .= '</div>';*/

 $titlecontent = apply_filters('the_content',$post->post_content);
    $theCategory = get_the_category( $post->ID );
    $titlecontent = wp_trim_words($titlecontent, 40);

             $output .= '<div class="et_pb_column  et_pb_column_0 et_pb_css_mix_blend_mode_passthrough">                
      <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_text_0 schools-container"> 
        <div class="et_pb_text_inner clearfix">
          <div class="school-logo">' ;

            
              $output .= '<img class="s-logo" src="'.get_field('school_logo').'">';
              $output .= '</div><div class="school-name"><h3>'.get_the_title().'</h3>';
          $output .= '</div>
        </div>
      </div> <!-- .et_pb_text -->            
      <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_text_1">         
        <div class="et_pb_text_inner"><p>'.$titlecontent.'</p>';
          
$output .='<div class="file-btns2">';
    $output .= '<a class="thickbox sortStatsButton sample" href="#TB_inline?height=680&amp;width=650&amp;inlineId=NewVideoPopup'.$post->ID.'">Edit Content</a>';
    $output .= wp_delete_post_link('Delete',$post->ID);
    $output .=  wp_view_post_link('View', $post->ID);
    $output .='</div>';
    $output .='</li>';
    $output .= '<div id="NewVideoPopup'.$post->ID.'" style="display: none;">';
    $output .= '<div id="postbox">';
                                    $output .= do_shortcode('[gravityform id=8 update="'.$post->ID.'"]');
        $output .= '</div>';

    $output .= '</div>';
    $output .= '</div>';




  }
  $output .='</div></div></div></div></div></ul>';

}

echo $output;


?>
