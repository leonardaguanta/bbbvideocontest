<?php


$videoViewsTimeFrame = '';
	 if(isset($_GET['videoViewsTimeFrame'])) {
		if($_GET['videoViewsTimeFrame'] == 'month') {
                        $_SESSION['videoViewsTimeFrame'] = 'month';
                } elseif($_GET['videoViewsTimeFrame']=='week') {
                        $_SESSION['videoViewsTimeFrame'] = 'week';
                } else  {
                        $_SESSION['videoViewsTimeFrame'] = 'day';
                }
        }

	$ga = new Platypus_GA();
        $analytics = $ga->getService();
        $profile = $ga->getFirstProfileId($analytics);

        $day = 6;
        $dataView='';
	if ($_SESSION['videoViewsTimeFrame'] == 'week') {
		$day = 6;
        	while($day>=0) {
                	$date = date('Y-m-d', strtotime("-$day days"));
                	$dayOfTheWeek = date('l', strtotime("-$day days"));
                	if($dayOfTheWeek=='Thursday') {
                	        $dayString = "TH";
                	} else {
                	        $dayString = substr($dayOfTheWeek,0,1);
                	}
                	$results = $ga->getVideoWatchCountPerDateAll($analytics, $profile, $date, $date);
                	$rows = $results->getRows();
                	$videoViews = $rows[0][1];
                	if(!$videoViews) {
                	        $videoViews = "0";
			}
                	$day--;
        	        $dataView .= "[\"$dayString\", $videoViews],";
        	}
	} elseif ($_SESSION['videoViewsTimeFrame'] == 'month') {
		$day = 30;
                while($day>=0) {
                        $date = date('Y-m-d', strtotime("-$day days"));
                        $dayOfTheMonth = date('d', strtotime("-$day days"));
                        $results = $ga->getVideoWatchCountPerDateAll($analytics, $profile, $date, $date);
                        $rows = $results->getRows();
                        $videoViews = $rows[0][1];
                        if(!$videoViews) {
                                $videoViews = "0";
                        }
                        $day--;
                        $dataView .= "[\"$dayOfTheMonth\", $videoViews],";
                } 
	} else {
		$results = $ga->getVideoWatchCountHourlyAll($analytics, $profile);
                $rows = $results->getRows();


                if(!$videoViews) {
                	$videoViews = "0";
                }
		$hours = date('g A', strtotime("-24 hours"));
		$countUp = 1;
		foreach ($rows as $hour => $videoViews ) {
			$dataView .= "[\"$hours\", $videoViews[1]],";
			$hours = date('g A', strtotime("+$countUp hour " ));
			$countUp++;
		}
	}
        $dataView = rtrim($dataView, ",");
        $output = ' 
       <div class="header-tab">VIDEO VIEWS</div>
		<script>
                                google.setOnLoadCallback(drawChart);
                                function drawChart() {
                                        var data = google.visualization.arrayToDataTable([
                                                ["days", "Views" ],
                                                '.$dataView.'
                                        ]);
                                var options = {
                                        hAxis: {titleTextStyle: {color: "#333"}},
                                        vAxis: {minValue: 0},
                                        legend: {position: "none"} 
                                };
        
                                var chart = new google.visualization.AreaChart(document.getElementById("videoViews"));
                        	chart.draw(data, options);
			}
		</script>
		<div class="typicalContainer">
			<div id="videoViews" style="width: 430px; height: 200px;"></div>
			<a href="" id="videoViewsday" class="sortStatsButton " onclick="statsSorting(\'videoViewsTimeFrame=day\')">Day</a><a href="" id="videoViewssweek" class="sortStatsButton" onclick="statsSorting(\'videoViewsTimeFrame=week\')">Week</a><a href="" id="videoViewsmonth" class="sortStatsButton" onclick="statsSorting(\'videoViewsTimeFrame=month\')">Month</a>
		</div>
        ';
        
        echo $output;
?>