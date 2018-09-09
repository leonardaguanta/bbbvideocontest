<?php /* Template Name: BBB Admin Videos Approved */ ?>

<?php get_header(); 
    add_filter('show_admin_bar', '__return_false');
    echo "<link rel='stylesheet' id='flowplayer5-skins-css' href='https://releases.flowplayer.org/5.5.2/commercial/skin/all-skins.css' type='text/css' media='all' />";
    echo "<link rel='stylesheet' id='flowplayer5-logo-origin-css' href='https://d3vzs1kv29k6gk.cloudfront.net/dallas/wp-content/plugins/flowplayer5/frontend/assets/css/public-concat.min.css?x75485' type='text/css' media='all' />";
    echo "<script type='text/javascript' src='http://www.bbbvideocontest.org/dallas/wp-includes/js/jquery/jquery.js?ver=1.11.3'></script>";
    echo "<script type='text/javascript' src='http://www.bbbvideocontest.org/dallas/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>";
    echo "<script type='text/javascript' src='https://d3vzs1kv29k6gk.cloudfront.net/dallas/wp-content/plugins/flowplayer5/frontend/assets/flowplayer/flowplayer.js?x75485'></script>";
    // echo "<script src='http://bbbvideocontest.platypustest.info/dev/wp-includes/js/zxcvbn.min.js' type='text/javascript'></script><script src='//w.likebtn.com/js/w/widget.js'></script><script src='//w.likebtn.com/js/w/widget.js'></script>";
    echo "<link rel='stylesheet' id='simplevotemestyle-css' href='http://bbbvideocontest.platypustest.info/dev/wp-content/plugins/simple-vote-me/css/simplevoteme.css?ver=4.9.6' type='text/css' media='all'>";

    echo '<script type="text/javascript">
        /* <![CDATA[ */
        var gtsimplevotemeajax = {"ajaxurl":"http:\/\/bbbvideocontest.platypustest.info\/dev\/wp-admin\/admin-ajax.php"};
        /* ]]> */
        </script>';
    echo '<script type="text/javascript" src="http://bbbvideocontest.platypustest.info/dev/wp-content/plugins/simple-vote-me/js/simple-vote-me.js?ver=4.9.6"></script>';
?>
<?php
    $logo = ( $user_logo = et_get_option( 'divi_logo' ) ) && '' != $user_logo ? $user_logo : $template_directory_uri . '/images/logo.png';
