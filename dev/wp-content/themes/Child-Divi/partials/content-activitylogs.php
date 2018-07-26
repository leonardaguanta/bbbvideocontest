
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
        <div class="header-tab">Activity Log</div>
            <div class="limitlessContainer">
        
                <ul class="activityLogList">
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
            <img class="listImage" src="http://platypus-dallas.s3.amazonaws.com/wp-content/uploads/2015/09/29201730/listImg.png">
            <li class="activityLogAction '.$actionClass.' "><span class="timeStamp">'.$thePostTime.'</span><span>'.$loggedUser.' '.$loggedAction.' '.timeSince($time).' ago</span></li>
            ';
    }
        }

        $output .=
        '
        </ul>
        </div>
        ';
        echo $output;
?>