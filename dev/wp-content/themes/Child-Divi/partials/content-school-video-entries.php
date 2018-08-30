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
	if ($posts) {
            $output .=
                '
                <div class=" et_pb_row et_pb_row_1 school-video-row with-scroll">
		            <div class="et_pb_column et_pb_column_4_4  et_pb_column_2 et_pb_css_mix_blend_mode_passthrough">            
                ';
		foreach ($posts as $school) {
			$output .= 
				'
				<div class="et_pb_blurb et_pb_module et_pb_bg_layout_light et_pb_text_align_left school-video-entry et_pb_blurb_0 et_pb_blurb_position_left">
					<div class="et_pb_blurb_content">
                        <div class="et_pb_main_blurb_image">
                            <span class="et_pb_image_wrap">
                                <img src="'.get_field('school_logo', $school->ID ).'" alt="'.$school->post_title.'" class="et-waypoint et_pb_animation_off">
                            </span>
                        </div>

                        <div class="et_pb_blurb_container">
                            <h4 class="et_pb_module_header">'.$school->post_title.'</h4>
                            <div class="et_pb_blurb_description">
                                <p>'.$school->count.' Video Entries</p>
                            </div>
					    </div>
					</div>
				</div>
				';
        }
            $output .=
                '
                    </div>
                </div>
                ';
	}
       echo $output;


?>