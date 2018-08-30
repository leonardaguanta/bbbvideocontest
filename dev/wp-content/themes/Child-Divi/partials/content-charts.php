<?php
$ga = new Platypus_GA();
$analytics = $ga->getService();
$profile = $ga->getFirstProfileId($analytics);

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
  $results = $ga->getVideoWatchCountPerDateAll($analytics, $profile, $date, $date);
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

// New vs Returning All Videos
$results = $ga->getVideoNewVsReturningCountAll($analytics, $profile);
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


$results2 = $ga->getVideoWatchAvgDurationAll($analytics, $profile);
$rows2 = $results2->getRows();
$avgDuration = number_format($rows2[0][1],1);


$output =
'

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

  var chart = new google.visualization.AreaChart(document.getElementById("viewTrend"));
  chart.draw(data, options);
}




google.setOnLoadCallback(drawChartNVR);
function drawChartNVR() {
  var dataNVR = google.visualization.arrayToDataTable([
  ["Type", "Views"],
  ["New Views",   '.$newVisitorData.'],
  ["Returning Views", '.$returnVisitorData.']
  ]);
  var optionsNVR = {
    title: "New Vs. Returning"

  };
  var chartNVR = new google.visualization.PieChart(document.getElementById("nvrGraph"));
  chartNVR.draw(dataNVR, optionsNVR);
}


jQuery( "span.left-elements.charts a" ).click(function() {
  var display_chart = jQuery(this).attr("id");
  console.log(display_chart);
  if (display_chart == "pie"){
    jQuery("#viewTrend").remove();
    jQuery("#nvrGraph").remove();
	jQuery(this).addClass("active");
	jQuery("a#line").removeClass("active");
    function drawChartPIE() {
      var dataNVR = google.visualization.arrayToDataTable([
      ["Type", "Views"],
      ["New Views",   '.$newVisitorData.'],
      ["Returning Views", '.$returnVisitorData.']
      ]);
      var optionsPIE = {
        title: "New Vs. Returning"

      };
      var chartPIE = new google.visualization.PieChart(document.getElementById("big"));
      chartPIE.draw(dataNVR, optionsPIE);
    }
    function drawChartLine() {
      var data = google.visualization.arrayToDataTable([
      ["days", "Views" ],
      '.$dataView.'
      ]);
      var options = {
        hAxis: {titleTextStyle: {color: "#333"}},
        vAxis: {minValue: 0},
        legend: {position: "none"} 
      };

      var chart = new google.visualization.AreaChart(document.getElementById("small"));
      chart.draw(data, options);
    }
    drawChartPIE();
    drawChartLine();
    }else{
	
	jQuery(this).addClass("active");
	jQuery("a#pie").removeClass("active");
	 function drawChartPIE() {
      var dataNVR = google.visualization.arrayToDataTable([
      ["Type", "Views"],
      ["New Views",   '.$newVisitorData.'],
      ["Returning Views", '.$returnVisitorData.']
      ]);
      var optionsPIE = {
        title: "New Vs. Returning"

      };
      var chartPIE = new google.visualization.PieChart(document.getElementById("small"));
      chartPIE.draw(dataNVR, optionsPIE);
    }
	    function drawChartLine() {
      var data = google.visualization.arrayToDataTable([
      ["days", "Views" ],
      '.$dataView.'
      ]);
      var options = {
        hAxis: {titleTextStyle: {color: "#333"}},
        vAxis: {minValue: 0},
        legend: {position: "none"} 
      };

      var chart = new google.visualization.AreaChart(document.getElementById("big"));
      chart.draw(data, options);
    }
    drawChartPIE();
    drawChartLine();

    }
    });


    </script>


    <div class="chart-container">
        <div class="row">
            <div class="col-lg-7 col-md-7">
                <div class="left-panel">
                    <div id="viewTrend" style="width: 100%; height: 300px; padding: 0px;"></div>
                    <div id="big"  style="width: 100%; height: 300px; padding: 0px;"></div>
                </div>
            </div>
            <div class="col-lg-5 col-md-5">

                <div class="right-panel">
                    <div class="upper-stat">
                        <span class="title">Highest:<br><em style="color: #707070; font-size:11px;"> '.$highestValue[day].' '.$highestValue[view].' Views</em></span>
                        <br/>
                        <span class="title">Lowest:<br><em style="color: #707070; font-size:11px;"> '.$lowestValue[day].' '.$lowestValue[view].' Views</em></span>
                    </div>
                    <div class="small-chart">
                        <div id="nvrGraph" style="width: 300px; height: 190px; padding: 10px;"></div>
                        <div id="small" style="width: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    ';

    echo $output;
    ?>



