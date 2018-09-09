<?php /* Template Name: BBB Admin Sponsors */ ?>

<?php get_header(); 
add_filter('show_admin_bar', '__return_false');
?>
<?php
$logo = ( $user_logo = et_get_option( 'divi_logo' ) ) && '' != $user_logo
? $user_logo
: $template_directory_uri . '/images/logo.png';

?>
<?php get_template_part( 'partials/content', 'header' ); ?>

    <div class="content-wrapper admin-wrapper">
        <div class="container-fluid admin-fluid">
            <div class="row logo-row">
                <div class="col-lg-2">
                    <div class="card mb-3">
                        <a  class="" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" id="logo" data-height-percentage="<?php echo esc_attr( et_get_option( 'logo_height', '54' ) ); ?>" />
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10">
                    <div class="card mb-3">
                        <div class="card-header sponsor-header">
                            Ad Management - Campaigns
                            <div class="ads-btns">
                                <a href="<?php echo admin_url('post-new.php?post_type=campaigns'); ?>" target="_blank" class="campaign-btn" style="position:static;">New Campaign</a>
                                <a href="<?php echo admin_url('post-new.php?post_type=advertisers'); ?>" target="_blank" class="advertiser-btn" style="position:static;">New Advertiser</a>
                            </div>
                        </div>
                            <?php 

                                $args = shortcode_atts(
                                    array(  
                                        'post_type' => 'campaigns',
                                        'numberposts' => -1,
                                        'order' => 'desc',
                                    ), $atts );

                                $campaigns = get_posts($args);
                            
                                $args = shortcode_atts(
                                    array(
                                        'post_type' => 'advertisers',
                                        'numberposts' => -1,
                                        'order' => 'desc',
                                    ), $atts );

                                $advertisers = get_posts($args);

                                $args = shortcode_atts(
                                    array(
                                        'post_type' => 'banners',
                                        'numberposts' => -1,
                                        'order' => 'desc',
                                    ),
                                    $atts
                                    );
                                    $banners = get_posts($args);

                                foreach ($banners as $banner) {
                                    $bannerMeta = get_post_meta($banner->ID);
                                }

                            
//                                         <div class="inboxTitleRow"><span class="inboxTitle">CAMPAIGNS</span></div>
//                                         <div class="limitlessContainer">
//                                             <div style="text-align:left;"><span>Advertisers:  </span><select id="advertiserSelect">
//                                                 <option value="">Select an advertiser</option>
//                                                 <option value="">All</option>';

//                                             foreach ($advertisers as $advertiser) {
//                                                 $output .= "<option class='advertiserOption' value='$advertiser->ID'>$advertiser->post_title</option>";
//                                             }

