<?php



	if(isset($_GET['externalTrafficTimeFrame'])) {

                if($_GET['externalTrafficTimeFrame'] == 'month') {
                        $_SESSION['externalTrafficTimeframe'] = 'month';
                } elseif($_GET['externalTrafficTimeFrame']== 'week') {
                        $_SESSION['externalTrafficTimeframe'] = 'week';
                } else  {
                        $_SESSION['externalTrafficTimeframe'] = 'day';
                }

        }

	$ga = new Platypus_GA();
        $analytics = $ga->getService();
        $profile = $ga->getFirstProfileId($analytics);

        $dataView='';
        if ($_SESSION['externalTrafficTimeframe'] == 'week') {
                $day = 6;
                while($day>=0) {
			$date = date('Y-m-d', strtotime("-$day days"));
                        $dayOfTheMonth = date('d', strtotime("-$day days"));
                        $resultsET = $ga->getExternalTrafficPerDateAll($analytics, $profile, $date, $date);
                        $rowsET = $resultsET->getRows();
                        if ($rowsET[0][0] == 'desktop') {
                                $desktopSessionsET = $rowsET[0][1];

                        } elseif ($rowsET[1][0] == 'desktop') {
                                $desktopSessionsET = $rowsET[1][1];
                        } else {
                                $desktopSessionsET = '0';
                        }
                        if ($rowsET[0][0] == 'mobile') {
                                 $mobileSessionsET = $rowsET[0][1];
                        } elseif ($rowsET[1][0] == 'mobile') {
                                $mobileSessionsET = $rowsET[1][1];
                        } elseif ($rowsET[2][0] == 'mobile') {
                                $mobileSessionsET = $rowsET[2][1];
                        } else {
                                $mobileSessionsET = '0';
                        }
                        if ($rowsET[0][0] == 'tablet') {
                                $tabletSessionsET = $rowsET[0][1];
                        } elseif ($rowsET[1][0] == 'tablet') {
                                $tabletSessionsET = $rowsET[1][1];
                        } elseif ($rowsET[2][0] == 'tablet') {
                                $tabletSessionsET = $rowsET[2][1];
                        } elseif ($rowsET[3][0] == 'tablet') {
                                $tabletSessionsET = $rowsET[3][1];
                        } else {
                                $tabletSessionsET = '0';
                        }

                        $sessionsET = $desktopSessionsET + $mobileSessionsET + $tabletSessionsET;
                        if(!$sessionsET) {
                                $sessionsET = "0";
                        }
                        $dataView .= "[\"$dayOfTheMonth\", $sessionsET],";
                        $resultsETRef = $ga->getExternalTrafficTopReferrers($analytics, $profile, $date, $date);
                        $rowsETRef  = $resultsETRef->getRows();
                        $day--;
                }
                $resultsETRef = $ga->getExternalTrafficTopReferrers($analytics, $profile, '6daysAgo', 'today');
                $rowsETRef  = $resultsETRef->getRows();
                $mVSdResultsET = $ga->getExternalTrafficPerDateAll($analytics, $profile, '6daysAgo', 'today');
                $mVSdRowsET = $mVSdResultsET->getRows();
                if ($mVSdRowsET[0][0] == 'desktop') {
                        $desktopAmount = $mVSdRowsET[0][1];
                }
                if ($mVSdRowsET[0][0] == 'mobile') {
                        $mobileAmount = $mVSdRowsET[0][1];
                } elseif ($mVSdRowsET[1][0] == 'mobile') {
                        $mobileAmount = $mVSdRowsET[1][1];
                } else {
                        $mobileAmount = '0';
                }
                if ($mVSdRowsET[0][0] == 'tablet') {
                        $tabletAmount = $mVSdRowsET[0][1];
                } elseif ($mVSdRowsET[1][0] == 'tablet') {
                        $tabletAmount = $mVSdRowsET[1][1];
                } elseif ($mVSdRowsET[2][0] == 'tablet') {
                        $tabletAmount = $mVSdRowsET[2][1];
                } else {
                        $tabletAmount = '0';
                }

	} elseif ($_SESSION['externalTrafficTimeframe'] == 'month') {
                $day = 30;
                while($day>=0) {
			$date = date('Y-m-d', strtotime("-$day days"));
                        $dayOfTheMonth = date('d', strtotime("-$day days"));
                        $resultsET = $ga->getExternalTrafficPerDateAll($analytics, $profile, $date, $date);
                        $rowsET = $resultsET->getRows();
                        if ($rowsET[0][0] == 'desktop') {
                                $desktopSessionsET = $rowsET[0][1];
                                
                        } elseif ($rowsET[1][0] == 'desktop') {
                                $desktopSessionsET = $rowsET[1][1];
                        } else {
                                $desktopSessionsET = '0';
                        }
                        if ($rowsET[0][0] == 'mobile') {
                                 $mobileSessionsET = $rowsET[0][1];
                        } elseif ($rowsET[1][0] == 'mobile') {
                                $mobileSessionsET = $rowsET[1][1];
                        } elseif ($rowsET[2][0] == 'mobile') {
                                $mobileSessionsET = $rowsET[2][1];
                        } else {
                                $mobileSessionsET = '0';
                        }
			if ($rowsET[0][0] == 'tablet') {
				$tabletSessionsET = $rowsET[0][1];
			} elseif ($rowsET[1][0] == 'tablet') {
				$tabletSessionsET = $rowsET[1][1];
			} elseif ($rowsET[2][0] == 'tablet') {
                                $tabletSessionsET = $rowsET[2][1];
			} elseif ($rowsET[3][0] == 'tablet') {
                                $tabletSessionsET = $rowsET[3][1];
			} else { 
				$tabletSessionsET = '0';
			}
                        
                        $sessionsET = $desktopSessionsET + $mobileSessionsET + $tabletSessionsET;
                        if(!$sessionsET) {
                                $sessionsET = "0";
                        }
                        $dataView .= "[\"$dayOfTheMonth\", $sessionsET],";
                        $resultsETRef = $ga->getExternalTrafficTopReferrers($analytics, $profile, $date, $date);
                        $rowsETRef  = $resultsETRef->getRows();
                        $day--;
                }
                $resultsETRef = $ga->getExternalTrafficTopReferrers($analytics, $profile, '29daysAgo', 'today');
                $rowsETRef  = $resultsETRef->getRows();
                $mVSdResultsET = $ga->getExternalTrafficPerDateAll($analytics, $profile, '29daysAgo', 'today');
                $mVSdRowsET = $mVSdResultsET->getRows();
		if ($mVSdRowsET[0][0] == 'desktop') {
			$desktopAmount = $mVSdRowsET[0][1];
		}
		if ($mVSdRowsET[0][0] == 'mobile') {
			$mobileAmount = $mVSdRowsET[0][1];
		} elseif ($mVSdRowsET[1][0] == 'mobile') {
			$mobileAmount = $mVSdRowsET[1][1];
		} else {
			$mobileAmount = '0';
		}
		if ($mVSdRowsET[0][0] == 'tablet') {
			$tabletAmount = $mVSdRowsET[0][1];
		} elseif ($mVSdRowsET[1][0] == 'tablet') {
			$tabletAmount = $mVSdRowsET[1][1];
		} elseif ($mVSdRowsET[2][0] == 'tablet') {
			$tabletAmount = $mVSdRowsET[2][1];
		} else {
			$tabletAmount = '0';
		}
        } else {
                $resultsET = $ga->getExternalTrafficHourlyAll($analytics, $profile);
                $rowsET = $resultsET->getRows();
		
		$hours = date('g A', strtotime("-24 hours"));
                $countUp = 1;
                foreach ($rowsET as $hour => $sessions ) {
                        $dataView .= "[\"$hours\", $sessions[1]],";
			$hours = date('g A', strtotime("+$countUp hour " ));
                        $countUp++;
                }
		$resultsETRef = $ga->getExternalTrafficTopReferrers($analytics, $profile, 'today', 'today');
                $rowsETRef  = $resultsETRef->getRows();

		$mVSdResultsET = $ga->getExternalTrafficPerDateAll($analytics, $profile, 'yesterday', 'today');
                $mVSdRowsET = $mVSdResultsET->getRows();
                if ($mVSdRowsET[0][0] == 'desktop') {
                        $desktopAmount = $mVSdRowsET[0][1];
                }
                if ($mVSdRowsET[0][0] == 'mobile') {
                        $mobileAmount = $mVSdRowsET[0][1];
                } elseif ($mVSdRowsET[1][0] == 'mobile') {
                        $mobileAmount = $mVSdRowsET[1][1];
                } else {
                        $mobileAmount = '0';
                }
                if ($mVSdRowsET[0][0] == 'tablet') {
                        $tabletAmount = $mVSdRowsET[0][1];
                } elseif ($mVSdRowsET[1][0] == 'tablet') {
                        $tabletAmount = $mVSdRowsET[1][1];
                } elseif ($mVSdRowsET[2][0] == 'tablet') {
                        $tabletAmount = $mVSdRowsET[2][1];
                } else {
                        $tabletAmount = '0';
                }


        }
	$dataView = rtrim($dataView, ",");
	$output =
		'
        <div class="header-tab-3">EXTERNAL TRAFFIC</div>
        <div class="typicalContainer" style="min-width: 997px;">
        <table class="externalTrafficTable">
        <tbody>
	<th colspan="2" style="text-align: center;">TOP REFERRING SITES</th>
	';
	foreach ($rowsETRef as $rowETRef) {
        	$output .= '
		<tr class="vistorsTableRow">	
        	<td><span class="visitorInfoTitle">'.$rowETRef[0].'</span></td><td><span class="visitorInfoValue">'.$rowETRef[1].'</span></td>
		</tr>';
	}
	$output .= '
        </tbody>
        </table>
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
        
                                var chart = new google.visualization.AreaChart(document.getElementById("etChart"));
                                        chart.draw(data, options);
                                }




                                google.setOnLoadCallback(drawChartmVSd);
                                function drawChartmVSd() {
                                        var datamVSd = google.visualization.arrayToDataTable([
                                                ["Type", "Views"],
                                                ["Desktop",   '.$desktopAmount.'],
                                                ["Mobile", '.$mobileAmount.'],
						["Tablet", '.$tabletAmount.']
                                         ]);
                                        var optionsmVSd = {
                                                title: "Device Type",
                                                width: 250
                                         };
                                        var chartmVSd = new google.visualization.PieChart(document.getElementById("mVSd"));
                                        chartmVSd.draw(datamVSd, optionsmVSd);
                                }

                        </script>
	<div style="display: inline-block;">
        	<div id="etChart" style="width: 380px; height: 200px; padding: 0px; display:inline-block;"></div>
		<div class="rightTableSection" id="mVSd"  ></div>
	</div>
        <br><br>
	<a href="" id="externaltrafficday" class="sortStatsButton " onclick="statsSorting(\'externalTrafficTimeFrame=day\')">Day</a><a href="" id="externaltrafficweek" class="sortStatsButton" onclick="statsSorting(\'externalTrafficTimeFrame=week\')">Week</a><a href="" id="externaltrafficmonth" class="sortStatsButton" onclick="statsSorting(\'externalTrafficTimeFrame=month\')">Month</a> 
        </div>
        ';
        
        echo $output;
        
    








?>