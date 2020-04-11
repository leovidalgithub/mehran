// ANGULAR JS 1.6.9 starts here!
angular
    .module('mhApp', [])
    .config([() => {}]) // not in use
    .run([() => { }]) // not in use

    .controller('mainController', ['$scope', 'phpServices', '$timeout', ($scope, phpServices, $timeout) => {

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
        $scope.username = username;
		// userId -> current user id

        $scope.hotelClicked = function(hotel) { // $SCOPE HOTEL ITEM CLICKED
            if ($scope.admin) { // administrator
                if(!hotel.booked) return;
                
                hotel.approved =!hotel.approved;
            } else { // client
                hotel.booked =!hotel.booked;
                hotel.approved = false;
            }
            $scope.loading = true;
            phpServices.setPivot(hotel)
                .finally(() => { $scope.loading = false });
            };
            
            $scope.userChanged = () => { // $SCOPE OPTION SELECT VALUE CHANGE
                $scope.loading = true;
                settingHotelsObj();
            }
            
            $scope.logout = () => { // $SCOPE LOGOUT
                phpServices.logout()
                .then((data) => {
                    location.replace('login.php');
                });
        }

        const getAll = () =>{ // CALLING API GET-ALL TABLES
            $scope.loading = true;
            phpServices.getHotels()
            .then(loadingDataModels)
            .catch((err) => {if (err.status == 403) {}})
            .finally(() => { $scope.loading = false });
            }
            
        const loadingDataModels = (data) => {
            $scope.hotels  = data.data.hotels; // assigning hotels-datamodel object
            $scope.users   = data.data.users;  // assigning users-datamodel object
            $scope.pivots  = data.data.pivots; // assigning pivot user_hotel-datamodel object
            $scope.userSelected = $scope.users[0]; // selecting first user on users select options
            settingHotelsObj();
        };

        const settingHotelsObj = () => { // GETTING SHAPE $SCOPE-HOTELS DATAMODEL OBJECT
            let currentUserId = $scope.admin == 1 ? $scope.userSelected.id : userId; // getting the currentUserId to show
            $scope.hotels.forEach(hotel => { // reseting hotel booked & approved to false and store current userId
                hotel.booked = false;
                hotel.approved = false;
                hotel.currentUserId = currentUserId;
            });

            let user = $scope.pivots.filter((pivot) => pivot.user_id == currentUserId ); // getting all rows in pivot table for the given user

            user.forEach(pivot => { // setting hotel object according to pivot table info (booked & approved field)
                let hotel = $scope.hotels.find(hotel => hotel.id == pivot.hotel_id);
                hotel.booked = true;
                hotel.approved = pivot.approved == 1 ? true : false;
            });
            $scope.loading = false;            
        }
        
        angular.element(document).ready(() => { // INIT FUNCTION AFTER HTML ALREADY LOADED
            $timeout(()=>{ getAll()},900);
        }); 
    }]);
