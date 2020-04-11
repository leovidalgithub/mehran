"use strict";

// ANGULAR JS 1.6.9 starts here!
angular.module('mhApp', []).config([function () {}]) // not in use
.run([function () {}]) // not in use
.controller('mainController', ['$scope', 'phpServices', '$timeout', function ($scope, phpServices, $timeout) {
  switch (adminType) {
    case '1':
      $scope.loggedAs = 'ADMINISTRATOR';
      break;

    case '2':
      $scope.loggedAs = 'EMPLOYEE';
      break;

    case '5':
      $scope.loggedAs = 'MEMBER';
      break;

    default:
      $scope.loggedAs = 'NOT REGISTERD';
      break;
  }

  $scope.admin = adminType == 1 ? true : false; // setting either admin or client logged

  $scope.username = username; // userId -> current user id

  $scope.hotelClicked = function (hotel) {
    // $SCOPE HOTEL ITEM CLICKED
    if ($scope.admin) {
      // administrator
      if (!hotel.booked) return;
      hotel.approved = !hotel.approved;
    } else {
      // client
      hotel.booked = !hotel.booked;
      hotel.approved = false;
    }

    $scope.loading = true;
    phpServices.setPivot(hotel)["finally"](function () {
      $scope.loading = false;
    });
  };

  $scope.userChanged = function () {
    // $SCOPE OPTION SELECT VALUE CHANGE
    $scope.loading = true;
    settingHotelsObj();
  };

  $scope.logout = function () {
    // $SCOPE LOGOUT
    phpServices.logout().then(function (data) {
      location.replace('login.php');
    });
  };

  var getAll = function getAll() {
    // CALLING API GET-ALL TABLES
    $scope.loading = true;
    phpServices.getHotels().then(loadingDataModels)["catch"](function (err) {
      if (err.status == 403) {}
    })["finally"](function () {
      $scope.loading = false;
    });
  };

  var loadingDataModels = function loadingDataModels(data) {
    $scope.hotels = data.data.hotels; // assigning hotels-datamodel object

    $scope.users = data.data.users; // assigning users-datamodel object

    $scope.pivots = data.data.pivots; // assigning pivot user_hotel-datamodel object

    $scope.userSelected = $scope.users[0]; // selecting first user on users select options

    settingHotelsObj();
  };

  var settingHotelsObj = function settingHotelsObj() {
    // GETTING SHAPE $SCOPE-HOTELS DATAMODEL OBJECT
    var currentUserId = $scope.admin == 1 ? $scope.userSelected.id : userId; // getting the currentUserId to show

    $scope.hotels.forEach(function (hotel) {
      // reseting hotel booked & approved to false and store current userId
      hotel.booked = false;
      hotel.approved = false;
      hotel.currentUserId = currentUserId;
    });
    var user = $scope.pivots.filter(function (pivot) {
      return pivot.user_id == currentUserId;
    }); // getting all rows in pivot table for the given user

    user.forEach(function (pivot) {
      // setting hotel object according to pivot table info (booked & approved field)
      var hotel = $scope.hotels.find(function (hotel) {
        return hotel.id == pivot.hotel_id;
      });
      hotel.booked = true;
      hotel.approved = pivot.approved == 1 ? true : false;
    });
    $scope.loading = false;
  };

  angular.element(document).ready(function () {
    // INIT FUNCTION AFTER HTML ALREADY LOADED
    $timeout(function () {
      getAll();
    }, 900);
  });
}]); // API SERVICE

angular.module('mhApp').service('phpServices', ['$http', function ($http) {
  return {
    getHotels: function getHotels() {
      return $http.get('built/scripts/getAll.php');
    },
    setPivot: function setPivot(hotel) {
      var hotel_plain = 'myData=' + JSON.stringify(hotel);
      return $http({
        method: 'POST',
        url: 'built/scripts/set.php',
        data: hotel_plain,
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        }
      });
    },
    logout: function logout() {
      return $http.get('built/scripts/sessiondestroy.php');
    }
  };
}]);