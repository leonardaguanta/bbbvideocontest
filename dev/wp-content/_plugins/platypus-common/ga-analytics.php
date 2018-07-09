<?php

class Platypus_GA { 

	function getService() {
  		// Creates and returns the Analytics service object.

  		// Load the Google API PHP Client Library.
  		require_once 'google-api-php-client/src/Google/autoload.php';

  		// Use the developers console and replace the values with your
  		// service account email, and relative location of your key file.
  		$service_account_email = 'account-2@bbb-analytics.iam.gserviceaccount.com';
		$path = plugin_dir_path( __FILE__ );
  		$key_file_location = $path."bbb-analytics-b36d24f0ad07.p12";

  		// Create and configure a new client object.
  		$client = new Google_Client();
  		$client->setApplicationName("HelloAnalytics");
  		$analytics = new Google_Service_Analytics($client);

  		// Read the generated client_secrets.p12 key.
  		$key = file_get_contents($key_file_location);
  		$cred = new Google_Auth_AssertionCredentials(
      			$service_account_email,
      			array(Google_Service_Analytics::ANALYTICS_READONLY),
      			$key
  		);
  		$client->setAssertionCredentials($cred);
  		if($client->getAuth()->isAccessTokenExpired()) {
    			$client->getAuth()->refreshTokenWithAssertion($cred);
  		}

  		return $analytics;
	}

	function getFirstprofileId(&$analytics) {
  		// Get the user's first view (profile) ID.

  		// Get the list of accounts for the authorized user.
  		$accounts = $analytics->management_accounts->listManagementAccounts();

  		if (count($accounts->getItems()) > 0) {
    			$items = $accounts->getItems();
    			$firstAccountId = $items[0]->getId();

    			// Get the list of properties for the authorized user.
    			$properties = $analytics->management_webproperties->listManagementWebproperties($firstAccountId);

    			if (count($properties->getItems()) > 0) {
      				$items = $properties->getItems();
      				$firstPropertyId = $items[0]->getId();

      				// Get the list of views (profiles) for the authorized user.
      				$profiles = $analytics->management_profiles->listManagementProfiles($firstAccountId, $firstPropertyId);

      				if (count($profiles->getItems()) > 0) {
        				$items = $profiles->getItems();

        				// Return the first view (profile) ID.
        				return $items[0]->getId();

      				} else {
        				throw new Exception('No views (profiles) found for this user.');
      				}
    			} else {
      				throw new Exception('No properties found for this user.');
    			}
  		} else {
    			throw new Exception('No accounts found for this user.');
  		}
	}

		function getResults(&$analytics, $profileId, $sortPeriod) {
  			// Calls the Core Reporting API and queries for the number of sessions
			if($sortPeriod == "week") {
   				return $analytics->data_ga->get(
       					'ga:' . $profileId,
       					'7daysAgo',
       					'today',
       					'ga:sessions,ga:pageviews,ga:avgSessionDuration,ga:percentNewSessions,ga:newUsers,ga:bounceRate');
			} elseif ($sortPeriod == "month") {
                                return $analytics->data_ga->get(
                                        'ga:' . $profileId,
                                        '30daysAgo',
                                        'today',
					'ga:sessions,ga:pageviews,ga:avgSessionDuration,ga:percentNewSessions,ga:newUsers,ga:bounceRate');
                        } elseif ($sortPeriod == "summary") {
                                 return $analytics->data_ga->get(
                                        'ga:' . $profileId,
                                        '90daysAgo',
                                        'today',
                                        'ga:sessions,ga:pageviews,ga:avgSessionDuration,ga:percentNewSessions,ga:newUsers,ga:bounceRate');
			} else {
				 return $analytics->data_ga->get(
                                        'ga:' . $profileId,
                                        'today',
                                        'today',
                                        'ga:sessions,ga:pageviews,ga:avgSessionDuration,ga:percentNewSessions,ga:newUsers,ga:bounceRate');
			}
		}

