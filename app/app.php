<?php
//phpinfo();
session_name("PHPSESSID");
session_start();

if (!isset($_SESSION['username'])) {
	header("location: login.php");
}
?>
<!doctype html>
<html ng-app="mhApp">

<head>
	<!-- ?v=1.26 no-cache-->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> <!-- initial-scale=.95 -->
	<title>CLASSIFIED ADS</title>

	<link rel="stylesheet" type="text/css" href="./built/css/vendor.css?v=1.26">
	<link rel="stylesheet" type="text/css" href="./built/css/default.css?v=1.26">
</head>

<body ng-controller="mainController">
	<section>
		<div class="navbar-wrapper">
			<div class="container">

				<nav class="navbar navbar-inverse navbar-fixed-top">
					<div class="container">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand" href="#">CLASSIFIED ADS</a>
						</div>
						<div id="navbar" class="navbar-collapse collapse">
							<ul class="nav navbar-nav">
								<p class="loggedAs navbar-text">User {{username}} : &#60;{{loggedAs}}&#62;</p>
								<li class="active"><a href="#">Home</a></li>
								<li><a href="#about">About</a></li>
								<li><a href="#contact">Contact</a></li>
							</ul>
							<ul class="nav navbar-nav navbar-right">
								<p class="loggedAs navbar-text">Categories <span class="glyphicon glyphicon-arrow-right"></span></p>
								<li class="dropdown">

									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{selectedCategory.name}} <span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li ng-repeat="(key, cat) in cats"><a ng-click="dropboxitemselected(cat)">{{cat.name}}</a></li>
									</ul>
								</li>
								<li><a ng-click="logout()"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
							</ul>
						</div>
					</div>
				</nav>

			</div>
		</div>


		<!-- Carousel
    ================================================== -->
		<div id="myCarousel" class="carousel slide" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				<li data-target="#myCarousel" data-slide-to="1"></li>
				<li data-target="#myCarousel" data-slide-to="2"></li>
			</ol>
			<div class="carousel-inner" role="listbox">
				<div class="item active">
					<img class="first-slide" src="images/kim-daniels-ldZRPa-6gQM-unsplash.jpg" alt="First slide">
					<div class="container">
						<div class="carousel-caption">
							<h1>Example headline.</h1>
							<p>Note: If you're viewing this page via a <code>file://</code> URL, the "next" and "previous" Glyphicon buttons on the left and right might not load/display properly due to web browser security rules.</p>
							<p><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p>
						</div>
					</div>
				</div>
				<div class="item">
					<img class="second-slide" src="images/karolina-wv-o4gRWnZLsgI-unsplash.jpg" alt="Second slide">
					<div class="container">
						<div class="carousel-caption">
							<h1>Another example headline.</h1>
							<p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
							<p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
						</div>
					</div>
				</div>
				<div class="item">
					<img class="third-slide" src="images/neven-krcmarek-V4EOZj7g1gw-unsplash.jpg" alt="Third slide">
					<div class="container">
						<div class="carousel-caption">
							<h1>One more for good measure.</h1>
							<p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
							<p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>
						</div>
					</div>
				</div>
			</div>
			<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div><!-- /.carousel -->

		<!-- JUMBOTRON PAID ADS -->
		<div class="container">
			<div class="jumbotron">
				<h2>Classified Ads - Paid Ads</h2>
				<p style="float: left;" class="loggedAs">User : {{username}} &#60;{{loggedAs}}&#62;</p>
				<p style="float: right;" class="displayCat">Displaying Category : {{selectedCategory.name}} ({{filteredPaidAds.length}})</p>
			</div>
		</div>

		<!-- Marketing messaging and featurettes
	================================================== -->
		<!-- Wrap the rest of the page in another container to center all the content. -->

		<div class="container-fluid marketing">
			<!--ng-repeat="(key, ad) in ads | filter : {type_id : selectedCategory.id}"  -->
			<!-- Three columns of text below the carousel -->
			<div class="paidItems">
				<div class="thisPaidAd" ng-repeat="(key, ad) in ads | filter : (selectedCategory.id == 11 ? '' :  {cat_id : selectedCategory.id}) | filter : {isPaid : 1} as filteredPaidAds">
					<img class="img-thumbnail img-responsive" ng-src="images/{{ad.image}}" title="{{ad.name}}" width="160" height="160">
					<h2>{{ad.name}}</h2>
					<p>{{ad.description}}</p>
					<h3>Category : {{ad.cat_name}}</h3>
					<p class="registerDate">{{ad.reigsterDate | date}}</p>
					<p ng-hide="ad.price==0" class="thisPrice">{{ad.price | currency}}</p>
					<p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
				</div>
			</div>
			<div class="container">
				<div ng-hide="filteredPaidAds.length" class="alert alert-danger" role="alert">There is no Paid Ads to show...</div>
			</div>

			<!-- START THE FEATURETTES -->

			<hr class="featurette-divider">
			<!-- JUMBOTRON FREE ADS -->
			<div class="container">
				<div class="jumbotron">
					<h2>Classified Ads - Free Ads</h2>
					<p style="float: left;" class="loggedAs">User : {{username}} &#60;{{loggedAs}}&#62;</p>
					<p style="float: right;" class="displayCat">Displaying Category : {{selectedCategory.name}} ({{filteredFreeAds.length}})</p>
				</div>
			</div>

			<hr class="featurette-divider">
			<div class="container-fluid freeAds">
				<div class="row featurette" ng-repeat="(key, ad) in ads | filter : (selectedCategory.id == '11' ? '' :  {cat_id : selectedCategory.id}) | filter : {isPaid : '0'} as filteredFreeAds">
					<div class="col-md-7" ng-class-even="'col-md-push-5'">
						<h2 class="featurette-heading">{{ad.name}}</h2>
						<p class="lead">{{ad.description}}</p>
						<h3>{{ad.cat_id}}-{{selectedCategory.id}}</h3>
						<h3>Category : {{ad.cat_name}}</h3>
						<p class="registerDate">{{ad.reigsterDate | date}}</p>
						<p ng-hide="ad.price==0" class="thisPrice">{{ad.price | currency}}</p>
						<p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
					</div>
					<div class="col-md-5" ng-class-even="'col-md-pull-7'">
						<img class="featurette-image img-responsive center-block" ng-src="images/{{ad.image}}" alt="Generic placeholder image">
					</div>
					<hr class="featurette-divider">
				</div>
				<div ng-hide="filteredFreeAds.length" class="alert alert-danger" role="alert">There is no free Ads to show...</div>
			</div>

			<hr class="featurette-divider">

			<!-- /END THE FEATURETTES -->


			<!-- FOOTER -->
			<footer>
				<p class="pull-right"><a href="#">Back to top</a></p>
				<p>&copy; 2020 Leo Vidal, Corp. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
			</footer>

		</div><!-- /.container -->
	</section>


	<!-- RETREIVING USER INFO FROM PHP $_SESSION -->
	<script>
		let adminType = "<?php echo $_SESSION['usertype']; ?>";
		//let userId = "<?php //echo $_SESSION['id'];
						?>";
		let username = "<?php echo $_SESSION['username']; ?>";
	</script>

	<!-- LOADING SCRIPTS -->
	<script src="./built/js/vendor.js?v=1.26"></script>
	<script src="./built/js/built.js?v=1.26"></script>

</body>

</html>