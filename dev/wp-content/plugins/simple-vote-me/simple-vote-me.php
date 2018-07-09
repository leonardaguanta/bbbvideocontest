<?php
/*
Plugin Name: Simple Vote Me
Plugin URI: https://wordpress.org/plugins/simple-vote-me/
Description: This plugin add cute and simple votes for Wordpress post.
Author: Gonzalo Torreras
Version: 100
Author URI: http://www.gonzalotorreras.com
*/
define('SIMPLEVOTEMESURL', WP_PLUGIN_URL . "/" . dirname(plugin_basename(__FILE__)));
include_once (plugin_dir_path(__FILE__) . '/admin.php');

include_once (plugin_dir_path(__FILE__) . '/widget.php');

global $gt_simplevoteme_version;
$gt_simplevoteme_version = "1.3";

function gt_simplevoteme_checkversion()
        {
        $version = get_option('gt_simplevoteme_version');
        if ($version === false)
                {

                // install plugin
                // check if there are old system of votes

          //      gt_simplevoteme_check_old_votes();
                }
          else
        if ($version != $gt_simplevoteme_version)
                {

                // update tables,vars etc.

                }

        update_option('gt_simplevoteme_version', $gt_simplevoteme_version);
        }

add_action('plugins_loaded', 'gt_simplevoteme_checkversion');

function gt_simplevoteme_check_old_votes()
        {
        $posts = get_posts('meta_key=_simplevotemetotal&amp;');
        if ($posts)
                {
                $votes = array(
                        'positives' => array() ,
                        'negatives' => array() ,
                        'neutrals' => array()
                );
                foreach($posts as $post)
                        {
                        $pos = get_post_meta($post->ID, '_simplevotemepositive', true) ? get_post_meta($post->ID, '_simplevotemepositive', true) : 0;
                        $neg = get_post_meta($post->ID, '_simplevotemenegative', true) ? get_post_meta($post->ID, '_simplevotemenegative', true) : 0;
                        $neu = get_post_meta($post->ID, '_simplevotemeneutral', true) ? get_post_meta($post->ID, '_simplevotemeneutral', true) : 0;
                        for ($i = 0; $i < $pos; $i++)
                                {
                                $votes['positives'][] = '0'; //add votes for positive with user_ID 0 like annonymous
                                }

                        for ($i = 0; $i < $neg; $i++)
                                {
                                $votes['negatives'][] = '0'; //add votes for positive with user_ID 0 like annonymous
                                }

                        for ($i = 0; $i < $neu; $i++)
                                {
                                $votes['neutrals'][] = '0'; //add votes for positive with user_ID 0 like annonymous
                                }

                        update_post_meta($post->ID, '_simplevotemevotes', $votes);

                        // echo "updating gt_svtm</br>neg:$neg</br>pos:$pos</br>neu:$neu";
                        // print_r($votes);

                        delete_post_meta($post->ID, '_simplevotemetotal', "");
                        delete_post_meta($post->ID, '_simplevotemepositive', "");
                        delete_post_meta($post->ID, '_simplevotemenegative', "");
                        delete_post_meta($post->ID, '_simplevotemeneutral', "");
                        }
                }
        }

function gt_simplevoteme_enqueuescripts()
        {
        wp_register_style('simplevotemestyle', SIMPLEVOTEMESURL . '/css/simplevoteme.css');
        wp_register_style('simplevotemestyleadmin', SIMPLEVOTEMESURL . '/css/simplevotemeadmin.css');
        wp_enqueue_script('gtsimplevoteme', SIMPLEVOTEMESURL . '/js/simple-vote-me.js', array(
                'jquery'
        ));
        wp_localize_script('gtsimplevoteme', 'gtsimplevotemeajax', array(
                'ajaxurl' => admin_url('admin-ajax.php')
        ));
        $css = get_option('gt_simplevoteme_custom_default_css');
        if (!$css) //default = yes = 0
        wp_enqueue_style('simplevotemestyle');
        }