?>
<?php get_template_part( 'partials/content', 'header' ); ?>

    <div class="content-wrapper admin-wrapper">
        <div class="container-fluid admin-fluid">
            <div class="row logo">
                <div class="col-lg-2">
                    <div class="card mb-3">
                        <a class="" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" id="logo" data-height-percentage="<?php echo esc_attr( et_get_option( 'logo_height', '54' ) ); ?>" />
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">Approved Videos</div>

			
<?php


                global $post;
        $args = array(
            'post_type' => 'flowplayer5',
            'posts_per_page' => -1,
            'public' => true,
            'post_status' => 'publish, draft'
        );
        $posts = get_posts($args);
        if ($posts) {
                $theVideo = '<div class="approved-vid-container">';
            foreach($posts as $postVideo) {
                $extra_video_info = get_post_meta($postVideo->ID);
                $theVideo .= '      <div class="main-container2 no-border">
                                    <div class="row-one">

                                        <div class="main-video">';

                $theVideo .= do_shortcode('[flowplayer id="'.$postVideo->ID.'" pre-post-ad-video=1 autoplay="false" preload="auto]');
                $theVideo .= '          </div>

                                    <div class="main-video-info">';
                  $theVideo .= '              <h3>' .$postVideo->post_title. '</h3>';
                  $theVideo .= '              <p><span class="yellow">Owner: </span>' .$user_data->data->display_name. '</p>';
                  $theVideo .= '              <p><span class="yellow">Date Published: </span>' .get_the_date("F j, Y", $postVideo->ID). '</p>';
                  $theVideo .= '              <p><span class="yellow">School:</span>  '.$school_name.'</p>
                                        <p class="rejected"><span class="yellow">Status: </span>Approved</p>';
                  $theVideo .= '              <p class="vid-desc"><span class="yellow">Info: </span>'.wp_trim_words($extra_video_info['fp5-video-description'][0],60).'</p>

                                        <div class="row-one boxshadow custom-mrgbtm">
                                                <a href="#" class="video-activate '. $video_status .'" onclick="videoActivate(this, '. $postVideo->ID .');">
                                                        <div class="col-one icon-width">
                                                                <span class="icon"></span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 38 38" stroke="#1C7593" id="small-preloader" style="display: none; margin: 6px auto 0;"><g fill="none" fill-rule="evenodd"><g transform="translate(1 1)" stroke-width="2"><circle stroke-opacity=".5" cx="18" cy="18" r="18"></circle><path d="M36 18c0-9.94-8.06-18-18-18" transform="rotate(72 18 18)"><animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"></animateTransform></path></g></g></svg>
                                                        </div>
                                                        <div class="col-two icon-desc"> 
                                                                <span>'. $video_status_btn .'</span>
                                                        </div>
                                                </a>
                                        </div>

                                        <div class="row-one boxshadow custom-mrgbtm">
                                            <div class="col-one icon-width">
                                                <a href="' .get_delete_post_link($postVideo->ID). '"><img class="aligncenter size-full wp-image-1253" src="'. get_stylesheet_directory_uri() .'/img/icon_trash_bin.svg" alt="bbb-view" width="22" height="16" /></a>
                                            </div>

                                            <div class="col-two icon-desc">
                                                <a class="delete-video-prompt video-info-buttons video-icon" href="' .get_delete_post_link($postVideo->ID). '">REMOVE VIDEO</a>
                                            </div>
                                        </div>

          <div class="row-one boxshadow custom-mrgbtm">
                                            <div class="col-one icon-width">
                                                <a class="thickbox" href="#TB_inline?height=680&width=650&inlineId=ApprovedVideoStatPopup_'.$postVideo->ID.'"><img class="aligncenter size-full wp-image-1253" src="//platypus-dallas.s3.amazonaws.com/wp-content/uploads/2015/11/05033712/stats.png" alt="bbb-view" width="22" height="16" /></a>
                                            </div>

                                            <div class="col-two icon-desc">
                                                <a class="video-info-buttons video-icon thickbox" href="#TB_inline?height=680&width=650&inlineId=ApprovedVideoStatPopup_'.$postVideo->ID.'">VIEW STATISTICS</a>
                                            </div>
                                        </div>

                                        <div class="row-one boxshadow custom-mrgbtm">
                                            <div class="col-one icon-width">
                                                <a href="http://platypus-dallas.s3.amazonaws.com/wp-content/uploads/2015/08/28064659/message-icon.png"><img class="aligncenter size-full wp-image-1195" src="//platypus-dallas.s3.amazonaws.com/wp-content/uploads/2015/08/28064659/message-icon.png" alt="message-icon" width="22" height="16" /></a>
                                            </div>

                                            <div class="col-two icon-desc">
                                                <a class="video-info-buttons video-icon thickbox" href="TB_inline?height=680&width=650&inlineId=approvedSendEmail-'.$postVideo->ID.'">SEND MESSAGE </a>
                                            </div>
                                           <div id="approvedSendEmail-' . $postVideo->ID  .  '" style="display:none;">'. do_shortcode('[gravityform id="21" title="false" field_values="email='.$user_data->data->user_email.'"]') . '</div>
                                        </div>
                                </div>
        </div>';
        var_dump(videoStatsDisplay($postVideo));
          $theVideo .= videoStatsDisplay($postVideo);
            $theVideo .= '</div>';
              }

              $theVideo .= '</div>';
              echo $theVideo;
          } else {
        $output .= "<div class='pending-vid-container'>";
                    $output .= "<div class='vid-upload-btn'>";
                    $output .= "<h2>No approved video entries yet</h2>";
                    $output .= "</div>";
                    $output .= "</div>";
                    echo $output; 
      }

      


