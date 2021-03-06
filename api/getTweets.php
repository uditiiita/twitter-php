<?php

namespace Uditiiita;

/**
 * Include the composer autloader, config and Twitter Client
 */
require_once '../vendor/autoload.php';
require_once '../config/config.inc.php';
require_once '../model/TwitterClient.php';

use \Abraham\TwitterOAuth\TwitterOAuth;
$twitterOAuth = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_ACCESS_TOKEN, OAUTH_ACCESS_TOKEN_SECRET);

$twitterClient = new TwitterClient($twitterOAuth);

$beforeId = NULL;
if (isset($_REQUEST['beforeId'])) {
    $beforeId = $_REQUEST['beforeId'];
}

$tweets = $twitterClient->getTweetsWithHashTagAndMinimumOneRetweet("#custserv", $beforeId);

header('Content-Type: application/json');
echo json_encode($tweets);