//   if($_GET['advertiser']) {
//     foreach ($campaigns as $campaign) {
//       $campaignAdvertiserId = get_post_meta($campaign->ID,'_campaign_advertiser_id', true);
//                   if($_GET['advertiser'] == $campaignAdvertiserId) {      
//                                 $cLinkedBannersRequest = Pro_Ads_Campaigns::get_linked_banners($campaign->ID);
//                                 foreach ($cLinkedBannersRequest as $banner) {
//                                         $banner_impressions  = get_post_meta( $banner->ID, '_banner_impressions', true );
//                                         $banner_clicks  = get_post_meta( $banner->ID, '_banner_clicks', true );
//                                         $cAllTotalImpressions = $cAllTotalImpressions + $banner_impressions;
//                                         $cAllTotalClicks = $cAllTotalClicks + $banner_clicks;
//           $ctr = !empty($cAllTotalClicks) && !empty($cAllTotalImpressions) ? $cAllTotalClicks / $cAllTotalImpressions * 100 : 0;
//                             $cAllTotalCTR = round($ctr,2).'%';
//                                 }
//                         }
//                 }
//         } else {
//     foreach ($campaigns as $campaign) {
//                   $cLinkedBannersRequest = Pro_Ads_Campaigns::get_linked_banners($campaign->ID);
//                   foreach ($cLinkedBannersRequest as $banner) {
//                           $banner_impressions  = get_post_meta( $banner->ID, '_banner_impressions', true );
//         $banner_clicks  = get_post_meta( $banner->ID, '_banner_clicks', true );
//                           $cAllTotalImpressions = $cAllTotalImpressions + $banner_impressions;
//         $cAllTotalClicks = $cAllTotalClicks + $banner_clicks;
//         $ctr = !empty($cAllTotalClicks) && !empty($cAllTotalImpressions) ? $cAllTotalClicks / $cAllTotalImpressions * 100 : 0;
//                                 $cAllTotalCTR = round($ctr,2).'%';
//                   }
//     }
//   }
//   $output .= '</select>

    $output = '<div class="table-responsive with-scroll"><table style="margin-bottom:20px;" class="table">
                    <thead>
                        <tr class="campaignHeader">
                            <th>Campaign</th>
                            <th>Advertiser</th>
                            <th>Ads</th>
                            <th>Campaign Status</th>
                            <th>Impressions/Views</th>
                            <th>Clicks</th>
                            <th>Actions</th>
                        </tr>
                    </thead>';

  foreach ($campaigns as $campaign) {
    $cAllTotalImpressions = $cAllTotalImpressions + $cTotalImpressions;
    $cTotalImpressions = 0;
    $cTotalClicks = 0;
    $cTotalCTR = 0;
    $class = ($i%2 == 0)? 'greyRow': 'whiteRow';
    $i++;
    $campaignAdvertiserId = get_post_meta($campaign->ID,'_campaign_advertiser_id', true);
    $cStatusRequest = get_post_meta( $campaign->ID, '_campaign_status', true );
    $cStatus = Pro_Ads_Campaigns::get_status($cStatusRequest);
    $cLinkedBannersRequest = Pro_Ads_Campaigns::get_linked_banners($campaign->ID);
    $bannersAmount = count($cLinkedBannersRequest);
    foreach ($cLinkedBannersRequest as $banner) {
                  $banner_impressions  = get_post_meta( $banner->ID, '_banner_impressions', true );
      $banner_clicks  = get_post_meta( $banner->ID, '_banner_clicks', true );
                        $cTotalImpressions = $cTotalImpressions + $banner_impressions;
      $cTotalClicks = $cTotalClicks + $banner_clicks;
      $ctr = !empty($cTotalClicks) && !empty($cTotalImpressions) ? $cTotalClicks / $cTotalImpressions * 100 : 0;
                        $cTotalCTR = round($ctr,2).'%';
                }
    if($_GET['advertiser']) {
      if($_GET['advertiser'] == $campaignAdvertiserId) {
        $output .= "
                    <tbody>
                        <tr class='$class campaign-data' id='$campaign->ID'>
                            <td data-th='Campaign'><span>$campaign->post_title</span></td>
                            <td data-th='Advertiser'><span>".get_the_title($campaignAdvertiserId)."</span></td>
                            <td data-th='Ads'><span>$bannersAmount</span></td>
                            <td data-th='Campaign Status'><span>".$cStatus['name']."</span></td>
                            <td data-th='Impressions/Views'><span>$cTotalImpressions</span></td>
                            <td data-th='Clicks'><span>$cTotalClicks</span></td>
                            <td data-th='Actions'><a class='thickbox' href='#TB_inline?height=680&amp;width=650&amp;inlineId=campaignBanners".$campaign->ID."'>View</a> | <a href='".MARKETNAME_DIR."/wp-admin/post.php?post=".$campaign->ID."&action=edit'  target='_blank'>Edit</a></td>
                            <td>                
                                <div id='campaignBanners".$campaign->ID."' style='display: none;'>
                                    <a style='float: right; margin: 15px; padding: 10px; background: #5B9DD9; color: #fff;' target='_blank'  href='".MARKETNAME_DIR."/wp-admin/post-new.php?post_type=banners'>New Ad</a>
                                    <h2>$campaign->post_title</h2>
                                    <table style='width:95%'>
                                            <tr>
                                                    <th>Ad Title</th>
                                                    <th>Advertiser</th>
                                                    <th>Status</th>
                                                    <th>Impressions/Views</th>
                                                    <th>Clicks</th>
                                                   
                                            </tr>";
                                            foreach ($cLinkedBannersRequest as $banner) {
                                                    $class2 = ($i2%2 == 0)? 'greyRow': 'whiteRow';
                                                    $i2++;
                                                    $bStatusRequest = get_post_meta( $banner->ID, '_banner_status', true );
                                                    $banner_clicks  = get_post_meta( $banner->ID, '_banner_clicks', true );
                                                    $banner_impressions  = get_post_meta( $banner->ID, '_banner_impressions', true );
                                                    $ctr = !empty($banner_clicks) && !empty($banner_impressions) ? $banner_clicks / $banner_impressions * 100 : 0;
                                                    $round_ctr = round($ctr,2).'%';
                                                    $bStatus = Pro_Ads_Banners::get_status($bStatusRequest);
                                            $output .="
                                            <tr class='$class2'>
                                                    <td><span>$banner->post_title</span></td>
                                                    <td><span>".get_the_title($campaignAdvertiserId)."</span></td>
                                                    <td><span>".$bStatus['name']."</span></td>
                                                    <td>$banner_impressions</td>
                                                    <td>$banner_clicks</td>
                                                    <td><a href='".MARKETNAME_DIR."/wp-admin/post.php?post=".$banner->ID."&action=edit'  target='_blank'>Edit Ads</a></td>
                                            </tr>";
                                            }

                                    $output .="
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </tbody>";
      }
    } else { 
      $output .= "
        <tr class='$class campaign-data' id='$campaign->ID'>
            <td data-th='Campaign'><span class='campaign-title'>$campaign->post_title</span></td>
            <td data-th='Advertiser'><span class='advertiser-title'>".get_the_title($campaignAdvertiserId)."</span></td>
            <td data-th='Ads'><span>$bannersAmount</span></td>
            <td data-th='Campaign Status'><span>".$cStatus['name']."</span></td>
            <td data-th='Impressions/Views'><span>$cTotalImpressions</span></td>
            <td data-th='Clicks'><span>$cTotalClicks</span></td>
            <td data-th='Actions'><a href='#'  data-toggle='modal' data-target='#campaignBanners".$campaign->ID."'>View</a>| <a href='".MARKETNAME_DIR."/wp-admin/post.php?post=".$campaign->ID."&action=edit'  target='_blank'>Edit</a></td>
            <td>

                <div id='campaignBanners".$campaign->ID."' class='modal fade student-messageModal2 bd-example-modal-lg' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog modal-dialog-centered modal-lg' role='document'>
                        <div class='modal-content'>                                               
                            <div class='modal-body'>
                                <a class='new-ad' target='_blank'  href='/wp-admin/post-new.php?post_type=banners'>New Ad</a>
                                <h2>$campaign->post_title</h2><br>
                                <div style='float: right; margin-right: 15px;'></div><br><br>
                                <table class='table modal-table'>
                                    <tr>
                                        <th>Ad Title</th>
                                        <th>Advertiser</th>
                                        <th>Status</th>
                                        <th>Impressions/Views</th>
                                        <th>Clicks</th>
                                        <th>CTR</th>
                                        <th></th>
                                    </tr>";
                                    foreach ($cLinkedBannersRequest as $banner) {
                                    $class2 = ($i2%2 == 0)? 'greyRow': 'whiteRow';
                                                $i2++;
                                    $bStatusRequest = get_post_meta( $banner->ID, '_banner_status', true );
                                    $banner_clicks  = get_post_meta( $banner->ID, '_banner_clicks', true );
                                    $banner_impressions  = get_post_meta( $banner->ID, '_banner_impressions', true );
                                    $ctr = !empty($banner_clicks) && !empty($banner_impressions) ? $banner_clicks / $banner_impressions * 100 : 0;
                                                $round_ctr = round($ctr,2).'%';
                                    $bStatus = Pro_Ads_Banners::get_status($bStatusRequest);
                                    $output .="
                                    <tr class='$class2'>
                                        <td><span>$banner->post_title</span></td>
                                        <td><span>".get_the_title($campaignAdvertiserId)."</span></td>
                                        <td><span>".$bStatus['name']."</span></td>
                                        <td><span>$banner_impressions</span></td>
                                        <td><span>$banner_clicks</span></td>
                                        <td><a href='".MARKETNAME_DIR."/wp-admin/post.php?post=".$banner->ID."&action=edit'  target='_blank'>Edit Ads</a></td>
                                    </tr>";
                                    }
                                
                                $output .="
                                </table>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close Window</button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    ";
    }
      }
        $output .= '</table></div></div>';
        echo $output;

?>

        
      </div>
    </div>

    </div>
 
</div>
  <!-- /.container-fluid-->
  <!-- /.content-wrapper-->
  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
  </a>
  <!-- Logout Modal-->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
    </div><!--
    <script type='text/javascript' src='http://bbbvideocontest.platypustest.info/dev/wp-content/themes/Child-Divi/vendor/jquery/jquery.min.js?ver=4.9.6'></script>
    <script type='text/javascript' src='http://bbbvideocontest.platypustest.info/dev/wp-content/themes/Child-Divi/vendor/bootstrap/js/bootstrap.bundle.min.js?ver=4.9.6'></script>
<script type='text/javascript' src='http://bbbvideocontest.platypustest.info/dev/wp-content/themes/Child-Divi/vendor/jquery-easing/jquery.easing.min.js?ver=4.9.6'></script>
<script type='text/javascript' src='http://bbbvideocontest.platypustest.info/dev/wp-content/themes/Child-Divi/js/sb-admin.min.js?ver=4.9.6'></script>-->
</div>
</body>

</html>
<?php get_footer(); ?>