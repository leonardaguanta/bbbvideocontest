<?php

 $ga = new Platypus_GA();
        $analytics = $ga->getService();
        $profile = $ga->getFirstProfileId($analytics);

        try{
                $results = $ga->getResultsSummary($analytics, $profile);
                $rows = $results->getRows();
                $videoViews = $rows[1][1];
                $adImpressions = $rows[2][1];
                $adClicks = $rows[0][1];

                $results2 = $ga->getResults($analytics, $profile, 'summary');
                $rows2 = $results2->getRows();
                $pageViewsSum = $rows2[0][1];

                $resultsBlog = $ga->getResultsSummaryBlog($analytics, $profile);

                $rowsBlog = $resultsBlog->getRows();
                $blogViews = $rowsBlog[0][1];

                $output =
                '
                <div class="header-tab">Last 90 Days</div>
                <table class="adSummaryTable">
                <tbody>
                        <tr>
                        <td class="summaryCol">
                                <img src="http://platypus-dallas.s3.amazonaws.com/wp-content/uploads/2015/09/22200856/videoViews.jpg" alt="Video Views" /><br>
                                <span class="adSummaryValue">'.$videoViews.'</span><br>
                                <h5 class="adSummaryTitle">VIDEO VIEWS</h5>
                        </td>
                        <td class="summaryCol">
                                <img src="http://platypus-dallas.s3.amazonaws.com/wp-content/uploads/2015/09/22200846/adIImpressions.jpg" alt="Ad Impressions" /><br>
                                <span class="adSummaryValue">'.$adImpressions.'</span><br>
                                <h5 class="adSummaryTitle">AD IMPRESSIONS</h5>
                        </td>
                        <td class="summaryCol">
                                <img src="http://platypus-dallas.s3.amazonaws.com/wp-content/uploads/2015/09/22200851/clickThrough.jpg" alt="Click Throughs" /><br>
                                <span class="adSummaryValue">'.$adClicks.'</span><br>
                                <h5 class="adSummaryTitle">CLICK THROUGHS</h5>
                        </td>
                        <td class="summaryCol">
                                <img src="http://platypus-dallas.s3.amazonaws.com/wp-content/uploads/2015/09/22200854/videoShare.jpg" alt="Page Views" /><br>
                                <span class="adSummaryValue">'.$pageViewsSum.'</span><br>
                                <h5 class="adSummaryTitle">PAGE VIEWS</h5>
                        </td>
                        </tr>
                </tbody>
                </table>
                ';

                echo $output;
        } catch (\Exception $e) { // <<<<<<<<<<< You must use the backslash
                return "<h5 style='margin-top: 10px; text-align: center; font-weight: bold; color: red;'>Google_Service_Exception - Quota Error: has exceeded the daily request limit.</h5>";
        }







?>