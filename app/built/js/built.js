"use strict";angular.module("mhApp",[]).config([function(){}]).run([function(){}]).controller("mainController",["$scope","phpServices","$timeout",function(n,t,e){n.admin=1==adminType,n.username=username,n.hotelClicked=function(e){if(n.admin){if(!e.booked)return;e.approved=!e.approved}else e.booked=!e.booked,e.approved=!1;n.loading=!0,t.setPivot(e).finally(function(){n.loading=!1})},n.userChanged=function(){n.loading=!0,i()},n.logout=function(){t.logout().then(function(e){location.replace("login.php")})};var o=function(e){n.hotels=e.data.hotels,n.users=e.data.users,n.pivots=e.data.pivots,n.userSelected=n.users[0],i()},i=function(){var t=1==n.admin?n.userSelected.id:userId;n.hotels.forEach(function(e){e.booked=!1,e.approved=!1,e.currentUserId=t}),n.pivots.filter(function(e){return e.user_id==t}).forEach(function(t){var e=n.hotels.find(function(e){return e.id==t.hotel_id});e.booked=!0,e.approved=1==t.approved}),n.loading=!1};angular.element(document).ready(function(){e(function(){n.loading=!0,t.getHotels().then(o).catch(function(e){e.status}).finally(function(){n.loading=!1})},900)})}]),angular.module("mhApp").service("phpServices",["$http",function(n){return{getHotels:function(){return n.get("built/scripts/getAll.php")},setPivot:function(e){var t="myData="+JSON.stringify(e);return n({method:"POST",url:"built/scripts/set.php",data:t,headers:{"Content-Type":"application/x-www-form-urlencoded"}})},logout:function(){return n.get("built/scripts/sessiondestroy.php")}}}]);