		function getResultsSummary(&$analytics, $profileId) {
                        // Summary

			$qParams = array(
				'dimensions' => 'ga:eventAction',
        			'filters' => 'ga:eventAction==html5/mp4,ga:eventAction==impression,ga:eventAction==click');
			
			return $analytics->data_ga->get(
                        	'ga:' . $profileId,
                        	'90daysAgo',
                        	'today',
				'ga:totalEvents',
				$qParams
			);
                }	


		function getResultsSummaryBlog(&$analytics, $profileId) {

                        // Summary Info Shares

                        $qParams = array(
                                'dimensions' => 'ga:pagePathLevel1',
                                'filters' => 'ga:pagePathLevel1=~^/blog/');

                        return $analytics->data_ga->get(
                                'ga:' . $profileId,
                                '90daysAgo',
                                'today',
                                'ga:pageviews',
                                $qParams
                        );
                }


		function getVideoViewsDay(&$analytics, $profileId) {
			$qParams = array(
				'dimensions' => 'ga:eventAction',
                        	'filters' => 'ga:eventAction==html5/mp4');

			return $analytics->data_ga->get(
                                'ga:' . $profileId,
                                'today',
                                'today',
                                'ga:totalEvents',
                                $qParams
                        );
		
		}
	function getVideoNewVsReturningCount(&$analytics, $profileId, $pagePath) {
                $qParams = array('dimensions' => 'ga:userType',
                                'filters' => "ga:pagePath=~$pagePath");
                return $analytics->data_ga->get(
                        'ga:' . $profileId,
                        '90daysAgo',
                        'today',
                        'ga:pageviews',
                        $qParams
                );
        }

	function getVideoNewVsReturningCountAll(&$analytics, $profileId) {
                $qParams = array('dimensions' => 'ga:userType',
                                'filters' => "ga:eventCategory==Video / Seconds played");
                return $analytics->data_ga->get(
                        'ga:' . $profileId,
                        '7daysAgo',
                        'today',
                        'ga:totalEvents',
                        $qParams
                );
        }

	function getVideoWatchCount(&$analytics, $profileId, $eventLabel) {
		$qParams = array('dimensions' => 'ga:eventLabel',
                           	'filters' => "ga:eventLabel==$eventLabel");
		return $analytics->data_ga->get(
			'ga:' . $profileId,
                	'90daysAgo',
                        'today',
			'ga:uniqueEvents',
                        $qParams
               	);
	}

	function getVideoWatchAvgDuration(&$analytics, $profileId, $eventLabel) {
                $qParams = array('dimensions' => 'ga:eventLabel',
                                'filters' => "ga:eventLabel==$eventLabel");
                return $analytics->data_ga->get(
                        'ga:' . $profileId,
                        '90daysAgo',
                        'today',
                        'ga:avgEventValue',
                        $qParams
                );
        }

	function getVideoWatchAvgDurationAll(&$analytics, $profileId) {
                $qParams = array('dimensions' => 'ga:eventCategory',
                                'filters' => "ga:eventCategory==Video / Seconds played");
                return $analytics->data_ga->get(
                        'ga:' . $profileId,
                        '7daysAgo',
                        'today',
                        'ga:avgEventValue',
                        $qParams
                );
        }


	function getVideoWatchCountPerDate(&$analytics, $profileId, $eventLabel, $fromDate, $toDate) {
                $qParams = array('dimensions' => 'ga:eventLabel',
                                'filters' => "ga:eventLabel==$eventLabel");
                return $analytics->data_ga->get(
                        'ga:' . $profileId,
                        "$fromDate",
                        "$toDate",
                        'ga:uniqueEvents',
                        $qParams
                );
        }

	 function getVideoWatchCountPerDateAll(&$analytics, $profileId, $fromDate, $toDate) {
         	$qParams = array('dimensions' => 'ga:eventCategory',
                                'filters' => "ga:eventCategory==Video / Seconds played");
                return $analytics->data_ga->get(
                        'ga:' . $profileId,
                        "$fromDate",
                        "$toDate",
                        'ga:totalEvents',
                        $qParams
                );
        }

