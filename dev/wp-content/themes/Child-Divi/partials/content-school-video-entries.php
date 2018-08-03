<?php

	$args = array(
                'post_type'      => 'student_schools',
                'post_status'    => 'publish',
                'posts_per_page' => -1

        );
    $posts = get_posts( $args );
	foreach($posts as $key => $value) {
		$posts[$key]->count = "0";
	}
		
	$vArgs = array(
                'post_type'      => 'flowplayer5',
                'post_status'    => 'publish',
                'posts_per_page' => -1
        );
 	$vPosts = get_posts( $vArgs );

	$videoDate = array();
	foreach ($vPosts as $video) {
		$userMeta = get_user_meta($video->post_author);
		$schoolID = $userMeta[school][0];
		foreach ($posts as $key => $value) {
			if ($schoolID == $posts[$key]->ID) {
				$posts[$key]->count = $posts[$key]->count + 1;
			}

		}
		$day = 6;
                while($day>=0) {
                        $dateValue = date('Y-m-d', strtotime("-$day days"));
			if(date('Y-m-d',$video->post_date)==$dateValue) {
                        	$videoDate[$day] =  $videoDate[$day]++;
                	}
			$day--;
		}
	}
        $output ='
	
        <div class="typicalContainer">';
	if ($posts) {
		foreach ($posts as $school) {
							$output .= 
				'
				<div class="row-one school-video-entry-row ">
					<div class="col-one school-video-entry-col1" style="width:100px">'.get_the_post_thumbnail( $school->ID ).'</div>
					<div class="col-two school-video-entry-col2">'.get_the_title($school->ID).' has <span class="yellow"> '.$school->count.' video entries</span></div>
				</div>
				';
		}
       		$output .= '</div>';
	}
       echo $output;


?>