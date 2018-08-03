<?php
	session_start();
 
	if(isset($_GET['visitorsTimeFrame'])) {
	
		if($_GET['visitorsTimeFrame'] == 'month') {
	        	$_SESSION['visitorsTimeframe'] = 'month';
		} elseif($_GET['visitorsTimeFrame']=='week') {
			$_SESSION['visitorsTimeframe'] = 'week';
		} else	{
			$_SESSION['visitorsTimeframe'] = 'day';
		}

	}
$ga = new Platypus_GA();
	$analytics = $ga->getService();
	$profile = $ga->getFirstProfileId($analytics);
	
        try{
                $results = $ga->getResults($analytics, $profile, $_SESSION['visitorsTimeframe']);
                $rows = $results->getRows();
                $sessions = $rows[0][0];
                $pageViews = $rows[0][1];
                $avgTimeOnSite = ceil($rows[0][2] / 60 );
                $percentNewVisits = ceil($rows[0][3]);
                $uniqueVisitors = $rows[0][4];
                $bounceRate  = ceil($rows[0][5]);
                                
                $output =
                '
                <div class="header-tab-2">VISITORS</div>
                        
                <div class="typicalContainer">
                        <table class="visitorsTable">
                        <tbody>
                                <tr class="greyRow vistorsTableRow">
                                <td><span class="visitorInfoTitle">Website Visits</span></td><td><span class="visitorInfoValue">'.$sessions.'</span></td>
                                </tr>
                                <tr class="whiteRow vistorsTableRow">
                                <td><span class="visitorInfoTitle">Unique Visitors</span></td><td><span class="visitorInfoValue">'.$uniqueVisitors.'</span></td>
                                </tr>
                                <tr class="greyRow vistorsTableRow">
                                <td><span class="visitorInfoTitle">Page Views</span></td><td><span class="visitorInfoValue">'.$pageViews.'</span></td>
                                </tr>
                                <tr class="whiteRow vistorsTableRow">
                                <td><span class="visitorInfoTitle">Bounce Rate</span></td><td><span class="visitorInfoValue">'.$bounceRate.'%</span></td>
                                </tr>
                                <tr class="greyRow vistorsTableRow">
                                <td><span class="visitorInfoTitle">% New Visits</span></td><td><span class="visitorInfoValue">'.$percentNewVisits.'%</span></td>
                                </tr>
                                <tr class="whiteRow vistorsTableRow">
                                <td><span class="visitorInfoTitle">Average Time On Site</span></td><td><span class="visitorInfoValue">'.$avgTimeOnSite.' m</span></td>
                                </tr>
                        </tbody>
                        </table>
                        <a href="" id="visitorsday" class="sortStatsButton " onclick="statsSorting(\'visitorsTimeFrame=day\')">Day</a><a href="" id="visitorsweek" class="sortStatsButton" onclick="statsSorting(\'visitorsTimeFrame=week\')">Week</a><a href="" id="visitorsmonth" class="sortStatsButton" onclick="statsSorting(\'visitorsTimeFrame=month\')">Month</a>
                        </div>
                ';
                
                echo $output;
        } catch (\Exception $e) { // <<<<<<<<<<< You must use the backslash
                return "<h5 style='margin-top: 10px; text-align: center; font-weight: bold; color: red;'>Google_Service_Exception - Quota Error: has exceeded the daily request limit.</h5>";
        }
?>