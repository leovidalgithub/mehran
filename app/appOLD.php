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
	<!-- ?v=1.25 no-cache-->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> <!-- initial-scale=.95 -->
	<title>CLASSIFIED ADS</title>

	<link rel="stylesheet" type="text/css" href="./built/css/vendor.css?v=1.25">
	<link rel="stylesheet" type="text/css" href="./built/css/default.css?v=1.25">
</head>

<body ng-controller="mainController">

	<section id="app">
		<div class="container animated">

			<!-- JUMBOTRON -->
			<div class="jumbotron">
				<h1>MH Hotels</h1>
				<h3 class="loggedAs" ng-cloak>Logged as: &#60;{{loggedAs}}&#62;</h3>
			</div>
			<!-- PANEL -->
			<div ng-class="{'panel-primary':!admin,'panel-info':admin}" class="panel" ng-cloak>
				<!-- Panel heading -->
				<div class="panel-heading">
					<h3 class="panel-title">{{admin==1 ? 'MH Hotels Admin' : 'Welcome to MH Hotels'}}&#160;&#160;&#160;<span class="none" ng-class="{'loading':loading}"><i class="fa fa-refresh fa-spin" style="font-size:17px"></i></span></h3>
				</div>
				<!-- Panel content -->
				<div class="panel-body">

					<!-- CLIENTS SELECT -->
					<div ng-show="admin" class="row">
						<div class="col-xs-offset-5 col-xs-7 col-sm-offset-6 col-sm-5">
							<div class="form-group">
								<label for="categoriesSelect">My clients</label>
								<div class="input-group">
									<div class="input-group-addon">
										<button ng-init="disablefilter = false" ng-class="{'btn-success' : !disablefilter}" class="btn btn-sm" ng-click="disablefilter = !disablefilter" title="{{disablefilter ? 'To active' : 'desactive'}} filter">
											<i class="glyphicon glyphicon-folder-open"></i>
										</button>
									</div>
									<select class="form-control input-lg" ng-model="userSelected" ng-disabled="disablefilter" id="categoriesSelect" ng-options="item as item.fullname for item in users track by item.id" ng-change="userChanged()" title="{{disablefilter ? 'Filter disabled' : ''}}">
									</select>
								</div>
							</div>
						</div>
					</div>

					<!-- HOTEL ITEMS -->
					<div class="row">
						<div class="well col-xs-12 col-sm-10 col-sm-offset-1">
							<div class="form-group hotel" ng-repeat="(key, hotel) in hotels">
								<div class="row item" ng-click="hotelClicked(hotel)">
									<div class="col-xs-12 col-sm-offset-1 col-sm-10">
										<div class="row">

											<div ng-class="{'hotelBooked':hotel.booked, 'hotelApproved':hotel.approved }" class="col-xs-12">
												<div class="input-group">
													<!-- form-group -->
													<div class="input-group-addon">
														<span ng-show="hotel.booked" class="glyphicon glyphicon-tag"></span>
														<span ng-hide="hotel.booked" class="glyphicon glyphicon-remove"></span>
													</div>
													<input class="form-control input-md" type="text" value="{{ hotel.name }} $CA {{hotel.price}}" title="$CA {{hotel.price}}" readonly />
													<div class="input-group-addon">
														<span ng-show="hotel.approved" class="glyphicon glyphicon-ok"></span>
														<span ng-hide="hotel.approved" class="glyphicon glyphicon-time"></span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Panel footer -->
				<div class="panel-footer">
					<button class="btn btn-md btn-primary" ng-click="logout()">Logout</button>
				</div>
			</div>
		</div>
	</section>

	<!-- RETREIVING USER INFO FROM PHP $_SESSION -->
	<script>
		let adminType = "<?php echo $_SESSION['usertype']; ?>";
		//let userId = "<?php //echo $_SESSION['id']; ?>";
		let username = "<?php echo $_SESSION['username']; ?>";
	</script>

	<!-- LOADING SCRIPTS -->
	<script src="./built/js/vendor.js?v=1.25"></script>
	<script src="./built/js/built.js?v=1.25"></script>

</body>

</html>