function videoStatsDisplay($postVideo) {
  $comments = wp_count_comments( $postVideo->ID );

  $extra_video_info = get_post_meta($postVideo->ID);
  $videoName = $extra_video_info['fp5-mp4-video'][0];
  $videoName = basename($videoName, ".mp4");
  
  $ga = new Platypus_GA();
  $analytics = $ga->getService();
  $profile = $ga->getFirstProfileId($analytics);
  
  try {
    $day = 6;
    $dataView='';
    $lowestValue = array();
    $highestValue = array();
    while($day>=0) {
      $date = date('Y-m-d', strtotime("-$day days"));
      $dayOfTheWeek = date('l', strtotime("-$day days"));
      if($dayOfTheWeek=='Thursday') {
        $dayString = "TH";
      } else {
        $dayString = substr($dayOfTheWeek,0,1);
      }
      $results = $ga->getVideoWatchCountPerDate($analytics, $profile, $videoName, $date, $date);
        $rows = $results->getRows();
        $videoViews = $rows[0][1];
        if(!$videoViews) {
          $videoViews = "0";
        }
      $day--;
      if(empty($lowestValue)) {
        $lowestValue = array('day' => $dayOfTheWeek, 'view' => $videoViews);
      } elseif($lowestValue['view']>=$videoViews) {
        $lowestValue = array('day' => $dayOfTheWeek, 'view' => $videoViews);
      }

      if(empty($highestValue)) {
        $highestValue = array('day' => $dayOfTheWeek, 'view' => $videoViews);
      } elseif($highestValue['view']<=$videoViews) {
        $highestValue = array('day' => $dayOfTheWeek, 'view' => $videoViews);
      }
      $dataView .= "[\"$dayString\", $videoViews],";
    }
    $dataView = rtrim($dataView, ",");

    // New vs Returning
    $results = $ga->getVideoNewVsReturningCount($analytics, $profile, str_replace(home_url(), '', get_permalink( $postVideo->ID )));
      $rows = $results->getRows();
    if($rows[0][0]=='New Visitor') {
          $newVisitorData = $rows[0][1];
      } elseif($rows[0][0]=='Returning Visitor') {
          $returnVisitorData = $rows[0][1];
      }
      if($rows[1][0]=='New Visitor') {
          $newVisitorData = $rows[1][1];
      } elseif($rows[1][0]=='Returning Visitor') {
          $returnVisitorData = $rows[1][1];
      }
    if(!$newVisitorData) {
      $newVisitorData = 0;
    }
    if(!$returnVisitorData) {
          $returnVisitorData = 0;
      }

    // Average View Duration
    $results = $ga->getVideoWatchAvgDuration($analytics, $profile, $videoName);
    $rows = $results->getRows();
    $avgDuration = $rows[0][1];
    $output = '
        <div id="ApprovedVideoStatPopup_'.$postVideo->ID.'" style="display: none;">
          <div class="main-container">
              <div class="row-one student-video-row">
                  <div class="col-one">
                      <div class="vid-chart">
            <div id="chart_div_'.$postVideo->ID.'" style="width: 244px; height: 158px;"></div>
                          <script>
                          google.setOnLoadCallback(drawChart);
                          function drawChart() {
                  var data = google.visualization.arrayToDataTable([
                                    ["days", "Views" ],
                    '.$dataView.'
                                ]);
                  var options = {
                                  hAxis: {titleTextStyle: {color: "#333"}},
                                  vAxis: {viewWindow:{min:0}},
                    chartArea:{ left: "10%", top: "5%", width: "87%", height: "85%" },
                    height: 158,
                    width: 244,
                                  legend: {position: "none"}
                              };
                              var chart = new google.visualization.AreaChart(document.getElementById("chart_div_'.$postVideo->ID.'"));
                              chart.draw(data, options);
                          }
                    </script>
                        </div>
                        <div class="vid-stats">
                          <p><span class="yellow">HIGHEST:<br>
                          </span>'.$highestValue['view'].' views('.$highestValue['day'].')</p>
                          <p><span class="yellow">LOWEST:<br>
                          </span>'.$lowestValue['view'].' views('.$lowestValue['day'].')</p>
                        </div>
                    </div>
                    <div class="col-two">
                      <table class="custom-table-video">
                          <tbody>
                              <tr>
                                <td class="likes">'.do_shortcode('[simplevoteme_votes postId='.$postVideo->ID.']').' total votes</td>
                                <td class="shares">0 total shares</td>
                              </tr>
                              <tr>
                                <td class="views">'. get_post_meta($postVideo->ID, '_custom_video_view', true) /*do_shortcode('[show-video-watch-count postId='.$postVideo->ID.']')*/ .' total views</td>
                                <td class="comments">'.$comments->approved.' total comments</td>
                              </tr>
                          </tbody>
                        </table>
                    </div>
            </div>
                <div class="row-one student-video-row">
                  <div class="col-one">
                        <div class="col-one pie-col-one">
                          <div class="piechart" id="piechart_'.$postVideo->ID.'">
                          </div>
              <script type="text/javascript">
                  google.load("visualization", "1", {packages:["corechart"]});
                  google.setOnLoadCallback(drawChart);
                  function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                      ["Type", "Views"],
                      ["New Views",   '.$newVisitorData.'],
                      ["Returning Views", '.$returnVisitorData.']
                    ]);

                    var options = {
                      title: "New Vs. Returning",
                    width: 320
                    };
                    var chart = new google.visualization.PieChart(document.getElementById("piechart_'.$postVideo->ID.'"));
                    chart.draw(data, options);
                  }
                </script>
                        </div>
                        <!-- <div class="col-two pie-col-two">
                          <div class="view-duration">Avg. View Duration<br>
                              <span class="yellow">00:07:16</span><br>
                              <span class="video-view-graph"><a href="#"><img class="aligncenter size-full wp-image-1232" src="http://platypus-dallas.s3.amazonaws.com/wp-content/uploads/2015/07/28223252/video-view-graph.png" height="26" width="111"></a></span>
                          </div>
                          <div class="new-views">% News Views<br>
                              <span class="yellow">00:07:16</span><br>
                              <span class="video-view-graph"><a href="#"><img class="aligncenter size-full wp-image-1232" src="http://platypus-dallas.s3.amazonaws.com/wp-content/uploads/2015/07/28223252/video-view-graph.png" alt="video-view-graph" height="26" width="111"></a></span>
                          </div>
                        </div> -->

                    </div>
                    <div class="col-two">
                        <div class="col-one dest-col-one">
                          <p class="share-title">VIEW DURATION</p>
              <p> Average Views</p>
              <!-- <p>Less than 10 seconds</p>
              <p>0 - 10 Seconds</p>
              <p>0 - 60 Seconds</p>
              <p>60 - 600 Seconds</p>
              <p>600 - 1801+ Seconds</p>-->
                        </div>
                        <div class="col-two dest-col-two">
                          <p class="destination-url">&nbsp;</p>
              <p>'.number_format($avgDuration,2).'</p>
              <!-- <p>4</p><p>5</p><p>24</p><p>61</p><p>12</p> -->
                        </div>
                    </div>
              </div>
            </div>
        </div>';
    return $output;
    } catch (\Exception $e) { // <<<<<<<<<<< You must use the backslash
        return "<h5 style='margin-top: 10px; text-align: center; font-weight: bold; color: red;'>Google_Service_Exception - Quota Error: has exceeded the daily request limit.</h5>";
    }


  
}


?>
			

        
      </div>
    </div>
    </div>
 
</div>
  <!-- /.container-fluid-->
  <!-- /.content-wrapper-->
  <footer class="sticky-footer">
    <div class="container">
      <div class="text-center">
        <small>Copyright © Your Website 2018</small>
      </div>
    </div>
  </footer>
  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
  </a>
  <!-- Logout Modal-->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
    </div>
</div>
</body>

</html>
<?php get_footer(); ?>