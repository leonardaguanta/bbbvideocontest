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
                <!--<div class="header-tab">Last 90 Days</div>-->
                <table class="adSummaryTable">
                    <tbody>
                        <tr>
                            <td class="summaryCol">
                                <h5 class="adSummaryValue">'.$videoViews.'</h5>
                                <span class="adSummaryTitle">Video Views</span>
                            </td>
                            <td class="summaryCol">
                                <h5 class="adSummaryValue">'.$adImpressions.'</h5>
                                <span class="adSummaryTitle">Ad Impressions</span>
                            </td>
                            <td class="summaryCol">
                                <h5 class="adSummaryValue">'.$adClicks.'</h5>
                                <span class="adSummaryTitle">Click Throughs</span>
                            </td>
                            <td class="summaryCol">
                                <h5 class="adSummaryValue">'.$pageViewsSum.'</h5>
                                <span class="adSummaryTitle">Page Views</span>
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