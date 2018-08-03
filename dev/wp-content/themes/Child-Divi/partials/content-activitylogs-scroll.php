
<?php

global $wpdb;
  $rows = $wpdb->get_results( "SELECT * FROM pl_ualp_user_activity ORDER BY uactid DESC" );  
        function timeSince($time) {     
                $time = time() - $time; // to get the time since that moment
                $time = ( $time < 1 ) ? 1 : $time;
                $tokens = array (
                        31536000 => 'year',
                        2592000 => 'month',
                        604800 => 'week',
                        86400 => 'day',
                        3600 => 'hour',
                        60 => 'minute',
                        1 => 'second'
                );
            
            foreach ($tokens as $unit => $text) {
                if ($time < $unit) continue;
                $numberOfUnits = floor($time / $unit);
                return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
            }
            
        }
        
  $output =
        '
            <div class="activity-container">
        
                <div class="activityLogList">
        ';
        foreach ($rows as $row) {
    if ( ($row->action == "flowplayer5 deleted") || ($row->action == "insert comment") || ($row->action == "flowplayer5 updated")) {
            $loggedUser = $row->user_name;
      $loggedTime = $row->modified_date;
      $loggedAction = $row->action;
      if ($loggedAction == "flowplayer5 deleted") {
        $loggedAction = "deleted a video";
      }
      if ($loggedAction == "flowplayer5 updated") {
                          $loggedAction = "uploaded a video";
                  }
      if ($loggedAction == "insert comment") {
                          $loggedAction = "made a comment";
                  }
      $loggedType = $row->object_type;
                  if ($loggedType == "flowplayer5") {
                      $actionClass = 'uploadActivity';
                  } elseif ($loggedType == "comment") {
                      $actionClass = 'commentActivity';
                  } else {
                        $actionClass = 'passActivity';
                  }

            $time = strtotime($loggedTime);
                $thePostTime = date("d F Y", $time);
            $output .=
            '
            <div class="et_pb_blurb et_pb_module et_pb_bg_layout_light et_pb_text_align_left user-log et_pb_blurb_0 et_pb_blurb_position_left">
                <div class="et_pb_blurb_content">
                    <div class="et_pb_main_blurb_image">
                        <span class="et_pb_image_wrap">
                            <div class="et-waypoint et_pb_animation_off">
                                <p class="user">'.$loggedUser.'</p>
                                <p class="timeStamp">'.$thePostTime.'</p>
                            </div>
                        </span>
                    </div>
                    <div class="et_pb_blurb_container">
                        <h4 class="et_pb_module_header">'.$loggedAction.' '.timeSince($time).' ago</h4>
                        <div class="et_pb_blurb_description">
                        </div>
                    </div>
                </div>
            </div>
            ';
    }
        }

        $output .=
        '
        </div>
        </div>
        ';
        echo $output;
?>