add_action('wp_enqueue_scripts', 'gt_simplevoteme_enqueuescripts');

function gt_simplevoteme_getimgvote($type)
        {
        /*$custom = get_option('gt_simplevoteme_custom_img');
        if(!$custom){
        return "<img src='". SIMPLEVOTEMESURL ."/img/$type.png'/>";
        } else{
        $customImg = get_option("gt_simplevoteme_custom_img_$type");
        return "<img src='$customImg'/>";
        }*/
        // return "<img src='http://platypus-dallas.s3.amazonaws.com/wp-content/uploads/2015/11/11223604/afterVote.png'/>";
    return "<i class='fa fa-heart' aria-hidden='true'></i>";
        }

function gt_simplevoteme_getvotelink($noLinks = false, $tipo = 'h', $postVideo_ID = '')
        {
        $votemelink = "";
        $user_ID = get_current_user_id();
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
                {
                $user_IP = $_SERVER['HTTP_CLIENT_IP'];
                }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
                {
                $user_IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
                }
          else
                {
                $user_IP = $_SERVER['REMOTE_ADDR'];
                }

        $limitVotesPerUser = get_option('gt_simplevoteme_votes');
        if (!$postVideo_ID)
                {
                if (!$noLinks)
                        {
                        $post_ID = get_the_ID();
                        }
                  else
                        {
                        if (!$_POST['postvideoid'])
                                {
                                $post_ID = $_POST['postid'];
                                }
                          else
                                {
                                $post_ID = $_POST['postvideoid'];
                                }
                        }
                }
          else
                {
                $post_ID = $postVideo_ID;
                }

      /*  $votes = get_post_meta($post_ID, '_simplevotemevotes', true) != "" ? get_post_meta($post_ID, '_simplevotemevotes', true) : array(
                'positives' => array() , //id users array
                'negatives' => array() ,
                'neutrals' => array() ,
        );*/
/*        $ipDate = get_post_meta($post_ID, '_simplevotedate', true) != "" ? get_post_meta($post_ID, '_simplevotedate', true) : date("Y-m-d");
        $ipVotes = get_post_meta($post_ID, '_simplevoteIP', true) != "" ? get_post_meta($post_ID, '_simplevoteIP', true) : array(
                'positives' => array()
        );
        if ($ipDate != date("Y-m-d"))
                {
                $ipVotes = array(
                        'positives' => array()
                );
                $ipDate = date("Y-m-d");
               // update_post_meta($post_ID, '_simplevotedate', $votes);
                $ipVotes = array(
                        'positives' => array()
                );
                $noLinks = 0;
                }

        // if no limit votes per user or user not logged

        if (!filter_var($user_IP, FILTER_VALIDATE_IP) === false)
                {
                if ((in_array($user_IP, $ipVotes['positives'])))
                        {
                        // scottw comment out
                        //$counts = array_count_values($ipVotes['positives']);
                        //if ($counts[$user_IP] >= 5)
                        //      {
                        //      $noLinks = 1; //check if there are limit per user and the user is in array, if is $nolinks = 1
                        //      }
                        //  else
                        //      {
                                $noLinks = 0;
                        //      }
                        }
                }
          else
                {
                $noLinks = 0;
                }
                


      //  $votemeNeutral = count($votes['neutrals']);
        $votemeNegative = count($votes['negatives']);
        $votemeTotal = sizeof($votes, 1) - 3; //rest 3 because arrays for separate votes counts.
        $votemeResults = get_option('gt_simplevoteme_results');
        $votemeResultsType = get_option('gt_simplevoteme_results_type');

        if ($votemeResults)
                {
                if ($votemeResults == 1 || ($votemeResults == 2 && $noLinks))
                        {
                        if ($votemeTotal != 0 || $votemeTotal != '')
                                {
                                if ($votemeNegative > 0) //if there are votes
                                $percentNegative = round($votemeNegative / $votemeTotal, 2) * 100 . "%";
                                  else $percentNegative = "0%";
                                if ($votemeResultsType == 2) //just total votes
                                $votemePercentNegative = $votemeNegative;
                                  else
                                if ($votemeResultsType == 1) //only percentages
                                $votemePercentNegative = $percentNegative;
                                  else

                                // all

                                $votemePercentNegative = "$percentNegative<small> ($votemeNegative) </small>";
                                if ($votemeNeutral > 0) //if there are votes
                                $percentNeutral = round($votemeNeutral / $votemeTotal, 2) * 100 . "%";
                                  else $percentNeutral = "0%";
                                if ($votemeResultsType == 2) //just total votes
                                $votemePercentNeutral = $votemeNeutral;
                                  else
                                if ($votemeResultsType == 1) //only percentages
                                $votemePercentNeutral = $percentNeutral;
                                  else

                                // all

                                $votemePercentNeutral = "$votemeNeutral";
                                if ($votemePositive > 0) $percentPositive = round($votemePositive / $votemeTotal, 2) * 100 . "%";
                                  else $percentPositive = "0%";
                                if ($votemeResultsType == 2) //just total votes
                                $votemePercentPositive = $votemePositive;
                                  else
                                if ($votemeResultsType == 1) //only percentages
                                $votemePercentPositive = $percentPositive;
                                  else

                                // all

                                $votemePercentPositive = "$votemePositive";
                                }
                          else
                                {
                                $votemePercentNegative = "";
                                $votemePercentNeutral = "";
                                $votemePercentPositive = "";
                                }
                        }
                  else
                        {
                        $votemePercentNegative = "";
                        $votemePercentNeutral = "";
                        $votemePercentPositive = "";
                        }
                }
          else
                {
                $votemePercentNegative = "";
                $votemePercentNeutral = "";
                $votemePercentPositive = "";
                }

        $votes_off = et_get_option('divi_turn_off_votes');

        if (!$noLinks)
                {
                        if($votes_off == "on"){
                                $linkPositivo = gt_simplevoteme_getimgvote("good");
                        }else{
                                $linkPositivo = '<a class="'. $votes_off .'" onclick="simplevotemeaddvote(event,' . $post_ID . ', 1,' . $user_ID . ');">' . gt_simplevoteme_getimgvote("good") . '</a>';
                        }
                }
          else
                {
                $linkPositivo = gt_simplevoteme_getimgvote("good");
                }*/

$linkPositivo = '<a onclick="simplevotemeaddvote(event,' . $post_ID . ', 1,' . $user_ID . ');">' . gt_simplevoteme_getimgvote("good") . '</a>';

        $votemePercentPositive = get_post_meta($post_ID, 'len_simplevotemevotes', true);
global $wpdb;
//$newvotes = 0;
foreach( $wpdb->get_results("SELECT * FROM pl_votes_new WHERE post_id = $post_ID;") as $key => $row) {

   $votemePercentPositive++;
}
        $title = get_option('gt_simplevoteme_title');
        $votemelink = "<div class='simplevotemeWrapper $tipo' id='simplevoteme-$post_ID' >$title";
      $votemelink .= "<span class='". ($noLinks ? 'no-link' : '') ."'>$linkPositivo <span class='result'>$votemePercentPositive</span></span>";
        $votemelink.= "</div>";

     

        $result = $votemelink;
        $css = get_option('gt_simplevoteme_custom_css');
        if ($css) $result.= "<style>" . $css . "</style>";
        $bor_G = get_option('gt_simplevoteme_custom_border_good');
        $bor_N = get_option('gt_simplevoteme_custom_border_neutral');
        $bor_B = get_option('gt_simplevoteme_custom_border_bad');
        $bg_B = get_option('gt_simplevoteme_custom_background_bad');
        $bg_N = get_option('gt_simplevoteme_custom_background_neutral');
        $bg_G = get_option('gt_simplevoteme_custom_background_good');
        if ($bor_G || $bor_N || $bor_B || $bg_G || $bg_N || $bg_B) $result.= "<style>.simplevotemeWrapper span.bad{  background: rgba($bg_B);border:1px solid rgba($bor_B);.simplevotemeWrapper span.neutro{  background: rgba($bg_N);border:1px solid rgba($bor_N);.simplevotemeWrapper span.good{  background: rgba($bg_G);border:1px solid rgba($bor_G);}</style>";

        // $result .= print_r($votes);

        return $result;
        }

