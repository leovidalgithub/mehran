<?php
	session_name("PHPSESSID");
	session_start();

	include_once 'dbConnect.php';
	include_once 'class.ads.php';
	include_once 'class.categories.php';

	$data   = array();

	//	Getting All Categories
	$CATEGORIES = new CATEGORIES($DB_connect);
	$allCats = $CATEGORIES->getAllCategories();

	//	Getting All Ads
	$ADS = new ADS($DB_connect);
	$allAds = $ADS->getAllAds();

	$data['cats'] = $allCats;
	$data['ads'] = $allAds;

	echo json_encode($data);
?>
