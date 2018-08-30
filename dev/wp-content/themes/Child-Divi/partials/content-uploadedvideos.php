<?php


        if(isset($_GET['uploadedVideosTimeFrame'])) {

                if($_GET['uploadedVideosTimeFrame'] == 'month') {
                        $_SESSION['uploadedVideosTimeframe'] = 'month';
                } elseif($_GET['uploadedVideosTimeFrame']=='week') {
                        $_SESSION['uploadedVideosTimeframe'] = 'week';
                } else  {
                        $_SESSION['uploadedVideosTimeframe'] = 'day';
                }

        }

	if ($_SESSION['uploadedVideosTimeframe'] == 'month') {
		$dateQuery = "30 days ago";
	} elseif ($_SESSION['uploadedVideosTimeframe'] == 'week') {
		$dateQuery = "7 days ago";
	} else {
		$dateQuery = "1 day ago";
	}
	$args = array(
                'post_type'      => 'flowplayer5',
		'post_status'    => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash'),
		'date_query'	 => array('after' => $dateQuery),
                'posts_per_page' => -1

        );

	$totalUploadedVids = '0';
	$approvedUploadedVideos = '0';
	$rejectedUploadedVideos = '0';
	$pendingUploadedVideos = '0';
        $posts = get_posts( $args );

	foreach ($posts as $video) {
		$totalUploadedVids++;
		if ($video->post_status == 'publish' ) {
			$approvedUploadedVideos++;
		}
		if ($video->post_status == 'pending' || $video->post_status == 'draft'  ) {
                        $pendingUploadedVideos++;
                }
		if ($video->post_status == 'trash') {
                        $rejectedUploadedVideos++;
                }
	}


        $output =
        '
        <div class="header-tab-3 clearfix"><p class="header-tab-3-total">Total Videos Uploaded: '. $totalUploadedVids .'</p> </div>
        <div class="typicalContainer style="overflow: visible !important;">
            <script>
                google.setOnLoadCallback(drawChartUploads);
                    function drawChartUploads() {
                        var dataNVR = google.visualization.arrayToDataTable([
                            ["Type", "Views"],
                            ["Approved Videos",  '.$approvedUploadedVideos.'],
                            ["Rejected Videos", '.$rejectedUploadedVideos.'],
                            ["Pending Approval", '.$pendingUploadedVideos.']
                        ]);
                        var optionsNVR = {
                            title: "",
                                width: 400,
								height:185
                        };
                        var chartNVR = new google.visualization.PieChart(document.getElementById("uploadStats"));
                        chartNVR.draw(dataNVR, optionsNVR);
                    }
            </script>
            <div id="uploadStats" style="text-align: center;"></div>
            <div class="videoViews-container">
                <a href="" id="uploadedvideosday" class="sortStatsButton " onclick="statsSorting(\'uploadedVideosTimeFrame=day\')">Day</a><a href="" id="uploadedvideosweek" class="sortStatsButton" onclick="statsSorting(\'uploadedVideosTimeFrame=week\')">Week</a><a href="" id="uploadedvideosmonth" class="sortStatsButton" onclick="statsSorting(\'uploadedVideosTimeFrame=month\')">Month</a>
            </div>
        </div>
        ';
        
        echo $output;
        





?>