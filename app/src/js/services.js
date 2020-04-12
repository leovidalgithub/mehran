// API SERVICE
angular
    .module('mhApp')
    .service('phpServices', ['$http', ($http) => {

        return {
            getAllAds : () => {
                return $http.get('built/scripts/service.data.php');
            },
            // getHotels : () => {
            //     return $http.get('built/scripts/getAll.php');
            // },
            
            // setPivot : (hotel) => {
            //     let hotel_plain = 'myData=' + JSON.stringify(hotel);
            //     return $http({
            //         method: 'POST',
            //         url: 'built/scripts/set.php',
            //         data: hotel_plain,
            //         headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            //     });
            // },

            logout : () => {
                return $http.get('built/scripts/sessiondestroy.php');
            }
        }
    }]);