	function getBlogViewCountPerDateAll(&$analytics, $profileId, $fromDate, $toDate) {
                $qParams = array('dimensions' => 'ga:pagePathLevel1',
                                'filters' => "ga:pagePathLevel1==/blog/");
                return $analytics->data_ga->get(
                        'ga:' . $profileId,
                        "$fromDate",
                        "$toDate",
                        'ga:pageViews',
                        $qParams
                );
        }

	function getBlogViewCountTopSeven(&$analytics, $profileId) {
                $qParams = array('dimensions' => 'ga:pageTitle',
				'max-results' => '7',
				'sort' => '-ga:pageViews',
                                'filters' => "ga:pagePathLevel1==/blog/");
                return $analytics->data_ga->get(
                        'ga:' . $profileId,
                        "6daysAgo",
                        "today",
                        'ga:pageViews',
                        $qParams
                );
        }

	function getVideoWatchCountHourlyAll(&$analytics, $profileId) {
                $qParams = array('dimensions' => 'ga:hour',
                                'filters' => "ga:eventCategory==Video / Seconds played");
                return $analytics->data_ga->get(
                        'ga:' . $profileId,
                        'yesterday',
                        'yesterday',
                        'ga:totalEvents',
                        $qParams
                );
        }

	function getVideoWatchCountExtended(&$analytics, $profileId, $eventLabel) {
                $qParams = array('dimensions' => 'ga:eventLabel',
                                'filters' => "ga:eventLabel==$eventLabel");
                return $analytics->data_ga->get(
                        'ga:' . $profileId,
                        '2008-10-01',
                        'today',
                        'ga:uniqueEvents',
                        $qParams
                );
        }	
	
	function getSearchTerms(&$analytics, $profileId, $timeFrame) {
                $qParams = array('dimensions' => 'ga:keyword');
		if ($timeFrame == 'week') {
			$fromDate = '7daysAgo';
		} elseif ($timeFrame == 'month') {
			$fromDate = '30daysAgo';
		} else {
			$fromDate = 'yesterday';
		}
	
                return $analytics->data_ga->get(
                        'ga:' . $profileId,
                        $fromDate,
                        'today',
                        'ga:organicSearches',
                        $qParams
                );
        }

	function getExternalTrafficPerDateAll(&$analytics, $profileId, $fromDate, $toDate) {
                $qParams = array('dimensions' => 'ga:deviceCategory',
				'filters' => 'ga:medium==referral');
                return $analytics->data_ga->get(
                        'ga:' . $profileId,
                        "$fromDate",
                        "$toDate",
                        'ga:sessions',
                        $qParams
                );
        }

	function getExternalTrafficHourlyAll(&$analytics, $profileId) {
                $qParams = array('dimensions' => 'ga:hour',
                                'filters' => 'ga:medium==referral');
                return $analytics->data_ga->get(
                        'ga:' . $profileId,
                        'yesterday',
                        'yesterday',
                        'ga:sessions',
                        $qParams
                );
        }

	function getExternalTrafficTopReferrers(&$analytics, $profileId, $fromDate, $toDate) {
                $qParams = array('dimensions' => 'ga:source',
				'filters' => 'ga:medium==referral',
				'max-results' => '5',
				'sort' => '-ga:sessions');
                return $analytics->data_ga->get(
                        'ga:' . $profileId,
                        "$fromDate",
                        "$toDate",
                        'ga:sessions',
                        $qParams
                );
        }
	

	function printResults(&$results) {
  		// Parses the response from the Core Reporting API and prints
  		// the profile name and total sessions.
  		if (count($results->getRows()) > 0) {

    			// Get the profile name.
    			$profileName = $results->getProfileInfo()->getProfileName();

    			// Get the entry for the first entry in the first row.
    			$rows = $results->getRows();
    			$sessions = $rows[0][0];
    			// Print the results.
    			//print "First view (profile) found: $profileName\n";
    			//print "Total sessions: $sessions\n";
			return $sessions;
  		} else {
    			//print "No results found.\n";
  		}
	}

//$analytics = getService();
//$profile = getFirstProfileId($analytics);
//$results = getResults($analytics, $profile);
//printResults($results);
}
?>