function gt_simplevoteme_printvotelink_auto($content)
        {
        $home = get_option('gt_simplevoteme_auto_insert_home');
        $auto = get_option('gt_simplevoteme_auto_insert_content');
        if (!$auto && (is_home() && !$home)) return ($content);
        $login = get_option('gt_simplevoteme_only_login'); //after auto, do not waste resources if is not necessary :)
        if ($login && !is_user_logged_in()) return ($content);
        $position = get_option('gt_simplevoteme_position'); //after login, do not waste resources if is not necessary :)
        if (is_home() && $home)
                { //if is home and home is active
                if (!$position) return $content . gt_simplevoteme_getvotelink();
                  else
                if ($position == 1) return gt_simplevoteme_getvotelink() . $content;
                  else
                if ($position == 2)
                        {
                        $linksVote = gt_simplevoteme_getvotelink(); //launch just once
                        return $linksVote . $content . $linksVote;
                        }
                  else return $content; //nothing expected
                }
          else
        if (($auto == 1 || $auto == 3) && is_single())
                { //if is only post(1) or post&page(3)
                if (!$position) return $content . gt_simplevoteme_getvotelink();
                  else
                if ($position == 1) return gt_simplevoteme_getvotelink() . $content;
                  else
                if ($position == 2)
                        {
                        $linksVote = gt_simplevoteme_getvotelink(); //launch just once
                        return $linksVote . $content . $linksVote;
                        }
                  else return $content; //nothing expected
                }
          else
        if (($auto == 2 || $auto == 3) && is_page())
                { //if is only page(2) or post&page(3)
                if (!$position) return $content . gt_simplevoteme_getvotelink();
                  else
                if ($position == 1) return gt_simplevoteme_getvotelink() . $content;
                  else
                if ($position == 3)
                        {
                        $linksVote = gt_simplevoteme_getvotelink(); //launch just once
                        return $linksVote . $content . $linksVote;
                        }
                  else return $content; //nothing expected
                }
          else return ($content); //nothing expected
        }

