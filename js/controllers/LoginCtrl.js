"use strict";
myApp.controller('LoginCtrl', ['$scope', '$cookies', '$http', '$location', '$rootScope', function ($scope, $cookies, $http, $location, $rootScope) {

    var sgLogin = {
        login: function(email, password) {
            var data = {'userName':email, 'password': password};
            $http.post('api/v1/users/login.php', data).then(function (res) {
                $cookies.putObject('user', res.data);
                $rootScope.user = res.data;
                $location.path("/");
            });
        }

    };

    $scope.sgLogin = sgLogin;
}]);
