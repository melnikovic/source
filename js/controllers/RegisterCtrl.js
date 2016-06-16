"use strict";
myApp.controller('RegisterCtrl', ['$scope', '$cookies', '$http', function ($scope, $cookies, $http) {

    var sgRegister = {
        register: function(email, password) {
            //TODO : ADD userName check in database
            var data = {'userName':email, 'password': password};
            $http.post('api/v1/users/register.php', data).then(function (res) {
                console.log(res.data);
            });
        }

    };

    $scope.sgRegister = sgRegister;
}]);