add_filter('the_content', 'gt_simplevoteme_printvotelink_auto');

function gt_simplevoteme_aftervote()
        {
        $linkPositivo = gt_simplevoteme_getimgvote("good");
        $linkNegativo = gt_simplevoteme_getimgvote("bad");
        $linkNeutral = gt_simplevoteme_getimgvote("neutral");
        }

/** Ajax **/


function gt_simplevoteme_addvote()
        {
        $results = '';
        global $wpdb;
        $post_ID = $_POST['postid'];
        $user_ID = $_POST['userid'];
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
                {
                $user_IP = $_SERVER['HTTP_CLIENT_IP'];
                }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
                {
                $user_IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
                }
          else
                {
                $user_IP = $_SERVER['REMOTE_ADDR'];
                }

        $type = $_POST['tipo'];
        $votes = get_post_meta($post_ID, 'len_simplevotemevotes', true);


$ipDate = date("Y-m-d");
$ipVotes = $user_IP;



$wpdb->insert( $wpdb->prefix . 'votes_new', 
    array( 
        'post_id'     => $post_ID,
        'ip_address' => $user_IP,
        'date_time' => $ipDate
    ), 
    array( 
        '%d',
        '%s',
        '%s'
    ) 
);

        $result = gt_simplevoteme_getvotelink(1);
      //  $result = $wpdb->last_error;

        // Return the String

        die($result);
        }

// creating Ajax call for WordPress

add_action('wp_ajax_nopriv_simplevoteme_addvote', 'gt_simplevoteme_addvote');
add_action('wp_ajax_simplevoteme_addvote', 'gt_simplevoteme_addvote');
